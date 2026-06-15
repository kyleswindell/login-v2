@props([
    'tone' => 'neutral',
    'size' => 'md',
    'icon' => null,
    'label' => null,
    'removable' => false,
    'removeLabel' => null,
])

@php
    $toneMap = [
        'neutral' => 'neutral',
        'info' => 'info',
        'notice' => 'info',
        'success' => 'success',
        'warning' => 'warning',
        'error' => 'error',
        'danger' => 'error',
        'inverse' => 'inverse',
    ];

    $sizeMap = ['sm' => 'sm', 'md' => 'md'];
    $resolvedTone = $toneMap[$tone] ?? 'neutral';
    $resolvedSize = $sizeMap[$size] ?? 'md';
    $isRemovableRequested = filter_var($removable, FILTER_VALIDATE_BOOLEAN);
@endphp

<span
    {{ $attributes->class([
        'ui-tag',
        'ui-tag-'.$resolvedTone,
        'ui-tag-'.$resolvedSize,
        'ui-tag-removable-gated' => $isRemovableRequested,
    ]) }}
    data-ui-component="tag"
    data-ui-tag-tone="{{ $resolvedTone }}"
    data-ui-tag-size="{{ $resolvedSize }}"
    @if ($isRemovableRequested) data-ui-tag-removable="gated" @endif
>
    @if ($icon)
        <x-dynamic-component :component="$icon" class="ui-tag-icon" aria-hidden="true" />
    @endif
    <span class="ui-tag-label">{{ $label ?? $slot }}</span>
</span>
