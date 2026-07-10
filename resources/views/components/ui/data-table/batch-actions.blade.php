{{-- ==========================================================================
    File: resources/views/components/ui/data-table/batch-actions.blade.php
    Purpose: Data Table batch-actions toolbar region.

    Notes:
    - Renders the selected-item summary and batch action slot.
    - Caller owns selected counts, active state, cancel behavior, and select-all.
    - Intended for composition inside x-ui.data-table.toolbar.
    ========================================================================== --}}

@props([
    'active' => false,
    'shouldShowBatchActions' => null,
    'totalSelected' => 0,
    'totalCount' => null,
    'showSelectAll' => false,
    'cancelLabel' => 'Cancel',
    'selectAllLabel' => 'Select all',
])

@php
    $isActive = is_null($shouldShowBatchActions)
        ? (bool) $active
        : (bool) $shouldShowBatchActions;

    $selectedCount = (int) $totalSelected;
    $resolvedTotalCount = is_null($totalCount) ? $selectedCount : (int) $totalCount;

    $selectedText = $selectedCount === 1
        ? '1 item selected'
        : $selectedCount.' items selected';

    $resolvedSelectAllLabel = $selectAllLabel.' ('.$resolvedTotalCount.')';
    $inactiveTabIndex = $isActive ? 0 : -1;
@endphp

<div
    {{ $attributes->class([
        'ui-batch-actions',
        'ui-batch-actions--active' => $isActive,
    ])->merge([
        'aria-hidden' => $isActive ? 'false' : 'true',
        'data-ui-table-batch-actions' => true,
        'data-ui-table-batch-actions-active' => $isActive ? 'true' : 'false',
    ]) }}
>
    <div class="ui-batch-summary">
        <p class="ui-batch-summary__para">
            <span>{{ $selectedText }}</span>
        </p>

        @if ($showSelectAll)
            <span class="ui-batch-summary__divider" aria-hidden="true">|</span>

            <x-ui.button
                type="button"
                semantic="primary"
                size="sm"
                tabindex="{{ $inactiveTabIndex }}"
                data-ui-table-batch-select-all
            >
                {{ $resolvedSelectAllLabel }}
            </x-ui.button>
        @endif
    </div>

    <x-ui.data-table.action-list>
        {{ $slot }}

        <x-ui.button
            type="button"
            semantic="primary"
            size="sm"
            class="ui-batch-summary__cancel"
            tabindex="{{ $inactiveTabIndex }}"
            data-ui-table-batch-cancel
        >
            {{ $cancelLabel }}
        </x-ui.button>
    </x-ui.data-table.action-list>
</div>
