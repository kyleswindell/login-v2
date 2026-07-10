{{-- ==========================================================================
    File: resources/views/components/ui/search/index.blade.php
    Purpose: Search input component.

    Notes:
    - Emits the installed .ui-search selector contract.
    - Uses a native input type="search".
    - Supports default search, expandable search, clear button, disabled state,
      light state, size variants, custom icon, and controlled/uncontrolled values.
    - Search clear and expandable behavior are handled by installed search JavaScript.
    - Uses generated UI icon components from resources/views/components/icons.
    - Search styles are handled by resources/css/components/search.css.
    ========================================================================== --}}

@props([
    'id' => null,
    'name' => null,
    'labelText',
    'placeholder' => 'Search',
    'value' => null,
    'defaultValue' => null,
    'autoComplete' => 'off',
    'closeButtonLabelText' => 'Clear search input',
    'disabled' => false,
    'isExpanded' => true,
    'expandable' => false,
    'light' => false,
    'size' => null,
    'type' => 'search',
    'role' => null,
    'icon' => 'search',
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
    $allowedTypes = ['search', 'text'];

    /*
    |--------------------------------------------------------------------------
    | Resolve values
    |--------------------------------------------------------------------------
    */

    $resolvedId = $id ?? 'ui-search-input-'.Str::uuid();
    $searchLabelId = $resolvedId.'-search';
    $resolvedSize = in_array($size, $allowedSizes, true) ? $size : null;
    $resolvedType = in_array($type, $allowedTypes, true) ? $type : 'search';

    $inputValue = $value ?? $defaultValue;
    $hasContent = filled($inputValue);

    /*
    |--------------------------------------------------------------------------
    | Render state
    |--------------------------------------------------------------------------
    */

    $isDisabled = (bool) $disabled;
    $isExpanded = (bool) $isExpanded;
    $isExpandable = (bool) $expandable;
    $isLight = (bool) $light;

    /*
    |--------------------------------------------------------------------------
    | CSS class contract
    |--------------------------------------------------------------------------
    |
    | These classes must match resources/css/components/search.css.
    |
    */

    $classes = [
        'ui-search',
        'ui-search--'.$resolvedSize => filled($resolvedSize),
        'ui-layout--size-'.$resolvedSize => filled($resolvedSize),
        'ui-search--light' => $isLight,
        'ui-search--disabled' => $isDisabled,
        'ui-search--expandable' => $isExpandable,
        'ui-search-expandable' => $isExpandable,
        'ui-search--expanded' => $isExpandable && $isExpanded,
        'ui-search-expanded' => $isExpandable && $isExpanded,
    ];

    $clearClasses = [
        'ui-search-close',
        'ui-search-close--hidden' => ! $hasContent || ! $isExpanded,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute handling
    |--------------------------------------------------------------------------
    |
    | Component classes are applied to the search wrapper. Non-class attributes
    | are passed to the input.
    |
    */

    $wrapperAttributes = $attributes->only([
        'class',
        'style',
    ]);

    $inputAttributes = $attributes->except([
        'class',
        'style',
        'id',
        'name',
        'value',
        'defaultValue',
        'default-value',
        'type',
        'role',
        'placeholder',
        'disabled',
        'autocomplete',
        'autoComplete',
    ]);
@endphp

<div
    role="search"
    aria-labelledby="{{ $searchLabelId }}"
    {{ $wrapperAttributes->class($classes)->merge([
        'data-ui-component' => 'search',
        'data-ui-search' => true,
        'data-ui-search-expanded' => $isExpanded ? 'true' : 'false',
        'data-ui-search-expandable' => $isExpandable ? 'true' : 'false',
    ]) }}
>
    {{-- ----------------------------------------------------------------------
        Search magnifier
        ----------------------------------------------------------------------
        In expandable mode, the magnifier can act as the expansion trigger.
        ---------------------------------------------------------------------- --}}

    @if ($isExpandable)
        <button
            type="button"
            class="ui-search-magnifier"
            aria-labelledby="{{ $searchLabelId }}"
            aria-expanded="{{ $isExpanded ? 'true' : 'false' }}"
            aria-controls="{{ $resolvedId }}"
            tabindex="{{ $isExpanded ? '-1' : '0' }}"
            data-ui-search-magnifier
            data-ui-search-expandable-trigger
        >
            <x-ui.icon
                :name="$icon"
                class="ui-search-magnifier-icon"
                aria-hidden="true"
                focusable="false"
            />
        </button>
    @else
        <div
            class="ui-search-magnifier"
            data-ui-search-magnifier
            aria-hidden="true"
        >
            <x-ui.icon
                :name="$icon"
                class="ui-search-magnifier-icon"
                aria-hidden="true"
                focusable="false"
            />
        </div>
    @endif

    {{-- ----------------------------------------------------------------------
        Search label
        ----------------------------------------------------------------------
        Label is visually managed by CSS but remains available to assistive tech.
        ---------------------------------------------------------------------- --}}

    <label
        id="{{ $searchLabelId }}"
        for="{{ $resolvedId }}"
        class="ui-label"
    >
        @if ($labelText instanceof HtmlString)
            {!! $labelText !!}
        @else
            {{ $labelText }}
        @endif
    </label>

    {{-- ----------------------------------------------------------------------
        Search input
        ----------------------------------------------------------------------
        Native search input remains responsible for value and form submission.
        ---------------------------------------------------------------------- --}}

    <input
        id="{{ $resolvedId }}"
        type="{{ $resolvedType }}"
        class="ui-search-input"
        autocomplete="{{ $autoComplete }}"
        @if (filled($name)) name="{{ $name }}" @endif
        @if (! is_null($inputValue)) value="{{ $inputValue }}" @endif
        placeholder="{{ $placeholder }}"
        @if (filled($role)) role="{{ $role }}" @endif
        @if ($isExpandable && ! $isExpanded) tabindex="-1" @endif
        @disabled($isDisabled)
        data-ui-search-input
        {{ $inputAttributes }}
    >

    {{-- ----------------------------------------------------------------------
        Clear button
        ----------------------------------------------------------------------
        JavaScript clears the input value, toggles button visibility, and
        returns focus to the search input.
        ---------------------------------------------------------------------- --}}

    <button
        type="button"
        aria-label="{{ $closeButtonLabelText }}"
        title="{{ $closeButtonLabelText }}"
        @class($clearClasses)
        @disabled($isDisabled)
        data-ui-search-clear
    >
        <x-ui.icon name="close"
            width="16"
            height="16"
            aria-hidden="true"
            focusable="false"
        />
    </button>
</div>
