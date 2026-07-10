<?php

namespace App\Platform\Dashboard\Widgets;

use App\Models\PlatformAuditLog;
use App\Platform\Dashboard\RendersOnDashboard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RecentAuditActivityWidget implements RendersOnDashboard
{
    public static function canView(): bool
    {
        return Auth::check() && Gate::allows('view-platform-audit-logs');
    }

    public function getDashboardView(): string
    {
        return 'livewire.platform.dashboard.widgets.recent-audit-activity';
    }

    public function getDashboardViewData(): array
    {
        return [
            'logs' => PlatformAuditLog::query()
                ->latest('occurred_at')
                ->limit(10)
                ->get(['occurred_at', 'event_type', 'action', 'actor_user_id', 'result', 'severity']),
        ];
    }
}
