{{-- ==========================================================================
    File: resources/views/components/shell/header-menu-item.blade.php
    Purpose: UI shell header menu item.

    Notes:
    - Renders an item inside shell header navigation or header submenu lists.
    - Supports active/current-page state.
    - Supports normal links by default and button rendering when as="button".
    - Keeps text truncation inside a dedicated label span.
    ========================================================================== --}}

@props([
    'as' => 'a',
    'href' => null,
    'active' => false,
    'isActive' => null,
    'isCurrentPage' => null,
    'current' => null,
    'ariaCurrent' => null,
    'role' => null,
    'tabIndex' => null,
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
        : (! is_null($isCurrentPage)
            ? (bool) $isCurrentPage
            : (! is_null($current) ? (bool) $current : (bool) $active));

    $resolvedAriaCurrent = $ariaCurrent ?? $attributes->get('aria-current');

    /*
    |--------------------------------------------------------------------------
    | Current state
    |--------------------------------------------------------------------------
    |
    | If aria-current="page" is provided, that is already the stronger page
    | current state and no extra selected-current class is needed.
    |
    */

    $hasCurrentClass = $isItemActive && $resolvedAriaCurrent !== 'page';

    $resolvedTabIndex = ! is_null($tabIndex)
        ? $tabIndex
        : ($attributes->get('tabindex') ?? 0);

    $resolvedHref = $href ?? $attributes->get('href') ?? '#';

    /*
    |--------------------------------------------------------------------------
    | CSS class contract
    |--------------------------------------------------------------------------
    */

    $itemClasses = [
        'ui-shell-header__menu-item-wrapper',
    ];

    $linkClasses = [
        'ui-shell-header__menu-item',
        'ui-shell-header__menu-item--current' => $hasCurrentClass,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute handling
    |--------------------------------------------------------------------------
    */

    $controlAttributes = $attributes->except([
        'aria-current',
        'href',
        'tabindex',
    ]);
@endphp

<li
    @class($itemClasses)
    @if ($role) role="{{ $role }}" @endif
    data-ui-shell-header-menu-item-wrapper
>
    @if ($resolvedTag === 'button')
        <button
            type="button"
            {{ $controlAttributes->class($linkClasses)->merge([
                'aria-current' => $hasCurrentClass ? 'true' : $resolvedAriaCurrent,
                'tabindex' => $resolvedTabIndex,
                'data-ui-shell-header-menu-item' => true,
            ]) }}
        >
            <span class="ui-shell-text-truncate--end">
                {{ $slot }}
            </span>
        </button>
    @else
        <a
            href="{{ $resolvedHref }}"
            @if ($wireNavigate) wire:navigate @endif
            {{ $controlAttributes->class($linkClasses)->merge([
                'aria-current' => $hasCurrentClass ? 'true' : $resolvedAriaCurrent,
                'tabindex' => $resolvedTabIndex,
                'data-ui-shell-header-menu-item' => true,
            ]) }}
        >
            <span class="ui-shell-text-truncate--end">
                {{ $slot }}
            </span>
        </a>
    @endif
</li>