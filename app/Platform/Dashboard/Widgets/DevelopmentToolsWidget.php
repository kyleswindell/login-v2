<?php

namespace App\Platform\Dashboard\Widgets;

use App\Modules\Notifications\Services\NotificationPermissions;
use App\Platform\Dashboard\RendersOnDashboard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DevelopmentToolsWidget implements RendersOnDashboard
{
    public static function canView(): bool
    {
        return Auth::check() && Gate::allows(NotificationPermissions::VIEW);
    }

    public function getDashboardView(): string
    {
        return 'livewire.platform.dashboard.widgets.development-tools';
    }

    public function getDashboardViewData(): array
    {
        return [];
    }
}
