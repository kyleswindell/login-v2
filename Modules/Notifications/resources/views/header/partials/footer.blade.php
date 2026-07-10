{{-- ==========================================================================
    File: Modules/Notifications/resources/views/header/partials/footer.blade.php
    Purpose: Notifications popover footer links.

    Notes:
    - Renders the optional View all link and notification preferences link.
    - Footer renders nothing when neither destination is available.
    - This partial assumes notification state has been normalized by
      header/action.blade.php.
    ========================================================================== --}}

@if ($resolvedIndexHref !== "#" || $resolvedPreferencesHref)
    <footer class="ui-shell-notifications-menu__footer">
        @if ($resolvedIndexHref !== "#")
            <a
                href="{{ $resolvedIndexHref }}"
                wire:navigate
                class="ui-link ui-shell-notifications-menu__view-all"
                data-notification-index-link
            >
                View all
            </a>
        @endif

        @if ($resolvedPreferencesHref)
            <a
                href="{{ $resolvedPreferencesHref }}"
                wire:navigate
                class="ui-shell-notifications-menu__preferences"
                aria-label="Notification preferences"
                data-notification-preferences-link
            >
                <x-ui.icon
                    name="settings"
                    width="16"
                    height="16"
                    aria-hidden="true"
                    focusable="false"
                />
            </a>
        @endif
    </footer>
@endif
