@props([
    'name',
    'id' => null,
    'label',
    'options' => [],
    'value' => null,
    'defaultValue' => null,
    'placeholder' => null,
    'helper' => null,
    'helperText' => null,
    'error' => null,
    'invalid' => false,
    'invalidText' => null,
    'warning' => null,
    'warn' => false,
    'warnText' => null,
    'size' => 'md',
    'variant' => 'default',
    'style' => 'default',
    'disabled' => false,
    'readonly' => false,
    'readOnly' => false,
    'required' => false,
    'skeleton' => false,
])

@php
    $fieldId = $id ?? str($name)->slug('-')->toString();
    $selectedValue = $value ?? $defaultValue;
    $helper = $helper ?? $helperText;
    $error = $error ?? ($invalid ? $invalidText : null);
    $warning = $warning ?? ($warn ? $warnText : null);
    $size = in_array($size, ['sm', 'md', 'lg'], true) ? $size : 'md';
    $variant = $variant === 'inline' ? 'inline' : 'default';
    $fieldStyle = $style === 'fluid' || $variant === 'fluid' ? 'fluid' : 'default';
    $isInvalid = filled($error);
    $isWarning = ! $isInvalid && filled($warning);
    $isReadOnly = (bool) ($readonly || $readOnly);
    $isDisabled = (bool) ($disabled || $skeleton);
    $helperId = $helper && ! $isInvalid && ! $isWarning ? $fieldId.'-helper' : null;
    $statusId = $isInvalid || $isWarning || $skeleton ? $fieldId.'-status' : null;
    $describedBy = trim(collect([$helperId, $statusId])->filter()->implode(' '));

    $flattenedOptions = collect($options)->flatMap(function ($option) {
        $children = data_get($option, 'options');

        if (is_iterable($children)) {
            return collect($children);
        }

        return [$option];
    });

    $selectedOption = $flattenedOptions->first(fn ($option) => (string) data_get($option, 'value') === (string) $selectedValue);
    $selectedLabel = data_get($selectedOption, 'label', $selectedValue);
@endphp

<div
    {{ $attributes->class([
        'ui-field',
        'ui-select-field',
        'ui-select-field-'.$fieldStyle,
        'ui-select-field-inline' => $variant === 'inline',
        'ui-select-field-'.$size,
        'ui-select-field-invalid' => $isInvalid,
        'ui-select-field-warning' => $isWarning,
        'ui-select-field-disabled' => $isDisabled,
        'ui-select-field-readonly' => $isReadOnly,
        'ui-select-field-skeleton' => $skeleton,
    ]) }}
    data-ui-component="select"
    data-ui-select-field
    data-ui-select-size="{{ $size }}"
    data-ui-select-variant="{{ $variant }}"
    data-ui-select-style="{{ $fieldStyle }}"
    @if($skeleton) aria-busy="true" @endif
>
    @if ($fieldStyle !== 'fluid')
        <label id="{{ $fieldId }}-label" for="{{ $isReadOnly ? $fieldId.'-value' : $fieldId }}" class="ui-field-label">{{ $label }}</label>
    @endif

    @if ($isReadOnly)
        <input type="hidden" name="{{ $name }}" value="{{ $selectedValue }}">
        <div class="ui-select-readonly-value" id="{{ $fieldId }}-value" aria-labelledby="{{ $fieldId }}-label" @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif data-ui-select-readonly>
            @if ($fieldStyle === 'fluid')
                <span id="{{ $fieldId }}-label" class="ui-field-label ui-select-fluid-label">{{ $label }}</span>
            @endif
            <span class="ui-select-readonly-text">{{ filled($selectedLabel) ? $selectedLabel : ($placeholder ?? 'No selection') }}</span>
        </div>
    @else
        <div class="ui-select-shell">
            @if ($fieldStyle === 'fluid')
                <label id="{{ $fieldId }}-label" for="{{ $fieldId }}" class="ui-field-label ui-select-fluid-label">{{ $label }}</label>
            @endif
            <select
                id="{{ $fieldId }}"
                name="{{ $name }}"
                class="ui-select"
                @required($required)
                @disabled($isDisabled)
                @if($isInvalid) aria-invalid="true" @endif
                @if($isWarning) data-ui-field-warning="true" @endif
                @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
                data-ui-select
            >
                @if($placeholder)
                    <option value="" @selected(blank($selectedValue)) @disabled($required)>{{ $placeholder }}</option>
                @endif
                @foreach($options as $option)
                    @php
                        $groupOptions = data_get($option, 'options');
                        $groupLabel = data_get($option, 'label', data_get($option, 'group'));
                    @endphp
                    @if (is_iterable($groupOptions))
                        <optgroup label="{{ $groupLabel }}">
                            @foreach($groupOptions as $groupOption)
                                @php $optionValue = data_get($groupOption, 'value'); @endphp
                                <option value="{{ $optionValue }}" @selected((string) $optionValue === (string) $selectedValue) @disabled((bool) data_get($groupOption, 'disabled', false))>
                                    {{ data_get($groupOption, 'label', $optionValue) }}
                                </option>
                            @endforeach
                        </optgroup>
                    @else
                        @php $optionValue = data_get($option, 'value'); @endphp
                        <option value="{{ $optionValue }}" @selected((string) $optionValue === (string) $selectedValue) @disabled((bool) data_get($option, 'disabled', false))>
                            {{ data_get($option, 'label', $optionValue) }}
                        </option>
                    @endif
                @endforeach
            </select>
            @if ($isInvalid)
                <x-heroicon-o-x-circle class="ui-select-status-icon ui-select-status-icon-error" aria-hidden="true" />
            @elseif ($isWarning)
                <x-heroicon-o-exclamation-triangle class="ui-select-status-icon ui-select-status-icon-warning" aria-hidden="true" />
            @endif
        </div>
    @endif

    @if ($helper && ! $isInvalid && ! $isWarning)
        <p id="{{ $helperId }}" class="ui-field-helper">{{ $helper }}</p>
    @endif
    @if ($isInvalid)
        <p id="{{ $statusId }}" class="ui-field-error">{{ $error }}</p>
    @elseif ($isWarning)
        <p id="{{ $statusId }}" class="ui-field-warning">{{ $warning }}</p>
    @elseif ($skeleton)
        <p id="{{ $statusId }}" class="ui-field-helper">Options loading.</p>
    @endif
</div>
