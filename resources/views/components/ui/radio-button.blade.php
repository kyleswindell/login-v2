@props([
    'name',
    'id' => null,
    'value',
    'label',
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

<div class="ui-checkbox" data-ui-component="radio-button">
    <label class="ui-checkbox-control" for="{{ $radioId }}">
        <input
            id="{{ $radioId }}"
            type="radio"
            name="{{ $name }}"
            value="{{ $value }}"
            class="sr-only peer"
            @checked($checked)
            @disabled($disabled)
            @required($required)
            @if($readonly) aria-readonly="true" onclick="return false;" @endif
            @if($error) aria-invalid="true" @endif
            @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
            data-ui-radio-button
        >
        <span class="h-4 w-4 rounded-full border transition peer-checked:border-[color:var(--ui-border-interactive)] peer-checked:bg-[color:var(--ui-border-interactive)] peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-[color:var(--ui-focus)]" style="border-color: var(--ui-border-strong-01);" aria-hidden="true"></span>
        <span class="ui-checkbox-label">{{ $label }}</span>
    </label>
    @if ($helper)
        <p id="{{ $helperId }}" class="ui-checkbox-helper">{{ $helper }}</p>
    @endif
    @if ($error)
        <p id="{{ $statusId }}" class="ui-checkbox-error">{{ $error }}</p>
    @elseif ($warning)
        <p id="{{ $statusId }}" class="ui-checkbox-warning">{{ $warning }}</p>
    @endif
</div>
