{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/partials/schedule-tag.blade.php
    Purpose: Renders snapshot-relative order schedule state consistently.
    ========================================================================== --}}

@php
    $label = match ($state) {
        'past_due' => 'Past due',
        'due_today' => 'Due today',
        'due_this_week' => 'Due this week',
        'next_week' => 'Next week',
        'complete' => 'Complete',
        'cancelled' => 'Cancelled',
        default => 'Upcoming',
    };
@endphp

<x-ui.tag
    :label="$label"
    :tone="match ($state) {
        'past_due' => 'danger',
        'due_today' => 'notice',
        'due_this_week' => 'warning',
        'next_week' => 'info',
        'complete' => 'success',
        'cancelled' => 'neutral',
        default => 'info',
    }"
    size="sm"
/>
