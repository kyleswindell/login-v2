{{-- ==========================================================================
    File: resources/views/components/ui/toggle/index.blade.php
    Purpose: Toggle form control component.

    Notes:
    - Emits the installed .ui-switch selector contract.
    - Supports checked/defaultChecked, toggled/defaultToggled aliases,
      disabled, read-only, required, helper text, hidden label, and form value.
    - The native checkbox input remains the source of truth for form submission.
    - The input exposes switch semantics through role="switch" and aria-checked.
    - Helper text is associated through aria-describedby.
    - Toggle styles are handled by resources/css/components/toggle.css.
    ========================================================================== --}}

@props([
    'name',
    'id' => null,
    'value' => '1',
    'labelText' => null,
    'label' => null,
    'checked' => false,
    'defaultChecked' => false,
    'toggled' => null,
    'defaultToggled' => false,
    'disabled' => false,
    'readOnly' => null,
    'readonly' => false,
    'required' => false,
    'helperText' => null,
    'helper' => null,
    'hideLabel' => false,
])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Boolean Helper
    |--------------------------------------------------------------------------
    */

    $asBool = static fn (mixed $value): bool => filter_var($value, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    |
    | `label` is retained as a shorter alias for `labelText`.
    | `helper` is retained as a shorter alias for `helperText`.
    | `readonly` is retained as a legacy alias for `readOnly`.
    | `toggled` and `defaultToggled` are retained for Carbon-style compatibility.
    |
    */

    $toggleId = $id ?? 'ui-toggle-'.Str::slug((string) $name);
    $resolvedLabel = $labelText ?? $label ?? '';
    $resolvedHelper = $helperText ?? $helper;
    $resolvedReadOnly = ! is_null($readOnly) ? $readOnly : $readonly;

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isChecked = ! is_null($toggled)
        ? $asBool($toggled)
        : $asBool($checked) || $asBool($defaultChecked) || $asBool($defaultToggled);

    $isDisabled = $asBool($disabled);
    $isReadOnly = $asBool($resolvedReadOnly);
    $isRequired = $asBool($required);

    /*
    |--------------------------------------------------------------------------
    | Message IDs and ARIA Wiring
    |--------------------------------------------------------------------------
    */

    $helperId = filled($resolvedHelper) ? $toggleId.'-helper-text' : null;

    $existingDescribedBy = $attributes->get('aria-describedby');

    $ariaDescribedBy = collect([$existingDescribedBy, $helperId])
        ->filter()
        ->implode(' ');

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    |
    | These classes must match resources/css/components/toggle.css.
    |
    */

    $wrapperClasses = [
        'ui-switch',
    ];

    $labelClasses = [
        'ui-control-label',
        'ui-visually-hidden' => $asBool($hideLabel),
    ];

    $helperClasses = [
        'ui-control-copy',
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    |
    | Caller-provided classes are applied to the wrapper. Non-class attributes
    | are passed to the native checkbox input.
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
        'role',
        'type',
        'id',
        'name',
        'value',
    ]);
@endphp

<label
    for="{{ $toggleId }}"
    {{ $wrapperAttributes->class($wrapperClasses) }}
    data-ui-component="toggle"
    data-ui-toggle-wrapper
    data-ui-toggle-state="{{ $isChecked ? 'on' : 'off' }}"
    @if ($isReadOnly) data-ui-toggle-readonly="true" @endif
>
    {{-- ----------------------------------------------------------------------
        Native switch input
        ----------------------------------------------------------------------
        The native checkbox input remains responsible for form behavior and
        submission while exposing switch semantics to assistive technology.
        ---------------------------------------------------------------------- --}}

    <input
        id="{{ $toggleId }}"
        name="{{ $name }}"
        type="checkbox"
        value="{{ $value }}"
        class="ui-switch-input"
        role="switch"
        aria-checked="{{ $isChecked ? 'true' : 'false' }}"
        @checked($isChecked)
        @disabled($isDisabled)
        @required($isRequired)
        @if ($isReadOnly) aria-readonly="true" onclick="return false;" @endif
        @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
        data-ui-toggle
        {{ $inputAttributes }}
    >

    {{-- ----------------------------------------------------------------------
        Visual switch
        ----------------------------------------------------------------------
        Track and thumb are decorative. State is owned by the native input.
        ---------------------------------------------------------------------- --}}

    <span class="ui-switch-track" aria-hidden="true"></span>
    <span class="ui-switch-thumb" aria-hidden="true"></span>

    {{-- ----------------------------------------------------------------------
        Label and helper text
        ----------------------------------------------------------------------
        The label text is visible by default and can be visually hidden when
        another nearby label owns the visible context.
        ---------------------------------------------------------------------- --}}

    <span @class($labelClasses)>
        @if ($resolvedLabel instanceof HtmlString)
            {!! $resolvedLabel !!}
        @else
            {{ $resolvedLabel }}
        @endif
    </span>

    @if (filled($resolvedHelper))
        <span id="{{ $helperId }}" @class($helperClasses)>
            @if ($resolvedHelper instanceof HtmlString)
                {!! $resolvedHelper !!}
            @else
                {{ $resolvedHelper }}
            @endif
        </span>
    @endif
</label>