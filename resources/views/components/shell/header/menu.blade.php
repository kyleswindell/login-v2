{{-- ==========================================================================
    File: resources/views/components/shell/header-menu.blade.php
    Purpose: UI shell header submenu.

    Notes:
    - Renders a submenu item inside x-shell.header.navigation.
    - Mirrors the base UI shell header menu structure.
    - The trigger must include both ui-shell-header__menu-item and
      ui-shell-header__menu-title so base header item styles and submenu styles
      both apply.
    - The submenu list must be the adjacent sibling of the trigger because the
      base CSS uses .ui-shell-header__menu-title[aria-expanded="true"] +
      .ui-shell-header__menu.
    ========================================================================== --}}

@props([
    'label',
    'href' => '#',
    'expanded' => false,
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

    $isItemActive = ! is_null($isActive)
        ? (bool) $isActive
        : (! is_null($isCurrentPage)
            ? (bool) $isCurrentPage
            : (! is_null($current) ? (bool) $current : (bool) $active));

    $resolvedAriaCurrent = $ariaCurrent ?? $attributes->get('aria-current');

    $hasCurrentClass = $isItemActive && $resolvedAriaCurrent !== 'page';

    $resolvedTabIndex = ! is_null($tabIndex)
        ? $tabIndex
        : ($attributes->get('tabindex') ?? 0);

    /*
    |--------------------------------------------------------------------------
    | CSS class contract
    |--------------------------------------------------------------------------
    */

    $triggerClasses = [
        'ui-shell-header__menu-item',
        'ui-shell-header__menu-title',
        'ui-shell-header__menu-item--current' => $hasCurrentClass,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute handling
    |--------------------------------------------------------------------------
    */

    $triggerAttributes = $attributes->except([
        'aria-current',
        'href',
        'tabindex',
    ]);
@endphp

<li
    class="ui-shell-header__submenu"
    @if ($role) role="{{ $role }}" @endif
    data-ui-shell-header-submenu
>
    <a
        href="{{ $href }}"
        @if ($wireNavigate) wire:navigate @endif
        {{ $triggerAttributes->class($triggerClasses)->merge([
            'aria-current' => $hasCurrentClass ? 'true' : $resolvedAriaCurrent,
            'aria-haspopup' => 'true',
            'aria-expanded' => $expanded ? 'true' : 'false',
            'tabindex' => $resolvedTabIndex,
            'data-ui-shell-header-menu-trigger' => true,
        ]) }}
    >
        <span class="ui-shell-text-truncate--end">
            {{ $label }}
        </span>

        <svg
            class="ui-shell-header__menu-arrow"
            focusable="false"
            aria-hidden="true"
            viewBox="0 0 16 16"
            width="16"
            height="16"
        >
            <path d="M8 11L3 6l.7-.7L8 9.6l4.3-4.3.7.7z" />
        </svg>
    </a>

    <ul class="ui-shell-header__menu" data-ui-shell-header-menu>
        {{ $slot }}
    </ul>
</li>
