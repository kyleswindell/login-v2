@props([
    'id' => null,
    'label' => 'Open popover',
    'panelLabel' => null,
    'placement' => 'bottom',
    'align' => 'start',
    'size' => 'md',
    'open' => false,
    'disabled' => false,
    'closeable' => true,
])

@php
    $popoverId = $id ?? 'popover-'.str()->random(8);
    $placement = in_array($placement, ['top', 'right', 'bottom', 'left'], true) ? $placement : 'bottom';
    $align = in_array($align, ['start', 'center', 'end'], true) ? $align : 'start';
    $size = in_array($size, ['sm', 'md', 'lg'], true) ? $size : 'md';
@endphp

<span
    {{ $attributes->class(['ui-popover']) }}
    data-ui-component="popover"
    data-ui-popover
    data-ui-popover-placement="{{ $placement }}"
    data-ui-popover-align="{{ $align }}"
    data-ui-popover-size="{{ $size }}"
>
    <button
        type="button"
        class="ui-action ui-action-ghost ui-action-sm"
        aria-haspopup="dialog"
        aria-expanded="{{ $open ? 'true' : 'false' }}"
        aria-controls="{{ $popoverId }}"
        @disabled($disabled)
        data-ui-popover-trigger
    >
        {{ $label }}
    </button>

    <span
        id="{{ $popoverId }}"
        class="ui-popover-panel"
        role="dialog"
        @if($panelLabel || $label) aria-label="{{ $panelLabel ?? $label }}" @endif
        data-ui-popover-panel
        @if(! $open) hidden @endif
    >
        <span class="ui-popover-content">
            {{ $slot }}
        </span>
        @if ($closeable)
            <button type="button" class="ui-popover-close" aria-label="Close {{ $panelLabel ?? $label }}" data-ui-popover-close>x</button>
        @endif
    </span>
</span>
