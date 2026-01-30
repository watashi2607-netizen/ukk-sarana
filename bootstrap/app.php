<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'siswa' => \App\Http\Middleware\CheckSiswa::class,
            'admin' => \App\Http\Middleware\CheckAdmin::class,
            'guest' => \App\Http\Middleware\Guest::class,
        ]);
        $middleware->validateCsrfTokens(except: ['/login', '/logout']);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
