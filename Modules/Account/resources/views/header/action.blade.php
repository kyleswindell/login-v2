{{-- ==========================================================================
    File: Modules/Account/resources/views/header/action.blade.php
    Purpose: Account module header global action and panel composition.

    Notes:
    - Composes the Account module header action from normalized view data.
    - View data is prepared by Modules/Account/Header/ActionViewData.php.
    - The Frame renders this view as a generic header global action contribution.
    - The account panel is modeled as a header disclosure popover with
      interactive content.
========================================================================== --}}

@props([
    'action' => [],
    'data' => [],
])

@php
    /*
    |--------------------------------------------------------------------------
    | View Data
    |--------------------------------------------------------------------------
    */

    $view = \App\Modules\Account\Header\ActionViewData::make(
        action: is_array($action) ? $action : [],
        data: is_array($data) ? $data : [],
    );
@endphp

<x-ui.popover
    :id="$view['id']"
    align="bottom-end"
    :caret="false"
    :drop-shadow="true"
    :border="false"
    :high-contrast="false"
    background-token="layer"
    :is-tab-tip="false"
    :auto-align="false"
    :open="$view['open']"
    interaction="click"
    class="ui-shell-account-popover"
>
    @include('account::header.partials.trigger', $view)

    <x-ui.popover.content
        :id="$view['panelId']"
        role="dialog"
        :label="$view['label']"
        :caret="false"
        :auto-align="false"
        data-ui-motion="popover-menu"
    >
        @include('account::header.partials.panel', $view)
    </x-ui.popover.content>
</x-ui.popover>
