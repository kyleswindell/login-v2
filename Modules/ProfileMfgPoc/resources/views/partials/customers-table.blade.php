{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/partials/customers-table.blade.php
    Purpose: Displays the customer directory through the canonical data table.
    ========================================================================== --}}

<x-ui.data-table.container
    title="Customer directory"
    description="Customer contacts, ship-to context, and open shipping demand at the presentation snapshot."
>
    @include('profile-mfg-poc::partials.disabled-toolbar')

    <x-ui.data-table.table size="md" aria-label="Customer directory">
        <x-ui.data-table.head>
            <x-ui.data-table.row>
                <x-ui.data-table.header>Company</x-ui.data-table.header>
                <x-ui.data-table.header>Primary contact</x-ui.data-table.header>
                <x-ui.data-table.header>Ship to</x-ui.data-table.header>
                <x-ui.data-table.header align="end">Active parts</x-ui.data-table.header>
                <x-ui.data-table.header align="end">Open orders</x-ui.data-table.header>
                <x-ui.data-table.header align="end">Past due</x-ui.data-table.header>
                <x-ui.data-table.header>Next ship</x-ui.data-table.header>
                <x-ui.data-table.header>Status</x-ui.data-table.header>
            </x-ui.data-table.row>
        </x-ui.data-table.head>

        <x-ui.data-table.body>
            @forelse ($customers as $customer)
                <x-ui.data-table.row>
                    <x-ui.data-table.cell>
                        <x-ui.link
                            :href="route('profile-mfg.customers.show', $customer['id'])"
                            :text="$customer['name']"
                            variant="standalone"
                            size="sm"
                            navigate
                        />
                        <p class="ui-platform-text-muted">{{ $customer['id'] }}</p>
                    </x-ui.data-table.cell>
                    <x-ui.data-table.cell>
                        <p>{{ $customer['primary_contact']['name'] ?? '—' }}</p>
                        <p class="ui-platform-text-muted">{{ $customer['primary_contact']['email'] ?? '—' }}</p>
                    </x-ui.data-table.cell>
                    <x-ui.data-table.cell>
                        <p>{{ $customer['shipping_address']['line_2'] ?? $customer['shipping_address']['line_1'] ?? '—' }}</p>
                        <p class="ui-platform-text-muted">
                            {{ collect([
                                $customer['shipping_address']['city'] ?? null,
                                $customer['shipping_address']['state'] ?? null,
                            ])->filter()->implode(', ') ?: '—' }}
                        </p>
                    </x-ui.data-table.cell>
                    <x-ui.data-table.cell align="end">{{ number_format($customer['metrics']['active_parts']) }}</x-ui.data-table.cell>
                    <x-ui.data-table.cell align="end">{{ number_format($customer['metrics']['open_orders']) }}</x-ui.data-table.cell>
                    <x-ui.data-table.cell align="end">{{ number_format($customer['metrics']['past_due_demand']) }}</x-ui.data-table.cell>
                    <x-ui.data-table.cell>{{ $customer['metrics']['nearest_ship_date'] ?? '—' }}</x-ui.data-table.cell>
                    <x-ui.data-table.cell>@include('profile-mfg-poc::partials.status-tag', ['status' => $customer['status']])</x-ui.data-table.cell>
                </x-ui.data-table.row>
            @empty
                <x-ui.data-table.row>
                    <x-ui.data-table.cell :colspan="8">No customers were supplied.</x-ui.data-table.cell>
                </x-ui.data-table.row>
            @endforelse
        </x-ui.data-table.body>
    </x-ui.data-table.table>
</x-ui.data-table.container>
