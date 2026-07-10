{{-- ==========================================================================
    File: Modules/Account/resources/views/header/partials/theme-switcher.blade.php
    Purpose: Account header theme switcher.

    Notes:
    - Renders the theme mode selector inside the account popover panel.
    - Uses x-ui.content-switcher and x-ui.switch so selected, focus, hover,
      and content-switcher styling remain component-owned.
    - Theme mode behavior is owned by the app theme-mode controller through
      data-theme-mode-toggle and data-theme-mode.
    - Selected switcher state is owned by aria-selected and selected classes,
      not data-ui-current.
    ========================================================================== --}}

<div class="ui-shell-account-menu__section ui-shell-account-menu__theme">
    <p class="ui-shell-account-menu__theme-label">Theme</p>

    <x-ui.content-switcher
        size="sm"
        :low-contrast="true"
        selection-mode="automatic"
        aria-label="Theme mode"
        data-ui-shell-account-theme-switcher
        data-ui-content-switcher-fluid="true"
        data-ui-content-switcher-value="{{ $themeMode }}"
    >
        @foreach ($themeOptions as $mode => $modeLabel)
            @php
                /*
                |--------------------------------------------------------------------------
                | Theme Option State
                |--------------------------------------------------------------------------
                */

                $isSelected = $themeMode === $mode;
            @endphp

            <x-ui.switch
                id="account-theme-{{ $mode }}"
                :index="$loop->index"
                :name="$mode"
                :selected="$isSelected"
                value="{{ $mode }}"
                data-theme-mode-toggle
                data-theme-mode="{{ $mode }}"
                data-ui-content-switcher-value="{{ $mode }}"
                data-ui-content-switcher-text="{{ $modeLabel }}"
            >
                {{ $modeLabel }}
            </x-ui.switch>
        @endforeach
    </x-ui.content-switcher>
</div>
