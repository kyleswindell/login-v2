{{-- ==========================================================================
    File: resources/views/components/patterns/notifications/callout/index.blade.php
    Purpose: Callout notification pattern for persistent contextual guidance.

    Source: Carbon notification pattern.
    Notes:
    - Composes the Tier 1 callout notification primitive.
    - Use for page-loaded guidance, not triggered action feedback.
    ========================================================================== --}}

@props([
    'kind' => 'info',
    'title' => null,
    'subtitle' => null,
    'lowContrast' => true,
    'actionButtonLabel' => null,
])

@php
    $resolvedKind = is_string($kind) && in_array($kind, ['info', 'info-square', 'warning', 'warning-alt'], true)
        ? $kind
        : 'info';
@endphp

<x-ui.notification.callout
    :kind="$resolvedKind"
    :title="$title"
    :subtitle="$subtitle"
    :low-contrast="$lowContrast"
    :action-button-label="$actionButtonLabel"
    {{ $attributes }}
>
    {{ $slot }}
</x-ui.notification.callout>
