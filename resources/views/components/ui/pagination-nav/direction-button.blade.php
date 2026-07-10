{{-- ==========================================================================
    File: resources/views/components/ui/pagination-nav/direction-button.blade.php
    Purpose: UI pagination navigation direction button.

    Source: Converted from the Carbon PaginationNav DirectionButton helper.

    Notes:
    - Renders the previous/next list item and icon-only button.
    - Provides default caret icons through x-ui.icon.
    ========================================================================== --}}

@props([
    'direction' => 'forward',
    'label' => null,
    'disabled' => false,
    'tooltipAlignment' => 'center',
    'tooltipPosition' => 'bottom',
])

@php
    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedDirections = [
        'forward',
        'backward',
    ];

    $allowedTooltipAlignments = [
        'start',
        'center',
        'end',
    ];

    $allowedTooltipPositions = [
        'top',
        'right',
        'bottom',
        'left',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedDirection = in_array($direction, $allowedDirections, true)
        ? $direction
        : 'forward';

    $resolvedLabel = $label ?? ($resolvedDirection === 'forward' ? 'Next' : 'Previous');

    $resolvedTooltipAlignment = in_array($tooltipAlignment, $allowedTooltipAlignments, true)
        ? $tooltipAlignment
        : 'center';

    $resolvedTooltipPosition = in_array($tooltipPosition, $allowedTooltipPositions, true)
        ? $tooltipPosition
        : 'bottom';

    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);

    $iconName = $resolvedDirection === 'forward'
        ? 'caret--right'
        : 'caret--left';

    $hasSlotContent = trim($slot->toHtml()) !== '';

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    */

    $buttonAttributes = $attributes->except([
        'disabled',
    ]);
@endphp

<li
    class="ui-pagination-nav__list-item"
    data-ui-pagination-nav-list-item
>
    <button
        type="button"
        {{ $buttonAttributes->class([
            'ui-button',
            'ui-button--ghost',
            'ui-button--icon-only',
            'ui-btn',
            'ui-btn--ghost',
            'ui-btn--icon-only',
        ])->merge([
            'aria-label' => $resolvedLabel,
            'title' => $resolvedLabel,
            'data-ui-pagination-nav-direction' => $resolvedDirection,
            'data-ui-pagination-nav-direction-disabled' => $isDisabled ? 'true' : 'false',
            'data-ui-tooltip-alignment' => $resolvedTooltipAlignment,
            'data-ui-tooltip-position' => $resolvedTooltipPosition,
        ]) }}
        @disabled($isDisabled)
    >
        @if ($hasSlotContent)
            {{ $slot }}
        @else
            <x-ui.icon name="{{ $iconName }}" aria-hidden="true" />
        @endif
    </button>
</li>