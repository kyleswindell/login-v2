<x-layouts.app title="Notifications">
    <section class="flex flex-1 flex-col gap-6">
        <div class="flex flex-col gap-4 rounded-lg border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.3em] text-slate-300">Platform Management</p>
                <h1 class="mt-3 text-3xl font-semibold text-white">Notifications</h1>
                <p class="mt-2 text-slate-400">Review your current in-app platform notifications.</p>
            </div>

            <form method="POST" action="{{ route('platform.notifications.mark-all-read') }}">
                @csrf
                <button type="submit" class="inline-flex rounded-md border border-slate-700 px-4 py-3 text-sm font-semibold text-slate-100 transition hover:border-slate-500 hover:text-slate-300">
                    Mark all read
                </button>
            </form>
        </div>

        @if (session('status'))
            <div class="rounded-md border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid gap-4 md:grid-cols-3">
            <article class="rounded-md border border-slate-800 bg-slate-900/70 p-6">
                <p class="text-sm uppercase tracking-[0.25em] text-slate-500">Unread</p>
                <p class="mt-4 text-3xl font-semibold text-white" data-notification-inbox-unread-count>{{ $unreadCount }}</p>
                <p class="mt-2 text-sm text-slate-400">Notifications still requiring attention</p>
            </article>
        </div>

        <div class="space-y-4" data-notification-inbox-list>
            @forelse ($notifications as $notification)
                <article class="rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/20" data-notification-card data-notification-id="{{ $notification->id }}">
                    <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2" data-notification-badges>
                                <span @class([
                                    'inline-flex rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em]',
                                    'bg-slate-700/60 text-slate-300' => $notification->severity === 'info',
                                    'bg-emerald-500/15 text-emerald-300' => $notification->severity === 'success',
                                    'bg-violet-500/15 text-violet-300' => $notification->severity === 'notice',
                                    'bg-amber-500/15 text-amber-300' => $notification->severity === 'warning',
                                    'bg-rose-500/15 text-rose-300' => in_array($notification->severity, ['error', 'urgent'], true),
                                ])>
                                    {{ $notification->severity }}
                                </span>

                                @if ($notification->read_at)
                                    <span class="inline-flex rounded-full bg-slate-800 px-3 py-1 text-xs font-medium text-slate-300">Read</span>
                                @else
                                    <span class="inline-flex rounded-full bg-slate-700/60 px-3 py-1 text-xs font-medium text-slate-200">Unread</span>
                                @endif

                                @if ($notification->dismissed_at)
                                    <span class="inline-flex rounded-full bg-slate-800 px-3 py-1 text-xs font-medium text-slate-400">Dismissed</span>
                                @endif
                            </div>

                            <h2 class="mt-4 text-xl font-semibold text-white">{{ $notification->title }}</h2>
                            <p class="mt-2 leading-7 text-slate-300">{{ $notification->body }}</p>

                            <div class="mt-4 flex flex-wrap gap-4 text-sm text-slate-500">
                                <span>Module: {{ $notification->module_key }}</span>
                                <span data-notification-created-label>{{ $notification->created_at?->format('M j, Y g:i A') }}</span>
                            </div>

                            @if ($notification->action_url)
                                <div class="mt-4">
                                    <a href="{{ $notification->action_url }}" class="text-sm font-semibold text-slate-300 transition hover:text-slate-200">
                                        Open notification link
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-wrap gap-3" data-notification-actions>
                            @if (! $notification->read_at)
                                <form method="POST" action="{{ route('platform.notifications.mark-read', $notification) }}">
                                    @csrf
                                    <button type="submit" class="inline-flex rounded-md border border-slate-700 px-4 py-3 text-sm font-semibold text-slate-100 transition hover:border-slate-500 hover:text-slate-300">
                                        Mark read
                                    </button>
                                </form>
                            @endif

                            @if (! $notification->dismissed_at)
                                <form method="POST" action="{{ route('platform.notifications.dismiss', $notification) }}">
                                    @csrf
                                    <button type="submit" class="inline-flex rounded-md border border-slate-700 px-4 py-3 text-sm font-semibold text-slate-100 transition hover:border-slate-500 hover:text-white">
                                        Dismiss
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-lg border border-dashed border-slate-800 bg-slate-950/40 px-6 py-12 text-center text-slate-500" data-notification-inbox-empty-state>
                    No notifications are available for your account yet.
                </div>
            @endforelse
        </div>

        {{ $notifications->links() }}
    </section>
</x-layouts.app>
