{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/partials/orders-table.blade.php
    Purpose: Displays read-only order context through the canonical data table.
    ========================================================================== --}}

@props([
    'orders' => [],
    'title' => 'Orders',
    'description' => null,
    'showCustomer' => false,
    'showPart' => true,
    'showCompleted' => false,
    'showSchedule' => false,
    'showToolbar' => false,
    'emptyText' => 'No orders were supplied.',
])

<x-ui.data-table.container :title="$title" :description="$description">
    @if ($showToolbar)
        @include('profile-mfg-poc::partials.disabled-toolbar')
    @endif

    <x-ui.data-table.table size="md" :aria-label="$title">
        <x-ui.data-table.head>
            <x-ui.data-table.row>
                <x-ui.data-table.header>Order</x-ui.data-table.header>
                @if ($showCustomer)
                    <x-ui.data-table.header>Customer</x-ui.data-table.header>
                @endif
                @if ($showPart)
                    <x-ui.data-table.header>Part</x-ui.data-table.header>
                @endif
                <x-ui.data-table.header align="end">Ordered</x-ui.data-table.header>
                @if ($showCompleted)
                    <x-ui.data-table.header align="end">Shipped</x-ui.data-table.header>
                @endif
                <x-ui.data-table.header align="end">Remaining</x-ui.data-table.header>
                <x-ui.data-table.header>Ship date</x-ui.data-table.header>
                @if ($showSchedule)
                    <x-ui.data-table.header>Schedule</x-ui.data-table.header>
                @endif
                <x-ui.data-table.header>Status</x-ui.data-table.header>
            </x-ui.data-table.row>
        </x-ui.data-table.head>

        <x-ui.data-table.body>
            @forelse ($orders as $order)
                <x-ui.data-table.row>
                    <x-ui.data-table.cell>
                        <x-ui.link
                            :href="route('profile-mfg.orders.show', $order['id'])"
                            :text="$order['id']"
                            variant="standalone"
                            size="sm"
                            navigate
                        />
                    </x-ui.data-table.cell>

                    @if ($showCustomer)
                        <x-ui.data-table.cell>
                            <x-ui.link
                                :href="route('profile-mfg.customers.show', $order['customer']['id'])"
                                :text="$order['customer']['name']"
                                variant="inline"
                                size="sm"
                                navigate
                            />
                        </x-ui.data-table.cell>
                    @endif

                    @if ($showPart)
                        <x-ui.data-table.cell>
                            <x-ui.link
                                :href="route('profile-mfg.parts.show', $order['part']['id'])"
                                :text="$order['part']['internal_part_number'] ?? '—'"
                                variant="inline"
                                size="sm"
                                navigate
                            />
                        </x-ui.data-table.cell>
                    @endif

                    <x-ui.data-table.cell align="end">{{ number_format($order['original_quantity']) }}</x-ui.data-table.cell>
                    @if ($showCompleted)
                        <x-ui.data-table.cell align="end">{{ number_format($order['completed_quantity']) }}</x-ui.data-table.cell>
                    @endif
                    <x-ui.data-table.cell align="end"><strong>{{ number_format($order['remaining_quantity']) }}</strong></x-ui.data-table.cell>
                    <x-ui.data-table.cell>{{ $order['ship_date_label'] }}</x-ui.data-table.cell>
                    @if ($showSchedule)
                        <x-ui.data-table.cell>
                            @include('profile-mfg-poc::partials.schedule-tag', ['state' => $order['schedule_state']])
                        </x-ui.data-table.cell>
                    @endif
                    <x-ui.data-table.cell>
                        @include('profile-mfg-poc::partials.status-tag', ['status' => $order['status']])
                    </x-ui.data-table.cell>
                </x-ui.data-table.row>
            @empty
                <x-ui.data-table.row>
                    <x-ui.data-table.cell
                        :colspan="5 + (int) $showCustomer + (int) $showPart + (int) $showCompleted + (int) $showSchedule"
                    >
                        {{ $emptyText }}
                    </x-ui.data-table.cell>
                </x-ui.data-table.row>
            @endforelse
        </x-ui.data-table.body>
    </x-ui.data-table.table>
</x-ui.data-table.container>
