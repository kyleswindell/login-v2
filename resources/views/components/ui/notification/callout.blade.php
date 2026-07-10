{{-- ==========================================================================
    File: resources/views/components/ui/notification/callout.blade.php
    Purpose: UI callout notification.

    Source: Converted from the Carbon Callout React component.
    Notes:
    - Carbon Callout uses actionable-notification classes with the close button
      hidden.
    - Supports kind, title, subtitle, action button, low contrast, and custom
      children.
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

@php
    $classes = [
        'ui-actionable-notification',
        'ui-actionable-notification--low-contrast' => (bool) $lowContrast,
        'ui-actionable-notification--hide-close-button',
        "ui-actionable-notification--{$kind}" => filled($kind),
    ];
@endphp

<div
    {{ $attributes->class($classes)->merge([
        'data-ui-notification' => true,
        'data-ui-notification-type' => 'callout',
        'data-ui-notification-kind' => $kind,
    ]) }}
>
    <div class="ui-actionable-notification__details">
        @isset($icon)
            <x-ui.notification.icon
                notification-type="inline"
                :kind="$kind"
                :description="$statusIconDescription"
            >
                {{ $icon }}
            </x-ui.notification.icon>
        @endisset

        <div class="ui-actionable-notification__text-wrapper">
            @if (filled($title))
                <div
                    @if ($titleId) id="{{ $titleId }}" @endif
                    class="ui-actionable-notification__title"
                >
                    {{ $title }}
                </div>
            @endif

            @if (filled($subtitle))
                <div class="ui-actionable-notification__subtitle">
                    {{ $subtitle }}
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>

    <div class="ui-actionable-notification__button-wrapper">
        @if (filled($actionButtonLabel))
            <x-ui.notification.action-button
                inline
                @if ($titleId) aria-describedby="{{ $titleId }}" @endif
            >
                {{ $actionButtonLabel }}
            </x-ui.notification.action-button>
        @endif
    </div>
</div>