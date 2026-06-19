<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UserRateLimitMiddleware
{
    /**
     * Default limits per user role
     */
    protected array $roleLimits = [
        'super-admin' => 1000,    // 1000 requests/minute
        'admin' => 500,        // 500 requests/minute
        'editor' => 200,       // 200 requests/minute
        'author' => 100,       // 100 requests/minute
        'user' => 50,        // 50 requests/minute
        'guest' => 30,        // 30 requests/minute
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ?int $maxRequests = null, ?int $decayMinutes = 1): Response
    {
        // Skip non-API routes
        if (!$request->is('api/*')) {
            return $next($request);
        }

        // Get user identifier
        $identifier = $this->getIdentifier($request);

        // Get rate limit for user
        $limit = $maxRequests ?? $this->getUserLimit($request);

        // Get cache key
        $key = "rate_limit_{$identifier}";

        // Get current count
        $current = Cache::get($key, 0);

        // Check if over limit
        if ($current >= $limit) {
            $retryAfter = Cache::ttl($key) ?? 60;

            Log::warning("Rate limit exceeded for {$identifier}", [
                'identifier' => $identifier,
                'limit' => $limit,
                'current' => $current,
                'url' => $request->fullUrl(),
            ]);

            return response()->json([
                'error' => 'Too Many Requests',
                'message' => 'Rate limit exceeded. Please try again later.',
                'limit' => $limit,
                'remaining' => 0,
                'retry_after' => $retryAfter,
            ], 429)->withHeaders([
                'X-RateLimit-Limit' => $limit,
                'X-RateLimit-Remaining' => 0,
                'X-RateLimit-Reset' => now()->addSeconds($retryAfter)->timestamp,
                'Retry-After' => $retryAfter,
            ]);
        }

        // Increment counter
        Cache::put($key, $current + 1, 60);

        $response = $next($request);

        // Add rate limit headers
        $response->headers->set('X-RateLimit-Limit', $limit);
        $response->headers->set('X-RateLimit-Remaining', max(0, $limit - $current - 1));
        $response->headers->set('X-RateLimit-Reset', now()->addMinutes($decayMinutes ?? 1)->timestamp);

        return $response;
    }

    /**
     * Get user identifier (user ID or IP)
     */
    protected function getIdentifier(Request $request): string
    {
        // If authenticated, use user ID
        if (auth()->check()) {
            return 'user_' . auth()->id();
        }

        // Otherwise use IP
        return 'ip_' . ($request->ip() ?: 'unknown');
    }

    /**
     * Get rate limit for user
     */
    protected function getUserLimit(Request $request): int
    {
        // Default for guests
        if (!auth()->check()) {
            return $this->roleLimits['guest'] ?? 30;
        }

        // Get user's highest role
        $role = auth()->user()->roles->pluck('name')->first();

        return $this->roleLimits[$role] ?? $this->roleLimits['user'] ?? 50;
    }
}