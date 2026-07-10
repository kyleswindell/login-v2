<?php

use App\Http\Middleware\ApplySecurityHeaders;
use App\Http\Middleware\ConfigureTrustedProxies;
use App\Http\Middleware\EnsureRequestId;
use App\Platform\Logging\PlatformLogger;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->prepend(ConfigureTrustedProxies::class);
        $middleware->append(EnsureRequestId::class);
        $middleware->append(ApplySecurityHeaders::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->dontReport([
            TokenMismatchException::class,
        ]);

        $exceptions->render(function (HttpException $exception, Request $request) {
            if ($exception->getStatusCode() !== 419 || ! $exception->getPrevious() instanceof TokenMismatchException) {
                return null;
            }

            if ($request->expectsJson()) {
                return null;
            }

            if (! $request->is('login', 'login/*', 'mfa/*')) {
                return null;
            }

            return redirect()
                ->route('login')
                ->with('auth_session_expired', true)
                ->with('auth_notice', 'The previous sign-in session expired. Start again to continue.');
        });

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
