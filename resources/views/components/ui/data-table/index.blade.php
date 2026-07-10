{{-- ==========================================================================
    File: resources/views/components/ui/data-table/index.blade.php
    Purpose: Array-driven Data Table component entry point.

    Notes:
    - Keeps the simple x-ui.data-table API for static server-rendered tables.
    - Delegates table anatomy to nested data-table Blade render components.
    - Does not own filtering, selection, expansion, or server-side table state.
    - Table state controllers belong in Livewire, page controllers, or later JS.
    ========================================================================== --}}

@props([
    'columns' => [],
    'rows' => [],
    'title' => null,
    'description' => null,
    'ariaLabel' => null,
    'size' => null,
    'toolbarSize' => null,
    'density' => 'standard',
    'sortable' => false,
    'sortBy' => null,
    'sortDirection' => null,
    'loading' => false,
    'empty' => null,
    'emptyTitle' => 'No records',
    'emptyDescription' => null,
    'error' => null,
    'rowActions' => false,
    'pagination' => false,
    'responsive' => 'overflow',
    'striped' => false,
    'stickyHeader' => false,
    'useStaticWidth' => false,
    'overflowMenuOnHover' => true,
    'experimentalAutoAlign' => false,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Public option normalization
    |--------------------------------------------------------------------------
    |
    | The Blade layer normalizes presentation-only values. Data ownership,
    | server sorting, filtering, pagination state, and selection state stay with
    | the calling controller, Livewire component, or future table JS controller.
    |
    */

    $resolvedDensity = in_array($density, ['standard', 'compact'], true)
        ? $density
        : 'standard';

    $resolvedSize = in_array($size, ['xs', 'sm', 'md', 'lg', 'xl'], true)
        ? $size
        : ($resolvedDensity === 'compact' ? 'sm' : 'md');

    $resolvedToolbarSize = in_array($toolbarSize, ['sm', 'lg'], true)
        ? $toolbarSize
        : (in_array($resolvedSize, ['xs', 'sm'], true) ? 'sm' : 'lg');

    $isEmpty = is_null($empty) ? count($rows) === 0 : (bool) $empty;

    $tableId = $attributes->get('id')
        ?? 'ui-data-table-'.substr(md5(($title ?? $ariaLabel ?? 'table').count($rows)), 0, 8);

    $titleId = $title ? $tableId.'-title' : null;
    $descriptionId = $description ? $tableId.'-description' : null;
    $hasRowActions = $rowActions || isset($rowActionsSlot);
@endphp

<x-ui.data-table.container
    :id="$tableId"
    :title="$title"
    :description="$description"
    :title-id="$titleId"
    :description-id="$descriptionId"
    :sticky-header="$stickyHeader"
    :use-static-width="$useStaticWidth || $responsive === 'static'"
    :class="$attributes->get('class')"
    data-ui-data-table
    data-ui-data-table-size="{{ $resolvedSize }}"
    data-ui-data-table-toolbar-size="{{ $resolvedToolbarSize }}"
>
    @isset($toolbar)
        {{ $toolbar }}
    @endisset

    @if ($error)
        <x-ui.data-table.empty-state
            class="ui-data-table-error"
            title="Table failed to load"
            :description="$error"
        />
    @elseif ($isEmpty && ! $loading)
        <x-ui.data-table.empty-state
            :title="$emptyTitle"
            :description="$emptyDescription"
        />
    @else
        <x-ui.data-table.table
            :size="$resolvedSize"
            :sortable="$sortable"
            :striped="$striped"
            :sticky-header="$stickyHeader"
            :use-static-width="$useStaticWidth || $responsive === 'static'"
            :overflow-menu-on-hover="$overflowMenuOnHover"
            :experimental-auto-align="$experimentalAutoAlign"
            :aria-labelledby="$titleId"
            :aria-describedby="$descriptionId"
            :aria-label="$ariaLabel ?? 'Data table'"
        >
            <x-ui.data-table.head>
                <tr>
                    @foreach ($columns as $column)
                        @php
                            $key = data_get($column, 'key');
                            $label = data_get($column, 'label', str($key)->headline()->toString());
                            $align = data_get($column, 'align', 'start');
                            $columnSortable = $sortable && (bool) data_get($column, 'sortable', false);
                            $isSorted = $columnSortable && $sortBy === $key;
                            $ariaSort = $isSorted
                                ? ($sortDirection === 'desc' ? 'descending' : 'ascending')
                                : 'none';
                        @endphp

                        <x-ui.data-table.header
                            :sortable="$columnSortable"
                            :sorted="$isSorted"
                            :sort-direction="$sortDirection"
                            :align="$align"
                            :aria-sort="$columnSortable ? $ariaSort : null"
                        >
                            {{ $label }}
                        </x-ui.data-table.header>
                    @endforeach

                    @if ($hasRowActions)
                        <x-ui.data-table.header class="ui-data-table-cell-actions ui-table-column-menu">
                            Actions
                        </x-ui.data-table.header>
                    @endif
                </tr>
            </x-ui.data-table.head>

            @if ($loading)
                <x-ui.data-table-skeleton :columns="count($columns) + ($hasRowActions ? 1 : 0)" />
            @else
                <x-ui.data-table.body>
                    @foreach ($rows as $row)
                        @php
                            $rowLabel = data_get($row, 'name')
                                ?? data_get($row, 'workspace')
                                ?? data_get($row, 'cells.name')
                                ?? data_get($row, 'cells.workspace')
                                ?? data_get($row, 'id', 'row');

                            $rowDisabled = (bool) data_get($row, 'disabled', false);
                        @endphp

                        <x-ui.data-table.row
                            :selected="(bool) data_get($row, 'selected', false)"
                            :current="(bool) data_get($row, 'current', false)"
                            :disabled="$rowDisabled"
                        >
                            @foreach ($columns as $column)
                                @php
                                    $key = data_get($column, 'key');
                                    $align = data_get($column, 'align', 'start');
                                    $value = data_get($row, 'cells.'.$key, data_get($row, $key, ''));
                                @endphp

                                <x-ui.data-table.cell :align="$align">
                                    {!! is_string($value) ? e($value) : $value !!}
                                </x-ui.data-table.cell>
                            @endforeach

                            @if ($hasRowActions)
                                <x-ui.data-table.cell class="ui-data-table-cell-actions ui-table-column-menu">
                                    @isset($rowActionsSlot)
                                        {{ $rowActionsSlot }}
                                    @else
                                        <x-ui.button
                                            semantic="ghost"
                                            size="sm"
                                            :disabled="$rowDisabled"
                                            aria-label="Open {{ $rowLabel }}"
                                        >
                                            Open
                                        </x-ui.button>
                                    @endisset
                                </x-ui.data-table.cell>
                            @endif
                        </x-ui.data-table.row>
                    @endforeach
                </x-ui.data-table.body>
            @endif
        </x-ui.data-table.table>
    @endif

    @isset($paginationSlot)
        <div class="ui-data-table-pagination">
            {{ $paginationSlot }}
        </div>
    @elseif ($pagination === true)
        <div class="ui-data-table-pagination">
            <x-ui.pagination
                id="{{ $tableId }}-pagination"
                label="{{ ($title ?? $ariaLabel ?? 'Data table').' pagination' }}"
                variant="pagination"
                :current-page="1"
                :total-pages="4"
                :total-items="96"
                :page-size="25"
                :page-size-options="[10, 25, 50]"
                base-url="#"
            />
        </div>
    @elseif (filled($pagination))
        <div class="ui-data-table-pagination">
            {{ $pagination }}
        </div>
    @endif
</x-ui.data-table.container>
