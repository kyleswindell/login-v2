{{-- ==========================================================================
    File: resources/views/components/ui/data-table/header.blade.php
    Purpose: Data Table header cell with optional sort affordance.

    Notes:
    - Renders native th elements and approved sort classes.
    - Does not mutate sort state; callers own state updates.
    - Uses existing project sort icons instead of introducing icon aliases.
    ========================================================================== --}}

@props([
    'sortable' => false,
    'sorted' => false,
    'sortDirection' => null,
    'align' => 'start',
    'scope' => 'col',
])

@php
    /*
    |--------------------------------------------------------------------------
    | Header cell presentation values
    |--------------------------------------------------------------------------
    |
    | Sort props only describe the current rendered state. Click handling and
    | state transitions belong to the consuming route or a future controller.
    |
    */

    $resolvedAlign = in_array($align, ['start', 'center', 'end'], true)
        ? $align
        : 'start';

    $resolvedSortDirection = $sortDirection === 'desc'
        ? 'desc'
        : ($sortDirection === 'asc' ? 'asc' : null);
@endphp

@if (! $sortable)
    <th
        {{ $attributes->class([
            'ui-data-table-header-cell',
            'ui-data-table-cell-align-'.$resolvedAlign,
        ]) }}
        scope="{{ $scope }}"
        @if ($resolvedAlign === 'end') align="right" @endif
        @if ($resolvedAlign === 'center') align="center" @endif
    >
        <div class="ui-table-header-label">
            {{ $slot }}
        </div>
    </th>
@else
    <th
        {{ $attributes->class([
            'ui-data-table-header-cell',
            'ui-table-sort__header',
            'ui-table-sort__header--active' => $sorted,
            'ui-table-sort__header--descending' => $sorted && $resolvedSortDirection === 'desc',
            'ui-data-table-cell-align-'.$resolvedAlign,
        ]) }}
        scope="{{ $scope }}"
        @if ($resolvedAlign === 'end') align="right" @endif
        @if ($resolvedAlign === 'center') align="center" @endif
    >
        <div class="ui-table-sort__description">
            Sort table by {{ trim((string) $slot) }}
        </div>

        <button
            type="button"
            @class([
                'ui-table-sort',
                'ui-table-sort--active' => $sorted,
                'ui-table-sort--descending' => $sorted && $resolvedSortDirection === 'desc',
            ])
            data-ui-data-table-sort
        >
            <span class="ui-table-sort__flex">
                <span class="ui-table-header-label">{{ $slot }}</span>

                @if ($resolvedSortDirection === 'desc')
                    <x-ui.icon name="sort--descending"
                        class="ui-table-sort__icon"
                        width="20"
                        height="20"
                        aria-hidden="true"
                        focusable="false"
                    />
                @else
                    <x-ui.icon name="sort--ascending"
                        class="ui-table-sort__icon"
                        width="20"
                        height="20"
                        aria-hidden="true"
                        focusable="false"
                    />
                @endif

                <x-ui.icon name="caret--sort"
                    class="ui-table-sort__icon-unsorted"
                    width="20"
                    height="20"
                    aria-hidden="true"
                    focusable="false"
                />
            </span>
        </button>
    </th>
@endif
