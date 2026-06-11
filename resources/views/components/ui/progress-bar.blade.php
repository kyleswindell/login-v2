@props([
    'value' => null,
    'max' => 100,
    'label' => null,
    'status' => 'neutral',
])

@php
    $isIndeterminate = $value === null;
    $percent = $isIndeterminate ? 100 : max(0, min(100, ((float) $value / max(1, (float) $max)) * 100));
@endphp

<div data-ui-component="progress-bar" data-ui-progress-bar-status="{{ $status }}">
    @if ($label)
        <div class="mb-2 flex items-center justify-between text-sm">
            <span style="color: var(--ui-text-primary);">{{ $label }}</span>
            @unless($isIndeterminate)
                <span style="color: var(--ui-text-secondary);">{{ round($percent) }}%</span>
            @endunless
        </div>
    @endif
    <div
        class="h-2 overflow-hidden rounded-full"
        style="background-color: var(--ui-skeleton-background);"
        role="progressbar"
        @unless($isIndeterminate) aria-valuenow="{{ $value }}" aria-valuemin="0" aria-valuemax="{{ $max }}" @endunless
    >
        <div class="h-full rounded-full transition-[width]" style="width: {{ $percent }}%; background-color: var(--ui-border-interactive);"></div>
    </div>
</div>
