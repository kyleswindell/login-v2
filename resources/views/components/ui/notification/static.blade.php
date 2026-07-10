{{-- ==========================================================================
    File: resources/views/components/ui/notification/static.blade.php
    Purpose: Legacy static notification alias.

    Source: Converted from the Carbon StaticNotification compatibility export.
    Notes:
    - StaticNotification was renamed to Callout in Carbon.
    - This component forwards to x-ui.notification.callout.
    ========================================================================== --}}

@props([
    'kind' => 'info',
    'title' => null,
    'subtitle' => null,
    'titleId' => null,
    'actionButtonLabel' => null,
    'lowContrast' => false,
    'statusIconDescription' => null,
])

<x-ui.notification.callout
    :kind="$kind"
    :title="$title"
    :subtitle="$subtitle"
    :title-id="$titleId"
    :action-button-label="$actionButtonLabel"
    :low-contrast="$lowContrast"
    :status-icon-description="$statusIconDescription"
    {{ $attributes }}
>
    @isset($icon)
        <x-slot:icon>
            {{ $icon }}
        </x-slot:icon>
    @endisset

    {{ $slot }}
</x-ui.notification.callout>