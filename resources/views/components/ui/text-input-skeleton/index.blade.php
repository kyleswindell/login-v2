{{-- ==========================================================================
    File: resources/views/components/ui/text-input-skeleton/index.blade.php
    Purpose: Text Input skeleton/loading placeholder component.

    Notes:
    - Emits the installed .ui-text-input skeleton selector contract.
    - Supports hidden label and Text Input sizing.
    - Uses skeleton animation styles from resources/css/base/skeleton.css.
    - Uses Text Input styles from resources/css/components/text-input.css.
    - Does not render an interactive input.
    ========================================================================== --}}

@props([
'hideLabel' => false,
'size' => null,
])

@php
/*
|--------------------------------------------------------------------------
| Supported public values
|--------------------------------------------------------------------------
*/

$allowedSizes = ['xs', 'sm', 'md', 'lg'];

/*
|--------------------------------------------------------------------------
| Resolve values
|--------------------------------------------------------------------------
*/

$resolvedSize = in_array($size, $allowedSizes, true) ? $size : null;

/*
|--------------------------------------------------------------------------
| CSS class contract
|--------------------------------------------------------------------------
*/

$wrapperClasses = [
'ui-form-item',
'ui-layout--size-'.$resolvedSize => filled($resolvedSize),
];

$labelClasses = [
'ui-label',
'ui-skeleton',
];

$inputClasses = [
'ui-skeleton',
'ui-text-input',
'ui-layout--size-'.$resolvedSize => filled($resolvedSize),
];
@endphp

<div
    aria-hidden="true"
    {{ $attributes->class($wrapperClasses)->merge(['data-ui-component' => 'text-input-skeleton']) }}>
    @unless ($hideLabel)
    <span @class($labelClasses)></span>
    @endunless

    <div @class($inputClasses)></div>
</div>