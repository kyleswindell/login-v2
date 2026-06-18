@props([
    'href' => null,
    'type' => 'button',
    'semantic' => 'primary',
    'variant' => null,
    'size' => 'lg',
    'expressive' => false,
    'loading' => false,
    'disabled' => false,
    'icon' => null,
    'iconPosition' => 'trailing',
    'dangerDescription' => null,
])

@php
    $allowedSemantics = [
        'primary',
        'secondary',
        'tertiary',
        'ghost',
        'danger',
        'danger-tertiary',
        'danger-ghost',
    ];
    $allowedSizes = ['xs', 'sm', 'md', 'lg', 'xl', '2xl'];
    $resolvedSemantic = in_array($semantic, $allowedSemantics, true) ? $semantic : 'primary';
    $resolvedSize = in_array($size, $allowedSizes, true) ? $size : 'lg';
    $resolvedExpressive = (bool) $expressive;

    if ($size === 'lg-expressive') {
        $resolvedSize = 'lg';
        $resolvedExpressive = true;
    }

    if (! in_array($semantic, $allowedSemantics, true)) {
        $resolvedSemantic = match ($semantic) {
            'neutral', 'warning', 'notice', 'info' => 'tertiary',
            'success' => 'primary',
            default => 'primary',
        };
    }

    if ($variant === 'outline' || $variant === 'soft') {
        $resolvedSemantic = $resolvedSemantic === 'danger' ? 'danger-tertiary' : 'tertiary';
    } elseif ($variant === 'ghost') {
        $resolvedSemantic = str_starts_with($resolvedSemantic, 'danger') ? 'danger-ghost' : 'ghost';
    }

    $isDisabled = $disabled || $loading;
    $isLink = filled($href) && ! $isDisabled;
    $renderIcon = filled($icon) && $iconPosition === 'trailing';
    $isDangerVariant = in_array($resolvedSemantic, ['danger', 'danger-tertiary', 'danger-ghost'], true);
    $dangerDescriptionId = $isDangerVariant && filled($dangerDescription)
        ? 'ui-button-danger-description-'.Str::uuid()
        : null;
    $existingDescribedBy = $attributes->get('aria-describedby');
    $ariaDescribedBy = collect([$existingDescribedBy, $dangerDescriptionId])
        ->filter()
        ->implode(' ');

    $classes = [
        'ui-button',
        'ui-button-'.$resolvedSemantic,
        'ui-button-'.$resolvedSize,
    ];

    if ($resolvedExpressive) {
        $classes[] = 'ui-button-expressive';
    }

    if ($loading) {
        $classes[] = 'ui-button-loading';
    }

    if ($isDisabled) {
        $classes[] = 'ui-button-disabled';
    }

    $showInverseSpinner = $loading && in_array($resolvedSemantic, ['primary', 'secondary', 'danger'], true);
    $componentAttributes = $attributes->except('aria-describedby');
@endphp

@if ($isLink)
    <a
        href="{{ $href }}"
        @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
        {{ $componentAttributes->class($classes)->merge(['data-ui-component' => 'button']) }}
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
        @disabled($isDisabled)
        @if ($loading) aria-busy="true" @endif
        @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
        {{ $componentAttributes->class($classes)->merge(['data-ui-component' => 'button']) }}
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

@if (filled($dangerDescriptionId))
    <span id="{{ $dangerDescriptionId }}" class="sr-only">{{ $dangerDescription }}</span>
@endif
