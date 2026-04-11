{{--
    Settings sidebar partial — used in all platform.settings.* views.
    Pass $active = 'general' | 'notifications' | 'audit-logs' | 'docs' | 'users'
--}}
<div class="flex w-full gap-3">
    {{-- Column 1: Setup entries --}}
    <div class="w-48 shrink-0 rounded-3xl border border-slate-800 bg-slate-900/70 p-5 shadow-2xl shadow-black/30 xl:sticky xl:top-24 xl:h-[calc(100vh-7rem)] xl:overflow-y-auto">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-sky-300">Setup</p>

        <nav class="mt-6 space-y-1">
            @can('view-platform-notifications')
                <a href="{{ route('platform.setup.notifications') }}" class="block rounded-2xl px-4 py-3 text-sm font-medium text-slate-300 transition hover:bg-slate-800 hover:text-white">
                    Notifications Setup
                </a>
            @endcan
            @can('view-platform-docs')
                <a href="{{ route('platform.setup.docs') }}" class="block rounded-2xl px-4 py-3 text-sm font-medium text-slate-300 transition hover:bg-slate-800 hover:text-white">
                    Documentation Setup
                </a>
            @endcan
            @can('view-platform-audit-logs')
                <a href="{{ route('platform.setup.audit-logs') }}" class="block rounded-2xl px-4 py-3 text-sm font-medium text-slate-300 transition hover:bg-slate-800 hover:text-white">
                    Audit Logs Setup
                </a>
            @endcan
            @can('view-platform-error-logs')
                <a href="{{ route('platform.setup.error-logs') }}" class="block rounded-2xl px-4 py-3 text-sm font-medium text-slate-300 transition hover:bg-slate-800 hover:text-white">
                    Error Logs Setup
                </a>
            @endcan
            @can('manage-platform-users')
                <a href="{{ route('platform.setup.users') }}" class="block rounded-2xl px-4 py-3 text-sm font-medium text-slate-300 transition hover:bg-slate-800 hover:text-white">
                    Platform Users Setup
                </a>
            @endcan

            @can('manage-platform-settings')
                <a href="{{ route('platform.settings.general') }}" class="mt-2 block rounded-2xl border border-sky-500/30 bg-sky-500/10 px-4 py-3 text-sm font-medium text-sky-200">
                    Settings
                </a>
            @endcan
        </nav>
    </div>

    {{-- Column 2: Settings accordion --}}
    <div class="w-52 shrink-0 rounded-3xl border border-slate-800 bg-slate-900/70 p-5 shadow-2xl shadow-black/30 xl:sticky xl:top-24 xl:h-[calc(100vh-7rem)] xl:overflow-y-auto">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Settings</p>

        <nav class="mt-6 space-y-4">
            {{-- General --}}
            <div>
                <p class="px-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">General</p>
                <div class="mt-1 space-y-1">
                    <a href="{{ route('platform.settings.general') }}" @class([
                        'block rounded-2xl px-4 py-3 text-sm font-medium transition',
                        'bg-sky-500/15 text-sky-200 ring-1 ring-sky-500/30' => ($active ?? null) === 'general',
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ($active ?? null) !== 'general',
                    ])>
                        Platform General
                    </a>
                    <a href="{{ route('platform.settings.general.company-information') }}" @class([
                        'block rounded-2xl px-4 py-3 text-sm font-medium transition',
                        'bg-sky-500/15 text-sky-200 ring-1 ring-sky-500/30' => request()->routeIs('platform.settings.general.company-information'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.general.company-information'),
                    ])>
                        Company Information
                    </a>
                    <a href="{{ route('platform.settings.general.localization') }}" @class([
                        'block rounded-2xl px-4 py-3 text-sm font-medium transition',
                        'bg-sky-500/15 text-sky-200 ring-1 ring-sky-500/30' => request()->routeIs('platform.settings.general.localization'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.general.localization'),
                    ])>
                        Localization
                    </a>
                    <a href="{{ route('platform.settings.general.email') }}" @class([
                        'block rounded-2xl px-4 py-3 text-sm font-medium transition',
                        'bg-sky-500/15 text-sky-200 ring-1 ring-sky-500/30' => request()->routeIs('platform.settings.general.email'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.general.email'),
                    ])>
                        Email
                    </a>
                    <a href="{{ route('platform.settings.general.system-update') }}" @class([
                        'block rounded-2xl px-4 py-3 text-sm font-medium transition',
                        'bg-sky-500/15 text-sky-200 ring-1 ring-sky-500/30' => request()->routeIs('platform.settings.general.system-update'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.general.system-update'),
                    ])>
                        System Update
                    </a>
                    <a href="{{ route('platform.settings.general.system-server-info') }}" @class([
                        'block rounded-2xl px-4 py-3 text-sm font-medium transition',
                        'bg-sky-500/15 text-sky-200 ring-1 ring-sky-500/30' => request()->routeIs('platform.settings.general.system-server-info'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.general.system-server-info'),
                    ])>
                        System/Server Info
                    </a>
                </div>
            </div>

            {{-- Platform Notifications --}}
            <div>
                <p class="px-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Platform Notifications</p>
                <div class="mt-1 space-y-1">
                    <a href="{{ route('platform.settings.notifications') }}" @class([
                        'block rounded-2xl px-4 py-3 text-sm font-medium transition',
                        'bg-sky-500/15 text-sky-200 ring-1 ring-sky-500/30' => ($active ?? null) === 'notifications',
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ($active ?? null) !== 'notifications',
                    ])>
                        Notification Defaults
                    </a>
                </div>
            </div>

            {{-- Audit Logs --}}
            <div>
                <p class="px-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Audit Logs</p>
                <div class="mt-1 space-y-1">
                    <a href="{{ route('platform.settings.audit-logs') }}" @class([
                        'block rounded-2xl px-4 py-3 text-sm font-medium transition',
                        'bg-sky-500/15 text-sky-200 ring-1 ring-sky-500/30' => ($active ?? null) === 'audit-logs',
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ($active ?? null) !== 'audit-logs',
                    ])>
                        Audit Settings
                    </a>
                </div>
            </div>

            {{-- Documentation Vault --}}
            <div>
                <p class="px-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Documentation Vault</p>
                <div class="mt-1 space-y-1">
                    <a href="{{ route('platform.settings.docs') }}" @class([
                        'block rounded-2xl px-4 py-3 text-sm font-medium transition',
                        'bg-sky-500/15 text-sky-200 ring-1 ring-sky-500/30' => ($active ?? null) === 'docs',
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ($active ?? null) !== 'docs',
                    ])>
                        Vault Access
                    </a>
                </div>
            </div>

            {{-- Platform Users --}}
            <div>
                <p class="px-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Platform Users</p>
                <div class="mt-1 space-y-1">
                    <a href="{{ route('platform.settings.users') }}" @class([
                        'block rounded-2xl px-4 py-3 text-sm font-medium transition',
                        'bg-sky-500/15 text-sky-200 ring-1 ring-sky-500/30' => ($active ?? null) === 'users',
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ($active ?? null) !== 'users',
                    ])>
                        User Defaults
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>
