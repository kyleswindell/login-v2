{{-- ==========================================================================
    File: resources/views/components/shell/side-nav/header.blade.php
    Purpose: UI shell side navigation header.

    Notes:
    - Renders the optional header region inside a shell side navigation.
    - Used for catalog/workspace labels such as "rendered evidence".
    - Keeps side-nav title spacing and divider styling attached to a wrapper.
    ========================================================================== --}}

@props([
    'icon' => null,
    'expanded' => null,
    'isSideNavExpanded' => null,
])

@php
    $resolvedExpanded = ! is_null($isSideNavExpanded)
        ? (bool) $isSideNavExpanded
        : (! is_null($expanded) ? (bool) $expanded : null);
@endphp

<header
    {{ $attributes->class('ui-shell-side-nav__header')->merge([
        'data-ui-shell-side-nav-header' => true,
        'data-ui-shell-side-nav-header-expanded' => is_null($resolvedExpanded) ? null : ($resolvedExpanded ? 'true' : 'false'),
    ]) }}
>
    @if ($icon)
        <span class="ui-shell-side-nav__icon" aria-hidden="true">
            <x-ui.icon
                :name="$icon"
                class="ui-shell-side-nav__icon-svg"
            />
        </span>
    @endif

    <div class="ui-shell-side-nav__header-content">
        {{ $slot }}
    </div>
</header>
