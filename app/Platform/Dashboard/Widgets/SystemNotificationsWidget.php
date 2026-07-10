<?php

namespace App\Platform\Dashboard\Widgets;

use App\Modules\Notifications\Models\Notification;
use App\Modules\Notifications\Services\NotificationPermissions;
use App\Platform\Dashboard\RendersOnDashboard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SystemNotificationsWidget implements RendersOnDashboard
{
    public static function canView(): bool
    {
        return Auth::check() && Gate::allows(NotificationPermissions::VIEW);
    }

    public function getDashboardView(): string
    {
        return 'livewire.platform.dashboard.widgets.system-notifications';
    }

    public function getDashboardViewData(): array
    {
        return [
            'notifications' => Notification::query()
                ->whereMorphedTo('notifiable', Auth::user())
                ->whereNull('read_at')
                ->latest()
                ->limit(5)
                ->get(),
        ];
    }
}
