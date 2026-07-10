<?php

namespace App\Platform\Dashboard\Widgets;

use App\Models\CentralErrorLog;
use App\Platform\Dashboard\RendersOnDashboard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ErrorHealthWidget implements RendersOnDashboard
{
    public static function canView(): bool
    {
        return Auth::check() && Gate::allows('view-platform-error-logs');
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
