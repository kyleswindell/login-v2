<div class="fi-wi-system-notifications rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-gray-900">
    <h3 class="mb-4 text-base font-semibold leading-tight text-gray-950 dark:text-white">
        Notifications
    </h3>

    @forelse ($notifications as $notification)
        <div class="mb-3 flex items-start gap-3 rounded-lg border border-gray-100 bg-gray-50 px-3.5 py-3 dark:border-white/5 dark:bg-white/5">
            <span class="mt-0.5 flex-shrink-0 w-2 h-2 rounded-full
                @if ($notification->severity === 'critical') bg-red-500
                @elseif ($notification->severity === 'warning') bg-amber-400
                @elseif ($notification->severity === 'success') bg-emerald-500
                @else bg-blue-500
                @endif
            "></span>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                    {{ $notification->title }}
                </p>
                @if ($notification->body)
                    <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400 line-clamp-2">
                        {{ $notification->body }}
                    </p>
                @endif
            </div>
            @if ($notification->action_url)
                <a href="{{ $notification->action_url }}"
                   class="ui-action ui-action-notice flex-shrink-0 text-xs">
                    View
                </a>
            @endif
        </div>
    @empty
        <p class="text-sm text-gray-500 dark:text-gray-400">No unread notifications.</p>
    @endforelse
</div>
