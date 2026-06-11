@props([
    'href' => null,
    'type' => 'button',
    'semantic' => 'primary',
    'variant' => null,
    'size' => 'lg',
    'loading' => false,
    'disabled' => false,
    'icon' => null,
    'iconPosition' => 'trailing',
])

@php
    $semanticMap = [
        'primary' => ['primary', 'base'],
        'secondary' => ['neutral', 'base'],
        'tertiary' => ['neutral', 'outline'],
        'ghost' => ['neutral', 'ghost'],
        'danger' => ['danger', 'base'],
        'danger-tertiary' => ['danger', 'outline'],
        'danger-ghost' => ['danger', 'ghost'],
        // Existing app aliases remain valid while the Component API moves to action hierarchy names.
        'neutral' => ['neutral', 'base'],
        'success' => ['success', 'base'],
        'warning' => ['warning', 'base'],
        'notice' => ['notice', 'base'],
        'info' => ['info', 'base'],
    ];
    $allowedVariants = ['base', 'soft', 'outline', 'ghost'];
    $sizeMap = [
        'xs' => 'xs',
        'sm' => 'sm',
        'md' => 'md',
        'lg' => 'lg',
        'lg-expressive' => 'lg-expressive',
        'xl' => 'xl',
        '2xl' => '2xl',
    ];
    $ghostSizeClasses = [
        'xs' => '!px-[calc(0.625rem+1px)] !py-[calc(0.375rem+1px)]',
        'sm' => '!px-[calc(0.75rem+1px)] !py-[calc(0.375rem+1px)]',
        'md' => '!px-[calc(0.875rem+1px)] !py-[calc(0.5rem+1px)]',
        'lg' => '!px-[calc(1.125rem+1px)] !py-[calc(0.625rem+1px)]',
        'lg-expressive' => '!px-[calc(1.125rem+1px)] !py-[calc(0.625rem+1px)]',
        'xl' => '!px-[calc(1.25rem+1px)] !py-[calc(0.75rem+1px)]',
        '2xl' => '!px-[calc(1.5rem+1px)] !py-[calc(1rem+1px)]',
    ];

    [$resolvedSemantic, $semanticVariant] = $semanticMap[$semantic] ?? $semanticMap['primary'];
    $resolvedVariant = in_array($variant, $allowedVariants, true) ? $variant : $semanticVariant;
    $resolvedSize = $sizeMap[$size] ?? 'lg';

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

    $renderIcon = filled($icon) && $iconPosition === 'trailing';
@endphp

@if ($isLink)
    <a
        href="{{ $href }}"
        {{ $attributes->class($classes)->merge(['data-ui-component' => 'button']) }}
    >
        @if ($loading)
            <span @class(['ui-spinner', 'ui-spinner-inverse' => $showInverseSpinner]) aria-hidden="true"></span>
        @endif
        <span class="ui-button-label">{{ $slot }}</span>
        @if ($renderIcon)
            <x-dynamic-component :component="$icon" class="ui-button-icon" aria-hidden="true" />
        @endif
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
        <span class="ui-button-label">{{ $slot }}</span>
        @if ($renderIcon)
            <x-dynamic-component :component="$icon" class="ui-button-icon" aria-hidden="true" />
        @endif
    </button>
@endif
