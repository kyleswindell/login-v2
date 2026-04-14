<x-layouts.app title="UI Reference · Badges And Status">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'components.status'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">Badges And Status Indicators</h1>
            <p class="ui-page-header-copy">Tier 1 contract for semantic status display, emphasis levels, and accessibility-safe contrast.</p>
        </div>

        <section class="ui-card">
            <p class="ui-kicker">Semantic Status</p>
            <div class="mt-4 flex flex-wrap gap-2 text-xs font-semibold uppercase tracking-[0.15em]">
                <span class="rounded-full bg-slate-700/60 px-3 py-1 text-slate-200">neutral</span>
                <span class="rounded-full bg-sky-500/15 px-3 py-1 text-sky-300">info</span>
                <span class="rounded-full bg-emerald-500/15 px-3 py-1 text-emerald-300">success</span>
                <span class="rounded-full bg-violet-500/15 px-3 py-1 text-violet-300">notice</span>
                <span class="rounded-full bg-amber-500/15 px-3 py-1 text-amber-300">warning</span>
                <span class="rounded-full bg-rose-500/15 px-3 py-1 text-rose-300">danger</span>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Emphasis Levels</p>
            <p class="mt-2 text-sm text-slate-400">Soft and outline variants should preserve semantic meaning without introducing color-only differentiation.</p>
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Soft Status</p>
                    <div class="mt-3 flex flex-wrap gap-2 text-xs font-semibold uppercase tracking-[0.15em]">
                        <span class="rounded-full bg-emerald-500/15 px-3 py-1 text-emerald-300">active</span>
                        <span class="rounded-full bg-amber-500/15 px-3 py-1 text-amber-300">pending review</span>
                        <span class="rounded-full bg-rose-500/15 px-3 py-1 text-rose-300">blocked</span>
                    </div>
                </div>

                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Outline Status</p>
                    <div class="mt-3 flex flex-wrap gap-2 text-xs font-semibold uppercase tracking-[0.15em]">
                        <span class="rounded-full border border-emerald-500/50 px-3 py-1 text-emerald-300">ready</span>
                        <span class="rounded-full border border-violet-500/50 px-3 py-1 text-violet-300">in progress</span>
                        <span class="rounded-full border border-slate-500/60 px-3 py-1 text-slate-300">archived</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Status In Context</p>
            <div class="mt-4 overflow-x-auto rounded-lg border border-slate-800 bg-slate-900/70">
                <table class="w-full min-w-[720px] divide-y divide-slate-800">
                    <thead class="bg-slate-900">
                        <tr class="text-left text-xs uppercase tracking-[0.2em] text-slate-500">
                            <th class="px-4 py-3">Entity</th>
                            <th class="px-4 py-3">Sync Status</th>
                            <th class="px-4 py-3">Compliance</th>
                            <th class="px-4 py-3">Risk</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 text-sm text-slate-200">
                        <tr>
                            <td class="px-4 py-3 text-white">North Region Tenant</td>
                            <td class="px-4 py-3"><span class="rounded-full bg-emerald-500/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] text-emerald-300">synced</span></td>
                            <td class="px-4 py-3"><span class="rounded-full border border-sky-500/50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] text-sky-300">audited</span></td>
                            <td class="px-4 py-3"><span class="rounded-full bg-slate-700/60 px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] text-slate-200">low</span></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-white">Messaging Queue</td>
                            <td class="px-4 py-3"><span class="rounded-full bg-amber-500/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] text-amber-300">degraded</span></td>
                            <td class="px-4 py-3"><span class="rounded-full border border-violet-500/50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] text-violet-300">review</span></td>
                            <td class="px-4 py-3"><span class="rounded-full bg-amber-500/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] text-amber-300">moderate</span></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-white">Webhook Replay Service</td>
                            <td class="px-4 py-3"><span class="rounded-full bg-rose-500/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] text-rose-300">failed</span></td>
                            <td class="px-4 py-3"><span class="rounded-full border border-rose-500/60 px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] text-rose-300">needs action</span></td>
                            <td class="px-4 py-3"><span class="rounded-full bg-rose-500/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] text-rose-300">high</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </section>
</x-layouts.app>
