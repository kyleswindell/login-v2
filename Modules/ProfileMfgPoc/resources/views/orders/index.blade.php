{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/orders/index.blade.php
    Purpose: Read-only customer order and shipping-demand directory.
    ========================================================================== --}}

<x-layouts.app
    header-variant="workspace"
    :grid="false"
    :reserve-page-tabs="false"
    title="Orders"
    page-title="Orders"
    page-subtitle="Customer order quantities, expected ship dates, and fulfillment status."
    brand-name="Profile Mfg"
    header-label="Profile Mfg"
    side-nav-area-title="Profile Mfg"
    :side-nav-expanded="false"
    :side-nav-fixed="false"
>
    <x-slot:pageActions>
        <x-ui.button kind="primary" disabled>Create order — Preview</x-ui.button>
    </x-slot:pageActions>

    <x-slot:sidebar>
        @include('profile-mfg-poc::partials.sidebar')
    </x-slot:sidebar>

    <div class="space-y-6">
        @include('profile-mfg-poc::partials.preview-banner')

        <x-patterns.dashboard-grid columns="4" aria-label="Order shipping summary">
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'Open orders',
                'value' => number_format($orders_summary['open']),
                'supportingText' => number_format($orders_summary['open_demand']).' remaining pieces',
            ])
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'Past due',
                'value' => number_format($orders_summary['past_due_demand']),
                'supportingText' => number_format($orders_summary['past_due']).' '.str('order')->plural($orders_summary['past_due']).' before '.$snapshot_label,
                'status' => $orders_summary['past_due'] > 0 ? 'Requires recovery plan' : null,
                'statusTone' => 'danger',
            ])
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'Ship today',
                'value' => number_format($orders_summary['ship_today_demand']),
                'supportingText' => number_format($orders_summary['due_today']).' '.str('order')->plural($orders_summary['due_today']).' due '.$snapshot_label,
                'status' => $orders_summary['due_today'] > 0 ? 'Today' : null,
                'statusTone' => 'notice',
            ])
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'Shorted orders',
                'value' => number_format($orders_summary['shorted']),
                'supportingText' => 'Open orders recorded with a supply exception',
                'status' => $orders_summary['shorted'] > 0 ? 'Review inventory' : null,
                'statusTone' => 'warning',
            ])
        </x-patterns.dashboard-grid>

        @include('profile-mfg-poc::partials.orders-table', [
            'orders' => $orders,
            'title' => 'Customer orders',
            'description' => 'All supplied orders. Due date is presented as the expected ship date used by the current workflow.',
            'showCustomer' => true,
            'showPart' => true,
            'showCompleted' => true,
            'showSchedule' => true,
            'showToolbar' => true,
        ])
    </div>
</x-layouts.app>
