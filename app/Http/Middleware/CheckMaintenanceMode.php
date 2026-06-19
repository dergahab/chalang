<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next)
    {
        // Allow access to admin panel and login routes
        if ($request->is('admin/*') || $request->is('login') || $request->is('logout')) {
            return $next($request);
        }

        // Check if maintenance mode is enabled
        if (Setting::getValue('maintenance_mode')) {
            // Allow logged-in admins to see the site? Optional. 
            // For now, let's block everyone except admin routes.
            
            return response()->view('errors.503', [], 503);
        }

        return $next($request);
    }
}
