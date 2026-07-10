{{-- ==========================================================================
    File: resources/views/components/ui/icon-skeleton/index.blade.php
    Purpose: Icon skeleton/loading placeholder component.

    Notes:
    - Emits the installed icon skeleton selector contract.
    - Uses base skeleton animation styles from resources/css/base/skeleton.css.
    - Intended for icon-only loading placeholders.
    - Does not render interactive content.
    ========================================================================== --}}

@props([
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
| Resolve size
|--------------------------------------------------------------------------
*/

$resolvedSize = in_array($size, $allowedSizes, true) ? $size : 'md';

/*
|--------------------------------------------------------------------------
| CSS class contract
|--------------------------------------------------------------------------
*/

$classes = [
'ui-icon--skeleton',
'ui-icon--skeleton-'.$resolvedSize,
'ui-skeleton',
];
@endphp

<div
    aria-hidden="true"
    {{ $attributes->class($classes)->merge(['data-ui-component' => 'icon-skeleton']) }}></div>