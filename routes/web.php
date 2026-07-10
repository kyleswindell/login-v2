<?php

use App\Http\Controllers\Platform\AuditLogController;
use App\Http\Controllers\Platform\DocsController;
use App\Http\Controllers\Platform\ErrorLogController;
use App\Http\Controllers\Platform\PlatformUserController;
use App\Http\Controllers\Platform\PlatformUserMfaController;
use App\Http\Controllers\Platform\SecurityChecklistController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Treat the root URL as the app entry point so staging lands on the real auth flow
    // instead of the Laravel starter page once the platform foundation is in place.
    return redirect()->route(Auth::check() ? 'dashboard' : 'login');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/platform/users', [PlatformUserController::class, 'index'])->name('platform.users.index');
    Route::get('/platform/users/create', [PlatformUserController::class, 'create'])->name('platform.users.create');
    Route::post('/platform/users', [PlatformUserController::class, 'store'])->name('platform.users.store');
    Route::get('/platform/users/{user}/edit', [PlatformUserController::class, 'edit'])->name('platform.users.edit');
    Route::match(['put', 'patch'], '/platform/users/{user}', [PlatformUserController::class, 'update'])->name('platform.users.update');
    Route::post('/platform/users/{user}/toggle-active', [PlatformUserController::class, 'toggleActive'])->name('platform.users.toggle-active');
    Route::post('/platform/users/{user}/mfa-requirement', [PlatformUserMfaController::class, 'updateRequirement'])->name('platform.users.mfa-requirement');
    Route::post('/platform/users/{user}/mfa-reset', [PlatformUserMfaController::class, 'reset'])->name('platform.users.mfa-reset');

    Route::get('/platform/administration/users', function () {
        abort_unless(Gate::allows('view-platform-users'), 403);

        return redirect()->route('platform.users.index');
    })->name('platform.administration.users.index');

    Route::get('/platform/audit-logs', [AuditLogController::class, 'index'])->name('platform.audit-logs.index');
    Route::get('/platform/audit-logs/{log}', [AuditLogController::class, 'show'])->name('platform.audit-logs.show');

    Route::get('/platform/operations/audit-logs', function () {
        abort_unless(Gate::allows('view-platform-audit-logs'), 403);

        return redirect()->route('platform.audit-logs.index');
    })->name('platform.operations.audit-logs.index');

    Route::get('/platform/error-logs', [ErrorLogController::class, 'index'])->name('platform.error-logs.index');
    Route::get('/platform/error-logs/{log}', [ErrorLogController::class, 'show'])->name('platform.error-logs.show');

    Route::get('/platform/operations/error-logs', function () {
        abort_unless(Gate::allows('view-platform-error-logs'), 403);

        return redirect()->route('platform.error-logs.index');
    })->name('platform.operations.error-logs.index');

    Route::get('/platform/security', [SecurityChecklistController::class, 'index'])->name('platform.security.index');
    Route::get('/platform/security/{requirement:slug}', [SecurityChecklistController::class, 'show'])->name('platform.security.show');
    Route::patch('/platform/security/{requirement:slug}', [SecurityChecklistController::class, 'update'])->name('platform.security.update');

    Route::get('/platform/docs', DocsController::class)->name('platform.docs.index');
});
