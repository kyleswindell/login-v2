{{-- ==========================================================================
    File: resources/views/components/shell/side-nav/items.blade.php
    Purpose: UI shell side navigation items list.

    Notes:
    - Renders the structural <ul> wrapper for side navigation items.
    - Keeps local expanded state aligned with the parent side navigation when
      provided.
    - Child items should usually be x-shell.side-nav.item, x-shell.side-nav.link,
      or x-shell.side-nav.menu.
    ========================================================================== --}}

@props([
    'expanded' => null,
    'isSideNavExpanded' => null,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Resolve values
    |--------------------------------------------------------------------------
    */

    $resolvedExpanded = ! is_null($isSideNavExpanded)
        ? (bool) $isSideNavExpanded
        : (! is_null($expanded) ? (bool) $expanded : null);

    /*
    |--------------------------------------------------------------------------
    | CSS class contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-shell-side-nav__items',
    ];
@endphp

<ul
    {{ $attributes->class($classes)->merge([
        'data-ui-shell-side-nav-items' => true,
        'data-ui-shell-side-nav-items-expanded' => is_null($resolvedExpanded) ? null : ($resolvedExpanded ? 'true' : 'false'),
    ]) }}
>
    {{ $slot }}
</ul>
