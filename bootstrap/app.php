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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\Admin::class,
            'user' => \App\Http\Middleware\User::class,
            'kepalatimkerja' => \App\Http\Middleware\KepalaTimKerja::class,
            'kepalabagian' => \App\Http\Middleware\KepalaBagian::class,
            'kepalabalai'=> \App\Http\Middleware\KepalaBalai::class,
            'widyaiswara'=> \App\Http\Middleware\Widyaiswara::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
