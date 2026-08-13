{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/partials/shipping-schedule-table.blade.php
    Purpose: Displays the source-aligned daily and weekly shipping schedule.
    ========================================================================== --}}

@props([
    'parts' => [],
    'dates' => [],
    'title' => 'Two-week shipping schedule',
    'description' => null,
    'showCustomer' => true,
    'emptyText' => 'No open shipping demand was supplied.',
])

<x-ui.data-table.container
    :title="$title"
    :description="$description ?? 'Remaining pieces by expected ship date. Scroll horizontally to review the complete two-week and forward-demand horizon.'"
>
    <x-ui.data-table.table size="sm" :aria-label="$title">
        <x-ui.data-table.head>
            <x-ui.data-table.row>
                <x-ui.data-table.header>Part</x-ui.data-table.header>
                @if ($showCustomer)
                    <x-ui.data-table.header>Customer</x-ui.data-table.header>
                @endif
                <x-ui.data-table.header align="end">Pack</x-ui.data-table.header>
                <x-ui.data-table.header align="end">Prior due</x-ui.data-table.header>
                @foreach ($dates as $date)
                    <x-ui.data-table.header align="end">
                        <span class="block">{{ $date['day_label'] }}</span>
                        <span class="block ui-platform-text-muted">{{ $date['date_label'] }}</span>
                        @if ($date['is_snapshot'])
                            <span class="block ui-platform-text-muted">Snapshot</span>
                        @elseif ($date['is_past'])
                            <span class="block ui-platform-text-muted">Past</span>
                        @endif
                    </x-ui.data-table.header>
                @endforeach
                <x-ui.data-table.header align="end">Weeks 3–4</x-ui.data-table.header>
                <x-ui.data-table.header align="end">Weeks 5–10</x-ui.data-table.header>
                <x-ui.data-table.header>FG coverage</x-ui.data-table.header>
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
                        @if (filled($part['notes'] ?? null))
                            <p class="ui-platform-text-muted">{{ $part['notes'] }}</p>
                        @endif
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
                    <x-ui.data-table.cell align="end">
                        {{ isset($part['pieces_per_box']) ? number_format($part['pieces_per_box']).' / box' : '—' }}
                    </x-ui.data-table.cell>
                    <x-ui.data-table.cell align="end">
                        {{ $part['schedule']['past_due_before_window'] > 0 ? number_format($part['schedule']['past_due_before_window']) : '—' }}
                    </x-ui.data-table.cell>

                    @foreach ($dates as $date)
                        @php
                            $quantity = $part['schedule']['demand_by_date'][$date['date']] ?? 0;
                            $dateOrders = $part['schedule']['orders_by_date'][$date['date']] ?? [];
                        @endphp
                        <x-ui.data-table.cell align="end">
                            @if ($quantity > 0)
                                <strong>{{ number_format($quantity) }}</strong>
                                @foreach ($dateOrders as $order)
                                    <p>
                                        <x-ui.link
                                            :href="route('profile-mfg.orders.show', $order['id'])"
                                            :text="$order['id']"
                                            variant="inline"
                                            size="sm"
                                            navigate
                                        />
                                    </p>
                                @endforeach
                            @else
                                —
                            @endif
                        </x-ui.data-table.cell>
                    @endforeach

                    <x-ui.data-table.cell align="end">
                        {{ $part['schedule']['weeks_three_and_four'] > 0 ? number_format($part['schedule']['weeks_three_and_four']) : '—' }}
                    </x-ui.data-table.cell>
                    <x-ui.data-table.cell align="end">
                        {{ $part['schedule']['weeks_five_through_ten'] > 0 ? number_format($part['schedule']['weeks_five_through_ten']) : '—' }}
                    </x-ui.data-table.cell>
                    <x-ui.data-table.cell>
                        @include('profile-mfg-poc::partials.coverage-tag', ['state' => $part['inventory_metrics']['coverage_state']])
                    </x-ui.data-table.cell>
                </x-ui.data-table.row>
            @empty
                <x-ui.data-table.row>
                    <x-ui.data-table.cell :colspan="16 + (int) $showCustomer">{{ $emptyText }}</x-ui.data-table.cell>
                </x-ui.data-table.row>
            @endforelse
        </x-ui.data-table.body>
    </x-ui.data-table.table>
</x-ui.data-table.container>
