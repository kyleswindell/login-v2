{{-- ==========================================================================
    File: resources/views/components/ui/text-area/index.blade.php
    Purpose: Text Area form control component.

    Notes:
    - Emits the installed .ui-text-area selector contract.
    - Supports label, helper text, invalid, warning, read-only, disabled,
      rows, cols, counter, counter mode, light, hidden label, and decorator.
    - The native textarea remains the source of truth for form submission.
    - Helper, invalid, warning, and counter messages are associated through ARIA.
    - Text Area styles are handled by resources/css/components/text-area.css.
    ========================================================================== --}}

@props([
    'id' => null,
    'name' => null,
    'labelText' => null,
    'label' => null,
    'value' => null,
    'defaultValue' => null,
    'placeholder' => '',
    'disabled' => false,
    'readOnly' => false,
    'required' => false,
    'helperText' => null,
    'hideLabel' => false,
    'invalid' => false,
    'invalidText' => null,
    'warn' => false,
    'warnText' => null,
    'light' => false,
    'rows' => 4,
    'cols' => null,
    'enableCounter' => false,
    'maxCount' => null,
    'counterMode' => 'character',
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

    $allowedCounterModes = [
        'character',
        'word',
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

    $resolvedId = $id ?? 'ui-text-area-'.Str::uuid();
    $resolvedLabel = $labelText ?? $label;
    $resolvedDecorator = $decorator ?? $slug;

    $resolvedCounterMode = in_array($counterMode, $allowedCounterModes, true)
        ? $counterMode
        : 'character';

    $textareaValue = $value ?? $defaultValue ?? '';

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    |
    | Invalid state takes precedence over warning state. Helper text is hidden
    | when invalid or warning text is active.
    |
    */

    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $isReadOnly = filter_var($readOnly, FILTER_VALIDATE_BOOLEAN);
    $isRequired = filter_var($required, FILTER_VALIDATE_BOOLEAN);
    $isLight = filter_var($light, FILTER_VALIDATE_BOOLEAN);
    $isLabelHidden = filter_var($hideLabel, FILTER_VALIDATE_BOOLEAN);
    $hasCols = ! is_null($cols);

    $isInvalid = ! $isDisabled && filter_var($invalid, FILTER_VALIDATE_BOOLEAN);
    $isWarning = ! $isDisabled && ! $isInvalid && filter_var($warn, FILTER_VALIDATE_BOOLEAN);

    $showHelper = ! $isInvalid && ! $isWarning && filled($helperText);
    $showInvalid = $isInvalid && filled($invalidText);
    $showWarning = $isWarning && filled($warnText);

    /*
    |--------------------------------------------------------------------------
    | Counter State
    |--------------------------------------------------------------------------
    |
    | Installed JavaScript may update the counter and announcement as the
    | textarea value changes.
    |
    */

    $usesCounter = filter_var($enableCounter, FILTER_VALIDATE_BOOLEAN) && filled($maxCount);

    if ($resolvedCounterMode === 'word') {
        preg_match_all('/\p{L}+/u', (string) $textareaValue, $matches);
        $textCount = count($matches[0] ?? []);
    } else {
        $textCount = mb_strlen((string) $textareaValue);
    }

    $counterText = $usesCounter ? $textCount.'/'.$maxCount : null;

    $counterLimitText = $resolvedCounterMode === 'word'
        ? 'Word limit '.$maxCount
        : 'Character limit '.$maxCount;

    $counterAnnouncement = $usesCounter
        ? $textCount.' of '.$maxCount.' '.($resolvedCounterMode === 'word' ? 'words' : 'characters').' used'
        : null;

    /*
    |--------------------------------------------------------------------------
    | Message IDs and ARIA Wiring
    |--------------------------------------------------------------------------
    */

    $helperId = $showHelper ? $resolvedId.'-helper-text' : null;
    $invalidId = $showInvalid ? $resolvedId.'-error-msg' : null;
    $warningId = $showWarning ? $resolvedId.'-warn-msg' : null;
    $counterDescriptionId = $usesCounter ? $resolvedId.'-counter-desc' : null;

    $existingDescribedBy = $attributes->get('aria-describedby');

    $ariaDescribedBy = collect([
        $existingDescribedBy,
        $helperId,
        $invalidId,
        $warningId,
        $counterDescriptionId,
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
    | These classes must match resources/css/components/text-area.css and
    | shared form styles.
    |
    */

    $formItemClasses = [
        'ui-form-item',
    ];

    $labelClasses = [
        'ui-label',
        'ui-visually-hidden' => $isLabelHidden,
        'ui-label--disabled' => $isDisabled,
    ];

    $labelCounterClasses = [
        'ui-label',
        'ui-label--disabled' => $isDisabled,
        'ui-text-area__label-counter',
    ];

    $wrapperClasses = [
        'ui-text-area__wrapper',
        'ui-text-area__wrapper--cols' => $hasCols,
        'ui-text-area__wrapper--readonly' => $isReadOnly,
        'ui-text-area__wrapper--warn' => $isWarning,
        'ui-text-area__wrapper--decorator' => $hasDecorator,
    ];

    $textareaClasses = [
        'ui-text-area',
        'ui-text-area--light' => $isLight,
        'ui-text-area--invalid' => $isInvalid,
        'ui-text-area--warn' => $isWarning,
    ];

    $helperClasses = [
        'ui-form__helper-text',
        'ui-form__helper-text--disabled' => $isDisabled,
    ];

    $iconClasses = [
        'ui-text-area__invalid-icon',
        'ui-text-area__invalid-icon--warning' => $isWarning,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    |
    | Component classes are applied to the wrapper. Non-class attributes are
    | passed to the native textarea.
    |
    */

    $wrapperAttributes = $attributes->only('class');

    $textareaAttributes = $attributes->except([
        'class',
        'aria-describedby',
        'aria-errormessage',
        'value',
        'defaultValue',
        'default-value',
        'id',
        'name',
        'placeholder',
        'disabled',
        'readonly',
        'required',
        'rows',
        'cols',
        'maxlength',
    ]);
@endphp

<div
    {{ $wrapperAttributes->class($formItemClasses)->merge([
        'data-ui-component' => 'text-area',
        'data-ui-text-area-form-item' => true,
    ]) }}
>
    {{-- ----------------------------------------------------------------------
        Label and counter
        ----------------------------------------------------------------------
        Counter is rendered beside the label when enabled.
        ---------------------------------------------------------------------- --}}

    <div class="ui-text-area__label-wrapper">
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
                @class($labelCounterClasses)
                aria-hidden="true"
                data-ui-text-area-counter
            >
                {{ $counterText }}
            </div>
        @endif
    </div>

    @if ($usesCounter)
        <span id="{{ $counterDescriptionId }}" class="ui-visually-hidden">
            {{ $counterLimitText }}
        </span>
    @endif

    {{-- ----------------------------------------------------------------------
        Textarea wrapper
        ----------------------------------------------------------------------
        The wrapper owns invalid/warning visual state and optional decorator
        positioning.
        ---------------------------------------------------------------------- --}}

    <div
        @class($wrapperClasses)
        @if ($isInvalid) data-invalid="true" @endif
        data-ui-text-area-wrapper
        data-ui-text-area-state="{{ $isInvalid ? 'invalid' : ($isWarning ? 'warning' : 'default') }}"
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

        {{-- ------------------------------------------------------------------
            Native textarea
            ------------------------------------------------------------------
            Native textarea remains responsible for form value and submission.
            ------------------------------------------------------------------ --}}

        <textarea
            id="{{ $resolvedId }}"
            @class($textareaClasses)
            @if (filled($name)) name="{{ $name }}" @endif
            @if (! is_null($placeholder)) placeholder="{{ $placeholder }}" @endif
            @if ($usesCounter && $resolvedCounterMode === 'character') maxlength="{{ $maxCount }}" @endif
            @if (! is_null($rows)) rows="{{ $rows }}" @endif
            @if (! is_null($cols)) cols="{{ $cols }}" @endif
            @disabled($isDisabled)
            @readonly($isReadOnly)
            @required($isRequired)
            @if ($isReadOnly) aria-readonly="true" @endif
            @if ($isInvalid) aria-invalid="true" @endif
            @if (filled($invalidId)) aria-errormessage="{{ $invalidId }}" @endif
            @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
            data-ui-text-area
            data-ui-text-area-state="{{ $isInvalid ? 'invalid' : ($isWarning ? 'warning' : 'default') }}"
            @if ($usesCounter)
                data-ui-text-area-counter-input
                data-ui-text-area-counter-mode="{{ $resolvedCounterMode }}"
                data-ui-text-area-max-count="{{ $maxCount }}"
            @endif
            {{ $textareaAttributes }}
        >{{ $textareaValue }}</textarea>

        @if ($hasDecorator)
            <span class="ui-text-area__inner-wrapper--decorator">
                @if ($resolvedDecorator instanceof HtmlString)
                    {!! $resolvedDecorator !!}
                @else
                    {{ $resolvedDecorator }}
                @endif
            </span>
        @endif

        @if ($usesCounter)
            <span
                class="ui-text-area__counter-alert"
                role="alert"
                aria-live="assertive"
                aria-atomic="true"
                data-ui-text-area-counter-alert
            >
                {{ $counterAnnouncement }}
            </span>
        @endif
    </div>

    {{-- ----------------------------------------------------------------------
        Validation, warning, and helper text
        ----------------------------------------------------------------------
        Invalid text takes precedence over warning text. Helper text is only
        shown when invalid/warning text is not active.
        ---------------------------------------------------------------------- --}}

    @if ($showInvalid)
        <div
            id="{{ $invalidId }}"
            role="alert"
            class="ui-form-requirement"
            data-ui-text-area-validation
        >
            {{ $invalidText }}
        </div>
    @elseif ($showWarning)
        <div
            id="{{ $warningId }}"
            role="alert"
            class="ui-form-requirement"
            data-ui-text-area-validation
        >
            {{ $warnText }}
        </div>
    @elseif ($showHelper)
        <div id="{{ $helperId }}" @class($helperClasses)>
            {{ $helperText }}
        </div>
    @endif
</div>