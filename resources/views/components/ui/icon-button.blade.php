@props([
    'href' => null,
    'type' => 'button',
    'label' => null,
    'ariaLabel' => null,
    'icon' => null,
    'semantic' => 'ghost',
    'size' => 'md',
    'tooltip' => null,
    'disabled' => false,
    'loading' => false,
])

@php
    $isLink = filled($href) && ! $disabled;
    $accessibleLabel = $ariaLabel ?? $label ?? $tooltip ?? 'Icon button';
    $tooltipText = $tooltip ?? $label;
    $semanticMap = [
        'primary' => ['primary', 'base'],
        'secondary' => ['neutral', 'base'],
        'tertiary' => ['neutral', 'outline'],
        'ghost' => ['neutral', 'ghost'],
        'danger' => ['danger', 'base'],
        'danger-tertiary' => ['danger', 'outline'],
        'danger-ghost' => ['danger', 'ghost'],
        'neutral' => ['neutral', 'base'],
        'success' => ['success', 'base'],
        'warning' => ['warning', 'base'],
        'notice' => ['notice', 'base'],
        'info' => ['info', 'base'],
    ];
    $allowedSizes = ['xs', 'sm', 'md', 'lg', 'lg-expressive', 'xl', '2xl'];
    [$resolvedSemantic, $resolvedVariant] = $semanticMap[$semantic] ?? $semanticMap['ghost'];
    $resolvedSize = in_array($size, $allowedSizes, true) ? $size : 'md';

    $classes = ['ui-icon-button', 'ui-icon-button-'.$resolvedSize];
    $isDisabled = $disabled || $loading;

    if ($resolvedVariant !== 'base') {
        $classes[] = 'ui-action-'.$resolvedVariant;
    }

    if ($resolvedSemantic !== 'neutral') {
        $classes[] = 'ui-action-'.$resolvedSemantic;
    }
@endphp

@if ($isLink)
    <a
        href="{{ $href }}"
        aria-label="{{ $accessibleLabel }}"
        @if (filled($tooltipText)) title="{{ $tooltipText }}" @endif
        {{ $attributes->class($classes)->merge(['data-ui-component' => 'icon-button']) }}
    >
        @if (filled($icon))
            <x-dynamic-component :component="$icon" class="ui-icon-button-icon" aria-hidden="true" />
        @else
            {{ $slot }}
        @endif
    </a>
@else
    <button
        type="{{ $type }}"
        aria-label="{{ $accessibleLabel }}"
        @if (filled($tooltipText)) title="{{ $tooltipText }}" @endif
        @if ($loading) aria-busy="true" @endif
        @disabled($isDisabled)
        {{ $attributes->class($classes)->merge(['data-ui-component' => 'icon-button']) }}
    >
        @if ($loading)
            <span class="ui-spinner" aria-hidden="true"></span>
        @elseif (filled($icon))
            <x-dynamic-component :component="$icon" class="ui-icon-button-icon" aria-hidden="true" />
        @else
            {{ $slot }}
        @endif
    </button>
@endif
