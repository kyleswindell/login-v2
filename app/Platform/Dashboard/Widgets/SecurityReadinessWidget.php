<?php

namespace App\Platform\Dashboard\Widgets;

use App\Models\SecurityRequirement;
use App\Platform\Dashboard\RendersOnDashboard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SecurityReadinessWidget implements RendersOnDashboard
{
    public static function canView(): bool
    {
        return Auth::check() && Gate::allows('view-platform-security-checklist');
    }

    public function getDashboardView(): string
    {
        return 'livewire.platform.dashboard.widgets.security-readiness';
    }

    public function getDashboardViewData(): array
    {
        $counts = SecurityRequirement::query()
            ->selectRaw('alignment_status, count(*) as aggregate')
            ->groupBy('alignment_status')
            ->pluck('aggregate', 'alignment_status')
            ->map(fn (int|string $count): int => (int) $count)
            ->all();

        return [
            'counts' => $counts,
            'total' => array_sum($counts),
            'openCritical' => SecurityRequirement::query()
                ->whereIn('priority', ['critical', 'high'])
                ->whereIn('alignment_status', [
                    SecurityRequirement::ALIGNMENT_PARTIAL,
                    SecurityRequirement::ALIGNMENT_LACKING,
                ])
                ->count(),
            'labels' => SecurityRequirement::alignmentStatuses(),
        ];
    }
}
