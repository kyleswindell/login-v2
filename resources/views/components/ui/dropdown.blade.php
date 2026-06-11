@props([
    'name',
    'id' => null,
    'label',
    'options' => [],
    'value' => null,
    'placeholder' => 'Choose an option',
    'helper' => null,
    'error' => null,
    'warning' => null,
    'disabled' => false,
    'open' => false,
])

@php
    $fieldId = $id ?? str($name)->slug('-')->toString();
    $statusId = $error || $warning ? $fieldId.'-status' : null;
    $helperId = $helper ? $fieldId.'-helper' : null;
    $describedBy = trim(collect([$helperId, $statusId])->filter()->implode(' '));
    $selected = collect($options)->first(fn ($option) => (string) data_get($option, 'value') === (string) $value);
@endphp

<div class="ui-field ui-searchable-select" data-ui-component="dropdown" data-ui-dropdown>
    <label id="{{ $fieldId }}-label" class="ui-field-label">{{ $label }}</label>
    <input type="hidden" name="{{ $name }}" value="{{ $value }}" data-ui-dropdown-hidden-input>
    <button
        type="button"
        class="ui-input ui-searchable-select-trigger"
        aria-haspopup="listbox"
        aria-expanded="{{ $open ? 'true' : 'false' }}"
        aria-labelledby="{{ $fieldId }}-label"
        @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
        @disabled($disabled)
        data-ui-dropdown-trigger
    >
        <span class="ui-searchable-select-trigger-text" data-ui-dropdown-value>{{ data_get($selected, 'label', $placeholder) }}</span>
        <span aria-hidden="true">⌄</span>
    </button>
    <div class="ui-searchable-select-panel" role="listbox" data-ui-dropdown-menu @if(! $open) hidden @endif>
        <div class="ui-searchable-select-options">
            @foreach ($options as $option)
                @php $optionValue = data_get($option, 'value'); @endphp
                <button
                    type="button"
                    class="ui-searchable-select-option"
                    role="option"
                    aria-selected="{{ (string) $optionValue === (string) $value ? 'true' : 'false' }}"
                    data-ui-dropdown-option
                    data-ui-dropdown-value="{{ $optionValue }}"
                >
                    <span>{{ data_get($option, 'label', $optionValue) }}</span>
                </button>
            @endforeach
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
