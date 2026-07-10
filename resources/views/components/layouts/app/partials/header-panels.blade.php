{{-- ==========================================================================
    File: resources/views/components/layouts/app/partials/header-panels.blade.php
    Purpose: Authenticated app header panel composition.

    Notes:
    - Renders Frame-owned header panels adjacent to the authenticated header.
    - Module-owned header actions render their own panels through contribution
      views and data providers.
========================================================================== --}}

<x-layouts.app.frame.header.panels :show-switcher="$showHeaderSwitcher" />

@includeIf ("notifications::runtime.toasts")
