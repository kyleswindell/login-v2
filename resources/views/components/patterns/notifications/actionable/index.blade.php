{{-- ==========================================================================
    File: resources/views/components/patterns/notifications/actionable/index.blade.php
    Purpose: Actionable notification pattern with one optional action.

    Source: Carbon notification pattern.
    Notes:
    - Composes the Tier 1 actionable notification primitive.
    - Keep action labels short and provide only one optional action.
    ========================================================================== --}}

@props([
    'kind' => 'info',
    'title' => null,
    'subtitle' => null,
    'caption' => null,
    'inline' => false,
    'lowContrast' => false,
    'actionButtonLabel' => null,
    'hideCloseButton' => false,
])

<x-ui.notification.actionable
    :kind="$kind"
    :title="$title"
    :subtitle="$subtitle"
    :caption="$caption"
    :inline="$inline"
    :low-contrast="$lowContrast"
    :action-button-label="$actionButtonLabel"
    :hide-close-button="$hideCloseButton"
    {{ $attributes }}
>
    {{ $slot }}
</x-ui.notification.actionable>
