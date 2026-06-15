@props([
    'id' => null,
    'caption' => null,
    'columns' => [],
    'rows' => [],
    'variant' => 'default',
    'selectable' => false,
    'name' => null,
    'value' => null,
    'size' => 'default',
    'condensed' => false,
    'alignment' => 'hang',
    'background' => false,
    'disabled' => false,
    'skeleton' => false,
    'emptyText' => 'No rows available.',
])

@php
    $listId = $id ?? 'structured-list-'.str()->random(8);
    $isSelectable = $selectable || $variant === 'selectable';
    $size = $condensed || $size === 'condensed' ? 'condensed' : 'default';
    $alignment = $isSelectable ? 'hang' : (in_array($alignment, ['hang', 'flush'], true) ? $alignment : 'hang');
    $background = (bool) $background && $alignment === 'hang';
    $selectionName = $name ?? $listId.'_selection';

    $normalizedRows = collect($rows)->values();
    $hasRichCells = $normalizedRows->contains(fn ($row) => is_array(data_get($row, 'cells')));

    if (empty($columns)) {
        $columns = $hasRichCells
            ? collect(data_get($normalizedRows->first(), 'cells', []))->keys()->map(fn ($key) => ['key' => $key, 'label' => str($key)->headline()->toString()])->all()
            : [
                ['key' => 'title', 'label' => 'Item'],
                ['key' => 'meta', 'label' => 'Status'],
            ];
    }

    $columns = collect($columns)->map(function ($column) {
        if (is_string($column)) {
            return ['key' => $column, 'label' => str($column)->headline()->toString()];
        }

        return [
            'key' => data_get($column, 'key', data_get($column, 'label')),
            'label' => data_get($column, 'label', data_get($column, 'key')),
            'truncate' => (bool) data_get($column, 'truncate', false),
        ];
    })->filter(fn ($column) => filled($column['key']))->values();
@endphp

<div
    class="ui-structured-list-shell"
    data-ui-component="structured-list"
    data-ui-structured-list
    data-ui-structured-list-selectable="{{ $isSelectable ? 'true' : 'false' }}"
    data-ui-structured-list-size="{{ $size }}"
    data-ui-structured-list-alignment="{{ $alignment }}"
    @if($background) data-ui-structured-list-background="true" @endif
    @if($disabled) data-ui-structured-list-disabled="true" @endif
    @if($skeleton) aria-busy="true" @endif
>
    <table
        {{ $attributes->class([
            'ui-structured-list',
            'ui-structured-list-'.$alignment,
            'ui-structured-list-condensed' => $size === 'condensed',
            'ui-structured-list-selectable' => $isSelectable,
            'ui-structured-list-background' => $background,
            'ui-structured-list-skeleton' => $skeleton,
        ]) }}
    >
        @if ($caption)
            <caption class="sr-only">{{ $caption }}</caption>
        @endif

        <thead class="ui-structured-list-head">
            <tr class="ui-structured-list-row">
                @if ($isSelectable)
                    <th class="ui-structured-list-header ui-structured-list-selection-cell" scope="col">
                        <span class="sr-only">Select row</span>
                    </th>
                @endif
                @foreach ($columns as $column)
                    <th
                        class="ui-structured-list-header"
                        scope="col"
                        title="{{ $column['label'] }}"
                        @if($column['truncate']) data-ui-structured-list-header-truncate="true" @endif
                    >
                        {{ $column['label'] }}
                    </th>
                @endforeach
            </tr>
        </thead>

        <tbody class="ui-structured-list-body">
            @if ($skeleton)
                @for ($rowIndex = 0; $rowIndex < 3; $rowIndex++)
                    <tr class="ui-structured-list-row" aria-hidden="true">
                        @if ($isSelectable)
                            <td class="ui-structured-list-cell ui-structured-list-selection-cell">
                                <span class="ui-structured-list-radio-placeholder"></span>
                            </td>
                        @endif
                        @foreach ($columns as $column)
                            <td class="ui-structured-list-cell">
                                <span class="ui-structured-list-skeleton-line"></span>
                            </td>
                        @endforeach
                    </tr>
                @endfor
            @elseif ($normalizedRows->isEmpty())
                <tr class="ui-structured-list-row">
                    <td class="ui-structured-list-cell" colspan="{{ $columns->count() + ($isSelectable ? 1 : 0) }}">
                        <div class="ui-structured-list-empty" role="status">{{ $emptyText }}</div>
                    </td>
                </tr>
            @else
                @foreach ($normalizedRows as $rowIndex => $row)
                    @php
                        $rowId = (string) data_get($row, 'id', data_get($row, 'value', $rowIndex));
                        $rowValue = (string) data_get($row, 'value', $rowId);
                        $isRowDisabled = $disabled || (bool) data_get($row, 'disabled', false);
                        $isSelected = (string) ($value ?? '') === $rowValue || (bool) data_get($row, 'selected', false);
                        $rowCells = data_get($row, 'cells');
                    @endphp
                    <tr
                        @class([
                            'ui-structured-list-row',
                            'ui-structured-list-row-selected' => $isSelected,
                            'ui-structured-list-row-disabled' => $isRowDisabled,
                        ])
                        data-ui-component="structured-list-row"
                        data-ui-structured-list-row
                        data-ui-structured-list-row-selected="{{ $isSelected ? 'true' : 'false' }}"
                        @if($isSelectable) data-ui-structured-list-selectable-row @endif
                        @if($isRowDisabled) aria-disabled="true" @endif
                    >
                        @if ($isSelectable)
                            <td class="ui-structured-list-cell ui-structured-list-selection-cell">
                                <input
                                    id="{{ $listId }}-{{ $rowId }}"
                                    class="ui-structured-list-radio"
                                    type="radio"
                                    name="{{ $selectionName }}"
                                    value="{{ $rowValue }}"
                                    @checked($isSelected)
                                    @disabled($isRowDisabled)
                                    aria-labelledby="{{ $listId }}-{{ $rowId }}-label"
                                    data-ui-structured-list-radio
                                >
                            </td>
                        @endif

                        @foreach ($columns as $columnIndex => $column)
                            @php
                                $cellValue = is_array($rowCells)
                                    ? data_get($rowCells, $column['key'])
                                    : data_get($row, $column['key']);

                                if (! is_array($rowCells) && $column['key'] === 'title') {
                                    $cellValue = $cellValue ?? data_get($row, 'label');
                                }

                                $description = ! is_array($rowCells) && $column['key'] === 'title' ? data_get($row, 'description') : null;
                                $cellId = $columnIndex === 0 ? $listId.'-'.$rowId.'-label' : null;
                            @endphp

                            @if ($columnIndex === 0)
                                <th
                                    id="{{ $cellId }}"
                                    class="ui-structured-list-cell ui-structured-list-row-header"
                                    scope="row"
                                >
                                    <span>{{ $cellValue }}</span>
                                    @if ($description)
                                        <span class="ui-structured-list-cell-description">{{ $description }}</span>
                                    @endif
                                </th>
                            @else
                                <td class="ui-structured-list-cell">
                                    <span>{{ $cellValue }}</span>
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
