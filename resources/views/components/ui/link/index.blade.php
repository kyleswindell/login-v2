{{-- ==========================================================================
    File: resources/views/components/ui/link/index.blade.php
    Purpose: Standard Link component.

    Notes:
    - Emits the canonical .ui-link selector contract.
    - Supports inline and standalone link variants.
    - Renders unavailable links as non-interactive text with aria-disabled.
    - Suppresses icons for inline links to preserve readable prose flow.
    - Supports internal, external, new-tab, download, current, and Livewire
      wire:navigate link behavior from one component API.
    - Link visual styles are handled by resources/css/components/link.css.
    ========================================================================== --}}

@props([
    'href' => null,
    'text' => null,
    'variant' => 'standalone',
    'size' => 'md',
    'external' => false,
    'newTab' => false,
    'icon' => null,
    'iconPosition' => 'end',
    'disabled' => false,
    'unavailable' => false,
    'current' => false,
    'visited' => false,
    'download' => false,
    'navigate' => false,
    'ariaLabel' => null,
    'describedBy' => null,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedVariants = [
        'inline',
        'standalone',
    ];

    $allowedSizes = [
        'sm',
        'md',
        'lg',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolved API Values
    |--------------------------------------------------------------------------
    */

    $variant = in_array($variant, $allowedVariants, true) ? $variant : 'standalone';
    $size = in_array($size, $allowedSizes, true) ? $size : 'md';
    $normalizedIconPosition = in_array($iconPosition, ['start', 'leading'], true) ? 'start' : 'end';

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isInline = $variant === 'inline';
    $isDisabled = (bool) $disabled || (bool) $unavailable || blank($href);
    $opensNewTab = (bool) $newTab || (bool) $external;
    $rel = $opensNewTab ? 'noopener noreferrer' : null;
    $currentValue = $current === true ? 'page' : (is_string($current) ? $current : null);
    $hasIcon = filled($icon) && ! $isInline;
    $label = filled($text) ? $text : $slot;
@endphp

@if ($isDisabled)
    {{-- ----------------------------------------------------------------------
        Unavailable rendering
        ----------------------------------------------------------------------
        Unavailable links render as text instead of anchors so unavailable,
        disabled, or missing destinations are not exposed as actionable links.
        ---------------------------------------------------------------------- --}}

    <span
        aria-disabled="true"
        @if ($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
        @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
        data-ui-component="link"
        data-ui-link-disabled="true"
        data-ui-link-variant="{{ $variant }}"
        data-ui-link-size="{{ $size }}"
        {{ $attributes->class([
            'ui-link',
            'ui-link-'.$variant,
            'ui-link-'.$size,
            'ui-link-with-icon' => $hasIcon,
            'ui-link-unavailable',
        ]) }}
    >
        @if ($hasIcon && $normalizedIconPosition === 'start')
            <x-ui.icon :name="$icon" class="ui-link-icon" aria-hidden="true" />
        @endif

        <span>{{ $label }}</span>

        @if ($hasIcon && $normalizedIconPosition === 'end')
            <x-ui.icon :name="$icon" class="ui-link-icon" aria-hidden="true" />
        @endif
    </span>
@else
    {{-- ----------------------------------------------------------------------
        Anchor rendering
        ----------------------------------------------------------------------
        Interactive links render as native anchors. External links and explicit
        new-tab links receive secure target/rel behavior.
        ---------------------------------------------------------------------- --}}

    <a
        href="{{ $href }}"
        @if ($opensNewTab) target="_blank" rel="{{ $rel }}" @endif
        @if ($download === true) download @elseif (is_string($download) && $download !== '') download="{{ $download }}" @endif
        @if ($navigate) wire:navigate @endif
        @if ($currentValue) aria-current="{{ $currentValue }}" @endif
        @if ($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
        @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
        data-ui-component="link"
        data-ui-link-variant="{{ $variant }}"
        data-ui-link-size="{{ $size }}"
        data-ui-link-external="{{ $external ? 'true' : 'false' }}"
        data-ui-link-current="{{ $currentValue ? 'true' : 'false' }}"
        data-ui-link-visited-policy="{{ $visited ? 'example' : 'none' }}"
        {{ $attributes->class([
            'ui-link',
            'ui-link-'.$variant,
            'ui-link-'.$size,
            'ui-link-with-icon' => $hasIcon,
            'ui-link-external' => (bool) $external,
        ]) }}
    >
        @if ($hasIcon && $normalizedIconPosition === 'start')
            <x-ui.icon :name="$icon" class="ui-link-icon" aria-hidden="true" />
        @endif

        <span>{{ $label }}</span>

        @if ($hasIcon && $normalizedIconPosition === 'end')
            <x-ui.icon :name="$icon" class="ui-link-icon" aria-hidden="true" />
        @endif
    </a>
@endif