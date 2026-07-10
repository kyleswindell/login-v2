{{-- ==========================================================================
    File: resources/views/components/ui/date-picker-input/index.blade.php
    Purpose: Date Picker input field component.

    Notes:
    - Emits the installed .ui-date-picker-container and .ui-date-picker__input selector contract.
    - Intended for custom date picker compositions and direct date input usage.
    - Supports simple, single, and range date picker metadata.
    - Supports label, helper text, invalid, warning, read-only, disabled, size,
      hidden label, pattern, placeholder, and decorator content.
    - Uses the unified x-ui.icon component for icons.
    - Calendar behavior is handled by installed Date Picker JavaScript.
    - Date Picker styles are handled by resources/css/components/date-picker.css.
    ========================================================================== --}}

@props([
    'id' => null,
    'name' => null,
    'datePickerType' => null,
    'type' => 'text',
    'labelText' => null,
    'label' => null,
    'value' => null,
    'placeholder' => null,
    'pattern' => '\d{1,2}\/\d{1,2}\/\d{4}',
    'size' => 'md',
    'disabled' => false,
    'readOnly' => false,
    'helperText' => null,
    'hideLabel' => false,
    'invalid' => false,
    'invalidText' => null,
    'warn' => false,
    'warnText' => null,
    'decorator' => null,
    'slug' => null,
])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedDatePickerTypes = [
        'simple',
        'single',
        'range',
    ];

    $allowedSizes = [
        'sm',
        'md',
        'lg',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    |
    | `label` is retained as a shorter alias for `labelText`.
    | `slug` is retained as a legacy alias for `decorator`.
    |
    */

    $resolvedId = $id ?? 'ui-date-picker-input-'.Str::uuid();

    $resolvedDatePickerType = in_array($datePickerType, $allowedDatePickerTypes, true)
        ? $datePickerType
        : null;

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : 'md';

    $resolvedLabel = $labelText ?? $label;
    $resolvedDecorator = $decorator ?? $slug;

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    |
    | Invalid state takes precedence over warning state.
    |
    */

    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $isReadOnly = filter_var($readOnly, FILTER_VALIDATE_BOOLEAN);
    $isLabelHidden = filter_var($hideLabel, FILTER_VALIDATE_BOOLEAN);

    $isInvalid = ! $isDisabled && filter_var($invalid, FILTER_VALIDATE_BOOLEAN);
    $isWarning = ! $isDisabled && ! $isInvalid && filter_var($warn, FILTER_VALIDATE_BOOLEAN);

    $stateValue = $isInvalid ? 'invalid' : ($isWarning ? 'warning' : 'default');

    $showHelper = ! $isInvalid && ! $isWarning && filled($helperText);
    $showInvalid = $isInvalid && filled($invalidText);
    $showWarning = $isWarning && filled($warnText);

    /*
    |--------------------------------------------------------------------------
    | Message IDs and ARIA Wiring
    |--------------------------------------------------------------------------
    */

    $helperId = $showHelper ? $resolvedId.'-helper-text' : null;
    $invalidId = $showInvalid ? $resolvedId.'-invalid-text' : null;
    $warningId = $showWarning ? $resolvedId.'-warning-text' : null;

    $existingDescribedBy = $attributes->get('aria-describedby');

    $ariaDescribedBy = collect([
        $existingDescribedBy,
        $helperId,
        $invalidId,
        $warningId,
    ])->filter()->implode(' ');

    /*
    |--------------------------------------------------------------------------
    | Decorator Handling
    |--------------------------------------------------------------------------
    */

    $hasDecorator = isset($resolvedDecorator) && filled($resolvedDecorator);

    /*
    |--------------------------------------------------------------------------
    | Icon Handling
    |--------------------------------------------------------------------------
    |
    | Simple date pickers do not show the calendar icon unless invalid/warning
    | state needs to be shown.
    |
    */

    $shouldShowIcon = $resolvedDatePickerType !== 'simple' || $isInvalid || $isWarning;

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $containerClasses = [
        'ui-date-picker-container',
        'ui-date-picker--nolabel' => blank($resolvedLabel),
    ];

    $labelClasses = [
        'ui-label',
        'ui-visually-hidden' => $isLabelHidden,
        'ui-label--disabled' => $isDisabled,
        'ui-label--readonly' => $isReadOnly,
    ];

    $wrapperClasses = [
        'ui-date-picker-input__wrapper',
        'ui-date-picker-input__wrapper--invalid' => $isInvalid,
        'ui-date-picker-input__wrapper--warn' => $isWarning,
        'ui-date-picker-input__wrapper--decorator' => $hasDecorator,
    ];

    $inputClasses = [
        'ui-date-picker__input',
        'ui-date-picker__input--'.$resolvedSize,
        'ui-date-picker__input--invalid' => $isInvalid,
        'ui-date-picker__input--warn' => $isWarning,
    ];

    $helperClasses = [
        'ui-form__helper-text',
        'ui-form__helper-text--disabled' => $isDisabled,
    ];

    $iconClasses = [
        'ui-date-picker__icon',
        'ui-date-picker__icon--invalid' => $isInvalid,
        'ui-date-picker__icon--warn' => $isWarning,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    |
    | Caller class is applied to the root container. Native input state and ARIA
    | attributes are owned by this component.
    |
    */

    $containerAttributes = $attributes->only([
        'class',
    ]);

    $inputAttributes = $attributes->except([
        'class',
        'aria-describedby',
        'aria-errormessage',
        'value',
        'id',
        'name',
        'type',
        'pattern',
        'placeholder',
        'disabled',
        'readonly',
    ]);
@endphp

<div
    {{ $containerAttributes->class($containerClasses)->merge([
        'data-ui-component' => 'date-picker-input',
        'data-ui-date-picker-input-container' => true,
        'data-ui-date-picker-input-container-state' => $stateValue,
        'data-ui-date-picker-input-container-size' => $resolvedSize,
    ]) }}
>
    {{-- ----------------------------------------------------------------------
        Label
        ---------------------------------------------------------------------- --}}

    @if (filled($resolvedLabel))
        <label for="{{ $resolvedId }}" @class($labelClasses)>
            @if ($resolvedLabel instanceof HtmlString)
                {!! $resolvedLabel !!}
            @else
                {{ $resolvedLabel }}
            @endif
        </label>
    @endif

    {{-- ----------------------------------------------------------------------
        Input Wrapper
        ----------------------------------------------------------------------
        The wrapper owns icon and decorator positioning.
        ---------------------------------------------------------------------- --}}

    <div
        @class($wrapperClasses)
        @if ($isInvalid) data-invalid="true" @endif
        data-ui-date-picker-input-wrapper
        data-ui-date-picker-input-wrapper-state="{{ $stateValue }}"
    >
        <span>
            <input
                id="{{ $resolvedId }}"
                type="{{ $type }}"
                @class($inputClasses)
                @if (filled($name)) name="{{ $name }}" @endif
                @if (! is_null($value)) value="{{ $value }}" @endif
                @if (! is_null($placeholder)) placeholder="{{ $placeholder }}" @endif
                pattern="{{ $pattern }}"
                @disabled($isDisabled)
                @readonly($isReadOnly)
                @if ($isReadOnly) aria-readonly="true" @endif
                @if ($isInvalid) aria-invalid="true" @endif
                @if (filled($invalidId)) aria-errormessage="{{ $invalidId }}" @endif
                @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
                data-ui-date-picker-input
                data-ui-date-picker-input-state="{{ $stateValue }}"
                data-ui-date-picker-input-size="{{ $resolvedSize }}"
                @if (filled($resolvedDatePickerType)) data-ui-date-picker-input-type="{{ $resolvedDatePickerType }}" @endif
                {{ $inputAttributes }}
            >

            @if ($hasDecorator)
                <span class="ui-date-picker-input-inner-wrapper--decorator">
                    @if ($resolvedDecorator instanceof HtmlString)
                        {!! $resolvedDecorator !!}
                    @else
                        {{ $resolvedDecorator }}
                    @endif
                </span>
            @endif

            @if ($shouldShowIcon)
                @if ($isInvalid)
                    <x-ui.icon
                        name="warning--filled"
                        @class($iconClasses)
                        aria-hidden="true"
                    />
                @elseif ($isWarning)
                    <x-ui.icon
                        name="warning--alt"
                        @class($iconClasses)
                        aria-hidden="true"
                    />
                @else
                    <x-ui.icon
                        name="calendar"
                        @class($iconClasses)
                        aria-hidden="true"
                    />
                @endif
            @endif
        </span>
    </div>

    {{-- ----------------------------------------------------------------------
        Validation, Warning, and Helper Text
        ----------------------------------------------------------------------
        Invalid text takes precedence over warning text.
        ---------------------------------------------------------------------- --}}

    @if ($showInvalid)
        <div
            id="{{ $invalidId }}"
            role="alert"
            class="ui-form-requirement"
            data-ui-date-picker-input-validation
        >
            {{ $invalidText }}
        </div>
    @elseif ($showWarning)
        <div
            id="{{ $warningId }}"
            role="alert"
            class="ui-form-requirement"
            data-ui-date-picker-input-validation
        >
            {{ $warnText }}
        </div>
    @elseif ($showHelper)
        <div id="{{ $helperId }}" @class($helperClasses)>
            {{ $helperText }}
        </div>
    @endif
</div>