            @if ($realtimeNotificationsEnabled)
                <div
                    data-realtime-notifications="1"
                    data-user-id="{{ $user->id }}"
                    data-notifications-index-url="{{ route('platform.administration.notifications.index') }}"
                ></div>

                <div
                    class="pointer-events-none fixed right-6 top-24 z-[70] flex w-full max-w-sm flex-col gap-3"
                    data-notification-toast-container
                ></div>
            @endif
