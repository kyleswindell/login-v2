{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/parts/show.blade.php
    Purpose: Read-only part engineering, packaging, inventory, and ship context.
    ========================================================================== --}}

<x-layouts.app
    header-variant="workspace"
    :grid="false"
    :reserve-page-tabs="false"
    :title="$part['internal_part_number'] ?? 'Part detail'"
    :page-title="$part['internal_part_number'] ?? 'Part detail'"
    :page-subtitle="$part['description'] ?? 'Read-only part detail.'"
    brand-name="Profile Mfg"
    header-label="Profile Mfg"
    side-nav-area-title="Profile Mfg"
    :side-nav-expanded="false"
    :side-nav-fixed="false"
>
    <x-slot:pageActions>
        <x-ui.button kind="primary" disabled>Edit part — Preview</x-ui.button>
    </x-slot:pageActions>

    <x-slot:sidebar>
        @include('profile-mfg-poc::partials.sidebar')
    </x-slot:sidebar>

    <div class="space-y-6">
        @include('profile-mfg-poc::partials.preview-banner')

        <div class="flex flex-wrap items-center gap-3">
            @include('profile-mfg-poc::partials.status-tag', ['status' => $part['status']])
            @include('profile-mfg-poc::partials.coverage-tag', ['state' => $part['inventory_metrics']['coverage_state']])
            <x-ui.link
                :href="route('profile-mfg.customers.show', $part['customer']['id'])"
                :text="$part['customer']['name']"
                variant="standalone"
                size="sm"
                navigate
            />
            <span class="text-sm ui-platform-text-muted">Customer part {{ $part['customer_part_number'] ?? '—' }}</span>
        </div>

        <x-patterns.dashboard-grid columns="2">
            <x-patterns.content-section-block
                title="Part image"
                description="Visual identification reference for production, inventory, and shipping staff."
            >
                @if ($part['has_image'])
                    <img
                        src="{{ route('profile-mfg.parts.image', $part['id']) }}"
                        alt="{{ $part['internal_part_number'] ?? $part['customer_part_number'] ?? 'Part' }} profile"
                        class="block max-h-80 w-full object-contain"
                    >
                @else
                    <div class="flex min-h-48 flex-col items-center justify-center gap-3 text-center">
                        <x-ui.icon name="no-image" class="h-12 w-12 ui-platform-text-muted" aria-hidden="true" />
                        <p class="text-sm ui-platform-text-muted">No part image was supplied in this snapshot.</p>
                    </div>
                @endif
            </x-patterns.content-section-block>

            <x-patterns.content-section-block title="Part identification">
                <x-patterns.key-value-display :columns="1" :items="[
                    ['label' => 'Profile Mfg part', 'value' => $part['internal_part_number'] ?? '—'],
                    ['label' => 'Customer part', 'value' => $part['customer_part_number'] ?? '—'],
                    ['label' => 'Description', 'value' => $part['description'] ?? '—'],
                    ['label' => 'Customer', 'value' => $part['customer']['name']],
                    ['label' => 'Program', 'value' => $part['program'] ?? '—'],
                ]" />
            </x-patterns.content-section-block>
        </x-patterns.dashboard-grid>

        @if (in_array($part['inventory_metrics']['coverage_state'], ['short', 'verify', 'unknown'], true))
            <x-ui.notification.inline
                kind="warning"
                title="Inventory review before shipping"
                :subtitle="match ($part['inventory_metrics']['coverage_state']) {
                    'short' => 'Both supplied inventory signals are below demand in the two-week shipping window.',
                    'verify' => 'The system balance and serialized full-box signal do not agree on shipping coverage.',
                    default => 'Enough inventory data was not supplied to determine shipping coverage.',
                }"
                low-contrast
                hide-close-button
            />
        @endif

        <x-patterns.dashboard-grid columns="4" aria-label="Part shipping and inventory summary">
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'System part balance',
                'value' => isset($part['inventory_metrics']['system_balance']) ? number_format($part['inventory_metrics']['system_balance']) : '—',
                'supportingText' => 'Aggregate pieces in the supplied part record',
            ])
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'Serialized finished goods',
                'value' => isset($part['inventory_metrics']['serialized_boxes'])
                    ? number_format($part['inventory_metrics']['serialized_boxes']).' '.str('box')->plural((int) $part['inventory_metrics']['serialized_boxes'])
                    : '—',
                'supportingText' => isset($part['inventory_metrics']['serialized_full_box_pieces']) ? number_format($part['inventory_metrics']['serialized_full_box_pieces']).' full-box pieces' : 'Piece equivalent not available',
            ])
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'Two-week demand',
                'value' => number_format($part['metrics']['demand_through_schedule']),
                'supportingText' => 'Pieces due through '.$schedule_end_label,
            ])
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'Next ship date',
                'value' => $part['metrics']['next_ship_date'] ?? '—',
                'supportingText' => number_format($part['metrics']['open_orders']).' '.str('open order')->plural($part['metrics']['open_orders']).' · '.number_format($part['metrics']['open_demand']).' pieces total',
            ])
        </x-patterns.dashboard-grid>

        @include('profile-mfg-poc::partials.shipping-schedule-table', [
            'parts' => [$part],
            'dates' => $schedule_dates,
            'title' => 'Part shipping schedule',
            'description' => 'Daily remaining demand for the current and next work week, followed by the longer planning horizon.',
        ])

        <x-patterns.dashboard-grid columns="2">
            <x-patterns.content-section-block title="Engineering and production">
                <x-patterns.key-value-display :columns="2" :items="[
                    ['label' => 'Customer part number', 'value' => $part['customer_part_number'] ?? '—'],
                    ['label' => 'Program', 'value' => $part['program'] ?? '—'],
                    ['label' => 'Production line', 'value' => $part['production_line'] ?? '—'],
                    ['label' => 'Material', 'value' => $part['material_description'] ?? '—'],
                    ['label' => 'Piece weight (lb.)', 'value' => $part['weight_lbs_per_piece'] ?? '—'],
                    ['label' => 'B/P date and level', 'value' => $part['blueprint_revision'] ?? '—'],
                    ['label' => 'Part ID', 'value' => $part['id']],
                ]" />
            </x-patterns.content-section-block>

            <x-patterns.content-section-block
                title="Packaging and inventory"
                description="Serialized full-box pieces are calculated as box count × pieces per box; loose pieces are not inferred."
            >
                <x-patterns.key-value-display :columns="2" :items="[
                    ['label' => 'Pieces per box', 'value' => $part['pieces_per_box'] ?? '—'],
                    ['label' => 'System part balance', 'value' => $part['inventory_metrics']['system_balance'] ?? '—'],
                    ['label' => 'Serialized boxes', 'value' => $part['inventory_metrics']['serialized_boxes'] ?? '—'],
                    ['label' => 'Serialized full-box pieces', 'value' => $part['inventory_metrics']['serialized_full_box_pieces'] ?? '—'],
                    ['label' => 'Balance difference', 'value' => $part['inventory_metrics']['balance_difference'] ?? '—'],
                    ['label' => 'Last inventory scan', 'value' => $part['inventory_metrics']['last_scan_label'] ?? '—'],
                ]" />
            </x-patterns.content-section-block>
        </x-patterns.dashboard-grid>

        <x-patterns.dashboard-grid columns="2">
            <x-patterns.content-section-block title="Part notes">
                <p class="text-sm leading-6 ui-platform-text">{{ $part['notes'] ?: '—' }}</p>
            </x-patterns.content-section-block>

            <x-patterns.content-section-block title="Customer shipping context">
                <x-patterns.key-value-display :columns="1" :items="[
                    ['label' => 'Customer', 'value' => $part['customer']['name']],
                    ['label' => 'Shipping instructions', 'value' => $customers_by_id[$part['customer']['id']]['shipping_instructions'] ?? '—'],
                ]" />
            </x-patterns.content-section-block>
        </x-patterns.dashboard-grid>

        @include('profile-mfg-poc::partials.orders-table', [
            'orders' => $part['orders'],
            'title' => 'Open orders for this part',
            'description' => 'Order quantities and expected ship dates contributing to open demand.',
            'showCustomer' => false,
            'showPart' => false,
            'showCompleted' => true,
            'showSchedule' => true,
            'emptyText' => 'No open order context was supplied.',
        ])

        @if ($part['scans'] !== [])
            @include('profile-mfg-poc::partials.scan-table', [
                'scans' => $part['scans'],
                'title' => 'Recent serialized box activity',
                'description' => 'Supplied receipt, shipment, and exception records for this part.',
            ])
        @endif

        @include('profile-mfg-poc::partials.additional-information', ['fields' => $part['additional_fields'] ?? []])
    </div>
</x-layouts.app>
