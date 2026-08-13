{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/scanning/index.blade.php
    Purpose: Read-only serialized box receipt, shipment, and exception activity.
    ========================================================================== --}}

<x-layouts.app
    header-variant="workspace"
    :grid="false"
    :reserve-page-tabs="false"
    title="Scan activity"
    page-title="Scan activity"
    :page-subtitle="'Serialized finished-goods movements recorded for the '.$snapshot_label.' snapshot.'"
    brand-name="Profile Mfg"
    header-label="Profile Mfg"
    side-nav-area-title="Profile Mfg"
    :side-nav-expanded="false"
    :side-nav-fixed="false"
>
    <x-slot:pageActions>
        <x-ui.button kind="primary" disabled>Scan inventory — Preview</x-ui.button>
    </x-slot:pageActions>

    <x-slot:sidebar>
        @include('profile-mfg-poc::partials.sidebar')
    </x-slot:sidebar>

    <div class="space-y-6">
        @include('profile-mfg-poc::partials.preview-banner')

        <x-ui.notification.inline
            kind="info"
            title="Serialized box traceability"
            subtitle="Each accepted event represents one labeled finished-goods box. Exceptions stay visible and do not change the inventory totals in this static preview."
            low-contrast
            hide-close-button
        />

        <x-patterns.dashboard-grid columns="4" aria-label="Scan activity summary">
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'Scanned in today',
                'value' => number_format($scan_summary['scanned_in']).' '.str('box')->plural($scan_summary['scanned_in']),
                'supportingText' => 'Accepted finished-goods receipts',
            ])
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'Pieces received',
                'value' => number_format($scan_summary['pieces_received']),
                'supportingText' => 'Using supplied pieces-per-box values',
            ])
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'Scanned out today',
                'value' => number_format($scan_summary['scanned_out']).' '.str('box')->plural($scan_summary['scanned_out']),
                'supportingText' => number_format($scan_summary['pieces_shipped']).' pieces represented',
            ])
            @include('profile-mfg-poc::partials.summary-tile', [
                'label' => 'Exceptions',
                'value' => number_format($scan_summary['exceptions']),
                'supportingText' => 'Rejected or duplicate scan attempts',
                'status' => $scan_summary['exceptions'] > 0 ? 'Review required' : null,
                'statusTone' => 'danger',
            ])
        </x-patterns.dashboard-grid>

        @include('profile-mfg-poc::partials.scan-table', [
            'scans' => $scans,
            'showToolbar' => true,
        ])
    </div>
</x-layouts.app>
