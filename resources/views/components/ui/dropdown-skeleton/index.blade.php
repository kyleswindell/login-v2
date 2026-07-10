{{-- ==========================================================================
    File: resources/views/components/ui/dropdown-skeleton/index.blade.php
    Purpose: Dropdown skeleton/loading placeholder component.

    Notes:
    - Emits the installed .ui-dropdown skeleton selector contract.
    - Supports hidden label and ListBox sizing.
    - Uses skeleton animation styles from resources/css/base/skeleton.css.
    - Uses Dropdown/ListBox styles from resources/css/components/dropdown.css.
    - Does not render an interactive dropdown.
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
        'ui-skeleton',
        'ui-form-item',
    ];

    $labelClasses = [
        'ui-label',
        'ui-skeleton',
    ];

    $dropdownClasses = [
        'ui-skeleton',
        'ui-dropdown',
        'ui-list-box--'.$resolvedSize => filled($resolvedSize),
    ];
@endphp

<div
    aria-hidden="true"
    {{ $attributes->class($wrapperClasses)->merge(['data-ui-component' => 'dropdown-skeleton']) }}
>
    @unless ($hideLabel)
        <span @class($labelClasses)></span>
    @endunless

    <div @class($dropdownClasses)></div>
</div>