@props([
    'name',
    'id' => null,
    'value' => '1',
    'label',
    'checked' => false,
    'indeterminate' => false,
    'disabled' => false,
    'readonly' => false,
    'required' => false,
    'helper' => null,
    'error' => null,
    'warning' => null,
    'description' => null,
])

@php
    $checkboxId = $id ?? str($name.'-'.$value)->slug('-')->toString();
    $helperId = $helper || $description ? $checkboxId.'-helper' : null;
    $statusId = $error || $warning ? $checkboxId.'-status' : null;
    $describedBy = trim(collect([$helperId, $statusId])->filter()->implode(' '));
@endphp

<div
    {{ $attributes->class([
        'ui-checkbox',
        'ui-checkbox-indeterminate' => $indeterminate,
        'ui-checkbox-disabled' => $disabled,
        'ui-checkbox-readonly' => $readonly,
        'ui-checkbox-invalid' => (bool) $error,
        'ui-checkbox-warning-state' => (bool) $warning && ! $error,
    ]) }}
    data-ui-checkbox
    data-ui-checkbox-root
    @if($readonly) data-ui-checkbox-readonly @endif
    @if($indeterminate) data-ui-checkbox-indeterminate="true" @endif
>
    <label class="ui-checkbox-control" for="{{ $checkboxId }}">
        <input
            id="{{ $checkboxId }}"
            class="ui-checkbox-input"
            type="checkbox"
            name="{{ $name }}"
            value="{{ $value }}"
            @checked($checked)
            @disabled($disabled)
            @required($required)
            data-ui-checkbox-input
            @if($readonly) aria-readonly="true" onclick="return false;" @endif
            @if($indeterminate) aria-checked="mixed" @endif
            @if($error) aria-invalid="true" @endif
            @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
        >
        <span class="ui-checkbox-box" aria-hidden="true"></span>
        <span class="ui-checkbox-label">{{ $label }}</span>
    </label>

    @if($helper || $description)
        <p id="{{ $helperId }}" class="ui-checkbox-helper">{{ $helper ?? $description }}</p>
    @endif

    @if($error)
        <p id="{{ $statusId }}" class="ui-checkbox-error">
            <x-heroicon-o-x-circle class="ui-checkbox-status-icon" aria-hidden="true" />
            <span>{{ $error }}</span>
        </p>
    @elseif($warning)
        <p id="{{ $statusId }}" class="ui-checkbox-warning">
            <x-heroicon-o-exclamation-triangle class="ui-checkbox-status-icon" aria-hidden="true" />
            <span>{{ $warning }}</span>
        </p>
    @endif
</div>
