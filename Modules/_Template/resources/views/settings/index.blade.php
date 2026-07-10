{{-- ==========================================================================
    File: Modules/_Template/resources/views/settings/index.blade.php
    Purpose: Starter settings page for copied module packages.

    Notes:
    - The app layout owns the installed Grid container through the grid prop.
    - The shell content layout owns the page header and reserved page-tabs space.
    - Page body content must render as x-ui.grid-column direct children when
      grid is enabled.
    - Replace module-key with the copied module translation namespace.
    ========================================================================== --}}

<x-layouts.app
    grid
    :title="__('module-key::module.settings.title')"
    :page-title="__('module-key::module.settings.title')"
    :page-subtitle="__('module-key::module.settings.description')"
    :reserve-page-tabs="true"
>
    {{-- ------------------------------------------------------------------
        Settings content
        ------------------------------------------------------------------
        Add settings forms, cards, or configuration panels inside this grid
        column.
        ------------------------------------------------------------------ --}}

    <x-ui.grid-column
        tag="section"
        span="100"
        lg="10"
        xlg="8"
        data-module-settings-page
    >
        {{-- Add settings page content here. --}}
    </x-ui.grid-column>
</x-layouts.app>
