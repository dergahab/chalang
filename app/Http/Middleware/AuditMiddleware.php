<?php

namespace App\Http\Middleware;

use App\Services\AuditService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuditMiddleware
{
    /**
     * Routes to exclude from audit logging
     */
    protected array $excludedPatterns = [
        '/api/health',
        '/api/ping',
        '/api/heartbeat',
        '/api/import-progress/*',
        '/api/analytics/*',
        '/telescope/*',
        '/horizon/*',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip if excluded
        if ($this->shouldSkip($request)) {
            return $next($request);
        }

        $startTime = microtime(true);

        $response = $next($request);

        // Calculate duration
        $durationMs = (int)((microtime(true) - $startTime) * 1000);

        // Log the request
        $this->logRequest($request, $response, $durationMs);

        return $response;
    }

    /**
     * Check if request should be skipped
     */
    protected function shouldSkip(Request $request): bool
    {
        // Skip non-HTML/API responses for performance
        if (!$request->expectsJson() && !$request->is('api/*')) {
            return true;
        }

        // Skip excluded patterns
        foreach ($this->excludedPatterns as $pattern) {
            if ($request->is($pattern)) {
                return true;
            }
        }

        // Skip safe methods
        if (in_array($request->method(), ['GET', 'HEAD', 'OPTIONS'])) {
            return true;
        }

        return false;
    }

    /**
     * Log the request
     */
    protected function logRequest(Request $request, Response $response, int $durationMs): void
    {
        try {
            $route = $request->route();
            $routeName = $route?->getName();
            $action = $request->route()?->getActionName();

            // Get entity info from route
            $entityType = null;
            $entityId = null;

            // Try to extract entity from route parameters
            if ($route) {
                $params = $route->parameters();
                foreach ($params as $key => $value) {
                    if (is_numeric($value)) {
                        $entityId = $value;
                        $entityType = $this->inferEntityType($routeName ?? '');
                        break;
                    }
                }
            }

            // Determine action type
            $actionType = match ($request->method()) {
                'POST' => $routeName && str_contains($routeName, 'store') ? 'create' : 'bulk_create',
                'PUT', 'PATCH' => 'update',
                'DELETE' => 'delete',
                default => 'unknown',
            };

            // Skip if no meaningful action
            if ($actionType === 'unknown') {
                return;
            }

            // Determine status
            $status = $response->getStatusCode() < 400 ? 'success' : 'failed';

            AuditService::log(
                $actionType,
                $entityType,
                $entityId,
                [
                    'method' => $request->method(),
                    'route' => $routeName,
                    'duration_ms' => $durationMs,
                    'status' => $status,
                    'metadata' => [
                        'status_code' => $response->getStatusCode(),
                        'url' => $request->fullUrl(),
                    ],
                ]
            );
        } catch (\Exception $e) {
            // Silent fail - don't break the app
        }
    }

    /**
     * Infer entity type from route name
     */
    protected function inferEntityType(string $routeName): ?string
    {
        $map = [
            'admin.service' => 'App\\Models\\Service',
            'admin.blog' => 'App\\Models\\Blog',
            'admin.portfolio' => 'App\\Models\\Portfolio',
            'admin.user' => 'App\\Models\\User',
            'admin.role' => 'App\\Models\\Role',
            'admin.tag' => 'App\\Models\\Tag',
            'admin.testimonial' => 'App\\Models\\Testimonial',
            'admin.partner' => 'App\\Models\\Partner',
            'admin.pricing-plan' => 'App\\Models\\PricingPlan',
            'admin.faq' => 'App\\Models\\Faq',
            'admin.banner' => 'App\\Models\\Banner',
            'admin.experiment' => 'App\\Models\\Experiment',
            'admin.import' => null,
            'admin.export' => null,
        ];

        foreach ($map as $prefix => $entity) {
            if (str_starts_with($routeName, $prefix)) {
                return $entity;
            }
        }

        return null;
    }
}