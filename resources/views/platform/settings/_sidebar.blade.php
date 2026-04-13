{{--
    Settings sidebar partial — used in all platform.settings.* views.
    Pass $active = 'general' | 'notifications' | 'audit-logs' | 'docs' | 'users'
--}}
<div class="flex w-full gap-4">
    {{-- Column 1: Setup entries --}}
    <div class="w-60 shrink-0 rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30 xl:sticky xl:top-24 xl:h-[calc(100vh-7rem)] xl:overflow-y-auto">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-300">Setup</p>

        <nav class="mt-6 space-y-1">
            @can('view-platform-notifications')
                <a wire:navigate href="{{ route('platform.setup.notifications') }}" @class([
                    'block rounded-md px-4 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.setup.notifications'),
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.setup.notifications'),
                ])>
                    Notifications Setup
                </a>
            @endcan
            @can('view-platform-docs')
                <a wire:navigate href="{{ route('platform.setup.docs') }}" @class([
                    'block rounded-md px-4 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.setup.docs'),
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.setup.docs'),
                ])>
                    Documentation Setup
                </a>
            @endcan
            @can('view-platform-audit-logs')
                <a wire:navigate href="{{ route('platform.setup.audit-logs') }}" @class([
                    'block rounded-md px-4 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.setup.audit-logs'),
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.setup.audit-logs'),
                ])>
                    Audit Logs Setup
                </a>
            @endcan
            @can('view-platform-error-logs')
                <a wire:navigate href="{{ route('platform.setup.error-logs') }}" @class([
                    'block rounded-md px-4 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.setup.error-logs'),
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.setup.error-logs'),
                ])>
                    Error Logs Setup
                </a>
            @endcan
            @can('manage-platform-users')
                <a wire:navigate href="{{ route('platform.setup.users') }}" @class([
                    'block rounded-md px-4 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.setup.users'),
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.setup.users'),
                ])>
                    Platform Users Setup
                </a>
            @endcan

            @can('manage-platform-settings')
                <a wire:navigate href="{{ route('platform.settings.general') }}" @class([
                    'mt-2 block rounded-md px-4 py-3 text-sm font-medium transition',
                    'border border-slate-500/40 bg-slate-700/60 text-white' => request()->routeIs('platform.settings.*'),
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.*'),
                ])>
                    Settings
                </a>
            @endcan
        </nav>
    </div>

    {{-- Column 2: Settings accordion --}}
    <div class="w-60 shrink-0 rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30 xl:sticky xl:top-24 xl:h-[calc(100vh-7rem)] xl:overflow-y-auto">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-300">Settings</p>

        <nav class="mt-6 space-y-4">
            {{-- General --}}
            <div>
                <p class="px-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">General</p>
                <div class="mt-1 space-y-1">
                    <a wire:navigate href="{{ route('platform.settings.general') }}" @class([
                        'block rounded-md px-4 py-3 text-sm font-medium transition',
                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.general'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.general'),
                    ])>
                        Platform General
                    </a>
                    <a wire:navigate href="{{ route('platform.settings.general.company-information') }}" @class([
                        'block rounded-md px-4 py-3 text-sm font-medium transition',
                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.general.company-information'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.general.company-information'),
                    ])>
                        Company Information
                    </a>
                    <a wire:navigate href="{{ route('platform.settings.general.localization') }}" @class([
                        'block rounded-md px-4 py-3 text-sm font-medium transition',
                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.general.localization'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.general.localization'),
                    ])>
                        Localization
                    </a>
                    <a wire:navigate href="{{ route('platform.settings.general.email') }}" @class([
                        'block rounded-md px-4 py-3 text-sm font-medium transition',
                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.general.email'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.general.email'),
                    ])>
                        Email
                    </a>
                    <a wire:navigate href="{{ route('platform.settings.general.system-update') }}" @class([
                        'block rounded-md px-4 py-3 text-sm font-medium transition',
                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.general.system-update'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.general.system-update'),
                    ])>
                        System Update
                    </a>
                    <a wire:navigate href="{{ route('platform.settings.general.system-server-info') }}" @class([
                        'block rounded-md px-4 py-3 text-sm font-medium transition',
                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.general.system-server-info'),
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
                    <a wire:navigate href="{{ route('platform.settings.notifications') }}" @class([
                        'block rounded-md px-4 py-3 text-sm font-medium transition',
                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.notifications'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.notifications'),
                    ])>
                        Notification Defaults
                    </a>
                </div>
            </div>

            {{-- Audit Logs --}}
            <div>
                <p class="px-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Audit Logs</p>
                <div class="mt-1 space-y-1">
                    <a wire:navigate href="{{ route('platform.settings.audit-logs') }}" @class([
                        'block rounded-md px-4 py-3 text-sm font-medium transition',
                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.audit-logs'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.audit-logs'),
                    ])>
                        Audit Settings
                    </a>
                </div>
            </div>

            {{-- Documentation Vault --}}
            <div>
                <p class="px-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Documentation Vault</p>
                <div class="mt-1 space-y-1">
                    <a wire:navigate href="{{ route('platform.settings.docs') }}" @class([
                        'block rounded-md px-4 py-3 text-sm font-medium transition',
                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.docs'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.docs'),
                    ])>
                        Vault Access
                    </a>
                </div>
            </div>

            {{-- Platform Users --}}
            <div>
                <p class="px-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Platform Users</p>
                <div class="mt-1 space-y-1">
                    <a wire:navigate href="{{ route('platform.settings.users') }}" @class([
                        'block rounded-md px-4 py-3 text-sm font-medium transition',
                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.users'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.users'),
                    ])>
                        User Defaults
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>
