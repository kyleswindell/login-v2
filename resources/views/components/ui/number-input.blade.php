@props([
    'name',
    'id' => null,
    'label',
    'value' => null,
    'min' => null,
    'max' => null,
    'step' => null,
    'helper' => null,
    'error' => null,
    'warning' => null,
    'disabled' => false,
    'readonly' => false,
    'required' => false,
])

@php
    $fieldId = $id ?? str($name)->slug('-')->toString();
    $helperId = $helper ? $fieldId.'-helper' : null;
    $statusId = $error || $warning ? $fieldId.'-status' : null;
    $describedBy = trim(collect([$helperId, $statusId])->filter()->implode(' '));
@endphp

<div class="ui-field" data-ui-component="number-input">
    <label for="{{ $fieldId }}" class="ui-field-label">{{ $label }}</label>
    <input
        id="{{ $fieldId }}"
        name="{{ $name }}"
        type="number"
        value="{{ $value }}"
        @if($min !== null) min="{{ $min }}" @endif
        @if($max !== null) max="{{ $max }}" @endif
        @if($step !== null) step="{{ $step }}" @endif
        @required($required)
        @disabled($disabled)
        @readonly($readonly)
        @if($error) aria-invalid="true" @endif
        @if($warning && ! $error) data-ui-field-warning="true" @endif
        @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
        {{ $attributes->class('ui-input mt-2') }}
    >
    @if ($helper)
        <p id="{{ $helperId }}" class="ui-field-helper">{{ $helper }}</p>
    @endif
    @if ($error)
        <p id="{{ $statusId }}" class="ui-field-error">{{ $error }}</p>
    @elseif ($warning)
        <p id="{{ $statusId }}" class="ui-field-warning">{{ $warning }}</p>
    @endif
</div>
