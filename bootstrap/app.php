<?php

use App\Http\Middleware\RestrictAccess;
use Illuminate\Foundation\Application;
use \App\Http\Middleware\NgrokMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(NgrokMiddleware::class);
        $middleware->trustProxies(at: '*');
        $middleware->trustHosts(at: ['light-pleasantly-parakeet.ngrok-free.app']);
        $middleware->alias([
           'restrict'   => RestrictAccess::class, 
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();