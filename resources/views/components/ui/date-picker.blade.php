@props([
    'name',
    'id' => null,
    'label',
    'value' => null,
    'defaultValue' => null,
    'type' => 'date',
    'min' => null,
    'minDate' => null,
    'max' => null,
    'maxDate' => null,
    'step' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'readOnly' => false,
    'helper' => null,
    'helperText' => null,
    'error' => null,
    'invalid' => false,
    'invalidText' => null,
    'warning' => null,
    'warn' => false,
    'warnText' => null,
    'autocomplete' => null,
    'placeholder' => null,
    'dateFormat' => null,
    'size' => 'md',
    'style' => 'default',
    'skeleton' => false,
])

@php
    $resolvedType = in_array($type, ['date', 'datetime-local'], true) ? $type : 'date';
    $fieldId = $id ?? str($name)->slug('-')->toString();
    $value = $value ?? $defaultValue;
    $min = $min ?? $minDate;
    $max = $max ?? $maxDate;
    $helper = $helper ?? $helperText;
    $error = $error ?? ($invalid ? $invalidText : null);
    $warning = $warning ?? ($warn ? $warnText : null);
    $size = in_array($size, ['sm', 'md', 'lg'], true) ? $size : 'md';
    $fieldStyle = $style === 'fluid' ? 'fluid' : 'default';
    $isInvalid = filled($error);
    $isWarning = ! $isInvalid && filled($warning);
    $isReadOnly = (bool) ($readonly || $readOnly);
    $isDisabled = (bool) ($disabled || $skeleton);
    $helperId = ($helper || $dateFormat) && ! $isInvalid && ! $isWarning ? $fieldId.'-helper' : null;
    $statusId = $isInvalid || $isWarning || $skeleton ? $fieldId.'-status' : null;
    $describedBy = trim(collect([$helperId, $statusId])->filter()->implode(' '));
    $helperCopy = $helper ?? ($dateFormat ? 'Format: '.$dateFormat.'.' : null);
@endphp

<div
    {{ $attributes->class([
        'ui-field',
        'ui-date-picker',
        'ui-date-picker-'.$size,
        'ui-date-picker-'.$fieldStyle,
        'ui-date-picker-invalid' => $isInvalid,
        'ui-date-picker-warning' => $isWarning,
        'ui-date-picker-disabled' => $isDisabled,
        'ui-date-picker-readonly' => $isReadOnly,
        'ui-date-picker-skeleton' => $skeleton,
    ]) }}
    data-ui-component="date-picker"
    data-ui-date-picker
    data-ui-date-picker-type="{{ $resolvedType }}"
    data-ui-date-picker-size="{{ $size }}"
    data-ui-date-picker-style="{{ $fieldStyle }}"
    @if($skeleton) aria-busy="true" @endif
>
    <label id="{{ $fieldId }}-label" for="{{ $isReadOnly ? $fieldId.'-value' : $fieldId }}" class="ui-field-label">
        {{ $label }}
        @if ($required)
            <span class="ui-field-required" aria-hidden="true">*</span>
        @endif
    </label>

    @if ($isReadOnly)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
        <div
            id="{{ $fieldId }}-value"
            class="ui-date-picker-readonly-value"
            aria-labelledby="{{ $fieldId }}-label"
            @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
            data-ui-date-picker-readonly
        >
            {{ filled($value) ? $value : 'No date set' }}
        </div>
    @else
        <div class="ui-date-picker-control">
            <input
                id="{{ $fieldId }}"
                name="{{ $name }}"
                type="{{ $resolvedType }}"
                value="{{ $value }}"
                @if($min) min="{{ $min }}" @endif
                @if($max) max="{{ $max }}" @endif
                @if($step) step="{{ $step }}" @endif
                @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
                @if($placeholder) placeholder="{{ $placeholder }}" @endif
                @required($required)
                @disabled($isDisabled)
                @if($isInvalid) aria-invalid="true" @endif
                @if($isWarning) data-ui-field-warning="true" @endif
                @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
                class="ui-input ui-input-date"
                data-ui-date-picker-input
            >

            @if ($isInvalid)
                <x-heroicon-o-x-circle class="ui-date-picker-status-icon ui-date-picker-status-icon-error" aria-hidden="true" />
            @elseif ($isWarning)
                <x-heroicon-o-exclamation-triangle class="ui-date-picker-status-icon ui-date-picker-status-icon-warning" aria-hidden="true" />
            @endif
        </div>
    @endif

    @if ($helperCopy && ! $isInvalid && ! $isWarning)
        <p id="{{ $helperId }}" class="ui-field-helper">{{ $helperCopy }}</p>
    @endif

    @if ($isInvalid)
        <p id="{{ $statusId }}" class="ui-field-error">{{ $error }}</p>
    @elseif ($isWarning)
        <p id="{{ $statusId }}" class="ui-field-warning">{{ $warning }}</p>
    @elseif ($skeleton)
        <p id="{{ $statusId }}" class="ui-field-helper">Date field loading.</p>
    @endif
</div>
