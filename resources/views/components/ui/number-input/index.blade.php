{{-- ==========================================================================
    File: resources/views/components/ui/number-input/index.blade.php
    Purpose: Number Input form control component.

    Notes:
    - Emits the installed .ui-number selector contract.
    - Supports label, helper text, invalid, warning, read-only, disabled,
      min, max, step, steppers, light state, size, and decorator content.
    - The native input remains the source of truth for form submission.
    - Helper, invalid, and warning messages are associated through ARIA.
    - Stepper, clamp, wheel-prevention, and optional locale formatting behavior
      are handled by installed Number Input JavaScript.
    - Uses the unified x-ui.icon component for icons.
    - Number Input styles are handled by resources/css/components/number-input.css.
    ========================================================================== --}}

@props([
    'id' => null,
    'name' => null,
    'label' => null,
    'value' => null,
    'defaultValue' => null,
    'type' => 'number',
    'min' => null,
    'max' => null,
    'step' => 1,
    'stepStartValue' => 0,
    'allowEmpty' => false,
    'disabled' => false,
    'readOnly' => false,
    'required' => false,
    'disableWheel' => false,
    'hideLabel' => false,
    'hideSteppers' => false,
    'helperText' => null,
    'invalid' => false,
    'invalidText' => null,
    'warn' => false,
    'warnText' => null,
    'light' => false,
    'size' => 'md',
    'inputMode' => 'decimal',
    'pattern' => '[0-9]*',
    'locale' => 'en-US',
    'decorator' => null,
    'slug' => null,
    'iconDescription' => null,
    'formatOptions' => null,
    'incrementLabel' => 'Increment number',
    'decrementLabel' => 'Decrement number',
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
        'number',
        'text',
    ];

    $allowedSizes = [
        'sm',
        'md',
        'lg',
    ];

    $allowedInputModes = [
        'none',
        'text',
        'tel',
        'url',
        'email',
        'numeric',
        'decimal',
        'search',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    |
    | `slug` is retained as a legacy alias for `decorator`.
    |
    */

    $resolvedId = $id ?? 'ui-number-input-'.Str::uuid();

    $resolvedType = in_array($type, $allowedTypes, true)
        ? $type
        : 'number';

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : 'md';

    $resolvedInputMode = in_array($inputMode, $allowedInputModes, true)
        ? $inputMode
        : 'decimal';

    $resolvedDecorator = $decorator ?? $slug;

    $allowsEmpty = filter_var($allowEmpty, FILTER_VALIDATE_BOOLEAN);

    $inputValue = $value ?? $defaultValue;

    if (is_null($inputValue) && ! $allowsEmpty && $resolvedType === 'number') {
        $inputValue = 0;
    }

    $resolvedIncrementLabel = $incrementLabel ?: $iconDescription ?: 'Increment number';
    $resolvedDecrementLabel = $decrementLabel ?: $iconDescription ?: 'Decrement number';

    $formatOptionsJson = ! is_null($formatOptions)
        ? (is_string($formatOptions) ? $formatOptions : json_encode($formatOptions))
        : null;

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
    $isRequired = filter_var($required, FILTER_VALIDATE_BOOLEAN);
    $isLight = filter_var($light, FILTER_VALIDATE_BOOLEAN);
    $hidesLabel = filter_var($hideLabel, FILTER_VALIDATE_BOOLEAN);
    $hidesSteppers = filter_var($hideSteppers, FILTER_VALIDATE_BOOLEAN);
    $wheelDisabled = filter_var($disableWheel, FILTER_VALIDATE_BOOLEAN);

    $isInvalid = ! $isDisabled && filter_var($invalid, FILTER_VALIDATE_BOOLEAN);
    $isWarning = ! $isDisabled && ! $isInvalid && filter_var($warn, FILTER_VALIDATE_BOOLEAN);

    $showHelper = ! $isInvalid && ! $isWarning && filled($helperText);
    $showInvalid = $isInvalid && filled($invalidText);
    $showWarning = $isWarning && filled($warnText);

    $stateValue = $isInvalid ? 'invalid' : ($isWarning ? 'warning' : 'default');

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
    | CSS Class Contract
    |--------------------------------------------------------------------------
    |
    | These classes must match resources/css/components/number-input.css and
    | shared form styles.
    |
    */

    $outerClasses = [
        'ui-form-item',
    ];

    $numberClasses = [
        'ui-number',
        'ui-number--helpertext',
        'ui-number--readonly' => $isReadOnly,
        'ui-number--light' => $isLight,
        'ui-number--nolabel' => $hidesLabel,
        'ui-number--nosteppers' => $hidesSteppers,
        'ui-number--'.$resolvedSize,
    ];

    $labelClasses = [
        'ui-label',
        'ui-label--disabled' => $isDisabled,
        'ui-visually-hidden' => $hidesLabel,
    ];

    $inputWrapperClasses = [
        'ui-number__input-wrapper',
        'ui-number__input-wrapper--warning' => $isWarning,
        'ui-number__input-wrapper--decorator' => $hasDecorator,
    ];

    $iconClasses = [
        'ui-number__invalid',
        'ui-number__invalid--warning' => $isWarning,
    ];

    $helperClasses = [
        'ui-form__helper-text',
        'ui-form__helper-text--disabled' => $isDisabled,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    |
    | Component classes are applied to the outer wrapper. Non-class attributes
    | are passed to the native input.
    |
    */

    $wrapperAttributes = $attributes->only('class');

    $inputAttributes = $attributes->except([
        'class',
        'aria-describedby',
        'aria-errormessage',
        'value',
        'defaultValue',
        'default-value',
        'type',
        'id',
        'name',
        'min',
        'max',
        'step',
        'disabled',
        'readonly',
        'required',
        'pattern',
        'inputmode',
        'inputMode',
    ]);
@endphp

<div
    {{ $wrapperAttributes->class($outerClasses)->merge([
        'data-ui-component' => 'number-input',
        'data-ui-number-input-form-item' => true,
    ]) }}
>
    <div
        @class($numberClasses)
        @if ($isInvalid) data-invalid="true" @endif
        data-ui-number-input-wrapper
        data-ui-number-input-state="{{ $stateValue }}"
        data-ui-number-input-size="{{ $resolvedSize }}"
        data-ui-number-input-locale="{{ $locale }}"
        data-ui-number-input-allow-empty="{{ $allowsEmpty ? 'true' : 'false' }}"
        data-ui-number-input-disable-wheel="{{ $wheelDisabled ? 'true' : 'false' }}"
    >
        {{-- ------------------------------------------------------------------
            Label
            ------------------------------------------------------------------ --}}

        @if (filled($label))
            <label for="{{ $resolvedId }}" @class($labelClasses)>
                @if ($label instanceof HtmlString)
                    {!! $label !!}
                @else
                    {{ $label }}
                @endif
            </label>
        @endif

        {{-- ------------------------------------------------------------------
            Input and steppers
            ------------------------------------------------------------------
            The input owns the submitted value. Stepper buttons are JS-driven.
            ------------------------------------------------------------------ --}}

        <div @class($inputWrapperClasses) data-ui-number-input-field-wrapper>
            <input
                id="{{ $resolvedId }}"
                type="{{ $resolvedType }}"
                @if (filled($name)) name="{{ $name }}" @endif
                @if (! is_null($inputValue)) value="{{ $inputValue }}" @endif
                @if (! is_null($min)) min="{{ $min }}" @endif
                @if (! is_null($max)) max="{{ $max }}" @endif
                @if (! is_null($formatOptionsJson)) data-ui-number-input-format-options="{{ $formatOptionsJson }}" @endif
                step="{{ $step }}"
                pattern="{{ $pattern }}"
                inputmode="{{ $resolvedInputMode }}"
                @disabled($isDisabled)
                @readonly($isReadOnly)
                @required($isRequired)
                @if ($isInvalid) aria-invalid="true" data-invalid="true" @endif
                @if (filled($invalidId)) aria-errormessage="{{ $invalidId }}" @endif
                @if ($isReadOnly) aria-readonly="true" @endif
                @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
                data-ui-number-input
                data-ui-number-input-control
                data-ui-number-input-state="{{ $stateValue }}"
                data-ui-number-input-type="{{ $resolvedType }}"
                data-ui-number-input-step="{{ $step }}"
                data-ui-number-input-step-start-value="{{ $stepStartValue }}"
                @if (! is_null($min)) data-ui-number-input-min="{{ $min }}" @endif
                @if (! is_null($max)) data-ui-number-input-max="{{ $max }}" @endif
                {{ $inputAttributes }}
            >

            @if ($hasDecorator)
                <span class="ui-number__input-inner-wrapper--decorator">
                    @if ($resolvedDecorator instanceof HtmlString)
                        {!! $resolvedDecorator !!}
                    @else
                        {{ $resolvedDecorator }}
                    @endif
                </span>
            @endif

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
            @endif

            @unless ($hidesSteppers)
                <div class="ui-number__controls" data-ui-number-input-controls>
                    <button
                        type="button"
                        class="ui-number__control-btn down-icon"
                        aria-label="{{ $resolvedDecrementLabel }}"
                        title="{{ $resolvedDecrementLabel }}"
                        tabindex="-1"
                        @disabled($isDisabled || $isReadOnly)
                        data-ui-number-input-stepper
                        data-ui-number-input-direction="down"
                    >
                        <x-ui.icon name="subtract" class="down-icon" aria-hidden="true" />
                    </button>

                    <div class="ui-number__rule-divider"></div>

                    <button
                        type="button"
                        class="ui-number__control-btn up-icon"
                        aria-label="{{ $resolvedIncrementLabel }}"
                        title="{{ $resolvedIncrementLabel }}"
                        tabindex="-1"
                        @disabled($isDisabled || $isReadOnly)
                        data-ui-number-input-stepper
                        data-ui-number-input-direction="up"
                    >
                        <x-ui.icon name="add" class="up-icon" aria-hidden="true" />
                    </button>

                    <div class="ui-number__rule-divider"></div>
                </div>
            @endunless
        </div>

        {{-- ------------------------------------------------------------------
            Validation, warning, and helper text
            ------------------------------------------------------------------ --}}

        @if ($showInvalid)
            <div
                id="{{ $invalidId }}"
                role="alert"
                class="ui-form-requirement"
                data-ui-number-input-validation
            >
                {{ $invalidText }}
            </div>
        @elseif ($showWarning)
            <div
                id="{{ $warningId }}"
                role="alert"
                class="ui-form-requirement"
                data-ui-number-input-validation
            >
                {{ $warnText }}
            </div>
        @elseif ($showHelper)
            <div id="{{ $helperId }}" @class($helperClasses)>
                {{ $helperText }}
            </div>
        @endif
    </div>
</div>