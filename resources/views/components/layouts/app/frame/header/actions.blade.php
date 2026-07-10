{{-- ==========================================================================
    File: resources/views/components/layouts/app/frame/header/actions.blade.php
    Purpose: Signed-in app header global actions.

    Notes:
    - Renders app-specific Frame actions and module-contributed header actions.
    - Search uses the app header search composition.
    - Module entries may render as generic route actions or as module-owned
      component views.
    ========================================================================== --}}

@props([
    'showSearch' => true,
    'showSwitcher' => false,
    'headerGlobalActions' => [],
    'switcherPanelId' => 'app-header-switcher-panel',
])

@php
    $moduleActions = collect($headerGlobalActions)->values();
@endphp

@if ($showSearch)
    <x-layouts.app.frame.header.search />
@endif

@foreach ($moduleActions as $action)
    @if (! empty($action['componentView']))
        @include($action['componentView'], [
            'action' => $action,
            'data' => $action['data'] ?? [],
        ])
    @else
        <a
            href="{{ $action['href'] ?? '#' }}"
            @class([
                'ui-shell-header__action',
                'ui-shell-header__global-action',
                'ui-button',
                'ui-button--icon-only',
                'ui-shell-header__action--active' => (bool) ($action['current'] ?? false),
            ])
            aria-label="{{ $action['label'] ?? 'Header action' }}"
            @if (! empty($action['current'])) aria-current="page" @endif
            data-ui-shell-header-global-action
            data-ui-shell-header-global-action-active="{{ ! empty($action['current']) ? 'true' : 'false' }}"
            data-header-global-action-key="{{ $action['key'] ?? '' }}"
            data-header-global-action-module="{{ $action['moduleKey'] ?? '' }}"
            @if (! empty($action['wireNavigate'])) wire:navigate @endif
        >
            <x-ui.icon :name="$action['icon'] ?? 'settings'"
                class="ui-shell-header__action-icon"
                width="20"
                height="20"
                aria-hidden="true"
                focusable="false"
            />
        </a>
    @endif
@endforeach

@if ($showSwitcher)
    <x-shell.header.global-action
        label="App switcher"
        :controls="$switcherPanelId"
    >
        @isset($switcherIcon)
            {{ $switcherIcon }}
        @else
            <x-ui.icon name="apps"
                width="20"
                height="20"
                aria-hidden="true"
                focusable="false"
            />
        @endisset
    </x-shell.header.global-action>
@endif

