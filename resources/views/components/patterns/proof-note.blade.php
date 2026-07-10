@props([
    'title' => null,
    'semantic' => 'notice',
])

@php
    $notificationKind = match ($semantic) {
        'danger', 'error' => 'error',
        'success' => 'success',
        'warning' => 'warning',
        default => 'info',
    };
@endphp

<x-ui.notification.inline
    :kind="$notificationKind"
    :title="$title"
    {{ $attributes->class(['ui-pattern-proof-note']) }}
>
    {{ $slot }}
</x-ui.notification.inline>
