<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class PlatformSetupController extends Controller
{
    public function users(): View
    {
        $this->authorize('manage-platform-users');

        return view('platform.setup.users');
    }
}
