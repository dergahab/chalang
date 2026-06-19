<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PerformanceController extends Controller
{
    /**
     * Display performance dashboard
     */
    public function index()
    {
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));

        // Get today's aggregated metrics
        $todayMetrics = Cache::get('performance_aggregated_' . $today, $this->getEmptyMetrics());
        $yesterdayMetrics = Cache::get('performance_aggregated_' . $yesterday, $this->getEmptyMetrics());

        // Get real-time metrics for the last hour
        $currentHour = date('Y-m-d-H');
        $hourlyMetrics = Cache::get('performance_metrics_' . $currentHour, []);

        // Calculate performance insights
        $insights = $this->calculateInsights($todayMetrics, $yesterdayMetrics);

        // Get top slow routes
        $slowRoutes = $this->getSlowRoutes($todayMetrics);

        // Get status code distribution
        $statusCodes = $todayMetrics['status_codes'] ?? [];

        return view('admin.pages.performance.index', compact(
            'todayMetrics',
            'yesterdayMetrics',
            'hourlyMetrics',
            'insights',
            'slowRoutes',
            'statusCodes'
        ));
    }

    /**
     * Get performance metrics API
     */
    public function metrics(Request $request)
    {
        $period = $request->get('period', 'today');
        $metrics = [];

        switch ($period) {
            case 'today':
                $date = date('Y-m-d');
                $metrics = Cache::get('performance_aggregated_' . $date, $this->getEmptyMetrics());
                break;
            case 'yesterday':
                $date = date('Y-m-d', strtotime('-1 day'));
                $metrics = Cache::get('performance_aggregated_' . $date, $this->getEmptyMetrics());
                break;
            case 'week':
                $metrics = $this->getWeeklyMetrics();
                break;
            case 'month':
                $metrics = $this->getMonthlyMetrics();
                break;
        }

        return response()->json($metrics);
    }

    /**
     * Get real-time performance data
     */
    public function realtime()
    {
        $currentHour = date('Y-m-d-H');
        $metrics = Cache::get('performance_metrics_' . $currentHour, []);

        // Get last 50 requests for real-time view
        $recentRequests = array_slice(array_reverse($metrics), 0, 50);

        return response()->json([
            'recent_requests' => $recentRequests,
            'total_this_hour' => count($metrics),
            'timestamp' => now()->toISOString()
        ]);
    }

    /**
     * Clear performance cache
     */
    public function clearCache()
    {
        $keys = Cache::store('redis')->getStore()->keys('performance_*');
        foreach ($keys as $key) {
            Cache::forget(str_replace('performance_', '', $key));
        }

        return redirect()->back()->with('success', 'Performance cache cleared successfully');
    }

    /**
     * Get empty metrics structure
     */
    private function getEmptyMetrics(): array
    {
        return [
            'total_requests' => 0,
            'avg_duration' => 0,
            'max_duration' => 0,
            'total_memory' => 0,
            'status_codes' => [],
            'slow_requests' => 0,
            'routes' => []
        ];
    }

    /**
     * Calculate performance insights
     */
    private function calculateInsights(array $today, array $yesterday): array
    {
        $insights = [];

        // Compare request counts
        if ($yesterday['total_requests'] > 0) {
            $requestChange = (($today['total_requests'] - $yesterday['total_requests']) / $yesterday['total_requests']) * 100;
            $insights['requests'] = [
                'change' => round($requestChange, 1),
                'trend' => $requestChange > 0 ? 'up' : 'down'
            ];
        }

        // Compare average response time
        if ($yesterday['avg_duration'] > 0) {
            $durationChange = (($today['avg_duration'] - $yesterday['avg_duration']) / $yesterday['avg_duration']) * 100;
            $insights['duration'] = [
                'change' => round($durationChange, 1),
                'trend' => $durationChange > 0 ? 'worse' : 'better'
            ];
        }

        // Calculate error rate
        $totalRequests = $today['total_requests'];
        $errorRequests = 0;
        foreach ($today['status_codes'] as $code => $count) {
            if ($code >= 400) {
                $errorRequests += $count;
            }
        }
        $insights['error_rate'] = $totalRequests > 0 ? round(($errorRequests / $totalRequests) * 100, 2) : 0;

        // Calculate slow request percentage
        $insights['slow_percentage'] = $totalRequests > 0 ? round(($today['slow_requests'] / $totalRequests) * 100, 2) : 0;

        return $insights;
    }

    /**
     * Get top slow routes
     */
    private function getSlowRoutes(array $metrics): array
    {
        $routes = $metrics['routes'] ?? [];
        $slowRoutes = [];

        foreach ($routes as $route => $data) {
            if ($data['avg_duration'] > 500) { // Routes with avg > 500ms
                $slowRoutes[] = [
                    'route' => $route,
                    'avg_duration' => round($data['avg_duration'], 2),
                    'max_duration' => round($data['max_duration'], 2),
                    'count' => $data['count']
                ];
            }
        }

        // Sort by average duration descending
        usort($slowRoutes, function($a, $b) {
            return $b['avg_duration'] <=> $a['avg_duration'];
        });

        return array_slice($slowRoutes, 0, 10); // Top 10
    }

    /**
     * Get weekly metrics
     */
    private function getWeeklyMetrics(): array
    {
        $weekly = $this->getEmptyMetrics();

        for ($i = 0; $i < 7; $i++) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $dayMetrics = Cache::get('performance_aggregated_' . $date, $this->getEmptyMetrics());

            $weekly['total_requests'] += $dayMetrics['total_requests'];
            $weekly['total_memory'] += $dayMetrics['total_memory'];
            $weekly['slow_requests'] += $dayMetrics['slow_requests'];

            // Merge status codes
            foreach ($dayMetrics['status_codes'] as $code => $count) {
                $weekly['status_codes'][$code] = ($weekly['status_codes'][$code] ?? 0) + $count;
            }

            // Track max values
            $weekly['max_duration'] = max($weekly['max_duration'], $dayMetrics['max_duration']);
        }

        // Calculate average duration
        if ($weekly['total_requests'] > 0) {
            $totalDuration = 0;
            for ($i = 0; $i < 7; $i++) {
                $date = date('Y-m-d', strtotime("-{$i} days"));
                $dayMetrics = Cache::get('performance_aggregated_' . $date, $this->getEmptyMetrics());
                $totalDuration += $dayMetrics['avg_duration'] * $dayMetrics['total_requests'];
            }
            $weekly['avg_duration'] = $totalDuration / $weekly['total_requests'];
        }

        return $weekly;
    }

    /**
     * Get monthly metrics
     */
    private function getMonthlyMetrics(): array
    {
        $monthly = $this->getEmptyMetrics();

        for ($i = 0; $i < 30; $i++) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $dayMetrics = Cache::get('performance_aggregated_' . $date, $this->getEmptyMetrics());

            $monthly['total_requests'] += $dayMetrics['total_requests'];
            $monthly['total_memory'] += $dayMetrics['total_memory'];
            $monthly['slow_requests'] += $dayMetrics['slow_requests'];

            // Merge status codes
            foreach ($dayMetrics['status_codes'] as $code => $count) {
                $monthly['status_codes'][$code] = ($monthly['status_codes'][$code] ?? 0) + $count;
            }

            // Track max values
            $monthly['max_duration'] = max($monthly['max_duration'], $dayMetrics['max_duration']);
        }

        // Calculate average duration
        if ($monthly['total_requests'] > 0) {
            $totalDuration = 0;
            for ($i = 0; $i < 30; $i++) {
                $date = date('Y-m-d', strtotime("-{$i} days"));
                $dayMetrics = Cache::get('performance_aggregated_' . $date, $this->getEmptyMetrics());
                $totalDuration += $dayMetrics['avg_duration'] * $dayMetrics['total_requests'];
            }
            $monthly['avg_duration'] = $totalDuration / $monthly['total_requests'];
        }

        return $monthly;
    }
}
