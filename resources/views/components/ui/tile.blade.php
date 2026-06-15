@props([
    'title' => null,
    'description' => null,
    'href' => null,
    'variant' => 'static',
    'selected' => false,
    'current' => false,
    'expanded' => false,
    'disabled' => false,
    'density' => 'standard',
    'type' => 'button',
    'name' => null,
    'value' => null,
    'selectionMode' => 'single',
    'icon' => null,
    'meta' => null,
    'loading' => false,
])

@php
    $variant = $variant === 'base' ? 'static' : $variant;
    $variant = in_array($variant, ['static', 'clickable', 'selectable', 'expandable'], true) ? $variant : 'static';
    $density = in_array($density, ['standard', 'compact'], true) ? $density : 'standard';
    $selectionMode = in_array($selectionMode, ['single', 'multiple'], true) ? $selectionMode : 'single';
    $inputType = $selectionMode === 'multiple' ? 'checkbox' : 'radio';
    $id = $attributes->get('id') ?: 'ui-tile-'.uniqid();
    $expandedPanelId = $id.'-expanded';
    $slotContent = trim((string) $slot);
    $usesSlotAsTitle = blank($title) && $slotContent !== '';
    $hasBody = filled($title) && $slotContent !== '';
    $detailsSlot = $details ?? null;
    $hasDetailsSlot = isset($detailsSlot) && trim((string) $detailsSlot) !== '';
    $isInteractive = in_array($variant, ['clickable', 'selectable', 'expandable'], true);
    $isSelected = (bool) $selected || (bool) $current;
    $rootClasses = [
        'ui-tile',
        'ui-tile--'.$variant,
        'ui-tile--density-'.$density,
        'ui-tile--selected' => $isSelected,
        'ui-tile--current' => (bool) $current,
        'ui-tile--expanded' => $variant === 'expandable' && (bool) $expanded,
        'ui-tile--collapsed' => $variant === 'expandable' && ! (bool) $expanded,
        'ui-tile--disabled' => (bool) $disabled,
        'ui-tile--loading' => (bool) $loading,
        'ui-tile--empty' => blank($title) && blank($description) && ! $hasBody,
    ];
    $tileAttributes = $attributes
        ->except(['id'])
        ->class($rootClasses)
        ->merge([
            'id' => $id,
            'data-ui-component' => 'tile',
            'data-ui-tile-variant' => $variant,
            'data-ui-tile-density' => $density,
            'data-ui-selected' => $isSelected ? 'true' : 'false',
            'data-ui-current' => $current ? 'true' : 'false',
            'data-ui-expanded' => $variant === 'expandable' && $expanded ? 'true' : 'false',
            'data-ui-disabled' => $disabled ? 'true' : 'false',
        ]);
@endphp

@if ($variant === 'clickable' && filled($href) && ! $disabled)
    <a
        href="{{ $href }}"
        {{ $tileAttributes }}
        @if($current) aria-current="page" @endif
        @if($loading) aria-busy="true" @endif
    >
        @include('components.ui.partials.tile-content', [
            'title' => $title,
            'description' => $description,
            'meta' => $meta,
            'icon' => $icon,
            'slot' => $slot,
            'usesSlotAsTitle' => $usesSlotAsTitle,
            'hasBody' => $hasBody,
        ])
        <span class="ui-tile__action-icon" aria-hidden="true">
            <x-heroicon-o-arrow-right />
        </span>
    </a>
@elseif ($variant === 'clickable')
    <button
        type="{{ $type }}"
        {{ $tileAttributes }}
        @if($disabled) disabled @endif
        @if($loading) aria-busy="true" @endif
    >
        @include('components.ui.partials.tile-content', [
            'title' => $title,
            'description' => $description,
            'meta' => $meta,
            'icon' => $icon,
            'slot' => $slot,
            'usesSlotAsTitle' => $usesSlotAsTitle,
            'hasBody' => $hasBody,
        ])
        <span class="ui-tile__action-icon" aria-hidden="true">
            <x-heroicon-o-arrow-right />
        </span>
    </button>
@elseif ($variant === 'selectable')
    <label
        {{ $tileAttributes->merge([
            'data-ui-tile-selection-mode' => $selectionMode,
            'aria-disabled' => $disabled ? 'true' : null,
        ]) }}
    >
        <input
            class="ui-tile__input"
            type="{{ $inputType }}"
            @if(filled($name)) name="{{ $name }}" @endif
            @if(filled($value)) value="{{ $value }}" @endif
            @if($selected) checked @endif
            @if($disabled) disabled @endif
        >
        <span class="ui-tile__selection-icon" aria-hidden="true"></span>
        @include('components.ui.partials.tile-content', [
            'title' => $title,
            'description' => $description,
            'meta' => $meta,
            'icon' => $icon,
            'slot' => $slot,
            'usesSlotAsTitle' => $usesSlotAsTitle,
            'hasBody' => $hasBody,
        ])
    </label>
@elseif ($variant === 'expandable')
    <div
        {{ $tileAttributes->merge([
            'aria-disabled' => $disabled ? 'true' : null,
            'aria-busy' => $loading ? 'true' : null,
        ]) }}
    >
        <button
            type="button"
            class="ui-tile__expand-trigger"
            aria-expanded="{{ $expanded ? 'true' : 'false' }}"
            aria-controls="{{ $expandedPanelId }}"
            @if($disabled) disabled @endif
        >
            @include('components.ui.partials.tile-content', [
                'title' => $title,
                'description' => $description,
                'meta' => $meta,
                'icon' => $icon,
                'slot' => $slot,
                'usesSlotAsTitle' => $usesSlotAsTitle,
                'hasBody' => $hasBody,
            ])
            <span class="ui-tile__action-icon" aria-hidden="true">
                <x-heroicon-o-chevron-down />
            </span>
        </button>

        @if ($hasDetailsSlot)
            <div
                id="{{ $expandedPanelId }}"
                class="ui-tile__expanded"
                @if(! $expanded) hidden @endif
            >
                {{ $detailsSlot }}
            </div>
        @endif
    </div>
@else
    <div
        {{ $tileAttributes->merge([
            'aria-busy' => $loading ? 'true' : null,
        ]) }}
    >
        @include('components.ui.partials.tile-content', [
            'title' => $title,
            'description' => $description,
            'meta' => $meta,
            'icon' => $icon,
            'slot' => $slot,
            'usesSlotAsTitle' => $usesSlotAsTitle,
            'hasBody' => $hasBody,
        ])

        @isset($actions)
            <div class="ui-tile__actions">
                {{ $actions }}
            </div>
        @endisset
    </div>
@endif
