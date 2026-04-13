<?php

namespace App\Filament\Widgets;

use App\Models\CentralErrorLog;
use App\Platform\Dashboard\RendersOnDashboard;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PlatformErrorHealth extends StatsOverviewWidget implements RendersOnDashboard
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return Auth::check() && Gate::allows('view-platform-error-logs');
    }

    protected function getStats(): array
    {
        $errors24h = CentralErrorLog::query()
            ->where('occurred_at', '>=', now()->subDay())
            ->count();

        $errors7d = CentralErrorLog::query()
            ->where('occurred_at', '>=', now()->subWeek())
            ->count();

        $critical7d = CentralErrorLog::query()
            ->where('occurred_at', '>=', now()->subWeek())
            ->where('severity', 'critical')
            ->count();

        return [
            Stat::make('Errors (24h)', $errors24h),
            Stat::make('Errors (7d)', $errors7d),
            Stat::make('Critical (7d)', $critical7d),
        ];
    }

    public function getDashboardView(): string
    {
        return 'livewire.platform.dashboard.widgets.platform-error-health';
    }

    public function getDashboardViewData(): array
    {
        return [
            'stats' => [
                [
                    'label' => 'Errors (24h)',
                    'value' => CentralErrorLog::query()->where('occurred_at', '>=', now()->subDay())->count(),
                    'tone' => 'amber',
                ],
                [
                    'label' => 'Errors (7d)',
                    'value' => CentralErrorLog::query()->where('occurred_at', '>=', now()->subWeek())->count(),
                    'tone' => 'slate',
                ],
                [
                    'label' => 'Critical (7d)',
                    'value' => CentralErrorLog::query()
                        ->where('occurred_at', '>=', now()->subWeek())
                        ->where('severity', 'critical')
                        ->count(),
                    'tone' => 'rose',
                ],
            ],
        ];
    }
}
