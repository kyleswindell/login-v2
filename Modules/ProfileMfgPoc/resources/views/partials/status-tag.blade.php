{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/partials/status-tag.blade.php
    Purpose: Renders a consistent semantic status label for POC records.
    ========================================================================== --}}

<x-ui.tag
    :label="match ($status) {
        'wip' => 'WIP',
        default => str_replace('_', ' ', ucfirst($status)),
    }"
    :tone="match ($status) {
        'active', 'closed' => 'success',
        'open' => 'info',
        'wip' => 'warning',
        'shorted' => 'danger',
        'purchase', 'service', 'cancelled', 'obsolete' => 'neutral',
        default => 'neutral',
    }"
    size="sm"
/>
