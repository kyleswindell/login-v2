<x-ui.patterns.widget-shell
    title="Notifications"
    description="Your latest unread platform notifications."
    :meta="['Activity widget']"
>
    <div class="space-y-3">
        @forelse ($notifications as $notification)
            <article class="ui-pattern-widget-shell-section flex items-start gap-3">
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
                    <a href="{{ $notification->action_url }}" class="ui-action ui-action-notice text-xs">
                        View
                    </a>
                @endif
            </article>
        @empty
            <p class="text-sm text-slate-400">No unread notifications.</p>
        @endforelse
    </div>
</x-ui.patterns.widget-shell>
