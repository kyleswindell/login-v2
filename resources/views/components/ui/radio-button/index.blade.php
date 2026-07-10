{{-- ==========================================================================
    File: resources/views/components/ui/radio-button/index.blade.php
    Purpose: Radio Button form control component.

    Notes:
    - Emits the installed .ui-radio-button selector contract.
    - Supports checked/defaultChecked, disabled, read-only, required, invalid,
      warning, hidden label, label position, and decorator content.
    - The native input remains the source of truth for form submission.
    - Validation and warning messages are associated through aria-describedby.
    - Radio Button styles are handled by resources/css/components/radio-button.css.
    ========================================================================== --}}

@props([
    'id' => null,
    'name' => null,
    'value' => '',
    'labelText' => null,
    'label' => null,
    'checked' => false,
    'defaultChecked' => false,
    'disabled' => false,
    'readOnly' => false,
    'required' => false,
    'hideLabel' => false,
    'labelPosition' => 'right',
    'invalid' => false,
    'invalidText' => null,
    'warn' => false,
    'warnText' => null,
    'decorator' => null,
])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedLabelPositions = [
        'left',
        'right',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    |
    | `label` is retained as a shorter alias for `labelText`.
    |
    */

    $resolvedId = $id ?? 'ui-radio-button-'.Str::uuid();
    $resolvedLabel = $labelText ?? $label ?? '';
    $resolvedLabelPosition = in_array($labelPosition, $allowedLabelPositions, true)
        ? $labelPosition
        : 'right';

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    |
    | Invalid state takes precedence over warning state. Disabled controls do
    | not show invalid or warning treatment.
    |
    */

    $isChecked = (bool) $checked || (bool) $defaultChecked;
    $isDisabled = (bool) $disabled;
    $isReadOnly = (bool) $readOnly;
    $isRequired = (bool) $required;

    $isInvalid = ! $isDisabled && (bool) $invalid;
    $isWarning = ! $isDisabled && ! $isInvalid && (bool) $warn;

    /*
    |--------------------------------------------------------------------------
    | Message IDs and ARIA Wiring
    |--------------------------------------------------------------------------
    |
    | Validation and warning text are referenced by the native input.
    |
    */

    $validationId = null;

    if ($isInvalid && filled($invalidText)) {
        $validationId = $resolvedId.'-invalid-text';
    } elseif ($isWarning && filled($warnText)) {
        $validationId = $resolvedId.'-warning-text';
    }

    $existingDescribedBy = $attributes->get('aria-describedby');

    $ariaDescribedBy = collect([$existingDescribedBy, $validationId])
        ->filter()
        ->implode(' ');

    /*
    |--------------------------------------------------------------------------
    | Decorator Handling
    |--------------------------------------------------------------------------
    |
    | Decorator content is rendered beside the label, not inside it, so
    | interactive decorators such as toggletips do not become nested
    | interactive content inside a label.
    |
    */

    $hasDecorator = isset($decorator) && filled($decorator);

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    |
    | These classes must match resources/css/components/radio-button.css.
    |
    */

    $wrapperClasses = [
        'ui-radio-button-wrapper',
        'ui-radio-button-wrapper--label-left' => $resolvedLabelPosition === 'left',
        'ui-radio-button-wrapper--decorator' => $hasDecorator,
        'ui-radio-button-wrapper--invalid' => $isInvalid,
        'ui-radio-button-wrapper--warning' => $isWarning,
    ];

    $labelTextClasses = [
        'ui-radio-button__label-text',
        'ui-visually-hidden' => (bool) $hideLabel,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    |
    | Caller-provided classes are applied to the wrapper. State and ARIA
    | attributes are handled by the component so generated state can merge with
    | caller-provided attributes safely.
    |
    */

    $wrapperAttributes = $attributes->only('class');

    $inputAttributes = $attributes->except([
        'class',
        'aria-describedby',
        'checked',
        'disabled',
        'readonly',
        'required',
        'type',
        'id',
        'name',
        'value',
    ]);
@endphp

<div
    {{ $wrapperAttributes->class($wrapperClasses) }}
    data-ui-component="radio-button"
    data-ui-radio-button-wrapper
    data-ui-radio-button-state="{{ $isInvalid ? 'invalid' : ($isWarning ? 'warning' : 'default') }}"
>
    {{-- ----------------------------------------------------------------------
        Native radio input
        ----------------------------------------------------------------------
        The input remains visually hidden/styled by CSS but stays responsible
        for native form behavior and submission.
        ---------------------------------------------------------------------- --}}

    <input
        id="{{ $resolvedId }}"
        type="radio"
        class="ui-radio-button"
        value="{{ $value }}"
        @if (filled($name)) name="{{ $name }}" @endif
        @checked($isChecked)
        @disabled($isDisabled)
        @required($isRequired)
        @if ($isInvalid) aria-invalid="true" @endif
        @if ($isReadOnly) aria-readonly="true" data-ui-radio-button-readonly="true" @endif
        @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
        data-ui-radio-button
        {{ $inputAttributes }}
    >

    {{-- ----------------------------------------------------------------------
        Label and appearance
        ----------------------------------------------------------------------
        The label owns the visual radio appearance and visible label text.
        ---------------------------------------------------------------------- --}}

    <label for="{{ $resolvedId }}" class="ui-radio-button__label">
        <span class="ui-radio-button__appearance" aria-hidden="true"></span>

        @if (filled($resolvedLabel))
            <span @class($labelTextClasses)>
                @if ($resolvedLabel instanceof HtmlString)
                    {!! $resolvedLabel !!}
                @else
                    {{ $resolvedLabel }}
                @endif
            </span>
        @endif
    </label>

    @if ($hasDecorator)
        <span class="ui-radio-button-wrapper-inner--decorator">
            @if ($decorator instanceof HtmlString)
                {!! $decorator !!}
            @else
                {{ $decorator }}
            @endif
        </span>
    @endif

    {{-- ----------------------------------------------------------------------
        Validation and warning text
        ----------------------------------------------------------------------
        Invalid text takes precedence over warning text.
        ---------------------------------------------------------------------- --}}

    @if ($isInvalid && filled($invalidText))
        <div
            id="{{ $validationId }}"
            class="ui-form-requirement ui-radio-button__validation ui-radio-button__validation--invalid"
            data-ui-radio-button-validation
        >
            {{ $invalidText }}
        </div>
    @elseif ($isWarning && filled($warnText))
        <div
            id="{{ $validationId }}"
            class="ui-form-requirement ui-radio-button__validation ui-radio-button__validation--warning"
            data-ui-radio-button-validation
        >
            {{ $warnText }}
        </div>
    @endif
</div>