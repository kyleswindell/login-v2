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
            <div class="mt-4 flex flex-wrap gap-2">
                <span class="ui-status-pill ui-status-neutral">neutral</span>
                <span class="ui-status-pill ui-status-info">info</span>
                <span class="ui-status-pill ui-status-success">success</span>
                <span class="ui-status-pill ui-status-notice">notice</span>
                <span class="ui-status-pill ui-status-warning">warning</span>
                <span class="ui-status-pill ui-status-danger">danger</span>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Emphasis Levels</p>
            <p class="mt-2 text-sm text-slate-400">Soft and outline variants should preserve semantic meaning without introducing color-only differentiation.</p>
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Soft Status</p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <span class="ui-status-pill ui-status-success">active</span>
                        <span class="ui-status-pill ui-status-warning">pending review</span>
                        <span class="ui-status-pill ui-status-danger">blocked</span>
                    </div>
                </div>

                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Outline Status</p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <span class="ui-status-pill ui-status-success ui-status-outline">ready</span>
                        <span class="ui-status-pill ui-status-notice ui-status-outline">in progress</span>
                        <span class="ui-status-pill ui-status-neutral ui-status-outline">archived</span>
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
                            <td class="px-4 py-3"><span class="ui-status-pill ui-status-success">synced</span></td>
                            <td class="px-4 py-3"><span class="ui-status-pill ui-status-info ui-status-outline">audited</span></td>
                            <td class="px-4 py-3"><span class="ui-status-pill ui-status-neutral">low</span></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-white">Messaging Queue</td>
                            <td class="px-4 py-3"><span class="ui-status-pill ui-status-warning">degraded</span></td>
                            <td class="px-4 py-3"><span class="ui-status-pill ui-status-notice ui-status-outline">review</span></td>
                            <td class="px-4 py-3"><span class="ui-status-pill ui-status-warning">moderate</span></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-white">Webhook Replay Service</td>
                            <td class="px-4 py-3"><span class="ui-status-pill ui-status-danger">failed</span></td>
                            <td class="px-4 py-3"><span class="ui-status-pill ui-status-danger ui-status-outline">needs action</span></td>
                            <td class="px-4 py-3"><span class="ui-status-pill ui-status-danger">high</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </section>
</x-layouts.app>
