{{-- ==========================================================================
    File: resources/views/components/ui/data-table/table.blade.php
    Purpose: Data Table native table and overflow wrapper.

    Notes:
    - Emits the canonical ui-data-table table class contract.
    - Keeps horizontal overflow handling around the native table element.
    - Sticky header wrapping is presentation-only and does not own table state.
    ========================================================================== --}}

@props([
    'size' => 'lg',
    'sortable' => false,
    'striped' => false,
    'stickyHeader' => false,
    'useStaticWidth' => false,
    'overflowMenuOnHover' => true,
    'experimentalAutoAlign' => false,
    'ariaLabelledby' => null,
    'ariaDescribedby' => null,
    'ariaLabel' => 'Data table',
])

@php
    /*
    |--------------------------------------------------------------------------
    | Table presentation values
    |--------------------------------------------------------------------------
    |
    | Size and presentation flags map directly to installed data-table CSS
    | selectors. Behavioral state is intentionally not computed here.
    |
    */

    $resolvedSize = in_array($size, ['xs', 'sm', 'md', 'lg', 'xl'], true)
        ? $size
        : 'lg';
@endphp

@if ($stickyHeader)
    <section class="ui-data-table_inner-container ui-data-table-inner-container">
@endif

<div class="ui-data-table-content" tabindex="0" data-ui-data-table-content>
    <table
        {{ $attributes->class([
            'ui-data-table',
            'ui-data-table--'.$resolvedSize,
            'ui-data-table-'.$resolvedSize,
            'ui-data-table--sort' => $sortable,
            'ui-data-table-sort' => $sortable,
            'ui-data-table--zebra' => $striped,
            'ui-data-table-zebra' => $striped,
            'ui-data-table--static' => $useStaticWidth,
            'ui-data-table-static' => $useStaticWidth,
            'ui-data-table--sticky-header' => $stickyHeader,
            'ui-data-table-sticky-header' => $stickyHeader,
            'ui-data-table--visible-overflow-menu' => ! $overflowMenuOnHover,
            'ui-data-table-visible-overflow-menu' => ! $overflowMenuOnHover,
        ]) }}
        @if ($ariaLabelledby)
            aria-labelledby="{{ $ariaLabelledby }}"
        @else
            aria-label="{{ $ariaLabel }}"
        @endif
        @if ($ariaDescribedby) aria-describedby="{{ $ariaDescribedby }}" @endif
        @if ($experimentalAutoAlign) data-ui-data-table-auto-align="true" @endif
    >
        {{ $slot }}
    </table>
</div>

@if ($stickyHeader)
    </section>
@endif
