{{-- ==========================================================================
    File: resources/views/components/ui/date-picker/index.blade.php
    Purpose: Date Picker form control component.

    Notes:
    - Emits the installed .ui-date-picker selector contract.
    - Supports simple, single, and range date picker modes.
    - Renders one input for simple/single mode and two inputs for range mode.
    - Calendar initialization, parsing, min/max dates, range behavior, and
      keyboard behavior are handled by installed Date Picker JavaScript.
    - Uses the unified x-ui.icon component for icons.
    - Date Picker styles are handled by resources/css/components/date-picker.css.
    ========================================================================== --}}

@props([
    'id' => null,
    'datePickerType' => 'single',
    'type' => null,
    'name' => null,
    'startName' => null,
    'endName' => null,
    'labelText' => null,
    'startLabelText' => null,
    'endLabelText' => null,
    'hideLabel' => false,
    'value' => null,
    'startValue' => null,
    'endValue' => null,
    'placeholder' => 'mm/dd/yyyy',
    'startPlaceholder' => null,
    'endPlaceholder' => null,
    'dateFormat' => 'm/d/Y',
    'allowInput' => true,
    'closeOnSelect' => true,
    'inline' => false,
    'readOnly' => false,
    'disabled' => false,
    'short' => false,
    'light' => false,
    'invalid' => false,
    'invalidText' => null,
    'warn' => false,
    'warnText' => null,
    'helperText' => null,
    'minDate' => null,
    'maxDate' => null,
    'locale' => 'en',
    'nextMonthAriaLabel' => 'Next month',
    'prevMonthAriaLabel' => 'Previous month',
])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedTypes = [
        'simple',
        'single',
        'range',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    |
    | `type` is retained as a shorter alias for `datePickerType`.
    |
    */

    $requestedType = $type ?? $datePickerType;

    $resolvedType = in_array($requestedType, $allowedTypes, true)
        ? $requestedType
        : 'single';

    $resolvedId = $id ?? 'ui-date-picker-'.Str::uuid();
    $startInputId = $resolvedId.'-start';
    $endInputId = $resolvedId.'-end';

    $resolvedStartName = $startName ?? $name;
    $resolvedEndName = $endName ?? (filled($name) ? $name.'_end' : null);

    $resolvedStartLabel = $startLabelText ?? $labelText ?? 'Date';
    $resolvedEndLabel = $endLabelText ?? 'End date';

    $resolvedStartPlaceholder = $startPlaceholder ?? $placeholder;
    $resolvedEndPlaceholder = $endPlaceholder ?? $placeholder;

    /*
    |--------------------------------------------------------------------------
    | Value Handling
    |--------------------------------------------------------------------------
    |
    | Range values may be passed as value=[start, end] or through explicit
    | startValue/endValue props.
    |
    */

    $rangeValue = is_array($value) ? array_values($value) : [];

    $resolvedStartValue = $startValue
        ?? ($rangeValue[0] ?? (! is_array($value) ? $value : null));

    $resolvedEndValue = $endValue
        ?? ($rangeValue[1] ?? null);

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    |
    | Invalid state takes precedence over warning state.
    |
    */

    $isRange = $resolvedType === 'range';
    $isSimple = $resolvedType === 'simple';
    $isSingle = $resolvedType === 'single';

    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $isReadOnly = filter_var($readOnly, FILTER_VALIDATE_BOOLEAN);
    $isInline = filter_var($inline, FILTER_VALIDATE_BOOLEAN);
    $isShort = filter_var($short, FILTER_VALIDATE_BOOLEAN);
    $isLight = filter_var($light, FILTER_VALIDATE_BOOLEAN);
    $isLabelHidden = filter_var($hideLabel, FILTER_VALIDATE_BOOLEAN);
    $allowsInput = filter_var($allowInput, FILTER_VALIDATE_BOOLEAN);
    $closesOnSelect = filter_var($closeOnSelect, FILTER_VALIDATE_BOOLEAN);

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
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $formItemClasses = [
        'ui-form-item',
    ];

    $datePickerClasses = [
        'ui-date-picker',
        'ui-date-picker--short' => $isShort || $isSimple,
        'ui-date-picker--light' => $isLight,
        'ui-date-picker--simple' => $isSimple,
        'ui-date-picker--single' => $isSingle,
        'ui-date-picker--range' => $isRange,
        'ui-date-picker--nolabel' => $isRange && blank($resolvedStartLabel) && blank($resolvedEndLabel),
        'ui-date-picker--invalid' => $isInvalid,
        'ui-date-picker--warning' => $isWarning,
    ];

    $labelClasses = [
        'ui-label',
        'ui-visually-hidden' => $isLabelHidden,
        'ui-label--disabled' => $isDisabled,
    ];

    $inputClasses = [
        'ui-date-picker__input',
        'ui-date-picker__input--invalid' => $isInvalid,
        'ui-date-picker__input--warning' => $isWarning,
    ];

    $helperClasses = [
        'ui-form__helper-text',
        'ui-form__helper-text--disabled' => $isDisabled,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    */

    $wrapperAttributes = $attributes->except([
        'aria-describedby',
        'aria-errormessage',
    ]);
@endphp

<div
    {{ $wrapperAttributes->class($formItemClasses)->merge([
        'data-ui-component' => 'date-picker',
        'data-ui-date-picker-form-item' => true,
        'data-ui-date-picker-state' => $stateValue,
    ]) }}
>
    <div
        id="{{ $resolvedId }}"
        @class($datePickerClasses)
        @if ($isInvalid) data-invalid="true" @endif
        data-ui-date-picker
        data-ui-date-picker-type="{{ $resolvedType }}"
        data-ui-date-picker-state="{{ $stateValue }}"
        data-ui-date-picker-date-format="{{ $dateFormat }}"
        data-ui-date-picker-allow-input="{{ $allowsInput ? 'true' : 'false' }}"
        data-ui-date-picker-close-on-select="{{ $closesOnSelect ? 'true' : 'false' }}"
        data-ui-date-picker-inline="{{ $isInline ? 'true' : 'false' }}"
        data-ui-date-picker-readonly="{{ $isReadOnly ? 'true' : 'false' }}"
        data-ui-date-picker-disabled="{{ $isDisabled ? 'true' : 'false' }}"
        data-ui-date-picker-light="{{ $isLight ? 'true' : 'false' }}"
        data-ui-date-picker-short="{{ ($isShort || $isSimple) ? 'true' : 'false' }}"
        data-ui-date-picker-locale="{{ $locale }}"
        data-ui-date-picker-next-month-label="{{ $nextMonthAriaLabel }}"
        data-ui-date-picker-prev-month-label="{{ $prevMonthAriaLabel }}"
        @if (! is_null($minDate)) data-ui-date-picker-min-date="{{ $minDate }}" @endif
        @if (! is_null($maxDate)) data-ui-date-picker-max-date="{{ $maxDate }}" @endif
    >
        {{-- ------------------------------------------------------------------
            Start Date Input
            ------------------------------------------------------------------ --}}

        <div class="ui-date-picker-container" data-ui-date-picker-container="start">
            @if (filled($resolvedStartLabel))
                <label for="{{ $startInputId }}" @class($labelClasses)>
                    @if ($resolvedStartLabel instanceof HtmlString)
                        {!! $resolvedStartLabel !!}
                    @else
                        {{ $resolvedStartLabel }}
                    @endif
                </label>
            @endif

            <div class="ui-date-picker__input-wrapper">
                <input
                    id="{{ $startInputId }}"
                    type="text"
                    @class($inputClasses)
                    @if (filled($resolvedStartName)) name="{{ $resolvedStartName }}" @endif
                    @if (! is_null($resolvedStartValue)) value="{{ $resolvedStartValue }}" @endif
                    placeholder="{{ $resolvedStartPlaceholder }}"
                    autocomplete="off"
                    @disabled($isDisabled)
                    @readonly($isReadOnly || ! $allowsInput)
                    @if ($isReadOnly) aria-readonly="true" @endif
                    @if ($isInvalid) aria-invalid="true" @endif
                    @if (filled($invalidId)) aria-errormessage="{{ $invalidId }}" @endif
                    @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
                    data-ui-date-picker-input
                    data-ui-date-picker-input-role="start"
                    data-ui-date-picker-input-state="{{ $stateValue }}"
                >

                @unless ($isSimple)
                    <x-ui.icon
                        name="calendar"
                        class="ui-date-picker__icon"
                        aria-hidden="true"
                    />
                @endunless
            </div>
        </div>

        {{-- ------------------------------------------------------------------
            End Date Input
            ------------------------------------------------------------------
            Rendered only for range mode.
            ------------------------------------------------------------------ --}}

        @if ($isRange)
            <div class="ui-date-picker-container" data-ui-date-picker-container="end">
                @if (filled($resolvedEndLabel))
                    <label for="{{ $endInputId }}" @class($labelClasses)>
                        @if ($resolvedEndLabel instanceof HtmlString)
                            {!! $resolvedEndLabel !!}
                        @else
                            {{ $resolvedEndLabel }}
                        @endif
                    </label>
                @endif

                <div class="ui-date-picker__input-wrapper">
                    <input
                        id="{{ $endInputId }}"
                        type="text"
                        @class($inputClasses)
                        @if (filled($resolvedEndName)) name="{{ $resolvedEndName }}" @endif
                        @if (! is_null($resolvedEndValue)) value="{{ $resolvedEndValue }}" @endif
                        placeholder="{{ $resolvedEndPlaceholder }}"
                        autocomplete="off"
                        @disabled($isDisabled)
                        @readonly($isReadOnly || ! $allowsInput)
                        @if ($isReadOnly) aria-readonly="true" @endif
                        @if ($isInvalid) aria-invalid="true" @endif
                        @if (filled($invalidId)) aria-errormessage="{{ $invalidId }}" @endif
                        @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
                        data-ui-date-picker-input
                        data-ui-date-picker-input-role="end"
                        data-ui-date-picker-input-state="{{ $stateValue }}"
                    >

                    <x-ui.icon
                        name="calendar"
                        class="ui-date-picker__icon"
                        aria-hidden="true"
                    />
                </div>
            </div>
        @endif
    </div>

    {{-- ----------------------------------------------------------------------
        Validation, warning, and helper text
        ---------------------------------------------------------------------- --}}

    @if ($showInvalid)
        <div
            id="{{ $invalidId }}"
            role="alert"
            class="ui-form-requirement"
            data-ui-date-picker-validation
        >
            {{ $invalidText }}
        </div>
    @elseif ($showWarning)
        <div
            id="{{ $warningId }}"
            role="alert"
            class="ui-form-requirement"
            data-ui-date-picker-validation
        >
            {{ $warnText }}
        </div>
    @elseif ($showHelper)
        <div id="{{ $helperId }}" @class($helperClasses)>
            {{ $helperText }}
        </div>
    @endif
</div>