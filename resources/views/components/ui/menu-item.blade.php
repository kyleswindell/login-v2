@props([
    'href' => null,
    'type' => 'button',
    'semantic' => 'neutral',
    'disabled' => false,
])

@php
    $allowedSemantics = ['neutral', 'primary', 'success', 'warning', 'danger', 'notice', 'info'];
    $resolvedSemantic = in_array($semantic, $allowedSemantics, true) ? $semantic : 'neutral';

    $semanticClasses = [
        'neutral' => 'text-[var(--ui-text-muted)] hover:bg-[var(--ui-surface-muted)] hover:text-[var(--ui-text-strong)] focus-visible:bg-[var(--ui-surface-muted)] focus-visible:text-[var(--ui-text-strong)]',
        'primary' => 'text-[var(--ui-action-outline-primary-text)] hover:bg-[var(--ui-action-outline-primary-bg-hover)] focus-visible:bg-[var(--ui-action-outline-primary-bg-hover)]',
        'success' => 'text-[var(--ui-action-outline-success-text)] hover:bg-[var(--ui-action-outline-success-bg-hover)] focus-visible:bg-[var(--ui-action-outline-success-bg-hover)]',
        'warning' => 'text-[var(--ui-action-outline-warning-text)] hover:bg-[var(--ui-action-outline-warning-bg-hover)] focus-visible:bg-[var(--ui-action-outline-warning-bg-hover)]',
        'danger' => 'text-[var(--ui-action-outline-danger-text)] hover:bg-[var(--ui-action-outline-danger-bg-hover)] focus-visible:bg-[var(--ui-action-outline-danger-bg-hover)]',
        'notice' => 'text-[var(--ui-action-outline-notice-text)] hover:bg-[var(--ui-action-outline-notice-bg-hover)] focus-visible:bg-[var(--ui-action-outline-notice-bg-hover)]',
        'info' => 'text-[var(--ui-action-outline-info-text)] hover:bg-[var(--ui-action-outline-info-bg-hover)] focus-visible:bg-[var(--ui-action-outline-info-bg-hover)]',
    ];

    $classes = [
        'flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-sm font-medium transition focus-visible:outline-none',
        $semanticClasses[$resolvedSemantic],
    ];

    if ($disabled) {
        $classes[] = 'cursor-not-allowed text-[var(--ui-action-disabled-text)]';
    }

    $isLink = filled($href) && ! $disabled;
@endphp

@if ($isLink)
    <a
        href="{{ $href }}"
        {{ $attributes->class($classes)->merge(['data-ui-component' => 'menu-item']) }}
    >
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        @disabled($disabled)
        {{ $attributes->class($classes)->merge(['data-ui-component' => 'menu-item']) }}
    >
        {{ $slot }}
    </button>
@endif
