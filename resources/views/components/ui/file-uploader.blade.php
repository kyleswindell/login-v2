@props([
    'name',
    'id' => null,
    'label',
    'helper' => null,
    'error' => null,
    'warning' => null,
    'accept' => null,
    'multiple' => false,
    'disabled' => false,
    'required' => false,
])

@php
    $fieldId = $id ?? str($name)->slug('-')->toString();
    $helperId = $helper ? $fieldId.'-helper' : null;
    $statusId = $error || $warning ? $fieldId.'-status' : null;
    $describedBy = trim(collect([$helperId, $statusId])->filter()->implode(' '));
@endphp

<div class="ui-field" data-ui-component="file-uploader">
    <label for="{{ $fieldId }}" class="ui-field-label">{{ $label }}</label>
    <input
        id="{{ $fieldId }}"
        name="{{ $name }}"
        type="file"
        class="ui-input mt-2"
        @if($accept) accept="{{ $accept }}" @endif
        @if($multiple) multiple @endif
        @required($required)
        @disabled($disabled)
        @if($error) aria-invalid="true" @endif
        @if($warning && ! $error) data-ui-field-warning="true" @endif
        @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
        data-ui-file-uploader
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
