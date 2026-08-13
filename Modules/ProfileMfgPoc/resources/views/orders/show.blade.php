{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/orders/show.blade.php
    Purpose: Read-only order fulfillment, packing, shipping, and stock context.
    ========================================================================== --}}

<x-layouts.app
    header-variant="workspace"
    :grid="false"
    :reserve-page-tabs="false"
    :title="$order['id']"
    :page-title="$order['id']"
    :page-subtitle="($part['internal_part_number'] ?? 'Part not supplied').' · '.$customer['name']"
    brand-name="Profile Mfg"
    header-label="Profile Mfg"
    side-nav-area-title="Profile Mfg"
    :side-nav-expanded="false"
    :side-nav-fixed="false"
>
    <x-slot:pageActions>
        <x-ui.button kind="secondary" disabled>Edit order — Preview</x-ui.button>
        <x-ui.button kind="primary" disabled>Close / short order — Preview</x-ui.button>
    </x-slot:pageActions>

    <x-slot:sidebar>
        @include('profile-mfg-poc::partials.sidebar')
    </x-slot:sidebar>

    <div class="space-y-6">
        @include('profile-mfg-poc::partials.preview-banner')

        <div class="flex flex-wrap items-center gap-3">
            @include('profile-mfg-poc::partials.status-tag', ['status' => $order['status']])
            @include('profile-mfg-poc::partials.schedule-tag', ['state' => $order['schedule_state']])
            @include('profile-mfg-poc::partials.coverage-tag', ['state' => $part['inventory_metrics']['coverage_state']])
            <x-ui.link
                :href="route('profile-mfg.customers.show', $customer['id'])"
                :text="$customer['name']"
                variant="standalone"
                size="sm"
                navigate
            />
            <x-ui.link
                :href="route('profile-mfg.parts.show', $part['id'])"
                :text="$part['internal_part_number'] ?? '—'"
                variant="standalone"
                size="sm"
                navigate
            />
        </div>

        <x-ui.notification.inline
            kind="info"
            title="Customer shipping instructions"
            :subtitle="$customer['shipping_instructions'] ?: 'No shipping instructions were supplied.'"
            low-contrast
            hide-close-button
        />

        <x-patterns.dashboard-grid columns="4" aria-label="Order fulfillment summary">
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'Ordered',
                'value' => number_format($order['original_quantity']),
                'supportingText' => 'Pieces on the customer order',
            ])
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'Recorded shipped',
                'value' => number_format($order['completed_quantity']),
                'supportingText' => 'Original quantity minus remaining quantity',
            ])
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'Remaining',
                'value' => number_format($order['remaining_quantity']),
                'supportingText' => 'Pieces still expected to ship',
            ])
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'Expected ship date',
                'value' => $order['ship_date_label'],
                'supportingText' => 'Evaluated against '.$snapshot_label,
                'status' => match ($order['schedule_state']) {
                    'past_due' => 'Past due',
                    'due_today' => 'Due today',
                    'due_this_week' => 'Due this week',
                    'next_week' => 'Next week',
                    'complete' => 'Complete',
                    'cancelled' => 'Cancelled',
                    default => 'Upcoming',
                },
                'statusTone' => match ($order['schedule_state']) {
                    'past_due' => 'danger',
                    'due_today' => 'notice',
                    'due_this_week' => 'warning',
                    'complete' => 'success',
                    default => 'neutral',
                },
            ])
        </x-patterns.dashboard-grid>

        <x-patterns.dashboard-grid columns="2">
            <x-patterns.content-section-block title="Order and packing">
                <x-patterns.key-value-display :columns="2" :items="[
                    ['label' => 'Order ID', 'value' => $order['id']],
                    ['label' => 'Customer', 'value' => $customer['name']],
                    ['label' => 'Internal part number', 'value' => $part['internal_part_number'] ?? '—'],
                    ['label' => 'Customer part number', 'value' => $part['customer_part_number'] ?? '—'],
                    ['label' => 'Expected ship date', 'value' => $order['ship_date_label']],
                    ['label' => 'B/P date and level', 'value' => $part['blueprint_revision'] ?? '—'],
                    ['label' => 'Pieces per box', 'value' => $part['pieces_per_box'] ?? '—'],
                    ['label' => 'Full boxes', 'value' => $order['pack_plan']['full_boxes'] ?? '—'],
                    ['label' => 'Loose pieces', 'value' => $order['pack_plan']['loose_pieces'] ?? '—'],
                    ['label' => 'Containers required', 'value' => $order['pack_plan']['boxes_required'] ?? '—'],
                ]" />
            </x-patterns.content-section-block>

            <x-patterns.content-section-block
                title="Finished-goods context"
                description="Both existing inventory signals remain visible. No stock is allocated or changed in this POC."
            >
                <x-patterns.key-value-display :columns="2" :items="[
                    ['label' => 'System part balance', 'value' => $part['inventory_metrics']['system_balance'] ?? '—'],
                    ['label' => 'Serialized boxes', 'value' => $part['inventory_metrics']['serialized_boxes'] ?? '—'],
                    ['label' => 'Serialized full-box pieces', 'value' => $part['inventory_metrics']['serialized_full_box_pieces'] ?? '—'],
                    ['label' => 'Two-week part demand', 'value' => number_format($part['metrics']['demand_through_schedule'])],
                    ['label' => 'All open part demand', 'value' => number_format($part['metrics']['open_demand'])],
                    ['label' => 'Last inventory scan', 'value' => $part['inventory_metrics']['last_scan_label'] ?? '—'],
                ]" />
            </x-patterns.content-section-block>
        </x-patterns.dashboard-grid>

        <x-patterns.content-section-block title="Order notes">
            <p class="text-sm leading-6 ui-platform-text">{{ $order['notes'] ?: '—' }}</p>
        </x-patterns.content-section-block>

        @include('profile-mfg-poc::partials.orders-table', [
            'orders' => $part['orders'],
            'title' => 'Other open orders for this part',
            'description' => 'Open demand sharing the same finished-goods inventory signals.',
            'showCustomer' => false,
            'showPart' => false,
            'showCompleted' => true,
            'showSchedule' => true,
            'emptyText' => 'No other open order context was supplied.',
        ])

        @include('profile-mfg-poc::partials.additional-information', ['fields' => $order['additional_fields'] ?? []])
    </div>
</x-layouts.app>
