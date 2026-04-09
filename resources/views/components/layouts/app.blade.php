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

        <div class="min-h-screen">
            @if ($user)
                <div class="mx-auto flex min-h-screen w-full max-w-7xl gap-6 px-6 py-8">
                    <aside class="hidden w-72 shrink-0 lg:block">
                        <div class="sticky top-8 rounded-3xl border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30">
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-300">Login App 2.0</p>
                            <h1 class="mt-3 text-2xl font-semibold text-white">Platform</h1>
                            <p class="mt-2 text-sm text-slate-400">{{ $user->email }}</p>

                            <nav class="mt-8 space-y-2">
                                <a href="{{ route('dashboard') }}" @class([
                                    'block rounded-xl px-4 py-3 text-sm font-medium transition',
                                    'bg-sky-500/15 text-sky-200 ring-1 ring-sky-500/30' => request()->routeIs('dashboard'),
                                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('dashboard'),
                                ])>
                                    Dashboard
                                </a>

                                @can('manage-platform-users')
                                    <a href="{{ route('platform.users.index') }}" @class([
                                        'block rounded-xl px-4 py-3 text-sm font-medium transition',
                                        'bg-sky-500/15 text-sky-200 ring-1 ring-sky-500/30' => request()->routeIs('platform.users.*'),
                                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.users.*'),
                                    ])>
                                        Platform Users
                                    </a>
                                @endcan

                                @can('view-platform-docs')
                                    <a href="{{ route('platform.docs.index') }}" @class([
                                        'block rounded-xl px-4 py-3 text-sm font-medium transition',
                                        'bg-sky-500/15 text-sky-200 ring-1 ring-sky-500/30' => request()->routeIs('platform.docs.index'),
                                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.docs.index'),
                                    ])>
                                        Documentation Vault
                                    </a>
                                @endcan
                            </nav>

                            <form method="POST" action="{{ route('logout') }}" class="mt-8">
                                @csrf
                                <button type="submit" class="w-full rounded-xl border border-slate-700 px-4 py-3 text-sm font-semibold text-slate-100 transition hover:border-sky-400 hover:text-sky-300">
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </aside>

                    <main class="flex min-h-screen min-w-0 flex-1 flex-col">
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
