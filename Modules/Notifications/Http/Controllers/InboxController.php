<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Notifications/Http/Controllers/InboxController.php
| Purpose: Handles the Notifications module inbox routes.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Notifications\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Notifications\Models\Notification;
use App\Modules\Notifications\Services\NotificationPermissions;
use App\Modules\Notifications\Services\Store;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class InboxController extends Controller
{
    public function index(): View
    {
        $this->authorize(NotificationPermissions::VIEW);

        return view('notifications::index', [
            'notifications' => Notification::query()
                ->visibleTo(auth()->user())
                ->latest()
                ->paginate(15),
            'unreadCount' => Notification::query()
                ->visibleTo(auth()->user())
                ->whereNull('read_at')
                ->count(),
        ]);
    }

    public function markRead(Notification $notification, Store $store): RedirectResponse
    {
        $this->authorize(NotificationPermissions::VIEW);
        abort_unless($this->ownsNotification($notification), 404);

        $store->markAsRead($notification);

        return back()->with('status', 'Notification marked as read.');
    }

    public function dismiss(Notification $notification, Store $store): RedirectResponse
    {
        $this->authorize(NotificationPermissions::VIEW);
        abort_unless($this->ownsNotification($notification), 404);

        $store->dismiss($notification);

        return back()->with('status', 'Notification dismissed.');
    }

    public function markAllRead(Request $request, Store $store): RedirectResponse|JsonResponse
    {
        $this->authorize(NotificationPermissions::VIEW);

        $notifications = Notification::query()
            ->visibleTo(auth()->user())
            ->whereNull('read_at')
            ->get();

        $notifications->each(fn (Notification $notification) => $store->markAsRead($notification));

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'All notifications marked as read.',
                'unread_count' => 0,
                'marked_notification_ids' => $notifications->pluck('id')->all(),
            ]);
        }

        return back()->with('status', 'All notifications marked as read.');
    }

    private function ownsNotification(Notification $notification): bool
    {
        return $notification->notifiable_type === auth()->user()::class
            && (int) $notification->notifiable_id === (int) auth()->id();
    }
}
