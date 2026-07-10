{{-- ==========================================================================
    File: resources/views/components/shell/side-nav/icon.blade.php
    Purpose: UI shell side navigation icon wrapper.

    Notes:
    - Renders the standard icon container used by side navigation links, menus,
      headers, and custom side navigation content.
    - Supports a smaller icon bounding box for compact submenu/rail contexts.
    - Accepts either a canonical icon name or slotted icon content.
    ========================================================================== --}}

@props([
    'icon' => null,
    'small' => false,
])

@php
    /*
    |--------------------------------------------------------------------------
    | CSS class contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-shell-side-nav__icon',
        'ui-shell-side-nav__icon--small' => (bool) $small,
    ];
@endphp

<span
    {{ $attributes->class($classes)->merge([
        'aria-hidden' => $attributes->get('aria-hidden', 'true'),
        'data-ui-shell-side-nav-icon' => true,
        'data-ui-shell-side-nav-icon-small' => $small ? 'true' : 'false',
    ]) }}
>
    @if ($icon)
        <x-ui.icon
            :name="$icon"
            class="ui-shell-side-nav__icon-svg"
        />
    @else
        {{ $slot }}
    @endif
</span>
