<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Routes/web.php
| Purpose: Registers Roles module web routes.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

use App\Modules\Roles\Http\Controllers\CreateController;
use App\Modules\Roles\Http\Controllers\DeleteController;
use App\Modules\Roles\Http\Controllers\DestroyController;
use App\Modules\Roles\Http\Controllers\EditController;
use App\Modules\Roles\Http\Controllers\IndexController;
use App\Modules\Roles\Http\Controllers\PermissionsIndexController;
use App\Modules\Roles\Http\Controllers\ShowController;
use App\Modules\Roles\Http\Controllers\StoreController;
use App\Modules\Roles\Http\Controllers\UpdateController;
use Illuminate\Support\Facades\Route;

Route::get('/platform/roles', IndexController::class)->name('roles.index');
Route::get('/platform/roles/permissions', PermissionsIndexController::class)->name('roles.permissions.index');
Route::get('/platform/roles/create', CreateController::class)->name('roles.create');
Route::post('/platform/roles', StoreController::class)->name('roles.store');
Route::get('/platform/roles/{role}', ShowController::class)->name('roles.show');
Route::get('/platform/roles/{role}/edit', EditController::class)->name('roles.edit');
Route::patch('/platform/roles/{role}', UpdateController::class)->name('roles.update');
Route::get('/platform/roles/{role}/delete', DeleteController::class)->name('roles.delete');
Route::delete('/platform/roles/{role}', DestroyController::class)->name('roles.destroy');
