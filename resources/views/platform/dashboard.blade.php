<x-layouts.app title="Dashboard">
    <section class="flex flex-1 flex-col gap-6">
        <div class="ui-card">
            <p class="ui-kicker">Platform Dashboard</p>
            <h1 class="mt-2 text-2xl font-semibold text-white">Dashboard</h1>
            <p class="mt-2 text-sm text-slate-400">You are signed in as {{ auth()->user()->email }}.</p>

            @if (session('status'))
                <div class="mt-4 rounded-md border border-emerald-500/30 bg-emerald-500/10 px-3.5 py-2.5 text-sm text-emerald-100">
                    {{ session('status') }}
                </div>
            @endif
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <article class="ui-card">
                <p class="ui-stat-label">Users</p>
                <p class="ui-stat-value">{{ $userCount }}</p>
                <p class="ui-stat-copy">{{ $activeUserCount }} active platform accounts</p>
            </article>

            <article class="ui-card">
                <p class="ui-stat-label">Settings</p>
                <p class="ui-stat-value">{{ $settingsCount }}</p>
                <p class="ui-stat-copy">Persisted configuration entries</p>
            </article>

            <article class="ui-card">
                <p class="ui-stat-label">Notifications</p>
                <p class="ui-stat-value">{{ $unreadNotificationCount }}</p>
                <p class="ui-stat-copy">Unread notifications for your account</p>
            </article>

            <article class="ui-card">
                <p class="ui-stat-label">Docs</p>
                <p class="ui-stat-value">{{ $docsFileCount }}</p>
                <p class="ui-stat-copy">Readable documentation files in the vault</p>
            </article>
        </div>

        <div class="grid gap-4 xl:grid-cols-2">
            @can('manage-platform-users')
                <section class="ui-card">
                    <h2 class="ui-card-title">Platform Users</h2>
                    <p class="ui-card-copy">Manage platform access, active status, and role assignments for internal users.</p>
                    <div class="mt-5">
                        <a href="{{ route('platform.administration.users.index') }}" class="ui-action">
                            Open User Management
                        </a>
                    </div>
                </section>
            @endcan

            @can('view-platform-docs')
                <section class="ui-card">
                    <h2 class="ui-card-title">Documentation Vault</h2>
                    <p class="ui-card-copy">Review the current `docs/` repository directly inside the platform without leaving the staging app.</p>
                    <div class="mt-5">
                        <a href="{{ route('platform.docs.index') }}" class="ui-action">
                            Open Documentation Viewer
                        </a>
                    </div>
                </section>
            @endcan

            @can('view-platform-notifications')
                <section class="ui-card border-amber-500/30">
                    <h2 class="ui-card-title">Review Tools</h2>
                    <p class="ui-card-copy">Generate a test notification for dashboard, header, and inbox review.</p>
                    <form method="POST" action="{{ route('dashboard.test-notification') }}" class="mt-5">
                        @csrf
                        <button type="submit" class="inline-flex items-center rounded-md border border-amber-400/60 px-3.5 py-2 text-sm font-semibold text-amber-100 transition hover:border-amber-300 hover:text-white">
                            Generate Test Notification
                        </button>
                    </form>
                </section>
            @endcan
        </div>
    </section>
</x-layouts.app>
