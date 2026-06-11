@props([
    'columns' => [],
    'rows' => [],
    'title' => null,
    'description' => null,
    'ariaLabel' => null,
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
])

@php
    $resolvedDensity = in_array($density, ['standard', 'compact'], true) ? $density : 'standard';
    $isEmpty = is_null($empty) ? count($rows) === 0 : (bool) $empty;
    $tableId = $attributes->get('id') ?? 'ui-data-table-'.substr(md5(($title ?? $ariaLabel ?? 'table').count($rows)), 0, 8);
    $labelId = $title ? $tableId.'-title' : null;
@endphp

<section
    {{ $attributes->class([
        'ui-data-table-wrapper',
        'ui-data-table-density-standard' => $resolvedDensity === 'standard',
        'ui-data-table-density-compact' => $resolvedDensity === 'compact',
    ]) }}
    data-ui-data-table
>
    @if($title || $description)
        <header class="ui-data-table-header">
            @if($title)
                <h3 id="{{ $labelId }}" class="ui-data-table-title">{{ $title }}</h3>
            @endif
            @if($description)
                <p class="ui-data-table-description">{{ $description }}</p>
            @endif
        </header>
    @endif

    @isset($toolbar)
        {{ $toolbar }}
    @endisset

    @if($error)
        <x-ui.data-table-empty-state class="ui-data-table-error" title="Table failed to load" :description="$error" />
    @elseif($isEmpty && ! $loading)
        <x-ui.data-table-empty-state :title="$emptyTitle" :description="$emptyDescription" />
    @else
        <div class="ui-data-table-overflow" tabindex="0">
            <table
                class="ui-data-table-table"
                @if($labelId) aria-labelledby="{{ $labelId }}" @else aria-label="{{ $ariaLabel ?? 'Data table' }}" @endif
            >
                <thead class="ui-data-table-head">
                    <tr>
                        @foreach($columns as $column)
                            @php
                                $key = data_get($column, 'key');
                                $label = data_get($column, 'label', str($key)->headline()->toString());
                                $align = data_get($column, 'align', 'start');
                                $columnSortable = $sortable && (bool) data_get($column, 'sortable', false);
                                $isSorted = $columnSortable && $sortBy === $key;
                                $ariaSort = $isSorted ? ($sortDirection === 'desc' ? 'descending' : 'ascending') : 'none';
                            @endphp
                            <th
                                class="ui-data-table-header-cell ui-data-table-cell-align-{{ $align }}"
                                scope="col"
                                @if($columnSortable) aria-sort="{{ $ariaSort }}" @endif
                            >
                                @if($columnSortable)
                                    <button type="button" @class(['ui-table-sort', 'is-active' => $isSorted]) data-ui-data-table-sort>
                                        <span>{{ $label }}</span>
                                        <span class="ui-table-sort-icon" aria-hidden="true">{{ $isSorted ? ($sortDirection === 'desc' ? '↓' : '↑') : '↕' }}</span>
                                    </button>
                                @else
                                    {{ $label }}
                                @endif
                            </th>
                        @endforeach
                        @if($rowActions || isset($rowActionsSlot))
                            <th class="ui-data-table-header-cell ui-data-table-cell-actions" scope="col">Actions</th>
                        @endif
                    </tr>
                </thead>
                @if($loading)
                    <x-ui.data-table-skeleton :columns="count($columns) + (($rowActions || isset($rowActionsSlot)) ? 1 : 0)" />
                @else
                    <tbody class="ui-data-table-body">
                        @foreach($rows as $row)
                            <tr @class(['ui-data-table-row ui-table-row', 'ui-data-table-row-current' => (bool) data_get($row, 'current', false), 'ui-data-table-row-selected' => (bool) data_get($row, 'selected', false)]) data-ui-data-table-row>
                                @foreach($columns as $column)
                                    @php
                                        $key = data_get($column, 'key');
                                        $align = data_get($column, 'align', 'start');
                                        $value = data_get($row, $key, '');
                                    @endphp
                                    <td class="ui-data-table-cell ui-data-table-cell-align-{{ $align }}" data-ui-data-table-cell>
                                        {!! is_string($value) ? e($value) : $value !!}
                                    </td>
                                @endforeach
                                @if($rowActions || isset($rowActionsSlot))
                                    <td class="ui-data-table-cell ui-data-table-cell-actions">
                                        @isset($rowActionsSlot)
                                            {{ $rowActionsSlot }}
                                        @else
                                            <x-ui.button semantic="ghost" size="sm">Open</x-ui.button>
                                        @endisset
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    @endif

    @isset($paginationSlot)
        <div class="ui-data-table-pagination">
            {{ $paginationSlot }}
        </div>
    @elseif($pagination)
        <div class="ui-data-table-pagination">
            {{ $pagination }}
        </div>
    @endif
</section>
