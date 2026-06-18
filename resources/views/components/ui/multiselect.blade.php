@props([
    'name',
    'id' => null,
    'label',
    'options' => [],
    'value' => [],
    'placeholder' => 'Choose options',
    'helper' => null,
    'error' => null,
    'warning' => null,
    'disabled' => false,
    'readonly' => false,
    'required' => false,
    'open' => false,
    'filterable' => false,
    'clearable' => false,
    'selectAll' => false,
    'loading' => false,
    'emptyMessage' => 'No options available',
])

@php
    $fieldId = $id ?? str($name)->slug('-')->toString();
    $selectedValues = collect(is_array($value) ? $value : [$value])->filter(fn ($item) => filled($item))->map(fn ($item) => (string) $item);
    $selectedOptions = collect($options)->filter(fn ($option) => $selectedValues->contains((string) data_get($option, 'value')));
    $inputName = str_ends_with($name, '[]') ? $name : $name.'[]';
    $helperId = $helper ? $fieldId.'-helper' : null;
    $statusId = $error || $warning ? $fieldId.'-status' : null;
    $describedBy = trim(collect([$helperId, $statusId])->filter()->implode(' '));
    $isUnavailable = $disabled || $readonly;
@endphp

<div
    class="ui-field ui-list-box-wrapper ui-multiselect"
    data-ui-component="multiselect"
    data-ui-multiselect
    data-ui-multiselect-name="{{ $inputName }}"
    data-ui-multiselect-filterable="{{ $filterable ? 'true' : 'false' }}"
    data-ui-multiselect-clearable="{{ $clearable ? 'true' : 'false' }}"
    data-ui-multiselect-select-all="{{ $selectAll ? 'true' : 'false' }}"
>
    <label id="{{ $fieldId }}-label" class="ui-field-label">
        {{ $label }}
        @if ($required)
            <span class="ui-field-required" aria-hidden="true">*</span>
        @endif
    </label>

    @foreach ($selectedValues as $selectedValue)
        <input type="hidden" name="{{ $inputName }}" value="{{ $selectedValue }}" data-ui-multiselect-hidden-input>
    @endforeach

    <button
        type="button"
        @class([
            'ui-list-box',
            'ui-list-box-field',
            'ui-list-box-expanded' => $open,
            'ui-list-box-disabled' => $isUnavailable,
            'ui-list-box-invalid' => filled($error),
            'ui-list-box-warning' => filled($warning) && blank($error),
            'ui-input',
            'ui-searchable-select-trigger',
            'ui-multiselect-trigger',
        ])
        aria-haspopup="listbox"
        aria-expanded="{{ $open ? 'true' : 'false' }}"
        aria-labelledby="{{ $fieldId }}-label"
        @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
        @if($error) aria-invalid="true" @endif
        @if($warning && ! $error) data-ui-field-warning="true" @endif
        @disabled($isUnavailable)
        data-ui-multiselect-trigger
    >
        <span class="ui-multiselect-values" data-ui-multiselect-value>
            @forelse ($selectedOptions as $option)
                <span class="ui-multiselect-tag" data-ui-multiselect-selected-value="{{ data_get($option, 'value') }}">
                    {{ data_get($option, 'label', data_get($option, 'value')) }}
                </span>
            @empty
                <span class="ui-multiselect-placeholder">{{ $placeholder }}</span>
            @endforelse
        </span>
        <span class="ui-list-box-menu-icon ui-multiselect-chevron" aria-hidden="true">
            <x-heroicon-o-chevron-down class="ui-multiselect-chevron-icon" />
        </span>
    </button>

    <div @class(['ui-list-box-menu', 'ui-list-box-menu-open' => $open, 'ui-searchable-select-panel', 'ui-multiselect-panel']) role="listbox" aria-multiselectable="true" data-ui-multiselect-menu @if(! $open) hidden @endif>
        @if ($filterable)
            <div class="ui-searchable-select-filter-shell">
                <input
                    type="search"
                    class="ui-searchable-select-filter"
                    placeholder="Filter options"
                    data-ui-multiselect-filter
                >
            </div>
        @endif

        @if ($clearable || $selectAll)
            <div class="ui-multiselect-actions">
                @if ($selectAll)
                    <button type="button" class="ui-link" data-ui-multiselect-select-all>Select all</button>
                @endif
                @if ($clearable)
                    <button type="button" class="ui-link" data-ui-multiselect-clear>Clear</button>
                @endif
            </div>
        @endif

        <div class="ui-searchable-select-options" data-ui-multiselect-options>
            @if ($loading)
                <p class="ui-searchable-select-empty" data-ui-multiselect-loading>Loading options</p>
            @elseif (empty($options))
                <p class="ui-searchable-select-empty" data-ui-multiselect-empty>{{ $emptyMessage }}</p>
            @else
                @foreach ($options as $option)
                    @php
                        $optionValue = (string) data_get($option, 'value');
                        $optionDisabled = (bool) data_get($option, 'disabled', false);
                        $isSelected = $selectedValues->contains($optionValue);
                    @endphp
                    <button
                        type="button"
                        @class([
                            'ui-list-box-menu-item',
                            'ui-list-box-menu-item-selected' => $isSelected,
                            'ui-list-box-menu-item-disabled' => $optionDisabled,
                            'ui-searchable-select-option',
                            'ui-multiselect-option',
                        ])
                        role="option"
                        aria-selected="{{ $isSelected ? 'true' : 'false' }}"
                        @disabled($optionDisabled)
                        data-ui-multiselect-option
                        data-ui-multiselect-option-value="{{ $optionValue }}"
                    >
                        <span class="ui-list-box-menu-item-option" data-ui-multiselect-option-label>{{ data_get($option, 'label', $optionValue) }}</span>
                        <span aria-hidden="true" data-ui-multiselect-option-check>{{ $isSelected ? 'Selected' : '' }}</span>
                    </button>
                @endforeach
            @endif
        </div>
    </div>

    @if ($helper)
        <p id="{{ $helperId }}" class="ui-field-helper">{{ $helper }}</p>
    @endif
    @if ($error)
        <p id="{{ $statusId }}" class="ui-field-error">{{ $error }}</p>
    @elseif ($warning)
        <p id="{{ $statusId }}" class="ui-field-warning">{{ $warning }}</p>
    @endif
</div>
