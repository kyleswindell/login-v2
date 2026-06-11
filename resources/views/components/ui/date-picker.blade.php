@props([
    'name',
    'id' => null,
    'label',
    'value' => null,
    'type' => 'date',
    'min' => null,
    'max' => null,
    'step' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'helper' => null,
    'error' => null,
    'warning' => null,
    'autocomplete' => null,
])

@php
    $resolvedType = in_array($type, ['date', 'datetime-local'], true) ? $type : 'date';
    $fieldId = $id ?? str($name)->slug('-')->toString();
    $helperId = $helper ? $fieldId.'-helper' : null;
    $statusId = $error || $warning ? $fieldId.'-status' : null;
    $describedBy = trim(collect([$helperId, $statusId])->filter()->implode(' '));
    $statusIcon = $error ? 'x-circle' : ($warning ? 'exclamation-triangle' : null);
@endphp

<div
    class="ui-field ui-date-picker"
    data-ui-component="date-picker"
    data-ui-date-picker
    data-ui-date-picker-type="{{ $resolvedType }}"
>
    <label for="{{ $fieldId }}" class="ui-field-label">
        {{ $label }}
        @if ($required)
            <span class="ui-field-required" aria-hidden="true">*</span>
        @endif
    </label>

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
            @required($required)
            @disabled($disabled)
            @readonly($readonly)
            @if($error) aria-invalid="true" @endif
            @if($warning && ! $error) data-ui-field-warning="true" @endif
            @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
            {{ $attributes->class(['ui-input', 'ui-input-date']) }}
        >

        @if ($statusIcon)
            <span @class(['ui-date-picker-status-icon', 'ui-date-picker-status-icon-error' => (bool) $error, 'ui-date-picker-status-icon-warning' => ! $error && (bool) $warning])>
                <x-ui.status-icon :icon="$statusIcon" class="h-4 w-4" />
            </span>
        @endif
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
