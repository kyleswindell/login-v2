@props(['title' => null])
@php($bootThemeMode = auth()->user()?->theme_preference)
@php($bootThemeMode = in_array($bootThemeMode, ['system', 'dark', 'light'], true) ? $bootThemeMode : 'system')
@php($themeBootPayload = json_encode(['mode' => $bootThemeMode], JSON_THROW_ON_ERROR))

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? config('app.name') }}</title>
        <script>
            (() => {
                const root = document.documentElement;
                const allowedModes = new Set(['system', 'dark', 'light']);
                const persistedMode = window.localStorage.getItem('platform.theme.mode');
                const bootPayload = document.getElementById('theme-boot-payload');
                const serverMode = bootPayload ? JSON.parse(bootPayload.textContent).mode : 'system';
                const themeMode = allowedModes.has(persistedMode) ? persistedMode : serverMode;
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const resolved = themeMode === 'system' ? (prefersDark ? 'dark' : 'light') : themeMode;

                root.dataset.themeMode = themeMode;
                root.dataset.themeResolved = resolved;
                root.classList.toggle('dark', resolved === 'dark');
                root.style.backgroundColor = resolved === 'light' ? 'rgb(248 250 252)' : 'rgb(9 9 11)';
                root.style.color = resolved === 'light' ? 'rgb(15 23 42)' : 'rgb(241 245 249)';
            })();
        </script>
        <script id="theme-boot-payload" type="application/json">{{ $themeBootPayload }}</script>
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body
        @class([
            'min-h-screen antialiased bg-slate-100 text-slate-900 dark:bg-slate-950 dark:text-slate-100',
            'has-auth-shell' => auth()->check(),
        ])
        data-theme-update-url="{{ auth()->check() ? route('platform.account.preferences.update') : '' }}"
        data-sidebar-context="{{ request()->routeIs('platform.setup.*', 'platform.settings.*') ? 'setup' : 'primary' }}"
    >
        @php($user = auth()->user())
        @php($hasCustomSidebar = isset($sidebar))
        @inject('platformNavigation', \App\Platform\Navigation\PlatformNavigation::class)
        @php($unreadNotificationCount = $user ? \App\Models\PlatformNotification::query()->visibleTo($user)->whereNull('read_at')->count() : 0)
        @php($recentNotifications = $user ? \App\Models\PlatformNotification::query()->visibleTo($user)->latest()->limit(5)->get() : collect())
        @php($realtimeNotificationsEnabled = $user && $user->can('platform.notifications.view'))
        @php($navigation = $platformNavigation->forUser($user))
        @php($accountNavigation = $navigation['account'])
        @php($primaryBaseNavigation = $navigation['primaryBase'] ?? [])
        @php($primaryAdminNavigation = $navigation['primaryAdmin'] ?? [])
        @php($logsNavigation = $navigation['logs'] ?? [])
        @php($setupBaseNavigation = $navigation['setupBase'] ?? [])
        @php($setupAdminNavigation = $navigation['setupAdmin'] ?? [])

        <div class="min-h-screen">
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

            @if ($user)
                <header class="sticky top-0 z-40 border-b border-slate-800 bg-slate-950/90 backdrop-blur">
                    <div class="mx-auto flex w-full max-w-[1700px] items-center gap-4 px-4 py-4 xl:px-6">
                        <button
                            type="button"
                            class="ui-icon-button lg:hidden"
                            aria-label="Toggle navigation"
                            data-sidebar-toggle
                        >
                            <span class="text-base leading-none" data-sidebar-toggle-icon>☰</span>
                        </button>

                        <a href="{{ route('dashboard') }}" wire:navigate class="flex min-w-0 items-center gap-3 py-1">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full border border-zinc-600 bg-zinc-800/70 text-lg font-semibold text-zinc-100">P</div>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-white">Parasolutions Platform</p>
                                <p class="truncate text-xs uppercase tracking-[0.2em] text-slate-500">Login App 2.0</p>
                            </div>
                        </a>

                        <div class="hidden min-w-0 flex-1 justify-center md:flex">
                            <label for="app-search" class="sr-only">Search</label>
                            <div class="relative w-full max-w-[22rem] xl:max-w-[26rem]">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500">Search</span>
                                <input
                                    id="app-search"
                                    type="text"
                                    placeholder="Global search coming soon"
                                    class="w-full rounded-md border border-slate-700 bg-slate-900/40 py-2.5 pl-20 pr-4 text-sm text-slate-200 placeholder:text-slate-500 focus:border-slate-500/60 focus:outline-none"
                                >
                            </div>
                        </div>

                        <div class="ml-auto flex items-center gap-3">
                            @can('view-platform-notifications')
                                <div
                                    class="relative hidden xl:block"
                                    data-notification-menu
                                >
                                    <button
                                        type="button"
                                        class="relative inline-flex h-10 w-10 items-center justify-center rounded-full text-slate-300 transition hover:bg-slate-800 hover:text-white"
                                        data-notification-trigger
                                        aria-expanded="false"
                                        aria-controls="notification-menu-panel"
                                        title="Notifications"
                                    >
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 1 5.454 1.31A8.967 8.967 0 0 1 18 9.75V9a6 6 0 1 0-12 0v.75a8.967 8.967 0 0 1-2.312 8.642 23.848 23.848 0 0 1 5.454-1.31m5.715 0a24.255 24.255 0 0 0-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                        </svg>
                                        <span class="sr-only">Unread notifications</span>
                                        <span
                                            @class([
                                                'absolute -right-1 -top-1 min-w-[1.2rem] rounded-full px-1.5 py-0.5 text-center text-[10px] font-semibold leading-none',
                                                'bg-slate-200 text-slate-900' => $unreadNotificationCount > 0,
                                                'bg-slate-700 text-slate-300' => $unreadNotificationCount === 0,
                                            ])
                                            data-notification-trigger-summary
                                        >{{ $unreadNotificationCount }}</span>
                                    </button>

                                    <div
                                        id="notification-menu-panel"
                                        class="absolute right-0 z-50 mt-3 hidden w-[28rem] rounded-lg border border-slate-800 bg-slate-900/95 p-4 shadow-2xl shadow-black/40"
                                        data-notification-panel
                                    >
                                        <div class="flex items-start justify-between gap-4 border-b border-slate-800 pb-4">
                                            <div>
                                                <p class="text-sm font-semibold text-white">Recent Notifications</p>
                                                <p class="mt-1 text-xs text-slate-500" data-notification-panel-summary>{{ $unreadNotificationCount }} unread across your latest updates</p>
                                            </div>

                                            <a href="{{ route('platform.administration.notifications.index') }}" wire:navigate class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-300 transition hover:text-white">
                                                View all
                                            </a>
                                        </div>

                                        <div class="mt-4 space-y-3" data-notification-preview-list>
                                            @forelse ($recentNotifications as $notification)
                                                <a
                                                    href="{{ $notification->action_url ?: route('platform.administration.notifications.index') }}"
                                                    wire:navigate
                                                    class="block rounded-md border border-slate-800 bg-slate-950/80 px-4 py-4 transition hover:border-slate-600 hover:bg-slate-950"
                                                    data-notification-preview-item
                                                    data-notification-id="{{ $notification->id }}"
                                                >
                                                    <div class="flex items-center gap-2">
                                                        @if (! $notification->read_at)
                                                            <span class="inline-flex rounded-full bg-slate-700/70 px-2.5 py-1 text-[11px] font-medium text-slate-200">Unread</span>
                                                        @endif

                                                        <span @class([
                                                            'inline-flex rounded-full px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.15em]',
                                                            'bg-slate-700/60 text-slate-200' => $notification->severity === 'info',
                                                            'bg-emerald-500/15 text-emerald-300' => $notification->severity === 'success',
                                                            'bg-violet-500/15 text-violet-300' => $notification->severity === 'notice',
                                                            'bg-amber-500/15 text-amber-300' => $notification->severity === 'warning',
                                                            'bg-rose-500/15 text-rose-300' => in_array($notification->severity, ['error', 'urgent'], true),
                                                        ])>
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

                            <details class="group relative" data-account-menu>
                                <summary class="flex cursor-pointer list-none items-center gap-3 px-1 py-1 transition hover:text-white">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full border border-zinc-600 bg-zinc-800/70 text-sm font-semibold text-zinc-100">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="hidden text-left lg:block">
                                        <p class="text-sm font-semibold text-white">{{ $user->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                    </div>
                                    <span class="text-slate-500 transition group-open:rotate-180">⌄</span>
                                </summary>

                                <div class="absolute right-0 z-50 mt-3 w-72 rounded-lg border border-slate-800 bg-slate-900/95 p-3 shadow-2xl shadow-black/40">
                                    <div class="rounded-md border border-slate-800 bg-slate-950/70 p-2">
                                        <p class="px-2 pb-2 text-xs font-semibold uppercase tracking-[0.15em] text-slate-400">Theme</p>
                                        <div class="grid grid-cols-3 gap-1">
                                            <button
                                                type="button"
                                                class="rounded-md px-2 py-2 text-xs font-semibold text-slate-300 transition hover:bg-slate-800 hover:text-white"
                                                data-theme-mode-toggle
                                                data-theme-mode="light"
                                            >Light</button>
                                            <button
                                                type="button"
                                                class="rounded-md px-2 py-2 text-xs font-semibold text-slate-300 transition hover:bg-slate-800 hover:text-white"
                                                data-theme-mode-toggle
                                                data-theme-mode="dark"
                                            >Dark</button>
                                            <button
                                                type="button"
                                                class="rounded-md px-2 py-2 text-xs font-semibold text-slate-300 transition hover:bg-slate-800 hover:text-white"
                                                data-theme-mode-toggle
                                                data-theme-mode="system"
                                            >System</button>
                                        </div>
                                    </div>

                                    @foreach ($accountNavigation as $item)
                                        <a href="{{ route($item['route']) }}" wire:navigate @class([
                                            'block rounded-md px-4 py-3 text-sm transition',
                                            'text-slate-200 hover:bg-slate-800 hover:text-white' => ! request()->routeIs(...$item['active']),
                                            'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs(...$item['active']),
                                            'mt-2' => $loop->first,
                                            'mt-1' => ! $loop->first,
                                        ])>
                                            {{ $item['label'] }}
                                        </a>
                                    @endforeach

                                    <form method="POST" action="{{ route('logout') }}" class="mt-2 border-t border-slate-800 pt-2">
                                        @csrf
                                        <button type="submit" class="w-full rounded-md px-4 py-3 text-left text-sm font-semibold text-rose-200 transition hover:bg-rose-500/10 hover:text-rose-100">
                                            Sign out
                                        </button>
                                    </form>
                                </div>
                            </details>
                        </div>
                    </div>
                </header>

                <div class="fixed inset-0 z-50 hidden bg-black/70 lg:hidden" data-sidebar-backdrop></div>

                <div @class([
                    'mx-auto flex min-h-[calc(100vh-5.5rem)] w-full max-w-[1700px] gap-6 px-4 py-6 xl:px-6',
                    'flex-col xl:flex-row' => $hasCustomSidebar,
                    'flex-col lg:flex-row' => ! $hasCustomSidebar,
                ])>
                    @if ($hasCustomSidebar)
                        <aside
                            class="fixed inset-2 z-[60] hidden shrink-0 overflow-y-auto rounded-2xl border border-slate-700 bg-slate-950/95 p-4 shadow-2xl shadow-black/40 lg:inset-auto lg:sticky lg:top-24 lg:z-auto lg:block lg:w-auto lg:max-h-[calc(100vh-7rem)] lg:overflow-visible lg:rounded-none lg:border-0 lg:bg-transparent lg:p-0 lg:shadow-none"
                            data-sidebar-panel
                        >
                            <x-layouts.mobile-sidebar
                                :primary-base-navigation="$primaryBaseNavigation"
                                :primary-admin-navigation="$primaryAdminNavigation"
                                :logs-navigation="$logsNavigation"
                                :setup-base-navigation="$setupBaseNavigation"
                                :setup-admin-navigation="$setupAdminNavigation"
                            />

                            <div class="hidden lg:block">
                                {{ $sidebar }}
                            </div>
                        </aside>
                    @else
                        <aside
                            class="fixed inset-2 z-[60] hidden shrink-0 overflow-y-auto rounded-2xl border border-slate-700 bg-slate-950/95 p-4 shadow-2xl shadow-black/40 lg:inset-auto lg:sticky lg:top-24 lg:z-auto lg:block lg:w-60 lg:self-start lg:max-h-[calc(100vh-7rem)] lg:rounded-none lg:border-0 lg:bg-transparent lg:p-0 lg:shadow-none"
                            data-sidebar-host
                            data-sidebar-panel
                        >
                            <x-layouts.mobile-sidebar
                                :primary-base-navigation="$primaryBaseNavigation"
                                :primary-admin-navigation="$primaryAdminNavigation"
                                :logs-navigation="$logsNavigation"
                                :setup-base-navigation="$setupBaseNavigation"
                                :setup-admin-navigation="$setupAdminNavigation"
                            />

                            <div class="hidden lg:block" data-sidebar-container>
                                {{-- Slider track: main nav and Setup panel side by side --}}
                                <div class="relative overflow-hidden">
                                    <div class="flex transition-transform duration-300 will-change-transform" data-sidebar-track>
                                        {{-- Panel 1: Main navigation --}}
                                        <div class="w-full shrink-0 rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30 lg:w-60" data-main-nav-panel>
                                            <p class="mb-3 px-1 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Base Features</p>
                                            <nav class="space-y-2">
                                                @foreach ($primaryBaseNavigation as $item)
                                                    <a href="{{ route($item['route']) }}" wire:navigate data-main-nav-link @class([
                                                        'flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition',
                                                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs(...$item['active']),
                                                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs(...$item['active']),
                                                    ])>
                                                        <x-layouts.nav-icon :icon="$item['icon'] ?? null" />
                                                        {{ $item['label'] }}
                                                    </a>
                                                @endforeach
                                            </nav>

                                            @if (count($primaryAdminNavigation) > 0 || count($logsNavigation) > 0)
                                                <div class="mt-4 border-t border-slate-800 pt-4">
                                                    <p class="mb-3 px-1 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Administrator</p>
                                                    <nav class="space-y-2">
                                                        @foreach ($primaryAdminNavigation as $item)
                                                            <a href="{{ route($item['route']) }}" wire:navigate data-main-nav-link @class([
                                                                'flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition',
                                                                'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs(...$item['active']),
                                                                'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs(...$item['active']),
                                                            ])>
                                                                <x-layouts.nav-icon :icon="$item['icon'] ?? null" />
                                                                {{ $item['label'] }}
                                                            </a>
                                                        @endforeach
                                                    </nav>

                                                    @if (count($logsNavigation) > 0)
                                                        <details class="mt-2 group" @if (collect($logsNavigation)->contains(fn (array $item): bool => request()->routeIs(...$item['active']))) open @endif>
                                                            <summary class="flex cursor-pointer list-none items-center gap-3 rounded-md px-4 py-3 text-sm font-medium text-slate-300 transition hover:bg-slate-800 hover:text-white">
                                                                <x-layouts.nav-icon icon="audit-log" />
                                                                <span>Logs</span>
                                                                <span class="ml-auto text-slate-500 transition group-open:rotate-180">⌄</span>
                                                            </summary>
                                                            <div class="mt-2 space-y-2 pl-2">
                                                                @foreach ($logsNavigation as $item)
                                                                    <a href="{{ route($item['route']) }}" wire:navigate data-main-nav-link @class([
                                                                        'flex items-center gap-3 rounded-md px-4 py-2.5 text-sm font-medium transition',
                                                                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs(...$item['active']),
                                                                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs(...$item['active']),
                                                                    ])>
                                                                        <x-layouts.nav-icon :icon="$item['icon'] ?? null" />
                                                                        {{ $item['label'] }}
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        </details>
                                                    @endif
                                                </div>
                                            @endif

                                            @if (count($setupBaseNavigation) > 0 || count($setupAdminNavigation) > 0)
                                                <div class="mt-4 border-t border-slate-800 pt-4">
                                                    <button
                                                        type="button"
                                                        class="flex w-full items-center rounded-md px-4 py-3 text-sm font-medium text-slate-400 transition hover:bg-slate-800 hover:text-white"
                                                        data-setup-open
                                                    >
                                                        <span>Setup</span>
                                                        <span class="ml-auto text-slate-500" aria-hidden="true">→</span>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Panel 2: Setup panel --}}
                                        <div class="w-full shrink-0 rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30 lg:w-60" data-setup-nav-panel>
                                            <div class="flex items-center justify-between">
                                                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-300">Setup</p>
                                                <button
                                                    type="button"
                                                    class="rounded-md border border-slate-700 px-3 py-1.5 text-xs font-semibold text-slate-400 transition hover:border-slate-600 hover:text-white"
                                                    data-setup-close
                                                >
                                                    ✕ Close
                                                </button>
                                            </div>

                                            <p class="mt-6 mb-3 px-1 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Base Features</p>
                                            <nav class="space-y-2">
                                                @foreach ($setupBaseNavigation as $item)
                                                    <a href="{{ route($item['route']) }}" wire:navigate data-setup-nav-link @class([
                                                        'flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition',
                                                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs(...$item['active']),
                                                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs(...$item['active']),
                                                    ])>
                                                        <x-layouts.nav-icon :icon="$item['icon'] ?? null" />
                                                        {{ $item['label'] }}
                                                    </a>
                                                @endforeach
                                            </nav>

                                            <p class="mt-5 mb-3 border-t border-slate-800 pt-4 px-1 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Administrator</p>
                                            <nav class="space-y-2">
                                                @foreach ($setupAdminNavigation as $item)
                                                    <a href="{{ route($item['route']) }}" wire:navigate data-setup-nav-link @class([
                                                        'flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition',
                                                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs(...$item['active']),
                                                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs(...$item['active']),
                                                    ])>
                                                        <x-layouts.nav-icon :icon="$item['icon'] ?? null" />
                                                        {{ $item['label'] }}
                                                    </a>
                                                @endforeach
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </aside>
                    @endif

                    <main class="flex min-h-full min-w-0 flex-1 flex-col">
                        {{ $slot }}
                    </main>
                </div>
            @else
                <main class="mx-auto flex min-h-screen w-full max-w-5xl flex-col px-6 py-10">
                    {{ $slot }}
                </main>
            @endif
        </div>
        @livewireScripts
    </body>
</html>
