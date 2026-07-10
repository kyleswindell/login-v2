<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Routes/web.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

use App\Modules\Auth\Http\Controllers\AccountMfaController;
use App\Modules\Auth\Http\Controllers\LoginController;
use App\Modules\Auth\Http\Controllers\MfaChallengeController;
use App\Modules\Auth\Http\Controllers\MfaEnrollmentController;
use App\Modules\Auth\Http\Controllers\MfaStepUpController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login/identify', [LoginController::class, 'identify'])->name('login.identify');
    Route::get('/login/password', [LoginController::class, 'password'])->name('login.password');
    Route::post('/login/password', [LoginController::class, 'authenticate'])->name('login.password.store');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::get('/mfa/challenge', [MfaChallengeController::class, 'show'])->name('mfa.challenge');
    Route::post('/mfa/challenge', [MfaChallengeController::class, 'verify'])->name('mfa.challenge.verify');
    Route::get('/mfa/enroll', [MfaEnrollmentController::class, 'show'])->name('mfa.enroll');
    Route::post('/mfa/enroll', [MfaEnrollmentController::class, 'confirm'])->name('mfa.enroll.confirm');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/mfa/step-up', [MfaStepUpController::class, 'show'])->name('mfa.step-up');
    Route::post('/mfa/step-up', [MfaStepUpController::class, 'verify'])->name('mfa.step-up.verify');
    Route::get('/account/mfa/recovery-codes', [AccountMfaController::class, 'recoveryCodes'])->name('platform.account.mfa.recovery-codes');
    Route::get('/account/mfa/enroll', [AccountMfaController::class, 'show'])->name('platform.account.mfa.enroll');
    Route::post('/account/mfa/enroll', [AccountMfaController::class, 'confirm'])->name('platform.account.mfa.confirm');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});
