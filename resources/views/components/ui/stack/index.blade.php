{{-- ==========================================================================
    File: resources/views/components/ui/stack/index.blade.php
    Purpose: UI stack layout utility.

    Source: Converted from the Carbon Stack React component.

    Notes:
    - Renders a layout container with vertical or horizontal stack classes.
    - Supports a custom element tag through the as prop.
    - Supports numeric spacing-scale gap classes.
    - Supports custom CSS gap values through --ui-stack-gap.
    - Used directly by x-ui.stack and indirectly by x-ui.v-stack / x-ui.h-stack.
    ========================================================================== --}}

@props([
    'as' => 'div',
    'gap' => null,
    'orientation' => 'vertical',
])

@php
    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedTags = [
        'div',
        'span',
        'section',
        'article',
        'aside',
        'header',
        'footer',
        'main',
        'nav',
        'form',
        'fieldset',
        'ul',
        'ol',
        'li',
        'dl',
        'dt',
        'dd',
    ];

    $allowedOrientations = [
        'horizontal',
        'vertical',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $requestedTag = is_string($as) ? strtolower(trim($as)) : 'div';

    $resolvedTag = in_array($requestedTag, $allowedTags, true)
        ? $requestedTag
        : 'div';

    $resolvedOrientation = in_array($orientation, $allowedOrientations, true)
        ? $orientation
        : 'vertical';

    /*
    |--------------------------------------------------------------------------
    | Gap Handling
    |--------------------------------------------------------------------------
    |
    | Integer gap values use scale classes. String values that are not integers
    | are treated as custom CSS gap values through --ui-stack-gap.
    |
    */

    $gapValue = is_null($gap) ? null : trim((string) $gap);

    $isScaleGap = ! is_null($gapValue) && preg_match('/^\d+$/', $gapValue) === 1;
    $resolvedScaleGap = $isScaleGap ? (string) max(0, min(13, (int) $gapValue)) : null;

    $isCustomGap = filled($gapValue) && ! $isScaleGap;
    $resolvedGapType = $isScaleGap ? 'scale' : ($isCustomGap ? 'custom' : 'none');

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = array_filter([
        'ui-stack',
        'ui-stack--'.$resolvedOrientation,
        'ui-stack-'.$resolvedOrientation,
        ! is_null($resolvedScaleGap) ? 'ui-stack-scale-'.$resolvedScaleGap : null,
    ]);

    /*
    |--------------------------------------------------------------------------
    | Inline Style Handling
    |--------------------------------------------------------------------------
    */

    $existingStyle = trim((string) $attributes->get('style'));
    $customGapStyle = $isCustomGap ? "--ui-stack-gap: {$gapValue};" : null;

    $resolvedStyle = trim(collect([
        $existingStyle,
        $customGapStyle,
    ])->filter()->implode(' '));

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    */

    $stackAttributes = $attributes->except('style');
@endphp

<{{ $resolvedTag }}
    {{ $stackAttributes->class($classes)->merge([
        'data-ui-component' => 'stack',
        'data-ui-stack' => true,
        'data-ui-stack-as' => $resolvedTag,
        'data-ui-stack-orientation' => $resolvedOrientation,
        'data-ui-stack-gap-type' => $resolvedGapType,
        'data-ui-stack-gap' => $gapValue,
    ]) }}
    @if ($resolvedStyle !== '') style="{{ $resolvedStyle }}" @endif
>
    {{ $slot }}
</{{ $resolvedTag }}>