<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\PlatformNotification;
use App\Models\Setting;
use App\Models\User;
use App\Platform\Docs\DocsRepository;
use App\Platform\Notifications\NotificationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function __invoke(DocsRepository $docsRepository): View
    {
        return view('platform.dashboard', [
            'userCount' => User::query()->count(),
            'activeUserCount' => User::query()->where('is_active', true)->count(),
            'settingsCount' => Setting::query()->count(),
            'unreadNotificationCount' => PlatformNotification::query()
                ->whereMorphedTo('notifiable', auth()->user())
                ->whereNull('read_at')
                ->count(),
            'docsFileCount' => $docsRepository->countFiles(),
        ]);
    }

    public function sendTestNotification(NotificationService $notificationService): RedirectResponse
    {
        $this->authorize('view-platform-notifications');

        $notificationService->sendTo(
            auth()->user(),
            'platform',
            'Test notification',
            'Temporary dashboard-generated notification for Batch 5 review.',
            'info',
            route('platform.administration.notifications.index'),
            metadata: [
                'source' => 'dashboard_test_notification',
                'generated_at' => now()->toIso8601String(),
            ],
        );

        return back()->with('status', 'Test notification generated.');
    }
}
