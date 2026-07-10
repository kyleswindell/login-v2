<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Setup/Routes/web.php
| Purpose: Registers Setup module web routes.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

use App\Modules\Setup\Http\Controllers\ScreenController;
use Illuminate\Support\Facades\Route;

Route::get('/platform/setup', [ScreenController::class, 'index'])->name('platform.setup.index');
