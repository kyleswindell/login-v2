{{-- ==========================================================================
    File: resources/views/components/shell/side-nav/menu.blade.php
    Purpose: UI shell side navigation expandable menu.

    Notes:
    - Renders a full side navigation list item containing a submenu trigger and
      nested menu list.
    - Supports active, expanded, large, rail, and collapsed side nav states.
    - Supports optional generated UI icon component.
    - Open/close, Escape, rail expansion sync, and keyboard behavior are handled
      by installed shell JavaScript.
    ========================================================================== --}}

@props([
    'id' => null,
    'title',
    'icon' => null,
    'active' => false,
    'isActive' => null,
    'large' => false,
    'expanded' => null,
    'defaultExpanded' => false,
    'sideNavExpanded' => null,
    'isSideNavExpanded' => null,
    'rail' => false,
    'isRail' => null,
    'tabIndex' => null,
    'chevronIcon' => 'chevron--down',
])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Resolve values
    |--------------------------------------------------------------------------
    */

    $resolvedId = $id ?? 'ui-shell-side-nav-menu-'.Str::uuid();
    $buttonId = $resolvedId.'-trigger';
    $menuId = $resolvedId.'-menu';

    $isMenuActive = ! is_null($isActive) ? (bool) $isActive : (bool) $active;
    $isExpanded = ! is_null($expanded) ? (bool) $expanded : (bool) $defaultExpanded;

    $isNavExpanded = ! is_null($isSideNavExpanded)
        ? (bool) $isSideNavExpanded
        : (! is_null($sideNavExpanded) ? (bool) $sideNavExpanded : true);

    $isRailNav = ! is_null($isRail) ? (bool) $isRail : (bool) $rail;

    $resolvedTabIndex = ! is_null($tabIndex)
        ? $tabIndex
        : ((! $isNavExpanded && ! $isRailNav) ? -1 : 0);

    /*
    |--------------------------------------------------------------------------
    | CSS class contract
    |--------------------------------------------------------------------------
    */

    $itemClasses = [
        'ui-shell-side-nav__item',
        'ui-shell-side-nav__item--active' => $isMenuActive,
        'ui-shell-side-nav__item--icon' => filled($icon),
        'ui-shell-side-nav__item--large' => (bool) $large,
        'ui-shell-side-nav__item--expanded' => $isExpanded,
    ];

    $buttonClasses = [
        'ui-shell-side-nav__submenu',
        'ui-shell-side-nav__submenu--active' => $isMenuActive,
    ];

    $menuClasses = [
        'ui-shell-side-nav__menu',
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute handling
    |--------------------------------------------------------------------------
    */

    $itemAttributes = $attributes->except([
        'id',
        'title',
        'aria-expanded',
        'aria-controls',
        'tabindex',
    ]);
@endphp

<li
    {{ $itemAttributes->class($itemClasses)->merge([
        'data-ui-shell-side-nav-menu' => true,
        'data-ui-shell-side-nav-menu-expanded' => $isExpanded ? 'true' : 'false',
        'data-ui-shell-side-nav-menu-active' => $isMenuActive ? 'true' : 'false',
    ]) }}
>
    <button
        id="{{ $buttonId }}"
        type="button"
        @class($buttonClasses)
        aria-expanded="{{ $isExpanded ? 'true' : 'false' }}"
        aria-controls="{{ $menuId }}"
        tabindex="{{ $resolvedTabIndex }}"
        data-ui-shell-side-nav-menu-trigger
    >
        @if ($icon)
            <span
                class="ui-shell-side-nav__icon"
                aria-hidden="true"
                data-ui-shell-side-nav-icon
            >
                <x-ui.icon
                    :name="$icon"
                    class="ui-shell-side-nav__icon-svg"
                />
            </span>
        @endif

        <span class="ui-shell-side-nav__submenu-title">
            @if ($title instanceof HtmlString)
                {!! $title !!}
            @else
                {{ $title }}
            @endif
        </span>

        <span class="ui-shell-side-nav__submenu-chevron" aria-hidden="true">
            <x-ui.icon
                :name="$chevronIcon"
                class="ui-shell-side-nav__submenu-chevron-icon"
            />
        </span>
    </button>

    <ul
        id="{{ $menuId }}"
        @class($menuClasses)
        aria-labelledby="{{ $buttonId }}"
        @if (! $isExpanded) hidden @endif
        data-ui-shell-side-nav-menu-panel
    >
        {{ $slot }}
    </ul>
</li>
