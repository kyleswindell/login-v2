@props([
    'rows' => [],
    'selectable' => false,
    'condensed' => false,
])

<div
    class="overflow-hidden rounded-lg border"
    style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);"
    data-ui-component="structured-list"
    data-ui-structured-list-selectable="{{ $selectable ? 'true' : 'false' }}"
    data-ui-structured-list-density="{{ $condensed ? 'condensed' : 'standard' }}"
>
    @if (! empty($rows))
        @foreach ($rows as $row)
            <x-ui.structured-list-row
                :title="data_get($row, 'title')"
                :description="data_get($row, 'description')"
                :meta="data_get($row, 'meta')"
                :selected="(bool) data_get($row, 'selected', false)"
                :disabled="(bool) data_get($row, 'disabled', false)"
            />
        @endforeach
    @else
        {{ $slot }}
    @endif
</div>
