@props([
    'href' => null,
    'type' => 'button',
    'label' => null,
    'ariaLabel' => null,
    'icon' => null,
    'semantic' => 'ghost',
    'size' => 'md',
    'tooltip' => null,
    'tooltipPlacement' => 'top',
    'tooltipAlign' => 'center',
    'tooltipSize' => 'single',
    'disabled' => false,
    'loading' => false,
])

@php
    $isLink = filled($href) && ! $disabled;
    $accessibleLabel = $ariaLabel ?? $label ?? $tooltip ?? 'Icon button';
    $tooltipText = $tooltip ?? $label;
    $tooltipId = filled($tooltip) ? 'ui-tooltip-'.Str::uuid() : null;
    $semanticMap = [
        'primary' => ['primary', 'base'],
        'secondary' => ['secondary', 'base'],
        'tertiary' => ['tertiary', 'outline'],
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
    $allowedTooltipPlacements = ['auto', 'top', 'right', 'bottom', 'left'];
    $allowedTooltipAlignments = ['start', 'center', 'end'];
    $allowedTooltipSizes = ['auto', 'single', 'multi', 'definition'];
    [$resolvedSemantic, $resolvedVariant] = $semanticMap[$semantic] ?? $semanticMap['ghost'];
    $resolvedSize = in_array($size, $allowedSizes, true) ? $size : 'md';
    $resolvedTooltipPlacement = in_array($tooltipPlacement, $allowedTooltipPlacements, true) ? $tooltipPlacement : 'top';
    $resolvedTooltipAlign = in_array($tooltipAlign, $allowedTooltipAlignments, true) ? $tooltipAlign : 'center';
    $resolvedTooltipSize = in_array($tooltipSize, $allowedTooltipSizes, true) ? $tooltipSize : 'single';

    $classes = ['ui-icon-button', 'ui-icon-button-'.$resolvedSize];
    $isDisabled = $disabled || $loading;

    if ($resolvedVariant !== 'base') {
        $classes[] = 'ui-action-'.$resolvedVariant;
    }

    if ($resolvedSemantic !== 'neutral') {
        $classes[] = 'ui-action-'.$resolvedSemantic;
    }
@endphp

@if (filled($tooltip))
    <span
        class="ui-tooltip"
        data-ui-component="tooltip"
        data-ui-tooltip
        data-ui-tooltip-kind="default"
        data-ui-tooltip-placement="{{ $resolvedTooltipPlacement }}"
        data-ui-tooltip-resolved-placement="{{ $resolvedTooltipPlacement === 'auto' ? 'top' : $resolvedTooltipPlacement }}"
        data-ui-tooltip-align="{{ $resolvedTooltipAlign }}"
        data-ui-tooltip-size="{{ $resolvedTooltipSize }}"
        data-ui-tooltip-state="closed"
    >
        <span class="ui-tooltip-trigger" data-ui-tooltip-trigger>
@endif

@if ($isLink)
    <a
        href="{{ $href }}"
        aria-label="{{ $accessibleLabel }}"
        @if (filled($tooltipId)) aria-describedby="{{ $tooltipId }}" @endif
        @if (filled($tooltipText) && blank($tooltip)) title="{{ $tooltipText }}" @endif
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
        @if (filled($tooltipId)) aria-describedby="{{ $tooltipId }}" @endif
        @if (filled($tooltipText) && blank($tooltip)) title="{{ $tooltipText }}" @endif
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

@if (filled($tooltip))
        </span>
        <span
            id="{{ $tooltipId }}"
            role="tooltip"
            class="ui-tooltip-content"
            aria-hidden="true"
            data-ui-tooltip-content
            data-ui-tooltip-id="{{ $tooltipId }}"
            data-ui-tooltip-state="closed"
            hidden
        >
            {{ $tooltipText }}
            <span class="ui-tooltip-caret" aria-hidden="true" data-ui-tooltip-caret></span>
        </span>
    </span>
@endif
