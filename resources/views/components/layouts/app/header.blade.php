                <header class="sticky top-0 z-40 border-b border-slate-800 bg-slate-950/90 backdrop-blur">
                    <div class="mx-auto flex w-full max-w-[1700px] items-center gap-4 px-4 py-4 xl:px-6">
                        <button
                            type="button"
                            class="ui-icon-button lg:hidden"
                            aria-label="Toggle navigation"
                            data-sidebar-toggle
                        >
                            <span class="text-base leading-none" data-sidebar-toggle-icon>☰</span>
                        </button>

                        <a href="{{ route('dashboard') }}" wire:navigate class="flex min-w-0 items-center gap-3 py-1">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full border border-zinc-600 bg-zinc-800/70 text-lg font-semibold text-zinc-100">P</div>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-white">Parasolutions Platform</p>
                                <p class="truncate text-xs uppercase tracking-[0.2em] text-slate-500">Login App 2.0</p>
                            </div>
                        </a>

                        <div class="hidden min-w-0 flex-1 justify-center md:flex">
                            <label for="app-search" class="sr-only">Search</label>
                            <div class="relative w-full max-w-[22rem] xl:max-w-[26rem]">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500">Search</span>
                                <input
                                    id="app-search"
                                    type="text"
                                    placeholder="Global search coming soon"
                                    class="w-full rounded-md border border-slate-700 bg-slate-900/40 py-2.5 pl-20 pr-4 text-sm text-slate-200 placeholder:text-slate-500 focus:border-slate-500/60 focus:outline-none"
                                >
                            </div>
                        </div>

                        <div class="ml-auto flex items-center gap-3">
                            @include('components.layouts.app.notification-menu')

                            @include('components.layouts.app.account-menu')
                        </div>
                    </div>
                </header>
