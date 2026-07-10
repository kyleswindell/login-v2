{{-- ==========================================================================
    File: resources/views/components/patterns/notifications/inline/index.blade.php
    Purpose: Inline notification pattern for task-local status feedback.

    Source: Carbon notification pattern.
    Notes:
    - Composes the Tier 1 inline notification primitive.
    - Use near the task, form, or field group the message relates to.
    ========================================================================== --}}

@props([
    'kind' => 'info',
    'title' => null,
    'subtitle' => null,
    'lowContrast' => true,
    'hideCloseButton' => false,
])

<x-ui.notification.inline
    :kind="$kind"
    :title="$title"
    :subtitle="$subtitle"
    :low-contrast="$lowContrast"
    :hide-close-button="$hideCloseButton"
    {{ $attributes }}
>
    {{ $slot }}
</x-ui.notification.inline>
