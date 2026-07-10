{{-- ==========================================================================
    File: resources/views/components/ui/checkbox/index.blade.php
    Purpose: Checkbox form control component.

    Notes:
    - Emits the installed .ui-checkbox selector contract.
    - Supports checked/defaultChecked, disabled, read-only, required,
      indeterminate, invalid, warning, helper text, hidden label, and decorator.
    - The native input remains the source of truth for form submission.
    - Validation, warning, and helper messages are associated through aria-describedby.
    - Indeterminate state is exposed through data attributes for installed JS.
    - Checkbox styles are handled by resources/css/components/checkbox.css.
    ========================================================================== --}}

@props([
    'id' => null,
    'name' => null,
    'value' => 'on',
    'labelText' => null,
    'label' => null,
    'checked' => false,
    'defaultChecked' => false,
    'disabled' => false,
    'readOnly' => false,
    'required' => false,
    'helperText' => null,
    'hideLabel' => false,
    'indeterminate' => false,
    'invalid' => false,
    'invalidText' => null,
    'warn' => false,
    'warnText' => null,
    'title' => '',
    'decorator' => null,
    'slug' => null,
])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    |
    | `label` is retained as a shorter alias for `labelText`.
    | `slug` is retained as a legacy alias for `decorator`.
    |
    */

    $resolvedId = $id ?? 'ui-checkbox-'.Str::uuid();
    $resolvedLabel = $labelText ?? $label ?? '';
    $resolvedDecorator = $decorator ?? $slug;

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    |
    | Invalid state takes precedence over warning state. Helper text is hidden
    | when invalid or warning text is active.
    |
    */

    $isChecked = (bool) $checked || (bool) $defaultChecked;
    $isDisabled = (bool) $disabled;
    $isReadOnly = (bool) $readOnly;
    $isRequired = (bool) $required;
    $isIndeterminate = (bool) $indeterminate;

    $isInvalid = ! $isDisabled && (bool) $invalid;
    $isWarning = ! $isDisabled && ! $isInvalid && (bool) $warn;

    $showHelper = ! $isInvalid && ! $isWarning && filled($helperText);
    $showInvalid = $isInvalid && filled($invalidText);
    $showWarning = $isWarning && filled($warnText);

    /*
    |--------------------------------------------------------------------------
    | Message IDs and ARIA Wiring
    |--------------------------------------------------------------------------
    |
    | Helper, invalid, and warning messages are referenced by the native input.
    |
    */

    $helperId = $showHelper ? $resolvedId.'-helper-text' : null;
    $invalidId = $showInvalid ? $resolvedId.'-invalid-text' : null;
    $warningId = $showWarning ? $resolvedId.'-warning-text' : null;

    $existingDescribedBy = $attributes->get('aria-describedby');

    $ariaDescribedBy = collect([$existingDescribedBy, $helperId, $invalidId, $warningId])
        ->filter()
        ->implode(' ');

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
    | These classes must match resources/css/components/checkbox.css and shared
    | form styles.
    |
    */

    $wrapperClasses = [
        'ui-form-item',
        'ui-checkbox-wrapper',
        'ui-checkbox-wrapper--readonly' => $isReadOnly,
        'ui-checkbox-wrapper--invalid' => $isInvalid,
        'ui-checkbox-wrapper--warning' => $isWarning,
        'ui-checkbox-wrapper--decorator' => $hasDecorator,
    ];

    $labelTextClasses = [
        'ui-checkbox-label-text',
        'ui-visually-hidden' => (bool) $hideLabel,
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
    | Caller-provided classes are applied to the wrapper. Non-class attributes
    | are passed to the native input.
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
    ]);
@endphp

<div
    {{ $wrapperAttributes->class($wrapperClasses) }}
    data-ui-component="checkbox"
    data-ui-checkbox-wrapper
    data-ui-checkbox-state="{{ $isInvalid ? 'invalid' : ($isWarning ? 'warning' : 'default') }}"
>
    {{-- ----------------------------------------------------------------------
        Native checkbox input
        ----------------------------------------------------------------------
        The input remains responsible for native form behavior and submission.
        Read-only and indeterminate behavior require installed checkbox JS.
        ---------------------------------------------------------------------- --}}

    <input
        id="{{ $resolvedId }}"
        type="checkbox"
        class="ui-checkbox"
        value="{{ $value }}"
        @if (filled($name)) name="{{ $name }}" @endif
        @checked($isChecked)
        @disabled($isDisabled)
        @required($isRequired)
        @if ($isInvalid) aria-invalid="true" data-invalid="true" @endif
        @if ($isReadOnly) aria-readonly="true" data-ui-checkbox-readonly="true" @endif
        @if ($isIndeterminate) aria-checked="mixed" data-ui-checkbox-indeterminate="true" @endif
        @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
        data-ui-checkbox
        {{ $inputAttributes }}
    >

    {{-- ----------------------------------------------------------------------
        Label
        ----------------------------------------------------------------------
        The label provides the visible control text. The optional decorator is
        rendered beside the label, not inside it, so interactive decorators such
        as toggletips do not become nested interactive content inside a label.
        ---------------------------------------------------------------------- --}}

    <label
        for="{{ $resolvedId }}"
        class="ui-checkbox-label"
        @if (filled($title)) title="{{ $title }}" @endif
    >
        <span @class($labelTextClasses)>
            @if ($resolvedLabel instanceof HtmlString)
                {!! $resolvedLabel !!}
            @else
                {{ $resolvedLabel }}
            @endif
        </span>
    </label>

    @if ($hasDecorator)
        <span class="ui-checkbox-wrapper-inner--decorator">
            @if ($resolvedDecorator instanceof HtmlString)
                {!! $resolvedDecorator !!}
            @else
                {{ $resolvedDecorator }}
            @endif
        </span>
    @endif

    {{-- ----------------------------------------------------------------------
        Validation and warning message
        ----------------------------------------------------------------------
        Invalid text takes precedence over warning text.
        ---------------------------------------------------------------------- --}}

    <div class="ui-checkbox__validation-msg">
        @if ($showInvalid)
            <x-ui.icon
                name="warning--filled"
                class="ui-checkbox__invalid-icon"
                aria-hidden="true"
            />

            <div id="{{ $invalidId }}" class="ui-form-requirement">
                {{ $invalidText }}
            </div>
        @elseif ($showWarning)
            <x-ui.icon
                name="warning--alt"
                class="ui-checkbox__invalid-icon ui-checkbox__invalid-icon--warning"
                aria-hidden="true"
            />

            <div id="{{ $warningId }}" class="ui-form-requirement">
                {{ $warnText }}
            </div>
        @endif
    </div>

    {{-- ----------------------------------------------------------------------
        Helper text
        ----------------------------------------------------------------------
        Helper text is shown only when invalid/warning text is not active.
        ---------------------------------------------------------------------- --}}

    @if ($showHelper)
        <div id="{{ $helperId }}" @class($helperClasses)>
            {{ $helperText }}
        </div>
    @endif
</div>