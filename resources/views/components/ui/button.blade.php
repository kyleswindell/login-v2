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
