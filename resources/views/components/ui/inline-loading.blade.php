@props([
    'status' => 'loading',
    'label' => null,
    'live' => 'polite',
])

@php
    $resolved = in_array($status, ['loading', 'success', 'error', 'warning', 'info'], true) ? $status : 'loading';
    $semantic = match ($resolved) {
        'success' => 'success',
        'error' => 'danger',
        'warning' => 'warning',
        'info' => 'info',
        default => 'neutral',
    };
@endphp

<span
    class="inline-flex items-center gap-2 text-sm"
    style="color: var(--ui-text-secondary);"
    role="status"
    aria-live="{{ $live }}"
    data-ui-component="inline-loading"
    data-ui-inline-loading-status="{{ $resolved }}"
>
    @if ($resolved === 'loading')
        <span class="ui-spinner" aria-hidden="true"></span>
    @else
        <x-ui.status-icon :icon="$resolved === 'error' ? 'x-circle' : ($resolved === 'warning' ? 'exclamation-triangle' : ($resolved === 'success' ? 'check-circle' : 'information-circle'))" class="h-4 w-4" />
    @endif
    <span>{{ $label ?? $slot }}</span>
</span>
