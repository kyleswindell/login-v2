{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/partials/preview-banner.blade.php
    Purpose: Identifies the snapshot and read-only POC state on every page.
    ========================================================================== --}}

<x-ui.notification.inline
    kind="info"
    title="Static proof of concept"
    :subtitle="'Data snapshot: '.$snapshot_label.' · Record-changing actions are unavailable.'"
    low-contrast
    hide-close-button
    aria-label="Proof of concept notice"
/>
