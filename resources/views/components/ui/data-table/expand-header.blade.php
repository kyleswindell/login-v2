{{-- ==========================================================================
    File: resources/views/components/ui/data-table/expand-header.blade.php
    Purpose: Data Table expandable-row header cell.

    Notes:
    - Renders the optional expand-all header control.
    - Expansion state is supplied by the caller.
    - Does not wire expansion into the high-level data-table array renderer.
    ========================================================================== --}}

@props([
    'id' => 'expand',
    'ariaControls' => null,
    'ariaLabel' => 'Expand all rows',
    'enableToggle' => false,
    'enableExpando' => false,
    'expanded' => false,
    'isExpanded' => null,
    'expandIconDescription' => 'Expand all rows',
])

@php
    $isExpanded = is_null($isExpanded) ? (bool) $expanded : (bool) $isExpanded;
    $showToggle = (bool) $enableToggle || (bool) $enableExpando;
    $previousValue = $isExpanded ? 'collapsed' : null;
@endphp

<th
    {{ $attributes->class('ui-table-expand') }}
    scope="col"
    id="{{ $id }}"
    @if ($previousValue) data-previous-value="{{ $previousValue }}" @endif
>
    @if ($showToggle)
        <button
            type="button"
            class="ui-table-expand__button"
            title="{{ $expandIconDescription }}"
            aria-label="{{ $ariaLabel }}"
            aria-expanded="{{ $isExpanded ? 'true' : 'false' }}"
            @if ($ariaControls) aria-controls="{{ $ariaControls }}" @endif
            data-ui-table-expand-all
        >
            <svg
                viewBox="0 0 16 16"
                focusable="false"
                preserveAspectRatio="xMidYMid meet"
                fill="currentColor"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
                class="ui-icon ui-table-expand__svg"
            >
                <polygon points="6,12 5.3,11.3 8.6,8 5.3,4.7 6,4 10,8"></polygon>
            </svg>
        </button>
    @endif

    {{ $slot }}
</th>
