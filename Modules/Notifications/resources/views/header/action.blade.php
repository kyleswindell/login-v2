{{-- ==========================================================================
    File: Modules/Notifications/resources/views/header/action.blade.php
    Purpose: Notifications module header global action and panel composition.

    Notes:
    - Composes the Notifications module header action from normalized view data.
    - View data is prepared by Modules/Notifications/Header/ActionViewData.php.
    - The Frame renders this view as a generic header global action contribution.
    - The notification panel is modeled as a header disclosure using a tab-tip
      popover surface with interactive content.
    - The panel is not a menu. It contains actions, tabs, grouped lists, links,
      and optional notification preference navigation.
    - Row, group, empty state, filter, header, footer, realtime, and trigger
      markup are owned by module-local header partials.
    - Popover panel enter/exit motion is owned by the Motion element through
      data-ui-motion="popover-menu".
    ========================================================================== --}}

@props ([
    "action" => [],
    "data" => [],
])

@php
    /*
    |--------------------------------------------------------------------------
    | View Data
    |--------------------------------------------------------------------------
    */

    $view = \App\Modules\Notifications\Header\ActionViewData::make(
        action: is_array($action) ? $action : [],
        data: is_array($data) ? $data : [],
    );
@endphp

@include ("notifications::header.partials.realtime", $view)

<x-ui.popover
    :id="$view['id']"
    align="bottom-end"
    :caret="false"
    :drop-shadow="true"
    :border="true"
    :is-tab-tip="true"
    background-token="layer"
    :open="$view['open']"
    interaction="click"
    class="ui-shell-notifications-popover"
>
    {{-- ----------------------------------------------------------------------
        Header disclosure trigger
        ---------------------------------------------------------------------- --}}

    @include ("notifications::header.partials.trigger", $view)

    {{-- ----------------------------------------------------------------------
        Notification panel
        ---------------------------------------------------------------------- --}}

    <x-ui.popover.content
        :id="$view['panelId']"
        role="dialog"
        :labelledby="$view['panelTitleId']"
        :caret="false"
        :auto-align="false"
        aria-describedby="{{ $view['panelSummaryId'] }}"
        data-ui-motion="popover-menu"
    >
        @include ("notifications::header.partials.panel", $view)
    </x-ui.popover.content>
</x-ui.popover>
