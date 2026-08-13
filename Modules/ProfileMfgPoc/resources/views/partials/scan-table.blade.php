{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/partials/scan-table.blade.php
    Purpose: Displays read-only serialized finished-goods scan activity.
    ========================================================================== --}}

@props([
    'scans' => [],
    'title' => 'Serialized box activity',
    'description' => 'Accepted scans and exceptions captured in the supplied snapshot.',
    'showToolbar' => false,
])

<x-ui.data-table.container :title="$title" :description="$description">
    @if ($showToolbar)
        @include('profile-mfg-poc::partials.disabled-toolbar')
    @endif

    <x-ui.data-table.table size="md" :aria-label="$title">
        <x-ui.data-table.head>
            <x-ui.data-table.row>
                <x-ui.data-table.header>Scanned at</x-ui.data-table.header>
                <x-ui.data-table.header>Movement</x-ui.data-table.header>
                <x-ui.data-table.header>Part</x-ui.data-table.header>
                <x-ui.data-table.header>Customer</x-ui.data-table.header>
                <x-ui.data-table.header>Manufactured</x-ui.data-table.header>
                <x-ui.data-table.header>Serial</x-ui.data-table.header>
                <x-ui.data-table.header align="end">Pieces / box</x-ui.data-table.header>
                <x-ui.data-table.header>Result</x-ui.data-table.header>
                <x-ui.data-table.header>Message</x-ui.data-table.header>
            </x-ui.data-table.row>
        </x-ui.data-table.head>

        <x-ui.data-table.body>
            @forelse ($scans as $scan)
                <x-ui.data-table.row>
                    <x-ui.data-table.cell class="whitespace-nowrap">{{ $scan['scanned_at_label'] }}</x-ui.data-table.cell>
                    <x-ui.data-table.cell>
                        @include('profile-mfg-poc::partials.scan-tag', ['type' => 'direction', 'value' => $scan['direction']])
                    </x-ui.data-table.cell>
                    <x-ui.data-table.cell>
                        <x-ui.link
                            :href="route('profile-mfg.parts.show', $scan['part']['id'])"
                            :text="$scan['part']['customer_part_number'] ?? $scan['part']['internal_part_number'] ?? '—'"
                            variant="standalone"
                            size="sm"
                            navigate
                        />
                        <p class="ui-platform-text-muted">{{ $scan['part']['internal_part_number'] ?? '—' }}</p>
                    </x-ui.data-table.cell>
                    <x-ui.data-table.cell>
                        <x-ui.link
                            :href="route('profile-mfg.customers.show', $scan['customer']['id'])"
                            :text="$scan['customer']['name']"
                            variant="inline"
                            size="sm"
                            navigate
                        />
                    </x-ui.data-table.cell>
                    <x-ui.data-table.cell class="whitespace-nowrap">{{ $scan['manufactured_date_label'] }}</x-ui.data-table.cell>
                    <x-ui.data-table.cell class="whitespace-nowrap"><strong>{{ $scan['serial_number'] }}</strong></x-ui.data-table.cell>
                    <x-ui.data-table.cell align="end">{{ isset($scan['pieces']) ? number_format($scan['pieces']) : '—' }}</x-ui.data-table.cell>
                    <x-ui.data-table.cell>
                        @include('profile-mfg-poc::partials.scan-tag', ['type' => 'status', 'value' => $scan['status']])
                    </x-ui.data-table.cell>
                    <x-ui.data-table.cell>{{ $scan['message'] ?: '—' }}</x-ui.data-table.cell>
                </x-ui.data-table.row>
            @empty
                <x-ui.data-table.row>
                    <x-ui.data-table.cell colspan="9">No serialized scan activity was supplied.</x-ui.data-table.cell>
                </x-ui.data-table.row>
            @endforelse
        </x-ui.data-table.body>
    </x-ui.data-table.table>
</x-ui.data-table.container>
