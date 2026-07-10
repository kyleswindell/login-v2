{{-- ==========================================================================
    File: resources/views/components/shell/side-nav.blade.php
    Purpose: UI shell side navigation region.

    Notes:
    - Renders the persistent or collapsible shell side navigation.
    - Supports fixed, rail, persistent, child-of-header, expanded, and overlay
      states.
    - Emits state through app-owned classes and data attributes for installed
      shell JavaScript.
    - Focus, Escape, overlay click, hover rail expansion, and responsive inert
      behavior are handled by shell JavaScript.
    ========================================================================== --}}

@props([
    'id' => null,
    'label' => null,
    'labelledby' => null,
    'expanded' => null,
    'defaultExpanded' => false,
    'childOfHeader' => true,
    'isChildOfHeader' => null,
    'fixed' => false,
    'isFixedNav' => null,
    'rail' => false,
    'isRail' => null,
    'persistent' => true,
    'isPersistent' => null,
    'addFocusListeners' => true,
    'addMouseListeners' => true,
    'href' => null,
    'enterDelayMs' => 100,
    'overlay' => true,
])

@php
    use Illuminate\Support\Str;

    /*
    |--------------------------------------------------------------------------
    | Resolve values
    |--------------------------------------------------------------------------
    */

    $resolvedId = $id ?? 'ui-shell-side-nav-'.Str::uuid();

    $isControlled = ! is_null($expanded);
    $isExpanded = $isControlled ? (bool) $expanded : (bool) $defaultExpanded;

    $resolvedChildOfHeader = ! is_null($isChildOfHeader)
        ? (bool) $isChildOfHeader
        : (bool) $childOfHeader;

    $resolvedFixed = ! is_null($isFixedNav)
        ? (bool) $isFixedNav
        : (bool) $fixed;

    $resolvedRail = ! is_null($isRail)
        ? (bool) $isRail
        : (bool) $rail;

    $resolvedPersistent = ! is_null($isPersistent)
        ? (bool) $isPersistent
        : (bool) $persistent;

    $resolvedAriaLabel = $label ?? $attributes->get('aria-label');
    $resolvedAriaLabelledby = $labelledby ?? $attributes->get('aria-labelledby');

    /*
    |--------------------------------------------------------------------------
    | CSS class contract
    |--------------------------------------------------------------------------
    */

    $navClasses = [
        'ui-shell-side-nav',
        'ui-shell-side-nav__navigation',
        'ui-shell-side-nav--expanded' => $isExpanded,
        'ui-shell-side-nav--collapsed' => ! $isExpanded && $resolvedFixed,
        'ui-shell-side-nav--rail' => $resolvedRail,
        'ui-shell-side-nav--ux' => $resolvedChildOfHeader,
        'ui-shell-side-nav--hidden' => ! $resolvedPersistent,
        'ui-shell-side-nav--fixed' => $resolvedFixed,
        'ui-shell-side-nav--persistent' => $resolvedPersistent,
    ];

    $overlayClasses = [
        'ui-shell-side-nav__overlay',
        'ui-shell-side-nav__overlay--active' => $isExpanded && ! $resolvedFixed,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute handling
    |--------------------------------------------------------------------------
    */

    $navAttributes = $attributes->except([
        'aria-label',
        'aria-labelledby',
    ]);
@endphp

@if (! $resolvedFixed && $overlay)
    <div
        @class($overlayClasses)
        data-ui-shell-side-nav-overlay
        data-ui-shell-side-nav-overlay-active="{{ $isExpanded ? 'true' : 'false' }}"
        @if (! $isExpanded) hidden @endif
    ></div>
@endif

<nav
    id="{{ $resolvedId }}"
    tabindex="-1"
    {{ $navAttributes->class($navClasses)->merge([
        'data-ui-shell-side-nav' => true,
        'data-ui-shell-side-nav-controlled' => $isControlled ? 'true' : 'false',
        'data-ui-shell-side-nav-expanded' => $isExpanded ? 'true' : 'false',
        'data-ui-shell-side-nav-default-expanded' => $defaultExpanded ? 'true' : 'false',
        'data-ui-shell-side-nav-child-of-header' => $resolvedChildOfHeader ? 'true' : 'false',
        'data-ui-shell-side-nav-fixed' => $resolvedFixed ? 'true' : 'false',
        'data-ui-shell-side-nav-rail' => $resolvedRail ? 'true' : 'false',
        'data-ui-shell-side-nav-persistent' => $resolvedPersistent ? 'true' : 'false',
        'data-ui-shell-side-nav-focus-listeners' => $addFocusListeners ? 'true' : 'false',
        'data-ui-shell-side-nav-mouse-listeners' => $addMouseListeners ? 'true' : 'false',
        'data-ui-shell-side-nav-collapse-href' => $href,
        'data-ui-shell-side-nav-enter-delay' => $enterDelayMs,
    ]) }}
    @if ($resolvedAriaLabel) aria-label="{{ $resolvedAriaLabel }}" @endif
    @if ($resolvedAriaLabelledby) aria-labelledby="{{ $resolvedAriaLabelledby }}" @endif
>
    {{ $slot }}
</nav>