{{-- ==========================================================================
    File: resources/views/components/ui/notification/icon.blade.php
    Purpose: UI notification status icon wrapper.

    Source: Converted from the Carbon NotificationIcon React component.
    Notes:
    - Does not define icon artwork.
    - Consumers provide the appropriate status icon through the default slot.
    - Applies the notification-type icon class to the wrapper.
    ========================================================================== --}}

@props([
    'kind' => 'info',
    'notificationType' => 'toast',
    'description' => null,
])

@php
    $iconClass = "ui-{$notificationType}-notification__icon";
    $resolvedDescription = $description ?? "{$kind} icon";
@endphp

<span
    {{ $attributes->class($iconClass)->merge([
        'data-ui-notification-icon' => true,
        'data-ui-notification-kind' => $kind,
    ]) }}
>
    <span class="ui-visually-hidden">{{ $resolvedDescription }}</span>
    {{ $slot }}
</span>