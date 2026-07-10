{{-- ==========================================================================
    File: resources/views/components/ui/notification/toast.blade.php
    Purpose: UI toast notification.

    Source: Converted from the Carbon ToastNotification React component.
    Notes:
    - Renders a toast notification container.
    - Supports kind, low-contrast, title, subtitle, caption, default status
      icon, role, close button, and custom children.
    - Dismiss behavior should be handled by notification JavaScript.
    ========================================================================== --}}

@props([
    'kind' => 'error',
    'title' => null,
    'subtitle' => null,
    'caption' => null,
    'role' => 'status',
    'lowContrast' => false,
    'hideCloseButton' => false,
    'closeLabel' => 'close notification',
    'statusIconDescription' => null,
])

@php
    $toastIconNames = [
        'error' => 'error--filled',
        'success' => 'checkmark--filled',
        'warning' => 'warning--filled',
        'warning-alt' => 'warning--alt--filled',
        'info' => 'information--filled',
        'info-square' => 'information--square--filled',
    ];

    $resolvedKind = is_string($kind) && array_key_exists($kind, $toastIconNames)
        ? $kind
        : 'info';

    $resolvedIconName = $toastIconNames[$resolvedKind];

    $classes = [
        'ui-toast-notification',
        'ui-toast-notification--low-contrast' => (bool) $lowContrast,
        "ui-toast-notification--{$resolvedKind}",
    ];
@endphp

<div
    {{ $attributes->class($classes)->merge([
        'role' => $role,
        'kind' => $resolvedKind,
        'data-ui-notification' => true,
        'data-ui-notification-type' => 'toast',
        'data-ui-notification-kind' => $resolvedKind,
    ]) }}
>
    <x-ui.notification.icon
        notification-type="toast"
        :kind="$resolvedKind"
        :description="$statusIconDescription"
    >
        @isset($icon)
            {{ $icon }}
        @else
            <x-ui.icon :name="$resolvedIconName" aria-hidden="true" />
        @endisset
    </x-ui.notification.icon>

    <div class="ui-toast-notification__details">
        @if (filled($title))
            <div class="ui-toast-notification__title">
                {{ $title }}
            </div>
        @endif

        @if (filled($subtitle))
            <div class="ui-toast-notification__subtitle">
                {{ $subtitle }}
            </div>
        @endif

        @if (filled($caption))
            <div class="ui-toast-notification__caption">
                {{ $caption }}
            </div>
        @endif

        {{ $slot }}
    </div>

    @unless ($hideCloseButton)
        <x-ui.notification.close-button
            notification-type="toast"
            :label="$closeLabel"
        >
            @isset($closeIcon)
                {{ $closeIcon }}
            @endisset
        </x-ui.notification.close-button>
    @endunless
</div>
