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
    $variant = in_array($variant, ['inline', 'standalone'], true) ? $variant : 'standalone';
    $size = in_array($size, ['sm', 'md', 'lg'], true) ? $size : 'md';
    $normalizedIconPosition = in_array($iconPosition, ['start', 'leading'], true) ? 'start' : 'end';
    $isInline = $variant === 'inline';
    $isDisabled = (bool) $disabled || (bool) $unavailable || blank($href);
    $opensNewTab = (bool) $newTab || (bool) $external;
    $rel = $opensNewTab ? 'noopener noreferrer' : null;
    $currentValue = $current === true ? 'page' : (is_string($current) ? $current : null);
    $hasIcon = filled($icon) && ! $isInline;
    $label = filled($text) ? $text : $slot;
    $downloadValue = is_string($download) ? $download : null;
@endphp

@if ($isDisabled)
    <span
        aria-disabled="true"
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
            <x-dynamic-component :component="$icon" class="ui-link-icon" aria-hidden="true" />
        @endif
        <span>{{ $label }}</span>
        @if ($hasIcon && $normalizedIconPosition === 'end')
            <x-dynamic-component :component="$icon" class="ui-link-icon" aria-hidden="true" />
        @endif
    </span>
@else
    <a
        href="{{ $href }}"
        @if ($opensNewTab) target="_blank" rel="{{ $rel }}" @endif
        @if ($download) download="{{ $downloadValue }}" @endif
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
            <x-dynamic-component :component="$icon" class="ui-link-icon" aria-hidden="true" />
        @endif
        <span>{{ $label }}</span>
        @if ($hasIcon && $normalizedIconPosition === 'end')
            <x-dynamic-component :component="$icon" class="ui-link-icon" aria-hidden="true" />
        @endif
    </a>
@endif
