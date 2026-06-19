<?php

namespace App\Http\Middleware;

use App\Services\ExperimentService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class HandleExperiments
{
    protected ExperimentService $experimentService;

    public function __construct(ExperimentService $experimentService)
    {
        $this->experimentService = $experimentService;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get or create session ID for experiment tracking
        $sessionId = $this->getSessionId($request);

        // Build context for experiment targeting
        $context = $this->buildContext($request);

        // Get active experiments
        $activeExperiments = $this->experimentService->getActiveExperiments($context);

        // Optimization: Eager load all experiment models at once instead of find() inside loop
        $experimentIds = array_column($activeExperiments, 'id');
        $experimentModels = \App\Models\Experiment::whereIn('id', $experimentIds)->with('variants')->get()->keyBy('id');

        // Store experiment assignments in request for later use
        $assignments = [];
        foreach ($activeExperiments as $expData) {
            $experiment = $experimentModels->get($expData['id']);
            if (!$experiment) continue;

            $variant = $this->experimentService->assignVariant(
                $experiment,
                $sessionId,
                $context
            );

            if ($variant) {
                $assignments[$expData['key']] = $variant;

                // Track page view if this is a page-type experiment
                if ($expData['type'] === 'page') {
                    $variant->trackEvent('view', $sessionId, [
                        'page_url' => $request->fullUrl(),
                        'user_agent' => $request->userAgent(),
                    ], $context['user_id'] ?? null);
                }
            }
        }


        // Add experiment data to request
        $request->merge([
            'experiment_session_id' => $sessionId,
            'experiment_assignments' => $assignments,
            'experiment_context' => $context,
        ]);

        $response = $next($request);

        // Set experiment cookie if not already set
        if (!$request->hasCookie('experiment_session')) {
            $response->cookie('experiment_session', $sessionId, 60 * 24 * 30); // 30 days
        }

        return $response;
    }

    /**
     * Get or create session ID for experiment tracking
     */
    protected function getSessionId(Request $request): string
    {
        // Try to get from cookie first
        $sessionId = $request->cookie('experiment_session');

        if (!$sessionId) {
            // Generate new session ID
            $sessionId = 'exp_' . \Illuminate\Support\Str::random(32);
        }

        return $sessionId;
    }

    /**
     * Build context for experiment targeting
     */
    protected function buildContext(Request $request): array
    {
        $context = [
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'path' => $request->path(),
            'method' => $request->method(),
            'referer' => $request->header('referer'),
        ];

        // Add user role if authenticated
        if (auth()->check()) {
            $context['user_role'] = auth()->user()->roles->pluck('name')->first();
        }

        // Detect device type
        $context['device_type'] = $this->detectDeviceType($request);

        // Detect country using GeoService
        $location = \App\Services\GeoService::detectLocation($request->ip());
        $context['country'] = $location['country_code'];
        $context['country_name'] = $location['country'];
        $context['city'] = $location['city'];

        return $context;
    }

    /**
     * Detect device type from user agent
     */
    protected function detectDeviceType(Request $request): string
    {
        $userAgent = $request->userAgent();

        if (preg_match('/mobile|android|iphone|ipad|ipod/i', $userAgent)) {
            return 'mobile';
        } elseif (preg_match('/tablet|ipad/i', $userAgent)) {
            return 'tablet';
        } else {
            return 'desktop';
        }
    }

    /**
     * Detect country from IP (simplified - you might want to use a proper geoip service)
     */
    protected function detectCountry(Request $request): ?string
    {
        // This is a simplified implementation
        // In production, you'd use a service like MaxMind GeoIP
        $ip = $request->ip();

        // For local development
        if ($ip === '127.0.0.1' || $ip === '::1') {
            return 'local';
        }

        // You could integrate with a geoip service here
        // For now, return null
        return null;
    }
}
