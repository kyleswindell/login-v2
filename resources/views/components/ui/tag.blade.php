@props([
    'tone' => 'neutral',
    'size' => 'md',
    'icon' => null,
    'removable' => false,
    'removeLabel' => null,
])

@php
    $toneMap = ['neutral' => 'neutral', 'info' => 'info', 'success' => 'success', 'warning' => 'warning', 'error' => 'danger', 'danger' => 'danger', 'inverse' => 'neutral'];
    $resolvedTone = $toneMap[$tone] ?? 'neutral';
@endphp

<span
    {{ $attributes->class(['ui-status-pill ui-status-'.$resolvedTone, 'text-[0.68rem] px-2 py-0.5' => $size === 'sm']) }}
    data-ui-component="tag"
    data-ui-tag-tone="{{ $tone }}"
>
    @if ($icon)
        <x-dynamic-component :component="$icon" class="h-3.5 w-3.5" aria-hidden="true" />
    @endif
    <span>{{ $slot }}</span>
    @if ($removable)
        <button type="button" class="ml-1 rounded focus:outline-none focus-visible:outline focus-visible:outline-2" aria-label="{{ $removeLabel ?? 'Remove tag' }}">×</button>
    @endif
</span>
