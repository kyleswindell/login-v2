{{-- ==========================================================================
    File: Modules/Notifications/resources/views/header/partials/panel-group.blade.php
    Purpose: Notifications popover grouped notification list.

    Notes:
    - Renders a single grouped notification section inside a filter panel.
    - Delegates individual row rendering to notification-row.blade.php.
    - Groups render as disclosed contained-list surfaces.
    - This partial assumes notification state has been normalized by
      header/action.blade.php.
    ========================================================================== --}}

<section
    class="ui-shell-notifications-menu__section"
    aria-labelledby="{{ $groupId }}"
>
    {{-- ------------------------------------------------------------------
        Group label
        ------------------------------------------------------------------ --}}

    <h3 id="{{ $groupId }}" class="ui-shell-notifications-menu__section-label">
        {{ $groupLabel }}
    </h3>

    {{-- ------------------------------------------------------------------
        Group list
        ------------------------------------------------------------------ --}}

    <ul
        class="ui-contained-list ui-contained-list--disclosed ui-contained-list-body ui-layout--size-sm ui-shell-notifications-list"
        aria-label="{{ $groupLabel }} notification list"
        data-ui-component="contained-list"
        data-ui-contained-list
        data-ui-contained-list-variant="disclosed"
        data-ui-contained-list-size="sm"
        data-ui-contained-list-inset-dividers="false"
        data-ui-contained-list-sticky-header="false"
        data-ui-contained-list-loading="false"
        data-ui-contained-list-item-count="{{ $groupItems->count() }}"
        data-ui-contained-list-body
        data-notification-preview-list="{{ $filterValue }}"
    >
        @foreach ($groupItems as $notification)
            @include ("notifications::header.partials.notification-row",
                [
                    "notification" => $notification,
                    "filterValue" => $filterValue,
                    "groupIndex" => $groupIndex,
                    "rowIndex" => $loop->index
                ])
        @endforeach
    </ul>
</section>
