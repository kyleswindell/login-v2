@props([
    'id' => null,
    'name' => null,
    'label',
    'type' => 'text',
    'variant' => 'text',
    'style' => 'default',
    'size' => 'md',
    'value' => '',
    'placeholder' => null,
    'helper' => null,
    'error' => null,
    'warning' => null,
    'disabled' => false,
    'readonly' => false,
    'required' => false,
    'optional' => false,
    'skeleton' => false,
    'rows' => 4,
    'maxlength' => null,
    'maxwords' => null,
    'counter' => null,
    'resize' => true,
    'passwordVisible' => false,
    'autocomplete' => null,
])

@php
    $fieldId = $id ?? 'text-input-'.Str::uuid();
    $fieldName = $name ?? Str::slug($label, '_');
    $kind = $variant === 'textarea' || $type === 'textarea' ? 'textarea' : ($type === 'password' || $variant === 'password' ? 'password' : 'text');
    $inputType = $kind === 'password' ? ($passwordVisible ? 'text' : 'password') : ($kind === 'text' ? $type : null);
    $resolvedStyle = in_array($style, ['default', 'fluid'], true) ? $style : 'default';
    $resolvedSize = in_array($size, ['sm', 'md', 'lg'], true) ? $size : 'md';
    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN) || filter_var($skeleton, FILTER_VALIDATE_BOOLEAN);
    $isReadonly = filter_var($readonly, FILTER_VALIDATE_BOOLEAN);
    $isRequired = filter_var($required, FILTER_VALIDATE_BOOLEAN);
    $isOptional = filter_var($optional, FILTER_VALIDATE_BOOLEAN);
    $isSkeleton = filter_var($skeleton, FILTER_VALIDATE_BOOLEAN);
    $hasError = filled($error);
    $hasWarning = ! $hasError && filled($warning);
    $message = $hasError ? $error : ($hasWarning ? $warning : $helper);
    $messageId = $message || $isSkeleton ? $fieldId.'-message' : null;
    $counterId = ($counter || $maxlength || $maxwords) && $kind === 'textarea' ? $fieldId.'-counter' : null;
    $describedBy = collect([$messageId, $counterId])->filter()->implode(' ');
    $textValue = (string) $value;
    $characterCount = mb_strlen($textValue);
    $wordCount = str_word_count(strip_tags($textValue));
    $counterMode = $counter ?? ($maxlength ? 'characters' : ($maxwords ? 'words' : null));
@endphp

<div
    {{ $attributes->class([
        'ui-text-input-component',
        'ui-text-input-kind-'.$kind,
        'ui-text-input-style-'.$resolvedStyle,
        'ui-text-input-size-'.$resolvedSize,
        'ui-text-input-invalid' => $hasError,
        'ui-text-input-warning' => $hasWarning,
        'ui-text-input-disabled' => $isDisabled,
        'ui-text-input-readonly' => $isReadonly,
        'ui-text-input-skeleton' => $isSkeleton,
    ]) }}
    data-ui-component="text-input"
    data-ui-text-input
    data-ui-text-input-kind="{{ $kind }}"
    data-ui-text-input-style="{{ $resolvedStyle }}"
    data-ui-text-input-size="{{ $resolvedSize }}"
    @if($isSkeleton) aria-busy="true" @endif
>
    @if ($resolvedStyle === 'default')
        <label class="ui-field-label" for="{{ $fieldId }}">
            {{ $label }}@if($isOptional) <span class="ui-field-label-indicator">(optional)</span>@elseif($isRequired) <span class="ui-field-label-indicator">(required)</span>@endif
        </label>
    @endif

    <div class="ui-text-input-shell">
        @if ($resolvedStyle === 'fluid')
            <label class="ui-field-label ui-text-input-fluid-label" for="{{ $fieldId }}">
                {{ $label }}@if($isOptional) <span class="ui-field-label-indicator">(optional)</span>@elseif($isRequired) <span class="ui-field-label-indicator">(required)</span>@endif
            </label>
        @endif

        @if ($kind === 'textarea')
            <textarea
                id="{{ $fieldId }}"
                name="{{ $fieldName }}"
                class="ui-text-input-control ui-textarea"
                rows="{{ $rows }}"
                @if($placeholder) placeholder="{{ $placeholder }}" @endif
                @if($maxlength) maxlength="{{ $maxlength }}" @endif
                @if($describedBy) aria-describedby="{{ $describedBy }}" @endif
                @if($hasError) aria-invalid="true" @endif
                @if($hasWarning) data-ui-field-warning="true" @endif
                @if(! $resize) data-ui-textarea-resize="none" @endif
                @readonly($isReadonly)
                @disabled($isDisabled)
                data-ui-text-input-control
            >{{ $textValue }}</textarea>
        @else
            <input
                id="{{ $fieldId }}"
                name="{{ $fieldName }}"
                class="ui-text-input-control"
                type="{{ $inputType }}"
                value="{{ $textValue }}"
                @if($placeholder) placeholder="{{ $placeholder }}" @endif
                @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
                @if($describedBy) aria-describedby="{{ $describedBy }}" @endif
                @if($hasError) aria-invalid="true" @endif
                @if($hasWarning) data-ui-field-warning="true" @endif
                @readonly($isReadonly)
                @disabled($isDisabled)
                data-ui-text-input-control
            >
        @endif

        @if ($hasError)
            <x-heroicon-o-x-circle class="ui-text-input-status-icon ui-text-input-status-icon-error" aria-hidden="true" />
        @elseif ($hasWarning)
            <x-heroicon-o-exclamation-triangle class="ui-text-input-status-icon ui-text-input-status-icon-warning" aria-hidden="true" />
        @endif

        @if ($kind === 'password' && ! $isSkeleton)
            <button
                type="button"
                class="ui-text-input-password-toggle"
                aria-label="{{ $passwordVisible ? 'Hide password' : 'Show password' }}"
                aria-pressed="{{ $passwordVisible ? 'true' : 'false' }}"
                @disabled($isDisabled || $isReadonly)
                data-ui-password-toggle
            >
                <x-heroicon-o-eye class="ui-text-input-password-icon ui-text-input-password-icon-show" aria-hidden="true" />
                <x-heroicon-o-eye-slash class="ui-text-input-password-icon ui-text-input-password-icon-hide" aria-hidden="true" />
            </button>
        @endif
    </div>

    @if ($messageId)
        <p
            id="{{ $messageId }}"
            @class([
                'ui-field-error' => $hasError,
                'ui-field-warning' => $hasWarning,
                'ui-field-helper' => ! $hasError && ! $hasWarning,
                'ui-text-input-fluid-helper' => $resolvedStyle === 'fluid' && ! $hasError && ! $hasWarning,
            ])
            @if($resolvedStyle === 'fluid' && ! $hasError && ! $hasWarning) role="tooltip" @endif
        >
            {{ $isSkeleton ? 'Loading field.' : $message }}
        </p>
    @endif

    @if ($counterId)
        <p id="{{ $counterId }}" class="ui-text-input-counter" data-ui-textarea-counter="{{ $counterMode }}">
            @if ($counterMode === 'words')
                {{ $wordCount }}{{ $maxwords ? ' / '.$maxwords : '' }} words
            @else
                {{ $characterCount }}{{ $maxlength ? ' / '.$maxlength : '' }} characters
            @endif
        </p>
    @endif
</div>
