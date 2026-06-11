@props([
    'label',
    'state' => 'upcoming',
])

@php
    $resolved = in_array($state, ['complete', 'current', 'error', 'upcoming'], true) ? $state : 'upcoming';
@endphp

<li
    class="flex items-center gap-2"
    data-ui-component="progress-step"
    data-ui-progress-step-state="{{ $resolved }}"
>
    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full border text-xs font-semibold" style="border-color: var(--ui-border-subtle-01); background-color: {{ $resolved === 'current' ? 'var(--ui-layer-selected-01)' : 'var(--ui-layer-01)' }}; color: var(--ui-text-primary);">
        @if ($resolved === 'complete') ✓ @elseif ($resolved === 'error') ! @else • @endif
    </span>
    <span class="text-sm" style="color: var(--ui-text-primary);">{{ $label }}</span>
</li>
