{{-- ==========================================================================
    File: resources/views/components/ui/radio-button-skeleton/index.blade.php
    Purpose: Radio Button skeleton/loading placeholder component.

    Notes:
    - Emits the installed .ui-radio-button skeleton selector contract.
    - Uses skeleton animation styles from resources/css/base/skeleton.css.
    - Uses Radio Button styles from resources/css/components/radio-button.css.
    - Does not render an interactive input.
    ========================================================================== --}}

@props([])

@php
/*
|--------------------------------------------------------------------------
| CSS class contract
|--------------------------------------------------------------------------
|
| These classes must match radio-button.css and skeleton.css.
|
*/

$wrapperClasses = [
'ui-radio-button-wrapper',
'ui-radio-button-wrapper--skeleton',
];

$inputClasses = [
'ui-radio-button',
'ui-skeleton',
];

$labelClasses = [
'ui-radio-button__label',
'ui-skeleton',
];
@endphp

<div
    aria-hidden="true"
    {{ $attributes->class($wrapperClasses)->merge(['data-ui-component' => 'radio-button-skeleton']) }}>
    <div @class($inputClasses)></div>
    <span @class($labelClasses)></span>
</div>