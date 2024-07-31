<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'ban' => \App\Http\Middleware\Ban::class,
            'admin' => \App\Http\Middleware\admin::class,
            'employee' => \App\Http\Middleware\employee::class,
            'company' => \App\Http\Middleware\company::class,
            'bluebadge' => \App\Http\Middleware\BlueBadge::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
