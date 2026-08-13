{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/reports/index.blade.php
    Purpose: Read-only report catalog for the Profile Mfg POC.
    ========================================================================== --}}

@php
    $reports = [
        [
            'title' => 'Daily and weekly shipping schedule',
            'description' => 'Customer and part demand across the active ten-workday shipping window.',
            'meta' => 'Primary daily coordination view',
            'icon' => 'calendar',
            'href' => route('profile-mfg.dashboard'),
        ],
        [
            'title' => 'Daily order schedule',
            'description' => 'Open and shorted orders prioritized by expected ship date.',
            'meta' => number_format($orders_summary['open']).' open orders',
            'icon' => 'delivery',
            'href' => route('profile-mfg.orders.index'),
        ],
        [
            'title' => 'Finished-goods totals',
            'description' => 'System balances and serialized box totals grouped by part and customer.',
            'meta' => number_format($inventory_summary['system_balance']).' system pieces',
            'icon' => 'inventory-management',
            'href' => route('profile-mfg.inventory.index'),
        ],
        [
            'title' => 'Inventory scanned',
            'description' => 'Serialized boxes received, shipped, and rejected in the supplied activity snapshot.',
            'meta' => number_format(count($scans)).' scan events',
            'icon' => 'barcode',
            'href' => route('profile-mfg.scanning.index'),
        ],
    ];
@endphp

<x-layouts.app
    header-variant="workspace"
    :grid="false"
    :reserve-page-tabs="false"
    title="Reports"
    page-title="Reports"
    page-subtitle="Operational views retained from the current system and reorganized around daily work."
    brand-name="Profile Mfg"
    header-label="Profile Mfg"
    side-nav-area-title="Profile Mfg"
    :side-nav-expanded="false"
    :side-nav-fixed="false"
>
    <x-slot:sidebar>
        @include('profile-mfg-poc::partials.sidebar')
    </x-slot:sidebar>

    <div class="space-y-6">
        @include('profile-mfg-poc::partials.preview-banner')

        <x-ui.notification.inline
            kind="info"
            title="Live views, static snapshot"
            subtitle="These destinations reuse the same normalized snapshot. Printing, exporting, date changes, and saved report configuration remain preview-only."
            low-contrast
            hide-close-button
        />

        <x-patterns.dashboard-grid columns="4" aria-label="Operational report catalog">
            @foreach ($reports as $report)
                <x-ui.tile
                    variant="clickable"
                    :href="$report['href']"
                    :title="$report['title']"
                    :description="$report['description']"
                    :meta="$report['meta']"
                    :icon="$report['icon']"
                    wire:navigate
                />
            @endforeach
        </x-patterns.dashboard-grid>

        <x-patterns.content-section-block
            title="Future report previews"
            description="Additional report concepts visible in the legacy application but intentionally not implemented for this POC."
        >
            <x-patterns.tag-group label="Future report previews">
                @foreach (['Inventory transactions', 'Shipping scan history', 'Production-by-date export', 'Customer delivery history'] as $report)
                    <x-ui.tag :label="$report.' — Preview'" tone="neutral" size="md" />
                @endforeach
            </x-patterns.tag-group>
        </x-patterns.content-section-block>
    </div>
</x-layouts.app>
