{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/partials/sidebar.blade.php
    Purpose: Profile Mfg POC workspace navigation and future previews.
    ========================================================================== --}}

<x-shell.side-nav.header>
    <span data-app-sidebar-area-title>Operations workspace</span>
</x-shell.side-nav.header>

<x-shell.side-nav.items>
    <x-layouts.app.frame.nav-link
        :href="route('profile-mfg.dashboard')"
        :current="request()->routeIs('profile-mfg.dashboard')"
        icon="activity"
    >
        Dashboard
    </x-layouts.app.frame.nav-link>

    <x-layouts.app.frame.nav-link
        :href="route('profile-mfg.shipping-schedule')"
        :current="request()->routeIs('profile-mfg.shipping-schedule')"
        icon="calendar"
    >
        Shipping schedule
    </x-layouts.app.frame.nav-link>

    <x-layouts.app.frame.nav-link
        :href="route('profile-mfg.orders.index')"
        :current="request()->routeIs('profile-mfg.orders.*')"
        icon="delivery"
    >
        Orders
    </x-layouts.app.frame.nav-link>

    <x-layouts.app.frame.nav-link
        :href="route('profile-mfg.inventory.index')"
        :current="request()->routeIs('profile-mfg.inventory.*')"
        icon="inventory-management"
    >
        Inventory
    </x-layouts.app.frame.nav-link>

    <x-layouts.app.frame.nav-link
        :href="route('profile-mfg.scanning.index')"
        :current="request()->routeIs('profile-mfg.scanning.*')"
        icon="barcode"
    >
        Scan activity
    </x-layouts.app.frame.nav-link>

    <x-layouts.app.frame.nav-link
        :href="route('profile-mfg.customers.index')"
        :current="request()->routeIs('profile-mfg.customers.*')"
        icon="group"
    >
        Customers
    </x-layouts.app.frame.nav-link>

    <x-layouts.app.frame.nav-link
        :href="route('profile-mfg.parts.index')"
        :current="request()->routeIs('profile-mfg.parts.*')"
        icon="product"
    >
        Parts
    </x-layouts.app.frame.nav-link>

    <x-layouts.app.frame.nav-link
        :href="route('profile-mfg.reports.index')"
        :current="request()->routeIs('profile-mfg.reports.*')"
        icon="report--data"
    >
        Reports
    </x-layouts.app.frame.nav-link>

    <x-shell.side-nav.divider />

    @foreach (["Scan in / ship out", "Inventory adjustments"] as $destination)
        <x-shell.side-nav.link
            as="button"
            disabled
            aria-disabled="true"
            :tab-index="-1"
        >
            {{ $destination }} — Future preview
        </x-shell.side-nav.link>
    @endforeach

    <x-shell.side-nav.divider />

    <x-shell.side-nav.menu title="Account & admin">
        <x-shell.side-nav.menu-item
            :href="route('platform.account.index')"
            :current="
                request()->routeIs(
            'platform.account.index',
            'platform.account.security',
            'platform.account.mfa.*',
        )
            "
            wire-navigate
        >
            My profile
        </x-shell.side-nav.menu-item>

        <x-shell.side-nav.menu-item
            :href="route('platform.account.preferences')"
            :current="request()->routeIs('platform.account.preferences')"
            wire-navigate
        >
            Preferences
        </x-shell.side-nav.menu-item>

        <x-shell.side-nav.menu-item
            :href="route('platform.account.notifications')"
            :current="request()->routeIs('platform.account.notifications')"
            wire-navigate
        >
            Notifications
        </x-shell.side-nav.menu-item>

        @can ("view-platform-users")
            <x-shell.side-nav.menu-item
                as="button"
                disabled
                aria-disabled="true"
                tabindex="-1"
            >
                Employees and access — Future preview
            </x-shell.side-nav.menu-item>
        @endcan

        @can ("view-platform-settings")
            <x-shell.side-nav.menu-item
                :href="route('profile-mfg.settings.index')"
                :current="request()->routeIs('profile-mfg.settings.*')"
                wire-navigate
            >
                Application settings
            </x-shell.side-nav.menu-item>
        @endcan
    </x-shell.side-nav.menu>
</x-shell.side-nav.items>
