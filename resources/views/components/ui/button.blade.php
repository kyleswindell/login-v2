@props([
    'href' => null,
    'type' => 'button',
    'semantic' => 'neutral',
    'variant' => 'base',
    'size' => 'md',
    'loading' => false,
    'disabled' => false,
])

@php
    $allowedSemantics = ['neutral', 'primary', 'success', 'warning', 'danger', 'notice', 'info'];
    $allowedVariants = ['base', 'soft', 'outline', 'ghost'];
    $allowedSizes = ['xs', 'sm', 'md', 'lg', 'xl'];
    $ghostSizeClasses = [
        'xs' => '!px-[calc(0.625rem+1px)] !py-[calc(0.375rem+1px)]',
        'sm' => '!px-[calc(0.75rem+1px)] !py-[calc(0.375rem+1px)]',
        'md' => '!px-[calc(0.875rem+1px)] !py-[calc(0.5rem+1px)]',
        'lg' => '!px-[calc(1.125rem+1px)] !py-[calc(0.625rem+1px)]',
        'xl' => '!px-[calc(1.25rem+1px)] !py-[calc(0.75rem+1px)]',
    ];

    $resolvedSemantic = in_array($semantic, $allowedSemantics, true) ? $semantic : 'neutral';
    $resolvedVariant = in_array($variant, $allowedVariants, true) ? $variant : 'base';
    $resolvedSize = in_array($size, $allowedSizes, true) ? $size : 'md';

    $classes = ['ui-action'];

    if ($resolvedSemantic !== 'neutral') {
        $classes[] = 'ui-action-'.$resolvedSemantic;
    }

    if ($resolvedVariant !== 'base') {
        $classes[] = 'ui-action-'.$resolvedVariant;
    }

    if ($resolvedSize !== 'md') {
        $classes[] = 'ui-action-'.$resolvedSize;
    }

    if ($resolvedVariant === 'ghost') {
        $classes[] = '!border-0 !shadow-none';
        $classes[] = $ghostSizeClasses[$resolvedSize];
    }

    $showInverseSpinner = $loading
        && $resolvedVariant === 'base'
        && $resolvedSemantic !== 'neutral';

    $isLink = filled($href) && ! $disabled;
@endphp

@if ($isLink)
    <a
        href="{{ $href }}"
        {{ $attributes->class($classes)->merge(['data-ui-component' => 'button']) }}
    >
        @if ($loading)
            <span @class(['ui-spinner', 'ui-spinner-inverse' => $showInverseSpinner]) aria-hidden="true"></span>
        @endif
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        @disabled($disabled)
        @if ($loading) aria-busy="true" @endif
        {{ $attributes->class($classes)->merge(['data-ui-component' => 'button']) }}
    >
        @if ($loading)
            <span @class(['ui-spinner', 'ui-spinner-inverse' => $showInverseSpinner]) aria-hidden="true"></span>
        @endif
        {{ $slot }}
    </button>
@endif
