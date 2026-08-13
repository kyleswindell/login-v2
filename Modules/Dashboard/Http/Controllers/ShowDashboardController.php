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
use Illuminate\Http\RedirectResponse;

final class ShowDashboardController
{
    public function __invoke(): View|RedirectResponse
    {
        if ((bool) config('profile-mfg-poc.enabled', false)) {
            return redirect()->route('profile-mfg.dashboard');
        }

        return view('dashboard::index');
    }
}
