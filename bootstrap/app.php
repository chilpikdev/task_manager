<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'user.active' => \App\Http\Middleware\CheckUserActiveMiddleware::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'Excel' => Maatwebsite\Excel\Facades\Excel::class,
        ]);
        $middleware->appendToGroup('api', [
            \App\Http\Middleware\ChangeLocale::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (AuthenticationException $e) {
            return response()->json([
                'status' => 401,
                'message' => $e->getMessage(),
            ], 401);
        });

        $exceptions->renderable(function (HttpException $e) {
            return response()->json([
                'status' => $e->getStatusCode(),
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        });
    })->create();
