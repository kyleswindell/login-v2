{{-- ==========================================================================
    File: resources/views/components/ui/data-table/action-list.blade.php
    Purpose: Data Table batch-action list wrapper.

    Notes:
    - Groups batch action controls inside the toolbar batch-actions region.
    - Does not own selected-row state or action behavior.
    ========================================================================== --}}

<div
    {{ $attributes->class('ui-action-list')->merge([
        'data-ui-table-action-list' => true,
    ]) }}
>
    {{ $slot }}
</div>
