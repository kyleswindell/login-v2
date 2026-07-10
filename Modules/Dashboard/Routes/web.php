<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Dashboard/Routes/web.php
| Purpose: Registers Dashboard module web routes.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

use App\Modules\Dashboard\Http\Controllers\ShowDashboardController;
use App\Modules\Dashboard\Http\Controllers\TestNotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', ShowDashboardController::class)->name('dashboard');
Route::post('/dashboard/test-notification', TestNotificationController::class)->name('dashboard.test-notification');
