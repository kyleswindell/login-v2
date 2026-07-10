@props([
    'rows' => 5,
    'columns' => 4,
])

<tbody {{ $attributes->class(['ui-data-table-skeleton']) }} data-ui-data-table-loading>
    @for($row = 0; $row < $rows; $row++)
        <tr class="ui-data-table-row ui-table-row">
            @for($column = 0; $column < $columns; $column++)
                <td class="ui-data-table-cell">
                    <span class="ui-data-table-skeleton-line" aria-hidden="true"></span>
                </td>
            @endfor
        </tr>
    @endfor
</tbody>
