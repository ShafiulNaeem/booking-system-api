<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HostMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guard('api')->user()->role == 'host') {
            return $next($request);
        } else {
            return sendError(
                'Unauthorized to access.',
                [],
                Response::HTTP_UNAUTHORIZED
            );
        }
    }
}
