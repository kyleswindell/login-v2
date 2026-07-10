{{-- ==========================================================================
    File: Modules/Notifications/resources/views/index.blade.php
    Purpose: Renders the Notifications module inbox view.
    ========================================================================== --}}

<x-layouts.app
    title="Notifications"
    page-title="Notifications"
    page-subtitle="Review your current in-app platform notifications."
    :reserve-page-tabs="true"
>
    <x-slot:pageActions>
        <form method="POST" action="{{ route('notifications.mark-all-read') }}">
            @csrf
            <x-ui.button type="submit" kind="primary">
                Mark all read
            </x-ui.button>
        </form>
    </x-slot:pageActions>

    <x-ui.grid-column
        tag="section"
        span="100"
        lg="12"
        xlg="12"
    >
        @if (session('status'))
            <x-ui.notification.inline kind="success">
                {{ session('status') }}
            </x-ui.notification.inline>
        @endif

        <div class="grid gap-4 md:grid-cols-3">
            <article class="ui-platform-surface p-6">
                <p class="text-sm uppercase tracking-[0.25em] ui-platform-text-muted">Unread</p>
                <p class="mt-4 text-3xl font-semibold ui-platform-text-strong" data-notification-inbox-unread-count>{{ $unreadCount }}</p>
                <p class="mt-2 text-sm ui-platform-text-muted">Notifications still requiring attention</p>
            </article>
        </div>

        <div class="space-y-4" data-notification-inbox-list>
            @forelse ($notifications as $notification)
                <article class="ui-platform-surface p-6" data-notification-card data-notification-id="{{ $notification->id }}">
                    <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2" data-notification-badges>
                                <x-ui.tag
                                    :label="$notification->severity"
                                    :tone="match ($notification->severity) { 'success' => 'success', 'notice' => 'notice', 'warning' => 'warning', 'error', 'urgent' => 'danger', 'info' => 'info', default => 'neutral' }"
                                    size="sm"
                                    data-notification-severity-badge
                                />

                                @if ($notification->read_at)
                                    <x-ui.tag label="Read" tone="neutral" size="sm" data-notification-read-badge="true" />
                                @else
                                    <x-ui.tag label="Unread" tone="notice" size="sm" data-notification-read-badge="false" />
                                @endif

                                @if ($notification->dismissed_at)
                                    <x-ui.tag label="Dismissed" type="outline" size="sm" />
                                @endif
                            </div>

                            <h2 class="mt-4 text-xl font-semibold ui-platform-text-strong">{{ $notification->title }}</h2>
                            <p class="mt-2 leading-7 ui-platform-text">{{ $notification->body }}</p>

                            <div class="mt-4 flex flex-wrap gap-4 text-sm ui-platform-text-muted">
                                <span>Module: {{ $notification->module_key }}</span>
                                <span data-notification-created-label>{{ $notification->created_at?->format('M j, Y g:i A') }}</span>
                            </div>

                            @if ($notification->action_url)
                                <div class="mt-4 flex flex-wrap gap-3">
                                    <a href="{{ $notification->action_url }}" class="ui-action ui-action-notice text-sm">
                                        Open notification link
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-wrap gap-3" data-notification-actions>
                            @if (! $notification->read_at)
                                <form method="POST" action="{{ route('notifications.mark-read', $notification) }}" data-notification-mark-read-form>
                                    @csrf
                                    <button type="submit" class="ui-action ui-action-success">
                                        Mark read
                                    </button>
                                </form>
                            @endif

                            @if (! $notification->dismissed_at)
                                <form method="POST" action="{{ route('notifications.dismiss', $notification) }}">
                                    @csrf
                                    <button type="submit" class="ui-action ui-action-ghost">
                                        Dismiss
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="ui-platform-subtle-surface border-dashed px-6 py-12 text-center ui-platform-text-muted" data-notification-inbox-empty-state>
                    No notifications are available for your account yet.
                </div>
            @endforelse
        </div>

        {{ $notifications->links() }}
    </x-ui.grid-column>
</x-layouts.app>
