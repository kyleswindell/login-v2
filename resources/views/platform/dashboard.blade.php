<x-layouts.app title="Dashboard">
    <section class="flex flex-1 flex-col gap-6">
        <div class="rounded-3xl border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            <p class="text-sm font-medium uppercase tracking-[0.3em] text-sky-300">Platform Foundation</p>
            <h1 class="mt-3 text-3xl font-semibold text-white">Dashboard</h1>
            <p class="mt-2 text-slate-400">You are signed in as {{ auth()->user()->email }}.</p>

            @if (session('status'))
                <div class="mt-5 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-100">
                    {{ session('status') }}
                </div>
            @endif
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-2xl border border-slate-800 bg-slate-900/70 p-6">
                <p class="text-sm uppercase tracking-[0.25em] text-slate-500">Users</p>
                <p class="mt-4 text-3xl font-semibold text-white">{{ $userCount }}</p>
                <p class="mt-2 text-sm text-slate-400">{{ $activeUserCount }} active platform accounts</p>
            </article>

            <article class="rounded-2xl border border-slate-800 bg-slate-900/70 p-6">
                <p class="text-sm uppercase tracking-[0.25em] text-slate-500">Settings</p>
                <p class="mt-4 text-3xl font-semibold text-white">{{ $settingsCount }}</p>
                <p class="mt-2 text-sm text-slate-400">Persisted configuration entries</p>
            </article>

            <article class="rounded-2xl border border-slate-800 bg-slate-900/70 p-6">
                <p class="text-sm uppercase tracking-[0.25em] text-slate-500">Notifications</p>
                <p class="mt-4 text-3xl font-semibold text-white">{{ $unreadNotificationCount }}</p>
                <p class="mt-2 text-sm text-slate-400">Unread notifications for your account</p>
            </article>

            <article class="rounded-2xl border border-slate-800 bg-slate-900/70 p-6">
                <p class="text-sm uppercase tracking-[0.25em] text-slate-500">Docs</p>
                <p class="mt-4 text-3xl font-semibold text-white">{{ $docsFileCount }}</p>
                <p class="mt-2 text-sm text-slate-400">Readable documentation files in the vault</p>
            </article>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            @can('manage-platform-users')
                <section class="rounded-3xl border border-slate-800 bg-slate-900/70 p-8">
                    <h2 class="text-xl font-semibold text-white">Platform Users</h2>
                    <p class="mt-2 text-sm text-slate-400">Manage platform access, active status, and role assignments for internal users.</p>
                    <div class="mt-6">
                        <a href="{{ route('platform.users.index') }}" class="inline-flex rounded-xl border border-slate-700 px-4 py-3 text-sm font-semibold text-slate-100 transition hover:border-sky-400 hover:text-sky-300">
                            Open User Management
                        </a>
                    </div>
                </section>
            @endcan

            @can('view-platform-docs')
                <section class="rounded-3xl border border-slate-800 bg-slate-900/70 p-8">
                    <h2 class="text-xl font-semibold text-white">Documentation Vault</h2>
                    <p class="mt-2 text-sm text-slate-400">Review the current `docs/` repository directly inside the platform without leaving the staging app.</p>
                    <div class="mt-6">
                        <a href="{{ route('platform.docs.index') }}" class="inline-flex rounded-xl border border-slate-700 px-4 py-3 text-sm font-semibold text-slate-100 transition hover:border-sky-400 hover:text-sky-300">
                            Open Documentation Viewer
                        </a>
                    </div>
                </section>
            @endcan

            @can('view-platform-notifications')
                <section class="rounded-3xl border border-amber-500/30 bg-slate-900/70 p-8">
                    <h2 class="text-xl font-semibold text-white">Review Tools</h2>
                    <p class="mt-2 text-sm text-slate-400">Generate a test notification for dashboard, header, and inbox review.</p>
                    <form method="POST" action="{{ route('dashboard.test-notification') }}" class="mt-6">
                        @csrf
                        <button type="submit" class="inline-flex rounded-xl border border-amber-400/60 px-4 py-3 text-sm font-semibold text-amber-100 transition hover:border-amber-300 hover:text-white">
                            Generate Test Notification
                        </button>
                    </form>
                </section>
            @endcan
        </div>
    </section>
</x-layouts.app>
