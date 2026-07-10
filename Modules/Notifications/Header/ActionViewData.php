<?php

declare(strict_types=1);

namespace App\Modules\Notifications\Header;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| File: Modules/Notifications/Header/ActionViewData.php
| Purpose: Normalized view data for the Notifications header action.
|--------------------------------------------------------------------------
|
| This class prepares render-only data for:
|
| - Modules/Notifications/resources/views/header/action.blade.php
| - Modules/Notifications/resources/views/header/partials/*
|
| This is not an Eloquent model and should not own persistence, queries,
| broadcasting, marking notifications read, or dismissing notifications.
|
*/

final class ActionViewData
{
    /*
    |--------------------------------------------------------------------------
    | Factory
    |--------------------------------------------------------------------------
    */

    public static function make(array $action = [], array $data = []): array
    {
        /*
        |--------------------------------------------------------------------------
        | Action / Module Inputs
        |--------------------------------------------------------------------------
        */

        $id = data_get($action, "panelTarget") ?: "app-header-notifications";
        $entryKey = data_get($action, "key");
        $moduleKey = data_get($action, "moduleKey");
        $label = data_get($action, "label") ?: "Notifications";
        $iconName = data_get($action, "icon") ?: "notification";
        $open = (bool) data_get($action, "expanded", false);

        /*
        |--------------------------------------------------------------------------
        | Panel IDs
        |--------------------------------------------------------------------------
        */

        $panelId = "{$id}-content";
        $panelTitleId = "{$panelId}-title";
        $panelSummaryId = "{$panelId}-summary";
        $unreadTabId = "{$id}-unread-tab";
        $allTabId = "{$id}-all-tab";
        $unreadPanelId = "{$id}-unread-panel";
        $allPanelId = "{$id}-all-panel";

        /*
        |--------------------------------------------------------------------------
        | Notification Data
        |--------------------------------------------------------------------------
        */

        $notifications = data_get($data, "recent", []);
        $unreadCount = data_get($data, "unreadCount");
        $activeFilter = data_get($data, "activeFilter", "unread");
        $showMarkAllAsRead = (bool) data_get($data, "showMarkAllAsRead", true);
        $markAllLabel = data_get($data, "markAllLabel", "Mark all as read");

        $indexHref =
            data_get($data, "routes.index") ?? data_get($action, "href");
        $markAllAction = data_get($data, "routes.markAllRead");

        $preferencesHref =
            data_get($data, "routes.preferences") ??
            data_get($data, "routes.settings");

        $realtimeEnabled = (bool) data_get($data, "realtimeEnabled", false);
        $realtimeAuthUrl = data_get($data, "routes.realtimeAuth");
        $userId = data_get($data, "userId");

        /*
        |--------------------------------------------------------------------------
        | Route Fallbacks
        |--------------------------------------------------------------------------
        */

        $resolvedIndexHref =
            $indexHref ??
            self::routeIfAvailable("notifications.index", default: "#");

        $resolvedMarkAllAction =
            $markAllAction ??
            self::routeIfAvailable("notifications.mark-all-read");

        $resolvedPreferencesHref =
            $preferencesHref ??
            self::routeIfAvailable("notifications.preferences");

        $resolvedRealtimeAuthUrl =
            $realtimeAuthUrl ??
            self::routeIfAvailable("notifications.realtime.auth");

        $resolvedDismissRouteTemplate = self::dismissRouteTemplate();

        /*
        |--------------------------------------------------------------------------
        | Notification State
        |--------------------------------------------------------------------------
        */

        $notificationItems = collect($notifications)->values();
        $isUnread = self::unreadResolver();

        $resolvedUnreadCount = !is_null($unreadCount)
            ? (int) $unreadCount
            : $notificationItems->filter($isUnread)->count();

        $resolvedActiveFilter = in_array($activeFilter, ["unread", "all"], true)
            ? $activeFilter
            : "unread";

        $totalCount = $notificationItems->count();

        $triggerText =
            $resolvedUnreadCount > 0
                ? "{$resolvedUnreadCount} unread notifications"
                : "No unread notifications";

        $summaryText = self::summaryText(
            unreadCount: $resolvedUnreadCount,
            totalCount: $totalCount,
        );

        /*
        |--------------------------------------------------------------------------
        | Notification Grouping
        |--------------------------------------------------------------------------
        */

        $allGroups = $notificationItems->groupBy(
            static fn($notification) => self::resolveGroupLabel($notification),
        );

        $unreadGroups = $notificationItems
            ->filter($isUnread)
            ->groupBy(
                static fn($notification) => self::resolveGroupLabel(
                    $notification,
                ),
            );

        $filterPanels = [
            "unread" => [
                "label" => "Unread",
                "count" => $resolvedUnreadCount,
                "tab_id" => $unreadTabId,
                "panel_id" => $unreadPanelId,
                "groups" => $unreadGroups,
                "empty" => "No unread notifications.",
            ],
            "all" => [
                "label" => "All",
                "count" => $totalCount,
                "tab_id" => $allTabId,
                "panel_id" => $allPanelId,
                "groups" => $allGroups,
                "empty" => "No notifications.",
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | View Data
        |--------------------------------------------------------------------------
        */

        return [
            "id" => $id,
            "entryKey" => $entryKey,
            "moduleKey" => $moduleKey,
            "label" => $label,
            "iconName" => $iconName,
            "open" => $open,

            "panelId" => $panelId,
            "panelTitleId" => $panelTitleId,
            "panelSummaryId" => $panelSummaryId,
            "unreadTabId" => $unreadTabId,
            "allTabId" => $allTabId,
            "unreadPanelId" => $unreadPanelId,
            "allPanelId" => $allPanelId,

            "notifications" => $notifications,
            "notificationItems" => $notificationItems,
            "unreadCount" => $unreadCount,
            "activeFilter" => $activeFilter,
            "showMarkAllAsRead" => $showMarkAllAsRead,
            "markAllLabel" => $markAllLabel,

            "indexHref" => $indexHref,
            "markAllAction" => $markAllAction,
            "preferencesHref" => $preferencesHref,
            "realtimeEnabled" => $realtimeEnabled,
            "realtimeAuthUrl" => $realtimeAuthUrl,
            "userId" => $userId,

            "resolvedIndexHref" => $resolvedIndexHref,
            "resolvedMarkAllAction" => $resolvedMarkAllAction,
            "resolvedPreferencesHref" => $resolvedPreferencesHref,
            "resolvedRealtimeAuthUrl" => $resolvedRealtimeAuthUrl,
            "resolvedDismissRouteTemplate" => $resolvedDismissRouteTemplate,

            "isUnread" => $isUnread,
            "resolvedUnreadCount" => $resolvedUnreadCount,
            "resolvedActiveFilter" => $resolvedActiveFilter,
            "totalCount" => $totalCount,
            "triggerText" => $triggerText,
            "summaryText" => $summaryText,

            "allGroups" => $allGroups,
            "unreadGroups" => $unreadGroups,
            "filterPanels" => $filterPanels,

            "toastKinds" => self::toastKinds(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Route Helpers
    |--------------------------------------------------------------------------
    */

    private static function routeIfAvailable(
        string $name,
        mixed $parameters = [],
        ?string $default = null,
    ): ?string {
        if (!Route::has($name)) {
            return $default;
        }

        try {
            return route($name, $parameters);
        } catch (\Throwable) {
            return $default;
        }
    }

    private static function dismissRouteTemplate(): ?string
    {
        if (!Route::has("notifications.dismiss")) {
            return null;
        }

        try {
            return route("notifications.dismiss", "__NOTIFICATION_ID__");
        } catch (\Throwable) {
            return null;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Notification State Helpers
    |--------------------------------------------------------------------------
    */

    private static function unreadResolver(): \Closure
    {
        return static function ($notification): bool {
            if (!is_null(data_get($notification, "unread"))) {
                return (bool) data_get($notification, "unread");
            }

            return !(bool) data_get($notification, "read", false);
        };
    }

    private static function summaryText(
        int $unreadCount,
        int $totalCount,
    ): string {
        $summary = match (true) {
            $unreadCount === 0 => "No unread notifications",
            $unreadCount === 1 => "1 unread notification",
            default => "{$unreadCount} unread notifications",
        };

        if ($totalCount > 0) {
            $summary .= " across your latest updates";
        }

        return $summary;
    }

    private static function resolveGroupLabel(mixed $notification): string
    {
        $explicitGroup =
            data_get($notification, "group") ??
            data_get($notification, "section");

        if (filled($explicitGroup)) {
            return (string) $explicitGroup;
        }

        $date =
            data_get($notification, "created_at") ??
            (data_get($notification, "date") ?? null);

        if (!$date) {
            return "Earlier";
        }

        try {
            $created = Carbon::parse($date);
            $now = Carbon::now();

            if ($created->isToday()) {
                return "Today";
            }

            if ($created->isYesterday()) {
                return "Yesterday";
            }

            if ($created->greaterThanOrEqualTo($now->copy()->startOfWeek())) {
                return $created->format("l");
            }

            return $created->format("M j, Y");
        } catch (\Throwable) {
            return "Earlier";
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Toast Helpers
    |--------------------------------------------------------------------------
    */

    private static function toastKinds(): array
    {
        return [
            "error",
            "success",
            "warning",
            "warning-alt",
            "info",
            "info-square",
        ];
    }
}
