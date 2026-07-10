{{-- ==========================================================================
    File: Modules/Notifications/resources/views/header/partials/trigger.blade.php
    Purpose: Notifications header trigger button.

    Notes:
    - Renders the notification bell global action trigger.
    - Exposes unread count state for the Notifications module runtime.
    - The surrounding x-ui.popover is rendered by header/action.blade.php.
    - This partial assumes notification state has been normalized by
      header/action.blade.php.
    ========================================================================== --}}

{{-- ----------------------------------------------------------------------
    Header disclosure trigger
    ----------------------------------------------------------------------
    This trigger opens the notification popover panel. The panel contains
    interactive notification content and is exposed as dialog content.
    ---------------------------------------------------------------------- --}}

<button
    type="button"
    class="ui-shell-header__action ui-shell-header__global-action ui-shell-notifications-menu__trigger"
    aria-label="{{ $triggerText }}"
    aria-haspopup="dialog"
    aria-expanded="{{ $open ? 'true' : 'false' }}"
    aria-controls="{{ $panelId }}"
    data-ui-popover-trigger
    data-app-header-notifications-action
    data-header-global-action-key="{{ $entryKey }}"
    data-header-global-action-module="{{ $moduleKey }}"
    data-notification-trigger
    data-notification-trigger-unread="{{ $resolvedUnreadCount > 0 ? 'true' : 'false' }}"
>
    <x-ui.icon
        :name="$iconName"
        width="20"
        height="20"
        aria-hidden="true"
        focusable="false"
    />

    <span class="ui-assistive-text" data-notification-trigger-label>
        {{ $triggerText }}
    </span>

    <span
        @class ([
            "ui-shell-header__notification-badge",
            "hidden" => $resolvedUnreadCount === 0
        ])
        aria-label="{{ $triggerText }}"
        data-notification-trigger-summary
        data-notification-trigger-badge-hidden="{{ $resolvedUnreadCount > 0 ? 'false' : 'true' }}"
    >
        {{ $resolvedUnreadCount }}
    </span>
</button>
