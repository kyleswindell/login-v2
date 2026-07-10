<?php

namespace App\Platform\Dashboard\Widgets;

use App\Models\User;
use App\Modules\Notifications\Models\Notification;
use App\Platform\Dashboard\RendersOnDashboard;
use Illuminate\Support\Facades\Auth;

class PlatformStatsWidget implements RendersOnDashboard
{
    public static function canView(): bool
    {
        return Auth::check();
    }

    public function getDashboardView(): string
    {
        return 'livewire.platform.dashboard.widgets.platform-stats-overview';
    }

    public function getDashboardViewData(): array
    {
        return [
            'stats' => [
                ['label' => 'Total Users', 'value' => User::query()->count(), 'tone' => 'slate'],
                ['label' => 'Active Users', 'value' => User::query()->where('is_active', true)->count(), 'tone' => 'emerald'],
                [
                    'label' => 'Unread Notifications',
                    'value' => Notification::query()
                        ->whereMorphedTo('notifiable', Auth::user())
                        ->whereNull('read_at')
                        ->count(),
                    'tone' => 'amber',
                ],
            ],
        ];
    }
}
