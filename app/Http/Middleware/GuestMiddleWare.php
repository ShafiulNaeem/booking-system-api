<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guard('api')->user()->role == 'guest') {
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
