{{-- ==========================================================================
    File: resources/views/components/ui/text-input/index.blade.php
    Purpose: Text Input form control component.

    Notes:
    - Emits the installed .ui-text-input selector contract.
    - Supports label, helper text, invalid, warning, read-only, disabled,
      inline layout, size, counter, decorator, and optional status icon.
    - The native input remains the source of truth for form submission.
    - Helper, invalid, warning, and counter messages are associated through ARIA.
    - Text Input styles are handled by resources/css/components/text-input.css.
    ========================================================================== --}}

@props([
'id' => null,
'name' => null,
'type' => 'text',
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
'enableCounter' => false,
'maxCount' => null,
'decorator' => null,
'slug' => null,
'icon' => null,
])

@php
use Illuminate\Support\Str;
use Illuminate\Support\HtmlString;

/*
|--------------------------------------------------------------------------
| Supported public values
|--------------------------------------------------------------------------
*/

$allowedSizes = ['xs', 'sm', 'md', 'lg'];

/*
|--------------------------------------------------------------------------
| Resolve values
|--------------------------------------------------------------------------
|
| `label` is retained as a shorter alias for `labelText`.
| `slug` is retained as a legacy alias for `decorator`.
|
*/

$resolvedId = $id ?? 'ui-text-input-'.Str::uuid();
$resolvedLabel = $labelText ?? $label;
$resolvedSize = in_array($size, $allowedSizes, true) ? $size : null;
$resolvedDecorator = $slug ?? $decorator;
$inputValue = $value ?? $defaultValue;

/*
|--------------------------------------------------------------------------
| Render state
|--------------------------------------------------------------------------
|
| Invalid state takes precedence over warning state. Helper text is hidden
| when invalid or warning text is active.
|
*/

$isDisabled = (bool) $disabled;
$isReadOnly = (bool) $readOnly;
$isRequired = (bool) $required;
$isInline = (bool) $inline;
$isLight = (bool) $light;

$isInvalid = ! $isDisabled && (bool) $invalid;
$isWarning = ! $isDisabled && ! $isInvalid && (bool) $warn;

$showHelper = ! $isInvalid && ! $isWarning && filled($helperText);
$showInvalid = $isInvalid && filled($invalidText);
$showWarning = $isWarning && filled($warnText);

/*
|--------------------------------------------------------------------------
| Counter state
|--------------------------------------------------------------------------
|
| Installed JavaScript may update the counter and announcement as the
| input value changes.
|
*/

$usesCounter = (bool) $enableCounter && filled($maxCount);
$textCount = strlen((string) ($inputValue ?? ''));
$counterText = $usesCounter ? $textCount.'/'.$maxCount : null;
$counterAnnouncement = $usesCounter ? $textCount.' of '.$maxCount.' characters used' : null;

/*
|--------------------------------------------------------------------------
| Message IDs and ARIA wiring
|--------------------------------------------------------------------------
*/

$helperId = $showHelper ? $resolvedId.'-helper-text' : null;
$invalidId = $showInvalid ? $resolvedId.'-invalid-text' : null;
$warningId = $showWarning ? $resolvedId.'-warning-text' : null;
$counterId = $usesCounter ? $resolvedId.'-counter' : null;

$existingDescribedBy = $attributes->get('aria-describedby');

$ariaDescribedBy = collect([$existingDescribedBy, $helperId, $invalidId, $warningId, $counterId])
->filter()
->implode(' ');

/*
|--------------------------------------------------------------------------
| Decorator handling
|--------------------------------------------------------------------------
*/

$hasDecorator = isset($resolvedDecorator) && filled($resolvedDecorator);

/*
|--------------------------------------------------------------------------
| CSS class contract
|--------------------------------------------------------------------------
|
| These classes must match resources/css/components/text-input.css and
| shared form styles.
|
*/

$wrapperClasses = [
'ui-form-item',
'ui-text-input-wrapper',
'ui-text-input-wrapper--readonly' => $isReadOnly,
'ui-text-input-wrapper--light' => $isLight,
'ui-text-input-wrapper--inline' => $isInline,
'ui-text-input-wrapper--inline--invalid' => $isInline && $isInvalid,
];

$labelClasses = [
'ui-label',
'ui-visually-hidden' => (bool) $hideLabel,
'ui-label--disabled' => $isDisabled,
'ui-label--inline' => $isInline,
'ui-label--inline--'.$resolvedSize => $isInline && filled($resolvedSize),
];

$inputClasses = [
'ui-text-input',
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
'ui-text-input__field-wrapper--decorator' => $hasDecorator,
];

$iconClasses = [
'ui-text-input__invalid-icon' => $isInvalid || $isWarning,
'ui-text-input__invalid-icon--warning' => $isWarning,
];

$counterClasses = [
'ui-label',
'ui-label--disabled' => $isDisabled,
'ui-text-input__label-counter',
];

/*
|--------------------------------------------------------------------------
| Attribute handling
|--------------------------------------------------------------------------
|
| Component classes are applied to the wrapper. Non-class attributes are
| passed to the native input.
|
*/

$wrapperAttributes = $attributes->only('class');

$inputAttributes = $attributes->except([
'class',
'aria-describedby',
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
'maxlength',
]);
@endphp

<div
    {{ $wrapperAttributes->class($wrapperClasses)->merge([
        'data-ui-component' => 'text-input',
        'data-ui-text-input-wrapper' => true,
        'data-ui-text-input-state' => $isInvalid ? 'invalid' : ($isWarning ? 'warning' : 'default'),
    ]) }}>
    {{-- ----------------------------------------------------------------------
        Label and counter
        ----------------------------------------------------------------------
        Counter is rendered beside the label when enabled.
        ---------------------------------------------------------------------- --}}

    <div class="ui-text-input__label-wrapper">
        @if (! is_null($resolvedLabel))
        <label for="{{ $resolvedId }}" @class($labelClasses)>
            @if ($resolvedLabel instanceof HtmlString)
            {!! $resolvedLabel !!}
            @else
            {{ $resolvedLabel }}
            @endif
        </label>
        @endif

        @if ($usesCounter)
        <div
            id="{{ $counterId }}"
            @class($counterClasses)
            data-ui-text-input-counter>
            {{ $counterText }}
        </div>
        @endif
    </div>

    {{-- ----------------------------------------------------------------------
        Field
        ----------------------------------------------------------------------
        Native input remains responsible for form value and submission.
        ---------------------------------------------------------------------- --}}

    <div @class($fieldOuterWrapperClasses)>
        <div
            @class($fieldWrapperClasses)
            @if ($isInvalid) data-invalid="true" @endif>
            <input
                id="{{ $resolvedId }}"
                type="{{ $type }}"
                @class($inputClasses)
                @if (filled($name)) name="{{ $name }}" @endif
                @if (! is_null($inputValue)) value="{{ $inputValue }}" @endif
                @if (! is_null($placeholder)) placeholder="{{ $placeholder }}" title="{{ $placeholder }}" @endif
                @if ($usesCounter) maxlength="{{ $maxCount }}" @endif
                @disabled($isDisabled)
                @readonly($isReadOnly)
                @required($isRequired)
                @if ($isInvalid) aria-invalid="true" @endif
                @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
                data-ui-text-input
                @if ($usesCounter) data-ui-text-input-counter-input data-ui-text-input-max-count="{{ $maxCount }}" @endif
                {{ $inputAttributes }}>

            @if ($isInvalid)
            <x-ui.icon name="warning--filled"
                @class($iconClasses)
                aria-hidden="true" />
            @elseif ($isWarning)
            <x-ui.icon name="warning--alt"
                @class($iconClasses)
                aria-hidden="true" />
            @elseif (filled($icon))
            <x-ui.icon
                :name="$icon"
                class="ui-text-input__icon"
                aria-hidden="true" />
            @endif

            @if ($hasDecorator)
            <span class="ui-text-input__field-inner-wrapper--decorator">
                @if ($resolvedDecorator instanceof HtmlString)
                {!! $resolvedDecorator !!}
                @else
                {{ $resolvedDecorator }}
                @endif
            </span>
            @endif

            @if ($usesCounter)
            <span
                class="ui-text-input__counter-alert"
                role="alert"
                aria-live="assertive"
                aria-atomic="true"
                data-ui-text-input-counter-alert>
                {{ $counterAnnouncement }}
            </span>
            @endif
        </div>

        {{-- ------------------------------------------------------------------
            Validation, warning, and helper text
            ------------------------------------------------------------------
            Invalid text takes precedence over warning text. Helper text is only
            shown when invalid/warning text is not active.
            ------------------------------------------------------------------ --}}

        @if ($showInvalid)
        <div id="{{ $invalidId }}" class="ui-form-requirement">
            {{ $invalidText }}
        </div>
        @elseif ($showWarning)
        <div id="{{ $warningId }}" class="ui-form-requirement">
            {{ $warnText }}
        </div>
        @elseif ($showHelper)
        <div id="{{ $helperId }}" @class($helperClasses)>
            {{ $helperText }}
        </div>
        @endif
    </div>
</div>
