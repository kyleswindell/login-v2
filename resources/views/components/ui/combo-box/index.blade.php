{{-- ==========================================================================
    File: resources/views/components/ui/combo-box/index.blade.php
    Purpose: ComboBox/ListBox autocomplete form control component.

    Notes:
    - Emits the installed .ui-combo-box and .ui-list-box selector contract.
    - Renders an editable input, menu trigger, selectable options, and optional hidden input.
    - Supports helper text, invalid, warning, disabled, read-only, light, size,
      direction, selected item, initial selected item, typeahead, custom values,
      and decorator content.
    - ComboBox open/close, filtering, keyboard navigation, clearing, and selection
      are handled by installed ComboBox JavaScript.
    - Uses the unified x-ui.icon component for icons.
    - ComboBox styles are handled by resources/css/components/combo-box.css and list-box.css.
    ========================================================================== --}}

@props([
    'items' => [],
    'id' => null,
    'name' => null,
    'titleText' => null,
    'label' => null,
    'helperText' => null,
    'invalid' => false,
    'invalidText' => null,
    'warn' => false,
    'warnText' => null,
    'disabled' => false,
    'readOnly' => false,
    'hideLabel' => false,
    'light' => false,
    'size' => null,
    'direction' => 'bottom',
    'open' => false,
    'selectedItem' => null,
    'initialSelectedItem' => null,
    'placeholder' => null,
    'ariaLabel' => 'Choose an item',
    'allowCustomValue' => false,
    'typeahead' => false,
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

    $allowedSizes = [
        'xs',
        'sm',
        'md',
        'lg',
    ];

    $allowedDirections = [
        'top',
        'bottom',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    |
    | `titleText` is canonical label text. `label` is retained as a shorter
    | compatibility alias. `slug` is retained as a legacy alias for decorator.
    |
    */

    $resolvedId = $id ?? 'ui-combo-box-'.Str::uuid();
    $menuId = $resolvedId.'-menu';
    $labelId = $resolvedId.'-label';

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : null;

    $resolvedDirection = in_array($direction, $allowedDirections, true)
        ? $direction
        : 'bottom';

    $resolvedLabel = $titleText ?? $label;
    $resolvedDecorator = $decorator ?? $slug;

    /*
    |--------------------------------------------------------------------------
    | Boolean State
    |--------------------------------------------------------------------------
    */

    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $isReadOnly = filter_var($readOnly, FILTER_VALIDATE_BOOLEAN);
    $isLight = filter_var($light, FILTER_VALIDATE_BOOLEAN);
    $isLabelHidden = filter_var($hideLabel, FILTER_VALIDATE_BOOLEAN);
    $allowsCustomValue = filter_var($allowCustomValue, FILTER_VALIDATE_BOOLEAN);
    $usesTypeahead = filter_var($typeahead, FILTER_VALIDATE_BOOLEAN);

    $isOpen = filter_var($open, FILTER_VALIDATE_BOOLEAN) && ! $isDisabled && ! $isReadOnly;

    $isInvalid = ! $isDisabled && filter_var($invalid, FILTER_VALIDATE_BOOLEAN);
    $isWarning = ! $isDisabled && ! $isInvalid && filter_var($warn, FILTER_VALIDATE_BOOLEAN);

    $stateValue = $isInvalid ? 'invalid' : ($isWarning ? 'warning' : 'default');

    /*
    |--------------------------------------------------------------------------
    | Item Normalization
    |--------------------------------------------------------------------------
    |
    | Items may be strings or arrays. Arrays support value, label/text, disabled,
    | hidden, and selected.
    |
    */

    $visibleItems = collect($items)->reject(function ($item) {
        return is_array($item) && ($item['hidden'] ?? false);
    })->values();

    $selectedValue = null;
    $selectedLabel = null;
    $selectedFallbackLabel = null;

    if (! is_null($selectedItem)) {
        $selectedValue = is_array($selectedItem)
            ? ($selectedItem['value'] ?? $selectedItem['label'] ?? $selectedItem['text'] ?? null)
            : $selectedItem;

        $selectedFallbackLabel = is_array($selectedItem)
            ? ($selectedItem['label'] ?? $selectedItem['text'] ?? $selectedValue)
            : $selectedItem;
    } elseif (! is_null($initialSelectedItem)) {
        $selectedValue = is_array($initialSelectedItem)
            ? ($initialSelectedItem['value'] ?? $initialSelectedItem['label'] ?? $initialSelectedItem['text'] ?? null)
            : $initialSelectedItem;

        $selectedFallbackLabel = is_array($initialSelectedItem)
            ? ($initialSelectedItem['label'] ?? $initialSelectedItem['text'] ?? $selectedValue)
            : $initialSelectedItem;
    }

    foreach ($visibleItems as $item) {
        $itemValue = is_array($item) ? ($item['value'] ?? $item['label'] ?? $item['text'] ?? '') : $item;
        $itemLabel = is_array($item) ? ($item['label'] ?? $item['text'] ?? $itemValue) : $item;

        if (
            (is_array($item) && ($item['selected'] ?? false))
            || (! is_null($selectedValue) && (string) $itemValue === (string) $selectedValue)
        ) {
            $selectedValue = $itemValue;
            $selectedLabel = $itemLabel;
            break;
        }
    }

    $inputValue = $selectedLabel ?? ($allowsCustomValue ? $selectedFallbackLabel : null) ?? '';
    $hasValue = filled($inputValue);

    /*
    |--------------------------------------------------------------------------
    | Message IDs and ARIA Wiring
    |--------------------------------------------------------------------------
    */

    $showHelper = ! $isInvalid && ! $isWarning && filled($helperText);
    $showInvalid = $isInvalid && filled($invalidText);
    $showWarning = $isWarning && filled($warnText);

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
    */

    $wrapperClasses = [
        'ui-list-box__wrapper',
        'ui-list-box__wrapper--decorator' => $hasDecorator,
    ];

    $labelClasses = [
        'ui-label',
        'ui-label--disabled' => $isDisabled,
        'ui-visually-hidden' => $isLabelHidden,
    ];

    $comboBoxClasses = [
        'ui-combo-box',
        'ui-list-box',
        'ui-combo-box--warning' => $isWarning,
        'ui-combo-box--readonly' => $isReadOnly,
        'ui-list-box--up' => $resolvedDirection === 'top',
        'ui-list-box--'.$resolvedSize => filled($resolvedSize),
        'ui-list-box--disabled' => $isDisabled,
        'ui-list-box--light' => $isLight,
        'ui-list-box--expanded' => $isOpen,
    ];

    $inputClasses = [
        'ui-text-input',
        'ui-text-input--empty' => ! $hasValue,
        'ui-combo-box--input',
    ];

    $fieldClasses = [
        'ui-list-box__field',
    ];

    $menuClasses = [
        'ui-list-box__menu',
    ];

    $helperClasses = [
        'ui-form__helper-text',
        'ui-form__helper-text--disabled' => $isDisabled,
    ];

    $iconClasses = [
        'ui-list-box__invalid-icon',
        'ui-list-box__invalid-icon--warning' => $isWarning,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    */

    $wrapperAttributes = $attributes->except([
        'aria-describedby',
    ]);
@endphp

<div
    {{ $wrapperAttributes->class($wrapperClasses)->merge([
        'data-ui-component' => 'combo-box',
        'data-ui-combo-box-wrapper' => true,
        'data-ui-combo-box-state' => $stateValue,
        'data-ui-combo-box-size' => $resolvedSize,
    ]) }}
>
    {{-- ----------------------------------------------------------------------
        Label
        ---------------------------------------------------------------------- --}}

    @if (filled($resolvedLabel))
        <label id="{{ $labelId }}" for="{{ $resolvedId }}" @class($labelClasses)>
            @if ($resolvedLabel instanceof HtmlString)
                {!! $resolvedLabel !!}
            @else
                {{ $resolvedLabel }}
            @endif
        </label>
    @endif

    {{-- ----------------------------------------------------------------------
        ComboBox/ListBox Control
        ---------------------------------------------------------------------- --}}

    <div
        @class($comboBoxClasses)
        @if ($isInvalid) data-invalid="true" @endif
        data-ui-combo-box
        data-ui-combo-box-open="{{ $isOpen ? 'true' : 'false' }}"
        data-ui-combo-box-direction="{{ $resolvedDirection }}"
        data-ui-combo-box-allow-custom-value="{{ $allowsCustomValue ? 'true' : 'false' }}"
        data-ui-combo-box-typeahead="{{ $usesTypeahead ? 'true' : 'false' }}"
        data-ui-combo-box-readonly="{{ $isReadOnly ? 'true' : 'false' }}"
        data-ui-combo-box-disabled="{{ $isDisabled ? 'true' : 'false' }}"
    >
        <div @class($fieldClasses) data-ui-combo-box-field>
            {{-- ------------------------------------------------------------------
                Editable input
                ------------------------------------------------------------------
                The input is the combobox text entry and owns listbox ARIA.
                ------------------------------------------------------------------ --}}

            <input
                id="{{ $resolvedId }}"
                type="text"
                role="combobox"
                @class($inputClasses)
                value="{{ $inputValue }}"
                @if (! is_null($placeholder)) placeholder="{{ $placeholder }}" @endif
                @if (filled($resolvedLabel)) aria-labelledby="{{ $labelId }}" @else aria-label="{{ $ariaLabel }}" @endif
                aria-haspopup="listbox"
                aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
                aria-controls="{{ $menuId }}"
                autocomplete="off"
                @if ($isInvalid) aria-invalid="true" @endif
                @if (filled($invalidId)) aria-errormessage="{{ $invalidId }}" @endif
                @if ($isReadOnly) aria-readonly="true" @endif
                @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
                @disabled($isDisabled)
                @readonly($isReadOnly)
                title="{{ $inputValue }}"
                data-ui-combo-box-input
                data-ui-combo-box-input-state="{{ $stateValue }}"
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
                Clear Selection
                ------------------------------------------------------------------
                Hidden when there is no current value.
                ------------------------------------------------------------------ --}}

            <button
                type="button"
                class="ui-list-box__selection"
                aria-label="Clear selected item"
                @disabled($isDisabled || $isReadOnly)
                data-ui-combo-box-clear
                @unless ($hasValue) hidden @endunless
            >
                <x-ui.icon
                    name="close"
                    class="ui-list-box__selection-icon"
                    aria-hidden="true"
                />
            </button>

            {{-- ------------------------------------------------------------------
                Menu Trigger
                ------------------------------------------------------------------ --}}

            <button
                type="button"
                class="ui-list-box__menu-icon"
                aria-label="{{ $isOpen ? 'Close menu' : 'Open menu' }}"
                aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
                aria-controls="{{ $menuId }}"
                @disabled($isDisabled || $isReadOnly)
                data-ui-combo-box-trigger
            >
                <x-ui.icon
                    name="chevron--down"
                    class="ui-list-box__menu-icon-svg"
                    aria-hidden="true"
                />
            </button>
        </div>

        @if ($hasDecorator)
            <span class="ui-list-box__inner-wrapper--decorator">
                @if ($resolvedDecorator instanceof HtmlString)
                    {!! $resolvedDecorator !!}
                @else
                    {{ $resolvedDecorator }}
                @endif
            </span>
        @endif

        {{-- ----------------------------------------------------------------------
            Option Menu
            ---------------------------------------------------------------------- --}}

        <ul
            id="{{ $menuId }}"
            @class($menuClasses)
            role="listbox"
            data-ui-combo-box-menu
            data-ui-combo-box-menu-open="{{ $isOpen ? 'true' : 'false' }}"
            @if (! $isOpen) hidden @endif
        >
            @foreach ($visibleItems as $index => $item)
                @php
                    $itemValue = is_array($item) ? ($item['value'] ?? $item['label'] ?? $item['text'] ?? '') : $item;
                    $itemLabel = is_array($item) ? ($item['label'] ?? $item['text'] ?? $itemValue) : $item;
                    $itemDisabled = is_array($item) && filter_var($item['disabled'] ?? false, FILTER_VALIDATE_BOOLEAN);
                    $itemIsSelected = ! is_null($selectedValue) && (string) $itemValue === (string) $selectedValue;

                    $itemId = $resolvedId.'-option-'.$index;
                @endphp

                <li
                    id="{{ $itemId }}"
                    class="ui-list-box__menu-item"
                    role="option"
                    aria-selected="{{ $itemIsSelected ? 'true' : 'false' }}"
                    @if ($itemDisabled) aria-disabled="true" @endif
                    title="{{ $itemLabel }}"
                    data-ui-combo-box-option
                    data-ui-combo-box-option-index="{{ $index }}"
                    data-ui-combo-box-option-value="{{ $itemValue }}"
                    data-ui-combo-box-option-label="{{ $itemLabel }}"
                    data-ui-combo-box-option-selected="{{ $itemIsSelected ? 'true' : 'false' }}"
                    @if ($itemDisabled) data-ui-combo-box-option-disabled="true" @endif
                >
                    <span class="ui-list-box__menu-item__option">
                        {{ $itemLabel }}
                    </span>

                    @if ($itemIsSelected)
                        <x-ui.icon
                            name="checkmark"
                            class="ui-list-box__menu-item__selected-icon"
                            aria-hidden="true"
                        />
                    @endif
                </li>
            @endforeach
        </ul>

        @if (filled($name))
            <input
                type="hidden"
                name="{{ $name }}"
                value="{{ $selectedValue }}"
                data-ui-combo-box-hidden-input
            >
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
            data-ui-combo-box-validation
        >
            {{ $invalidText }}
        </div>
    @elseif ($showWarning)
        <div
            id="{{ $warningId }}"
            role="alert"
            class="ui-form-requirement"
            data-ui-combo-box-validation
        >
            {{ $warnText }}
        </div>
    @elseif ($showHelper)
        <div id="{{ $helperId }}" @class($helperClasses)>
            {{ $helperText }}
        </div>
    @endif
</div>