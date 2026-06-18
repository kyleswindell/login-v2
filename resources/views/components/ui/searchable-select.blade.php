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
    $selectedLabel = collect($normalizedOptions)
        ->firstWhere('value', $selectedValue)['label']
        ?? $placeholder;
@endphp

<div
    data-ui-component="searchable-select"
    data-ui-searchable-select
    data-ui-searchable-select-empty-label="{{ $emptyLabel }}"
    class="ui-list-box-wrapper ui-searchable-select"
>
    <input
        type="hidden"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ $selectedValue }}"
        data-ui-searchable-select-value
        @disabled($disabled)
        @required($required)
        @if($invalid) aria-invalid="true" @endif
    >

    <button
        type="button"
        class="ui-list-box ui-list-box-field ui-select ui-searchable-select-trigger"
        data-ui-searchable-select-trigger
        data-ui-searchable-select-label="{{ $placeholder }}"
        aria-haspopup="listbox"
        aria-expanded="false"
        aria-controls="{{ $id }}__options"
        @disabled($disabled)
    >
        <span class="ui-list-box-label ui-searchable-select-trigger-text" data-ui-searchable-select-trigger-text>
            {{ $selectedLabel }}
        </span>
        <x-heroicon-o-chevron-up-down
            class="h-4 w-4 shrink-0"
            data-ui-searchable-select-trigger-icon
            aria-hidden="true"
        />
    </button>

    <div class="ui-list-box-menu ui-searchable-select-panel hidden" data-ui-searchable-select-panel>
        <div class="ui-searchable-select-filter-shell">
            <label for="{{ $id }}__filter" class="sr-only">{{ $searchLabel }}</label>
            <span class="ui-searchable-select-icon">
                <x-heroicon-o-magnifying-glass class="h-4 w-4" aria-hidden="true" />
            </span>
            <input
                id="{{ $id }}__filter"
                type="search"
                value=""
                placeholder="{{ $searchPlaceholder }}"
                class="ui-searchable-select-filter"
                autocomplete="off"
                data-ui-searchable-select-filter
            >
        </div>

        <div
            id="{{ $id }}__options"
            class="ui-searchable-select-options ui-scrollbar"
            role="listbox"
            data-ui-searchable-select-options
        >
            @foreach ($normalizedOptions as $option)
                <button
                    type="button"
                    class="ui-list-box-menu-item ui-searchable-select-option"
                    data-ui-searchable-select-option
                    data-value="{{ $option['value'] }}"
                    data-label="{{ $option['label'] }}"
                    role="option"
                    aria-selected="{{ $selectedValue === $option['value'] ? 'true' : 'false' }}"
                >
                    <span class="ui-list-box-menu-item-option">{{ $option['label'] }}</span>
                    @if ($selectedValue === $option['value'])
                        <x-heroicon-o-check
                            class="h-4 w-4 shrink-0"
                            data-ui-searchable-select-check
                            aria-hidden="true"
                        />
                    @endif
                </button>
            @endforeach

            <p class="ui-searchable-select-empty hidden" data-ui-searchable-select-empty>
                {{ $emptyLabel }}
            </p>
        </div>
    </div>
</div>
