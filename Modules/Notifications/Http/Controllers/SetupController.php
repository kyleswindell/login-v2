<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Notifications/Http/Controllers/SetupController.php
| Purpose: Handles Notifications setup page rendering.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Notifications\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Notifications\Services\NotificationPermissions;
use Illuminate\Contracts\View\View;

final class SetupController extends Controller
{
    public function index(): View
    {
        $this->authorize(NotificationPermissions::VIEW);

        return view('notifications::setup.index');
    }
}
