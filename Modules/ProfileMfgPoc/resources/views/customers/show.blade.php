{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/customers/show.blade.php
    Purpose: Read-only customer shipping, demand, part, and contact context.
    ========================================================================== --}}

<x-layouts.app
    header-variant="workspace"
    :grid="false"
    :reserve-page-tabs="false"
    :title="$customer['name']"
    :page-title="$customer['name']"
    page-subtitle="Shipping instructions, expected ship dates, linked parts, and customer contacts."
    brand-name="Profile Mfg"
    header-label="Profile Mfg"
    side-nav-area-title="Profile Mfg"
    :side-nav-expanded="false"
    :side-nav-fixed="false"
>
    <x-slot:pageActions>
        <x-ui.button kind="primary" disabled>Edit customer — Preview</x-ui.button>
    </x-slot:pageActions>

    <x-slot:sidebar>
        @include('profile-mfg-poc::partials.sidebar')
    </x-slot:sidebar>

    <div class="space-y-6">
        @include('profile-mfg-poc::partials.preview-banner')

        <div class="flex flex-wrap items-center gap-3">
            @include('profile-mfg-poc::partials.status-tag', ['status' => $customer['status']])
            <span class="text-sm ui-platform-text-muted">Customer ID {{ $customer['id'] }}</span>
        </div>

        <x-ui.notification.inline
            kind="info"
            title="Shipping instructions"
            :subtitle="$customer['shipping_instructions'] ?: 'No shipping instructions were supplied.'"
            low-contrast
            hide-close-button
        />

        <x-patterns.dashboard-grid columns="4" aria-label="Customer shipping summary">
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'Open orders',
                'value' => number_format($customer['metrics']['open_orders']),
                'supportingText' => 'Open and shorted customer orders',
            ])
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'Past due',
                'value' => number_format($customer['metrics']['past_due_demand']),
                'supportingText' => 'Remaining pieces before '.$snapshot_label,
                'status' => $customer['metrics']['past_due_demand'] > 0 ? 'Attention' : null,
                'statusTone' => 'danger',
            ])
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'Two-week demand',
                'value' => number_format($customer['metrics']['demand_through_schedule']),
                'supportingText' => 'Pieces due through '.$schedule_end_label,
            ])
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'Next ship date',
                'value' => $customer['metrics']['nearest_ship_date'] ?? '—',
                'supportingText' => 'Earliest open customer order',
            ])
        </x-patterns.dashboard-grid>

        @include('profile-mfg-poc::partials.shipping-schedule-table', [
            'parts' => $customer['shipping_schedule'],
            'dates' => $schedule_dates,
            'title' => 'Customer shipping schedule',
            'description' => 'Remaining pieces by expected ship date for this customer, followed by the forward planning horizon.',
            'showCustomer' => false,
        ])

        @include('profile-mfg-poc::partials.orders-table', [
            'orders' => $customer['orders'],
            'title' => 'Open orders',
            'description' => 'Open and shorted orders ordered by expected ship date.',
            'showPart' => true,
            'showCompleted' => true,
            'showSchedule' => true,
            'emptyText' => 'No open order context was supplied.',
        ])

        @include('profile-mfg-poc::partials.parts-table', [
            'parts' => $customer['parts'],
            'title' => 'Associated parts',
            'description' => 'All supplied part definitions for this customer, including parts without current demand.',
            'showCustomer' => false,
            'emptyText' => 'No linked parts were supplied.',
        ])

        <x-patterns.dashboard-grid columns="3">
            <x-patterns.content-section-block title="Primary contact">
                <x-patterns.key-value-display :columns="1" :items="[
                    ['label' => 'Name', 'value' => $customer['primary_contact']['name'] ?? '—'],
                    ['label' => 'Email', 'value' => $customer['primary_contact']['email'] ?? '—'],
                    ['label' => 'Phone', 'value' => $customer['primary_contact']['phone'] ?? '—'],
                    ['label' => 'Fax', 'value' => $customer['primary_contact']['fax'] ?? '—'],
                ]" />
            </x-patterns.content-section-block>

            <x-patterns.content-section-block title="Billing address">
                <x-patterns.key-value-display
                    :columns="1"
                    :items="collect($customer['billing_address'] ?? [])->map(fn ($value, $label) => [
                        'label' => str_replace('_', ' ', ucfirst($label)),
                        'value' => $value ?? '—',
                    ])->values()"
                />
            </x-patterns.content-section-block>

            <x-patterns.content-section-block title="Shipping address">
                <x-patterns.key-value-display
                    :columns="1"
                    :items="collect($customer['shipping_address'] ?? [])->map(fn ($value, $label) => [
                        'label' => str_replace('_', ' ', ucfirst($label)),
                        'value' => $value ?? '—',
                    ])->values()"
                />
            </x-patterns.content-section-block>
        </x-patterns.dashboard-grid>

        @include('profile-mfg-poc::partials.additional-information', ['fields' => $customer['additional_fields'] ?? []])
    </div>
</x-layouts.app>
