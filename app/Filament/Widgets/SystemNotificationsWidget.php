<?php

namespace App\Filament\Widgets;

use App\Models\PlatformNotification;
use App\Platform\Dashboard\RendersOnDashboard;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SystemNotificationsWidget extends Widget implements RendersOnDashboard
{
    protected static ?int $sort = 3;

    protected string $view = 'filament.widgets.system-notifications-widget';

    public static function canView(): bool
    {
        return Auth::check() && Gate::allows('view-platform-notifications');
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $notifications = PlatformNotification::query()
            ->whereMorphedTo('notifiable', Auth::user())
            ->whereNull('read_at')
            ->latest()
            ->limit(5)
            ->get();

        return ['notifications' => $notifications];
    }

    public function getDashboardView(): string
    {
        return 'livewire.platform.dashboard.widgets.system-notifications';
    }

    public function getDashboardViewData(): array
    {
        return $this->getViewData();
    }
}
