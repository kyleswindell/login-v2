<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Preferences/Routes/web.php
| Purpose: Registers Preferences module web routes.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

use App\Modules\Preferences\Http\Controllers\PersonalDefaultsController;
use Illuminate\Support\Facades\Route;

Route::get('/account/preferences', [PersonalDefaultsController::class, 'edit'])->name('platform.account.preferences');
Route::post('/account/preferences', [PersonalDefaultsController::class, 'update'])->name('platform.account.preferences.update');
