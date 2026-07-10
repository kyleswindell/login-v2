<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Notifications/Routes/web.php
| Purpose: Registers Notifications module web routes.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

use App\Modules\Notifications\Http\Controllers\InboxController;
use App\Modules\Notifications\Http\Controllers\PersonalPreferencesController;
use App\Modules\Notifications\Http\Controllers\RealtimeAuthController;
use App\Modules\Notifications\Http\Controllers\SettingsDefaultsController;
use App\Modules\Notifications\Http\Controllers\SetupController;
use App\Modules\Notifications\Services\NotificationPermissions;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

Route::post('/notifications/realtime/auth', RealtimeAuthController::class)->name('notifications.realtime.auth');

Route::get('/notifications', [InboxController::class, 'index'])->name('notifications.index');
Route::post('/notifications/mark-all-read', [InboxController::class, 'markAllRead'])->name('notifications.mark-all-read');
Route::post('/notifications/{notification}/read', [InboxController::class, 'markRead'])->name('notifications.mark-read');
Route::post('/notifications/{notification}/dismiss', [InboxController::class, 'dismiss'])->name('notifications.dismiss');

Route::get('/account/notifications', [PersonalPreferencesController::class, 'edit'])->name('platform.account.notifications');
Route::post('/account/notifications', [PersonalPreferencesController::class, 'update'])->name('platform.account.notifications.update');

Route::post('/platform/realtime/auth', RealtimeAuthController::class)->name('platform.realtime.auth');

Route::get('/platform/notifications', [InboxController::class, 'index'])->name('platform.notifications.index');
Route::post('/platform/notifications/mark-all-read', [InboxController::class, 'markAllRead'])->name('platform.notifications.mark-all-read');
Route::post('/platform/notifications/{notification}/read', [InboxController::class, 'markRead'])->name('platform.notifications.mark-read');
Route::post('/platform/notifications/{notification}/dismiss', [InboxController::class, 'dismiss'])->name('platform.notifications.dismiss');

Route::get('/platform/settings/notifications', [SettingsDefaultsController::class, 'edit'])->name('platform.settings.notifications');
Route::post('/platform/settings/notifications', [SettingsDefaultsController::class, 'update'])->name('platform.settings.notifications.update');

Route::get('/platform/setup/notifications', [SetupController::class, 'index'])->name('platform.setup.notifications');

Route::get('/platform/administration/notifications', function () {
    abort_unless(Gate::allows(NotificationPermissions::VIEW), 403);

    return redirect()->route('notifications.index');
})->name('platform.administration.notifications.index');
