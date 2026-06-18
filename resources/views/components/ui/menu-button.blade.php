@props([
    'items' => [],
    'label' => 'Actions',
    'type' => 'primary',
    'variant' => null,
    'size' => 'md',
    'align' => 'bottom-start',
    'placement' => null,
    'open' => false,
    'disabled' => false,
    'loading' => false,
])

@php
    $requestedType = $variant ?? $type;
    $resolvedType = match ($requestedType) {
        'outline' => 'tertiary',
        'primary', 'tertiary', 'ghost' => $requestedType,
        default => 'primary',
    };

    $requestedPlacement = $placement ?? $align;
    $resolvedPlacement = match ($requestedPlacement) {
        'start' => 'bottom-start',
        'end' => 'bottom-end',
        'top', 'top-start', 'top-end', 'bottom', 'bottom-start', 'bottom-end' => $requestedPlacement,
        default => 'bottom-start',
    };

    $resolvedSize = in_array($size, ['xs', 'sm', 'md', 'lg'], true) ? $size : 'md';
@endphp

<div
    class="ui-menu-button ui-menu-button-{{ $resolvedType }} ui-menu-button-{{ $resolvedSize }} {{ $open ? 'ui-menu-button-open' : '' }}"
    data-ui-component="menu-button"
    data-ui-menu-button
    data-ui-menu-button-type="{{ $resolvedType }}"
    data-ui-menu-button-size="{{ $resolvedSize }}"
>
    <x-ui.menu
        :items="$items"
        :trigger-label="$label"
        trigger-kind="text"
        :trigger-variant="$resolvedType"
        :size="$resolvedSize"
        :placement="$resolvedPlacement"
        :open="$open"
        :disabled="$disabled || $loading"
        trigger-class="ui-menu-button-trigger"
        data-ui-menu-button-kind="menu"
        data-ui-menu-button-loading="{{ $loading ? 'true' : 'false' }}"
    />
</div>
