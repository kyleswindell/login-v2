<x-layouts.app title="UI Reference · Badges And Status">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'components.status'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">Badges And Status Indicators</h1>
            <p class="ui-page-header-copy">Tier 1 contract for semantic status display, emphasis levels, and accessibility-safe contrast.</p>
        </div>

        <section class="ui-card" data-ui-guidance="badge-feedback-semantics" data-guidance-id="P2-F-CQ-009">
            <p class="ui-kicker">Badge And Status Usage Guidance</p>
            <div class="mt-3 grid gap-4 lg:grid-cols-2">
                <div>
                    <h2 class="text-base font-semibold text-slate-100">Badge semantic mapping</h2>
                    <dl class="mt-3 space-y-3 text-sm text-slate-300">
                        <div>
                            <dt class="font-semibold text-slate-100">G-BADGE-01 - Neutral and info</dt>
                            <dd class="mt-1">Use neutral for passive metadata and info for contextual facts that do not require action.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-slate-100">G-BADGE-02 - Success and notice</dt>
                            <dd class="mt-1">Use success for completed or healthy states and notice for queued, scheduled, or review-oriented states.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-slate-100">G-BADGE-03 - Warning and danger</dt>
                            <dd class="mt-1">Use warning for degraded or attention-needed states and danger for failed, blocked, destructive, or security-relevant states.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-slate-100">G-BADGE-04 - Text-first status</dt>
                            <dd class="mt-1">Badges must remain text-first. Icon and color reinforce the label but never replace it.</dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <h2 class="text-base font-semibold text-slate-100">Login App 2.0 boundary</h2>
                    <p class="mt-3 text-sm text-slate-300">Badge semantics use the existing Login App 2.0 neutral, info, success, notice, warning, and danger set. Carbon is a coverage benchmark only; do not adopt Carbon visual tokens, color names, or component chrome.</p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <x-ui.badge label="metadata" semantic="neutral" />
                        <x-ui.badge label="context" semantic="info" />
                        <x-ui.badge label="healthy" semantic="success" />
                        <x-ui.badge label="queued review" semantic="notice" />
                        <x-ui.badge label="needs action" semantic="warning" />
                        <x-ui.badge label="blocked" semantic="danger" />
                    </div>
                </div>
            </div>
        </section>

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
            <p class="ui-kicker">Allowed Variants</p>
            <p class="mt-2 text-sm text-slate-400">Tier 1 badges are limited to base and outline variants only.</p>
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Base Status</p>
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
            <p class="mt-4 text-sm text-slate-400">Disabled is not part of the Tier 1 badge/status contract, so it is intentionally not shown here.</p>
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
