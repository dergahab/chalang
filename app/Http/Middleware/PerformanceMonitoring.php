<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PerformanceMonitoring
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        // Track request start
        $this->logRequestStart($request);

        $response = $next($request);

        $endTime = microtime(true);
        $endMemory = memory_get_usage();

        $duration = ($endTime - $startTime) * 1000; // Convert to milliseconds
        $memoryUsage = $endMemory - $startMemory;

        // Log performance metrics
        $this->logPerformanceMetrics($request, $response, $duration, $memoryUsage);

        // Store metrics for analytics
        $this->storePerformanceMetrics($request, $duration, $memoryUsage, $response->getStatusCode());

        // Add performance headers to response
        $response->headers->set('X-Response-Time', round($duration, 2) . 'ms');
        $response->headers->set('X-Memory-Usage', $this->formatBytes($memoryUsage));

        return $response;
    }

    /**
     * Log request start for debugging
     */
    private function logRequestStart(Request $request): void
    {
        if (config('app.debug')) {
            Log::info('Request started', [
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now()->toISOString()
            ]);
        }
    }

    /**
     * URLs excluded from slow request Telegram alerts.
     * These are internal monitoring endpoints that naturally take longer
     * (e.g., they ping external APIs like Telegram).
     */
    private array $excludedFromAlerts = [
        'telegram-health',
        'telegram/webhook',
        'horizon',
        'telescope',
        '_debugbar',
        'notifications/latest', // Added to prevent AJAX polling spam
        'telegram-integration', // Exclude telegram panel actions (like test-message)
    ];

    /**
     * Log performance metrics
     */
    private function logPerformanceMetrics(Request $request, Response $response, float $duration, int $memoryUsage): void
    {
        $statusCode = $response->getStatusCode();
        
        // --- SMART ALERTS (Anomaly Detection) ---
        if (!$this->isExcludedFromAlerts($request)) {
            // 1. RAM Anomaly (> 100MB per request)
            if ($memoryUsage > 100 * 1024 * 1024) {
                try {
                    app(\App\Services\TelegramService::class)->sendToAdmin(
                        "<b>⚠️ Yaddaş (RAM) Anomaliyası!</b>\n\n" .
                        "<b>URL:</b> <code>" . $request->fullUrl() . "</code>\n" .
                        "<b>İstifadə:</b> <code>" . $this->formatBytes($memoryUsage) . "</code>"
                    );
                } catch (\Exception $e) {}
            }

            // 2. Server Errors (5xx)
            if ($statusCode >= 500) {
                try {
                    app(\App\Services\TelegramService::class)->sendToAdmin(
                        "<b>🚨 Server Xətası (HTTP {$statusCode})</b>\n\n" .
                        "<b>URL:</b> <code>" . $request->fullUrl() . "</code>\n" .
                        "<b>Metod:</b> <code>" . $request->method() . "</code>\n" .
                        "<b>IP:</b> <code>" . $request->ip() . "</code>"
                    );
                } catch (\Exception $e) {}
            }
        }

        // Only log slow requests in production, or all in debug
        if ($duration > 500 || config('app.debug')) {
            $logData = [
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'status' => $statusCode,
                'duration_ms' => round($duration, 2),
                'memory_usage' => $this->formatBytes($memoryUsage),
                'timestamp' => now()->toISOString()
            ];

            if ($duration > 2000) {
                Log::error('Very slow request detected', $logData);
                
                // Notify via Telegram ONLY if not an excluded internal route
                if (!$this->isExcludedFromAlerts($request)) {
                    try {
                        app(\App\Services\TelegramService::class)->notifySlowRequest(
                            $request->fullUrl(),
                            round($duration, 2)
                        );
                    } catch (\Exception $e) {}
                }
            } elseif ($duration > 500) {
                Log::warning('Slow request detected', $logData);
            } else {
                Log::debug('Request completed', $logData);
            }
        }
    }

    /**
     * Check if the request URL matches any excluded pattern.
     */
    private function isExcludedFromAlerts(Request $request): bool
    {
        $url = $request->fullUrl();
        foreach ($this->excludedFromAlerts as $pattern) {
            if (str_contains($url, $pattern)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Store performance metrics for analytics
     */
    private function storePerformanceMetrics(Request $request, float $duration, int $memoryUsage, int $statusCode): void
    {
        $route = $request->route();
        $routeName = $route ? $route->getName() : 'unknown';
        $hourKey = date('Y-m-d-H');

        // Store aggregated hourly metrics using atomic increments where possible
        // To avoid massive arrays in cache, we store summary data
        $summaryKey = 'perf_summary_' . $hourKey;
        $summary = Cache::get($summaryKey, [
            'count' => 0,
            'total_duration' => 0,
            'total_memory' => 0,
            'errors' => 0
        ]);

        $summary['count']++;
        $summary['total_duration'] += $duration;
        $summary['total_memory'] += $memoryUsage;
        if ($statusCode >= 400) {
            $summary['errors']++;
        }

        Cache::put($summaryKey, $summary, now()->addHours(48));

        // Store aggregated metrics for dashboard
        $this->updateAggregatedMetrics([
            'route' => $routeName,
            'duration' => $duration,
            'memory_usage' => $memoryUsage,
            'status_code' => $statusCode
        ]);
    }

    /**
     * Update aggregated performance metrics
     */
    private function updateAggregatedMetrics(array $metrics): void
    {
        $aggKey = 'performance_aggregated_' . date('Y-m-d');

        // Note: In high traffic, this should ideally be handled via Redis or a DB
        // Using a lock to prevent race conditions during the aggregate update
        Cache::lock($aggKey . '_lock', 10)->get(function () use ($aggKey, $metrics) {
            $aggregated = Cache::get($aggKey, [
                'total_requests' => 0,
                'avg_duration' => 0,
                'max_duration' => 0,
                'total_memory' => 0,
                'status_codes' => [],
                'slow_requests' => 0,
                'routes' => []
            ]);

            $aggregated['total_requests']++;
            $aggregated['avg_duration'] = (($aggregated['avg_duration'] * ($aggregated['total_requests'] - 1)) + $metrics['duration']) / $aggregated['total_requests'];
            $aggregated['max_duration'] = max($aggregated['max_duration'], $metrics['duration']);
            $aggregated['total_memory'] += $metrics['memory_usage'];

            $status = $metrics['status_code'];
            $aggregated['status_codes'][$status] = ($aggregated['status_codes'][$status] ?? 0) + 1;

            if ($metrics['duration'] > 500) {
                $aggregated['slow_requests']++;
            }

            $route = $metrics['route'];
            if (!isset($aggregated['routes'][$route])) {
                $aggregated['routes'][$route] = [
                    'count' => 0,
                    'total_duration' => 0,
                    'avg_duration' => 0,
                    'max_duration' => 0
                ];
            }
            
            // Limit route tracking to top 50 to prevent cache bloat
            if (count($aggregated['routes']) < 50 || isset($aggregated['routes'][$route])) {
                $aggregated['routes'][$route]['count']++;
                $aggregated['routes'][$route]['total_duration'] += $metrics['duration'];
                $aggregated['routes'][$route]['avg_duration'] = $aggregated['routes'][$route]['total_duration'] / $aggregated['routes'][$route]['count'];
                $aggregated['routes'][$route]['max_duration'] = max($aggregated['routes'][$route]['max_duration'], $metrics['duration']);
            }

            Cache::put($aggKey, $aggregated, now()->addDays(7));
        });
    }


    /**
     * Format bytes to human readable format
     */
    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
