<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => App\Http\Middleware\Authenticate::class,
            'host' => App\Http\Middleware\HostMiddleWare::class,
            'guest' => App\Http\Middleware\GuestMiddleWare::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (MethodNotAllowedHttpException $e, $request) {
            return sendError(
                'Method Not Allowed',
                ['error' => 'Method Not Allowed'],
                Response::HTTP_METHOD_NOT_ALLOWED
            );
        })
            ->render(function (ModelNotFoundException $e, $request) {
                return sendError(
                    'Record Not Found',
                    ['error' => 'Record Not Found'],
                    Response::HTTP_NOT_FOUND
                );
            })
            ->render(function (NotFoundHttpException  $e, $request) {
                return sendError(
                    'Not Found',
                    ['error' => 'Not Found'],
                    Response::HTTP_NOT_FOUND
                );
            });
    })->create();
