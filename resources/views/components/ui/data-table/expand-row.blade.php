{{-- ==========================================================================
    File: resources/views/components/ui/data-table/expand-row.blade.php
    Purpose: Data Table expandable parent row.

    Notes:
    - Renders a parent row with an expand/collapse trigger cell.
    - Expansion, selection, and disabled state are supplied by the caller.
    - Intended to pair with x-ui.data-table.expanded-row.
    ========================================================================== --}}

@props([
    'ariaControls' => null,
    'ariaLabel' => 'Expand current row',
    'expanded' => false,
    'isExpanded' => null,
    'selected' => false,
    'isSelected' => null,
    'expandHeader' => 'expand',
    'expandIconDescription' => 'Expand row',
    'disabled' => false,
])

@php
    $isExpanded = is_null($isExpanded) ? (bool) $expanded : (bool) $isExpanded;
    $isSelected = is_null($isSelected) ? (bool) $selected : (bool) $isSelected;
    $previousValue = $isExpanded ? 'collapsed' : null;
@endphp

<tr
    {{ $attributes->class([
        'ui-parent-row',
        'ui-expandable-row' => $isExpanded,
        'ui-data-table--selected' => $isSelected,
        'ui-data-table-selected' => $isSelected,
        'ui-data-table-row-disabled' => $disabled,
    ]) }}
    data-parent-row
    data-ui-table-expand-parent
    @if ($disabled) aria-disabled="true" @endif
>
    <td
        class="ui-table-expand"
        headers="{{ $expandHeader }}"
        @if ($previousValue) data-previous-value="{{ $previousValue }}" @endif
    >
        <button
            type="button"
            class="ui-table-expand__button"
            title="{{ $expandIconDescription }}"
            aria-label="{{ $ariaLabel }}"
            aria-expanded="{{ $isExpanded ? 'true' : 'false' }}"
            @if ($ariaControls) aria-controls="{{ $ariaControls }}" @endif
            @disabled($disabled)
            data-ui-table-expand-trigger
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
    </td>

    {{ $slot }}
</tr>
