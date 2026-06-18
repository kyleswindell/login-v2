@props([
    'href' => null,
    'type' => 'button',
    'semantic' => 'neutral',
    'tone' => null,
    'danger' => false,
    'dangerDescription' => null,
    'action' => null,
    'method' => null,
    'current' => false,
    'selected' => false,
    'disabled' => false,
    'shortcut' => null,
    'submenu' => false,
    'size' => 'md',
    'state' => null,
    'selectionType' => null,
    'title' => null,
    'reserveIndicator' => false,
    'closeOnActivate' => true,
])

@php
    $isDivider = $type === 'divider';
    $allowedSemantics = ['neutral', 'primary', 'success', 'warning', 'danger', 'notice', 'info'];
    $resolvedSemantic = ($danger || $tone === 'danger')
        ? 'danger'
        : (in_array($semantic, $allowedSemantics, true) ? $semantic : 'neutral');
    $resolvedSize = in_array($size, ['xs', 'sm', 'md', 'lg'], true) ? $size : 'md';
    $resolvedMethod = filled($method) && in_array(strtoupper($method), ['GET', 'POST', 'PATCH', 'DELETE'], true)
        ? strtoupper($method)
        : null;
    $requestedSelectionType = $selectionType === 'multi' ? 'multiple' : $selectionType;
    $resolvedSelectionType = in_array($requestedSelectionType, ['single', 'multiple'], true) ? $requestedSelectionType : null;
    $isCurrent = (bool) $current;
    $isSelected = (bool) $selected;
    $shouldReserveIndicator = (bool) $reserveIndicator || filled($resolvedSelectionType) || $isSelected;
    $resolvedRole = match ($resolvedSelectionType) {
        'single' => 'menuitemradio',
        'multiple' => 'menuitemcheckbox',
        default => 'menuitem',
    };

    $classes = [
        'ui-menu-item',
        'ui-menu-item-'.$resolvedSize,
        'ui-menu-item-'.$resolvedSemantic,
    ];

    if ($disabled) {
        $classes[] = 'ui-menu-item-disabled';
    }

    if ($isSelected && ! $disabled) {
        $classes[] = 'is-selected';
    }

    if (filled($state) && ! $disabled) {
        $classes[] = 'is-'.$state;
    }

    if ($isCurrent && ! $disabled) {
        $classes[] = 'ui-menu-item-current';
    }

    $isLink = filled($href) && ! $disabled;
    $stateValue = $disabled
        ? 'disabled'
        : (filled($state) ? $state : ($isSelected ? 'selected' : 'default'));
    $dangerDescriptionId = $resolvedSemantic === 'danger' && filled($dangerDescription)
        ? 'ui-menu-item-danger-description-'.Str::uuid()
        : null;
@endphp

@if ($isDivider)
    <div
        {{ $attributes->class('ui-menu-divider')->merge([
            'role' => 'separator',
            'data-ui-component' => 'menu-divider',
            'data-ui-menu-divider' => true,
        ]) }}
    ></div>
@elseif ($isLink)
    <a
        href="{{ $href }}"
        @if ($isCurrent) aria-current="true" @endif
        @if ($resolvedSelectionType) aria-checked="{{ $isSelected ? 'true' : 'false' }}" @endif
        @if ($submenu) aria-haspopup="menu" aria-expanded="false" @endif
        @if (filled($dangerDescriptionId)) aria-describedby="{{ $dangerDescriptionId }}" @endif
        @if (filled($title)) title="{{ $title }}" @endif
        {{ $attributes->class($classes)->merge([
            'data-ui-component' => 'menu-item',
            'data-ui-menu-item' => true,
            'data-ui-menu-close' => $closeOnActivate && ! $submenu ? true : null,
            'data-ui-menu-action' => filled($action) ? $action : null,
            'data-ui-menu-method' => $resolvedMethod,
            'data-ui-menu-item-size' => $resolvedSize,
            'data-ui-menu-item-state' => $stateValue,
            'data-ui-menu-submenu-trigger' => $submenu ? true : null,
            'data-ui-current' => $isCurrent ? 'true' : 'false',
            'role' => $resolvedRole,
        ]) }}
    >
        @if ($shouldReserveIndicator)
            <span class="ui-menu-item-check" aria-hidden="true">
                @if ($isSelected)
                    <x-heroicon-o-check class="ui-menu-item-check-icon" />
                @endif
            </span>
        @endif
        <span class="ui-menu-item-label">{{ $slot }}</span>
        @if (filled($shortcut))
            <kbd class="ui-menu-item-shortcut">{{ $shortcut }}</kbd>
        @endif
        @if (filled($dangerDescriptionId))
            <span id="{{ $dangerDescriptionId }}" class="sr-only">{{ $dangerDescription }}</span>
        @endif
        @if ($submenu)
            <span class="ui-menu-item-submenu" aria-hidden="true">
                <x-heroicon-o-chevron-right class="ui-menu-item-submenu-icon" />
            </span>
        @endif
    </a>
@else
    <button
        type="{{ $type }}"
        @disabled($disabled)
        @if ($resolvedSelectionType) aria-checked="{{ $isSelected ? 'true' : 'false' }}" @endif
        @if ($submenu) aria-haspopup="menu" aria-expanded="false" @endif
        @if (filled($dangerDescriptionId)) aria-describedby="{{ $dangerDescriptionId }}" @endif
        @if (filled($title)) title="{{ $title }}" @endif
        {{ $attributes->class($classes)->merge([
            'data-ui-component' => 'menu-item',
            'data-ui-menu-item' => true,
            'data-ui-menu-close' => $closeOnActivate && ! $submenu ? true : null,
            'data-ui-menu-action' => filled($action) ? $action : null,
            'data-ui-menu-method' => $resolvedMethod,
            'data-ui-menu-item-size' => $resolvedSize,
            'data-ui-menu-item-state' => $stateValue,
            'data-ui-menu-submenu-trigger' => $submenu ? true : null,
            'data-ui-current' => $isCurrent ? 'true' : 'false',
            'role' => $resolvedRole,
        ]) }}
    >
        @if ($shouldReserveIndicator)
            <span class="ui-menu-item-check" aria-hidden="true">
                @if ($isSelected)
                    <x-heroicon-o-check class="ui-menu-item-check-icon" />
                @endif
            </span>
        @endif
        <span class="ui-menu-item-label">{{ $slot }}</span>
        @if (filled($shortcut))
            <kbd class="ui-menu-item-shortcut">{{ $shortcut }}</kbd>
        @endif
        @if (filled($dangerDescriptionId))
            <span id="{{ $dangerDescriptionId }}" class="sr-only">{{ $dangerDescription }}</span>
        @endif
        @if ($submenu)
            <span class="ui-menu-item-submenu" aria-hidden="true">
                <x-heroicon-o-chevron-right class="ui-menu-item-submenu-icon" />
            </span>
        @endif
    </button>
@endif
