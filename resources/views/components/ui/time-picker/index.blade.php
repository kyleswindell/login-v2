{{-- ==========================================================================
    File: resources/views/components/ui/time-picker/index.blade.php
    Purpose: UI time picker input.

    Source: Converted from the Carbon TimePicker React component.

    Notes:
    - Renders the form item, label, time picker wrapper, input wrapper, input,
      optional status icon, child picker selects, and validation message.
    - Child controls such as AM/PM or timezone selects are passed through the
      default slot.
    - Uses the unified x-ui.icon component for default invalid/warning icons.
    - Slot-provided invalidIcon or warningIcon content may override default icons.
    - Time Picker styles are handled by resources/css/components/time-picker.css.
    ========================================================================== --}}

@props([
    'id' => null,
    'name' => null,
    'labelText' => null,
    'hideLabel' => false,
    'disabled' => false,
    'readOnly' => false,
    'required' => false,
    'invalid' => false,
    'invalidText' => 'Error message goes here',
    'warning' => false,
    'warningText' => 'Warning message goes here',
    'light' => false,
    'maxLength' => 5,
    'pattern' => '(1[012]|[1-9]):[0-5][0-9](\s)?',
    'placeholder' => 'hh:mm',
    'size' => 'md',
    'type' => 'text',
    'value' => null,
    'inputClassName' => null,
    'pickerClassName' => null,
])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedSizes = [
        'sm',
        'md',
        'lg',
    ];

    $allowedTypes = [
        'text',
        'time',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedId = $id ?? 'ui-time-picker-'.Str::uuid();

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : 'md';

    $resolvedType = in_array($type, $allowedTypes, true)
        ? $type
        : 'text';

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    |
    | Invalid state takes precedence over warning state. Disabled state suppresses
    | invalid and warning treatment.
    |
    */

    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $isReadOnly = filter_var($readOnly, FILTER_VALIDATE_BOOLEAN);
    $isRequired = filter_var($required, FILTER_VALIDATE_BOOLEAN);
    $isLight = filter_var($light, FILTER_VALIDATE_BOOLEAN);
    $isLabelHidden = filter_var($hideLabel, FILTER_VALIDATE_BOOLEAN);

    $isInvalid = ! $isDisabled && filter_var($invalid, FILTER_VALIDATE_BOOLEAN);
    $isWarning = ! $isDisabled && ! $isInvalid && filter_var($warning, FILTER_VALIDATE_BOOLEAN);

    $stateValue = $isInvalid ? 'invalid' : ($isWarning ? 'warning' : 'default');

    /*
    |--------------------------------------------------------------------------
    | Message IDs and ARIA Wiring
    |--------------------------------------------------------------------------
    */

    $validationId = $isInvalid
        ? $resolvedId.'-error-msg'
        : ($isWarning ? $resolvedId.'-warning-msg' : null);

    $existingDescribedBy = $attributes->get('aria-describedby');

    $describedBy = collect([
        $existingDescribedBy,
        $validationId,
    ])->filter()->implode(' ');

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $rootClasses = [
        'ui-form-item',
    ];

    $pickerClasses = [
        'ui-time-picker',
        'ui-time-picker--light' => $isLight,
        'ui-time-picker--invalid' => $isInvalid,
        'ui-time-picker--warning' => $isWarning,
        'ui-time-picker--readonly' => $isReadOnly,
        'ui-time-picker--'.$resolvedSize,
        $pickerClassName,
    ];

    $labelClasses = [
        'ui-label',
        'ui-visually-hidden' => $isLabelHidden,
        'ui-label--disabled' => $isDisabled,
    ];

    $inputClasses = [
        'ui-time-picker__input-field',
        'ui-text-input',
        'ui-text-input--light' => $isLight,
        'ui-time-picker__input-field-error' => $isInvalid || $isWarning,
        $inputClassName,
    ];

    $iconClasses = [
        'ui-time-picker__error__icon',
        'ui-time-picker__error__icon--invalid' => $isInvalid,
        'ui-time-picker__error__icon--warning' => $isWarning,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    |
    | Caller class is applied to the outer form item. Remaining attributes are
    | forwarded to the native input.
    |
    */

    $rootAttributes = $attributes->only([
        'class',
    ]);

    $inputAttributes = $attributes->except([
        'class',
        'aria-describedby',
        'aria-errormessage',
        'id',
        'name',
        'maxlength',
        'placeholder',
        'pattern',
        'type',
        'value',
        'disabled',
        'readonly',
        'required',
    ]);
@endphp

<div
    {{ $rootAttributes->class($rootClasses)->merge([
        'data-ui-component' => 'time-picker',
        'data-ui-time-picker-form-item' => true,
        'data-ui-time-picker-state' => $stateValue,
        'data-ui-time-picker-size' => $resolvedSize,
    ]) }}
>
    {{-- ----------------------------------------------------------------------
        Label
        ---------------------------------------------------------------------- --}}

    @if (! is_null($labelText))
        <label for="{{ $resolvedId }}" @class($labelClasses)>
            @if ($labelText instanceof HtmlString)
                {!! $labelText !!}
            @else
                {{ $labelText }}
            @endif
        </label>
    @endif

    {{-- ----------------------------------------------------------------------
        Time Picker
        ----------------------------------------------------------------------
        Child controls such as AM/PM or timezone selects are rendered through
        the default slot.
        ---------------------------------------------------------------------- --}}

    <div
        @class($pickerClasses)
        data-ui-time-picker
        data-ui-time-picker-state="{{ $stateValue }}"
        data-ui-time-picker-size="{{ $resolvedSize }}"
        data-ui-time-picker-light="{{ $isLight ? 'true' : 'false' }}"
        data-ui-time-picker-readonly="{{ $isReadOnly ? 'true' : 'false' }}"
        data-ui-time-picker-disabled="{{ $isDisabled ? 'true' : 'false' }}"
    >
        <div class="ui-time-picker__input" data-ui-time-picker-input-wrapper>
            <input
                id="{{ $resolvedId }}"
                @if (filled($name)) name="{{ $name }}" @endif
                maxlength="{{ $maxLength }}"
                placeholder="{{ $placeholder }}"
                pattern="{{ $pattern }}"
                type="{{ $resolvedType }}"
                @if (! is_null($value)) value="{{ $value }}" @endif
                @class($inputClasses)
                @disabled($isDisabled)
                @readonly($isReadOnly)
                @required($isRequired)
                @if ($isInvalid) data-invalid="true" aria-invalid="true" @endif
                @if (filled($validationId) && $isInvalid) aria-errormessage="{{ $validationId }}" @endif
                @if ($isReadOnly) aria-readonly="true" @endif
                @if (filled($describedBy)) aria-describedby="{{ $describedBy }}" @endif
                data-ui-time-picker-input
                data-ui-time-picker-input-state="{{ $stateValue }}"
                {{ $inputAttributes }}
            >

            @if ($isInvalid || $isWarning)
                <div @class($iconClasses) aria-hidden="true" data-ui-time-picker-status-icon>
                    @if ($isInvalid)
                        @isset($invalidIcon)
                            {{ $invalidIcon }}
                        @else
                            <x-ui.icon name="warning--filled" aria-hidden="true" />
                        @endisset
                    @else
                        @isset($warningIcon)
                            {{ $warningIcon }}
                        @else
                            <x-ui.icon name="warning--alt" aria-hidden="true" />
                        @endisset
                    @endif
                </div>
            @endif
        </div>

        {{ $slot }}
    </div>

    {{-- ----------------------------------------------------------------------
        Validation and Warning Text
        ---------------------------------------------------------------------- --}}

    @if ($isInvalid)
        <div
            id="{{ $validationId }}"
            role="alert"
            class="ui-form-requirement"
            data-ui-time-picker-validation
        >
            {{ $invalidText }}
        </div>
    @elseif ($isWarning)
        <div
            id="{{ $validationId }}"
            role="alert"
            class="ui-form-requirement"
            data-ui-time-picker-validation
        >
            {{ $warningText }}
        </div>
    @endif
</div>