{{-- ==========================================================================
    File: resources/views/components/shell/item.blade.php
    Purpose: UI shell switcher item.

    Notes:
    - Mirrors the base UI shell SwitcherItem structure.
    - Custom classes apply to the li wrapper.
    - Selection state applies to the anchor element.
    - Tab index follows the React SwitcherItem expanded behavior when provided.
    - Link behavior is caller-owned; this component only renders the shell
      switcher item anatomy and selection state.
    ========================================================================== --}}

@props([
    'href' => null,
    'target' => null,
    'rel' => null,
    'label' => null,
    'labelledby' => null,
    'selected' => false,
    'isSelected' => false,
    'expanded' => null,
    'tabIndex' => null,
    'index' => null,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Resolve State
    |--------------------------------------------------------------------------
    */

    $resolvedSelected = filter_var($selected, FILTER_VALIDATE_BOOLEAN)
        || filter_var($isSelected, FILTER_VALIDATE_BOOLEAN);

    $resolvedExpanded = is_null($expanded)
        ? null
        : filter_var($expanded, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | Resolve Link Values
    |--------------------------------------------------------------------------
    */

    $resolvedHref = filled($href) ? $href : '#';

    $resolvedRel = $rel;

    if ($target === '_blank' && blank($resolvedRel)) {
        $resolvedRel = 'noopener noreferrer';
    }

    /*
    |--------------------------------------------------------------------------
    | Resolve Tab Index
    |--------------------------------------------------------------------------
    */

    $resolvedTabIndex = $tabIndex;

    if ($resolvedTabIndex === null && $resolvedExpanded !== null) {
        $resolvedTabIndex = $resolvedExpanded ? 0 : -1;
    }

    /*
    |--------------------------------------------------------------------------
    | Resolve Accessible Name
    |--------------------------------------------------------------------------
    |
    | aria-labelledby takes precedence over aria-label when both are supplied.
    |
    */

    $resolvedAriaLabel = $label ?? $attributes->get('aria-label');
    $resolvedAriaLabelledby = $labelledby ?? $attributes->get('aria-labelledby');

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $linkClasses = [
        'ui-shell-switcher__item-link',
        'ui-shell-switcher__item-link--selected' => $resolvedSelected,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    |
    | Custom classes and extra attributes apply to the li wrapper. Link-specific
    | attributes are owned by explicit component props.
    |
    */

    $itemAttributes = $attributes->except([
        'aria-label',
        'aria-labelledby',
    ]);
@endphp

<li
    {{ $itemAttributes->class('ui-shell-switcher__item')->merge([
        'data-ui-component' => 'shell-switcher-item',
        'data-ui-shell-switcher-item' => true,
    ]) }}
    @if (! is_null($index)) data-ui-shell-switcher-index="{{ $index }}" @endif
>
    <a
        href="{{ $resolvedHref }}"
        @if ($target) target="{{ $target }}" @endif
        @if ($resolvedRel) rel="{{ $resolvedRel }}" @endif
        @if ($resolvedTabIndex !== null) tabindex="{{ $resolvedTabIndex }}" @endif
        @class($linkClasses)
        @if ($resolvedAriaLabelledby) aria-labelledby="{{ $resolvedAriaLabelledby }}" @elseif ($resolvedAriaLabel) aria-label="{{ $resolvedAriaLabel }}" @endif
        @if ($resolvedSelected) aria-current="page" @endif
    >
        {{ $slot }}
    </a>
</li>