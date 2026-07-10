{{-- ==========================================================================
    File: resources/views/components/ui/overflow-menu/index.blade.php
    Purpose: Icon-triggered overflow menu component.

    Notes:
    - Emits the canonical .ui-overflow-menu wrapper selector contract.
    - Composes x-ui.menu with an icon trigger.
    - Uses x-ui.menu for menu surface rendering, item-array rendering, slot
      rendering, placement, open state, disabled state, and menu behavior hooks.
    - Uses x-ui.icon-button through x-ui.menu trigger icon mode.
    - Overflow menu behavior, keyboard handling, outside-click dismissal,
      focus return, and positioning are handled by installed menu JavaScript.
    - Use x-ui.menu-button for visible text button-triggered action menus.
    ========================================================================== --}}

@props([
    'items' => [],
    'label' => 'More actions',
    'ariaLabel' => null,
    'tooltip' => null,
    'size' => 'md',
    'align' => 'bottom-end',
    'placement' => null,
    'open' => false,
    'disabled' => false,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedSizes = [
        'xs',
        'sm',
        'md',
        'lg',
    ];

    $allowedPlacements = [
        'top',
        'top-start',
        'top-end',
        'bottom',
        'bottom-start',
        'bottom-end',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Placement
    |--------------------------------------------------------------------------
    |
    | placement is canonical when provided. align is retained as the older app
    | alias. start/end resolve to bottom-start/bottom-end.
    |
    */

    $requestedPlacement = $placement ?? $align;

    $resolvedPlacement = match ($requestedPlacement) {
        'start' => 'bottom-start',
        'end' => 'bottom-end',
        'top',
        'top-start',
        'top-end',
        'bottom',
        'bottom-start',
        'bottom-end' => $requestedPlacement,
        default => 'bottom-end',
    };

    $resolvedPlacement = in_array($resolvedPlacement, $allowedPlacements, true)
        ? $resolvedPlacement
        : 'bottom-end';

    /*
    |--------------------------------------------------------------------------
    | Resolve Size and State
    |--------------------------------------------------------------------------
    */

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : 'md';

    $isOpen = (bool) $open && ! (bool) $disabled;
    $isDisabled = (bool) $disabled;

    /*
    |--------------------------------------------------------------------------
    | Resolve Accessible Label
    |--------------------------------------------------------------------------
    */

    $resolvedAriaLabel = $ariaLabel
        ?? $attributes->get('aria-label')
        ?? $label
        ?? 'More actions';

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-overflow-menu',
        'ui-overflow-menu-'.$resolvedSize,
        'ui-overflow-menu-open' => $isOpen,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    |
    | aria-label is owned by the nested icon trigger. Root classes and data hooks
    | stay on the overflow menu wrapper.
    |
    */

    $rootAttributes = $attributes->except([
        'aria-label',
    ]);
@endphp

<div
    {{ $rootAttributes->class($classes)->merge([
        'data-ui-component' => 'overflow-menu',
        'data-ui-overflow-menu' => true,
        'data-ui-overflow-menu-size' => $resolvedSize,
        'data-ui-overflow-menu-placement' => $resolvedPlacement,
        'data-ui-overflow-menu-open' => $isOpen ? 'true' : 'false',
        'data-ui-overflow-menu-disabled' => $isDisabled ? 'true' : 'false',
    ]) }}
>
    {{-- ----------------------------------------------------------------------
        Menu composition
        ----------------------------------------------------------------------
        x-ui.menu owns the icon trigger and menu surface. This wrapper supplies
        the overflow-specific class contract and default trigger configuration.
        ---------------------------------------------------------------------- --}}

    <x-ui.menu
        :items="$items"
        :trigger-label="$resolvedAriaLabel"
        :trigger-tooltip="$tooltip"
        :menu-label="$label"
        trigger-kind="icon"
        trigger-icon="overflow-menu--vertical"
        trigger-variant="ghost"
        :size="$resolvedSize"
        :placement="$resolvedPlacement"
        :open="$isOpen"
        :disabled="$isDisabled"
        trigger-class="ui-overflow-menu-trigger"
        data-ui-menu-button-kind="overflow"
    />
</div>