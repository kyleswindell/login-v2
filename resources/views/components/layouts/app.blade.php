@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? config('app.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-950 text-slate-100 antialiased">
        @php($user = auth()->user())
        @php($hasCustomSidebar = isset($sidebar))
        @php($unreadNotificationCount = $user ? \App\Models\PlatformNotification::query()->visibleTo($user)->whereNull('read_at')->count() : 0)

        <div class="min-h-screen">
            @if ($user)
                <header class="sticky top-0 z-40 border-b border-slate-800 bg-slate-950/90 backdrop-blur">
                    <div class="mx-auto flex w-full max-w-[1700px] items-center gap-4 px-4 py-4 xl:px-6">
                        <a href="{{ route('dashboard') }}" class="flex min-w-0 items-center gap-3 rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3 transition hover:border-sky-500/40">
                            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-sky-500/15 text-lg font-semibold text-sky-300">P</div>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-white">Parasolutions Platform</p>
                                <p class="truncate text-xs uppercase tracking-[0.2em] text-slate-500">Login App 2.0</p>
                            </div>
                        </a>

                        <div class="hidden min-w-0 flex-1 md:block">
                            <label for="app-search" class="sr-only">Search</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500">Search</span>
                                <input
                                    id="app-search"
                                    type="text"
                                    placeholder="Global search coming soon"
                                    class="w-full rounded-2xl border border-slate-800 bg-slate-900/70 py-3 pl-20 pr-4 text-sm text-slate-200 placeholder:text-slate-500 focus:border-sky-500/40 focus:outline-none"
                                >
                            </div>
                        </div>

                        <div class="ml-auto flex items-center gap-3">
                            @can('view-platform-notifications')
                                <a href="{{ route('platform.notifications.index') }}" class="hidden rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3 text-sm text-slate-300 transition hover:border-sky-500/40 xl:block">
                                    <p class="font-medium text-white">Notifications</p>
                                    <p class="text-xs text-slate-500">{{ $unreadNotificationCount }} unread</p>
                                </a>
                            @endcan

                            <details class="group relative">
                                <summary class="flex cursor-pointer list-none items-center gap-3 rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3 transition hover:border-sky-500/40">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-800 text-sm font-semibold text-white">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="hidden text-left lg:block">
                                        <p class="text-sm font-semibold text-white">{{ $user->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                    </div>
                                    <span class="text-slate-500 transition group-open:rotate-180">⌄</span>
                                </summary>

                                <div class="absolute right-0 z-50 mt-3 w-72 rounded-3xl border border-slate-800 bg-slate-900/95 p-3 shadow-2xl shadow-black/40">
                                    <a href="{{ route('dashboard') }}" class="block rounded-2xl px-4 py-3 text-sm text-slate-200 transition hover:bg-slate-800 hover:text-white">
                                        Dashboard
                                    </a>

                                    @can('manage-platform-users')
                                        <a href="{{ route('platform.users.index') }}" class="mt-1 block rounded-2xl px-4 py-3 text-sm text-slate-200 transition hover:bg-slate-800 hover:text-white">
                                            Platform Users
                                        </a>
                                    @endcan

                                    @can('view-platform-docs')
                                        <a href="{{ route('platform.docs.index') }}" class="mt-1 block rounded-2xl px-4 py-3 text-sm text-slate-200 transition hover:bg-slate-800 hover:text-white">
                                            Documentation Vault
                                        </a>
                                    @endcan

                                    @can('view-platform-notifications')
                                        <a href="{{ route('platform.notifications.index') }}" class="mt-1 block rounded-2xl px-4 py-3 text-sm text-slate-200 transition hover:bg-slate-800 hover:text-white">
                                            Notifications
                                        </a>
                                    @endcan

                                    @can('view-platform-audit-logs')
                                        <a href="{{ route('platform.audit-logs.index') }}" class="mt-1 block rounded-2xl px-4 py-3 text-sm text-slate-200 transition hover:bg-slate-800 hover:text-white">
                                            Audit Logs
                                        </a>
                                    @endcan

                                    <form method="POST" action="{{ route('logout') }}" class="mt-2 border-t border-slate-800 pt-2">
                                        @csrf
                                        <button type="submit" class="w-full rounded-2xl px-4 py-3 text-left text-sm font-semibold text-rose-200 transition hover:bg-rose-500/10 hover:text-rose-100">
                                            Sign out
                                        </button>
                                    </form>
                                </div>
                            </details>
                        </div>
                    </div>
                </header>

                <div @class([
                    'mx-auto flex min-h-[calc(100vh-5.5rem)] w-full max-w-[1700px] gap-6 px-4 py-6 xl:px-6',
                    'flex-col xl:flex-row' => $hasCustomSidebar,
                    'flex-col lg:flex-row' => ! $hasCustomSidebar,
                ])>
                    @if ($hasCustomSidebar)
                        <aside class="w-full shrink-0 xl:sticky xl:top-24 xl:h-[calc(100vh-7rem)] xl:w-80">
                            {{ $sidebar }}
                        </aside>
                    @else
                        <aside class="hidden w-72 shrink-0 lg:block">
                            <div class="sticky top-24 rounded-3xl border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30">
                                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-300">Platform Navigation</p>
                                <h1 class="mt-3 text-2xl font-semibold text-white">Workspace</h1>
                                <p class="mt-2 text-sm text-slate-400">Core internal platform surfaces.</p>

                                <nav class="mt-8 space-y-2">
                                    <a href="{{ route('dashboard') }}" @class([
                                        'block rounded-2xl px-4 py-3 text-sm font-medium transition',
                                        'bg-sky-500/15 text-sky-200 ring-1 ring-sky-500/30' => request()->routeIs('dashboard'),
                                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('dashboard'),
                                    ])>
                                        Dashboard
                                    </a>

                                    @can('manage-platform-users')
                                        <a href="{{ route('platform.users.index') }}" @class([
                                            'block rounded-2xl px-4 py-3 text-sm font-medium transition',
                                            'bg-sky-500/15 text-sky-200 ring-1 ring-sky-500/30' => request()->routeIs('platform.users.*'),
                                            'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.users.*'),
                                        ])>
                                            Platform Users
                                        </a>
                                    @endcan

                                    @can('view-platform-docs')
                                        <a href="{{ route('platform.docs.index') }}" @class([
                                            'block rounded-2xl px-4 py-3 text-sm font-medium transition',
                                            'bg-sky-500/15 text-sky-200 ring-1 ring-sky-500/30' => request()->routeIs('platform.docs.index'),
                                            'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.docs.index'),
                                        ])>
                                            Documentation Vault
                                        </a>
                                    @endcan

                                    @can('view-platform-notifications')
                                        <a href="{{ route('platform.notifications.index') }}" @class([
                                            'block rounded-2xl px-4 py-3 text-sm font-medium transition',
                                            'bg-sky-500/15 text-sky-200 ring-1 ring-sky-500/30' => request()->routeIs('platform.notifications.*'),
                                            'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.notifications.*'),
                                        ])>
                                            Notifications
                                        </a>
                                    @endcan

                                    @can('view-platform-audit-logs')
                                        <a href="{{ route('platform.audit-logs.index') }}" @class([
                                            'block rounded-2xl px-4 py-3 text-sm font-medium transition',
                                            'bg-sky-500/15 text-sky-200 ring-1 ring-sky-500/30' => request()->routeIs('platform.audit-logs.*'),
                                            'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.audit-logs.*'),
                                        ])>
                                            Audit Logs
                                        </a>
                                    @endcan
                                </nav>
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
    </body>
</html>
