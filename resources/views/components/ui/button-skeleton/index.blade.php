{{-- ==========================================================================
    File: resources/views/components/ui/button-skeleton/index.blade.php
    Purpose: Button skeleton/loading placeholder component.

    Notes:
    - Emits the canonical .ui-btn skeleton selector contract.
    - Matches the Button size API used by resources/views/components/ui/button/index.blade.php.
    - Uses skeleton animation styles from resources/css/base/skeleton.css.
    - Uses Button skeleton support from resources/css/components/button.css.
    - Does not render interactive button content.
    ========================================================================== --}}

@props([
'href' => null,
'size' => 'lg',
'small' => false,
])

@php
/*
|--------------------------------------------------------------------------
| Supported public values
|--------------------------------------------------------------------------
|
| The `small` prop is retained as a compatibility alias for size="sm".
|
*/

$allowedSizes = ['xs', 'sm', 'md', 'lg', 'xl', '2xl'];

/*
|--------------------------------------------------------------------------
| Resolve size
|--------------------------------------------------------------------------
*/

$resolvedSize = $small
? 'sm'
: (in_array($size, $allowedSizes, true) ? $size : 'lg');

/*
|--------------------------------------------------------------------------
| CSS class contract
|--------------------------------------------------------------------------
|
| These classes must match resources/css/components/button.css and the base
| skeleton utility styles.
|
*/

$classes = [
'ui-btn',
'ui-btn--'.$resolvedSize,
'ui-layout--size-'.$resolvedSize,
'ui-skeleton',
];
@endphp

@if (filled($href))
{{-- ----------------------------------------------------------------------
        Anchor skeleton rendering
        ----------------------------------------------------------------------
        Used when a skeleton should preserve link-button layout.
        ---------------------------------------------------------------------- --}}

<a
    href="{{ $href }}"
    role="button"
    aria-hidden="true"
    tabindex="-1"
    {{ $attributes->class($classes)->merge(['data-ui-component' => 'button-skeleton']) }}></a>
@else
{{-- ----------------------------------------------------------------------
        Block skeleton rendering
        ----------------------------------------------------------------------
        Default skeleton output for a non-interactive button placeholder.
        ---------------------------------------------------------------------- --}}

<div
    aria-hidden="true"
    {{ $attributes->class($classes)->merge(['data-ui-component' => 'button-skeleton']) }}></div>
@endif