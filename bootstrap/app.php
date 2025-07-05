<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',  // <-- TAMBAHKAN INI
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Konfigurasi middleware untuk API dengan JWT
        $middleware->api(prepend: [
            // Tidak perlu Sanctum middleware untuk JWT
        ]);

        // JWT middleware akan otomatis ditangani oleh guard 'api' di config/auth.php
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle AuthenticationException for API responses
        $exceptions->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated.'
                ], 401);
            }
        });
    })
    ->create();