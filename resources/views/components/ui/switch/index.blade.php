{{-- ==========================================================================
    File: resources/views/components/ui/switch/index.blade.php
    Purpose: Content Switcher tab button component.

    Notes:
    - Emits the installed .ui-content-switcher-btn selector contract.
    - Intended for use inside resources/views/components/ui/content-switcher/index.blade.php.
    - Renders a native button with role="tab".
    - Selection state is represented with aria-selected and tabindex.
    - Supports text switch and icon switch variants from one Blade API.
    - Switch behavior is handled by installed Content Switcher JavaScript.
    - Styles are handled by resources/css/components/content-switcher.css.
    ========================================================================== --}}

@props([
    'index' => null,
    'name' => null,
    'text' => null,
    'selected' => false,
    'disabled' => false,
    'variant' => 'text',
    'icon' => null,
    'iconOnly' => false,
    'align' => 'bottom',
])

@php
    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedVariants = [
        'text',
        'icon',
    ];

    $allowedAlignments = [
        'top',
        'top-start',
        'top-end',
        'bottom',
        'bottom-start',
        'bottom-end',
        'left',
        'left-start',
        'left-end',
        'right',
        'right-start',
        'right-end',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $isSelected = filter_var($selected, FILTER_VALIDATE_BOOLEAN);
    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $hasText = ! is_null($text) && $text !== '';

    $resolvedVariant = in_array($variant, $allowedVariants, true)
        ? $variant
        : 'text';

    $resolvedAlign = in_array($align, $allowedAlignments, true)
        ? $align
        : 'bottom';

    $rendersIcon = filled($icon) || $resolvedVariant === 'icon';
    $isIconOnly = filter_var($iconOnly, FILTER_VALIDATE_BOOLEAN) || ($resolvedVariant === 'icon' && $rendersIcon);

    $resolvedLabel = $hasText
        ? $text
        : trim(strip_tags($slot->toHtml()));

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    |
    | These classes must match resources/css/components/content-switcher.css.
    |
    */

    $classes = [
        'ui-content-switcher-btn',
        'ui-content-switcher--selected' => $isSelected,
        'ui-content-switcher-btn--icon' => $rendersIcon,
        'ui-content-switcher-btn--icon-only' => $isIconOnly,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    |
    | Role, tab state, and disabled state are owned by the component.
    |
    */

    $buttonAttributes = $attributes->except([
        'type',
        'role',
        'tabindex',
        'aria-selected',
        'aria-label',
        'disabled',
    ]);
@endphp

{{-- ----------------------------------------------------------------------
    Content switcher tab
    ----------------------------------------------------------------------
    The parent Content Switcher manages roving tabindex, selected state, and
    keyboard navigation through JavaScript.
    ---------------------------------------------------------------------- --}}

<button
    type="button"
    role="tab"
    tabindex="{{ $isSelected ? '0' : '-1' }}"
    aria-selected="{{ $isSelected ? 'true' : 'false' }}"
    @if ($isIconOnly && filled($resolvedLabel)) aria-label="{{ $resolvedLabel }}" @endif
    @disabled($isDisabled)
    data-ui-component="switch"
    data-ui-switch
    data-ui-switch-variant="{{ $resolvedVariant }}"
    data-ui-switch-icon="{{ $rendersIcon ? 'true' : 'false' }}"
    data-ui-switch-icon-only="{{ $isIconOnly ? 'true' : 'false' }}"
    data-ui-switch-align="{{ $resolvedAlign }}"
    data-ui-content-switcher-switch
    @if (! is_null($index)) data-ui-content-switcher-index="{{ $index }}" @endif
    @if (! is_null($name)) data-ui-content-switcher-name="{{ $name }}" @endif
    @if ($hasText) data-ui-content-switcher-text="{{ $text }}" @endif
    {{ $buttonAttributes->class($classes) }}
>
    @if ($rendersIcon)
        <span class="ui-content-switcher__icon" aria-hidden="true">
            @if (filled($icon))
                <x-ui.icon :name="$icon" />
            @else
                {{ $slot }}
            @endif
        </span>
    @endif

    @if (! $isIconOnly)
        <span
            class="ui-content-switcher__label"
            @if ($hasText) title="{{ $text }}" @endif
        >
            @if ($hasText)
                {{ $text }}
            @else
                {{ $slot }}
            @endif
        </span>
    @elseif (filled($resolvedLabel))
        <span class="ui-visually-hidden sr-only">
            {{ $resolvedLabel }}
        </span>
    @endif
</button>