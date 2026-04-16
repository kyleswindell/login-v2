@props([
    'primaryBaseNavigation' => [],
    'primaryAdminNavigation' => [],
    'logsNavigation' => [],
    'setupBaseNavigation' => [],
    'setupAdminNavigation' => [],
])

@php($defaultPanel = request()->routeIs('platform.settings.*') ? 'settings' : (request()->routeIs('platform.setup.*') ? 'setup' : 'main'))

<div class="flex h-full flex-col lg:hidden" data-mobile-sidebar-dock data-default-panel="{{ $defaultPanel }}">
    <div class="relative mb-4 flex items-center justify-center border-b border-slate-800 pb-3">
        <button
            type="button"
            class="absolute left-0 ui-icon-button"
            data-sidebar-toggle
            aria-label="Close navigation"
        >
            <span class="text-base leading-none" data-sidebar-toggle-icon>✕</span>
        </button>
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-200">Navigation</p>
    </div>

    <div class="min-h-0 flex-1 overflow-y-auto pb-20">
        <section data-mobile-dock-panel="main" class="space-y-4">
            <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30">
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
            </div>

            @if (count($primaryAdminNavigation) > 0 || count($logsNavigation) > 0)
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30">
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
                        <div class="mt-3 border-t border-slate-800 pt-3">
                            <p class="mb-2 px-1 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Logs</p>
                            <nav class="space-y-2">
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
                            </nav>
                        </div>
                    @endif
                </div>
            @endif
        </section>

        <section data-mobile-dock-panel="setup" class="hidden space-y-4">
            <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30">
                <p class="mb-3 px-1 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Setup Base Features</p>
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
            </div>

            @if (count($setupAdminNavigation) > 0)
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30">
                    <p class="mb-3 px-1 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Setup Administrator</p>
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
            @endif
        </section>

        <section data-mobile-dock-panel="settings" class="hidden">
            <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30">
                <p class="mb-3 px-1 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Settings</p>
                <nav class="space-y-2">
                    @can('manage-platform-settings')
                        <a wire:navigate href="{{ route('platform.settings.general') }}" @class([
                            'flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition',
                            'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.general'),
                            'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.general'),
                        ])><x-layouts.nav-icon icon="settings" />Platform General</a>
                        <a wire:navigate href="{{ route('platform.settings.general.company-information') }}" @class([
                            'flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition',
                            'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.general.company-information'),
                            'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.general.company-information'),
                        ])><x-layouts.nav-icon icon="docs" />Company Information</a>
                        <a wire:navigate href="{{ route('platform.settings.general.localization') }}" @class([
                            'flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition',
                            'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.general.localization'),
                            'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.general.localization'),
                        ])><x-layouts.nav-icon icon="settings" />Localization</a>
                        <a wire:navigate href="{{ route('platform.settings.general.email') }}" @class([
                            'flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition',
                            'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.general.email'),
                            'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.general.email'),
                        ])><x-layouts.nav-icon icon="bell" />Email</a>
                        <a wire:navigate href="{{ route('platform.settings.general.system-update') }}" @class([
                            'flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition',
                            'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.general.system-update'),
                            'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.general.system-update'),
                        ])><x-layouts.nav-icon icon="settings" />System Update</a>
                        <a wire:navigate href="{{ route('platform.settings.general.system-server-info') }}" @class([
                            'flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition',
                            'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.general.system-server-info'),
                            'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.general.system-server-info'),
                        ])><x-layouts.nav-icon icon="settings" />System/Server Info</a>
                        <a wire:navigate href="{{ route('platform.settings.notifications') }}" @class([
                            'flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition',
                            'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.notifications'),
                            'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.notifications'),
                        ])><x-layouts.nav-icon icon="bell" />Notification Defaults</a>
                        <a wire:navigate href="{{ route('platform.settings.audit-logs') }}" @class([
                            'flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition',
                            'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.audit-logs'),
                            'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.audit-logs'),
                        ])><x-layouts.nav-icon icon="audit-log" />Audit Settings</a>
                        <a wire:navigate href="{{ route('platform.settings.docs') }}" @class([
                            'flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition',
                            'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.docs'),
                            'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.docs'),
                        ])><x-layouts.nav-icon icon="docs" />Vault Access</a>
                        <a wire:navigate href="{{ route('platform.settings.users') }}" @class([
                            'flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition',
                            'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => request()->routeIs('platform.settings.users'),
                            'text-slate-300 hover:bg-slate-800 hover:text-white' => ! request()->routeIs('platform.settings.users'),
                        ])><x-layouts.nav-icon icon="users" />User Defaults</a>
                    @else
                        <p class="rounded-md border border-dashed border-slate-700 bg-slate-900/60 px-4 py-3 text-sm text-slate-400">
                            Settings navigation is not available for this account.
                        </p>
                    @endcan
                </nav>
            </div>
        </section>
    </div>

    <div class="absolute inset-x-3 bottom-3 rounded-xl border border-slate-700 bg-slate-900/95 p-2 shadow-2xl shadow-black/40" role="tablist" aria-label="Navigation dock">
        <div class="grid grid-cols-3 gap-2">
            <button type="button" class="flex items-center justify-center rounded-lg px-2 py-2 text-xs font-semibold text-slate-300 transition" data-mobile-dock-target="main">
                <x-layouts.nav-icon icon="home" />
                <span class="ml-1">Main</span>
            </button>
            <button type="button" class="flex items-center justify-center rounded-lg px-2 py-2 text-xs font-semibold text-slate-300 transition" data-mobile-dock-target="setup">
                <x-layouts.nav-icon icon="settings" />
                <span class="ml-1">Setup</span>
            </button>
            <button type="button" class="flex items-center justify-center rounded-lg px-2 py-2 text-xs font-semibold text-slate-300 transition" data-mobile-dock-target="settings">
                <x-layouts.nav-icon icon="users" />
                <span class="ml-1">Settings</span>
            </button>
        </div>
    </div>
</div>
