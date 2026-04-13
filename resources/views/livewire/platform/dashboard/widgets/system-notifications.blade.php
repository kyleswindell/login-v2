<section class="rounded-lg border border-slate-800 bg-slate-900/70 p-5">
    <div class="mb-4 flex items-center justify-between gap-3">
        <div>
            <h2 class="text-base font-semibold text-white">Notifications</h2>
            <p class="text-sm text-slate-400">Your latest unread platform notifications.</p>
        </div>
    </div>

    <div class="space-y-3">
        @forelse ($notifications as $notification)
            <article class="flex items-start gap-3 rounded-lg border border-slate-800 bg-slate-950/70 px-4 py-3">
                <span class="mt-1 h-2.5 w-2.5 rounded-full {{ match ($notification->severity) {
                    'critical' => 'bg-rose-500',
                    'warning' => 'bg-amber-400',
                    'success' => 'bg-emerald-500',
                    default => 'bg-sky-500',
                } }}"></span>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-medium text-white">{{ $notification->title }}</p>
                    @if ($notification->body)
                        <p class="mt-1 text-sm text-slate-400">{{ $notification->body }}</p>
                    @endif
                </div>
                @if ($notification->action_url)
                    <a href="{{ $notification->action_url }}" class="text-xs font-semibold uppercase tracking-[0.15em] text-amber-300 hover:text-amber-200">
                        View
                    </a>
                @endif
            </article>
        @empty
            <p class="text-sm text-slate-400">No unread notifications.</p>
        @endforelse
    </div>
</section>