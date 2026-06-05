                    @if ($hasCustomSidebar)
                        <aside
                            class="fixed inset-2 z-[60] hidden shrink-0 overflow-y-auto rounded-2xl border border-slate-700 bg-slate-950/95 p-4 shadow-2xl shadow-black/40 lg:inset-auto lg:sticky lg:top-24 lg:z-auto lg:block lg:w-auto lg:self-start lg:max-h-[calc(100vh-7rem)] lg:overflow-visible lg:rounded-none lg:border-0 lg:bg-transparent lg:p-0 lg:shadow-none"
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
