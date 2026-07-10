{{-- ==========================================================================
    File: resources/views/components/shell/switcher-item.blade.php
    Purpose: UI shell switcher item.

    Notes:
    - Mirrors the base UI shell SwitcherItem structure.
    - Custom classes apply to the li wrapper.
    - Selection state applies to the anchor element.
    - Tab index follows the React SwitcherItem expanded behavior when provided.
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
    $resolvedSelected = (bool) $selected || (bool) $isSelected;

    $resolvedTabIndex = $tabIndex;

    if ($resolvedTabIndex === null && $expanded !== null) {
        $resolvedTabIndex = $expanded ? 0 : -1;
    }

    $resolvedAriaLabel = $label ?? $attributes->get('aria-label');
    $resolvedAriaLabelledby = $labelledby ?? $attributes->get('aria-labelledby');

    $itemAttributes = $attributes->except([
        'aria-label',
        'aria-labelledby',
    ]);

    $linkClasses = [
        'ui-shell-switcher__item-link',
        'ui-shell-switcher__item-link--selected' => $resolvedSelected,
    ];
@endphp

<li
    {{ $itemAttributes->class('ui-shell-switcher__item')->merge([
        'data-ui-shell-switcher-item' => true,
        'data-ui-shell-switcher-index' => $index,
    ]) }}
>
    <a
        href="{{ $href ?? '#' }}"
        @if ($target) target="{{ $target }}" @endif
        @if ($rel) rel="{{ $rel }}" @endif
        @if ($resolvedTabIndex !== null) tabindex="{{ $resolvedTabIndex }}" @endif
        @class($linkClasses)
        @if ($resolvedAriaLabel) aria-label="{{ $resolvedAriaLabel }}" @endif
        @if ($resolvedAriaLabelledby) aria-labelledby="{{ $resolvedAriaLabelledby }}" @endif
        @if ($resolvedSelected) aria-current="page" @endif
    >
        {{ $slot }}
    </a>
</li>