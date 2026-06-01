@props([
    'href' => null,
    'type' => 'button',
    'semantic' => 'neutral',
    'current' => false,
    'disabled' => false,
])

@php
    $allowedSemantics = ['neutral', 'primary', 'success', 'warning', 'danger', 'notice', 'info'];
    $resolvedSemantic = in_array($semantic, $allowedSemantics, true) ? $semantic : 'neutral';
    $isCurrent = (bool) $current;

    $semanticClasses = [
        'neutral' => 'text-[var(--ui-text-muted)] hover:bg-[var(--ui-surface-muted)] hover:text-[var(--ui-text-strong)] focus-visible:bg-[var(--ui-surface-muted)] focus-visible:text-[var(--ui-text-strong)]',
        'primary' => 'text-[var(--ui-action-outline-primary-text)] hover:bg-[var(--ui-action-outline-primary-bg-hover)] focus-visible:bg-[var(--ui-action-outline-primary-bg-hover)]',
        'success' => 'text-[var(--ui-action-outline-success-text)] hover:bg-[var(--ui-action-outline-success-bg-hover)] focus-visible:bg-[var(--ui-action-outline-success-bg-hover)]',
        'warning' => 'text-[var(--ui-action-outline-warning-text)] hover:bg-[var(--ui-action-outline-warning-bg-hover)] focus-visible:bg-[var(--ui-action-outline-warning-bg-hover)]',
        'danger' => 'text-[var(--ui-action-outline-danger-text)] hover:bg-[var(--ui-action-outline-danger-bg-hover)] focus-visible:bg-[var(--ui-action-outline-danger-bg-hover)]',
        'notice' => 'text-[var(--ui-action-outline-notice-text)] hover:bg-[var(--ui-action-outline-notice-bg-hover)] focus-visible:bg-[var(--ui-action-outline-notice-bg-hover)]',
        'info' => 'text-[var(--ui-action-outline-info-text)] hover:bg-[var(--ui-action-outline-info-bg-hover)] focus-visible:bg-[var(--ui-action-outline-info-bg-hover)]',
    ];

    $currentClasses = [
        'neutral' => 'border-[color:var(--ui-action-soft-neutral-border)] bg-[color:var(--ui-action-soft-neutral-bg)] font-semibold text-[color:var(--ui-action-soft-neutral-text)] hover:bg-[color:var(--ui-action-soft-neutral-bg-hover)] focus-visible:bg-[color:var(--ui-action-soft-neutral-bg-hover)]',
        'primary' => 'border-[color:var(--ui-action-soft-primary-border)] bg-[color:var(--ui-action-soft-primary-bg)] font-semibold text-[color:var(--ui-action-soft-primary-text)] hover:bg-[color:var(--ui-action-soft-primary-bg-hover)] focus-visible:bg-[color:var(--ui-action-soft-primary-bg-hover)]',
        'success' => 'border-[color:var(--ui-action-soft-success-border)] bg-[color:var(--ui-action-soft-success-bg)] font-semibold text-[color:var(--ui-action-soft-success-text)] hover:bg-[color:var(--ui-action-soft-success-bg-hover)] focus-visible:bg-[color:var(--ui-action-soft-success-bg-hover)]',
        'warning' => 'border-[color:var(--ui-action-soft-warning-border)] bg-[color:var(--ui-action-soft-warning-bg)] font-semibold text-[color:var(--ui-action-soft-warning-text)] hover:bg-[color:var(--ui-action-soft-warning-bg-hover)] focus-visible:bg-[color:var(--ui-action-soft-warning-bg-hover)]',
        'danger' => 'border-[color:var(--ui-action-soft-danger-border)] bg-[color:var(--ui-action-soft-danger-bg)] font-semibold text-[color:var(--ui-action-soft-danger-text)] hover:bg-[color:var(--ui-action-soft-danger-bg-hover)] focus-visible:bg-[color:var(--ui-action-soft-danger-bg-hover)]',
        'notice' => 'border-[color:var(--ui-action-soft-notice-border)] bg-[color:var(--ui-action-soft-notice-bg)] font-semibold text-[color:var(--ui-action-soft-notice-text)] hover:bg-[color:var(--ui-action-soft-notice-bg-hover)] focus-visible:bg-[color:var(--ui-action-soft-notice-bg-hover)]',
        'info' => 'border-[color:var(--ui-action-soft-info-border)] bg-[color:var(--ui-action-soft-info-bg)] font-semibold text-[color:var(--ui-action-soft-info-text)] hover:bg-[color:var(--ui-action-soft-info-bg-hover)] focus-visible:bg-[color:var(--ui-action-soft-info-bg-hover)]',
    ];

    $classes = [
        'flex w-full items-center gap-2 rounded-md border border-transparent px-3 py-2 text-left text-sm font-medium transition focus-visible:outline-none',
        $isCurrent ? $currentClasses[$resolvedSemantic] : $semanticClasses[$resolvedSemantic],
    ];

    if ($disabled) {
        $classes[] = 'cursor-not-allowed border-transparent bg-transparent text-[var(--ui-action-disabled-text)]';
    }

    $isLink = filled($href) && ! $disabled;
@endphp

@if ($isLink)
    <a
        href="{{ $href }}"
        @if ($isCurrent) aria-current="true" @endif
        {{ $attributes->class($classes)->merge(['data-ui-component' => 'menu-item', 'data-ui-current' => $isCurrent ? 'true' : 'false']) }}
    >
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        @disabled($disabled)
        {{ $attributes->class($classes)->merge(['data-ui-component' => 'menu-item', 'data-ui-current' => $isCurrent ? 'true' : 'false']) }}
    >
        {{ $slot }}
    </button>
@endif
