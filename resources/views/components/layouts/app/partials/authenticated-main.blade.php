{{-- ==========================================================================
    File: resources/views/components/layouts/app/partials/authenticated-main.blade.php
    Purpose: Authenticated application main shell.

    Notes:
    - Owns authenticated shell composition below the global header.
    - Renders skip link, side navigation, and shell content region.
    - Receives grid configuration from the parent app layout.
    - Places the optional Grid wrapper inside the shell content body only.
    - Does not wrap the header, side navigation, or shell panels in the grid.
    - Grid-enabled pages must render x-ui.grid-column as direct slot children.
    ========================================================================== --}}

@php
    /*
    |--------------------------------------------------------------------------
    | App Grid Handoff
    |--------------------------------------------------------------------------
    |
    | The parent app layout resolves these variables. Authenticated app pages
    | use Grid by default; pages that need another shape opt out explicitly.
    |
    */

    $usesGrid = (bool) ($usesGrid ?? false);
    $usesGridFullWidth = (bool) ($usesGridFullWidth ?? false);
    $usesGridRowGap = (bool) ($usesGridRowGap ?? true);

    $gridMode = is_string($gridMode ?? null) && in_array($gridMode, ['default', 'narrow', 'condensed'], true)
        ? $gridMode
        : 'default';

    $gridAlign = is_string($gridAlign ?? null) && in_array($gridAlign, ['start', 'end'], true)
        ? $gridAlign
        : null;
@endphp

{{-- --------------------------------------------------------------------------
    Skip link
    -------------------------------------------------------------------------- --}}

<x-shell.skip-to-content :href="'#' . $mainContentId">
    Skip to main content
</x-shell.skip-to-content>

{{-- --------------------------------------------------------------------------
    Side navigation
    -------------------------------------------------------------------------- --}}

<x-layouts.app.frame.sidebar
    :id="$sideNavId"
    :label="$sideNavLabel"
    :area-title="$sideNavAreaTitle"
    :expanded="$sideNavExpanded"
    :fixed="$sideNavFixed"
    :persistent="$sideNavPersistent"
    :primary-base-navigation="$primaryBaseNavigation"
    :primary-admin-navigation="$primaryAdminNavigation"
    :logs-navigation="$logsNavigation"
    :setup-base-navigation="$setupBaseNavigation"
    :setup-admin-navigation="$setupAdminNavigation"
>
    @if ($hasCustomSidebar)
        {{ $sidebar }}
    @endif
</x-layouts.app.frame.sidebar>

{{-- --------------------------------------------------------------------------
    Main shell content
    -------------------------------------------------------------------------- --}}

<x-shell.content
    :id="$mainContentId"
    :page-title="$pageTitle"
    :page-subtitle="$pageSubtitle"
    :breadcrumbs="$breadcrumbs"
    :tab-items="$tabItems"
    :tabs-label="$tabsLabel"
    :reserve-page-tabs="$reservePageTabs"
>
    {{-- ----------------------------------------------------------------------
        Optional page header override
        ---------------------------------------------------------------------- --}}

    @isset ($pageHeader)
        <x-slot:pageHeader>
            {{ $pageHeader }}
        </x-slot:pageHeader>
    @endisset

    {{-- ----------------------------------------------------------------------
        Optional breadcrumb override
        ---------------------------------------------------------------------- --}}

    @isset ($headerBreadcrumbs)
        <x-slot:headerBreadcrumbs>
            {{ $headerBreadcrumbs }}
        </x-slot:headerBreadcrumbs>
    @endisset

    {{-- ----------------------------------------------------------------------
        Optional page actions
        ---------------------------------------------------------------------- --}}

    @isset ($pageActions)
        <x-slot:pageActions>
            {{ $pageActions }}
        </x-slot:pageActions>
    @endisset

    {{-- ----------------------------------------------------------------------
        Optional page tabs override
        ---------------------------------------------------------------------- --}}

    @isset ($pageTabs)
        <x-slot:pageTabs>
            {{ $pageTabs }}
        </x-slot:pageTabs>
    @endisset

    {{-- ----------------------------------------------------------------------
        Page body
        ----------------------------------------------------------------------
        When grid is enabled, x-ui.grid owns the grid container and direct page
        children must render as x-ui.grid-column.
        ---------------------------------------------------------------------- --}}

    @if ($usesGrid)
        <x-ui.grid
            :full-width="$usesGridFullWidth"
            :row-gap="$usesGridRowGap"
            :mode="$gridMode"
            :align="$gridAlign"
            data-ui-app-grid
            data-ui-app-grid-region="authenticated-main"
        >
            {{ $slot }}
        </x-ui.grid>
    @else
        {{ $slot }}
    @endif
</x-shell.content>
