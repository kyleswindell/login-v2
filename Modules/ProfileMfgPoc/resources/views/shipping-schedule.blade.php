{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/shipping-schedule.blade.php
    Purpose: Daily and weekly shipping coordination page for the static POC.
    ========================================================================== --}}

<x-layouts.app
    header-variant="workspace"
    :grid="false"
    :reserve-page-tabs="false"
    title="Shipping schedule"
    page-title="Shipping schedule"
    :page-subtitle="
        'Daily and weekly customer demand, packaging context, and finished-goods readiness through ' .
        $schedule_end_label .
        '.'
    "
    brand-name="Profile Mfg"
    header-label="Profile Mfg"
    side-nav-area-title="Profile Mfg"
    :side-nav-expanded="false"
    :side-nav-fixed="false"
>
    <x-slot:pageActions>
        <x-ui.button kind="secondary" disabled>
            Print schedule — Preview</x-ui.button
        >
        <x-ui.button kind="primary" disabled>
            Close / short orders — Preview</x-ui.button
        >
    </x-slot:pageActions>

    <x-slot:sidebar>
        @include ("profile-mfg-poc::partials.sidebar")
    </x-slot:sidebar>

    <div class="space-y-6">
        @include ("profile-mfg-poc::partials.preview-banner")

        <x-patterns.dashboard-grid
            columns="4"
            aria-label="Shipping workload summary"
        >
            @include ("profile-mfg-poc::partials.summary-tile",
                [
                    "label" => "Past due",
                    "value" => number_format($dashboard["past_due_demand"]),
                    "supportingText" => "Remaining pieces before " . $snapshot_label,
                    "status" =>
                        $dashboard["past_due_demand"] > 0 ? "Requires recovery plan" : null,
                    "statusTone" => "danger"
                ])
            @include ("profile-mfg-poc::partials.summary-tile",
                [
                    "label" => "Ship today",
                    "value" => number_format($dashboard["ship_today"]),
                    "supportingText" => "Remaining pieces due " . $snapshot_label,
                    "status" => $dashboard["ship_today"] > 0 ? "Today" : null,
                    "statusTone" => "notice"
                ])
            @include ("profile-mfg-poc::partials.summary-tile",
                [
                    "label" => "Rest of this week",
                    "value" => number_format($dashboard["due_rest_of_week"]),
                    "supportingText" => "Pieces due after today through Friday"
                ])
            @include ("profile-mfg-poc::partials.summary-tile",
                [
                    "label" => "Next week",
                    "value" => number_format($dashboard["due_next_week"]),
                    "supportingText" => "Pieces due in the second schedule week"
                ])
        </x-patterns.dashboard-grid>

        @include ("profile-mfg-poc::partials.shipping-schedule-table",
            [
                "parts" => $dashboard["schedule"],
                "dates" => $schedule_dates,
                "description" =>
                    "The current and next work week remain the primary coordination window. Daily cells link to the orders that make up each remaining quantity; forward columns preserve the longer planning horizon."
            ])

        @include ("profile-mfg-poc::partials.inventory-table",
            [
                "parts" => $dashboard["inventory_exceptions"],
                "title" => "Inventory checks before shipping",
                "description" =>
                    "Parts with near-term demand where system and serialized stock are short, conflicting, or unavailable."
            ])

        <x-ui.contained-list
            title="Customer shipping instructions"
            description="Current instructions for customers with open demand in the snapshot."
            variant="on-page"
            size="md"
            :items="
                collect($dashboard['shipping_notes'])
        ->map(
            fn($customer) => [
                'title' => $customer['name'],
                'description' => collect([
                    $customer['shipping_instructions'] ?:
                    'No shipping instructions were supplied.',
                    filled(
                        collect($customer['shipping_address'] ?? [])
                            ->filter()
                            ->implode(', '),
                    )
                        ? 'Ship to: ' .
                            collect($customer['shipping_address'])
                                ->filter()
                                ->implode(', ')
                        : null,
                ])
                    ->filter()
                    ->implode(' · '),
                'href' => route('profile-mfg.customers.show', $customer['id']),
                'icon' => 'delivery',
            ],
        )
        ->values()
            "
        />
    </div>
</x-layouts.app>
