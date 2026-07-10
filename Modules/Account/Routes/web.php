<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Account/Routes/web.php
| Purpose: Provides Account module package behavior.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

use App\Modules\Account\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::get('/account', [AccountController::class, 'index'])->name('platform.account.index');
Route::get('/account/security', [AccountController::class, 'security'])->name('platform.account.security');
Route::patch('/account/details', [AccountController::class, 'updateDetails'])->name('platform.account.details.update');
Route::patch('/account/profile-photo', [AccountController::class, 'updateProfilePhoto'])->name('platform.account.profile-photo.update');
Route::delete('/account/profile-photo', [AccountController::class, 'removeProfilePhoto'])->name('platform.account.profile-photo.destroy');
Route::post('/account/contact-emails', [AccountController::class, 'storeContactEmail'])->name('platform.account.contact-emails.store');
Route::delete('/account/contact-emails/{contactEmail}', [AccountController::class, 'destroyContactEmail'])->name('platform.account.contact-emails.destroy');
Route::post('/account/password', [AccountController::class, 'updatePassword'])->name('platform.account.password.update');
Route::get('/account/settings', [AccountController::class, 'settings'])->name('platform.account.settings');
Route::post('/account/settings', [AccountController::class, 'updateSettings'])->name('platform.account.settings.update');
