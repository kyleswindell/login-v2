@props([
    'href' => null,
    'type' => 'button',
    'semantic' => 'neutral',
    'current' => false,
    'selected' => false,
    'disabled' => false,
    'shortcut' => null,
    'submenu' => false,
    'size' => 'md',
    'state' => null,
    'selectionType' => null,
    'title' => null,
])

@php
    $allowedSemantics = ['neutral', 'primary', 'success', 'warning', 'danger', 'notice', 'info'];
    $resolvedSemantic = in_array($semantic, $allowedSemantics, true) ? $semantic : 'neutral';
    $resolvedSize = in_array($size, ['xs', 'sm', 'md', 'lg'], true) ? $size : 'md';
    $requestedSelectionType = $selectionType === 'multi' ? 'multiple' : $selectionType;
    $resolvedSelectionType = in_array($requestedSelectionType, ['single', 'multiple'], true) ? $requestedSelectionType : null;
    $isCurrent = (bool) $current;
    $isSelected = (bool) $selected;
    $resolvedRole = match ($resolvedSelectionType) {
        'single' => 'menuitemradio',
        'multiple' => 'menuitemcheckbox',
        default => 'menuitem',
    };

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
        'ui-menu-item flex w-full items-center gap-2 rounded-md border border-transparent text-left text-sm font-medium transition focus-visible:outline-none',
        'ui-menu-item-'.$resolvedSize,
        $isCurrent ? $currentClasses[$resolvedSemantic] : $semanticClasses[$resolvedSemantic],
    ];

    if ($isSelected) {
        $classes[] = 'is-selected';
    }

    if (filled($state)) {
        $classes[] = 'is-'.$state;
    }

    if ($disabled) {
        $classes[] = 'cursor-not-allowed border-transparent bg-transparent text-[var(--ui-action-disabled-text)]';
    }

    $isLink = filled($href) && ! $disabled;
    $stateValue = filled($state)
        ? $state
        : ($disabled ? 'disabled' : ($isSelected ? 'selected' : 'default'));
@endphp

@if ($isLink)
    <a
        href="{{ $href }}"
        @if ($isCurrent) aria-current="true" @endif
        @if ($resolvedSelectionType) aria-checked="{{ $isSelected ? 'true' : 'false' }}" @endif
        @if ($submenu) aria-haspopup="menu" aria-expanded="false" @endif
        @if (filled($title)) title="{{ $title }}" @endif
        {{ $attributes->class($classes)->merge([
            'data-ui-component' => 'menu-item',
            'data-ui-menu-item' => true,
            'data-ui-menu-item-size' => $resolvedSize,
            'data-ui-menu-item-state' => $stateValue,
            'data-ui-menu-submenu-trigger' => $submenu ? true : null,
            'data-ui-current' => $isCurrent ? 'true' : 'false',
            'role' => $resolvedRole,
        ]) }}
    >
        @if ($isSelected)
            <span class="ui-menu-item-check" aria-hidden="true">✓</span>
        @endif
        <span class="ui-menu-item-label">{{ $slot }}</span>
        @if (filled($shortcut))
            <kbd class="ui-menu-item-shortcut">{{ $shortcut }}</kbd>
        @endif
        @if ($submenu)
            <span class="ui-menu-item-submenu" aria-hidden="true">›</span>
        @endif
    </a>
@else
    <button
        type="{{ $type }}"
        @disabled($disabled)
        @if ($resolvedSelectionType) aria-checked="{{ $isSelected ? 'true' : 'false' }}" @endif
        @if ($submenu) aria-haspopup="menu" aria-expanded="false" @endif
        @if (filled($title)) title="{{ $title }}" @endif
        {{ $attributes->class($classes)->merge([
            'data-ui-component' => 'menu-item',
            'data-ui-menu-item' => true,
            'data-ui-menu-item-size' => $resolvedSize,
            'data-ui-menu-item-state' => $stateValue,
            'data-ui-menu-submenu-trigger' => $submenu ? true : null,
            'data-ui-current' => $isCurrent ? 'true' : 'false',
            'role' => $resolvedRole,
        ]) }}
    >
        @if ($isSelected)
            <span class="ui-menu-item-check" aria-hidden="true">✓</span>
        @endif
        <span class="ui-menu-item-label">{{ $slot }}</span>
        @if (filled($shortcut))
            <kbd class="ui-menu-item-shortcut">{{ $shortcut }}</kbd>
        @endif
        @if ($submenu)
            <span class="ui-menu-item-submenu" aria-hidden="true">›</span>
        @endif
    </button>
@endif
