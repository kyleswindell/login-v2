{{-- ==========================================================================
    File: resources/views/components/ui/text-area-skeleton/index.blade.php
    Purpose: Text Area skeleton/loading placeholder component.

    Notes:
    - Emits the installed .ui-text-area skeleton selector contract.
    - Supports hidden label.
    - Uses skeleton animation styles from resources/css/base/skeleton.css.
    - Uses Text Area styles from resources/css/components/text-area.css.
    - Does not render an interactive textarea.
    ========================================================================== --}}

@props([
'hideLabel' => false,
])

@php
/*
|--------------------------------------------------------------------------
| CSS class contract
|--------------------------------------------------------------------------
|
| These classes must match text-area.css and skeleton.css.
|
*/

$wrapperClasses = [
'ui-form-item',
];

$labelClasses = [
'ui-label',
'ui-skeleton',
];

$textareaClasses = [
'ui-skeleton',
'ui-text-area',
];
@endphp

<div
    aria-hidden="true"
    {{ $attributes->class($wrapperClasses)->merge(['data-ui-component' => 'text-area-skeleton']) }}>
    @unless ($hideLabel)
    <span @class($labelClasses)></span>
    @endunless

    <div @class($textareaClasses)></div>
</div>