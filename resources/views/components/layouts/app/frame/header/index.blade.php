{{-- ==========================================================================
    File: resources/views/components/layouts/app/frame/header/index.blade.php
    Purpose: Signed-in app header composition.

    Notes:
    - Composes the base shell header primitives into the app-level header.
    - Keeps app-specific header decisions out of resources/views/components/shell.
    - Supports default, workspace, docs, minimal, and bare header variants.
    - Navigation content may be passed through the default slot or navigation slot.
    - Header global actions may be passed through the actions slot.
    ========================================================================== --}}

@props([
    'variant' => 'default',
    'label' => null,
    'sideNavId' => 'app-side-nav',
    'brandHref' => null,
    'brandPrefix' => null,
    'brandName' => null,
    'showMenuButton' => null,
    'showNavigation' => null,
    'showActions' => null,
    'menuLabel' => 'Open menu',
    'menuCloseLabel' => 'Close menu',
])

@php
    $resolvedLabel = $label ?? config('app.name', 'Application');
    $resolvedBrandHref = $brandHref ?? url('/');
    $resolvedBrandName = $brandName ?? config('app.name', 'Application');

    $hasNavigationSlot = isset($navigation) && trim((string) $navigation) !== '';
    $navigationContent = $hasNavigationSlot ? $navigation : $slot;
    $hasNavigationContent = trim((string) $navigationContent) !== '';

    $hasActions = isset($actions) && trim((string) $actions) !== '';

    $resolvedShowMenuButton = ! is_null($showMenuButton)
        ? (bool) $showMenuButton
        : $variant !== 'bare' && filled($sideNavId);

    $resolvedShowNavigation = ! is_null($showNavigation)
        ? (bool) $showNavigation
        : in_array($variant, ['default', 'workspace', 'docs'], true);

    $resolvedShowActions = ! is_null($showActions)
        ? (bool) $showActions
        : $variant !== 'bare';

    $classes = [
        'app-header',
        "app-header--{$variant}" => filled($variant),
    ];
@endphp

<x-shell.header
    :label="$resolvedLabel"
    {{ $attributes->class($classes) }}
>
    @if ($resolvedShowMenuButton)
        <x-shell.header.menu-button
            class="ui-shell-header__menu-toggle__hidden"
            :controls="$sideNavId"
            :label="$menuLabel"
            :close-label="$menuCloseLabel"
        >
            @isset($menuIcon)
                {{ $menuIcon }}
            @else
                <x-ui.icon name="menu"
                    class="ui-shell-navigation-menu-panel-expand-icon"
                    width="20"
                    height="20"
                    aria-hidden="true"
                    focusable="false"
                />
            @endisset

            @isset($closeIcon)
                {{ $closeIcon }}
            @else
                <x-ui.icon name="close"
                    class="ui-shell-navigation-menu-panel-collapse-icon"
                    width="20"
                    height="20"
                    aria-hidden="true"
                    focusable="false"
                />
            @endisset
        </x-shell.header.menu-button>
    @endif

    <x-shell.header.name
        :href="$resolvedBrandHref"
        :prefix="$brandPrefix"
    >
        {{ $resolvedBrandName }}
    </x-shell.header.name>

    @if ($resolvedShowNavigation && $hasNavigationContent)
        <x-shell.header.navigation label="Primary navigation">
            {{ $navigationContent }}
        </x-shell.header.navigation>
    @endif

    @if ($resolvedShowActions && $hasActions)
        <x-shell.header.global-bar>
            {{ $actions }}
        </x-shell.header.global-bar>
    @endif
</x-shell.header>
