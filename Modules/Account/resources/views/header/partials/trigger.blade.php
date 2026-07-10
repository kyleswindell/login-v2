{{-- ==========================================================================
    File: Modules/Account/resources/views/header/partials/trigger.blade.php
    Purpose: Account header popover trigger.
========================================================================== --}}

<button
    type="button"
    class="ui-shell-header__action ui-shell-account-menu__trigger"
    aria-label="{{ $label }}"
    aria-haspopup="dialog"
    aria-expanded="{{ $open ? 'true' : 'false' }}"
    aria-controls="{{ $panelId }}"
    data-ui-popover-trigger
    data-header-global-action-key="{{ $entryKey ?? '' }}"
    data-header-global-action-module="{{ $moduleKey ?? '' }}"
>
    <span class="ui-shell-account-menu__avatar" aria-hidden="true">
        @if ($avatarUrl)
            <img
                src="{{ $avatarUrl }}"
                alt=""
                class="ui-shell-account-menu__avatar-image"
            >
        @else
            <span class="ui-shell-account-menu__initials">
                {{ $initials }}
            </span>
        @endif
    </span>

    <span class="ui-shell-account-menu__identity">
        <span class="ui-shell-account-menu__name">
            {{ $name }}
        </span>

        @if ($email)
            <span class="ui-shell-account-menu__email">
                {{ $email }}
            </span>
        @endif
    </span>

    <x-ui.icon name="chevron--down"
        class="ui-shell-account-menu__chevron"
        width="16"
        height="16"
        aria-hidden="true"
        focusable="false"
    />
</button>
