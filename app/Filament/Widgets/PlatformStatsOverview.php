<?php

namespace App\Filament\Widgets;

use App\Models\PlatformNotification;
use App\Models\User;
use App\Platform\Dashboard\RendersOnDashboard;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class PlatformStatsOverview extends StatsOverviewWidget implements RendersOnDashboard
{
    protected static ?int $sort = 0;

    public static function canView(): bool
    {
        return Auth::check();
    }

    protected function getStats(): array
    {
        $user = Auth::user();

        return [
            Stat::make('Total Users', User::query()->count()),
            Stat::make('Active Users', User::query()->where('is_active', true)->count()),
            Stat::make(
                'Unread Notifications',
                PlatformNotification::query()
                    ->whereMorphedTo('notifiable', $user)
                    ->whereNull('read_at')
                    ->count(),
            ),
        ];
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
                    'value' => PlatformNotification::query()
                        ->whereMorphedTo('notifiable', Auth::user())
                        ->whereNull('read_at')
                        ->count(),
                    'tone' => 'amber',
                ],
            ],
        ];
    }
}
