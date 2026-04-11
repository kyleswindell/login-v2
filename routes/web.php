<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Platform\AuditLogController;
use App\Http\Controllers\Platform\BroadcastAuthController;
use App\Http\Controllers\Platform\DashboardController;
use App\Http\Controllers\Platform\DocsController;
use App\Http\Controllers\Platform\ErrorLogController;
use App\Http\Controllers\Platform\NotificationController;
use App\Http\Controllers\Platform\PlatformSetupController;
use App\Http\Controllers\Platform\PlatformUserController;
use App\Http\Controllers\Platform\SettingsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Treat the root URL as the app entry point so staging lands on the real auth flow
    // instead of the Laravel starter page once the platform foundation is in place.
    return redirect()->route(Auth::check() ? 'dashboard' : 'login');
});

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::post('/platform/realtime/auth', BroadcastAuthController::class)->name('platform.realtime.auth');

    Route::get('/platform/users', [PlatformUserController::class, 'index'])->name('platform.users.index');
    Route::get('/platform/users/create', [PlatformUserController::class, 'create'])->name('platform.users.create');
    Route::post('/platform/users', [PlatformUserController::class, 'store'])->name('platform.users.store');
    Route::get('/platform/users/{user}/edit', [PlatformUserController::class, 'edit'])->name('platform.users.edit');
    Route::match(['put', 'patch'], '/platform/users/{user}', [PlatformUserController::class, 'update'])->name('platform.users.update');

    Route::get('/platform/administration/users', function () {
        abort_unless(Gate::allows('manage-platform-users'), 403);

        return redirect('/console/platform-users');
    })->name('platform.administration.users.index');

    Route::get('/platform/setup/notifications', [PlatformSetupController::class, 'notifications'])->name('platform.setup.notifications');
    Route::get('/platform/setup/docs', [PlatformSetupController::class, 'docs'])->name('platform.setup.docs');
    Route::get('/platform/setup/audit-logs', [PlatformSetupController::class, 'auditLogs'])->name('platform.setup.audit-logs');
    Route::get('/platform/setup/error-logs', [PlatformSetupController::class, 'errorLogs'])->name('platform.setup.error-logs');
    Route::get('/platform/setup/users', [PlatformSetupController::class, 'users'])->name('platform.setup.users');

    Route::get('/platform/notifications', [NotificationController::class, 'index'])->name('platform.notifications.index');
    Route::post('/platform/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('platform.notifications.mark-all-read');
    Route::post('/platform/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('platform.notifications.mark-read');
    Route::post('/platform/notifications/{notification}/dismiss', [NotificationController::class, 'dismiss'])->name('platform.notifications.dismiss');

    Route::get('/platform/administration/notifications', function () {
        abort_unless(Gate::allows('view-platform-notifications'), 403);

        return redirect()->route('platform.notifications.index');
    })->name('platform.administration.notifications.index');

    Route::get('/platform/audit-logs', [AuditLogController::class, 'index'])->name('platform.audit-logs.index');

    Route::get('/platform/operations/audit-logs', function () {
        abort_unless(Gate::allows('view-platform-audit-logs'), 403);

        return redirect('/console/platform-audit-logs');
    })->name('platform.operations.audit-logs.index');

    Route::get('/platform/error-logs', [ErrorLogController::class, 'index'])->name('platform.error-logs.index');
    Route::get('/platform/error-logs/{log}', [ErrorLogController::class, 'show'])->name('platform.error-logs.show');

    Route::get('/platform/operations/error-logs', function () {
        abort_unless(Gate::allows('view-platform-error-logs'), 403);

        return redirect('/console/central-error-logs');
    })->name('platform.operations.error-logs.index');

    Route::get('/platform/settings/general', [SettingsController::class, 'general'])->name('platform.settings.general');
    Route::post('/platform/settings/general', [SettingsController::class, 'updateGeneral'])->name('platform.settings.general.update');
    Route::get('/platform/settings/general/company-information', [SettingsController::class, 'generalCompanyInformation'])->name('platform.settings.general.company-information');
    Route::post('/platform/settings/general/company-information', [SettingsController::class, 'updateGeneralCompanyInformation'])->name('platform.settings.general.company-information.update');
    Route::get('/platform/settings/general/localization', [SettingsController::class, 'generalLocalization'])->name('platform.settings.general.localization');
    Route::post('/platform/settings/general/localization', [SettingsController::class, 'updateGeneralLocalization'])->name('platform.settings.general.localization.update');
    Route::get('/platform/settings/general/email', [SettingsController::class, 'generalEmail'])->name('platform.settings.general.email');
    Route::post('/platform/settings/general/email', [SettingsController::class, 'updateGeneralEmail'])->name('platform.settings.general.email.update');
    Route::get('/platform/settings/general/system-update', [SettingsController::class, 'generalSystemUpdate'])->name('platform.settings.general.system-update');
    Route::post('/platform/settings/general/system-update', [SettingsController::class, 'updateGeneralSystemUpdate'])->name('platform.settings.general.system-update.update');
    Route::get('/platform/settings/general/system-server-info', [SettingsController::class, 'generalSystemServerInfo'])->name('platform.settings.general.system-server-info');
    Route::get('/platform/settings/notifications', [SettingsController::class, 'notifications'])->name('platform.settings.notifications');
    Route::post('/platform/settings/notifications', [SettingsController::class, 'updateNotifications'])->name('platform.settings.notifications.update');
    Route::get('/platform/settings/audit-logs', [SettingsController::class, 'auditLogs'])->name('platform.settings.audit-logs');
    Route::post('/platform/settings/audit-logs', [SettingsController::class, 'updateAuditLogs'])->name('platform.settings.audit-logs.update');
    Route::get('/platform/settings/docs', [SettingsController::class, 'docs'])->name('platform.settings.docs');
    Route::post('/platform/settings/docs', [SettingsController::class, 'updateDocs'])->name('platform.settings.docs.update');
    Route::get('/platform/settings/users', [SettingsController::class, 'users'])->name('platform.settings.users');
    Route::post('/platform/settings/users', [SettingsController::class, 'updateUsers'])->name('platform.settings.users.update');

    Route::get('/platform/administration/settings', function () {
        abort_unless(Gate::allows('manage-platform-settings'), 403);

        return redirect()->route('platform.settings.general');
    })->name('platform.administration.settings.index');

    Route::get('/platform/docs', DocsController::class)->name('platform.docs.index');

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});
