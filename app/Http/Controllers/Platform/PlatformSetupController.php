<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class PlatformSetupController extends Controller
{
    public function notifications(): View
    {
        $this->authorize('view-platform-notifications');

        return view('platform.setup.notifications');
    }

    public function docs(): View
    {
        $this->authorize('view-platform-docs');

        return view('platform.setup.docs');
    }

    public function auditLogs(): View
    {
        $this->authorize('view-platform-audit-logs');

        return view('platform.setup.audit-logs');
    }

    public function errorLogs(): View
    {
        $this->authorize('view-platform-error-logs');

        return view('platform.setup.error-logs');
    }

    public function users(): View
    {
        $this->authorize('view-platform-users');

        return view('platform.setup.users');
    }
}
