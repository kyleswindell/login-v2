@props([
    'id' => null,
    'name',
    'labelText' => null,
    'label' => null,
    'value' => null,
    'defaultValue' => null,
    'placeholder' => 'mm/dd/yyyy',
    'helperText' => null,
    'helper' => null,
    'size' => 'md',
    'style' => 'default',
    'disabled' => false,
    'readOnly' => false,
    'readonly' => false,
    'hideLabel' => false,
    'invalid' => false,
    'invalidText' => null,
    'warn' => false,
    'warnText' => null,
    'pattern' => null,
    'type' => 'text',
    'required' => false,
    'calendar' => false,
    'role' => null,
])

@php
    $fieldId = $id ?? str($name)->slug('-')->toString();
    $labelText = $labelText ?? $label ?? 'Date';
    $value = $value ?? $defaultValue;
    $helperText = $helperText ?? $helper;
    $size = in_array($size, ['sm', 'md', 'lg'], true) ? $size : 'md';
    $style = $style === 'fluid' ? 'fluid' : 'default';
    $isReadOnly = (bool) ($readOnly || $readonly);
    $isInvalid = (bool) $invalid && filled($invalidText);
    $isWarning = ! $isInvalid && (bool) $warn && filled($warnText);
    $helperId = $helperText && ! $isInvalid && ! $isWarning ? $fieldId.'-helper' : null;
    $statusId = $isInvalid || $isWarning ? $fieldId.'-status' : null;
    $describedBy = trim(collect([$helperId, $statusId])->filter()->implode(' '));
@endphp

<div
    {{ $attributes->class([
        'ui-field',
        'ui-date-picker-input-field',
        'ui-date-picker-input-'.$size,
        'ui-date-picker-input-'.$style,
        'ui-date-picker-input-invalid' => $isInvalid,
        'ui-date-picker-input-warning' => $isWarning,
        'ui-date-picker-input-disabled' => $disabled,
        'ui-date-picker-input-readonly' => $isReadOnly,
    ]) }}
    data-ui-date-picker-field
    data-ui-date-picker-size="{{ $size }}"
    data-ui-date-picker-style="{{ $style }}"
    @if($role) data-ui-date-picker-input-role="{{ $role }}" @endif
>
    <label id="{{ $fieldId }}-label" for="{{ $fieldId }}" @class(['ui-field-label', 'sr-only' => $hideLabel])>
        {{ $labelText }}
        @if ($required)
            <span class="ui-field-required" aria-hidden="true">*</span>
        @endif
    </label>

    <div class="ui-date-picker-control">
        @if($style === 'fluid' && ! $hideLabel)
            <span class="ui-field-label ui-date-picker-fluid-label" aria-hidden="true">
                {{ $labelText }}
                @if ($required)
                    <span class="ui-field-required" aria-hidden="true">*</span>
                @endif
            </span>
        @endif

        <input
            id="{{ $fieldId }}"
            name="{{ $name }}"
            type="{{ $type }}"
            value="{{ $value }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($pattern) pattern="{{ $pattern }}" @endif
            @required($required)
            @disabled($disabled)
            @readonly($isReadOnly)
            @if($isInvalid) aria-invalid="true" @endif
            @if($isWarning) data-ui-field-warning="true" @endif
            @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
            class="ui-input ui-input-date"
            data-ui-date-picker-input
        >

        @if ($calendar)
            <x-heroicon-o-calendar-days class="ui-date-picker-calendar-icon" aria-hidden="true" />
        @endif

        @if ($isInvalid)
            <x-heroicon-o-x-circle class="ui-date-picker-status-icon ui-date-picker-status-icon-error" aria-hidden="true" />
        @elseif ($isWarning)
            <x-heroicon-o-exclamation-triangle class="ui-date-picker-status-icon ui-date-picker-status-icon-warning" aria-hidden="true" />
        @endif
    </div>

    @if ($helperText && ! $isInvalid && ! $isWarning)
        <p id="{{ $helperId }}" class="ui-field-helper">{{ $helperText }}</p>
    @endif

    @if ($isInvalid)
        <p id="{{ $statusId }}" class="ui-field-error">{{ $invalidText }}</p>
    @elseif ($isWarning)
        <p id="{{ $statusId }}" class="ui-field-warning">{{ $warnText }}</p>
    @endif
</div>
