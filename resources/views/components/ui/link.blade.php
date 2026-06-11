@props([
    'href' => null,
    'external' => false,
    'newTab' => false,
    'icon' => null,
    'iconPosition' => 'trailing',
    'disabled' => false,
    'current' => false,
    'visited' => false,
])

@php
    $isDisabled = (bool) $disabled || blank($href);
    $opensNewTab = (bool) $newTab || (bool) $external;
    $rel = $opensNewTab ? 'noopener noreferrer' : null;
@endphp

@if ($isDisabled)
    <span
        aria-disabled="true"
        data-ui-component="link"
        data-ui-link-disabled="true"
        {{ $attributes->class(['ui-link opacity-70 no-underline']) }}
    >
        @if ($icon && $iconPosition === 'leading')
            <x-dynamic-component :component="$icon" class="h-4 w-4" aria-hidden="true" />
        @endif
        <span>{{ $slot }}</span>
        @if ($icon && $iconPosition === 'trailing')
            <x-dynamic-component :component="$icon" class="h-4 w-4" aria-hidden="true" />
        @endif
    </span>
@else
    <a
        href="{{ $href }}"
        @if ($opensNewTab) target="_blank" rel="{{ $rel }}" @endif
        @if ($current) aria-current="page" @endif
        data-ui-component="link"
        data-ui-link-external="{{ $external ? 'true' : 'false' }}"
        data-ui-link-current="{{ $current ? 'true' : 'false' }}"
        data-ui-link-visited-policy="{{ $visited ? 'example' : 'none' }}"
        {{ $attributes->class('ui-link') }}
    >
        @if ($icon && $iconPosition === 'leading')
            <x-dynamic-component :component="$icon" class="h-4 w-4" aria-hidden="true" />
        @endif
        <span>{{ $slot }}</span>
        @if ($icon && $iconPosition === 'trailing')
            <x-dynamic-component :component="$icon" class="h-4 w-4" aria-hidden="true" />
        @endif
    </a>
@endif
