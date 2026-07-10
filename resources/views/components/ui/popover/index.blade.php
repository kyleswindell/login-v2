{{-- ==========================================================================
    File: resources/views/components/ui/popover/index.blade.php
    Purpose: Popover container component.

    Source: Ported from Carbon React Popover.

    Notes:
    - Mirrors Carbon's outer Popover render contract.
    - Outer container owns alignment, open, caret, border, shadow, contrast,
      auto-align, tab-tip, and background-token modifier classes.
    - Trigger and PopoverContent are passed as children through the default slot.
    - In React, child cloning/ref behavior is handled by React. In Blade, the
      consumer must provide the trigger element and content element explicitly.
    ========================================================================== --}}

@props([
    /*
    |--------------------------------------------------------------------------
    | Carbon Popover props
    |--------------------------------------------------------------------------
    */

    'align' => null,
    'alignmentAxisOffset' => null,
    'as' => 'span',
    'autoAlign' => false,
    'autoAlignBoundary' => null,
    'backgroundToken' => 'layer',
    'caret' => null,
    'border' => false,
    'dropShadow' => true,
    'highContrast' => false,
    'isTabTip' => false,
    'open' => false,

    /*
    |--------------------------------------------------------------------------
    | Local Blade / JS support props
    |--------------------------------------------------------------------------
    */

    'id' => null,
    'interaction' => 'click',
])

@php
    /*
    |--------------------------------------------------------------------------
    | Resolve base element
    |--------------------------------------------------------------------------
    */

    $allowedElements = [
        'span',
        'div',
        'section',
        'aside',
    ];

    $componentTag = in_array($as, $allowedElements, true)
        ? $as
        : 'span';

    /*
    |--------------------------------------------------------------------------
    | Resolve alignment
    |--------------------------------------------------------------------------
    */

    $deprecatedAlignmentMap = [
        'top-left' => 'top-start',
        'top-right' => 'top-end',
        'bottom-left' => 'bottom-start',
        'bottom-right' => 'bottom-end',
        'left-top' => 'left-start',
        'left-bottom' => 'left-end',
        'right-top' => 'right-start',
        'right-bottom' => 'right-end',
    ];

    $allowedAlignments = [
        'top',
        'bottom',
        'left',
        'right',
        'top-start',
        'top-end',
        'bottom-start',
        'bottom-end',
        'left-end',
        'left-start',
        'right-end',
        'right-start',
    ];

    $initialAlign = $align
        ?? ($isTabTip ? 'bottom-start' : 'bottom');

    $mappedAlign = $deprecatedAlignmentMap[$initialAlign] ?? $initialAlign;

    $resolvedAlign = in_array($mappedAlign, $allowedAlignments, true)
        ? $mappedAlign
        : ($isTabTip ? 'bottom-start' : 'bottom');

    if ($isTabTip && ! in_array($resolvedAlign, ['bottom-start', 'bottom-end'], true)) {
        $resolvedAlign = 'bottom-start';
    }

    /*
    |--------------------------------------------------------------------------
    | Resolve booleans / modifiers
    |--------------------------------------------------------------------------
    */

    $resolvedCaret = $caret;

    if ($resolvedCaret === null) {
        $resolvedCaret = ! $isTabTip;
    }

    $resolvedBackgroundToken = in_array($backgroundToken, ['layer', 'background'], true)
        ? $backgroundToken
        : 'layer';

    $resolvedInteraction = in_array($interaction, ['click', 'hover', 'focus'], true)
        ? $interaction
        : 'click';

    /*
    |--------------------------------------------------------------------------
    | Class contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-popover-container',

        // React-equivalent modifier classes.
        'ui-popover--caret' => $resolvedCaret,
        'ui-popover--drop-shadow' => $dropShadow,
        'ui-popover--border' => $border,
        'ui-popover--high-contrast' => $highContrast,
        'ui-popover--open' => $open,
        'ui-popover--auto-align' => $autoAlign,
        'ui-autoalign' => $autoAlign,
        "ui-popover--{$resolvedAlign}",
        'ui-popover--tab-tip' => $isTabTip,
        'ui-popover--background-token__background' => $resolvedBackgroundToken === 'background' && ! $highContrast,

        // Compatibility classes for the existing converted CSS.
        'ui-popover-caret' => $resolvedCaret,
        'ui-popover-drop-shadow' => $dropShadow,
        'ui-popover-border' => $border,
        'ui-popover-high-contrast' => $highContrast,
        'ui-popover-open' => $open,
        'ui-popover-auto-align' => $autoAlign,
        "ui-popover-{$resolvedAlign}",
        'ui-popover-tab-tip' => $isTabTip,
        'ui-popover-background-token-background' => $resolvedBackgroundToken === 'background' && ! $highContrast,
    ];

    $resolvedId = $id ?? 'popover-'.str()->random(8);
@endphp

<{{ $componentTag }}
    {{ $attributes->class($classes)->merge([
        'id' => $resolvedId,
        'data-ui-component' => 'popover',
        'data-ui-popover' => true,
        'data-ui-popover-align' => $resolvedAlign,
        'data-ui-popover-open' => $open ? 'true' : 'false',
        'data-ui-popover-caret' => $resolvedCaret ? 'true' : 'false',
        'data-ui-popover-border' => $border ? 'true' : 'false',
        'data-ui-popover-drop-shadow' => $dropShadow ? 'true' : 'false',
        'data-ui-popover-high-contrast' => $highContrast ? 'true' : 'false',
        'data-ui-popover-auto-align' => $autoAlign ? 'true' : 'false',
        'data-ui-popover-tab-tip' => $isTabTip ? 'true' : 'false',
        'data-ui-popover-background-token' => $resolvedBackgroundToken,
        'data-ui-popover-interaction' => $resolvedInteraction,
        'data-ui-popover-alignment-axis-offset' => $alignmentAxisOffset,
        'data-ui-popover-auto-align-boundary' => is_scalar($autoAlignBoundary) ? $autoAlignBoundary : null,
    ]) }}
>
    {{ $slot }}
</{{ $componentTag }}>