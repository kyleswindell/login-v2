{{-- ==========================================================================
    File: Modules/Notifications/resources/views/header/partials/panel-header.blade.php
    Purpose: Notifications popover panel header.

    Notes:
    - Renders the notification panel title, summary, and optional mark-all form.
    - Mark-all state is synchronized by the Notifications module runtime.
    - This partial assumes notification state has been normalized by
      header/action.blade.php.
    ========================================================================== --}}

<header class="ui-shell-notifications-menu__header">
    {{-- ------------------------------------------------------------------
        Panel heading
        ------------------------------------------------------------------ --}}

    <div class="ui-shell-notifications-menu__heading">
        <h2 id="{{ $panelTitleId }}" class="ui-shell-notifications-menu__title">
            Notifications
        </h2>

        <p
            id="{{ $panelSummaryId }}"
            class="ui-shell-notifications-menu__summary"
            data-notification-panel-summary
        >
            {{ $summaryText }}
        </p>
    </div>

    {{-- ------------------------------------------------------------------
        Mark all as read
        ------------------------------------------------------------------ --}}

    @if ($showMarkAllAsRead && $resolvedMarkAllAction)
        <form
            method="POST"
            action="{{ $resolvedMarkAllAction }}"
            class="ui-shell-notifications-menu__mark-all-form"
            data-notification-mark-all-form
        >
            @csrf

            <button
                type="submit"
                class="ui-shell-notifications-menu__mark-all"
                @disabled ($resolvedUnreadCount < 1)
                data-app-notifications-mark-all-read
                data-notification-mark-all
                data-notification-mark-all-enabled="{{ $resolvedUnreadCount > 0 ? 'true' : 'false' }}"
            >
                {{ $markAllLabel }}
            </button>
        </form>
    @endif
</header>
