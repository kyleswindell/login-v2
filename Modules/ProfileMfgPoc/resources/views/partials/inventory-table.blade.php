{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/partials/inventory-table.blade.php
    Purpose: Compares finished-goods physical and aggregate inventory signals.
    ========================================================================== --}}

@props([
    'parts' => [],
    'showToolbar' => false,
    'title' => 'Finished-goods inventory by part',
    'description' => 'Serialized full-box stock is the physical signal. The system part balance remains visible for reconciliation and may include loose pieces.',
])

<x-ui.data-table.container :title="$title" :description="$description">
    @if ($showToolbar)
        @include('profile-mfg-poc::partials.disabled-toolbar', ['showCreate' => false])
    @endif

    <x-ui.data-table.table size="md" :aria-label="$title">
        <x-ui.data-table.head>
            <x-ui.data-table.row>
                <x-ui.data-table.header>Part</x-ui.data-table.header>
                <x-ui.data-table.header>Customer</x-ui.data-table.header>
                <x-ui.data-table.header>Status</x-ui.data-table.header>
                <x-ui.data-table.header align="end">System balance</x-ui.data-table.header>
                <x-ui.data-table.header align="end">Serialized boxes</x-ui.data-table.header>
                <x-ui.data-table.header align="end">Full-box pieces</x-ui.data-table.header>
                <x-ui.data-table.header align="end">2-week demand</x-ui.data-table.header>
                <x-ui.data-table.header align="end">System − full boxes</x-ui.data-table.header>
                <x-ui.data-table.header>Coverage</x-ui.data-table.header>
                <x-ui.data-table.header>Last scan</x-ui.data-table.header>
            </x-ui.data-table.row>
        </x-ui.data-table.head>

        <x-ui.data-table.body>
            @forelse ($parts as $part)
                <x-ui.data-table.row>
                    <x-ui.data-table.cell>
                        <x-ui.link
                            :href="route('profile-mfg.parts.show', $part['id'])"
                            :text="$part['internal_part_number'] ?? '—'"
                            variant="standalone"
                            size="sm"
                            navigate
                        />
                        <p class="ui-platform-text-muted">{{ $part['customer_part_number'] ?? '—' }}</p>
                    </x-ui.data-table.cell>
                    <x-ui.data-table.cell>
                        <x-ui.link
                            :href="route('profile-mfg.customers.show', $part['customer']['id'])"
                            :text="$part['customer']['name']"
                            variant="inline"
                            size="sm"
                            navigate
                        />
                    </x-ui.data-table.cell>
                    <x-ui.data-table.cell>
                        @include('profile-mfg-poc::partials.status-tag', ['status' => $part['status']])
                    </x-ui.data-table.cell>
                    <x-ui.data-table.cell align="end">
                        {{ isset($part['inventory_metrics']['system_balance']) ? number_format($part['inventory_metrics']['system_balance']) : '—' }}
                    </x-ui.data-table.cell>
                    <x-ui.data-table.cell align="end">
                        {{ isset($part['inventory_metrics']['serialized_boxes']) ? number_format($part['inventory_metrics']['serialized_boxes']) : '—' }}
                    </x-ui.data-table.cell>
                    <x-ui.data-table.cell align="end">
                        {{ isset($part['inventory_metrics']['serialized_full_box_pieces']) ? number_format($part['inventory_metrics']['serialized_full_box_pieces']) : '—' }}
                    </x-ui.data-table.cell>
                    <x-ui.data-table.cell align="end">
                        {{ number_format($part['metrics']['demand_through_schedule']) }}
                    </x-ui.data-table.cell>
                    <x-ui.data-table.cell align="end">
                        {{ isset($part['inventory_metrics']['balance_difference']) ? number_format($part['inventory_metrics']['balance_difference']) : '—' }}
                    </x-ui.data-table.cell>
                    <x-ui.data-table.cell>
                        @include('profile-mfg-poc::partials.coverage-tag', ['state' => $part['inventory_metrics']['coverage_state']])
                    </x-ui.data-table.cell>
                    <x-ui.data-table.cell>{{ $part['inventory_metrics']['last_scan_label'] ?? '—' }}</x-ui.data-table.cell>
                </x-ui.data-table.row>
            @empty
                <x-ui.data-table.row>
                    <x-ui.data-table.cell :colspan="10">No inventory values were supplied.</x-ui.data-table.cell>
                </x-ui.data-table.row>
            @endforelse
        </x-ui.data-table.body>
    </x-ui.data-table.table>
</x-ui.data-table.container>
