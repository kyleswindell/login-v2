@props([
    'id',
    'name',
    'options' => [],
    'selected' => null,
    'placeholder' => 'Select an option',
    'searchLabel' => 'Search available options',
    'searchPlaceholder' => 'Search available options',
    'emptyLabel' => 'No matching options',
    'required' => false,
    'disabled' => false,
    'invalid' => false,
])

@php
    $normalizedOptions = collect($options)
        ->map(function (array $option): array {
            $value = (string) ($option['value'] ?? '');

            return [
                'value' => $value,
                'label' => (string) ($option['label'] ?? $value),
            ];
        })
        ->values()
        ->all();

    $selectedValue = $selected === null ? '' : (string) $selected;
@endphp

<div
    data-ui-component="searchable-select"
    data-ui-searchable-select
    data-ui-searchable-select-empty-label="{{ $emptyLabel }}"
    class="ui-searchable-select"
>
    <label for="{{ $id }}__filter" class="sr-only">{{ $searchLabel }}</label>
    <div class="relative">
        <span class="ui-searchable-select-icon">
            <x-heroicon-o-magnifying-glass class="h-4 w-4" aria-hidden="true" />
        </span>
        <input
            id="{{ $id }}__filter"
            type="search"
            value=""
            placeholder="{{ $searchPlaceholder }}"
            class="ui-input ui-searchable-select-filter"
            autocomplete="off"
            data-ui-searchable-select-filter
        >
    </div>

    <select
        id="{{ $id }}"
        name="{{ $name }}"
        class="ui-select w-full"
        @disabled($disabled)
        @required($required)
        @if($invalid) aria-invalid="true" @endif
        data-ui-searchable-select-list
    >
        <option value="" data-ui-searchable-select-placeholder="true" @selected($selectedValue === '')>{{ $placeholder }}</option>
        @foreach ($normalizedOptions as $option)
            <option value="{{ $option['value'] }}" @selected($selectedValue === $option['value'])>{{ $option['label'] }}</option>
        @endforeach
    </select>

    <p class="ui-searchable-select-count" data-ui-searchable-select-count>
        {{ count($normalizedOptions) }} options available
    </p>
</div>
