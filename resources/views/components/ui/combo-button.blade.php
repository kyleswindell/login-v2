@props([
    'items' => [],
    'label' => 'Apply',
    'menuLabel' => 'Choose action',
    'action' => null,
    'size' => 'md',
    'align' => 'bottom-end',
    'placement' => null,
    'open' => false,
    'disabled' => false,
    'loading' => false,
])

@php($resolvedPlacement = $placement ?? $align)

<div
    class="ui-combo-button inline-flex items-start"
    data-ui-component="combo-button"
    data-ui-combo-button
    data-ui-combo-button-size="{{ $size }}"
>
    <x-ui.button semantic="primary" :size="$size" :disabled="$disabled || $loading" :loading="$loading" class="rounded-r-none" data-ui-combo-button-primary>
        {{ $label }}
    </x-ui.button>
    <x-ui.menu
        :items="$items"
        :trigger-label="$menuLabel"
        trigger-kind="icon"
        trigger-variant="primary"
        :size="$size"
        :placement="$resolvedPlacement"
        :open="$open"
        :disabled="$disabled || $loading"
        class="-ml-px"
        data-ui-menu-button-kind="combo"
        data-ui-combo-button-trigger
    />
</div>
