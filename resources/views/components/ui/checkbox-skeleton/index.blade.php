{{-- ==========================================================================
    File: resources/views/components/ui/checkbox-skeleton/index.blade.php
    Purpose: Checkbox skeleton/loading placeholder component.

    Notes:
    - Emits the installed .ui-checkbox skeleton selector contract.
    - Uses skeleton animation styles from resources/css/base/skeleton.css.
    - Uses Checkbox styles from resources/css/components/checkbox.css.
    - Does not render an interactive input.
    ========================================================================== --}}

@props([])

@php
/*
|--------------------------------------------------------------------------
| CSS class contract
|--------------------------------------------------------------------------
|
| These classes must match checkbox.css and skeleton.css.
|
*/

$wrapperClasses = [
'ui-form-item',
'ui-checkbox-wrapper',
'ui-checkbox-skeleton',
];

$labelTextClasses = [
'ui-checkbox-label-text',
'ui-skeleton',
];
@endphp

<div
    aria-hidden="true"
    {{ $attributes->class($wrapperClasses)->merge(['data-ui-component' => 'checkbox-skeleton']) }}>
    <div class="ui-checkbox-label">
        <span @class($labelTextClasses)></span>
    </div>
</div>