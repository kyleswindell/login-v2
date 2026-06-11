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

@php($resolvedPlacement = $placement ?? $align)

<div class="ui-overflow-menu" data-ui-component="overflow-menu" data-ui-overflow-menu data-ui-overflow-menu-size="{{ $size }}">
    <x-ui.menu
        :items="$items"
        :trigger-label="$ariaLabel ?? $label"
        :menu-label="$label"
        trigger-kind="icon"
        trigger-variant="ghost"
        :size="$size"
        :placement="$resolvedPlacement"
        :open="$open"
        :disabled="$disabled"
        data-ui-menu-button-kind="overflow"
        @if (filled($tooltip)) title="{{ $tooltip }}" @endif
    />
</div>
