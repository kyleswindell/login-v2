{{-- ==========================================================================
    File: resources/views/components/ui/slider/index.blade.php
    Purpose: Slider and range slider form control component.

    Notes:
    - Emits the installed .ui-slider selector contract.
    - Supports single-handle and two-handle range slider modes.
    - Supports visible or hidden text inputs.
    - Slider drag, touch, keyboard, correction, and input sync behavior are
      handled by installed Slider JavaScript.
    - Uses slider-specific handle SVGs because these are part of the slider
      control anatomy, not general-purpose UI icons.
    - Slider styles are handled by resources/css/components/slider.css.
    ========================================================================== --}}

@props([
    'id' => null,
    'name' => null,
    'nameUpper' => null,
    'unstableNameUpper' => null,
    'value' => 0,
    'valueUpper' => null,
    'unstableValueUpper' => null,
    'min' => 0,
    'max' => 100,
    'step' => 1,
    'stepMultiplier' => 4,
    'labelText' => null,
    'hideLabel' => false,
    'minLabel' => null,
    'maxLabel' => null,
    'ariaLabelInput' => null,
    'ariaLabelInputUpper' => null,
    'unstableAriaLabelInputUpper' => null,
    'inputType' => 'number',
    'hideTextInput' => false,
    'disabled' => false,
    'readOnly' => false,
    'required' => false,
    'invalid' => false,
    'invalidText' => null,
    'warn' => false,
    'warnText' => null,
    'light' => false,
    'twoHandles' => null,
    'rtl' => false,
])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedInputTypes = [
        'number',
        'text',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve IDs
    |--------------------------------------------------------------------------
    */

    $resolvedId = $id ?? 'ui-slider-'.Str::uuid();
    $labelId = $resolvedId.'-label';

    $lowerInputId = $resolvedId.'-lower-input-for-slider';
    $upperInputId = $resolvedId.'-upper-input-for-slider';
    $singleInputId = $resolvedId.'-input-for-slider';

    $lowerThumbId = $resolvedId.'-lower-thumb';
    $upperThumbId = $resolvedId.'-upper-thumb';

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedInputType = in_array($inputType, $allowedInputTypes, true)
        ? $inputType
        : 'number';

    $resolvedUpperValue = $valueUpper ?? $unstableValueUpper;

    $usesTwoHandles = ! is_null($twoHandles)
        ? filter_var($twoHandles, FILTER_VALIDATE_BOOLEAN)
        : ! is_null($resolvedUpperValue);

    if ($usesTwoHandles && is_null($resolvedUpperValue)) {
        $resolvedUpperValue = $max;
    }

    $resolvedUpperName = $nameUpper ?? $unstableNameUpper;
    $resolvedLowerAriaLabel = $ariaLabelInput ?? ($usesTwoHandles ? 'Lower slider handle' : 'Slider handle');
    $resolvedUpperAriaLabel = $ariaLabelInputUpper ?? $unstableAriaLabelInputUpper ?? 'Upper slider handle';

    /*
    |--------------------------------------------------------------------------
    | Numeric Value Handling
    |--------------------------------------------------------------------------
    */

    $numericMin = is_numeric($min) ? (float) $min : 0.0;
    $numericMax = is_numeric($max) ? (float) $max : 100.0;

    if ($numericMax < $numericMin) {
        [$numericMin, $numericMax] = [$numericMax, $numericMin];
    }

    $numericValue = is_numeric($value) ? (float) $value : $numericMin;
    $numericUpperValue = is_numeric($resolvedUpperValue) ? (float) $resolvedUpperValue : $numericMax;

    $lowerValue = max($numericMin, min($numericMax, $numericValue));
    $upperValue = max($numericMin, min($numericMax, $numericUpperValue));

    if ($usesTwoHandles && $upperValue < $lowerValue) {
        [$lowerValue, $upperValue] = [$upperValue, $lowerValue];
    }

    /*
    |--------------------------------------------------------------------------
    | Percent Calculations
    |--------------------------------------------------------------------------
    |
    | Percent values drive initial thumb and filled-track placement. JavaScript
    | updates these values after user interaction.
    |
    */

    $range = $numericMax - $numericMin;

    $lowerPercent = $range === 0.0
        ? 0
        : max(0, min(100, (($lowerValue - $numericMin) / $range) * 100));

    $upperPercent = $range === 0.0
        ? 100
        : max(0, min(100, (($upperValue - $numericMin) / $range) * 100));

    $filledScale = $usesTwoHandles
        ? max(0, ($upperPercent - $lowerPercent) / 100)
        : max(0, $lowerPercent / 100);

    $filledTranslate = $usesTwoHandles ? $lowerPercent : 0;

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $isReadOnly = filter_var($readOnly, FILTER_VALIDATE_BOOLEAN);
    $isRequired = filter_var($required, FILTER_VALIDATE_BOOLEAN);
    $isLight = filter_var($light, FILTER_VALIDATE_BOOLEAN);
    $isRtl = filter_var($rtl, FILTER_VALIDATE_BOOLEAN);
    $isLabelHidden = filter_var($hideLabel, FILTER_VALIDATE_BOOLEAN);
    $hidesTextInput = filter_var($hideTextInput, FILTER_VALIDATE_BOOLEAN);

    $isInvalid = ! $isDisabled && filter_var($invalid, FILTER_VALIDATE_BOOLEAN);
    $isWarning = ! $isDisabled && ! $isInvalid && filter_var($warn, FILTER_VALIDATE_BOOLEAN);

    $stateValue = $isInvalid ? 'invalid' : ($isWarning ? 'warning' : 'default');

    /*
    |--------------------------------------------------------------------------
    | Message IDs and ARIA Wiring
    |--------------------------------------------------------------------------
    */

    $invalidId = $isInvalid && filled($invalidText) ? $resolvedId.'-invalid-text' : null;
    $warningId = $isWarning && filled($warnText) ? $resolvedId.'-warning-text' : null;
    $statusId = $resolvedId.'-status-message';

    $existingDescribedBy = $attributes->get('aria-describedby');

    $ariaDescribedBy = collect([
        $existingDescribedBy,
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

    $labelClasses = [
        'ui-label',
        'ui-visually-hidden' => $isLabelHidden,
        'ui-label--disabled' => $isDisabled,
    ];

    $containerClasses = [
        'ui-slider-container',
        'ui-slider-container--two-handles' => $usesTwoHandles,
        'ui-slider-container--disabled' => $isDisabled,
        'ui-slider-container--readonly' => $isReadOnly,
        'ui-slider-container--rtl' => $isRtl,
        'ui-slider-container--light' => $isLight,
        'ui-slider-container--invalid' => $isInvalid,
        'ui-slider-container--warning' => $isWarning,
    ];

    $sliderClasses = [
        'ui-slider',
        'ui-slider--disabled' => $isDisabled,
        'ui-slider--readonly' => $isReadOnly,
    ];

    $lowerInputWrapperClasses = [
        'ui-text-input-wrapper',
        'ui-slider-text-input-wrapper',
        'ui-slider-text-input-wrapper--lower',
        'ui-text-input-wrapper--readonly' => $isReadOnly,
        'ui-slider-text-input-wrapper--hidden' => $hidesTextInput,
    ];

    $upperInputWrapperClasses = [
        'ui-text-input-wrapper',
        'ui-slider-text-input-wrapper',
        'ui-slider-text-input-wrapper--upper',
        'ui-text-input-wrapper--readonly' => $isReadOnly,
        'ui-slider-text-input-wrapper--hidden' => $hidesTextInput,
    ];

    $lowerInputClasses = [
        'ui-text-input',
        'ui-slider-text-input',
        'ui-slider-text-input--lower',
        'ui-text-input--light' => $isLight,
        'ui-text-input--invalid' => $isInvalid,
        'ui-slider-text-input--warn' => $isWarning,
    ];

    $upperInputClasses = [
        'ui-text-input',
        'ui-slider-text-input',
        'ui-slider-text-input--upper',
        'ui-text-input--light' => $isLight,
        'ui-text-input--invalid' => $isInvalid,
        'ui-slider-text-input--warn' => $isWarning,
    ];

    $lowerThumbWrapperClasses = [
        'ui-icon-tooltip',
        'ui-slider__thumb-wrapper',
        'ui-slider__thumb-wrapper--lower' => $usesTwoHandles,
    ];

    $upperThumbWrapperClasses = [
        'ui-icon-tooltip',
        'ui-slider__thumb-wrapper',
        'ui-slider__thumb-wrapper--upper',
    ];

    $lowerThumbClasses = [
        'ui-slider__thumb',
        'ui-slider__thumb--lower' => $usesTwoHandles,
    ];

    $upperThumbClasses = [
        'ui-slider__thumb',
        'ui-slider__thumb--upper',
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    */

    $rootAttributes = $attributes->except([
        'aria-describedby',
        'aria-errormessage',
    ]);
@endphp

<div
    {{ $rootAttributes->class($formItemClasses)->merge([
        'data-ui-component' => 'slider',
        'data-ui-slider-form-item' => true,
        'data-ui-slider-state' => $stateValue,
    ]) }}
>
    {{-- ----------------------------------------------------------------------
        Label
        ---------------------------------------------------------------------- --}}

    @if (filled($labelText))
        @if ($usesTwoHandles)
            <span id="{{ $labelId }}" @class($labelClasses)>
                @if ($labelText instanceof HtmlString)
                    {!! $labelText !!}
                @else
                    {{ $labelText }}
                @endif
            </span>
        @else
            <label id="{{ $labelId }}" for="{{ $singleInputId }}" @class($labelClasses)>
                @if ($labelText instanceof HtmlString)
                    {!! $labelText !!}
                @else
                    {{ $labelText }}
                @endif
            </label>
        @endif
    @endif

    <div
        @class($containerClasses)
        data-ui-slider-container
        data-ui-slider-two-handles="{{ $usesTwoHandles ? 'true' : 'false' }}"
        data-ui-slider-disabled="{{ $isDisabled ? 'true' : 'false' }}"
        data-ui-slider-readonly="{{ $isReadOnly ? 'true' : 'false' }}"
        data-ui-slider-required="{{ $isRequired ? 'true' : 'false' }}"
        data-ui-slider-light="{{ $isLight ? 'true' : 'false' }}"
        data-ui-slider-rtl="{{ $isRtl ? 'true' : 'false' }}"
        data-ui-slider-state="{{ $stateValue }}"
        data-ui-slider-min="{{ $numericMin }}"
        data-ui-slider-max="{{ $numericMax }}"
        data-ui-slider-step="{{ $step }}"
        data-ui-slider-step-multiplier="{{ $stepMultiplier }}"
    >
        {{-- ------------------------------------------------------------------
            Lower Text Input
            ------------------------------------------------------------------ --}}

        @if ($usesTwoHandles)
            <div @class($lowerInputWrapperClasses)>
                <input
                    id="{{ $lowerInputId }}"
                    @if (filled($name)) name="{{ $name }}" @endif
                    type="{{ $hidesTextInput ? 'hidden' : $resolvedInputType }}"
                    value="{{ $lowerValue }}"
                    @class($lowerInputClasses)
                    aria-label="{{ $resolvedLowerAriaLabel }}"
                    min="{{ $numericMin }}"
                    max="{{ $numericMax }}"
                    step="{{ $step }}"
                    @disabled($isDisabled)
                    @readonly($isReadOnly)
                    @required($isRequired)
                    @if ($isReadOnly) aria-readonly="true" @endif
                    @if ($isInvalid) data-invalid="true" aria-invalid="true" @endif
                    @if (filled($invalidId)) aria-errormessage="{{ $invalidId }}" @endif
                    @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
                    data-ui-slider-input
                    data-ui-slider-input-state="{{ $stateValue }}"
                    data-ui-slider-handle-position="lower"
                >

                @if ($isInvalid)
                    <x-ui.icon name="warning--filled" class="ui-slider__invalid-icon" aria-hidden="true" />
                @elseif ($isWarning)
                    <x-ui.icon name="warning--alt" class="ui-slider__invalid-icon ui-slider__invalid-icon--warning" aria-hidden="true" />
                @endif
            </div>
        @endif

        <span class="ui-slider__range-label">
            {{ $minLabel ?? $numericMin }}
        </span>

        {{-- ------------------------------------------------------------------
            Slider Track and Thumbs
            ------------------------------------------------------------------ --}}

        <div
            @class($sliderClasses)
            role="presentation"
            tabindex="-1"
            data-ui-slider
            data-ui-slider-state="{{ $stateValue }}"
            @if ($isInvalid) data-invalid="true" @endif
        >
            <div
                @class($lowerThumbWrapperClasses)
                style="inset-inline-start: {{ $lowerPercent }}%;"
                data-ui-slider-thumb-wrapper
                data-ui-slider-handle-position="lower"
            >
                <div
                    id="{{ $usesTwoHandles ? $lowerThumbId : $resolvedId }}"
                    @class($lowerThumbClasses)
                    role="slider"
                    tabindex="{{ $isReadOnly || $isDisabled ? '-1' : '0' }}"
                    aria-orientation="horizontal"
                    aria-valuemin="{{ $numericMin }}"
                    aria-valuemax="{{ $usesTwoHandles ? $upperValue : $numericMax }}"
                    aria-valuenow="{{ $lowerValue }}"
                    aria-valuetext="{{ $lowerValue }}"
                    @if ($usesTwoHandles)
                        aria-label="{{ $resolvedLowerAriaLabel }}"
                    @elseif (filled($labelText))
                        aria-labelledby="{{ $labelId }}"
                    @else
                        aria-label="{{ $resolvedLowerAriaLabel }}"
                    @endif
                    @if ($isReadOnly) aria-readonly="true" @endif
                    @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
                    data-ui-slider-thumb
                    data-ui-slider-thumb-state="{{ $stateValue }}"
                    data-ui-slider-handle-position="lower"
                >
                    @if ($usesTwoHandles)
                        <svg
                            class="ui-slider__thumb-icon ui-slider__thumb-icon--lower"
                            viewBox="0 0 16 24"
                            aria-hidden="true"
                            focusable="false"
                        >
                            <path d="M15.08 6.46H16v11.08h-.92zM4.46 17.54c-.25 0-.46-.21-.46-.46V6.92a.465.465 0 0 1 .69-.4l8.77 5.08a.46.46 0 0 1 0 .8l-8.77 5.08c-.07.04-.15.06-.23.06Z" />
                        </svg>
                    @endif
                </div>
            </div>

            @if ($usesTwoHandles)
                <div
                    @class($upperThumbWrapperClasses)
                    style="inset-inline-start: {{ $upperPercent }}%;"
                    data-ui-slider-thumb-wrapper
                    data-ui-slider-handle-position="upper"
                >
                    <div
                        id="{{ $upperThumbId }}"
                        @class($upperThumbClasses)
                        role="slider"
                        tabindex="{{ $isReadOnly || $isDisabled ? '-1' : '0' }}"
                        aria-orientation="horizontal"
                        aria-valuemin="{{ $lowerValue }}"
                        aria-valuemax="{{ $numericMax }}"
                        aria-valuenow="{{ $upperValue }}"
                        aria-valuetext="{{ $upperValue }}"
                        aria-label="{{ $resolvedUpperAriaLabel }}"
                        @if ($isReadOnly) aria-readonly="true" @endif
                        @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
                        data-ui-slider-thumb
                        data-ui-slider-thumb-state="{{ $stateValue }}"
                        data-ui-slider-handle-position="upper"
                    >
                        <svg
                            class="ui-slider__thumb-icon ui-slider__thumb-icon--upper"
                            viewBox="0 0 16 24"
                            aria-hidden="true"
                            focusable="false"
                        >
                            <path d="M0 6.46h.92v11.08H0zM11.54 6.46c.25 0 .46.21.46.46v10.15a.465.465 0 0 1-.69.4L2.54 12.4a.46.46 0 0 1 0-.8l8.77-5.08c.07-.04.15-.06.23-.06Z" />
                        </svg>
                    </div>
                </div>
            @endif

            <div class="ui-slider__track"></div>

            <div
                class="ui-slider__filled-track"
                style="transform: translate({{ $filledTranslate }}%, -50%) scaleX({{ $filledScale }});"
                data-ui-slider-filled-track
            ></div>
        </div>

        <span class="ui-slider__range-label">
            {{ $maxLabel ?? $numericMax }}
        </span>

        {{-- ------------------------------------------------------------------
            Upper / Single Text Input
            ------------------------------------------------------------------ --}}

        <div @class($upperInputWrapperClasses)>
            <input
                id="{{ $usesTwoHandles ? $upperInputId : $singleInputId }}"
                @if ($usesTwoHandles && filled($resolvedUpperName)) name="{{ $resolvedUpperName }}" @endif
                @if (! $usesTwoHandles && filled($name)) name="{{ $name }}" @endif
                type="{{ $hidesTextInput ? 'hidden' : $resolvedInputType }}"
                value="{{ $usesTwoHandles ? $upperValue : $lowerValue }}"
                @class($upperInputClasses)
                @if ($usesTwoHandles)
                    aria-label="{{ $resolvedUpperAriaLabel }}"
                @elseif (filled($labelText))
                    aria-labelledby="{{ $labelId }}"
                @else
                    aria-label="{{ $ariaLabelInput ?? 'Slider input' }}"
                @endif
                min="{{ $numericMin }}"
                max="{{ $numericMax }}"
                step="{{ $step }}"
                @disabled($isDisabled)
                @readonly($isReadOnly)
                @required($isRequired)
                @if ($isReadOnly) aria-readonly="true" @endif
                @if ($isInvalid) data-invalid="true" aria-invalid="true" @endif
                @if (filled($invalidId)) aria-errormessage="{{ $invalidId }}" @endif
                @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
                data-ui-slider-input
                data-ui-slider-input-state="{{ $stateValue }}"
                data-ui-slider-handle-position="{{ $usesTwoHandles ? 'upper' : 'lower' }}"
            >

            @if ($isInvalid)
                <x-ui.icon name="warning--filled" class="ui-slider__invalid-icon" aria-hidden="true" />
            @elseif ($isWarning)
                <x-ui.icon name="warning--alt" class="ui-slider__invalid-icon ui-slider__invalid-icon--warning" aria-hidden="true" />
            @endif
        </div>
    </div>

    {{-- ----------------------------------------------------------------------
        Validation and Warning Messages
        ---------------------------------------------------------------------- --}}

    @if ($isInvalid && filled($invalidText))
        <div
            id="{{ $invalidId }}"
            class="ui-slider__validation-msg ui-slider__validation-msg--invalid ui-form-requirement"
            role="alert"
            data-ui-slider-validation
        >
            {{ $invalidText }}
        </div>
    @elseif ($isWarning && filled($warnText))
        <div
            id="{{ $warningId }}"
            class="ui-slider__validation-msg ui-form-requirement"
            role="alert"
            data-ui-slider-validation
        >
            {{ $warnText }}
        </div>
    @endif

    <div
        id="{{ $statusId }}"
        class="ui-slider__status-msg ui-form-requirement"
        role="alert"
        hidden
        data-ui-slider-status-message
    ></div>
</div>