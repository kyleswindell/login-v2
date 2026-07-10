{{-- ==========================================================================
    File: resources/views/components/ui/filterable-multi-select/index.blade.php
    Purpose: Filterable MultiSelect/ListBox form control component.

    Notes:
    - Emits the installed .ui-multi-select--filterable selector contract.
    - Renders a text input, selected-count affordance, menu trigger, option menu,
      and hidden inputs for submitted selected values.
    - Supports filtering, selected items, select-all item, helper text, invalid,
      warning, disabled, read-only, inline, light, size, direction, and decorator.
    - Filtering, open/close, keyboard navigation, selection, selected-count, and
      hidden input sync are handled by installed MultiSelect JavaScript.
    - Uses the unified x-ui.icon component for icons.
    ========================================================================== --}}

@props([
    'items' => [],
    'id' => null,
    'name' => null,
    'label' => null,
    'placeholder' => null,
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
    'selectedItems' => [],
    'initialSelectedItems' => [],
    'selectionFeedback' => 'top-after-reopen',
    'clearSelectionDescription' => 'Total items selected:',
    'clearSelectionText' => 'To clear selection, press Delete or Backspace',
    'selectAll' => false,
    'selectAllLabel' => 'Select all',
    'useTitleInItem' => false,
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

    $allowedSelectionFeedback = [
        'fixed',
        'top',
        'top-after-reopen',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    |
    | `titleText` is the field label. `label` is retained as the filter input
    | label/placeholder fallback. `slug` is retained as a legacy alias for
    | `decorator`.
    |
    */

    $resolvedId = $id ?? 'ui-filterable-multi-select-'.Str::uuid();
    $menuId = $resolvedId.'-menu';
    $labelId = $resolvedId.'-label';
    $inputId = $resolvedId.'-input';
    $clearDescriptionId = $resolvedId.'-clear-description';

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : null;

    $resolvedType = in_array($type, $allowedTypes, true)
        ? $type
        : 'default';

    $resolvedDirection = in_array($direction, $allowedDirections, true)
        ? $direction
        : 'bottom';

    $resolvedSelectionFeedback = in_array($selectionFeedback, $allowedSelectionFeedback, true)
        ? $selectionFeedback
        : 'top-after-reopen';

    $resolvedDecorator = $decorator ?? $slug;
    $resolvedInputLabel = $label ?? $placeholder ?? 'Filter options';
    $resolvedPlaceholder = $placeholder ?? $label ?? 'Filter options';

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
    $hasSelectAll = filter_var($selectAll, FILTER_VALIDATE_BOOLEAN);
    $usesTitleInItem = filter_var($useTitleInItem, FILTER_VALIDATE_BOOLEAN);

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
    | hidden, selected, and selectAll.
    |
    */

    $rawItems = collect($items)
        ->reject(fn ($item) => is_array($item) && ($item['hidden'] ?? false))
        ->values();

    if ($hasSelectAll) {
        $rawItems = collect([[
            'value' => '__select_all__',
            'label' => $selectAllLabel,
            'selectAll' => true,
        ]])->merge($rawItems)->values();
    }

    $selectedValues = collect($selectedItems ?: $initialSelectedItems)
        ->map(function ($item) {
            if (is_array($item)) {
                return (string) ($item['value'] ?? $item['label'] ?? $item['text'] ?? '');
            }

            return (string) $item;
        })
        ->filter()
        ->values()
        ->all();

    $normalizedItems = $rawItems->map(function ($item, int $index) use ($selectedValues) {
        $itemValue = is_array($item)
            ? ($item['value'] ?? $item['label'] ?? $item['text'] ?? '')
            : $item;

        $itemLabel = is_array($item)
            ? ($item['label'] ?? $item['text'] ?? $itemValue)
            : $item;

        $isSelectAll = is_array($item) && filter_var($item['selectAll'] ?? false, FILTER_VALIDATE_BOOLEAN);

        $isSelected = $isSelectAll
            ? false
            : in_array((string) $itemValue, $selectedValues, true)
                || (is_array($item) && filter_var($item['selected'] ?? false, FILTER_VALIDATE_BOOLEAN));

        return [
            'id' => 'option-'.$index,
            'value' => $itemValue,
            'label' => $itemLabel,
            'disabled' => is_array($item) && filter_var($item['disabled'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'selected' => $isSelected,
            'selectAll' => $isSelectAll,
        ];
    })->values();

    $selectedCount = $normalizedItems
        ->filter(fn ($item) => ! $item['selectAll'] && $item['selected'])
        ->count();

    $selectableCount = $normalizedItems
        ->filter(fn ($item) => ! $item['selectAll'] && ! $item['disabled'])
        ->count();

    $selectAllChecked = $selectableCount > 0 && $selectedCount === $selectableCount;
    $selectAllIndeterminate = $selectedCount > 0 && $selectedCount < $selectableCount;

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
        $clearDescriptionId,
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
        'ui-multi-select__wrapper',
        'ui-multi-select--filterable__wrapper',
        'ui-list-box__wrapper',
        'ui-multi-select__wrapper--inline' => $isInline,
        'ui-list-box__wrapper--inline' => $isInline,
        'ui-multi-select__wrapper--inline--invalid' => $isInline && $isInvalid,
        'ui-list-box__wrapper--inline--invalid' => $isInline && $isInvalid,
        'ui-list-box__wrapper--decorator' => $hasDecorator,
    ];

    $labelClasses = [
        'ui-label',
        'ui-label--disabled' => $isDisabled,
        'ui-visually-hidden' => $isLabelHidden,
    ];

    $multiSelectClasses = [
        'ui-multi-select',
        'ui-combo-box',
        'ui-list-box',
        'ui-multi-select--filterable',
        'ui-multi-select--invalid' => $isInvalid,
        'ui-multi-select--warning' => $isWarning,
        'ui-multi-select--open' => $isOpen,
        'ui-multi-select--inline' => $isInline,
        'ui-multi-select--selected' => $selectedCount > 0,
        'ui-multi-select--readonly' => $isReadOnly,
        'ui-multi-select--selectall' => $hasSelectAll,
        'ui-list-box--up' => $resolvedDirection === 'top',
        'ui-list-box--'.$resolvedSize => filled($resolvedSize),
        'ui-list-box--disabled' => $isDisabled,
        'ui-list-box--light' => $isLight,
        'ui-list-box--expanded' => $isOpen,
    ];

    $inputClasses = [
        'ui-text-input',
        'ui-text-input--empty',
        'ui-text-input--light' => $isLight,
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
        'data-ui-component' => 'filterable-multi-select',
        'data-ui-multi-select-wrapper' => true,
        'data-ui-filterable-multi-select-wrapper' => true,
        'data-ui-multi-select-state' => $stateValue,
        'data-ui-multi-select-size' => $resolvedSize,
    ]) }}
>
    {{-- ----------------------------------------------------------------------
        Label
        ---------------------------------------------------------------------- --}}

    @if (filled($titleText))
        <label id="{{ $labelId }}" for="{{ $inputId }}" @class($labelClasses)>
            @if ($titleText instanceof HtmlString)
                {!! $titleText !!}
            @else
                {{ $titleText }}
            @endif
        </label>
    @endif

    <span id="{{ $clearDescriptionId }}" class="ui-visually-hidden" data-ui-multi-select-clear-description>
        {{ $clearSelectionDescription }} {{ $selectedCount }}. {{ $clearSelectionText }}.
    </span>

    {{-- ----------------------------------------------------------------------
        Filterable MultiSelect/ListBox Control
        ---------------------------------------------------------------------- --}}

    <div
        id="{{ $resolvedId }}"
        @class($multiSelectClasses)
        @if ($isInvalid) data-invalid="true" @endif
        data-ui-multi-select
        data-ui-filterable-multi-select
        data-ui-multi-select-open="{{ $isOpen ? 'true' : 'false' }}"
        data-ui-multi-select-direction="{{ $resolvedDirection }}"
        data-ui-multi-select-type="{{ $resolvedType }}"
        data-ui-multi-select-selection-feedback="{{ $resolvedSelectionFeedback }}"
        data-ui-multi-select-readonly="{{ $isReadOnly ? 'true' : 'false' }}"
        data-ui-multi-select-disabled="{{ $isDisabled ? 'true' : 'false' }}"
        data-ui-multi-select-selected-count="{{ $selectedCount }}"
        data-ui-multi-select-selectable-count="{{ $selectableCount }}"
        data-ui-multi-select-select-all="{{ $hasSelectAll ? 'true' : 'false' }}"
        @if (filled($name)) data-ui-multi-select-name="{{ $name }}" @endif
    >
        <div class="ui-list-box__field" data-ui-filterable-multi-select-field>
            @if ($selectedCount > 0)
                <button
                    type="button"
                    class="ui-list-box__selection"
                    aria-label="Clear selected items"
                    @disabled($isDisabled || $isReadOnly)
                    data-ui-multi-select-clear
                >
                    <span class="ui-list-box__selection-count" data-ui-multi-select-selection-count>
                        {{ $selectedCount }}
                    </span>

                    <x-ui.icon
                        name="close"
                        class="ui-list-box__selection-icon"
                        aria-hidden="true"
                    />
                </button>
            @endif

            <input
                id="{{ $inputId }}"
                type="text"
                role="combobox"
                @class($inputClasses)
                placeholder="{{ $resolvedPlaceholder }}"
                autocomplete="off"
                aria-haspopup="listbox"
                aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
                aria-controls="{{ $menuId }}"
                @if (filled($titleText)) aria-labelledby="{{ $labelId }}" @else aria-label="{{ $resolvedInputLabel }}" @endif
                @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
                @if ($isInvalid) aria-invalid="true" @endif
                @if (filled($invalidId)) aria-errormessage="{{ $invalidId }}" @endif
                @if ($isReadOnly) aria-readonly="true" @endif
                @disabled($isDisabled)
                @readonly($isReadOnly)
                data-ui-multi-select-input
                data-ui-filterable-multi-select-input
                data-ui-filterable-multi-select-input-state="{{ $stateValue }}"
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
                class="ui-list-box__menu-icon"
                aria-label="{{ $isOpen ? 'Close menu' : 'Open menu' }}"
                aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
                aria-controls="{{ $menuId }}"
                @disabled($isDisabled || $isReadOnly)
                data-ui-multi-select-trigger
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

        <ul
            id="{{ $menuId }}"
            class="ui-list-box__menu"
            role="listbox"
            aria-multiselectable="true"
            data-ui-multi-select-menu
            data-ui-multi-select-menu-open="{{ $isOpen ? 'true' : 'false' }}"
            @if (! $isOpen) hidden @endif
        >
            @foreach ($normalizedItems as $index => $item)
                @php
                    $itemId = $resolvedId.'-option-'.$index;

                    $isChecked = $item['selectAll']
                        ? $selectAllChecked
                        : $item['selected'];

                    $isIndeterminate = $item['selectAll'] && $selectAllIndeterminate;
                @endphp

                <li
                    id="{{ $itemId }}"
                    class="ui-list-box__menu-item"
                    role="option"
                    aria-selected="{{ $isChecked ? 'true' : 'false' }}"
                    aria-label="{{ $item['label'] }}"
                    @if ($item['disabled']) aria-disabled="true" @endif
                    @if ($usesTitleInItem) title="{{ $item['label'] }}" @endif
                    data-ui-multi-select-option
                    data-ui-multi-select-option-index="{{ $index }}"
                    data-ui-multi-select-option-value="{{ $item['value'] }}"
                    data-ui-multi-select-option-label="{{ $item['label'] }}"
                    data-ui-multi-select-option-selected="{{ $isChecked ? 'true' : 'false' }}"
                    @if ($isIndeterminate) data-ui-multi-select-option-indeterminate="true" @endif
                    @if ($item['selectAll']) data-ui-multi-select-option-select-all="true" @endif
                    @if ($item['disabled']) data-ui-multi-select-option-disabled="true" @endif
                >
                    <div class="ui-checkbox-wrapper">
                        <input
                            id="{{ $itemId }}__checkbox"
                            type="checkbox"
                            class="ui-checkbox"
                            tabindex="-1"
                            @checked($isChecked)
                            @disabled($isDisabled || $item['disabled'])
                            @if ($isIndeterminate) data-ui-checkbox-indeterminate="true" aria-checked="mixed" @endif
                            data-ui-multi-select-checkbox
                        >

                        <label for="{{ $itemId }}__checkbox" class="ui-checkbox-label">
                            <span class="ui-checkbox-label-text">
                                {{ $item['label'] }}
                            </span>
                        </label>
                    </div>
                </li>
            @endforeach
        </ul>

        @if (filled($name))
            <div data-ui-multi-select-hidden-inputs>
                @foreach ($normalizedItems->where('selected', true)->where('selectAll', false) as $item)
                    <input
                        type="hidden"
                        name="{{ $name }}"
                        value="{{ $item['value'] }}"
                        data-ui-multi-select-hidden-input
                    >
                @endforeach
            </div>
        @endif

        <span
            class="ui-visually-hidden"
            aria-live="assertive"
            data-ui-multi-select-clear-announcement
        ></span>
    </div>

    {{-- ----------------------------------------------------------------------
        Validation, warning, and helper text
        ---------------------------------------------------------------------- --}}

    @if ($showInvalid)
        <div
            id="{{ $invalidId }}"
            role="alert"
            class="ui-form-requirement"
            data-ui-filterable-multi-select-validation
        >
            {{ $invalidText }}
        </div>
    @elseif ($showWarning)
        <div
            id="{{ $warningId }}"
            role="alert"
            class="ui-form-requirement"
            data-ui-filterable-multi-select-validation
        >
            {{ $warnText }}
        </div>
    @elseif ($showHelper)
        <div id="{{ $helperId }}" @class($helperClasses)>
            {{ $helperText }}
        </div>
    @endif
</div>