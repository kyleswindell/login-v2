<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureConsoleProofPathsEnabled
{
    public function handle(Request $request, Closure $next): Response
    {
        if (config('app.console_proof_paths_enabled', true)) {
            return $next($request);
        }

        return $this->fallbackResponse($request);
    }

    private function fallbackResponse(Request $request): RedirectResponse
    {
        $path = trim($request->path(), '/');

        if ($path === 'console/login') {
            return redirect()->route('login');
        }

        if (str_starts_with($path, 'console/platform-users')) {
            return redirect()->route('platform.users.index');
        }

        if (str_starts_with($path, 'console/platform-audit-logs')) {
            return redirect()->route('platform.audit-logs.index');
        }

        if (str_starts_with($path, 'console/central-error-logs')) {
            return redirect()->route('platform.error-logs.index');
        }

        return redirect()->route($request->user() ? 'dashboard' : 'login');
    }
}
