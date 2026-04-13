<?php

use App\Http\Middleware\EnsureRequestId;
use App\Platform\Logging\PlatformLogger;
use Illuminate\Foundation\Application;
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
        $middleware->append(EnsureRequestId::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->report(function (Throwable $exception): void {
            if (app()->runningInConsole() || ! app()->bound('db')) {
                return;
            }

            try {
                app(PlatformLogger::class)->recordException($exception);
            } catch (Throwable) {
                // Avoid cascading failures during exception reporting.
            }
        });
    })->create();
