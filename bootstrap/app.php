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
        // Redirecionar usuários não autenticados para a página de login
        $middleware->redirectGuestsTo('/login');
        
        // Registrar middleware de autenticação
        $middleware->alias([
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
            'force.auth' => \App\Http\Middleware\ForceAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
