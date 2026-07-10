{{-- ==========================================================================
    File: Modules/Account/resources/views/header/partials/sign-out.blade.php
    Purpose: Account header sign out action.
========================================================================== --}}

@if (\Illuminate\Support\Facades\Route::has($logoutRoute))
    <form
        method="POST"
        action="{{ route($logoutRoute) }}"
        class="ui-shell-account-menu__logout-form"
    >
        @csrf

        <x-ui.button
            type="submit"
            semantic="danger-ghost"
            class="w-full justify-start ui-shell-account-menu__logout"
        >
            Sign out
        </x-ui.button>
    </form>
@endif
