{{-- ==========================================================================
    File: resources/views/components/ui/button-set/index.blade.php
    Purpose: Button Set layout wrapper for grouping related Button components.

    Notes:
    - Emits the canonical .ui-btn-set selector contract.
    - Use with resources/views/components/ui/button/index.blade.php children.
    - Fluid mode wraps children in .ui-btn-set__fluid-inner for container-query stacking.
    - Fluid mode ignores the stacked prop.
    - Carbon order mode visually orders buttons by kind so primary/destructive
      actions sit on the outside edge of the set.
    - Source order mode is available for rare custom layouts.
    - Layout styles are handled by resources/css/components/button.css.
    ========================================================================== --}}

@props ([
    "fluid" => false,
    "stacked" => false,
    "autoStack" => true,
    "width" => null,
    "align" => null,
    "order" => "carbon",
])

@php
    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isFluid = filter_var($fluid, FILTER_VALIDATE_BOOLEAN);
    $isStacked = ! $isFluid && filter_var($stacked, FILTER_VALIDATE_BOOLEAN);
    $usesAutoStack = $isFluid && filter_var($autoStack, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | Width, Alignment, And Ordering
    |--------------------------------------------------------------------------
    */

    $allowedWidths = ['half', 'full'];
    $allowedAlignments = ['start', 'end', 'stretch'];
    $allowedOrders = ['carbon', 'source'];

    $resolvedWidth = $isFluid && is_string($width) && in_array($width, $allowedWidths, true)
        ? $width
        : null;

    $resolvedAlign = is_string($align) && in_array($align, $allowedAlignments, true)
        ? $align
        : null;

    $resolvedOrder = is_string($order) && in_array($order, $allowedOrders, true)
        ? $order
        : 'carbon';

    if ($isFluid && $resolvedWidth === 'half' && $resolvedAlign === null) {
        $resolvedAlign = 'end';
    }

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-btn-set',
        'ui-btn-set--stacked' => $isStacked,
        'ui-btn-set--fluid' => $isFluid,
        'ui-btn-set--width-'.$resolvedWidth => filled($resolvedWidth),
        'ui-btn-set--align-'.$resolvedAlign => filled($resolvedAlign),
        'ui-btn-set--order-'.$resolvedOrder,
    ];

    $fluidInnerClasses = [
        'ui-btn-set__fluid-inner',
        'ui-btn-set__fluid-inner--auto-stack' => $usesAutoStack,
    ];
@endphp

<div
    {{
        $attributes->class($classes)->merge([
            "data-ui-component" => "button-set",
            "data-ui-button-set" => true,
            "data-ui-button-set-fluid" => $isFluid ? "true" : "false",
            "data-ui-button-set-stacked" => $isStacked ? "true" : "false",
            "data-ui-button-set-auto-stack" => $usesAutoStack ? "true" : "false",
            "data-ui-button-set-width" => $resolvedWidth ?? "auto",
            "data-ui-button-set-align" => $resolvedAlign ?? "auto",
            "data-ui-button-set-order" => $resolvedOrder,
        ])
    }}
>
    @if ($isFluid)
        <div @class ($fluidInnerClasses) data-ui-button-set-fluid-inner>
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif
</div>
