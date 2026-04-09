<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Platform\DashboardController;
use App\Http\Controllers\Platform\DocsController;
use App\Http\Controllers\Platform\PlatformUserController;
use Illuminate\Support\Facades\Auth;
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

    Route::get('/platform/users', [PlatformUserController::class, 'index'])->name('platform.users.index');
    Route::get('/platform/users/create', [PlatformUserController::class, 'create'])->name('platform.users.create');
    Route::post('/platform/users', [PlatformUserController::class, 'store'])->name('platform.users.store');
    Route::get('/platform/users/{user}/edit', [PlatformUserController::class, 'edit'])->name('platform.users.edit');
    Route::match(['put', 'patch'], '/platform/users/{user}', [PlatformUserController::class, 'update'])->name('platform.users.update');

    Route::get('/platform/docs', DocsController::class)->name('platform.docs.index');

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});
