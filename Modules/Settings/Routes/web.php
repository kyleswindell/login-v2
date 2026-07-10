<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Settings/Routes/web.php
| Purpose: Registers Settings module web routes.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

use App\Modules\Settings\Http\Controllers\PageController;
use App\Modules\Settings\Services\SettingsPermissions;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

Route::get('/settings', [PageController::class, 'index'])->name('settings.index');
Route::get('/platform/settings', [PageController::class, 'index'])->name('platform.settings.index');
Route::get('/platform/settings/general', function () {
    abort_unless(Gate::allows(SettingsPermissions::VIEW), 403);

    return redirect()->route('settings.index');
})->name('platform.settings.general');
Route::post('/platform/settings/general', [PageController::class, 'updateGeneral'])->name('platform.settings.general.update');
Route::get('/platform/settings/general/company-information', function () {
    abort_unless(Gate::allows(SettingsPermissions::VIEW), 403);

    return redirect()->route('settings.index');
})->name('platform.settings.general.company-information');
Route::post('/platform/settings/general/company-information', [PageController::class, 'updateGeneralCompanyInformation'])->name('platform.settings.general.company-information.update');
Route::get('/platform/settings/general/localization', function () {
    abort_unless(Gate::allows(SettingsPermissions::VIEW), 403);

    return redirect()->route('settings.index');
})->name('platform.settings.general.localization');
Route::post('/platform/settings/general/localization', [PageController::class, 'updateGeneralLocalization'])->name('platform.settings.general.localization.update');
Route::get('/platform/settings/general/email', function () {
    abort_unless(Gate::allows(SettingsPermissions::VIEW), 403);

    return redirect()->route('settings.index');
})->name('platform.settings.general.email');
Route::post('/platform/settings/general/email', [PageController::class, 'updateGeneralEmail'])->name('platform.settings.general.email.update');
Route::get('/platform/settings/general/system-update', function () {
    abort_unless(Gate::allows(SettingsPermissions::VIEW), 403);

    return redirect()->route('settings.index');
})->name('platform.settings.general.system-update');
Route::post('/platform/settings/general/system-update', [PageController::class, 'updateGeneralSystemUpdate'])->name('platform.settings.general.system-update.update');
Route::get('/platform/settings/general/system-server-info', function () {
    abort_unless(Gate::allows(SettingsPermissions::VIEW), 403);

    return redirect()->route('settings.index');
})->name('platform.settings.general.system-server-info');
Route::get('/platform/settings/audit-logs', [PageController::class, 'auditLogs'])->name('platform.settings.audit-logs');
Route::post('/platform/settings/audit-logs', [PageController::class, 'updateAuditLogs'])->name('platform.settings.audit-logs.update');
Route::get('/platform/settings/docs', [PageController::class, 'docs'])->name('platform.settings.docs');
Route::post('/platform/settings/docs', [PageController::class, 'updateDocs'])->name('platform.settings.docs.update');
Route::get('/platform/settings/users', [PageController::class, 'users'])->name('platform.settings.users');
Route::post('/platform/settings/users', [PageController::class, 'updateUsers'])->name('platform.settings.users.update');

Route::get('/platform/administration/settings', function () {
    abort_unless(Gate::allows(SettingsPermissions::VIEW), 403);

    return redirect()->route('settings.index');
})->name('platform.administration.settings.index');
