{{--
    Settings sidebar partial — used in all platform.settings.* views.
    Pass $active = 'general' | 'notifications' | 'audit-logs' | 'docs' | 'users'
--}}
<div class="flex w-full gap-4">

    {{-- Column 1: Setup entries --}}
    <div class="w-60 shrink-0 rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30 xl:sticky xl:top-24 xl:h-[calc(100vh-7rem)] xl:overflow-y-auto">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-300">Setup</p>

        <p class="mb-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Base Features</p>
        <nav class="space-y-1">
            @can('view-platform-notifications')
                <a wire:navigate href="{{ route('platform.setup.notifications') }}" @class([
                    'block rounded-md px-4 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.setup.notifications'),
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.setup.notifications'),
                ])>
                    <span class="inline-flex items-center gap-2">
                        <x-layouts.nav-icon icon="bell" />
                        <span>Notifications Setup</span>
                    </span>
                </a>
            @endcan
            @can('view-platform-docs')
                <a wire:navigate href="{{ route('platform.setup.docs') }}" @class([
                    'block rounded-md px-4 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.setup.docs'),
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.setup.docs'),
                ])>
                    <span class="inline-flex items-center gap-2">
                        <x-layouts.nav-icon icon="docs" />
                        <span>Documentation Setup</span>
                    </span>
                </a>
            @endcan
            @can('view-platform-audit-logs')
                <a wire:navigate href="{{ route('platform.setup.audit-logs') }}" @class([
                    'block rounded-md px-4 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.setup.audit-logs'),
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.setup.audit-logs'),
                ])>
                    <span class="inline-flex items-center gap-2">
                        <x-layouts.nav-icon icon="audit-log" />
                        <span>Audit Logs Setup</span>
                    </span>
                </a>
            @endcan
            @can('view-platform-error-logs')
                <a wire:navigate href="{{ route('platform.setup.error-logs') }}" @class([
                    'block rounded-md px-4 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.setup.error-logs'),
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.setup.error-logs'),
                ])>
                    <span class="inline-flex items-center gap-2">
                        <x-layouts.nav-icon icon="error-log" />
                        <span>Error Logs Setup</span>
                    </span>
                </a>
            @endcan
            @can('manage-platform-users')
                <a wire:navigate href="{{ route('platform.setup.users') }}" @class([
                    'block rounded-md px-4 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.setup.users'),
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.setup.users'),
                ])>
                    <span class="inline-flex items-center gap-2">
                        <x-layouts.nav-icon icon="users" />
                        <span>Staff Setup</span>
                    </span>
                </a>
            @endcan
        </nav>

        <div class="mt-4 border-t border-slate-800 pt-4">
            <p class="mb-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Administrator</p>
            <nav class="space-y-1">
                @can('view-platform-docs')
                    <a wire:navigate href="{{ route('platform.setup.docs') }}" @class([
                        'block rounded-md px-4 py-3 text-sm font-medium transition',
                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.setup.docs'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.setup.docs'),
                    ])>
                        <span class="inline-flex items-center gap-2">
                            <x-layouts.nav-icon icon="docs" />
                            <span>Documentation Setup</span>
                        </span>
                    </a>
                @endcan
                @can('view-platform-audit-logs')
                    <a wire:navigate href="{{ route('platform.setup.audit-logs') }}" @class([
                        'block rounded-md px-4 py-3 text-sm font-medium transition',
                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.setup.audit-logs'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.setup.audit-logs'),
                    ])>
                        <span class="inline-flex items-center gap-2">
                            <x-layouts.nav-icon icon="audit-log" />
                            <span>Audit Logs Setup</span>
                        </span>
                    </a>
                @endcan
                @can('view-platform-error-logs')
                    <a wire:navigate href="{{ route('platform.setup.error-logs') }}" @class([
                        'block rounded-md px-4 py-3 text-sm font-medium transition',
                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.setup.error-logs'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.setup.error-logs'),
                    ])>
                        <span class="inline-flex items-center gap-2">
                            <x-layouts.nav-icon icon="error-log" />
                            <span>Error Logs Setup</span>
                        </span>
                    </a>
                @endcan
            @can('manage-platform-settings')
                    <a wire:navigate href="{{ route('platform.settings.general') }}" @class([
                        'block rounded-md px-4 py-3 text-sm font-medium transition',
                        'border border-slate-500/40 bg-slate-700/60 text-white' => request()->routeIs('platform.settings.*'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.*'),
                    ])>
                        <span class="inline-flex items-center gap-2">
                            <x-layouts.nav-icon icon="settings" />
                            <span>Settings</span>
                        </span>
                    </a>
            @endcan
            </nav>
        </div>
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
                        <span class="inline-flex items-center gap-2">
                            <x-layouts.nav-icon icon="settings" />
                            <span>Platform General</span>
                        </span>
                    </a>
                    <a wire:navigate href="{{ route('platform.settings.general.company-information') }}" @class([
                        'block rounded-md px-4 py-3 text-sm font-medium transition',
                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.general.company-information'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.general.company-information'),
                    ])>
                        <span class="inline-flex items-center gap-2">
                            <x-layouts.nav-icon icon="docs" />
                            <span>Company Information</span>
                        </span>
                    </a>
                    <a wire:navigate href="{{ route('platform.settings.general.localization') }}" @class([
                        'block rounded-md px-4 py-3 text-sm font-medium transition',
                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.general.localization'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.general.localization'),
                    ])>
                        <span class="inline-flex items-center gap-2">
                            <x-layouts.nav-icon icon="settings" />
                            <span>Localization</span>
                        </span>
                    </a>
                    <a wire:navigate href="{{ route('platform.settings.general.email') }}" @class([
                        'block rounded-md px-4 py-3 text-sm font-medium transition',
                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.general.email'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.general.email'),
                    ])>
                        <span class="inline-flex items-center gap-2">
                            <x-layouts.nav-icon icon="bell" />
                            <span>Email</span>
                        </span>
                    </a>
                    <a wire:navigate href="{{ route('platform.settings.general.system-update') }}" @class([
                        'block rounded-md px-4 py-3 text-sm font-medium transition',
                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.general.system-update'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.general.system-update'),
                    ])>
                        <span class="inline-flex items-center gap-2">
                            <x-layouts.nav-icon icon="settings" />
                            <span>System Update</span>
                        </span>
                    </a>
                    <a wire:navigate href="{{ route('platform.settings.general.system-server-info') }}" @class([
                        'block rounded-md px-4 py-3 text-sm font-medium transition',
                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.general.system-server-info'),
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.general.system-server-info'),
                    ])>
                        <span class="inline-flex items-center gap-2">
                            <x-layouts.nav-icon icon="settings" />
                            <span>System/Server Info</span>
                        </span>
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
                        <span class="inline-flex items-center gap-2">
                            <x-layouts.nav-icon icon="bell" />
                            <span>Notification Defaults</span>
                        </span>
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
                        <span class="inline-flex items-center gap-2">
                            <x-layouts.nav-icon icon="audit-log" />
                            <span>Audit Settings</span>
                        </span>
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
                        <span class="inline-flex items-center gap-2">
                            <x-layouts.nav-icon icon="docs" />
                            <span>Vault Access</span>
                        </span>
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
                        <span class="inline-flex items-center gap-2">
                            <x-layouts.nav-icon icon="users" />
                            <span>User Defaults</span>
                        </span>
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>
