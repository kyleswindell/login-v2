@props([
    'items' => [],
    'label' => 'Apply',
    'menuLabel' => 'Additional actions',
    'action' => null,
    'size' => 'md',
    'align' => 'bottom-end',
    'placement' => null,
    'open' => false,
    'disabled' => false,
    'loading' => false,
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
@endphp

<div
    class="ui-combo-button ui-combo-button-{{ $resolvedSize }} {{ $open ? 'ui-combo-button-open' : '' }}"
    data-ui-component="combo-button"
    data-ui-combo-button
    data-ui-combo-button-size="{{ $resolvedSize }}"
>
    <div class="ui-combo-button-primary" data-ui-combo-button-primary>
        <x-ui.button semantic="primary" :size="$resolvedSize" :disabled="$disabled || $loading" :loading="$loading" data-ui-combo-button-primary-action>
            {{ $label }}
        </x-ui.button>
    </div>
    <x-ui.menu
        :items="$items"
        :trigger-label="$menuLabel"
        trigger-kind="icon"
        trigger-icon="heroicon-o-chevron-down"
        trigger-variant="primary"
        :size="$resolvedSize"
        :placement="$resolvedPlacement"
        :open="$open"
        :disabled="$disabled || $loading"
        trigger-class="ui-combo-button-trigger"
        class="ui-combo-button-menu"
        data-ui-menu-button-kind="combo"
        data-ui-combo-button-trigger
    />
</div>
