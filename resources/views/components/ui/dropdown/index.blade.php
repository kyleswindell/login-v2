{{-- ==========================================================================
    File: resources/views/components/ui/dropdown/index.blade.php
    Purpose: Custom Dropdown/ListBox select component.

    Notes:
    - Emits the installed .ui-dropdown and .ui-list-box selector contract.
    - Renders a button trigger, listbox menu, selectable options, and optional hidden input.
    - Supports label, helper text, invalid, warning, disabled, read-only, inline,
      light, size, direction, selected item, and decorator content.
    - Dropdown open/close, keyboard navigation, and item selection are handled by installed dropdown JavaScript.
    - Uses the unified x-ui.icon component for icons.
    - Dropdown styles are handled by resources/css/components/dropdown.css and list-box.css.
    ========================================================================== --}}

@props([
    'items' => [],
    'id' => null,
    'name' => null,
    'label' => null,
    'titleText' => null,
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
    'type' => 'default',
    'direction' => 'bottom',
    'open' => false,
    'selectedItem' => null,
    'initialSelectedItem' => null,
    'placeholder' => null,
    'ariaLabel' => null,
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

    $allowedTypes = [
        'default',
        'inline',
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
    | `titleText` is canonical field label text. `label` is retained as a
    | compatibility label/placeholder value. `slug` is retained as a legacy
    | alias for `decorator`.
    |
    */

    $resolvedId = $id ?? 'ui-dropdown-'.Str::uuid();
    $menuId = $resolvedId.'-menu';
    $labelId = $resolvedId.'-label';
    $buttonLabelId = $resolvedId.'-button-label';

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : null;

    $resolvedType = in_array($type, $allowedTypes, true)
        ? $type
        : 'default';

    $resolvedDirection = in_array($direction, $allowedDirections, true)
        ? $direction
        : 'bottom';

    $resolvedLabel = $titleText ?? $label;
    $resolvedPlaceholder = $placeholder ?? $label ?? 'Select an option';
    $resolvedDecorator = $decorator ?? $slug;

    /*
    |--------------------------------------------------------------------------
    | Boolean State
    |--------------------------------------------------------------------------
    */

    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $isReadOnly = filter_var($readOnly, FILTER_VALIDATE_BOOLEAN);
    $isInline = $resolvedType === 'inline';
    $isLight = filter_var($light, FILTER_VALIDATE_BOOLEAN);
    $isLabelHidden = filter_var($hideLabel, FILTER_VALIDATE_BOOLEAN);

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

    if (! is_null($selectedItem)) {
        $selectedValue = is_array($selectedItem)
            ? ($selectedItem['value'] ?? $selectedItem['label'] ?? $selectedItem['text'] ?? null)
            : $selectedItem;
    } elseif (! is_null($initialSelectedItem)) {
        $selectedValue = is_array($initialSelectedItem)
            ? ($initialSelectedItem['value'] ?? $initialSelectedItem['label'] ?? $initialSelectedItem['text'] ?? null)
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

    $displayLabel = $selectedLabel ?? $resolvedPlaceholder;
    $hasSelectedValue = ! is_null($selectedValue);

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
        'ui-dropdown__wrapper',
        'ui-list-box__wrapper',
        'ui-dropdown__wrapper--inline' => $isInline,
        'ui-list-box__wrapper--inline' => $isInline,
        'ui-dropdown__wrapper--inline--invalid' => $isInline && $isInvalid,
        'ui-list-box__wrapper--inline--invalid' => $isInline && $isInvalid,
        'ui-list-box__wrapper--decorator' => $hasDecorator,
    ];

    $labelClasses = [
        'ui-label',
        'ui-label--disabled' => $isDisabled,
        'ui-visually-hidden' => $isLabelHidden,
    ];

    $dropdownClasses = [
        'ui-dropdown',
        'ui-list-box',
        'ui-dropdown--invalid' => $isInvalid,
        'ui-dropdown--warning' => $isWarning,
        'ui-dropdown--open' => $isOpen,
        'ui-dropdown--inline' => $isInline,
        'ui-dropdown--disabled' => $isDisabled,
        'ui-dropdown--readonly' => $isReadOnly,
        'ui-dropdown--light' => $isLight,
        'ui-dropdown--'.$resolvedSize => filled($resolvedSize),
        'ui-list-box--'.$resolvedSize => filled($resolvedSize),
        'ui-list-box--up' => $resolvedDirection === 'top',
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
        'data-ui-component' => 'dropdown',
        'data-ui-dropdown-wrapper' => true,
        'data-ui-dropdown-state' => $stateValue,
        'data-ui-dropdown-size' => $resolvedSize,
    ]) }}
>
    {{-- ----------------------------------------------------------------------
        Label
        ---------------------------------------------------------------------- --}}

    @if (filled($resolvedLabel))
        <label id="{{ $labelId }}" @class($labelClasses)>
            @if ($resolvedLabel instanceof HtmlString)
                {!! $resolvedLabel !!}
            @else
                {{ $resolvedLabel }}
            @endif
        </label>
    @endif

    {{-- ----------------------------------------------------------------------
        Dropdown/ListBox Control
        ---------------------------------------------------------------------- --}}

    <div
        id="{{ $resolvedId }}"
        @class($dropdownClasses)
        @if ($isInvalid) data-invalid="true" @endif
        data-ui-dropdown
        data-ui-dropdown-open="{{ $isOpen ? 'true' : 'false' }}"
        data-ui-dropdown-direction="{{ $resolvedDirection }}"
        data-ui-dropdown-type="{{ $resolvedType }}"
        data-ui-dropdown-readonly="{{ $isReadOnly ? 'true' : 'false' }}"
        data-ui-dropdown-disabled="{{ $isDisabled ? 'true' : 'false' }}"
        data-ui-dropdown-has-value="{{ $hasSelectedValue ? 'true' : 'false' }}"
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

        <button
            type="button"
            @class($fieldClasses)
            role="combobox"
            aria-haspopup="listbox"
            aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
            aria-controls="{{ $menuId }}"
            @if (filled($ariaLabel)) aria-label="{{ $ariaLabel }}" @elseif (filled($resolvedLabel)) aria-labelledby="{{ $labelId }} {{ $buttonLabelId }}" @endif
            @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
            @if ($isInvalid) aria-invalid="true" @endif
            @if (filled($invalidId)) aria-errormessage="{{ $invalidId }}" @endif
            @if ($isReadOnly) aria-readonly="true" aria-disabled="true" @endif
            @disabled($isDisabled)
            title="{{ $displayLabel }}"
            data-ui-dropdown-trigger
        >
            <span
                id="{{ $buttonLabelId }}"
                class="ui-list-box__label"
                data-ui-dropdown-selected-label
            >
                {{ $displayLabel }}
            </span>

            <x-ui.icon
                name="chevron--down"
                class="ui-list-box__menu-icon"
                aria-hidden="true"
            />
        </button>

        @if ($hasDecorator)
            <span class="ui-list-box__inner-wrapper--decorator">
                @if ($resolvedDecorator instanceof HtmlString)
                    {!! $resolvedDecorator !!}
                @else
                    {{ $resolvedDecorator }}
                @endif
            </span>
        @endif

        <ul
            id="{{ $menuId }}"
            @class($menuClasses)
            role="listbox"
            tabindex="-1"
            data-ui-dropdown-menu
            data-ui-dropdown-menu-open="{{ $isOpen ? 'true' : 'false' }}"
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
                    data-ui-dropdown-option
                    data-ui-dropdown-option-index="{{ $index }}"
                    data-ui-dropdown-option-value="{{ $itemValue }}"
                    data-ui-dropdown-option-label="{{ $itemLabel }}"
                    data-ui-dropdown-option-selected="{{ $itemIsSelected ? 'true' : 'false' }}"
                    @if ($itemDisabled) data-ui-dropdown-option-disabled="true" @endif
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
                data-ui-dropdown-hidden-input
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
            data-ui-dropdown-validation
        >
            {{ $invalidText }}
        </div>
    @elseif ($showWarning)
        <div
            id="{{ $warningId }}"
            role="alert"
            class="ui-form-requirement"
            data-ui-dropdown-validation
        >
            {{ $warnText }}
        </div>
    @elseif ($showHelper)
        <div id="{{ $helperId }}" @class($helperClasses)>
            {{ $helperText }}
        </div>
    @endif
</div>