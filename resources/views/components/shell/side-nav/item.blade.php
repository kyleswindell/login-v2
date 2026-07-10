{{-- ==========================================================================
    File: resources/views/components/shell/side-nav/item.blade.php
    Purpose: UI shell side navigation list item.

    Notes:
    - Renders the structural <li> wrapper used by side navigation links,
      menus, icons, and custom side navigation content.
    - Supports the large side navigation item variation.
    - Interactive behavior belongs to the child link/menu component, not this
      structural wrapper.
    ========================================================================== --}}

@props([
    'large' => false,
])

@php
    /*
    |--------------------------------------------------------------------------
    | CSS class contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-shell-side-nav__item',
        'ui-shell-side-nav__item--large' => (bool) $large,
    ];
@endphp

<li
    {{ $attributes->class($classes)->merge([
        'data-ui-shell-side-nav-item' => true,
    ]) }}
>
    {{ $slot }}
</li>