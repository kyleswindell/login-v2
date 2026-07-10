{{-- ==========================================================================
    File: Modules/Notifications/resources/views/header/partials/notification-row.blade.php
    Purpose: Notifications popover notification row.

    Notes:
    - Renders one notification as a contained-list item.
    - Supports linked notification rows and button-style local rows.
    - Keeps dismiss controls in a separate contained-list item action region.
    - Row dismiss motion is owned by the Motion element through
      data-ui-motion="row-dismiss".
    - This partial assumes notification state has been normalized by
      header/action.blade.php.
    ========================================================================== --}}

@php
    /*
    |--------------------------------------------------------------------------
    | Notification Row State
    |--------------------------------------------------------------------------
    */

    $notificationPersistedId = data_get($notification, 'id');

    $notificationId = $notificationPersistedId
        ?? "{$filterValue}-{$groupIndex}-{$rowIndex}";

    $notificationTitle = data_get($notification, 'title')
        ?? 'Notification';

    $notificationSubtitle = data_get($notification, 'subtitle')
        ?? data_get($notification, 'body')
        ?? data_get($notification, 'message')
        ?? null;

    $notificationTime = data_get($notification, 'time')
        ?? data_get($notification, 'created_label')
        ?? null;

    $notificationKind = data_get($notification, 'kind') ?? 'info';

    $notificationHref = data_get($notification, 'href')
        ?? data_get($notification, 'url')
        ?? null;

    $notificationDismissUrl = data_get($notification, 'dismiss_url')
        ?? data_get($notification, 'dismissUrl')
        ?? data_get($notification, 'routes.dismiss')
        ?? null;

    if (! $notificationDismissUrl && $resolvedDismissRouteTemplate && filled($notificationPersistedId)) {
        $notificationDismissUrl = str_replace(
            '__NOTIFICATION_ID__',
            rawurlencode((string) $notificationPersistedId),
            $resolvedDismissRouteTemplate
        );
    }

    $notificationUnread = $isUnread($notification);

    $statusInfo = in_array($notificationKind, ['info', 'info-square', 'notice'], true);
    $statusWarning = in_array($notificationKind, ['warning', 'warning-alt'], true);
    $statusError = in_array($notificationKind, ['error', 'danger'], true);
@endphp

<li
    @class ([
        "ui-contained-list-item",
        "ui-contained-list-item-with-actions",
        "ui-contained-list-status-info" => $statusInfo,
        "ui-contained-list-status-success" => $notificationKind === "success",
        "ui-contained-list-status-warning" => $statusWarning,
        "ui-contained-list-status-error" => $statusError,
        "ui-shell-notification-row",
        "ui-shell-notification-row--unread" => $notificationUnread,
        "ui-shell-notification-row--{$notificationKind}" => filled(
            $notificationKind
        )
    ])
    data-ui-component="contained-list-item"
    data-ui-contained-list-item
    data-ui-contained-list-item-interactive="true"
    data-ui-contained-list-item-status="{{ $notificationKind }}"
    data-ui-contained-list-item-actions="true"
    data-ui-selected="false"
    data-ui-current="false"
    data-ui-disabled="false"
    data-ui-motion="row-dismiss"
    data-app-notification-row
    data-app-notification-id="{{ $notificationId }}"
    data-app-notification-unread="{{ $notificationUnread ? 'true' : 'false' }}"
    data-app-notification-dismiss-url="{{ $notificationDismissUrl }}"
    data-notification-preview-item
    data-notification-preview-item-unread="{{ $notificationUnread ? 'true' : 'false' }}"
    data-notification-id="{{ $notificationId }}"
>
    {{-- ------------------------------------------------------------------
        Row content
        ------------------------------------------------------------------ --}}

    @if ($notificationHref)
        <a
            href="{{ $notificationHref }}"
            class="ui-contained-list-item-content ui-shell-notification-row__main"
            @if (data_get($notification, "wireNavigate")) wire:navigate @endif
        >
            <span
                class="ui-contained-list-item-icon ui-shell-notification-row__status"
                @if ($notificationUnread) data-notification-preview-unread @endif
                data-notification-preview-severity="{{ $notificationKind }}"
                aria-hidden="true"
            ></span>

            <span
                class="ui-contained-list-item-text ui-shell-notification-row__content"
            >
                @if ($notificationTime)
                    <span
                        class="ui-contained-list-item-meta ui-shell-notification-row__meta"
                    >
                        {{ $notificationTime }}
                    </span>
                @endif

                <span
                    class="ui-contained-list-item-title ui-shell-notification-row__title"
                >
                    {{ $notificationTitle }}
                </span>

                @if ($notificationSubtitle)
                    <span
                        class="ui-contained-list-item-description ui-shell-notification-row__subtitle"
                    >
                        {{ $notificationSubtitle }}
                    </span>
                @endif
            </span>
        </a>
    @else
        <button
            type="button"
            class="ui-contained-list-item-content ui-shell-notification-row__main"
            data-app-notification-open
        >
            <span
                class="ui-contained-list-item-icon ui-shell-notification-row__status"
                @if ($notificationUnread) data-notification-preview-unread @endif
                data-notification-preview-severity="{{ $notificationKind }}"
                aria-hidden="true"
            ></span>

            <span
                class="ui-contained-list-item-text ui-shell-notification-row__content"
            >
                @if ($notificationTime)
                    <span
                        class="ui-contained-list-item-meta ui-shell-notification-row__meta"
                    >
                        {{ $notificationTime }}
                    </span>
                @endif

                <span
                    class="ui-contained-list-item-title ui-shell-notification-row__title"
                >
                    {{ $notificationTitle }}
                </span>

                @if ($notificationSubtitle)
                    <span
                        class="ui-contained-list-item-description ui-shell-notification-row__subtitle"
                    >
                        {{ $notificationSubtitle }}
                    </span>
                @endif
            </span>
        </button>
    @endif

    {{-- ------------------------------------------------------------------
        Row actions
        ------------------------------------------------------------------ --}}

    <span
        class="ui-contained-list-item-actions ui-shell-notification-row__actions"
    >
        <x-ui.icon-button
            type="button"
            icon="close"
            kind="ghost"
            size="sm"
            label="Dismiss {{ $notificationTitle }}"
            class="ui-shell-notification-row__dismiss"
            data-app-notification-dismiss
            data-app-notification-dismiss-url="{{ $notificationDismissUrl }}"
        />
    </span>
</li>
