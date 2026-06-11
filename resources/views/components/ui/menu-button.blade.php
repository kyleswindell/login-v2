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
    $resolvedType = $variant ?? $type;
    $resolvedPlacement = $placement ?? $align;
@endphp

<div class="ui-menu-button" data-ui-component="menu-button" data-ui-menu-button data-ui-menu-button-type="{{ $resolvedType }}" data-ui-menu-button-size="{{ $size }}">
    <x-ui.menu
        :items="$items"
        :trigger-label="$label"
        trigger-kind="text"
        :trigger-variant="$resolvedType"
        :size="$size"
        :placement="$resolvedPlacement"
        :open="$open"
        :disabled="$disabled || $loading"
        data-ui-menu-button-kind="menu"
        data-ui-menu-button-loading="{{ $loading ? 'true' : 'false' }}"
    />
</div>
