{{-- ==========================================================================
    File: resources/views/components/ui/data-table/row.blade.php
    Purpose: Data Table body row wrapper.

    Notes:
    - Renders native tr elements with installed row state classes.
    - Row selection/current state must be supplied by the caller.
    ========================================================================== --}}

@props([
    'selected' => false,
    'current' => false,
    'disabled' => false,
])

<tr
    {{ $attributes->class([
        'ui-data-table-row',
        'ui-table-row',
        'ui-data-table--selected' => $selected,
        'ui-data-table-selected' => $selected,
        'ui-data-table-row-current' => $current,
        'ui-data-table-row-disabled' => $disabled,
    ]) }}
    data-ui-data-table-row
    @if ($disabled) aria-disabled="true" @endif
>
    {{ $slot }}
</tr>
