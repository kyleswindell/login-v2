{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/customers/index.blade.php
    Purpose: Read-only Profile Mfg customer directory.
    ========================================================================== --}}

<x-layouts.app
    header-variant="workspace"
    :grid="false"
    :reserve-page-tabs="false"
    title="Customers"
    page-title="Customers"
    page-subtitle="Customer contacts, ship-to context, and the next expected shipment."
    brand-name="Profile Mfg"
    header-label="Profile Mfg"
    side-nav-area-title="Profile Mfg"
    :side-nav-expanded="false"
    :side-nav-fixed="false"
>
    <x-slot:sidebar>
        @include('profile-mfg-poc::partials.sidebar')
    </x-slot:sidebar>

    <div class="space-y-6">
        @include('profile-mfg-poc::partials.preview-banner')
        @include('profile-mfg-poc::partials.customers-table', ['customers' => $customers])
    </div>
</x-layouts.app>
