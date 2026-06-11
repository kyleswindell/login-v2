@props([
    'nameMin' => 'min',
    'nameMax' => 'max',
    'id' => null,
    'label',
    'min' => 0,
    'max' => 100,
    'step' => 1,
    'valueMin' => null,
    'valueMax' => null,
    'unit' => null,
    'helper' => null,
    'error' => null,
    'warning' => null,
    'disabled' => false,
    'readonly' => false,
    'showInputs' => false,
    'showEndpoints' => true,
])

@php
    $fieldId = $id ?? str($nameMin.'-'.$nameMax)->slug('-')->toString();
    $currentMin = $valueMin ?? $min;
    $currentMax = $valueMax ?? $max;
    $helperId = $helper ? $fieldId.'-helper' : null;
    $statusId = $error || $warning ? $fieldId.'-status' : null;
    $describedBy = trim(collect([$helperId, $statusId])->filter()->implode(' '));
@endphp

<div class="ui-field ui-slider ui-range-slider" data-ui-component="range-slider" data-ui-slider data-ui-range-slider>
    <div class="ui-slider-header">
        <span class="ui-field-label">{{ $label }}</span>
        <output class="ui-slider-value" data-ui-slider-value>{{ $currentMin }}{{ $unit }} - {{ $currentMax }}{{ $unit }}</output>
    </div>
    <div class="ui-slider-control">
        @if ($showEndpoints)
            <span class="ui-slider-endpoint">{{ $min }}</span>
        @endif
        <span class="ui-slider-track ui-range-slider-track">
            <input
                id="{{ $fieldId }}-min"
                name="{{ $nameMin }}"
                type="range"
                class="ui-slider-input"
                min="{{ $min }}"
                max="{{ $max }}"
                step="{{ $step }}"
                value="{{ $currentMin }}"
                @disabled($disabled || $readonly)
                @if($readonly) aria-readonly="true" @endif
                @if($error) aria-invalid="true" @endif
                @if($warning && ! $error) data-ui-field-warning="true" @endif
                @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
                data-ui-slider-input
                data-ui-range-slider-min
            >
            <input
                id="{{ $fieldId }}-max"
                name="{{ $nameMax }}"
                type="range"
                class="ui-slider-input"
                min="{{ $min }}"
                max="{{ $max }}"
                step="{{ $step }}"
                value="{{ $currentMax }}"
                @disabled($disabled || $readonly)
                @if($readonly) aria-readonly="true" @endif
                @if($error) aria-invalid="true" @endif
                @if($warning && ! $error) data-ui-field-warning="true" @endif
                @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
                data-ui-slider-input
                data-ui-range-slider-max
            >
            <span class="ui-slider-thumb" aria-hidden="true" data-ui-slider-thumb></span>
        </span>
        @if ($showEndpoints)
            <span class="ui-slider-endpoint">{{ $max }}</span>
        @endif
    </div>
    @if ($showInputs)
        <div class="ui-range-slider-inputs">
            <input type="number" class="ui-input ui-slider-number" min="{{ $min }}" max="{{ $max }}" step="{{ $step }}" value="{{ $currentMin }}" @disabled($disabled || $readonly) data-ui-slider-number data-ui-range-slider-number-min>
            <input type="number" class="ui-input ui-slider-number" min="{{ $min }}" max="{{ $max }}" step="{{ $step }}" value="{{ $currentMax }}" @disabled($disabled || $readonly) data-ui-slider-number data-ui-range-slider-number-max>
        </div>
    @endif
    <span class="sr-only" data-ui-slider-state>{{ $label }} range is {{ $currentMin }}{{ $unit }} to {{ $currentMax }}{{ $unit }}</span>
    @if ($helper)
        <p id="{{ $helperId }}" class="ui-field-helper">{{ $helper }}</p>
    @endif
    @if ($error)
        <p id="{{ $statusId }}" class="ui-field-error">{{ $error }}</p>
    @elseif ($warning)
        <p id="{{ $statusId }}" class="ui-field-warning">{{ $warning }}</p>
    @endif
</div>
