<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Platform\Dashboard\RendersOnDashboard;
use App\Platform\Notifications\NotificationService;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DevelopmentToolsWidget extends Widget implements RendersOnDashboard
{
    protected static ?int $sort = 4;

    protected string $view = 'filament.widgets.development-tools-widget';

    public static function canView(): bool
    {
        return Auth::check() && Gate::allows('view-platform-notifications');
    }

    public function generateTestNotification(): void
    {
        $user = Auth::user();
        if (!$user instanceof User) {
            return;
        }

        $notificationService = app(NotificationService::class);
        $notificationService->sendTo(
            notifiable: $user,
            moduleKey: 'development',
            title: 'Test notification',
            body: 'This notification was generated from the dashboard development tools widget.',
            severity: 'notice',
            actionUrl: route('platform.administration.notifications.index'),
            metadata: ['source' => 'dashboard-development-tools'],
        );

        session()->flash('status', 'Test notification generated and delivered to your inbox.');
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
