@props([
    'name',
    'legend' => null,
    'options' => [],
    'selected' => [],
    'orientation' => 'vertical',
    'helper' => null,
    'error' => null,
    'warning' => null,
    'disabled' => false,
    'readonly' => false,
    'required' => false,
    'nested' => false,
])

@php
    $groupId = str($name)->slug('-')->toString();
    $isHorizontal = $orientation === 'horizontal';
    $selectedValues = collect($selected)->map(fn ($value) => (string) $value)->all();
@endphp

<fieldset
    {{ $attributes->class([
        'ui-checkbox-group',
        'ui-checkbox-group-horizontal' => $isHorizontal,
        'ui-checkbox-group-vertical' => ! $isHorizontal,
        'ui-checkbox-invalid' => (bool) $error,
        'ui-checkbox-warning-state' => (bool) $warning && ! $error,
    ]) }}
    data-ui-checkbox-group
    @if($disabled) disabled @endif
>
    @if($legend)
        <legend class="ui-checkbox-group-legend">{{ $legend }}</legend>
    @endif

    @if($helper)
        <p id="{{ $groupId }}-helper" class="ui-checkbox-group-helper">{{ $helper }}</p>
    @endif

    <div class="ui-checkbox-group-options">
        @foreach($options as $index => $option)
            @php
                $optionValue = (string) data_get($option, 'value', $index);
                $optionName = str_ends_with($name, '[]') ? $name : $name.'[]';
            @endphp
            <x-ui.checkbox
                :name="$optionName"
                :id="data_get($option, 'id', $groupId.'-'.$index)"
                :value="$optionValue"
                :label="data_get($option, 'label', $optionValue)"
                :checked="in_array($optionValue, $selectedValues, true) || (bool) data_get($option, 'checked', false)"
                :indeterminate="(bool) data_get($option, 'indeterminate', false)"
                :disabled="$disabled || (bool) data_get($option, 'disabled', false)"
                :readonly="$readonly || (bool) data_get($option, 'readonly', false)"
                :required="$required && $index === 0"
                :helper="data_get($option, 'helper')"
                :error="data_get($option, 'error')"
                :warning="data_get($option, 'warning')"
                @class(['ui-checkbox-nested' => $nested || (bool) data_get($option, 'nested', false)])
            />
        @endforeach
    </div>

    @if($error)
        <p class="ui-checkbox-error">{{ $error }}</p>
    @elseif($warning)
        <p class="ui-checkbox-warning">{{ $warning }}</p>
    @endif
</fieldset>
