@props([
    'name',
    'id' => null,
    'label',
    'checked' => false,
    'disabled' => false,
    'readonly' => false,
    'helper' => null,
])

@php
    $toggleId = $id ?? str($name)->slug('-')->toString();
@endphp

<label class="ui-switch" for="{{ $toggleId }}" data-ui-component="toggle">
    <input
        id="{{ $toggleId }}"
        name="{{ $name }}"
        type="checkbox"
        value="1"
        class="ui-switch-input"
        @checked($checked)
        @disabled($disabled)
        @if($readonly) aria-readonly="true" onclick="return false;" @endif
        data-ui-toggle
    >
    <span class="ui-switch-track" aria-hidden="true"></span>
    <span class="ui-switch-thumb" aria-hidden="true"></span>
    <span class="ui-control-label">{{ $label }}</span>
    @if ($helper)
        <span class="ui-control-copy">{{ $helper }}</span>
    @endif
</label>
