{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/partials/parts-table.blade.php
    Purpose: Displays part production, inventory, and demand context.
    ========================================================================== --}}

@props([
    'parts' => [],
    'title' => 'Part directory',
    'description' => 'Part identity, production ownership, packaging, finished-goods signals, and near-term demand.',
    'showCustomer' => true,
    'showToolbar' => false,
    'showImage' => false,
    'emptyText' => 'No parts were supplied.',
])

<x-ui.data-table.container :title="$title" :description="$description">
    @if ($showToolbar)
        @include('profile-mfg-poc::partials.disabled-toolbar')
    @endif

    <x-ui.data-table.table size="md" :aria-label="$title">
        <x-ui.data-table.head>
            <x-ui.data-table.row>
                @if ($showImage)
                    <x-ui.data-table.header class="whitespace-nowrap">Image</x-ui.data-table.header>
                @endif
                <x-ui.data-table.header class="whitespace-nowrap">Part</x-ui.data-table.header>
                @if ($showCustomer)
                    <x-ui.data-table.header>Customer</x-ui.data-table.header>
                @endif
                <x-ui.data-table.header>Description</x-ui.data-table.header>
                <x-ui.data-table.header>Line</x-ui.data-table.header>
                <x-ui.data-table.header align="end" class="whitespace-nowrap">Pack</x-ui.data-table.header>
                <x-ui.data-table.header align="end" class="whitespace-nowrap">System balance</x-ui.data-table.header>
                <x-ui.data-table.header align="end" class="whitespace-nowrap">Serialized boxes</x-ui.data-table.header>
                <x-ui.data-table.header align="end" class="whitespace-nowrap">2-week demand</x-ui.data-table.header>
                <x-ui.data-table.header class="whitespace-nowrap">Coverage</x-ui.data-table.header>
                <x-ui.data-table.header class="whitespace-nowrap">Next ship</x-ui.data-table.header>
                <x-ui.data-table.header class="whitespace-nowrap">Status</x-ui.data-table.header>
            </x-ui.data-table.row>
        </x-ui.data-table.head>

        <x-ui.data-table.body>
            @forelse ($parts as $part)
                <x-ui.data-table.row>
                    @if ($showImage)
                        <x-ui.data-table.cell>
                            @if ($part['has_image'])
                                <img
                                    src="{{ route('profile-mfg.parts.image', $part['id']) }}"
                                    alt="{{ $part['internal_part_number'] ?? $part['customer_part_number'] ?? 'Part' }} profile"
                                    class="block h-12 w-20 object-contain"
                                    loading="lazy"
                                >
                            @else
                                <x-ui.icon name="no-image" class="h-8 w-8 ui-platform-text-muted" aria-hidden="true" />
                                <span class="ui-assistive-text">No part image supplied</span>
                            @endif
                        </x-ui.data-table.cell>
                    @endif
                    <x-ui.data-table.cell class="whitespace-nowrap">
                        <x-ui.link
                            :href="route('profile-mfg.parts.show', $part['id'])"
                            :text="$part['internal_part_number'] ?? '—'"
                            variant="standalone"
                            size="sm"
                            navigate
                        />
                        <p class="ui-platform-text-muted">{{ $part['customer_part_number'] ?? '—' }}</p>
                    </x-ui.data-table.cell>
                    @if ($showCustomer)
                        <x-ui.data-table.cell>
                            <x-ui.link
                                :href="route('profile-mfg.customers.show', $part['customer']['id'])"
                                :text="$part['customer']['name']"
                                variant="inline"
                                size="sm"
                                navigate
                            />
                        </x-ui.data-table.cell>
                    @endif
                    <x-ui.data-table.cell>{{ $part['description'] ?? '—' }}</x-ui.data-table.cell>
                    <x-ui.data-table.cell>{{ $part['production_line'] ?? '—' }}</x-ui.data-table.cell>
                    <x-ui.data-table.cell align="end" class="whitespace-nowrap">{{ isset($part['pieces_per_box']) ? number_format($part['pieces_per_box']).' / box' : '—' }}</x-ui.data-table.cell>
                    <x-ui.data-table.cell align="end" class="whitespace-nowrap">{{ isset($part['inventory_metrics']['system_balance']) ? number_format($part['inventory_metrics']['system_balance']) : '—' }}</x-ui.data-table.cell>
                    <x-ui.data-table.cell align="end" class="whitespace-nowrap">{{ isset($part['inventory_metrics']['serialized_boxes']) ? number_format($part['inventory_metrics']['serialized_boxes']) : '—' }}</x-ui.data-table.cell>
                    <x-ui.data-table.cell align="end" class="whitespace-nowrap">{{ number_format($part['metrics']['demand_through_schedule']) }}</x-ui.data-table.cell>
                    <x-ui.data-table.cell class="whitespace-nowrap">@include('profile-mfg-poc::partials.coverage-tag', ['state' => $part['inventory_metrics']['coverage_state']])</x-ui.data-table.cell>
                    <x-ui.data-table.cell class="whitespace-nowrap">{{ $part['metrics']['next_ship_date'] ?? '—' }}</x-ui.data-table.cell>
                    <x-ui.data-table.cell class="whitespace-nowrap">@include('profile-mfg-poc::partials.status-tag', ['status' => $part['status']])</x-ui.data-table.cell>
                </x-ui.data-table.row>
            @empty
                <x-ui.data-table.row>
                    <x-ui.data-table.cell :colspan="10 + (int) $showCustomer + (int) $showImage">{{ $emptyText }}</x-ui.data-table.cell>
                </x-ui.data-table.row>
            @endforelse
        </x-ui.data-table.body>
    </x-ui.data-table.table>
</x-ui.data-table.container>
