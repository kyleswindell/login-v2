<x-layouts.app title="Notifications">
    <section class="flex flex-1 flex-col gap-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="ui-page-header-title">Notifications</h1>
                <p class="ui-page-header-copy">Review your current in-app platform notifications.</p>
            </div>

            <form method="POST" action="{{ route('platform.notifications.mark-all-read') }}">
                @csrf
                <button type="submit" class="ui-action ui-action-primary">
                    Mark all read
                </button>
            </form>
        </div>

        @if (session('status'))
            <x-ui.inline-alert semantic="success">
                {{ session('status') }}
            </x-ui.inline-alert>
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
                                <x-ui.badge
                                    :label="$notification->severity"
                                    :semantic="match ($notification->severity) { 'success' => 'success', 'notice' => 'notice', 'warning' => 'warning', 'error', 'urgent' => 'danger', 'info' => 'info', default => 'neutral' }"
                                    :show-icon="false"
                                    data-notification-severity-badge
                                />

                                @if ($notification->read_at)
                                    <x-ui.badge label="Read" semantic="neutral" :show-icon="false" data-notification-read-badge="true" />
                                @else
                                    <x-ui.badge label="Unread" semantic="notice" :show-icon="false" data-notification-read-badge="false" />
                                @endif

                                @if ($notification->dismissed_at)
                                    <x-ui.badge label="Dismissed" semantic="neutral" variant="outline" :show-icon="false" />
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
                                <form method="POST" action="{{ route('platform.notifications.mark-read', $notification) }}" data-notification-mark-read-form>
                                    @csrf
                                    <button type="submit" class="ui-action ui-action-success">
                                        Mark read
                                    </button>
                                </form>
                            @endif

                            @if (! $notification->dismissed_at)
                                <form method="POST" action="{{ route('platform.notifications.dismiss', $notification) }}">
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
    </section>
</x-layouts.app>
