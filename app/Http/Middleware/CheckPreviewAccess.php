<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPreviewAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (config('app.env') === 'local') {
            return $next($request);
        }

        $previewToken = config('app.preview_token');
        $incomingToken = $request->query('preview_token')
            ?: $request->bearerToken()
            ?: $request->header('X-Preview-Token');

        if ($previewToken && $incomingToken === $previewToken) {
            return $next($request);
        }

        abort(404);
    }
}
