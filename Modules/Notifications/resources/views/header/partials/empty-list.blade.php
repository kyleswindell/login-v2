{{-- ==========================================================================
    File: Modules/Notifications/resources/views/header/partials/empty-list.blade.php
    Purpose: Notifications popover empty filter panel state.

    Notes:
    - Renders an empty contained-list body so realtime-created rows have a
      stable list target.
    - Renders visible empty-state copy below the empty list.
    - This partial assumes notification state has been normalized by
      header/action.blade.php.
    ========================================================================== --}}

<ul
    class="ui-contained-list ui-contained-list--disclosed ui-contained-list-body ui-layout--size-sm ui-shell-notifications-list"
    aria-label="{{ $filterPanel['label'] }} notification list"
    data-ui-component="contained-list"
    data-ui-contained-list
    data-ui-contained-list-variant="disclosed"
    data-ui-contained-list-size="sm"
    data-ui-contained-list-inset-dividers="false"
    data-ui-contained-list-sticky-header="false"
    data-ui-contained-list-loading="false"
    data-ui-contained-list-item-count="0"
    data-ui-contained-list-body
    data-notification-preview-list="{{ $filterValue }}"
></ul>

<div
    class="ui-shell-notifications-menu__empty"
    data-notification-preview-empty-state
>
    {{
        $filterPanel[
            "empty"
        ]
    }}
</div>
