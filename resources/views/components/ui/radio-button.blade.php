@props([
    'name',
    'id' => null,
    'value',
    'label',
    'description' => null,
    'checked' => false,
    'disabled' => false,
    'readonly' => false,
    'required' => false,
    'helper' => null,
    'error' => null,
    'warning' => null,
])

@php
    $radioId = $id ?? str($name.'-'.$value)->slug('-')->toString();
    $helperId = $helper ? $radioId.'-helper' : null;
    $statusId = $error || $warning ? $radioId.'-status' : null;
    $describedBy = trim(collect([$helperId, $statusId])->filter()->implode(' '));
@endphp

<div
    @class([
        'ui-radio',
        'ui-radio-disabled' => $disabled,
        'ui-radio-readonly' => $readonly,
        'ui-radio-invalid' => (bool) $error,
        'ui-radio-warning-state' => (bool) $warning && ! $error,
    ])
    data-ui-component="radio-button"
    data-ui-radio
    data-ui-radio-root
    @if($readonly) data-ui-radio-readonly @endif
>
    <label class="ui-radio-control" for="{{ $radioId }}">
        <input
            id="{{ $radioId }}"
            type="radio"
            name="{{ $name }}"
            value="{{ $value }}"
            class="ui-radio-input"
            @checked($checked)
            @disabled($disabled)
            @required($required)
            @if($readonly) aria-readonly="true" onclick="return false;" onkeydown="return false;" @endif
            @if($error) aria-invalid="true" @endif
            @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
            data-ui-radio-button
            data-ui-radio-input
        >
        <span class="ui-radio-box" aria-hidden="true"></span>
        <span class="ui-radio-label">
            <span>{{ $label }}</span>
            @if ($description)
                <span class="ui-radio-option-description">{{ $description }}</span>
            @endif
        </span>
    </label>
    @if ($helper)
        <p id="{{ $helperId }}" class="ui-radio-helper">{{ $helper }}</p>
    @endif
    @if ($error)
        <p id="{{ $statusId }}" class="ui-radio-error">
            <x-ui.status-icon icon="x-circle" class="ui-radio-status-icon h-4 w-4 shrink-0" />
            <span>{{ $error }}</span>
        </p>
    @elseif ($warning)
        <p id="{{ $statusId }}" class="ui-radio-warning">
            <x-ui.status-icon icon="exclamation-triangle" class="ui-radio-status-icon h-4 w-4 shrink-0" />
            <span>{{ $warning }}</span>
        </p>
    @endif
</div>
