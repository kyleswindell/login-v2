{{-- ==========================================================================
    File: resources/views/components/patterns/notifications/toast/index.blade.php
    Purpose: Toast notification pattern for short transient feedback.

    Source: Carbon notification pattern.
    Notes:
    - Composes the Tier 1 toast notification primitive.
    - Use for non-persistent action feedback and system-generated updates.
    ========================================================================== --}}

@props([
    'kind' => 'info',
    'title' => null,
    'subtitle' => null,
    'caption' => null,
    'lowContrast' => false,
    'hideCloseButton' => false,
])

<x-ui.notification.toast
    :kind="$kind"
    :title="$title"
    :subtitle="$subtitle"
    :caption="$caption"
    :low-contrast="$lowContrast"
    :hide-close-button="$hideCloseButton"
    {{ $attributes }}
>
    {{ $slot }}
</x-ui.notification.toast>
