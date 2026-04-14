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
            <p class="ui-kicker">Implementation Pointers</p>
            <ul class="mt-4 list-disc space-y-2 pl-4 text-sm text-slate-300">
                <li>`resources/views/components/layouts/app.blade.php` owns header/sidebar shell and responsive panel containers.</li>
                <li>`resources/views/components/layouts/mobile-sidebar.blade.php` owns mobile modal structure and dock state targets.</li>
                <li>`resources/js/app.js` owns sidebar open/close state, dock panel state, and auto-close on `wire:navigate` events.</li>
            </ul>
        </section>
    </section>
</x-layouts.app>
