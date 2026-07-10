{{-- ==========================================================================
    File: resources/views/components/ui/password-input/index.blade.php
    Purpose: Password Input form control component.

    Notes:
    - Emits the installed .ui-password-input selector contract.
    - Extends the Text Input selector contract and field anatomy.
    - Supports password/text type, visibility toggle, helper text, invalid,
      warning, read-only, disabled, inline layout, and size.
    - The visibility toggle state is handled by installed password input JS.
    - Uses the unified x-ui.icon component for visibility and state icons.
    - Password Input styles are handled by resources/css/components/text-input.css.
    ========================================================================== --}}

@props([
    'id' => null,
    'name' => null,
    'type' => 'password',
    'labelText' => null,
    'label' => null,
    'value' => null,
    'defaultValue' => null,
    'placeholder' => null,
    'disabled' => false,
    'readOnly' => false,
    'required' => false,
    'helperText' => null,
    'hideLabel' => false,
    'inline' => false,
    'invalid' => false,
    'invalidText' => null,
    'warn' => false,
    'warnText' => null,
    'light' => false,
    'size' => null,
    'showPasswordLabel' => 'Show password',
    'hidePasswordLabel' => 'Hide password',
    'tooltipPosition' => 'bottom',
    'tooltipAlignment' => 'end',
])

@php
    use Illuminate\Support\HtmlString;
    use Illuminate\Support\Str;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedTypes = [
        'password',
        'text',
    ];

    $allowedSizes = [
        'xs',
        'sm',
        'md',
        'lg',
    ];

    $allowedTooltipPositions = [
        'top',
        'right',
        'bottom',
        'left',
    ];

    $allowedTooltipAlignments = [
        'start',
        'center',
        'end',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedId = $id ?? 'ui-password-input-'.Str::uuid();
    $resolvedLabel = $labelText ?? $label;

    $resolvedType = in_array($type, $allowedTypes, true)
        ? $type
        : 'password';

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : null;

    $resolvedTooltipPosition = in_array($tooltipPosition, $allowedTooltipPositions, true)
        ? $tooltipPosition
        : 'bottom';

    $resolvedTooltipAlignment = in_array($tooltipAlignment, $allowedTooltipAlignments, true)
        ? $tooltipAlignment
        : 'end';

    $inputValue = $value ?? $defaultValue;

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $isReadOnly = filter_var($readOnly, FILTER_VALIDATE_BOOLEAN);
    $isRequired = filter_var($required, FILTER_VALIDATE_BOOLEAN);
    $isInline = filter_var($inline, FILTER_VALIDATE_BOOLEAN);
    $isLight = filter_var($light, FILTER_VALIDATE_BOOLEAN);
    $isLabelHidden = filter_var($hideLabel, FILTER_VALIDATE_BOOLEAN);

    $passwordIsVisible = $resolvedType === 'text';

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

    $toggleLabel = $passwordIsVisible ? $hidePasswordLabel : $showPasswordLabel;

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

    $wrapperClasses = [
        'ui-form-item',
        'ui-text-input-wrapper',
        'ui-password-input-wrapper',
        'ui-text-input-wrapper--readonly' => $isReadOnly,
        'ui-text-input-wrapper--light' => $isLight,
        'ui-text-input-wrapper--inline' => $isInline,
        'ui-text-input-wrapper--inline--invalid' => $isInline && $isInvalid,
    ];

    $labelClasses = [
        'ui-label',
        'ui-visually-hidden' => $isLabelHidden,
        'ui-label--disabled' => $isDisabled,
        'ui-label--inline' => $isInline,
        'ui-label--inline--'.$resolvedSize => $isInline && filled($resolvedSize),
    ];

    $inputClasses = [
        'ui-text-input',
        'ui-password-input',
        'ui-text-input--light' => $isLight,
        'ui-text-input--invalid' => $isInvalid,
        'ui-text-input--warning' => $isWarning,
        'ui-text-input--'.$resolvedSize => filled($resolvedSize),
        'ui-layout--size-'.$resolvedSize => filled($resolvedSize),
    ];

    $helperClasses = [
        'ui-form__helper-text',
        'ui-form__helper-text--disabled' => $isDisabled,
        'ui-form__helper-text--inline' => $isInline,
    ];

    $fieldOuterWrapperClasses = [
        'ui-text-input__field-outer-wrapper',
        'ui-text-input__field-outer-wrapper--inline' => $isInline,
    ];

    $fieldWrapperClasses = [
        'ui-text-input__field-wrapper',
        'ui-text-input__field-wrapper--warning' => $isWarning,
        'ui-layout--size-'.$resolvedSize => filled($resolvedSize),
    ];

    $iconClasses = [
        'ui-text-input__invalid-icon' => $isInvalid || $isWarning,
        'ui-text-input__invalid-icon--warning' => $isWarning,
    ];

    $toggleClasses = [
        'ui-text-input--password__visibility__toggle',
        'ui-btn',
        'ui-tooltip__trigger',
        'ui-tooltip--a11y',
        'ui-tooltip--'.$resolvedTooltipPosition,
        'ui-tooltip--align-'.$resolvedTooltipAlignment,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
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
        'placeholder',
        'disabled',
        'readonly',
        'required',
    ]);
@endphp

<div
    {{ $wrapperAttributes->class($wrapperClasses)->merge([
        'data-ui-component' => 'password-input',
        'data-ui-password-input-wrapper' => true,
        'data-ui-password-input-state' => $stateValue,
        'data-ui-password-input-size' => $resolvedSize,
        'data-ui-password-input-inline' => $isInline ? 'true' : 'false',
        'data-ui-password-input-light' => $isLight ? 'true' : 'false',
    ]) }}
>
    {{-- ----------------------------------------------------------------------
        Label
        ---------------------------------------------------------------------- --}}

    @if (! is_null($resolvedLabel))
        <label for="{{ $resolvedId }}" @class($labelClasses)>
            @if ($resolvedLabel instanceof HtmlString)
                {!! $resolvedLabel !!}
            @else
                {{ $resolvedLabel }}
            @endif
        </label>
    @endif

    {{-- ----------------------------------------------------------------------
        Field
        ---------------------------------------------------------------------- --}}

    <div @class($fieldOuterWrapperClasses)>
        <div
            @class($fieldWrapperClasses)
            @if ($isInvalid) data-invalid="true" @endif
            data-ui-password-input-field-wrapper
        >
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

            <input
                id="{{ $resolvedId }}"
                type="{{ $resolvedType }}"
                @class($inputClasses)
                @if (filled($name)) name="{{ $name }}" @endif
                @if (! is_null($inputValue)) value="{{ $inputValue }}" @endif
                @if (! is_null($placeholder)) placeholder="{{ $placeholder }}" @endif
                @disabled($isDisabled)
                @readonly($isReadOnly)
                @required($isRequired)
                @if ($isInvalid) aria-invalid="true" @endif
                @if (filled($invalidId)) aria-errormessage="{{ $invalidId }}" @endif
                @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
                data-ui-password-input
                data-ui-password-input-state="{{ $stateValue }}"
                data-toggle-password-visibility="{{ $resolvedType === 'password' ? 'true' : 'false' }}"
                {{ $inputAttributes }}
            >

            <hr class="ui-text-input__divider">

            {{-- ------------------------------------------------------------------
                Password visibility toggle
                ------------------------------------------------------------------
                Both visibility icons are rendered up front so the installed
                password input JavaScript only needs to toggle input state,
                aria-pressed, labels, and icon visibility classes.
                ------------------------------------------------------------------ --}}

            <button
                type="button"
                @class($toggleClasses)
                @disabled($isDisabled)
                aria-label="{{ $toggleLabel }}"
                aria-pressed="{{ $passwordIsVisible ? 'true' : 'false' }}"
                data-ui-password-toggle
                data-ui-password-toggle-target="{{ $resolvedId }}"
                data-ui-password-show-label="{{ $showPasswordLabel }}"
                data-ui-password-hide-label="{{ $hidePasswordLabel }}"
            >
                <span class="ui-assistive-text">{{ $toggleLabel }}</span>

                <x-ui.icon
                    name="view"
                    class="ui-icon-visibility-on"
                    width="16"
                    height="16"
                    aria-hidden="true"
                    data-ui-password-icon="show"
                />

                <x-ui.icon
                    name="view--off"
                    class="ui-icon-visibility-off"
                    width="16"
                    height="16"
                    aria-hidden="true"
                    data-ui-password-icon="hide"
                />
            </button>
        </div>

        {{-- ------------------------------------------------------------------
            Validation, warning, and helper text
            ------------------------------------------------------------------ --}}

        @if ($showInvalid)
            <div
                id="{{ $invalidId }}"
                role="alert"
                class="ui-form-requirement"
                data-ui-password-input-validation
            >
                {{ $invalidText }}
            </div>
        @elseif ($showWarning)
            <div
                id="{{ $warningId }}"
                role="alert"
                class="ui-form-requirement"
                data-ui-password-input-validation
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