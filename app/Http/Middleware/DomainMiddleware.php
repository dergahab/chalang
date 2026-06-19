<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DomainMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        
        // Domain configs
        $domains = [
            'chalang.az' => 'az',
            'chalang.ai' => 'en',
            // Default: chalanggroup.com
        ];

        $locale = $domains[$host] ?? 'az';
        
        // Set locale for the request
        app()->setLocale($locale);
        
        // Store current domain for views
        view()->share('current_domain', $host);
        
        return $next($request);
    }
}