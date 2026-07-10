{{-- ==========================================================================
    File: resources/views/components/ui/number-input-skeleton/index.blade.php
    Purpose: Number Input skeleton/loading placeholder component.

    Notes:
    - Emits the installed .ui-number skeleton selector contract.
    - Supports hidden label and Number Input sizing.
    - Uses skeleton animation styles from resources/css/base/skeleton.css.
    - Uses Number Input styles from resources/css/components/number-input.css.
    - Does not render an interactive input.
    ========================================================================== --}}

@props([
    'hideLabel' => false,
    'size' => 'md',
])

@php
    /*
    |--------------------------------------------------------------------------
    | Supported public values
    |--------------------------------------------------------------------------
    */

    $allowedSizes = ['sm', 'md', 'lg'];

    /*
    |--------------------------------------------------------------------------
    | Resolve values
    |--------------------------------------------------------------------------
    */

    $resolvedSize = in_array($size, $allowedSizes, true) ? $size : 'md';

    /*
    |--------------------------------------------------------------------------
    | CSS class contract
    |--------------------------------------------------------------------------
    */

    $wrapperClasses = [
        'ui-form-item',
    ];

    $labelClasses = [
        'ui-label',
        'ui-skeleton',
    ];

    $numberClasses = [
        'ui-number',
        'ui-skeleton',
        'ui-number--'.$resolvedSize,
    ];
@endphp

<div
    aria-hidden="true"
    {{ $attributes->class($wrapperClasses)->merge(['data-ui-component' => 'number-input-skeleton']) }}
>
    @unless ($hideLabel)
        <span @class($labelClasses)></span>
    @endunless

    <div @class($numberClasses)></div>
</div>