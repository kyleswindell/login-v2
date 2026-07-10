{{-- ==========================================================================
    File: Modules/Account/resources/views/header/partials/profile.blade.php
    Purpose: Account header profile summary.
========================================================================== --}}

<div class="ui-shell-account-menu__profile">
    <span
        class="ui-shell-account-menu__avatar ui-shell-account-menu__avatar--large"
        aria-hidden="true"
    >
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

    <div class="ui-shell-account-menu__profile-text">
        <p class="ui-shell-account-menu__profile-name">
            {{ $name }}
        </p>

        @if ($email)
            <p class="ui-shell-account-menu__profile-email">
                {{ $email }}
            </p>
        @endif
    </div>
</div>
