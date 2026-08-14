<?php

/*
|--------------------------------------------------------------------------
| File: Modules/ProfileMfgPoc/Routes/web.php
| Purpose: Registers authenticated read-only Profile Mfg POC routes.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

use App\Modules\ProfileMfgPoc\Http\Controllers\ProfileMfgPocController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProfileMfgPocController::class, 'dashboard'])->name('dashboard');
Route::get('/shipping-schedule', [ProfileMfgPocController::class, 'shippingSchedule'])->name('shipping-schedule');
Route::get('/customers', [ProfileMfgPocController::class, 'customers'])->name('customers.index');
Route::get('/customers/{customer}', [ProfileMfgPocController::class, 'customer'])->name('customers.show');
Route::get('/parts', [ProfileMfgPocController::class, 'parts'])->name('parts.index');
Route::get('/parts/{part}/image', [ProfileMfgPocController::class, 'partImage'])->name('parts.image');
Route::get('/parts/{part}', [ProfileMfgPocController::class, 'part'])->name('parts.show');
Route::get('/orders', [ProfileMfgPocController::class, 'orders'])->name('orders.index');
Route::get('/orders/{order}', [ProfileMfgPocController::class, 'order'])->name('orders.show');
Route::get('/inventory', [ProfileMfgPocController::class, 'inventory'])->name('inventory.index');
Route::get('/scanning', [ProfileMfgPocController::class, 'scanning'])->name('scanning.index');
Route::get('/reports', [ProfileMfgPocController::class, 'reports'])->name('reports.index');
Route::get('/settings', [ProfileMfgPocController::class, 'settings'])->name('settings.index');
