{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/partials/scan-tag.blade.php
    Purpose: Renders semantic direction and result tags for scan activity.
    ========================================================================== --}}

@props([
    'type',
    'value',
])

<x-ui.tag
    :label="match ($type) {
        'direction' => $value === 'in' ? 'Scanned in' : 'Scanned out',
        default => $value === 'accepted' ? 'Accepted' : 'Exception',
    }"
    :tone="match ($type) {
        'direction' => $value === 'in' ? 'info' : 'neutral',
        default => $value === 'accepted' ? 'success' : 'danger',
    }"
    size="sm"
/>
