{{-- ==========================================================================
    File: resources/views/components/ui/notification/action-button.blade.php
    Purpose: UI notification action button.

    Source: Converted from the Carbon NotificationActionButton React component.
    Notes:
    - Renders the notification action button class.
    - Button visual kind should come from the app-owned button component.
    - Inline notifications use ghost treatment; toast/actionable use tertiary.
    ========================================================================== --}}

@props([
    'inline' => false,
    'kind' => null,
    'size' => 'sm',
])

@php
    $resolvedKind = $kind ?? ((bool) $inline ? 'ghost' : 'tertiary');
@endphp

<x-ui.button
    :kind="$resolvedKind"
    :size="$size"
    {{ $attributes->class('ui-actionable-notification__action-button') }}
>
    {{ $slot }}
</x-ui.button>