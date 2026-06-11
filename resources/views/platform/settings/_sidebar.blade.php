{{--
    Settings sidebar partial — used in all platform.settings.* views.
    Pass $active = 'general' | 'notifications' | 'audit-logs' | 'docs' | 'users'
--}}
<div class="flex w-full gap-4">

    {{-- Column 1: Setup entries --}}
    <div class="ui-shell-sidebar-panel w-60 shrink-0 xl:sticky xl:top-24 xl:h-[calc(100vh-7rem)] xl:overflow-y-auto">
        <p class="ui-shell-sidebar-title text-xs font-semibold uppercase tracking-[0.3em]">Setup</p>

        <p class="ui-shell-sidebar-section-label mb-3 text-xs font-semibold uppercase tracking-[0.18em]">Base Features</p>
        <nav class="space-y-1">
            @can('view-platform-notifications')
                <a wire:navigate href="{{ route('platform.setup.notifications') }}" @class([
                    'ui-shell-sidebar-nav-item block rounded-md px-4 py-3 text-sm font-medium transition',
                    'is-current' => request()->routeIs('platform.setup.notifications'),
                ])>
                    <span class="inline-flex items-center gap-2">
                        <x-layouts.nav-icon icon="bell" />
                        <span>Notifications Setup</span>
                    </span>
                </a>
            @endcan
            @can('view-platform-docs')
                <a wire:navigate href="{{ route('platform.setup.docs') }}" @class([
                    'ui-shell-sidebar-nav-item block rounded-md px-4 py-3 text-sm font-medium transition',
                    'is-current' => request()->routeIs('platform.setup.docs'),
                ])>
                    <span class="inline-flex items-center gap-2">
                        <x-layouts.nav-icon icon="docs" />
                        <span>Documentation Setup</span>
                    </span>
                </a>
            @endcan
            @can('view-platform-audit-logs')
                <a wire:navigate href="{{ route('platform.setup.audit-logs') }}" @class([
                    'ui-shell-sidebar-nav-item block rounded-md px-4 py-3 text-sm font-medium transition',
                    'is-current' => request()->routeIs('platform.setup.audit-logs'),
                ])>
                    <span class="inline-flex items-center gap-2">
                        <x-layouts.nav-icon icon="audit-log" />
                        <span>Audit Logs Setup</span>
                    </span>
                </a>
            @endcan
            @can('view-platform-error-logs')
                <a wire:navigate href="{{ route('platform.setup.error-logs') }}" @class([
                    'ui-shell-sidebar-nav-item block rounded-md px-4 py-3 text-sm font-medium transition',
                    'is-current' => request()->routeIs('platform.setup.error-logs'),
                ])>
                    <span class="inline-flex items-center gap-2">
                        <x-layouts.nav-icon icon="error-log" />
                        <span>Error Logs Setup</span>
                    </span>
                </a>
            @endcan
            @can('manage-platform-users')
                <a wire:navigate href="{{ route('platform.setup.users') }}" @class([
                    'ui-shell-sidebar-nav-item block rounded-md px-4 py-3 text-sm font-medium transition',
                    'is-current' => request()->routeIs('platform.setup.users'),
                ])>
                    <span class="inline-flex items-center gap-2">
                        <x-layouts.nav-icon icon="users" />
                        <span>Staff Setup</span>
                    </span>
                </a>
            @endcan
        </nav>

        <div class="ui-shell-sidebar-divider mt-4 border-t pt-4">
            <p class="ui-shell-sidebar-section-label mb-3 text-xs font-semibold uppercase tracking-[0.18em]">Administrator</p>
            <nav class="space-y-1">
                @can('view-platform-docs')
                    <a wire:navigate href="{{ route('platform.setup.docs') }}" @class([
                        'ui-shell-sidebar-nav-item block rounded-md px-4 py-3 text-sm font-medium transition',
                        'is-current' => request()->routeIs('platform.setup.docs'),
                    ])>
                        <span class="inline-flex items-center gap-2">
                            <x-layouts.nav-icon icon="docs" />
                            <span>Documentation Setup</span>
                        </span>
                    </a>
                @endcan
                @can('view-platform-audit-logs')
                    <a wire:navigate href="{{ route('platform.setup.audit-logs') }}" @class([
                        'ui-shell-sidebar-nav-item block rounded-md px-4 py-3 text-sm font-medium transition',
                        'is-current' => request()->routeIs('platform.setup.audit-logs'),
                    ])>
                        <span class="inline-flex items-center gap-2">
                            <x-layouts.nav-icon icon="audit-log" />
                            <span>Audit Logs Setup</span>
                        </span>
                    </a>
                @endcan
                @can('view-platform-error-logs')
                    <a wire:navigate href="{{ route('platform.setup.error-logs') }}" @class([
                        'ui-shell-sidebar-nav-item block rounded-md px-4 py-3 text-sm font-medium transition',
                        'is-current' => request()->routeIs('platform.setup.error-logs'),
                    ])>
                        <span class="inline-flex items-center gap-2">
                            <x-layouts.nav-icon icon="error-log" />
                            <span>Error Logs Setup</span>
                        </span>
                    </a>
                @endcan
            @can('manage-platform-settings')
                    <a wire:navigate href="{{ route('platform.settings.general') }}" @class([
                        'ui-shell-sidebar-nav-item block rounded-md px-4 py-3 text-sm font-medium transition',
                        'is-current' => request()->routeIs('platform.settings.*'),
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
    <div class="ui-shell-sidebar-panel w-60 shrink-0 xl:sticky xl:top-24 xl:h-[calc(100vh-7rem)] xl:overflow-y-auto">
        <p class="ui-shell-sidebar-title text-xs font-semibold uppercase tracking-[0.3em]">Settings</p>

        <nav class="mt-6 space-y-4">
            {{-- General --}}
            <div>
                <p class="ui-shell-sidebar-section-label px-2 text-xs font-semibold uppercase tracking-[0.2em]">General</p>
                <div class="mt-1 space-y-1">
                    <a wire:navigate href="{{ route('platform.settings.general') }}" @class([
                        'ui-shell-sidebar-nav-item block rounded-md px-4 py-3 text-sm font-medium transition',
                        'is-current' => request()->routeIs('platform.settings.general'),
                    ])>
                        <span class="inline-flex items-center gap-2">
                            <x-layouts.nav-icon icon="settings" />
                            <span>Platform General</span>
                        </span>
                    </a>
                    <a wire:navigate href="{{ route('platform.settings.general.company-information') }}" @class([
                        'ui-shell-sidebar-nav-item block rounded-md px-4 py-3 text-sm font-medium transition',
                        'is-current' => request()->routeIs('platform.settings.general.company-information'),
                    ])>
                        <span class="inline-flex items-center gap-2">
                            <x-layouts.nav-icon icon="docs" />
                            <span>Company Information</span>
                        </span>
                    </a>
                    <a wire:navigate href="{{ route('platform.settings.general.localization') }}" @class([
                        'ui-shell-sidebar-nav-item block rounded-md px-4 py-3 text-sm font-medium transition',
                        'is-current' => request()->routeIs('platform.settings.general.localization'),
                    ])>
                        <span class="inline-flex items-center gap-2">
                            <x-layouts.nav-icon icon="settings" />
                            <span>Localization</span>
                        </span>
                    </a>
                    <a wire:navigate href="{{ route('platform.settings.general.email') }}" @class([
                        'ui-shell-sidebar-nav-item block rounded-md px-4 py-3 text-sm font-medium transition',
                        'is-current' => request()->routeIs('platform.settings.general.email'),
                    ])>
                        <span class="inline-flex items-center gap-2">
                            <x-layouts.nav-icon icon="bell" />
                            <span>Email</span>
                        </span>
                    </a>
                    <a wire:navigate href="{{ route('platform.settings.general.system-update') }}" @class([
                        'ui-shell-sidebar-nav-item block rounded-md px-4 py-3 text-sm font-medium transition',
                        'is-current' => request()->routeIs('platform.settings.general.system-update'),
                    ])>
                        <span class="inline-flex items-center gap-2">
                            <x-layouts.nav-icon icon="settings" />
                            <span>System Update</span>
                        </span>
                    </a>
                    <a wire:navigate href="{{ route('platform.settings.general.system-server-info') }}" @class([
                        'ui-shell-sidebar-nav-item block rounded-md px-4 py-3 text-sm font-medium transition',
                        'is-current' => request()->routeIs('platform.settings.general.system-server-info'),
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
                <p class="ui-shell-sidebar-section-label px-2 text-xs font-semibold uppercase tracking-[0.2em]">Platform Notifications</p>
                <div class="mt-1 space-y-1">
                    <a wire:navigate href="{{ route('platform.settings.notifications') }}" @class([
                        'ui-shell-sidebar-nav-item block rounded-md px-4 py-3 text-sm font-medium transition',
                        'is-current' => request()->routeIs('platform.settings.notifications'),
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
                <p class="ui-shell-sidebar-section-label px-2 text-xs font-semibold uppercase tracking-[0.2em]">Audit Logs</p>
                <div class="mt-1 space-y-1">
                    <a wire:navigate href="{{ route('platform.settings.audit-logs') }}" @class([
                        'ui-shell-sidebar-nav-item block rounded-md px-4 py-3 text-sm font-medium transition',
                        'is-current' => request()->routeIs('platform.settings.audit-logs'),
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
                <p class="ui-shell-sidebar-section-label px-2 text-xs font-semibold uppercase tracking-[0.2em]">Documentation Vault</p>
                <div class="mt-1 space-y-1">
                    <a wire:navigate href="{{ route('platform.settings.docs') }}" @class([
                        'ui-shell-sidebar-nav-item block rounded-md px-4 py-3 text-sm font-medium transition',
                        'is-current' => request()->routeIs('platform.settings.docs'),
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
                <p class="ui-shell-sidebar-section-label px-2 text-xs font-semibold uppercase tracking-[0.2em]">Platform Users</p>
                <div class="mt-1 space-y-1">
                    <a wire:navigate href="{{ route('platform.settings.users') }}" @class([
                        'ui-shell-sidebar-nav-item block rounded-md px-4 py-3 text-sm font-medium transition',
                        'is-current' => request()->routeIs('platform.settings.users'),
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
