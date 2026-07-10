{{-- ==========================================================================
    File: resources/views/components/shell/side-nav/menu-item.blade.php
    Purpose: UI shell side navigation submenu item.

    Notes:
    - Renders an item inside x-shell.side-nav.menu.
    - Supports active/current-page state.
    - Supports normal links by default and button rendering when as="button".
    - Text is wrapped in x-shell.side-nav.link-text for the shared side-nav
      text selector contract.
    ========================================================================== --}}

@props([
    'as' => 'a',
    'href' => null,
    'active' => false,
    'isActive' => null,
    'current' => null,
    'ariaCurrent' => null,
    'wireNavigate' => false,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Resolve values
    |--------------------------------------------------------------------------
    */

    $resolvedTag = $as === 'button' ? 'button' : 'a';

    $isItemActive = ! is_null($isActive)
        ? (bool) $isActive
        : (! is_null($current) ? (bool) $current : (bool) $active);

    $resolvedHref = $href ?? $attributes->get('href') ?? '#';

    $resolvedAriaCurrent = $ariaCurrent ?? $attributes->get('aria-current');

    /*
    |--------------------------------------------------------------------------
    | CSS class contract
    |--------------------------------------------------------------------------
    */

    $itemClasses = [
        'ui-shell-side-nav__menu-item',
    ];

    $linkClasses = [
        'ui-shell-side-nav__link',
        'ui-shell-side-nav__link--current' => $isItemActive,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute handling
    |--------------------------------------------------------------------------
    */

    $controlAttributes = $attributes->except([
        'href',
        'aria-current',
    ]);
@endphp

<li
    @class($itemClasses)
    data-ui-shell-side-nav-menu-item
>
    @if ($resolvedTag === 'button')
        <button
            type="button"
            {{ $controlAttributes->class($linkClasses)->merge([
                'aria-current' => $isItemActive ? 'page' : $resolvedAriaCurrent,
                'data-ui-shell-side-nav-menu-item-control' => true,
                'data-ui-shell-side-nav-menu-item-active' => $isItemActive ? 'true' : 'false',
            ]) }}
        >
            <x-shell.side-nav.link-text>
                {{ $slot }}
            </x-shell.side-nav.link-text>
        </button>
    @else
        <a
            href="{{ $resolvedHref }}"
            @if ($wireNavigate) wire:navigate @endif
            {{ $controlAttributes->class($linkClasses)->merge([
                'aria-current' => $isItemActive ? 'page' : $resolvedAriaCurrent,
                'data-ui-shell-side-nav-menu-item-control' => true,
                'data-ui-shell-side-nav-menu-item-active' => $isItemActive ? 'true' : 'false',
            ]) }}
        >
            <x-shell.side-nav.link-text>
                {{ $slot }}
            </x-shell.side-nav.link-text>
        </a>
    @endif
</li>
