@props([
    'name',
    'id' => null,
    'label' => null,
    'helperText' => null,
    'invalid' => false,
    'invalidText' => null,
    'warn' => false,
    'warnText' => null,
    'options' => [],
    'value' => null,
    'layout' => null,
    'orientation' => 'vertical',
    'helper' => null,
    'error' => null,
    'warning' => null,
    'disabled' => false,
    'readonly' => false,
    'required' => false,
])

@php
    $groupId = $id ?? str($name.'-radio-group')->slug('-')->toString();
    $resolvedLayout = $layout ?? $orientation;
    $resolvedLayout = in_array($resolvedLayout, ['vertical', 'horizontal'], true) ? $resolvedLayout : 'vertical';
    $resolvedHelper = $helperText ?? $helper;
    $resolvedError = $invalidText ?? $error;
    $resolvedWarning = $warnText ?? $warning;
    $isInvalid = (bool) $invalid || filled($resolvedError);
    $isWarning = ! $isInvalid && ((bool) $warn || filled($resolvedWarning));
    $helperId = filled($resolvedHelper) ? $groupId.'-helper' : null;
    $statusId = ($isInvalid || $isWarning) ? $groupId.'-status' : null;
    $describedBy = trim(collect([$helperId, $statusId])->filter()->implode(' '));
@endphp

<fieldset
    @class([
        'ui-radio-group',
        'ui-radio-group-horizontal' => $resolvedLayout === 'horizontal',
        'ui-radio-group-disabled' => $disabled,
        'ui-radio-group-readonly' => $readonly,
        'ui-radio-invalid' => $isInvalid,
        'ui-radio-warning-state' => $isWarning,
    ])
    data-ui-component="radio-group"
    data-ui-radio-group
    data-ui-radio-group-layout="{{ $resolvedLayout }}"
    @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
    @if($disabled) disabled @endif
    @if($readonly) data-ui-radio-readonly @endif
>
    @if ($label)
        <legend class="ui-radio-group-legend">{{ $label }}</legend>
    @endif
    @if ($resolvedHelper)
        <p id="{{ $helperId }}" class="ui-radio-group-helper">{{ $resolvedHelper }}</p>
    @endif
    <div class="ui-radio-group-options">
        @foreach ($options as $option)
            <x-ui.radio-button
                :name="$name"
                :value="data_get($option, 'value')"
                :label="data_get($option, 'label')"
                :description="data_get($option, 'description')"
                :checked="(string) data_get($option, 'value') === (string) $value"
                :disabled="$disabled || (bool) data_get($option, 'disabled', false)"
                :readonly="$readonly"
                :required="$required"
            />
        @endforeach
    </div>
    @if ($isInvalid)
        <p id="{{ $statusId }}" class="ui-radio-error">
            <x-ui.status-icon icon="x-circle" class="ui-radio-status-icon h-4 w-4 shrink-0" />
            <span>{{ $resolvedError }}</span>
        </p>
    @elseif ($isWarning)
        <p id="{{ $statusId }}" class="ui-radio-warning">
            <x-ui.status-icon icon="exclamation-triangle" class="ui-radio-status-icon h-4 w-4 shrink-0" />
            <span>{{ $resolvedWarning }}</span>
        </p>
    @endif
</fieldset>
