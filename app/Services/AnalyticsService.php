<?php

namespace App\Services;

use App\Models\AnalyticsEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AnalyticsService
{
    /**
     * Track a page view event
     */
    public function trackPageView(Request $request, string $pageTitle = null): void
    {
        $this->trackEvent('page_view', 'page_view', [
            'page_url' => $request->fullUrl(),
            'page_title' => $pageTitle ?: $request->path(),
        ], $request);
    }

    /**
     * Track a click event
     */
    public function trackClick(Request $request, string $element, array $additionalData = []): void
    {
        $this->trackEvent('click', 'click', array_merge([
            'element' => $element,
            'page_url' => $request->fullUrl(),
        ], $additionalData), $request);
    }

    /**
     * Track a conversion event
     */
    public function trackConversion(Request $request, string $conversionType, float $value = null, array $additionalData = []): void
    {
        $this->trackEvent('conversion', $conversionType, array_merge([
            'conversion_value' => $value,
            'page_url' => $request->fullUrl(),
        ], $additionalData), $request, $value);
    }

    /**
     * Track a custom event
     */
    public function trackCustomEvent(Request $request, string $eventName, array $eventData = []): void
    {
        $this->trackEvent('custom', $eventName, array_merge([
            'page_url' => $request->fullUrl(),
        ], $eventData), $request);
    }

    /**
     * Generic event tracking method
     */
    private function trackEvent(string $eventType, string $eventName, array $eventData, Request $request, float $conversionValue = null): void
    {
        try {
            // Get user info
            $userId = auth()->id();
            $sessionId = $this->getSessionId($request);

            // Parse user agent for device info
            $userAgent = $request->userAgent();
            $deviceInfo = $this->parseUserAgent($userAgent);

            // Get experiment context if available
            $experimentData = $this->getExperimentContext($request);

            // GDPR: Anonymize IP address
            $ipAddress = $request->ip();
            if ($ipAddress) {
                $parts = explode('.', $ipAddress);
                if (count($parts) === 4) {
                    $ipAddress = $parts[0] . '.' . $parts[1] . '.' . $parts[2] . '.0';
                }
            }

            AnalyticsEvent::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'event_type' => $eventType,
                'event_name' => $eventName,
                'event_data' => $eventData,
                'page_url' => $eventData['page_url'] ?? $request->fullUrl(),
                'page_title' => $eventData['page_title'] ?? null,
                'user_agent' => $userAgent,
                'ip_address' => $ipAddress,
                'referrer' => $request->header('referer'),
                'device_type' => $deviceInfo['device_type'],
                'browser' => $deviceInfo['browser'],
                'os' => $deviceInfo['os'],
                'experiment_id' => $experimentData['experiment_id'] ?? null,
                'experiment_variant' => $experimentData['variant'] ?? null,
                'conversion_value' => $conversionValue,
                'timestamp' => now(),
            ]);

            // Update real-time cache
            $this->updateRealtimeCache($eventType);

        } catch (\Exception $e) {
            Log::error('Analytics tracking failed', [
                'error' => $e->getMessage(),
                'event_type' => $eventType,
                'event_name' => $eventName
            ]);
        }
    }

    /**
     * Get or create session ID
     */
    private function getSessionId(Request $request): string
    {
        $sessionId = $request->cookie('analytics_session');

        if (!$sessionId) {
            $sessionId = Str::uuid()->toString();
            // Note: Cookie will be set by frontend JavaScript
        }

        return $sessionId;
    }

    /**
     * Parse user agent string for device info
     */
    private function parseUserAgent(?string $userAgent): array
    {
        if (!$userAgent) {
            return [
                'device_type' => 'unknown',
                'browser' => 'unknown',
                'os' => 'unknown'
            ];
        }

        // Simple user agent parsing (in production, consider using a library like DeviceDetector)
        $deviceType = 'desktop';
        if (stripos($userAgent, 'mobile') !== false || stripos($userAgent, 'android') !== false || stripos($userAgent, 'iphone') !== false) {
            $deviceType = 'mobile';
        } elseif (stripos($userAgent, 'tablet') !== false || stripos($userAgent, 'ipad') !== false) {
            $deviceType = 'tablet';
        }

        // Extract browser
        $browser = 'unknown';
        if (stripos($userAgent, 'chrome') !== false) {
            $browser = 'chrome';
        } elseif (stripos($userAgent, 'firefox') !== false) {
            $browser = 'firefox';
        } elseif (stripos($userAgent, 'safari') !== false) {
            $browser = 'safari';
        } elseif (stripos($userAgent, 'edge') !== false) {
            $browser = 'edge';
        }

        // Extract OS
        $os = 'unknown';
        if (stripos($userAgent, 'windows') !== false) {
            $os = 'windows';
        } elseif (stripos($userAgent, 'mac os') !== false || stripos($userAgent, 'macos') !== false) {
            $os = 'macos';
        } elseif (stripos($userAgent, 'linux') !== false) {
            $os = 'linux';
        } elseif (stripos($userAgent, 'android') !== false) {
            $os = 'android';
        } elseif (stripos($userAgent, 'ios') !== false || stripos($userAgent, 'iphone') !== false) {
            $os = 'ios';
        }

        return [
            'device_type' => $deviceType,
            'browser' => $browser,
            'os' => $os
        ];
    }

    /**
     * Get experiment context from session/cache
     */
    private function getExperimentContext(Request $request): array
    {
        // This would be populated by the HandleExperiments middleware
        return session('experiment_context', []);
    }

    /**
     * Update real-time analytics cache
     */
    private function updateRealtimeCache(string $eventType): void
    {
        $cacheKey = 'analytics_realtime_' . date('Y-m-d-H-i');
        $current = Cache::get($cacheKey, [
            'page_views' => 0,
            'clicks' => 0,
            'conversions' => 0,
            'total_events' => 0
        ]);

        $current['total_events']++;
        $current[$eventType . 's'] = ($current[$eventType . 's'] ?? 0) + 1;

        Cache::put($cacheKey, $current, now()->addMinutes(5));
    }

    /**
     * Get analytics summary for dashboard
     */
    public function getAnalyticsSummary(int $days = 30): array
    {
        $startDate = now()->subDays($days);

        $summary = AnalyticsEvent::where('timestamp', '>=', $startDate)
            ->selectRaw('
                COUNT(CASE WHEN event_type = "page_view" THEN 1 END) as page_views,
                COUNT(CASE WHEN event_type = "click" THEN 1 END) as clicks,
                COUNT(CASE WHEN event_type = "conversion" THEN 1 END) as conversions,
                COUNT(DISTINCT session_id) as unique_sessions,
                COUNT(DISTINCT user_id) as unique_users,
                AVG(CASE WHEN event_type = "conversion" THEN conversion_value END) as avg_conversion_value,
                SUM(CASE WHEN event_type = "conversion" THEN conversion_value END) as total_conversion_value
            ')
            ->first();

        return [
            'period_days' => $days,
            'page_views' => $summary->page_views ?? 0,
            'clicks' => $summary->clicks ?? 0,
            'conversions' => $summary->conversions ?? 0,
            'unique_sessions' => $summary->unique_sessions ?? 0,
            'unique_users' => $summary->unique_users ?? 0,
            'conversion_rate' => $summary->page_views > 0 ? round(($summary->conversions / $summary->page_views) * 100, 2) : 0,
            'avg_conversion_value' => round($summary->avg_conversion_value ?? 0, 2),
            'total_conversion_value' => round($summary->total_conversion_value ?? 0, 2),
        ];
    }

    /**
     * Get top performing pages
     */
    public function getTopPages(int $days = 30, int $limit = 10): array
    {
        return AnalyticsEvent::getTopPages($days)->toArray();
    }

    /**
     * Get conversion funnel data
     */
    public function getConversionFunnel(int $experimentId = null, int $days = 30): array
    {
        $funnel = AnalyticsEvent::getConversionFunnel($experimentId, $days);

        return [
            'page_views' => $funnel->page_views ?? 0,
            'clicks' => $funnel->clicks ?? 0,
            'conversions' => $funnel->conversions ?? 0,
            'click_through_rate' => $funnel->page_views > 0 ? round(($funnel->clicks / $funnel->page_views) * 100, 2) : 0,
            'conversion_rate' => $funnel->clicks > 0 ? round(($funnel->conversions / $funnel->clicks) * 100, 2) : 0,
            'avg_conversion_value' => round($funnel->avg_conversion_value ?? 0, 2),
        ];
    }

    /**
     * Get real-time analytics data
     */
    public function getRealtimeAnalytics(): array
    {
        $cacheKey = 'analytics_realtime_' . date('Y-m-d-H-i');
        return Cache::get($cacheKey, [
            'page_views' => 0,
            'clicks' => 0,
            'conversions' => 0,
            'total_events' => 0
        ]);
    }

    /**
     * Get device and browser breakdown
     */
    public function getDeviceBreakdown(int $days = 30): array
    {
        $startDate = now()->subDays($days);

        $breakdown = AnalyticsEvent::where('timestamp', '>=', $startDate)
            ->selectRaw('
                device_type,
                browser,
                os,
                COUNT(*) as count
            ')
            ->groupBy('device_type', 'browser', 'os')
            ->orderBy('count', 'desc')
            ->get();

        return $breakdown->groupBy('device_type')->map(function ($devices) {
            return $devices->pluck('count', 'browser');
        })->toArray();
    }
}