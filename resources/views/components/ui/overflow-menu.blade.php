@props([
    'items' => [],
    'label' => 'More actions',
    'ariaLabel' => null,
    'tooltip' => null,
    'size' => 'md',
    'align' => 'bottom-end',
    'placement' => null,
    'open' => false,
    'disabled' => false,
])

@php
    $requestedPlacement = $placement ?? $align;
    $resolvedPlacement = match ($requestedPlacement) {
        'start' => 'bottom-start',
        'end' => 'bottom-end',
        'top', 'top-start', 'top-end', 'bottom', 'bottom-start', 'bottom-end' => $requestedPlacement,
        default => 'bottom-end',
    };

    $resolvedSize = in_array($size, ['xs', 'sm', 'md', 'lg'], true) ? $size : 'md';
    $resolvedAriaLabel = $ariaLabel ?? $attributes->get('aria-label') ?? $label;
    $rootAttributes = $attributes->except('aria-label');
@endphp

<div
    {{ $rootAttributes->class(['ui-overflow-menu', 'ui-overflow-menu-'.$resolvedSize, 'ui-overflow-menu-open' => $open]) }}
    data-ui-component="overflow-menu"
    data-ui-overflow-menu
    data-ui-overflow-menu-size="{{ $resolvedSize }}"
>
    <x-ui.menu
        :items="$items"
        :trigger-label="$resolvedAriaLabel"
        :trigger-tooltip="$tooltip"
        :menu-label="$label"
        trigger-kind="icon"
        trigger-icon="heroicon-o-ellipsis-vertical"
        trigger-variant="ghost"
        :size="$resolvedSize"
        :placement="$resolvedPlacement"
        :open="$open"
        :disabled="$disabled"
        trigger-class="ui-overflow-menu-trigger"
        data-ui-menu-button-kind="overflow"
    />
</div>
