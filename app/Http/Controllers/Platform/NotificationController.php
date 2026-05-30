<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\PlatformNotification;
use App\Platform\Notifications\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class NotificationController extends Controller
{
    public function index(): View
    {
        $this->authorize('view-platform-notifications');

        return view('platform.notifications.index', [
            'notifications' => PlatformNotification::query()
                ->visibleTo(auth()->user())
                ->latest()
                ->paginate(15),
            'unreadCount' => PlatformNotification::query()
                ->visibleTo(auth()->user())
                ->whereNull('read_at')
                ->count(),
        ]);
    }

    public function markRead(PlatformNotification $notification, NotificationService $notificationService): RedirectResponse
    {
        $this->authorize('view-platform-notifications');
        abort_unless($this->ownsNotification($notification), 404);

        $notificationService->markAsRead($notification);

        return back()->with('status', 'Notification marked as read.');
    }

    public function dismiss(PlatformNotification $notification, NotificationService $notificationService): RedirectResponse
    {
        $this->authorize('view-platform-notifications');
        abort_unless($this->ownsNotification($notification), 404);

        $notificationService->dismiss($notification);

        return back()->with('status', 'Notification dismissed.');
    }

    public function markAllRead(Request $request, NotificationService $notificationService): RedirectResponse|JsonResponse
    {
        $this->authorize('view-platform-notifications');

        $notifications = PlatformNotification::query()
            ->visibleTo(auth()->user())
            ->whereNull('read_at')
            ->get();

        $notifications->each(fn (PlatformNotification $notification) => $notificationService->markAsRead($notification));

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'All notifications marked as read.',
                'unread_count' => 0,
                'marked_notification_ids' => $notifications->pluck('id')->all(),
            ]);
        }

        return back()->with('status', 'All notifications marked as read.');
    }

    private function ownsNotification(PlatformNotification $notification): bool
    {
        return $notification->notifiable_type === auth()->user()::class
            && (int) $notification->notifiable_id === (int) auth()->id();
    }
}
