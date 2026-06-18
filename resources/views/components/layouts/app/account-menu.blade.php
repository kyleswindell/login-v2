                            <details class="group relative" data-account-menu>
                                <summary class="flex cursor-pointer list-none items-center gap-3 px-1 py-1 transition hover:text-white">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full border border-zinc-600 bg-zinc-800/70 text-sm font-semibold text-zinc-100">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="hidden text-left lg:block">
                                        <p class="text-sm font-semibold text-white">{{ $user->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                    </div>
                                    <span class="text-slate-500 transition group-open:rotate-180">⌄</span>
                                </summary>

                                <div class="absolute right-0 z-50 mt-3 w-72 rounded-lg border border-slate-800 bg-slate-900/95 p-3 shadow-2xl shadow-black/40">
                                    <div class="rounded-md border border-slate-800 bg-slate-950/70 p-2">
                                        <p class="px-2 pb-2 text-xs font-semibold uppercase tracking-[0.15em] text-slate-400">Theme</p>
                                        <div class="grid grid-cols-3 gap-1">
                                            <x-ui.button
                                                type="button"
                                                semantic="ghost"
                                                size="xs"
                                                class="w-full"
                                                data-theme-mode-toggle
                                                data-theme-mode="light"
                                                aria-pressed="{{ $bootThemeMode === 'light' ? 'true' : 'false' }}"
                                                data-ui-current="{{ $bootThemeMode === 'light' ? 'true' : 'false' }}"
                                            >Light</x-ui.button>
                                            <x-ui.button
                                                type="button"
                                                semantic="ghost"
                                                size="xs"
                                                class="w-full"
                                                data-theme-mode-toggle
                                                data-theme-mode="dark"
                                                aria-pressed="{{ $bootThemeMode === 'dark' ? 'true' : 'false' }}"
                                                data-ui-current="{{ $bootThemeMode === 'dark' ? 'true' : 'false' }}"
                                            >Dark</x-ui.button>
                                            <x-ui.button
                                                type="button"
                                                semantic="ghost"
                                                size="xs"
                                                class="w-full"
                                                data-theme-mode-toggle
                                                data-theme-mode="system"
                                                aria-pressed="{{ $bootThemeMode === 'system' ? 'true' : 'false' }}"
                                                data-ui-current="{{ $bootThemeMode === 'system' ? 'true' : 'false' }}"
                                            >System</x-ui.button>
                                        </div>
                                    </div>

                                    @foreach ($accountNavigation as $item)
                                        <x-ui.menu-item href="{{ route($item['route']) }}" wire:navigate :current="request()->routeIs(...$item['active'])" @class([
                                            'mt-2' => $loop->first,
                                            'mt-1' => ! $loop->first,
                                        ])>
                                            {{ $item['label'] }}
                                        </x-ui.menu-item>
                                    @endforeach

                                    <form method="POST" action="{{ route('logout') }}" class="mt-2 border-t border-slate-800 pt-2">
                                        @csrf
                                        <x-ui.button type="submit" semantic="danger-ghost" class="w-full justify-start">
                                            Sign out
                                        </x-ui.button>
                                    </form>
                                </div>
                            </details>
