@props([
    'name',
    'id' => null,
    'label',
    'options' => [],
    'value' => null,
    'placeholder' => null,
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

<div class="ui-field" data-ui-component="select">
    <label for="{{ $fieldId }}" class="ui-field-label">{{ $label }}</label>
    <select
        id="{{ $fieldId }}"
        name="{{ $name }}"
        class="ui-select mt-2"
        @required($required)
        @disabled($disabled || $readonly)
        @if($readonly) aria-readonly="true" @endif
        @if($error) aria-invalid="true" @endif
        @if($warning && ! $error) data-ui-field-warning="true" @endif
        @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
        data-ui-select
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach($options as $option)
            @php $optionValue = data_get($option, 'value'); @endphp
            <option value="{{ $optionValue }}" @selected((string) $optionValue === (string) $value)>
                {{ data_get($option, 'label', $optionValue) }}
            </option>
        @endforeach
    </select>
    @if ($helper)
        <p id="{{ $helperId }}" class="ui-field-helper">{{ $helper }}</p>
    @endif
    @if ($error)
        <p id="{{ $statusId }}" class="ui-field-error">{{ $error }}</p>
    @elseif ($warning)
        <p id="{{ $statusId }}" class="ui-field-warning">{{ $warning }}</p>
    @endif
</div>
