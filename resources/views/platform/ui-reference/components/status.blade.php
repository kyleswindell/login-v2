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
                <x-ui.badge label="neutral" semantic="neutral" />
                <x-ui.badge label="info" semantic="info" />
                <x-ui.badge label="success" semantic="success" />
                <x-ui.badge label="notice" semantic="notice" />
                <x-ui.badge label="warning" semantic="warning" />
                <x-ui.badge label="danger" semantic="danger" />
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Emphasis Levels</p>
            <p class="mt-2 text-sm text-slate-400">Soft and outline variants should preserve semantic meaning without introducing color-only differentiation.</p>
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Soft Status</p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <x-ui.badge status="active" />
                        <x-ui.badge status="pending review" />
                        <x-ui.badge status="blocked" />
                    </div>
                </div>

                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Outline Status</p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <x-ui.badge status="ready" variant="outline" />
                        <x-ui.badge status="in progress" variant="outline" />
                        <x-ui.badge status="archived" variant="outline" />
                    </div>
                </div>
            </div>

            <div class="mt-4 rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Solid Status</p>
                <p class="mt-2 text-xs text-slate-500">Use sparingly for critical summary emphasis.</p>
                <div class="mt-3 flex flex-wrap gap-2">
                    <x-ui.badge status="critical" variant="solid" />
                    <x-ui.badge status="failed" variant="solid" />
                    <x-ui.badge status="needs action" variant="solid" />
                </div>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Inline Status Pattern</p>
            <p class="mt-2 text-sm text-slate-400">Lighter status treatment for metadata-heavy rows and logs.</p>
            <div class="mt-4 flex flex-wrap items-center gap-4">
                <x-ui.status status="synced" />
                <x-ui.status status="under review" />
                <x-ui.status status="degraded" />
                <x-ui.status status="failed" />
                <x-ui.status status="archived" dot="true" />
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
                            <td class="px-4 py-3"><x-ui.badge status="synced" /></td>
                            <td class="px-4 py-3"><x-ui.badge status="audited" variant="outline" /></td>
                            <td class="px-4 py-3"><x-ui.badge status="low" /></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-white">Messaging Queue</td>
                            <td class="px-4 py-3"><x-ui.badge status="degraded" /></td>
                            <td class="px-4 py-3"><x-ui.badge status="review" variant="outline" /></td>
                            <td class="px-4 py-3"><x-ui.badge status="moderate" /></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-white">Webhook Replay Service</td>
                            <td class="px-4 py-3"><x-ui.badge status="failed" /></td>
                            <td class="px-4 py-3"><x-ui.badge status="needs action" variant="outline" /></td>
                            <td class="px-4 py-3"><x-ui.badge status="high" /></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </section>
</x-layouts.app>
