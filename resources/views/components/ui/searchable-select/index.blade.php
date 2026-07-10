{{-- ==========================================================================
    File: resources/views/components/ui/searchable-select/index.blade.php
    Purpose: Searchable Select/ListBox form control component.

    Notes:
    - Emits the installed .ui-searchable-select selector contract.
    - Renders a hidden submitted value, button trigger, searchable panel,
      filter input, selectable options, and empty state.
    - This is an app-owned composite, not a direct Carbon component mapping.
    - Combines listbox/dropdown anatomy with a search input inside the panel.
    - Search filtering, open/close behavior, keyboard navigation, and selection
      sync are handled by installed Searchable Select JavaScript.
    - Uses the unified x-ui.icon component for icons.
    ========================================================================== --}}

@props([
    'id' => null,
    'name' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => 'Select an option',
    'label' => null,
    'ariaLabel' => null,
    'searchLabel' => 'Search available options',
    'searchPlaceholder' => 'Search available options',
    'emptyLabel' => 'No matching options',
    'required' => false,
    'disabled' => false,
    'invalid' => false,
    'open' => false,
])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Resolve IDs
    |--------------------------------------------------------------------------
    */

    $resolvedId = $id ?? 'ui-searchable-select-'.Str::uuid();
    $optionsId = $resolvedId.'__options';
    $filterId = $resolvedId.'__filter';
    $labelId = $resolvedId.'__label';
    $triggerTextId = $resolvedId.'__trigger-text';

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isRequired = filter_var($required, FILTER_VALIDATE_BOOLEAN);
    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $isInvalid = ! $isDisabled && filter_var($invalid, FILTER_VALIDATE_BOOLEAN);
    $isOpen = filter_var($open, FILTER_VALIDATE_BOOLEAN) && ! $isDisabled;

    /*
    |--------------------------------------------------------------------------
    | Option Normalization
    |--------------------------------------------------------------------------
    |
    | Options may be strings or arrays. Arrays support value, label, disabled,
    | and hidden.
    |
    */

    $normalizedOptions = collect($options)
        ->reject(fn ($option) => is_array($option) && filter_var($option['hidden'] ?? false, FILTER_VALIDATE_BOOLEAN))
        ->map(function ($option): array {
            $value = is_array($option)
                ? (string) ($option['value'] ?? $option['label'] ?? '')
                : (string) $option;

            return [
                'value' => $value,
                'label' => is_array($option)
                    ? (string) ($option['label'] ?? $value)
                    : (string) $option,
                'disabled' => is_array($option) && filter_var($option['disabled'] ?? false, FILTER_VALIDATE_BOOLEAN),
            ];
        })
        ->values();

    $selectedValue = $selected === null ? '' : (string) $selected;

    $selectedOption = $normalizedOptions->firstWhere('value', $selectedValue);
    $selectedLabel = $selectedOption['label'] ?? $placeholder;
    $hasSelectedValue = $selectedValue !== '' && ! is_null($selectedOption);

    /*
    |--------------------------------------------------------------------------
    | Accessible Labeling
    |--------------------------------------------------------------------------
    */

    $resolvedAriaLabel = $ariaLabel ?? $placeholder ?? 'Select an option';

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $rootClasses = [
        'ui-list-box-wrapper',
        'ui-searchable-select',
        'ui-searchable-select--open' => $isOpen,
        'ui-searchable-select--disabled' => $isDisabled,
        'ui-searchable-select--invalid' => $isInvalid,
        'ui-searchable-select--selected' => $hasSelectedValue,
    ];

    $triggerClasses = [
        'ui-list-box',
        'ui-list-box-field',
        'ui-select',
        'ui-searchable-select-trigger',
    ];

    $panelClasses = [
        'ui-list-box-menu',
        'ui-searchable-select-panel',
        'hidden' => ! $isOpen,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    */

    $rootAttributes = $attributes->except([
        'aria-label',
    ]);
@endphp

<div
    {{ $rootAttributes->class($rootClasses)->merge([
        'data-ui-component' => 'searchable-select',
        'data-ui-searchable-select' => true,
        'data-ui-searchable-select-empty-label' => $emptyLabel,
        'data-ui-searchable-select-open' => $isOpen ? 'true' : 'false',
        'data-ui-searchable-select-disabled' => $isDisabled ? 'true' : 'false',
        'data-ui-searchable-select-invalid' => $isInvalid ? 'true' : 'false',
        'data-ui-searchable-select-required' => $isRequired ? 'true' : 'false',
    ]) }}
>
    {{-- ----------------------------------------------------------------------
        Optional Field Label
        ---------------------------------------------------------------------- --}}

    @if (filled($label))
        <label id="{{ $labelId }}" class="ui-label" for="{{ $resolvedId }}">
            @if ($label instanceof HtmlString)
                {!! $label !!}
            @else
                {{ $label }}
            @endif
        </label>
    @endif

    {{-- ----------------------------------------------------------------------
        Submitted Value
        ----------------------------------------------------------------------
        The hidden input owns the submitted form value.
        ---------------------------------------------------------------------- --}}

    <input
        type="hidden"
        id="{{ $resolvedId }}"
        @if (filled($name)) name="{{ $name }}" @endif
        value="{{ $selectedValue }}"
        @disabled($isDisabled)
        @if ($isInvalid) aria-invalid="true" @endif
        data-ui-searchable-select-value
    >

    {{-- ----------------------------------------------------------------------
        Trigger
        ----------------------------------------------------------------------
        The trigger opens the searchable listbox panel.
        ---------------------------------------------------------------------- --}}

    <button
        type="button"
        @class($triggerClasses)
        data-ui-searchable-select-trigger
        data-ui-searchable-select-label="{{ $placeholder }}"
        role="combobox"
        aria-haspopup="listbox"
        aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
        aria-controls="{{ $optionsId }}"
        @if (filled($label)) aria-labelledby="{{ $labelId }} {{ $triggerTextId }}" @else aria-label="{{ $resolvedAriaLabel }}" @endif
        @if ($isRequired) aria-required="true" @endif
        @if ($isInvalid) aria-invalid="true" @endif
        @disabled($isDisabled)
    >
        <span
            id="{{ $triggerTextId }}"
            class="ui-list-box-label ui-searchable-select-trigger-text"
            data-ui-searchable-select-trigger-text
        >
            {{ $selectedLabel }}
        </span>

        <x-ui.icon
            name="chevron--sort"
            class="ui-searchable-select-trigger-icon"
            data-ui-searchable-select-trigger-icon
            aria-hidden="true"
        />
    </button>

    {{-- ----------------------------------------------------------------------
        Searchable Panel
        ---------------------------------------------------------------------- --}}

    <div @class($panelClasses) data-ui-searchable-select-panel>
        <div class="ui-searchable-select-filter-shell">
            <label for="{{ $filterId }}" class="sr-only">
                {{ $searchLabel }}
            </label>

            <span class="ui-searchable-select-icon">
                <x-ui.icon
                    name="search"
                    class="ui-searchable-select-filter-icon"
                    aria-hidden="true"
                />
            </span>

            <input
                id="{{ $filterId }}"
                type="search"
                value=""
                placeholder="{{ $searchPlaceholder }}"
                class="ui-searchable-select-filter"
                autocomplete="off"
                @disabled($isDisabled)
                data-ui-searchable-select-filter
            >
        </div>

        <div
            id="{{ $optionsId }}"
            class="ui-searchable-select-options ui-scrollbar"
            role="listbox"
            data-ui-searchable-select-options
        >
            @foreach ($normalizedOptions as $option)
                @php
                    $optionSelected = $selectedValue === $option['value'];
                @endphp

                <button
                    type="button"
                    class="ui-list-box-menu-item ui-searchable-select-option"
                    data-ui-searchable-select-option
                    data-value="{{ $option['value'] }}"
                    data-label="{{ $option['label'] }}"
                    role="option"
                    tabindex="-1"
                    aria-selected="{{ $optionSelected ? 'true' : 'false' }}"
                    @if ($option['disabled']) aria-disabled="true" @endif
                    @disabled($isDisabled || $option['disabled'])
                >
                    <span class="ui-list-box-menu-item-option">
                        {{ $option['label'] }}
                    </span>

                    @if ($optionSelected)
                        <x-ui.icon
                            name="checkmark"
                            class="ui-searchable-select-check"
                            data-ui-searchable-select-check
                            aria-hidden="true"
                        />
                    @endif
                </button>
            @endforeach

            <p
                class="ui-searchable-select-empty hidden"
                role="status"
                aria-live="polite"
                data-ui-searchable-select-empty
            >
                {{ $emptyLabel }}
            </p>
        </div>
    </div>
</div>