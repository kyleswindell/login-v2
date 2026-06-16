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
    'size' => 'md',
    'variant' => 'default',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'open' => false,
    'menuMaxHeight' => null,
    'placement' => 'auto',
])

@php
    $fieldId = $id ?? str($name)->slug('-')->toString();
    $menuId = $fieldId.'-menu';
    $statusId = $error || $warning ? $fieldId.'-status' : null;
    $helperId = $helper ? $fieldId.'-helper' : null;
    $describedBy = trim(collect([$helperId, $statusId])->filter()->implode(' '));
    $selected = collect($options)->first(fn ($option) => (string) data_get($option, 'value') === (string) $value);
    $selectedLabel = data_get($selected, 'label');
    $size = in_array($size, ['sm', 'md', 'lg'], true) ? $size : 'md';
    $variant = $variant === 'fluid' ? 'fluid' : 'default';
    $placement = in_array($placement, ['auto', 'down', 'up'], true) ? $placement : 'auto';
    $isDisabled = (bool) $disabled;
    $isReadOnly = (bool) $readonly;
    $isInvalid = filled($error);
    $isWarning = ! $isInvalid && filled($warning);
@endphp

<div
    {{ $attributes->class([
        'ui-field',
        'ui-dropdown',
        'ui-dropdown-'.$size,
        'ui-dropdown-fluid' => $variant === 'fluid',
        'ui-dropdown-open' => $open,
        'ui-dropdown-disabled' => $isDisabled,
        'ui-dropdown-readonly' => $isReadOnly,
        'ui-dropdown-invalid' => $isInvalid,
        'ui-dropdown-warning' => $isWarning,
    ]) }}
    data-ui-component="dropdown"
    data-ui-dropdown
    data-ui-dropdown-size="{{ $size }}"
    data-ui-dropdown-variant="{{ $variant }}"
    data-ui-dropdown-placement="{{ $placement }}"
    data-ui-dropdown-open="{{ $open ? 'true' : 'false' }}"
    data-ui-dropdown-readonly="{{ $isReadOnly ? 'true' : 'false' }}"
>
    <label id="{{ $fieldId }}-label" class="ui-field-label">{{ $label }}</label>
    <input type="hidden" name="{{ $name }}" value="{{ $value }}" data-ui-dropdown-hidden-input>
    <button
        id="{{ $fieldId }}"
        type="button"
        class="ui-dropdown-trigger"
        aria-haspopup="listbox"
        aria-expanded="{{ $open ? 'true' : 'false' }}"
        aria-controls="{{ $menuId }}"
        aria-labelledby="{{ $fieldId }}-label"
        @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
        @if($isInvalid) aria-invalid="true" @endif
        @if($isReadOnly) aria-readonly="true" @endif
        @if($required) aria-required="true" @endif
        @disabled($isDisabled)
        data-ui-dropdown-trigger
        data-ui-dropdown-field
        data-ui-dropdown-unified-trigger
    >
        <span @class(['ui-dropdown-value', 'ui-dropdown-placeholder' => blank($selectedLabel)]) data-ui-dropdown-value>{{ $selectedLabel ?? $placeholder }}</span>
        @if ($isInvalid)
            <x-heroicon-o-x-circle class="ui-dropdown-status-icon ui-dropdown-status-icon-error" aria-hidden="true" />
        @elseif ($isWarning)
            <x-heroicon-o-exclamation-triangle class="ui-dropdown-status-icon ui-dropdown-status-icon-warning" aria-hidden="true" />
        @endif
        <span class="ui-dropdown-chevron" aria-hidden="true" data-ui-dropdown-chevron>
            <x-heroicon-o-chevron-down class="ui-dropdown-chevron-icon" />
        </span>
    </button>
    <div
        id="{{ $menuId }}"
        class="ui-dropdown-menu"
        role="listbox"
        aria-labelledby="{{ $fieldId }}-label"
        data-ui-dropdown-menu
        @if($menuMaxHeight) style="--ui-dropdown-menu-max-height: {{ $menuMaxHeight }};" @endif
        @if(! $open) hidden @endif
    >
        <div class="ui-dropdown-options">
            @foreach ($options as $option)
                @php
                    $optionValue = data_get($option, 'value');
                    $optionLabel = data_get($option, 'label', $optionValue);
                    $isSelected = (string) $optionValue === (string) $value;
                    $optionDisabled = (bool) data_get($option, 'disabled', false);
                @endphp
                <button
                    type="button"
                    @class([
                        'ui-dropdown-option',
                        'ui-dropdown-option-selected' => $isSelected,
                        'ui-dropdown-option-disabled' => $optionDisabled,
                    ])
                    role="option"
                    aria-selected="{{ $isSelected ? 'true' : 'false' }}"
                    @disabled($optionDisabled)
                    title="{{ $optionLabel }}"
                    data-ui-dropdown-option
                    data-ui-dropdown-value="{{ $optionValue }}"
                    data-ui-dropdown-option-value="{{ $optionValue }}"
                    data-ui-dropdown-option-label="{{ $optionLabel }}"
                >
                    <span class="ui-dropdown-option-label">{{ $optionLabel }}</span>
                    <x-heroicon-o-check class="ui-dropdown-option-check" aria-hidden="true" />
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
