{{-- ==========================================================================
    File: resources/views/components/layouts/app/frame/header/panels.blade.php
    Purpose: Signed-in app header panels.

    Notes:
    - Renders app-specific panels controlled by x-layouts.app.frame.header.actions.
    - Search is intentionally excluded because it uses x-ui.search directly.
    - Module-owned header actions render their own panels through contribution
      views; this component keeps Frame-owned panels only.
    ========================================================================== --}}

@props([
    'showSwitcher' => true,
    'switcherPanelId' => 'app-header-switcher-panel',
    'theme' => null,
])

@if ($showSwitcher)
    <x-shell.header.panel
        :id="$switcherPanelId"
        label="App switcher"
        :data-ui-theme="$theme"
    >
        @isset($switcher)
            {{ $switcher }}
        @else
            <x-shell.switcher aria-label="App switcher" :expanded="false">
                <x-shell.switcher.item href="{{ url('/') }}" :expanded="false">
                    Home
                </x-shell.switcher.item>

                <x-shell.switcher.item href="#" :expanded="false">
                    Workspace
                </x-shell.switcher.item>

                <x-shell.switcher.divider />

                <x-shell.switcher.item href="#" :expanded="false">
                    Settings
                </x-shell.switcher.item>
            </x-shell.switcher>
        @endisset
    </x-shell.header.panel>
@endif
