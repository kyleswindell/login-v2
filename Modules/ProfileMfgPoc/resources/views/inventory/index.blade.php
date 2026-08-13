{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/inventory/index.blade.php
    Purpose: Read-only finished-goods inventory and reconciliation workspace.
    ========================================================================== --}}

<x-layouts.app
    header-variant="workspace"
    :grid="false"
    :reserve-page-tabs="false"
    title="Finished-goods inventory"
    page-title="Finished-goods inventory"
    :page-subtitle="'Physical box stock, system balances, and demand through '.$schedule_end_label.'.'"
    brand-name="Profile Mfg"
    header-label="Profile Mfg"
    side-nav-area-title="Profile Mfg"
    :side-nav-expanded="false"
    :side-nav-fixed="false"
>
    <x-slot:pageActions>
        <x-ui.button
            kind="secondary"
            :href="route('profile-mfg.scanning.index')"
            wire:navigate
        >
            View scan activity
        </x-ui.button>
    </x-slot:pageActions>

    <x-slot:sidebar>
        @include('profile-mfg-poc::partials.sidebar')
    </x-slot:sidebar>

    <div class="space-y-6">
        @include('profile-mfg-poc::partials.preview-banner')

        <x-ui.notification.inline
            kind="info"
            title="Two inventory views are kept visible"
            subtitle="Serialized boxes are treated as the physical finished-goods signal for this POC. The aggregate system balance remains alongside it so employees can identify loose-piece or transaction differences instead of hiding them."
            low-contrast
            hide-close-button
        />

        <x-patterns.dashboard-grid columns="4" aria-label="Inventory summary">
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'Two-week demand',
                'value' => number_format($inventory_summary['demand_through_schedule']),
                'supportingText' => 'Pieces due through '.$schedule_end_label,
            ])
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'Serialized finished goods',
                'value' => number_format($inventory_summary['serialized_boxes']).' boxes',
                'supportingText' => number_format($inventory_summary['serialized_full_box_pieces']).' full-box pieces',
            ])
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'System part balance',
                'value' => number_format($inventory_summary['system_balance']),
                'supportingText' => 'Aggregate pieces across supplied parts',
            ])
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'Needs review',
                'value' => number_format($inventory_summary['review_count']).' parts',
                'supportingText' => 'Short, conflicting, or missing coverage signals',
                'status' => $inventory_summary['review_count'] > 0 ? 'Review before shipping' : null,
                'statusTone' => 'warning',
            ])
        </x-patterns.dashboard-grid>

        @include('profile-mfg-poc::partials.inventory-table', [
            'parts' => $inventory,
            'showToolbar' => true,
        ])
    </div>
</x-layouts.app>
