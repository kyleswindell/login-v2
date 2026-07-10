{{-- ==========================================================================
    File: Modules/_Template/resources/views/setup/index.blade.php
    Purpose: Starter setup page for copied module packages.

    Notes:
    - The app layout owns the installed Grid container through the grid prop.
    - The shell content layout owns the page header and reserved page-tabs space.
    - Page body content must render as x-ui.grid-column direct children when
      grid is enabled.
    - Replace module-key with the copied module translation namespace.
    ========================================================================== --}}

<x-layouts.app
    grid
    :title="__('module-key::module.setup.title')"
    :page-title="__('module-key::module.setup.title')"
    :page-subtitle="__('module-key::module.setup.description')"
    :reserve-page-tabs="true"
>
    {{-- ------------------------------------------------------------------
        Setup content
        ------------------------------------------------------------------
        Add setup page controls, forms, cards, or explanatory content inside
        this grid column.
        ------------------------------------------------------------------ --}}

    <x-ui.grid-column
        tag="section"
        span="100"
        lg="10"
        xlg="8"
        data-module-setup-page
    >
        {{-- Add setup page content here. --}}
    </x-ui.grid-column>
</x-layouts.app>
