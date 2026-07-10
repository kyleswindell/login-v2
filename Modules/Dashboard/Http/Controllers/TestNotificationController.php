<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Dashboard/Http/Controllers/TestNotificationController.php
| Purpose: Creates a temporary dashboard test notification.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Dashboard\Http\Controllers;

use App\Models\User;
use App\Modules\Notifications\Services\Delivery;
use App\Modules\Notifications\Services\NotificationPermissions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

final class TestNotificationController
{
    public function __invoke(Request $request, Delivery $notifications): RedirectResponse|JsonResponse
    {
        Gate::authorize(NotificationPermissions::VIEW);

        $user = Auth::user();

        abort_unless($user instanceof User, 403);

        $notification = $notifications->sendTo(
            notifiable: $user,
            moduleKey: 'dashboard',
            title: __('dashboard::dashboard.test_notification.title'),
            body: __('dashboard::dashboard.test_notification.body'),
            severity: 'notice',
            actionUrl: route('notifications.index'),
            metadata: ['source' => 'dashboard-test-notification-tile'],
        );

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'created' => true,
                'notification_id' => $notification->getKey(),
            ], 201);
        }

        return redirect()->route('dashboard');
    }
}
