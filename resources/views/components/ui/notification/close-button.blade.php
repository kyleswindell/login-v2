{{-- ==========================================================================
    File: resources/views/components/ui/notification/close-button.blade.php
    Purpose: UI notification close button.

    Source: Converted from the Carbon NotificationButton React component.
    Notes:
    - Renders close button markup for toast, inline, and actionable
      notifications.
    - Does not define icon artwork.
    - Consumers provide the close icon through the default slot.
    - data-ui-notification-close is used by notification JavaScript.
    ========================================================================== --}}

@props([
    'label' => 'close notification',
    'type' => 'button',
    'notificationType' => 'toast',
])

@php
    $buttonClass = "ui-{$notificationType}-notification__close-button";
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->class($buttonClass)->merge([
        'aria-label' => $label,
        'title' => $label,
        'data-ui-notification-close' => true,
    ]) }}
>
    @if ($slot->isEmpty())
        <x-ui.icon name="close" class="ui-notification-close-icon" aria-hidden="true" />
    @else
        {{ $slot }}
    @endif
</button>
