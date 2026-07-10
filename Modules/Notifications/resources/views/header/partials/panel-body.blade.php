{{-- ==========================================================================
    File: Modules/Notifications/resources/views/header/partials/panel-body.blade.php
    Purpose: Notifications popover filter panel body.

    Notes:
    - Renders Unread / All tab panels from normalized filter panel data.
    - Delegates grouped notification list rendering to panel-group.blade.php.
    - Delegates empty panel rendering to empty-list.blade.php.
    - This partial assumes notification state has been normalized by
      header/action.blade.php.
    ========================================================================== --}}

<div class="ui-shell-notifications-menu__body">
    @foreach ($filterPanels as $filterValue => $filterPanel)
        @php
            /*
            |--------------------------------------------------------------------------
            | Panel State
            |--------------------------------------------------------------------------
            */

            $selected = $resolvedActiveFilter === $filterValue;
        @endphp

        <div
            id="{{ $filterPanel['panel_id'] }}"
            class="ui-shell-notifications-menu__panel"
            role="tabpanel"
            aria-labelledby="{{ $filterPanel['tab_id'] }}"
            tabindex="0"
            data-app-notifications-filter-panel="{{ $filterValue }}"
            @if (!$selected) hidden @endif
        >
            @forelse ($filterPanel["groups"] as $groupLabel => $groupItems)
                @php
                    /*
                    |--------------------------------------------------------------------------
                    | Group State
                    |--------------------------------------------------------------------------
                    */

                    $groupIndex = $loop->index;
                    $groupId = "{$id}-{$filterValue}-group-{$groupIndex}";
                @endphp

                @include ("notifications::header.partials.panel-group",
                    [
                        "filterValue" => $filterValue,
                        "filterPanel" => $filterPanel,
                        "groupLabel" => $groupLabel,
                        "groupItems" => $groupItems,
                        "groupIndex" => $groupIndex,
                        "groupId" => $groupId
                    ])
            @empty
                @include ("notifications::header.partials.empty-list",
                    [
                        "filterValue" => $filterValue,
                        "filterPanel" => $filterPanel
                    ])
            @endforelse
        </div>
    @endforeach
</div>
