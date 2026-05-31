@props([
    'href' => null,
    'type' => 'button',
    'label' => null,
    'disabled' => false,
])

@php
    $isLink = filled($href) && ! $disabled;
@endphp

@if ($isLink)
    <a
        href="{{ $href }}"
        aria-label="{{ $label }}"
        {{ $attributes->class(['ui-icon-button'])->merge(['data-ui-component' => 'icon-button']) }}
    >
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        aria-label="{{ $label }}"
        @disabled($disabled)
        {{ $attributes->class(['ui-icon-button'])->merge(['data-ui-component' => 'icon-button']) }}
    >
        {{ $slot }}
    </button>
@endif
