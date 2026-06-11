@props([
    'id' => null,
    'label' => 'Open popover',
    'panelLabel' => null,
    'placement' => 'bottom',
    'align' => 'start',
    'size' => 'md',
    'tip' => 'caret',
    'caret' => null,
    'triggerKind' => 'icon',
    'triggerIcon' => 'heroicon-o-information-circle',
    'interaction' => 'click',
    'open' => false,
    'disabled' => false,
    'closeable' => true,
])

@php
    $popoverId = $id ?? 'popover-'.str()->random(8);
    $placement = in_array($placement, ['top', 'right', 'bottom', 'left'], true) ? $placement : 'bottom';
    $align = in_array($align, ['start', 'center', 'end'], true) ? $align : 'start';
    $size = in_array($size, ['sm', 'md', 'lg'], true) ? $size : 'md';
    $resolvedTip = in_array($tip, ['none', 'caret', 'tab'], true) ? $tip : 'caret';
    $resolvedTriggerKind = in_array($triggerKind, ['icon', 'button', 'ghost'], true) ? $triggerKind : 'icon';
    $resolvedInteraction = in_array($interaction, ['click', 'hover', 'focus'], true) ? $interaction : 'click';

    if ($caret === false) {
        $resolvedTip = 'none';
    }
@endphp

<span
    {{ $attributes->class(['ui-popover']) }}
    data-ui-component="popover"
    data-ui-popover
    data-ui-popover-placement="{{ $placement }}"
    data-ui-popover-align="{{ $align }}"
    data-ui-popover-size="{{ $size }}"
    data-ui-popover-tip="{{ $resolvedTip }}"
    data-ui-popover-trigger-kind="{{ $resolvedTriggerKind }}"
    data-ui-popover-interaction="{{ $resolvedInteraction }}"
>
    @if ($resolvedTriggerKind === 'icon')
        <button
            type="button"
            class="ui-popover-trigger ui-icon-button ui-icon-button-md ui-action-ghost"
            aria-label="{{ $label }}"
            aria-haspopup="dialog"
            aria-expanded="{{ $open ? 'true' : 'false' }}"
            aria-controls="{{ $popoverId }}"
            @disabled($disabled)
            data-ui-popover-trigger
        >
            <x-dynamic-component :component="$triggerIcon" class="ui-icon-button-icon" aria-hidden="true" />
        </button>
    @else
        <button
            type="button"
            @class([
                'ui-popover-trigger',
                'ui-action',
                'ui-action-sm',
                'ui-action-ghost' => $resolvedTriggerKind === 'ghost',
                'ui-action-secondary' => $resolvedTriggerKind === 'button',
            ])
            aria-haspopup="dialog"
            aria-expanded="{{ $open ? 'true' : 'false' }}"
            aria-controls="{{ $popoverId }}"
            @disabled($disabled)
            data-ui-popover-trigger
        >
            <span class="ui-button-label">{{ $label }}</span>
            @if ($resolvedTriggerKind === 'button')
                <x-heroicon-o-chevron-down class="ui-button-icon" aria-hidden="true" />
            @endif
        </button>
    @endif

    <div
        id="{{ $popoverId }}"
        class="ui-popover-panel"
        role="dialog"
        @if($panelLabel || $label) aria-label="{{ $panelLabel ?? $label }}" @endif
        data-ui-popover-panel
        @if(! $open) hidden @endif
    >
        @if ($resolvedTip !== 'none')
            <span class="ui-popover-tip" aria-hidden="true" data-ui-popover-tip-shape></span>
        @endif
        @isset($title)
            <div class="ui-popover-header">
                <h4 class="ui-popover-title">{{ $title }}</h4>
            </div>
        @endisset
        <div class="ui-popover-content" data-ui-popover-content>
            {{ $slot }}
        </div>
        @isset($footer)
            <div class="ui-popover-footer">
                {{ $footer }}
            </div>
        @endisset
        @if ($closeable)
            <button type="button" class="ui-popover-close" aria-label="Close {{ $panelLabel ?? $label }}" data-ui-popover-close>
                <x-heroicon-o-x-mark class="ui-popover-close-icon" aria-hidden="true" />
            </button>
        @endif
    </div>
</span>
