                            @can('view-platform-notifications')
                                <div
                                    class="relative hidden xl:block"
                                    data-notification-menu
                                >
                                    <button
                                        type="button"
                                        class="ui-notification-trigger"
                                        data-notification-trigger
                                        data-notification-trigger-unread="{{ $unreadNotificationCount > 0 ? 'true' : 'false' }}"
                                        aria-expanded="false"
                                        aria-controls="notification-menu-panel"
                                        title="Notifications"
                                    >
                                        <x-heroicon-o-bell class="ui-notification-trigger-icon" data-notification-trigger-icon aria-hidden="true" />
                                        <span class="sr-only" data-notification-trigger-label>
                                            {{ $unreadNotificationCount > 0 ? "{$unreadNotificationCount} unread notifications" : 'No unread notifications' }}
                                        </span>
                                        <span
                                            @class([
                                                'ui-notification-trigger-badge',
                                                'hidden' => $unreadNotificationCount === 0,
                                            ])
                                            data-notification-trigger-summary
                                            data-notification-trigger-badge-hidden="{{ $unreadNotificationCount > 0 ? 'false' : 'true' }}"
                                        >{{ $unreadNotificationCount }}</span>
                                    </button>

                                    <div
                                        id="notification-menu-panel"
                                        class="absolute right-0 z-50 mt-3 hidden w-[28rem] rounded-lg border border-slate-800 bg-slate-900/95 p-4 shadow-2xl shadow-black/40"
                                        data-notification-panel
                                    >
                                        <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-800 pb-4">
                                            <div>
                                                <p class="text-sm font-semibold text-white">Recent Notifications</p>
                                                <p class="mt-1 text-xs text-slate-500" data-notification-panel-summary>{{ $unreadNotificationCount }} unread across your latest updates</p>
                                            </div>

                                            <div class="flex flex-wrap items-center gap-2">
                                                <form method="POST" action="{{ route('platform.notifications.mark-all-read') }}" data-notification-mark-all-form>
                                                    @csrf
                                                    <x-ui.button
                                                        type="submit"
                                                        size="xs"
                                                        :disabled="$unreadNotificationCount === 0"
                                                        data-notification-mark-all
                                                        data-notification-mark-all-enabled="{{ $unreadNotificationCount > 0 ? 'true' : 'false' }}"
                                                    >
                                                        Mark all as read
                                                    </x-ui.button>
                                                </form>

                                                <a href="{{ route('platform.administration.notifications.index') }}" wire:navigate class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-300 transition hover:text-white">
                                                    View all
                                                </a>
                                            </div>
                                        </div>

                                        <div class="mt-4 space-y-3" data-notification-preview-list>
                                            @forelse ($recentNotifications as $notification)
                                                @php($notificationSeveritySemantic = match ($notification->severity) {
                                                    'info' => 'info',
                                                    'success' => 'success',
                                                    'notice' => 'notice',
                                                    'warning' => 'warning',
                                                    'error', 'urgent' => 'danger',
                                                    default => 'neutral',
                                                })
                                                <a
                                                    href="{{ $notification->action_url ?: route('platform.administration.notifications.index') }}"
                                                    wire:navigate
                                                    @class([
                                                        'ui-notification-preview-item',
                                                        'ui-notification-preview-item-unread' => ! $notification->read_at,
                                                    ])
                                                    data-notification-preview-item
                                                    data-notification-preview-item-unread="{{ ! $notification->read_at ? 'true' : 'false' }}"
                                                    data-notification-id="{{ $notification->id }}"
                                                >
                                                    <div class="flex items-center gap-2">
                                                        @if (! $notification->read_at)
                                                            <span class="ui-notification-preview-pill ui-notification-preview-pill-unread" data-notification-preview-unread>Unread</span>
                                                        @endif

                                                        <span
                                                            class="ui-notification-preview-pill ui-notification-preview-pill-{{ $notificationSeveritySemantic }}"
                                                            data-notification-preview-severity="{{ $notificationSeveritySemantic }}"
                                                        >
                                                            {{ $notification->severity }}
                                                        </span>

                                                        <span class="ml-auto text-xs text-slate-500">{{ $notification->created_at?->format('M j, g:i A') }}</span>
                                                    </div>

                                                    <p class="mt-3 text-sm font-semibold text-white">{{ $notification->title }}</p>
                                                    <p class="mt-1 line-clamp-2 text-sm text-slate-400">{{ $notification->body }}</p>
                                                </a>
                                            @empty
                                                <div class="rounded-md border border-dashed border-slate-800 bg-slate-950/50 px-4 py-8 text-center text-sm text-slate-500" data-notification-preview-empty-state>
                                                    No recent notifications are available for your account.
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            @endcan
