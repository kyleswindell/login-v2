@props([
    'icon' => 'minus-circle',
    'class' => 'h-3.5 w-3.5',
    'decorative' => true,
])

@php
    $aria = $decorative ? ['aria-hidden' => 'true'] : ['role' => 'img'];
@endphp

@switch($icon)
    @case('information-circle')
        <svg {{ $attributes->merge(['class' => $class])->merge($aria) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <circle cx="12" cy="12" r="9" />
            <path d="M12 10v6" stroke-linecap="round" />
            <circle cx="12" cy="7" r="1" fill="currentColor" stroke="none" />
        </svg>
        @break
    @case('check-circle')
        <svg {{ $attributes->merge(['class' => $class])->merge($aria) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <circle cx="12" cy="12" r="9" />
            <path d="m8.5 12.5 2.5 2.5 4.5-5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        @break
    @case('clock')
        <svg {{ $attributes->merge(['class' => $class])->merge($aria) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <circle cx="12" cy="12" r="9" />
            <path d="M12 7.5v5l3 2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        @break
    @case('exclamation-triangle')
        <svg {{ $attributes->merge(['class' => $class])->merge($aria) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path d="M12 3 2.5 20h19L12 3Z" stroke-linejoin="round" />
            <path d="M12 9.5v5" stroke-linecap="round" />
            <circle cx="12" cy="17" r="1" fill="currentColor" stroke="none" />
        </svg>
        @break
    @case('x-circle')
        <svg {{ $attributes->merge(['class' => $class])->merge($aria) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <circle cx="12" cy="12" r="9" />
            <path d="m9 9 6 6M15 9l-6 6" stroke-linecap="round" />
        </svg>
        @break
    @case('arrow-path')
        <svg {{ $attributes->merge(['class' => $class])->merge($aria) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path d="M17.5 6.5V3m0 0h-3.5m3.5 0-3 3" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M20 11a8 8 0 1 0 1.2 4.2" stroke-linecap="round" />
        </svg>
        @break
    @case('archive-box')
        <svg {{ $attributes->merge(['class' => $class])->merge($aria) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path d="M4 7h16v12H4z" />
            <path d="M2.5 4h19v3h-19z" />
            <path d="M9 13h6" stroke-linecap="round" />
        </svg>
        @break
    @case('no-symbol')
        <svg {{ $attributes->merge(['class' => $class])->merge($aria) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <circle cx="12" cy="12" r="9" />
            <path d="m7 17 10-10" stroke-linecap="round" />
        </svg>
        @break
    @default
        <svg {{ $attributes->merge(['class' => $class])->merge($aria) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <circle cx="12" cy="12" r="9" />
            <path d="M8 12h8" stroke-linecap="round" />
        </svg>
@endswitch
