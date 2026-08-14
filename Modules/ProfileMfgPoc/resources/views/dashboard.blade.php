{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/dashboard.blade.php
    Purpose: Concise Operations workspace dashboard for the static POC.
    ========================================================================== --}}

<x-layouts.app
    header-variant="workspace"
    :grid="false"
    :reserve-page-tabs="false"
    title="Operations dashboard"
    page-title="Operations dashboard"
    :page-subtitle="
        'Operations workspace overview for shipping, open demand, finished goods, and scan activity as of ' .
        $snapshot_label .
        '.'
    "
    brand-name="Profile Mfg"
    header-label="Profile Mfg"
    side-nav-area-title="Operations"
    :side-nav-expanded="false"
    :side-nav-fixed="false"
>
    <x-slot:pageActions>
        <x-ui.button kind="secondary" disabled>
            Edit dashboard — Coming soon</x-ui.button
        >
        <x-ui.button
            :href="route('profile-mfg.shipping-schedule')"
            kind="primary"
            wire:navigate
        >
            View shipping schedule
        </x-ui.button>
    </x-slot:pageActions>

    <x-slot:sidebar>
        @include ("profile-mfg-poc::partials.sidebar")
    </x-slot:sidebar>

    <div class="space-y-6">
        @include ("profile-mfg-poc::partials.preview-banner")

        <x-patterns.dashboard-grid columns="4" aria-label="Operations summary">
            @include ("profile-mfg-poc::partials.summary-tile",
                [
                    "label" => "Ship today",
                    "value" => number_format($dashboard["ship_today"]),
                    "supportingText" =>
                        number_format($orders_summary["due_today"]) .
                        " " .
                        str("order")->plural($orders_summary["due_today"]) .
                        " due " .
                        $snapshot_label,
                    "status" => $dashboard["ship_today"] > 0 ? "Today" : null,
                    "statusTone" => "notice"
                ])
            @include ("profile-mfg-poc::partials.summary-tile",
                [
                    "label" => "Open demand",
                    "value" => number_format($orders_summary["open_demand"]),
                    "supportingText" =>
                        number_format($orders_summary["open"]) . " open or shorted orders"
                ])
            @include ("profile-mfg-poc::partials.summary-tile",
                [
                    "label" => "Past due",
                    "value" => number_format($dashboard["past_due_demand"]),
                    "supportingText" =>
                        number_format($orders_summary["past_due"]) .
                        " " .
                        str("order")->plural($orders_summary["past_due"]) .
                        " before the snapshot date",
                    "status" =>
                        $dashboard["past_due_demand"] > 0 ? "Attention required" : null,
                    "statusTone" => "danger"
                ])
            @include ("profile-mfg-poc::partials.summary-tile",
                [
                    "label" => "Inventory checks",
                    "value" => number_format($dashboard["inventory_review_count"]),
                    "supportingText" => "Parts requiring finished-goods review",
                    "status" =>
                        $dashboard["inventory_review_count"] > 0
                            ? "Verify before shipping"
                            : null,
                    "statusTone" => "warning"
                ])
        </x-patterns.dashboard-grid>

        <x-patterns.dashboard-grid
            columns="4"
            aria-label="Common Operations tasks"
        >
            <x-ui.tile
                variant="clickable"
                density="compact"
                :href="route('profile-mfg.shipping-schedule')"
                icon="calendar"
                meta="Daily coordination"
                title="Shipping schedule"
                description="Review customer requirements across the current and next work week."
                wire:navigate
            />

            <x-ui.tile
                variant="clickable"
                density="compact"
                icon="barcode"
                meta="Finished goods"
                title="Start new scan — Coming soon"
                description="Receive or ship a serialized finished-goods box."
                disabled
            />

            <x-ui.tile
                variant="clickable"
                density="compact"
                :href="route('profile-mfg.reports.index')"
                icon="report--data"
                meta="Operational records"
                title="Reports"
                description="Review the available schedule, production, and scan report previews."
                wire:navigate
            />

            @can (\App\Modules\Notifications\Services\NotificationPermissions::VIEW)
                <form
                    method="POST"
                    action="{{ route('dashboard.test-notification') }}"
                    class="contents"
                    data-dashboard-test-notification-form
                >
                    @csrf

                    <x-ui.tile
                        variant="clickable"
                        type="submit"
                        density="compact"
                        icon="notification--new"
                        meta="Demonstration"
                        title="Generate example notification"
                        description="Create a real notification for the signed-in presentation account."
                        data-dashboard-test-notification-submit
                    />
                </form>
            @else
                <x-ui.tile
                    variant="clickable"
                    density="compact"
                    icon="notification--off"
                    meta="Demonstration"
                    title="Generate example notification — Unavailable"
                    description="Notification access is unavailable for this account."
                    disabled
                />
            @endcan
        </x-patterns.dashboard-grid>

        @include ("profile-mfg-poc::partials.orders-table",
            [
                "orders" => $dashboard["shipping_focus_orders"],
                "title" => $dashboard["shipping_focus_is_snapshot_date"]
                    ? "Shipping requirements for today"
                    : "Next shipping requirements · " .
                        $dashboard["shipping_focus_date_label"],
                "description" => $dashboard["shipping_focus_is_snapshot_date"]
                    ? "Open customer requirements due on the data snapshot date."
                    : "No open requirements are due on " .
                        $snapshot_label .
                        ". Showing the next scheduled shipping date.",
                "showCustomer" => true,
                "showPart" => true,
                "showCompleted" => true,
                "showSchedule" => true,
                "emptyText" => "No open orders are due on the snapshot date."
            ])

        <x-patterns.dashboard-grid
            columns="2"
            aria-label="Operations detail widgets"
        >
            <x-ui.tile
                variant="static"
                title="Open order priorities"
                description="The five earliest remaining customer requirements."
                data-dashboard-widget="open-order-priorities"
            >
                <x-ui.contained-list
                    aria-label="Open order priorities"
                    variant="on-page"
                    size="sm"
                    :items="
                        collect($dashboard['priority_orders'])
        ->map(
            fn($order) => [
                'title' =>
                    $order['id'] .
                    ' · ' .
                    ($order['part']['internal_part_number'] ?? '—'),
                'description' =>
                    $order['customer']['name'] .
                    ' · ' .
                    number_format($order['remaining_quantity']) .
                    ' pieces remaining',
                'meta' =>
                    'Ship ' .
                    $order['ship_date_label'] .
                    ' · ' .
                    str($order['schedule_state'])->replace('_', ' ')->title(),
                'href' => route('profile-mfg.orders.show', $order['id']),
                'icon' => 'delivery',
            ],
        )
        ->values()
                    "
                />
            </x-ui.tile>

            <x-ui.tile
                variant="static"
                title="Inventory attention"
                description="Near-term parts whose finished-goods signals need review."
                data-dashboard-widget="inventory-attention"
            >
                <x-ui.contained-list
                    aria-label="Inventory attention"
                    variant="on-page"
                    size="sm"
                    :items="
                        collect($dashboard['priority_inventory'])
        ->map(
            fn($part) => [
                'title' =>
                    ($part['internal_part_number'] ?? '—') .
                    ' · ' .
                    $part['customer']['name'],
                'description' =>
                    'Two-week demand ' .
                    number_format($part['metrics']['demand_through_schedule']) .
                    ' · System balance ' .
                    (isset($part['inventory_metrics']['system_balance'])
                        ? number_format(
                            $part['inventory_metrics']['system_balance'],
                        )
                        : '—'),
                'meta' => str($part['inventory_metrics']['coverage_state'])
                    ->replace('_', ' ')
                    ->title(),
                'href' => route('profile-mfg.parts.show', $part['id']),
                'icon' => 'inventory-management',
            ],
        )
        ->values()
                    "
                    empty-title="No inventory checks"
                    empty-description="No supplied part requires review for the two-week schedule."
                />
            </x-ui.tile>

            <x-ui.tile
                variant="static"
                title="Scan activity today"
                description="Accepted serialized box movements and exceptions for the snapshot date."
                data-dashboard-widget="scan-activity"
            >
                <x-patterns.key-value-display
                    :columns="2"
                    compact
                    :items="
                        [
       [
           'label' => 'Scanned in',
           'value' =>
               number_format($scan_summary['scanned_in']) .
               ' ' .
               str('box')->plural($scan_summary['scanned_in']),
       ],
       [
           'label' => 'Scanned out',
           'value' =>
               number_format($scan_summary['scanned_out']) .
               ' ' .
               str('box')->plural($scan_summary['scanned_out']),
       ],
       [
           'label' => 'Pieces received',
           'value' => number_format($scan_summary['pieces_received']),
       ],
       [
           'label' => 'Exceptions',
           'value' => number_format($scan_summary['exceptions']),
       ],
    ]
                    "
                />

                <x-slot:actions>
                    <x-ui.link
                        :href="route('profile-mfg.scanning.index')"
                        text="View scan activity"
                        variant="standalone"
                        size="sm"
                        navigate
                    />
                </x-slot:actions>
            </x-ui.tile>

            <x-ui.tile
                variant="static"
                title="Shipping demand trend"
                description="A graphical current-week and forward-demand view is planned for the production dashboard."
                data-dashboard-widget="shipping-demand-trend"
            >
                <x-ui.tag
                    label="Visualization coming soon"
                    tone="notice"
                    size="sm"
                />

                <x-slot:actions>
                    <x-ui.link
                        :href="route('profile-mfg.shipping-schedule')"
                        text="Open shipping schedule"
                        variant="standalone"
                        size="sm"
                        navigate
                    />
                </x-slot:actions>
            </x-ui.tile>
        </x-patterns.dashboard-grid>
    </div>
</x-layouts.app>
