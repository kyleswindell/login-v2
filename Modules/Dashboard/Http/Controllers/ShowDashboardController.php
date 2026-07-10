<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Dashboard/Http/Controllers/ShowDashboardController.php
| Purpose: Renders the Dashboard module main page.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Dashboard\Http\Controllers;

use Illuminate\Contracts\View\View;

final class ShowDashboardController
{
    public function __invoke(): View
    {
        return view('dashboard::index');
    }
}
