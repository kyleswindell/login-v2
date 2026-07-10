{{-- ==========================================================================
    File: Modules/Account/resources/views/header/partials/panel.blade.php
    Purpose: Account header popover panel.
========================================================================== --}}

<div
    class="ui-shell-account-menu"
    data-app-account-menu
    data-ui-shell-account-menu
>
    @include('account::header.partials.profile')

    @if ($showTheme)
        @include('account::header.partials.theme-switcher')
    @endif

    @include('account::header.partials.navigation')

    @if ($showLogout)
        @include('account::header.partials.sign-out')
    @endif
</div>
