<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Alias middleware yang sudah Anda buat
        $middleware->alias([
            'cek_peran' => \App\Http\Middleware\CheckPeran::class,
        ]);

        // TAMBAHKAN BARIS INI
        // Mengarahkan tamu (belum login) ke halaman login kustom Anda
        $middleware->redirectGuestsTo(fn(Request $request) => route('febi.login'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn(Request $request) => $request->is('api/*'),
        );
    })->create();
