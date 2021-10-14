<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;

/**
 * Class CorsMiddleware.
 */
class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
}
