                    @if ($hasCustomSidebar)
                        <aside
                            class="ui-shell-sidebar-host fixed inset-2 z-[60] hidden shrink-0 overflow-y-auto rounded-2xl p-4 lg:inset-auto lg:sticky lg:top-24 lg:z-auto lg:block lg:w-auto lg:self-start lg:max-h-[calc(100vh-7rem)] lg:overflow-visible lg:rounded-none lg:border-0 lg:bg-transparent lg:p-0 lg:shadow-none"
                            data-sidebar-host
                            data-sidebar-panel
                        >
                            <x-layouts.mobile-sidebar
                                :primary-base-navigation="$primaryBaseNavigation"
                                :primary-admin-navigation="$primaryAdminNavigation"
                                :logs-navigation="$logsNavigation"
                                :setup-base-navigation="$setupBaseNavigation"
                                :setup-admin-navigation="$setupAdminNavigation"
                                custom-panel-label="Page"
                            >
                                {{ $sidebar }}
                            </x-layouts.mobile-sidebar>

                            <div class="hidden lg:block">
                                {{ $sidebar }}
                            </div>
                        </aside>
                    @else
                        <aside
                            class="ui-shell-sidebar-host fixed inset-2 z-[60] hidden shrink-0 overflow-y-auto rounded-2xl p-4 lg:inset-auto lg:sticky lg:top-24 lg:z-auto lg:block lg:w-60 lg:self-start lg:max-h-[calc(100vh-7rem)] lg:rounded-none lg:border-0 lg:bg-transparent lg:p-0 lg:shadow-none"
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
                                        <div class="ui-shell-sidebar-panel w-full shrink-0 lg:w-60" data-main-nav-panel>
                                            <p class="ui-shell-sidebar-section-label mb-3 px-1 text-xs font-semibold uppercase tracking-[0.18em]">Base Features</p>
                                            <nav class="space-y-2">
                                                @foreach ($primaryBaseNavigation as $item)
                                                    <a href="{{ route($item['route']) }}" wire:navigate data-main-nav-link @class([
                                                        'ui-shell-sidebar-nav-item flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition',
                                                        'is-current' => request()->routeIs(...$item['active']),
                                                    ])>
                                                        <x-layouts.nav-icon :icon="$item['icon'] ?? null" />
                                                        {{ $item['label'] }}
                                                    </a>
                                                @endforeach
                                            </nav>

                                            @if (count($primaryAdminNavigation) > 0 || count($logsNavigation) > 0)
                                                <div class="ui-shell-sidebar-divider mt-4 border-t pt-4">
                                                    <p class="ui-shell-sidebar-section-label mb-3 px-1 text-xs font-semibold uppercase tracking-[0.18em]">Administrator</p>
                                                    <nav class="space-y-2">
                                                        @foreach ($primaryAdminNavigation as $item)
                                                            <a href="{{ route($item['route']) }}" wire:navigate data-main-nav-link @class([
                                                                'ui-shell-sidebar-nav-item flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition',
                                                                'is-current' => request()->routeIs(...$item['active']),
                                                            ])>
                                                                <x-layouts.nav-icon :icon="$item['icon'] ?? null" />
                                                                {{ $item['label'] }}
                                                            </a>
                                                        @endforeach
                                                    </nav>

                                                    @if (count($logsNavigation) > 0)
                                                        <details class="mt-2 group" @if (collect($logsNavigation)->contains(fn (array $item): bool => request()->routeIs(...$item['active']))) open @endif>
                                                            <summary class="ui-shell-sidebar-nav-item flex cursor-pointer list-none items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition">
                                                                <x-layouts.nav-icon icon="audit-log" />
                                                                <span>Logs</span>
                                                                <span class="ui-shell-sidebar-section-label ml-auto transition group-open:rotate-180">⌄</span>
                                                            </summary>
                                                            <div class="mt-2 space-y-2 pl-2">
                                                                @foreach ($logsNavigation as $item)
                                                                    <a href="{{ route($item['route']) }}" wire:navigate data-main-nav-link @class([
                                                                        'ui-shell-sidebar-nav-item flex items-center gap-3 rounded-md px-4 py-2.5 text-sm font-medium transition',
                                                                        'is-current' => request()->routeIs(...$item['active']),
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
                                                <div class="ui-shell-sidebar-divider mt-4 border-t pt-4">
                                                    <button
                                                        type="button"
                                                        class="ui-shell-sidebar-control flex w-full items-center rounded-md px-4 py-3 text-sm font-medium transition"
                                                        data-setup-open
                                                    >
                                                        <span>Setup</span>
                                                        <span class="ui-shell-sidebar-section-label ml-auto" aria-hidden="true">→</span>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Panel 2: Setup panel --}}
                                        <div class="ui-shell-sidebar-panel w-full shrink-0 lg:w-60" data-setup-nav-panel>
                                            <div class="flex items-center justify-between">
                                                <p class="ui-shell-sidebar-title text-xs font-semibold uppercase tracking-[0.3em]">Setup</p>
                                                <button
                                                    type="button"
                                                    class="ui-shell-sidebar-control-compact"
                                                    data-setup-close
                                                >
                                                    ✕ Close
                                                </button>
                                            </div>

                                            <p class="ui-shell-sidebar-section-label mt-6 mb-3 px-1 text-xs font-semibold uppercase tracking-[0.18em]">Base Features</p>
                                            <nav class="space-y-2">
                                                @foreach ($setupBaseNavigation as $item)
                                                    <a href="{{ route($item['route']) }}" wire:navigate data-setup-nav-link @class([
                                                        'ui-shell-sidebar-nav-item flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition',
                                                        'is-current' => request()->routeIs(...$item['active']),
                                                    ])>
                                                        <x-layouts.nav-icon :icon="$item['icon'] ?? null" />
                                                        {{ $item['label'] }}
                                                    </a>
                                                @endforeach
                                            </nav>

                                            <p class="ui-shell-sidebar-divider ui-shell-sidebar-section-label mt-5 mb-3 border-t pt-4 px-1 text-xs font-semibold uppercase tracking-[0.18em]">Administrator</p>
                                            <nav class="space-y-2">
                                                @foreach ($setupAdminNavigation as $item)
                                                    <a href="{{ route($item['route']) }}" wire:navigate data-setup-nav-link @class([
                                                        'ui-shell-sidebar-nav-item flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium transition',
                                                        'is-current' => request()->routeIs(...$item['active']),
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
