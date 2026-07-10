<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Notifications/Header/PanelDataProvider.php
| Purpose: Provides Notifications module data for the app header panel.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Notifications\Header;

use App\Models\User;
use App\Modules\Notifications\Models\Notification;
use App\Modules\Notifications\Services\NotificationPermissions;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Support\Facades\Route;

final class PanelDataProvider
{
    public function __construct(private readonly Gate $gate) {}

    /**
     * @return array<string, mixed>
     */
    public function forUser(?User $user): array
    {
        $canView =
            $user !== null &&
            $this->gate->forUser($user)->allows(NotificationPermissions::VIEW);

        $recent = $canView
            ? Notification::query()
                ->visibleTo($user)
                ->latest()
                ->limit(20)
                ->get()
            : collect();

        $unread = $canView
            ? Notification::query()
                ->visibleTo($user)
                ->whereNull("read_at")
                ->count()
            : 0;

        return [
            "canView" => $canView,
            "realtimeEnabled" =>
                $canView && (bool) $user?->can(NotificationPermissions::VIEW),
            "userId" => $user?->id,
            "unreadCount" => $unread,
            "recent" => $recent
                ->map(
                    fn(Notification $notification): array => $this->item(
                        $notification,
                    ),
                )
                ->all(),
            "routes" => [
                "index" => $this->routeHref("notifications.index"),
                "markAllRead" => $this->routeHref(
                    "notifications.mark-all-read",
                ),
                "realtimeAuth" => $this->routeHref(
                    "notifications.realtime.auth",
                ),
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function item(Notification $notification): array
    {
        $href =
            $notification->action_url ?:
            $this->routeHref("notifications.index");
        $createdLabel = $notification->created_at?->format("M j, g:i A");
        $isUnread = $notification->read_at === null;

        return [
            "id" => $notification->id,
            "uuid" => $notification->uuid,
            "title" => $notification->title,
            "body" => $notification->body,
            "subtitle" => $notification->body,
            "message" => $notification->body,
            "severity" => $notification->severity,
            "kind" => $this->kind($notification->severity),
            "href" => $href,
            "url" => $href,
            "wireNavigate" => $this->isInternalHref($href),
            "read" => !$isUnread,
            "unread" => $isUnread,
            "read_at" => $notification->read_at?->toIso8601String(),
            "created_at" => $notification->created_at?->toIso8601String(),
            "created_label" => $createdLabel,
            "time" => $createdLabel,
        ];
    }

    private function kind(?string $severity): string
    {
        return match ($severity) {
            "success" => "success",
            "notice" => "notice",
            "warning" => "warning",
            "error" => "error",
            "urgent" => "danger",
            default => "info",
        };
    }

    private function routeHref(string $route): string
    {
        return Route::has($route) ? route($route) : "#";
    }

    private function isInternalHref(string $href): bool
    {
        if ($href === "#" || str_starts_with($href, "/")) {
            return true;
        }

        $appUrl = (string) config("app.url");

        return $appUrl !== "" && str_starts_with($href, $appUrl);
    }
}
