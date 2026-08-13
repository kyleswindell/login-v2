{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/partials/coverage-tag.blade.php
    Purpose: Renders two-week finished-goods coverage state consistently.
    ========================================================================== --}}

@php
    $label = match ($state) {
        'ready' => 'Covered',
        'short' => 'Short',
        'verify' => 'Verify balances',
        'unknown' => 'Not supplied',
        default => 'No 2-week demand',
    };
@endphp

<x-ui.tag
    :label="$label"
    :tone="match ($state) {
        'ready' => 'success',
        'short' => 'danger',
        'verify' => 'warning',
        default => 'neutral',
    }"
    size="sm"
/>
