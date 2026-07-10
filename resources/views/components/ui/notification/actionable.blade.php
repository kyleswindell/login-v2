{{-- ==========================================================================
    File: resources/views/components/ui/notification/actionable.blade.php
    Purpose: UI actionable notification.

    Source: Converted from the Carbon ActionableNotification React component.
    Notes:
    - Renders an actionable notification container.
    - Supports toast-style and inline-style presentation.
    - Supports action button, close button, title, subtitle, caption, role,
      low-contrast, and kind state.
    - Focus trap behavior for alertdialog should be handled by notification JS
      if needed.
    ========================================================================== --}}

@props([
    'kind' => 'error',
    'title' => null,
    'subtitle' => null,
    'caption' => null,
    'role' => 'alertdialog',
    'inline' => false,
    'lowContrast' => false,
    'hideCloseButton' => false,
    'actionButtonLabel' => null,
    'closeLabel' => 'close notification',
    'statusIconDescription' => null,
    'titleId' => null,
    'subtitleId' => null,
])

@php
    $resolvedTitleId = $titleId ?? ($title ? 'actionable-notification-title-'.uniqid() : null);
    $resolvedSubtitleId = $subtitleId ?? (($subtitle || ! $title) ? 'actionable-notification-subtitle-'.uniqid() : null);

    $classes = [
        'ui-actionable-notification',
        'ui-actionable-notification--toast' => ! (bool) $inline,
        'ui-actionable-notification--low-contrast' => (bool) $lowContrast,
        'ui-actionable-notification--hide-close-button' => (bool) $hideCloseButton,
        "ui-actionable-notification--{$kind}" => filled($kind),
    ];
@endphp

<div
    {{ $attributes->class($classes)->merge([
        'role' => $role,
        'aria-labelledby' => $title ? $resolvedTitleId : $resolvedSubtitleId,
        'data-ui-notification' => true,
        'data-ui-notification-type' => 'actionable',
        'data-ui-notification-kind' => $kind,
        'data-ui-notification-close-on-escape' => 'true',
    ]) }}
>
    <div class="ui-actionable-notification__focus-wrapper">
        <div class="ui-actionable-notification__details">
            @isset($icon)
                <x-ui.notification.icon
                    :notification-type="$inline ? 'inline' : 'toast'"
                    :kind="$kind"
                    :description="$statusIconDescription"
                >
                    {{ $icon }}
                </x-ui.notification.icon>
            @endisset

            <div class="ui-actionable-notification__text-wrapper">
                <div class="ui-actionable-notification__content">
                    @if (filled($title))
                        <div
                            id="{{ $resolvedTitleId }}"
                            class="ui-actionable-notification__title"
                        >
                            {{ $title }}
                        </div>
                    @endif

                    @if (filled($subtitle))
                        <div
                            id="{{ $resolvedSubtitleId }}"
                            class="ui-actionable-notification__subtitle"
                        >
                            {{ $subtitle }}
                        </div>
                    @endif

                    @if (filled($caption))
                        <div class="ui-actionable-notification__caption">
                            {{ $caption }}
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </div>
        </div>

        <div class="ui-actionable-notification__button-wrapper">
            @if (filled($actionButtonLabel))
                <x-ui.notification.action-button :inline="$inline">
                    {{ $actionButtonLabel }}
                </x-ui.notification.action-button>
            @endif

            @unless ($hideCloseButton)
                <x-ui.notification.close-button
                    notification-type="actionable"
                    :label="$closeLabel"
                >
                    @isset($closeIcon)
                        {{ $closeIcon }}
                    @endisset
                </x-ui.notification.close-button>
            @endunless
        </div>
    </div>
</div>