@props([
    'name',
    'label',
    'options' => [],
    'value' => null,
    'orientation' => 'vertical',
    'helper' => null,
    'error' => null,
    'warning' => null,
])

<fieldset
    class="ui-checkbox-group"
    data-ui-component="radio-group"
    data-ui-radio-group-orientation="{{ $orientation }}"
>
    <legend class="ui-checkbox-group-legend">{{ $label }}</legend>
    @if ($helper)
        <p class="ui-checkbox-group-helper">{{ $helper }}</p>
    @endif
    <div @class(['ui-checkbox-group-options', 'ui-checkbox-group-horizontal' => $orientation === 'horizontal'])>
        @foreach ($options as $option)
            <x-ui.radio-button
                :name="$name"
                :value="data_get($option, 'value')"
                :label="data_get($option, 'label')"
                :checked="(string) data_get($option, 'value') === (string) $value"
                :disabled="(bool) data_get($option, 'disabled', false)"
            />
        @endforeach
    </div>
    @if ($error)
        <p class="ui-checkbox-error">{{ $error }}</p>
    @elseif ($warning)
        <p class="ui-checkbox-warning">{{ $warning }}</p>
    @endif
</fieldset>
