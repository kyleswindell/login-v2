{{-- ==========================================================================
    File: resources/views/components/shell/header-side-nav-items.blade.php
    Purpose: UI shell side navigation container for header navigation items.

    Notes:
    - Renders header navigation items inside the side navigation.
    - Used when header navigation should collapse into the side nav on smaller
      viewports.
    - Supports an optional divider between header-derived navigation items and
      primary side navigation items.
    ========================================================================== --}}

@props([
    'divider' => false,
    'hasDivider' => null,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Resolve values
    |--------------------------------------------------------------------------
    */

    $hasBottomDivider = ! is_null($hasDivider)
        ? (bool) $hasDivider
        : (bool) $divider;

    /*
    |--------------------------------------------------------------------------
    | CSS class contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-shell-side-nav__header-navigation',
        'ui-shell-side-nav__header-divider' => $hasBottomDivider,
    ];
@endphp

<ul
    {{ $attributes->class($classes)->merge([
        'data-ui-shell-header-side-nav-items' => true,
        'data-ui-shell-header-side-nav-items-divider' => $hasBottomDivider ? 'true' : 'false',
    ]) }}
>
    {{ $slot }}
</ul>