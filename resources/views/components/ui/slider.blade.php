@props([
    'name',
    'id' => null,
    'label',
    'min' => 0,
    'max' => 100,
    'step' => 1,
    'value' => null,
    'unit' => null,
    'helper' => null,
    'error' => null,
    'warning' => null,
    'disabled' => false,
    'readonly' => false,
    'showInput' => false,
    'showEndpoints' => true,
])

@php
    $fieldId = $id ?? str($name)->slug('-')->toString();
    $currentValue = $value ?? $min;
    $helperId = $helper ? $fieldId.'-helper' : null;
    $statusId = $error || $warning ? $fieldId.'-status' : null;
    $describedBy = trim(collect([$helperId, $statusId])->filter()->implode(' '));
@endphp

<div class="ui-field ui-slider" data-ui-component="slider" data-ui-slider>
    <div class="ui-slider-header">
        <label for="{{ $fieldId }}" class="ui-field-label">{{ $label }}</label>
        <output for="{{ $fieldId }}" class="ui-slider-value" data-ui-slider-value>{{ $currentValue }}{{ $unit }}</output>
    </div>
    <div class="ui-slider-control">
        @if ($showEndpoints)
            <span class="ui-slider-endpoint">{{ $min }}</span>
        @endif
        <span class="ui-slider-track">
            <input
                id="{{ $fieldId }}"
                name="{{ $name }}"
                type="range"
                class="ui-slider-input"
                min="{{ $min }}"
                max="{{ $max }}"
                step="{{ $step }}"
                value="{{ $currentValue }}"
                @disabled($disabled || $readonly)
                @if($readonly) aria-readonly="true" @endif
                @if($error) aria-invalid="true" @endif
                @if($warning && ! $error) data-ui-field-warning="true" @endif
                @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
                data-ui-slider-input
            >
            <span class="ui-slider-thumb" aria-hidden="true" data-ui-slider-thumb></span>
        </span>
        @if ($showEndpoints)
            <span class="ui-slider-endpoint">{{ $max }}</span>
        @endif
        @if ($showInput)
            <input
                type="number"
                class="ui-input ui-slider-number"
                min="{{ $min }}"
                max="{{ $max }}"
                step="{{ $step }}"
                value="{{ $currentValue }}"
                @disabled($disabled || $readonly)
                data-ui-slider-number
            >
        @endif
    </div>
    <span class="sr-only" data-ui-slider-state>{{ $label }} value is {{ $currentValue }}{{ $unit }}</span>
    @if ($helper)
        <p id="{{ $helperId }}" class="ui-field-helper">{{ $helper }}</p>
    @endif
    @if ($error)
        <p id="{{ $statusId }}" class="ui-field-error">{{ $error }}</p>
    @elseif ($warning)
        <p id="{{ $statusId }}" class="ui-field-warning">{{ $warning }}</p>
    @endif
</div>
