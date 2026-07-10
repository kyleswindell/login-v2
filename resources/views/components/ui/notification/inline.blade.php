{{-- ==========================================================================
    File: resources/views/components/ui/notification/inline.blade.php
    Purpose: UI inline notification.

    Source: Converted from the Carbon InlineNotification React component.
    Notes:
    - Renders an inline notification container.
    - Supports kind, low-contrast, title, subtitle, role, close button, and
      custom children.
    - Dismiss behavior should be handled by notification JavaScript.
    ========================================================================== --}}

@props([
    'kind' => 'error',
    'title' => null,
    'subtitle' => null,
    'role' => 'status',
    'lowContrast' => false,
    'hideCloseButton' => false,
    'closeLabel' => 'close notification',
    'statusIconDescription' => null,
])

@php
    $classes = [
        'ui-inline-notification',
        'ui-inline-notification--low-contrast' => (bool) $lowContrast,
        'ui-inline-notification--hide-close-button' => (bool) $hideCloseButton,
        "ui-inline-notification--{$kind}" => filled($kind),
    ];
@endphp

<div
    {{ $attributes->class($classes)->merge([
        'role' => $role,
        'data-ui-notification' => true,
        'data-ui-notification-type' => 'inline',
        'data-ui-notification-kind' => $kind,
    ]) }}
>
    <div class="ui-inline-notification__details">
        @isset($icon)
            <x-ui.notification.icon
                notification-type="inline"
                :kind="$kind"
                :description="$statusIconDescription"
            >
                {{ $icon }}
            </x-ui.notification.icon>
        @endisset

        <div class="ui-inline-notification__text-wrapper">
            @if (filled($title))
                <div class="ui-inline-notification__title">
                    {{ $title }}
                </div>
            @endif

            @if (filled($subtitle))
                <div class="ui-inline-notification__subtitle">
                    {{ $subtitle }}
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>

    @unless ($hideCloseButton)
        <x-ui.notification.close-button
            notification-type="inline"
            :label="$closeLabel"
        >
            @isset($closeIcon)
                {{ $closeIcon }}
            @endisset
        </x-ui.notification.close-button>
    @endunless
</div>