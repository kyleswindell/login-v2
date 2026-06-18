@props([
    'label' => 'Copy to clipboard',
    'feedback' => 'Copied to clipboard',
    'copyState' => 'idle',
    'size' => 'md',
    'align' => 'bottom',
    'disabled' => false,
])

@php
    $resolvedState = $copyState === 'copied' ? 'copied' : 'idle';
    $resolvedSize = in_array($size, ['xs', 'sm', 'md', 'lg'], true) ? $size : 'md';
    $resolvedAlign = in_array($align, ['auto', 'top', 'right', 'bottom', 'left'], true) ? $align : 'bottom';
    $visibleLabel = $resolvedState === 'copied' ? $feedback : $label;
@endphp

<x-ui.tooltip
    :text="$visibleLabel"
    :placement="$resolvedAlign"
    size="single"
>
    <button
        type="button"
        aria-label="{{ $visibleLabel }}"
        @disabled($disabled)
        {{ $attributes->class([
            'ui-copy-button',
            'ui-copy-button-'.$resolvedSize,
            'ui-copy-button-copied' => $resolvedState === 'copied',
        ])->merge([
            'data-ui-component' => 'copy-button',
            'data-ui-copy-button' => true,
            'data-ui-copy-state' => $resolvedState,
            'data-ui-code-copy-state' => $resolvedState,
        ]) }}
    >
        <x-heroicon-o-clipboard-document class="ui-copy-button-icon" aria-hidden="true" />
        <span class="ui-copy-button-label">{{ $label }}</span>
        <span class="ui-copy-button-feedback" aria-hidden="true">{{ $visibleLabel }}</span>
    </button>
</x-ui.tooltip>
