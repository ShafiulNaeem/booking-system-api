<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, string $guard)
    {
        if (auth()->guard($guard)->check()) {
            return $next($request);
        } else {
            return sendError('Unauthenticated.', [], 401);
        }
    }
}
