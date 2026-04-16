<x-layouts.app title="UI Reference · Navigation Behavior">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.navigation'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">Navigation Behavior Standards</h1>
            <p class="ui-page-header-copy">Tier 1 contract for sidebar, mobile dock, and account menu behavior parity across responsive breakpoints.</p>
        </div>

        <section class="ui-card">
            <p class="ui-kicker">Shell Rules</p>
            <div class="mt-4 grid gap-4 lg:grid-cols-3">
                <article class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <h2 class="text-sm font-semibold uppercase tracking-[0.15em] text-slate-300">Desktop</h2>
                    <ul class="mt-3 list-disc space-y-1 pl-4 text-sm text-slate-300">
                        <li>Sidebar remains visible and sticky.</li>
                        <li>No hamburger toggle in normal desktop width.</li>
                        <li>Active route uses high-contrast state token.</li>
                    </ul>
                </article>
                <article class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <h2 class="text-sm font-semibold uppercase tracking-[0.15em] text-slate-300">Mobile/Small Width</h2>
                    <ul class="mt-3 list-disc space-y-1 pl-4 text-sm text-slate-300">
                        <li>Header toggle opens sidebar modal.</li>
                        <li>Modal is nearly full-screen with visible container edge.</li>
                        <li>Close with `X`, backdrop click, or route navigation.</li>
                    </ul>
                </article>
                <article class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <h2 class="text-sm font-semibold uppercase tracking-[0.15em] text-slate-300">Navigation Sets</h2>
                    <ul class="mt-3 list-disc space-y-1 pl-4 text-sm text-slate-300">
                        <li>Main, Setup, and Settings remain independent.</li>
                        <li>Only one menu set visible at a time on mobile.</li>
                        <li>Bottom dock switches sets without route change.</li>
                    </ul>
                </article>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Account Dropdown Parity</p>
            <div class="mt-4 rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                <p class="text-sm text-slate-300">Sidebar toggle behavior should match account menu fundamentals: explicit open/close state, outside-click dismissal, escape handling, and keyboard focus return.</p>
                <div class="mt-4 flex flex-wrap gap-3">
                    <span class="rounded-full bg-emerald-500/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] text-emerald-300">open state token</span>
                    <span class="rounded-full bg-sky-500/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] text-sky-300">aria-expanded sync</span>
                    <span class="rounded-full bg-violet-500/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] text-violet-300">focus-return target</span>
                    <span class="rounded-full bg-amber-500/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] text-amber-300">route-change close</span>
                </div>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Desktop Sidebar Validation</p>
            <div class="mt-4 grid gap-4 xl:grid-cols-2">
                <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Sidebar Baseline</p>
                    <div class="mt-3 max-w-sm rounded-lg border border-slate-800 bg-slate-900/70 p-3">
                        <a href="#" class="flex items-center gap-3 rounded-md bg-slate-700/60 px-4 py-3 text-sm font-medium text-white ring-1 ring-slate-500/40">
                            <x-layouts.nav-icon icon="home" />
                            <span>Dashboard</span>
                        </a>
                        <a href="#" class="mt-2 flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium text-slate-300 transition hover:bg-slate-800 hover:text-white">
                            <x-layouts.nav-icon icon="docs" />
                            <span>Documentation Vault</span>
                        </a>
                        <a href="#" class="mt-2 flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium text-slate-300 ring-2 ring-sky-400/40 ring-offset-2 ring-offset-slate-900">
                            <x-layouts.nav-icon icon="audit-log" />
                            <span>Focused Audit Logs</span>
                        </a>
                    </div>
                </div>
                <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Header + Account Menu</p>
                    <div class="mt-3 rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                        <div class="flex items-center justify-between gap-3">
                            <button type="button" class="ui-icon-button" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="text-base leading-none">☰</span>
                            </button>
                            <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-2">
                                <button type="button" class="ui-action ui-action-ghost ui-action-xs" aria-expanded="true">Account</button>
                                <div class="mt-2 rounded-md border border-slate-800 bg-slate-900/70 p-2">
                                    <a href="#" class="block rounded-md px-3 py-2 text-sm text-slate-300 hover:bg-slate-800 hover:text-white">Preferences</a>
                                    <a href="#" class="mt-1 block rounded-md px-3 py-2 text-sm text-slate-300 hover:bg-slate-800 hover:text-white">Platform Settings</a>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 text-sm text-slate-400">Review open/closed parity, focus treatment, and current-location clarity without changing route context.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Mobile Breakpoint Coverage</p>
            <p class="mt-2 text-sm text-slate-400">This compressed view mirrors the mobile sidebar modal and dock behavior used below the `lg` breakpoint.</p>
            <div class="mt-4 grid gap-4 xl:grid-cols-2">
                <div class="rounded-[1.5rem] border border-slate-800 bg-slate-950/70 p-4 shadow-2xl shadow-black/30">
                    <div class="mx-auto max-w-sm rounded-[1.25rem] border border-slate-800 bg-slate-900/70 p-4">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                            <button type="button" class="ui-icon-button ring-2 ring-sky-400/40 ring-offset-2 ring-offset-slate-900" aria-expanded="true" aria-label="Close navigation">
                                <span class="text-base leading-none">✕</span>
                            </button>
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-200">Navigation</p>
                            <span class="h-10 w-10"></span>
                        </div>
                        <div class="mt-4 space-y-3">
                            <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                                <p class="mb-2 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Main</p>
                                <a href="#" class="flex items-center gap-3 rounded-md bg-slate-700/60 px-4 py-3 text-sm font-medium text-white ring-1 ring-slate-500/40">
                                    <x-layouts.nav-icon icon="home" /> Dashboard
                                </a>
                                <a href="#" class="mt-2 flex items-center gap-3 rounded-md px-4 py-3 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white">
                                    <x-layouts.nav-icon icon="bell" /> Notifications
                                </a>
                            </div>
                            <div class="rounded-xl border border-slate-700 bg-slate-900/95 p-2 shadow-2xl shadow-black/40" role="tablist" aria-label="Navigation dock">
                                <div class="grid grid-cols-3 gap-2">
                                    <button type="button" class="rounded-lg bg-slate-700/60 px-2 py-2 text-xs font-semibold text-white ring-1 ring-slate-500/40" aria-pressed="true">Main</button>
                                    <button type="button" class="rounded-lg px-2 py-2 text-xs font-semibold text-slate-300">Setup</button>
                                    <button type="button" class="rounded-lg px-2 py-2 text-xs font-semibold text-slate-300">Settings</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Breakpoint Checks</p>
                    <ul class="mt-3 list-disc space-y-2 pl-4 text-sm text-slate-300">
                        <li>Desktop keeps sidebar fixed-open and hides the hamburger toggle.</li>
                        <li>Mobile opens a modal-style navigation container with visible backdrop separation.</li>
                        <li>Only one dock panel is active at a time, and the selected dock button remains explicit.</li>
                        <li>Current-location emphasis stays distinct from hover-only states.</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Implementation Pointers</p>
            <ul class="mt-4 list-disc space-y-2 pl-4 text-sm text-slate-300">
                <li>`resources/views/components/layouts/app.blade.php` owns header/sidebar shell and responsive panel containers.</li>
                <li>`resources/views/components/layouts/mobile-sidebar.blade.php` owns mobile modal structure and dock state targets.</li>
                <li>`resources/js/app.js` owns sidebar open/close state, dock panel state, and auto-close on `wire:navigate` events.</li>
            </ul>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Layout And Scaffolding</p>
            <p class="mt-2 text-sm text-slate-400">Container, grid, stack, and section/panel primitives stay structural and do not absorb Tier 2 card semantics.</p>
            <div class="mt-4 space-y-4">
                <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Container + Stack</p>
                    <div class="mt-3 max-w-4xl space-y-3">
                        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                            <h2 class="text-base font-semibold text-white">Section / Panel Baseline</h2>
                            <p class="mt-2 text-sm text-slate-400">Panels frame grouped content while nested controls provide the actual interaction states.</p>
                        </div>
                        <div class="rounded-lg border border-dashed border-slate-700 px-4 py-3 text-sm text-slate-400">
                            Stack spacing preserves readable vertical rhythm across shell sections.
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Grid Baseline</p>
                    <div class="mt-3 grid gap-3 md:grid-cols-3">
                        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4 text-sm text-slate-300">Primary column</div>
                        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4 text-sm text-slate-300">Secondary column</div>
                        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4 text-sm text-slate-300">Support column</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Validation Surface</p>
            <div class="mt-4 overflow-x-auto rounded-lg border border-slate-800 bg-slate-900/70">
                <table class="min-w-[820px] w-full divide-y divide-slate-800">
                    <thead class="bg-slate-900">
                        <tr class="text-left text-xs uppercase tracking-[0.2em] text-slate-500">
                            <th class="px-4 py-3">Surface</th>
                            <th class="px-4 py-3">Visible States</th>
                            <th class="px-4 py-3">Breakpoint / Behavior</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 text-sm text-slate-200">
                        <tr>
                            <td class="px-4 py-3 text-white">Sidebar</td>
                            <td class="px-4 py-3">default, hover, focus, selected/current</td>
                            <td class="px-4 py-3">desktop fixed-open, current-location preserved</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-white">Header + account menu</td>
                            <td class="px-4 py-3">default, focus, open state</td>
                            <td class="px-4 py-3">outside-click dismissal, `Escape`, focus return target</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-white">Mobile nav dock</td>
                            <td class="px-4 py-3">default, selected, focus</td>
                            <td class="px-4 py-3">single active panel, mobile modal container below `lg`</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </section>
</x-layouts.app>
