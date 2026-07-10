{{-- ==========================================================================
    File: Modules/Notifications/resources/views/header/partials/panel.blade.php
    Purpose: Notifications popover panel composition.

    Notes:
    - Owns the notification popover panel shell.
    - Composes the panel header, filter switcher, filter panel body, and footer.
    - The panel is rendered inside x-ui.popover.content by header/action.blade.php.
    - The panel is not a menu. It contains actions, tabs, grouped lists, links,
      and optional notification preference navigation.
    - This partial assumes notification state has been normalized by
      header/action.blade.php.
    ========================================================================== --}}

<section
    class="ui-shell-notifications-menu"
    data-app-notifications-menu
    data-app-notifications-active-filter="{{ $resolvedActiveFilter }}"
    @if ($resolvedDismissRouteTemplate)
        data-app-notifications-dismiss-url-template="{{ $resolvedDismissRouteTemplate }}"
    @endif
>
    {{-- ------------------------------------------------------------------
        Panel header
        ------------------------------------------------------------------ --}}

    @include ("notifications::header.partials.panel-header")

    {{-- ------------------------------------------------------------------
        Filter switcher
        ------------------------------------------------------------------ --}}

    @include ("notifications::header.partials.filters")

    {{-- ------------------------------------------------------------------
        Filter panels
        ------------------------------------------------------------------ --}}

    @include ("notifications::header.partials.panel-body")

    {{-- ------------------------------------------------------------------
        Panel footer
        ------------------------------------------------------------------ --}}

    @include ("notifications::header.partials.footer")
</section>
