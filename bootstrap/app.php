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
        // $middleware->redirectTo(
        //   guests: function ($request) {
        //     if($request->is('teknisi/*')){
        //         return route('login.teknisi');
        //     }

        //     return route('login.mahasiswa');
        //   },
        //   users: '/dashboard',  
        // );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();