{{-- ==========================================================================
    File: Modules/Notifications/resources/views/setup/index.blade.php
    Purpose: Notifications module setup page.

    Notes:
    - The app layout owns the installed Grid container through the grid prop.
    - The shell content layout owns the page header and reserved page-tabs space.
    - Setup page body content must render as x-ui.grid-column direct children
      when grid is enabled.
    ========================================================================== --}}

<x-layouts.app
    grid
    :title="__('notifications::module.setup.title')"
    :page-title="__('notifications::module.setup.title')"
    :page-subtitle="__('notifications::module.setup.description')"
    :reserve-page-tabs="true"
>
    {{-- ------------------------------------------------------------------
        Setup content
        ------------------------------------------------------------------ --}}

    <x-ui.grid-column
        tag="section"
        span="100"
        lg="10"
        xlg="8"
        data-notifications-setup-page
    >
        {{-- Add Notifications setup controls or guidance here. --}}
    </x-ui.grid-column>
</x-layouts.app>
