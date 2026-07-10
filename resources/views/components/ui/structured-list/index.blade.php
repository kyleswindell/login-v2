{{-- ==========================================================================
    File: resources/views/components/ui/structured-list/index.blade.php
    Purpose: Structured List component.

    Notes:
    - Emits the installed .ui-structured-list selector contract.
    - Uses native table semantics for table-backed row/column comparison.
    - Supports generated columns, rich cells, selectable single radio rows,
      condensed rows, hang/flush alignment, background treatment, disabled rows,
      empty state, and skeleton state.
    - Use Data Table for sorting, filtering, pagination, expansion, row actions,
      batch actions, or multiple row selection.
    ========================================================================== --}}

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
    use Illuminate\Support\Str;
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Resolve State
    |--------------------------------------------------------------------------
    */

    $listId = $id ?? 'structured-list-'.Str::random(8);

    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $isSkeleton = filter_var($skeleton, FILTER_VALIDATE_BOOLEAN);
    $isCondensed = filter_var($condensed, FILTER_VALIDATE_BOOLEAN) || $size === 'condensed';
    $isSelectable = filter_var($selectable, FILTER_VALIDATE_BOOLEAN) || $variant === 'selectable';

    $resolvedSize = $isCondensed ? 'condensed' : 'default';

    $resolvedAlignment = in_array($alignment, ['hang', 'flush'], true)
        ? $alignment
        : 'hang';

    $resolvedAlignment = $isSelectable ? 'hang' : $resolvedAlignment;

    $hasBackground = filter_var($background, FILTER_VALIDATE_BOOLEAN)
        && $resolvedAlignment === 'hang';

    $selectionName = $name ?? $listId.'_selection';

    /*
    |--------------------------------------------------------------------------
    | Normalize Rows
    |--------------------------------------------------------------------------
    */

    $normalizedRows = collect($rows)->values();

    $hasRichCells = $normalizedRows->contains(fn ($row) => is_array(data_get($row, 'cells')));

    /*
    |--------------------------------------------------------------------------
    | Normalize Columns
    |--------------------------------------------------------------------------
    */

    if (empty($columns)) {
        $columns = $hasRichCells
            ? collect(data_get($normalizedRows->first(), 'cells', []))
                ->keys()
                ->map(fn ($key) => [
                    'key' => $key,
                    'label' => Str::headline((string) $key),
                ])
                ->all()
            : [
                ['key' => 'title', 'label' => 'Item'],
                ['key' => 'meta', 'label' => 'Status'],
            ];
    }

    $normalizedColumns = collect($columns)
        ->map(function ($column): array {
            if (is_string($column)) {
                return [
                    'key' => $column,
                    'label' => Str::headline($column),
                    'truncate' => false,
                ];
            }

            $key = (string) data_get($column, 'key', data_get($column, 'label', ''));

            return [
                'key' => $key,
                'label' => (string) data_get($column, 'label', $key),
                'truncate' => filter_var(data_get($column, 'truncate', false), FILTER_VALIDATE_BOOLEAN),
            ];
        })
        ->filter(fn ($column) => filled($column['key']))
        ->values();

    $columnCount = $normalizedColumns->count() + ($isSelectable ? 1 : 0);

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $tableClasses = [
        'ui-structured-list',
        'ui-structured-list-'.$resolvedAlignment,
        'ui-structured-list-condensed' => $resolvedSize === 'condensed',
        'ui-structured-list-selectable' => $isSelectable,
        'ui-structured-list-background' => $hasBackground,
        'ui-structured-list-skeleton' => $isSkeleton,
    ];
@endphp

<div
    class="ui-structured-list-shell"
    data-ui-component="structured-list"
    data-ui-structured-list
    data-ui-structured-list-selectable="{{ $isSelectable ? 'true' : 'false' }}"
    data-ui-structured-list-size="{{ $resolvedSize }}"
    data-ui-structured-list-alignment="{{ $resolvedAlignment }}"
    data-ui-structured-list-row-count="{{ $normalizedRows->count() }}"
    data-ui-structured-list-column-count="{{ $normalizedColumns->count() }}"
    @if ($hasBackground) data-ui-structured-list-background="true" @endif
    @if ($isDisabled) data-ui-structured-list-disabled="true" @endif
    @if ($isSkeleton) aria-busy="true" @endif
>
    <table {{ $attributes->class($tableClasses) }}>
        @if (filled($caption))
            <caption class="sr-only">
                @if ($caption instanceof HtmlString)
                    {!! $caption !!}
                @else
                    {{ $caption }}
                @endif
            </caption>
        @endif

        <thead class="ui-structured-list-head">
            <tr class="ui-structured-list-row">
                @if ($isSelectable)
                    <th class="ui-structured-list-header ui-structured-list-selection-cell" scope="col">
                        <span class="sr-only">Select row</span>
                    </th>
                @endif

                @foreach ($normalizedColumns as $column)
                    <th
                        class="ui-structured-list-header"
                        scope="col"
                        title="{{ $column['label'] }}"
                        @if ($column['truncate']) data-ui-structured-list-header-truncate="true" @endif
                    >
                        {{ $column['label'] }}
                    </th>
                @endforeach
            </tr>
        </thead>

        <tbody class="ui-structured-list-body">
            @if ($isSkeleton)
                @for ($rowIndex = 0; $rowIndex < 3; $rowIndex++)
                    <tr class="ui-structured-list-row" aria-hidden="true" data-ui-structured-list-skeleton-row>
                        @if ($isSelectable)
                            <td class="ui-structured-list-cell ui-structured-list-selection-cell">
                                <span class="ui-structured-list-radio-placeholder"></span>
                            </td>
                        @endif

                        @foreach ($normalizedColumns as $column)
                            <td class="ui-structured-list-cell">
                                <span class="ui-structured-list-skeleton-line"></span>
                            </td>
                        @endforeach
                    </tr>
                @endfor
            @elseif ($normalizedRows->isEmpty())
                <tr class="ui-structured-list-row" data-ui-structured-list-empty-row>
                    <td class="ui-structured-list-cell" colspan="{{ $columnCount }}">
                        <div class="ui-structured-list-empty" role="status">
                            {{ $emptyText }}
                        </div>
                    </td>
                </tr>
            @else
                @foreach ($normalizedRows as $rowIndex => $row)
                    @php
                        $rawRowId = (string) data_get($row, 'id', data_get($row, 'value', $rowIndex));
                        $safeRowId = Str::slug($rawRowId) ?: (string) $rowIndex;
                        $rowDomId = $listId.'-'.$safeRowId;

                        $rowValue = (string) data_get($row, 'value', $rawRowId);
                        $isRowDisabled = $isDisabled || filter_var(data_get($row, 'disabled', false), FILTER_VALIDATE_BOOLEAN);
                        $isSelected = (string) ($value ?? '') === $rowValue
                            || filter_var(data_get($row, 'selected', false), FILTER_VALIDATE_BOOLEAN);

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
                        data-ui-structured-list-row-disabled="{{ $isRowDisabled ? 'true' : 'false' }}"
                        @if ($isSelectable) data-ui-structured-list-selectable-row @endif
                        @if ($isRowDisabled) aria-disabled="true" @endif
                    >
                        @if ($isSelectable)
                            <td class="ui-structured-list-cell ui-structured-list-selection-cell">
                                <input
                                    id="{{ $rowDomId }}"
                                    class="ui-structured-list-radio"
                                    type="radio"
                                    name="{{ $selectionName }}"
                                    value="{{ $rowValue }}"
                                    @checked($isSelected)
                                    @disabled($isRowDisabled)
                                    aria-labelledby="{{ $rowDomId }}-label"
                                    data-ui-structured-list-radio
                                >
                            </td>
                        @endif

                        @foreach ($normalizedColumns as $columnIndex => $column)
                            @php
                                $cellValue = is_array($rowCells)
                                    ? data_get($rowCells, $column['key'])
                                    : data_get($row, $column['key']);

                                if (! is_array($rowCells) && $column['key'] === 'title') {
                                    $cellValue = $cellValue ?? data_get($row, 'label');
                                }

                                $description = ! is_array($rowCells) && $column['key'] === 'title'
                                    ? data_get($row, 'description')
                                    : null;

                                $cellId = $columnIndex === 0 ? $rowDomId.'-label' : null;
                            @endphp

                            @if ($columnIndex === 0)
                                <th
                                    id="{{ $cellId }}"
                                    class="ui-structured-list-cell ui-structured-list-row-header"
                                    scope="row"
                                >
                                    <span>
                                        @if ($cellValue instanceof HtmlString)
                                            {!! $cellValue !!}
                                        @else
                                            {{ $cellValue }}
                                        @endif
                                    </span>

                                    @if (filled($description))
                                        <span class="ui-structured-list-cell-description">
                                            @if ($description instanceof HtmlString)
                                                {!! $description !!}
                                            @else
                                                {{ $description }}
                                            @endif
                                        </span>
                                    @endif
                                </th>
                            @else
                                <td class="ui-structured-list-cell">
                                    <span>
                                        @if ($cellValue instanceof HtmlString)
                                            {!! $cellValue !!}
                                        @else
                                            {{ $cellValue }}
                                        @endif
                                    </span>
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>