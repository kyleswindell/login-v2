{{-- ==========================================================================
    File: resources/views/components/ui/select/index.blade.php
    Purpose: Native Select form control component.

    Notes:
    - Emits the installed .ui-select selector contract.
    - Supports item-array options and slot-based option content.
    - Supports label, helper text, invalid, warning, read-only, disabled,
      inline layout, hidden label, no-label, light, size, and decorator.
    - The native select remains the source of truth for form submission.
    - Helper, invalid, and warning messages are associated through aria-describedby.
    - Select styles are handled by resources/css/components/select.css.
    ========================================================================== --}}

@props([
'items' => [],
'id' => null,
'name' => null,
'labelText' => 'Select',
'label' => null,
'value' => null,
'defaultValue' => null,
'disabled' => false,
'readOnly' => false,
'required' => false,
'helperText' => null,
'hideLabel' => false,
'noLabel' => false,
'inline' => false,
'invalid' => false,
'invalidText' => null,
'warn' => false,
'warnText' => null,
'light' => false,
'size' => null,
'decorator' => null,
'slug' => null,
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

$resolvedId = $id ?? 'ui-select-'.Str::uuid();
$resolvedLabel = $label ?? $labelText;
$resolvedSize = in_array($size, $allowedSizes, true) ? $size : null;
$resolvedDecorator = $slug ?? $decorator;
$selectedValue = $value ?? $defaultValue;

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
| Message IDs and ARIA wiring
|--------------------------------------------------------------------------
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
| Decorator handling
|--------------------------------------------------------------------------
*/

$hasDecorator = isset($resolvedDecorator) && filled($resolvedDecorator);

/*
|--------------------------------------------------------------------------
| CSS class contract
|--------------------------------------------------------------------------
|
| These classes must match resources/css/components/select.css and shared
| form styles.
|
*/

$formItemClasses = [
'ui-form-item',
];

$selectClasses = [
'ui-select',
'ui-select--inline' => $isInline,
'ui-select--light' => $isLight,
'ui-select--invalid' => $isInvalid,
'ui-select--disabled' => $isDisabled,
'ui-select--readonly' => $isReadOnly,
'ui-select--warning' => $isWarning,
'ui-select--decorator' => $hasDecorator,
'ui-select--'.$resolvedSize => filled($resolvedSize),
'ui-layout--size-'.$resolvedSize => filled($resolvedSize),
];

$labelClasses = [
'ui-label',
'ui-visually-hidden' => (bool) $hideLabel,
'ui-label--disabled' => $isDisabled,
];

$inputClasses = [
'ui-select-input',
];

$inputWrapperClasses = [
'ui-select-input__wrapper',
];

$helperClasses = [
'ui-form__helper-text',
'ui-form__helper-text--disabled' => $isDisabled,
];

$iconClasses = [
'ui-select__invalid-icon',
'ui-select__invalid-icon--warning' => $isWarning,
];

/*
|--------------------------------------------------------------------------
| Attribute handling
|--------------------------------------------------------------------------
|
| Component classes are applied to the form item wrapper. Non-class
| attributes are passed to the native select.
|
*/

$wrapperAttributes = $attributes->only('class');

$selectAttributes = $attributes->except([
'class',
'aria-describedby',
'value',
'defaultValue',
'default-value',
'id',
'name',
'disabled',
'readonly',
'required',
]);

/*
|--------------------------------------------------------------------------
| Slot detection
|--------------------------------------------------------------------------
*/

$hasSlotContent = trim($slot->toHtml()) !== '';
@endphp

<div
    {{ $wrapperAttributes->class($formItemClasses)->merge([
        'data-ui-component' => 'select',
        'data-ui-select-form-item' => true,
    ]) }}>
    <div
        @class($selectClasses)
        data-ui-select-wrapper
        data-ui-select-state="{{ $isInvalid ? 'invalid' : ($isWarning ? 'warning' : 'default') }}"
        @if ($isReadOnly) data-ui-select-readonly="true" @endif>
        {{-- ------------------------------------------------------------------
            Label
            ------------------------------------------------------------------
            noLabel is used when another component renders the select label.
            ------------------------------------------------------------------ --}}

        @unless ($noLabel)
        <label for="{{ $resolvedId }}" @class($labelClasses)>
            @if ($resolvedLabel instanceof HtmlString)
            {!! $resolvedLabel !!}
            @else
            {{ $resolvedLabel }}
            @endif
        </label>
        @endunless

        {{-- ------------------------------------------------------------------
            Native select field
            ------------------------------------------------------------------
            Native select remains responsible for value and form submission.
            ------------------------------------------------------------------ --}}

        <div
            @class($inputWrapperClasses)
            @if ($isInvalid) data-invalid="true" @endif
            data-ui-select-input-wrapper>
            <select
                id="{{ $resolvedId }}"
                @class($inputClasses)
                @if (filled($name)) name="{{ $name }}" @endif
                @disabled($isDisabled)
                @required($isRequired)
                @if ($isReadOnly) aria-readonly="true" data-ui-select-readonly-control="true" @endif
                @if ($isInvalid) aria-invalid="true" @endif
                @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
                data-ui-select-input
                {{ $selectAttributes }}>
                {{-- Item-array options. --}}
                @foreach ($items as $item)
                @php
                $isGroup = isset($item['options']) && is_array($item['options']);
                $itemHidden = (bool) ($item['hidden'] ?? false);
                @endphp

                @continue($itemHidden)

                @if ($isGroup)
                <optgroup
                    class="ui-select-optgroup"
                    label="{{ $item['label'] ?? '' }}"
                    @disabled($item['disabled'] ?? false)>
                    @foreach ($item['options'] as $option)
                    @php
                    $optionValue = $option['value'] ?? '';
                    $optionText = $option['text'] ?? $option['label'] ?? $optionValue;

                    $isSelected = ! is_null($selectedValue)
                    ? (string) $optionValue === (string) $selectedValue
                    : (bool) ($option['selected'] ?? false);
                    @endphp

                    @continue($option['hidden'] ?? false)

                    <option
                        value="{{ $optionValue }}"
                        @selected($isSelected)
                        @disabled($option['disabled'] ?? false)>
                        {{ $optionText }}
                    </option>
                    @endforeach
                </optgroup>
                @else
                @php
                $optionValue = $item['value'] ?? '';
                $optionText = $item['text'] ?? $item['label'] ?? $optionValue;

                $isSelected = ! is_null($selectedValue)
                ? (string) $optionValue === (string) $selectedValue
                : (bool) ($item['selected'] ?? false);
                @endphp

                <option
                    value="{{ $optionValue }}"
                    @selected($isSelected)
                    @disabled($item['disabled'] ?? false)>
                    {{ $optionText }}
                </option>
                @endif
                @endforeach

                {{-- Slot-based options. --}}
                @if ($hasSlotContent)
                {{ $slot }}
                @endif
            </select>

            <x-ui.icon name="chevron--down"
                class="ui-select__arrow"
                aria-hidden="true" />

            @if ($isInvalid)
            <x-ui.icon name="warning--filled"
                @class($iconClasses)
                aria-hidden="true" />
            @elseif ($isWarning)
            <x-ui.icon name="warning--alt"
                @class($iconClasses)
                aria-hidden="true" />
            @endif

            @if ($hasDecorator)
            <span class="ui-select__inner-wrapper--decorator">
                @if ($resolvedDecorator instanceof HtmlString)
                {!! $resolvedDecorator !!}
                @else
                {{ $resolvedDecorator }}
                @endif
            </span>
            @endif
        </div>

        {{-- ------------------------------------------------------------------
            Validation, warning, and helper text
            ------------------------------------------------------------------
            Invalid text takes precedence over warning text.
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