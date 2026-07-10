{{-- ==========================================================================
    File: resources/views/components/shell/side-nav/link.blade.php
    Purpose: UI shell side navigation link.

    Notes:
    - Renders a full side navigation list item containing a link or button.
    - Supports active/current-page state.
    - Supports optional canonical navigation icon names through x-ui.icon.
    - Supports rail/collapsed tab-index behavior through expanded and rail props.
    - Text is wrapped in a dedicated label span for truncation and rail behavior.
    - Interactive navigation behavior belongs to the browser/router or installed
      shell JavaScript.
    ========================================================================== --}}

@props([
    'as' => 'a',
    'href' => null,
    'icon' => null,
    'active' => false,
    'isActive' => null,
    'current' => null,
    'large' => false,
    'expanded' => null,
    'isSideNavExpanded' => null,
    'rail' => false,
    'isRail' => null,
    'tabIndex' => null,
    'label' => null,
    'labelledby' => null,
    'wireNavigate' => false,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Resolve values
    |--------------------------------------------------------------------------
    */

    $resolvedTag = $as === 'button' ? 'button' : 'a';

    $isLinkActive = ! is_null($isActive)
        ? (bool) $isActive
        : (! is_null($current) ? (bool) $current : (bool) $active);

    $isExpanded = ! is_null($isSideNavExpanded)
        ? (bool) $isSideNavExpanded
        : (! is_null($expanded) ? (bool) $expanded : true);

    $isRail = ! is_null($isRail)
        ? (bool) $isRail
        : (bool) $rail;

    $resolvedTabIndex = ! is_null($tabIndex)
        ? $tabIndex
        : ((! $isExpanded && ! $isRail) ? -1 : 0);

    $resolvedHref = $href ?? $attributes->get('href') ?? '#';

    $resolvedAriaLabel = $label ?? $attributes->get('aria-label');
    $resolvedAriaLabelledby = $labelledby ?? $attributes->get('aria-labelledby');

    /*
    |--------------------------------------------------------------------------
    | CSS class contract
    |--------------------------------------------------------------------------
    */

    $itemClasses = [
        'ui-shell-side-nav__item',
        'ui-shell-side-nav__item--large' => (bool) $large,
    ];

    $linkClasses = [
        'ui-shell-side-nav__link',
        'ui-shell-side-nav__link--current' => $isLinkActive,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute handling
    |--------------------------------------------------------------------------
    */

    $controlAttributes = $attributes->except([
        'href',
        'aria-label',
        'aria-labelledby',
        'tabindex',
    ]);
@endphp

<li
    @class($itemClasses)
    data-ui-shell-side-nav-item
    data-ui-shell-side-nav-link-item
>
    @if ($resolvedTag === 'button')
        <button
            type="button"
            {{ $controlAttributes->class($linkClasses)->merge([
                'aria-current' => $isLinkActive ? 'page' : null,
                'aria-label' => $resolvedAriaLabel,
                'aria-labelledby' => $resolvedAriaLabelledby,
                'tabindex' => $resolvedTabIndex,
                'data-ui-shell-side-nav-link' => true,
                'data-ui-shell-side-nav-link-active' => $isLinkActive ? 'true' : 'false',
            ]) }}
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

            <span class="ui-shell-side-nav__link-text">
                {{ $slot }}
            </span>
        </button>
    @else
        <a
            href="{{ $resolvedHref }}"
            @if ($wireNavigate) wire:navigate @endif
            {{ $controlAttributes->class($linkClasses)->merge([
                'aria-current' => $isLinkActive ? 'page' : null,
                'aria-label' => $resolvedAriaLabel,
                'aria-labelledby' => $resolvedAriaLabelledby,
                'tabindex' => $resolvedTabIndex,
                'data-ui-shell-side-nav-link' => true,
                'data-ui-shell-side-nav-link-active' => $isLinkActive ? 'true' : 'false',
            ]) }}
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

            <span class="ui-shell-side-nav__link-text">
                {{ $slot }}
            </span>
        </a>
    @endif
</li>
