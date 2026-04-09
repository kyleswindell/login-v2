<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\PlatformNotification;
use App\Models\Setting;
use App\Models\User;
use App\Platform\Docs\DocsRepository;
use Illuminate\Contracts\View\View;

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
}
