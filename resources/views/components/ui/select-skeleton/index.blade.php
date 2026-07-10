{{-- ==========================================================================
    File: resources/views/components/ui/select-skeleton/index.blade.php
    Purpose: Select skeleton/loading placeholder component.

    Notes:
    - Emits the installed .ui-select skeleton selector contract.
    - Supports hidden label.
    - Uses skeleton animation styles from resources/css/base/skeleton.css.
    - Uses Select styles from resources/css/components/select.css.
    - Does not render an interactive select.
    ========================================================================== --}}

@props([
'hideLabel' => false,
])

@php
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

$selectClasses = [
'ui-select',
'ui-skeleton',
];
@endphp

<div
    aria-hidden="true"
    {{ $attributes->class($wrapperClasses)->merge(['data-ui-component' => 'select-skeleton']) }}>
    @unless ($hideLabel)
    <span @class($labelClasses)></span>
    @endunless

    <div @class($selectClasses)>
        <div class="ui-select-input"></div>
    </div>
</div>