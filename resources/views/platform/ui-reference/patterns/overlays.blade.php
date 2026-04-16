<x-layouts.app title="UI Reference · Overlays And Feedback">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.overlays'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">Overlays And Feedback</h1>
            <p class="ui-page-header-copy">Tier 1 contract for drawer/modal containers plus toast and inline alert feedback semantics.</p>
        </div>

        <div class="flex justify-end" data-ui-demo-toast-page-stack>
            <div class="flex w-full max-w-md flex-col gap-3" data-ui-demo-toast-generated-stack aria-live="polite" aria-label="Generated toast stack"></div>
        </div>

        <section class="ui-card">
            <p class="ui-kicker">Drawer Baseline</p>
            <p class="mt-2 text-sm text-slate-400">Use right-side drawer for contextual details while preserving table context. See live behavior in Table Baselines.</p>
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <article class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <h2 class="text-sm font-semibold uppercase tracking-[0.15em] text-slate-300">Required Behavior</h2>
                    <ul class="mt-3 list-disc space-y-1 pl-4 text-sm text-slate-300">
                        <li>Escape closes when dismissible.</li>
                        <li>Focus moves into panel on open.</li>
                        <li>Focus returns to invoking trigger on close.</li>
                        <li>Backdrop click behavior is explicit.</li>
                    </ul>
                </article>
                <article class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <h2 class="text-sm font-semibold uppercase tracking-[0.15em] text-slate-300">Implementation Path</h2>
                    <p class="mt-3 text-sm text-slate-300">Drawer hooks are implemented by `data-audit-log-*` and `data-error-log-*` selectors in `resources/js/app.js` with matching modal shells in the tables reference page.</p>
                </article>
            </div>

            <div class="mt-4 rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" class="ui-action ui-action-primary" data-ui-demo-overlay-open="reference-drawer">Open Drawer</button>
                    <button type="button" class="ui-action ui-action-outline ring-2 ring-sky-400/40 ring-offset-2 ring-offset-slate-950" data-ui-demo-overlay-open="reference-drawer">Focused Trigger</button>
                    <button type="button" disabled class="ui-action ui-action-primary">Disabled Trigger</button>
                </div>
                <p class="mt-3 text-sm text-slate-400">Open the drawer and verify focus lands inside the panel, `Escape` closes it, backdrop click closes it, and focus returns to the trigger.</p>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Modal Baseline</p>
            <div class="mt-4 rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" class="ui-action ui-action-danger" data-ui-demo-overlay-open="reference-modal">Open Destructive Modal</button>
                    <button type="button" class="ui-action ui-action-outline ring-2 ring-sky-400/40 ring-offset-2 ring-offset-slate-950" data-ui-demo-overlay-open="reference-modal">Focused Trigger</button>
                    <button type="button" disabled class="ui-action ui-action-danger">Disabled Trigger</button>
                </div>
                <p class="mt-3 text-sm text-slate-400">This modal is the blocking Tier 1 confirmation baseline. It should close via explicit action, `Escape`, or backdrop click.</p>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Inline Alerts</p>
            <p class="mt-2 text-sm text-slate-400">Tier 1 inline alerts use the base display only and cover the canonical severity map.</p>
            <div class="mt-4 grid gap-3">
                <div class="ui-inline-alert border-slate-700 bg-slate-900/70 text-slate-200" role="status">Neutral: Workspace defaults are unchanged.</div>
                <div class="ui-inline-alert ui-inline-alert-info" role="status">Info: Workspace settings were loaded from policy defaults.</div>
                <div class="ui-inline-alert ui-inline-alert-success" role="status">Success: Notification digest preferences updated.</div>
                <div class="ui-inline-alert ui-inline-alert-notice" role="status">Notice: Review handoff was scheduled for the next batch pass.</div>
                <div class="ui-inline-alert ui-inline-alert-warning" role="alert">Warning: Audit export contains redacted values.</div>
                <div class="ui-inline-alert ui-inline-alert-danger" role="alert">Danger: Failed to persist queue escalation policy.</div>
            </div>
        </section>

        <section class="ui-card" data-ui-demo-toast-root>
            <p class="ui-kicker">Toast Baseline</p>
            <div class="mt-2 flex flex-wrap items-center gap-3">
                <p class="text-sm text-slate-400">Toasts should use a polite live region for non-critical updates, an assertive region for high-severity failures, and only minimal baseline entry/exit motion.</p>
                <button type="button" class="ui-action ui-action-ghost ui-action-xs" data-ui-demo-toast-reset>Reset Toast Stack</button>
                <button type="button" class="ui-action ui-action-soft ui-action-info ui-action-xs" data-ui-demo-toast-generate>Generate Example Toast</button>
            </div>
            <div class="mt-4 flex flex-col gap-3" data-ui-demo-toast-stack>
                <div data-ui-demo-toast class="ui-toast ui-toast-neutral" role="status" aria-live="polite">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="font-semibold text-white">Neutral</p>
                            <p class="mt-1 text-slate-400">Workspace baseline saved without further action.</p>
                        </div>
                        <button type="button" class="ui-action ui-action-ghost ui-action-xs" data-ui-demo-toast-dismiss>Dismiss</button>
                    </div>
                </div>
                <div data-ui-demo-toast class="ui-toast ui-toast-info" role="status" aria-live="polite">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="font-semibold">Info</p>
                            <p class="mt-1">A new reference sample is available for review.</p>
                        </div>
                        <button type="button" class="ui-action ui-action-ghost ui-action-xs" data-ui-demo-toast-dismiss>Dismiss</button>
                    </div>
                </div>
                <div data-ui-demo-toast class="ui-toast ui-toast-success" role="status" aria-live="polite">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="font-semibold">Success</p>
                            <p class="mt-1">Notification digest preferences updated.</p>
                        </div>
                        <button type="button" class="ui-action ui-action-ghost ui-action-xs" data-ui-demo-toast-dismiss>Dismiss</button>
                    </div>
                </div>
                <div data-ui-demo-toast class="ui-toast ui-toast-notice" role="status" aria-live="polite">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="font-semibold">Notice</p>
                            <p class="mt-1">Batch handoff is queued after documentation sync.</p>
                        </div>
                        <button type="button" class="ui-action ui-action-ghost ui-action-xs" data-ui-demo-toast-dismiss>Dismiss</button>
                    </div>
                </div>
                <div data-ui-demo-toast class="ui-toast ui-toast-warning" role="alert" aria-live="assertive">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="font-semibold">Warning</p>
                            <p class="mt-1">Audit export contains redacted values.</p>
                        </div>
                        <button type="button" class="ui-action ui-action-ghost ui-action-xs" data-ui-demo-toast-dismiss>Dismiss</button>
                    </div>
                </div>
                <div data-ui-demo-toast class="ui-toast ui-toast-danger" role="alert" aria-live="assertive">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="font-semibold">Danger</p>
                            <p class="mt-1">Could not reach notification provider. Retry in 30 seconds.</p>
                        </div>
                        <button type="button" class="ui-action ui-action-ghost ui-action-xs" data-ui-demo-toast-dismiss>Dismiss</button>
                    </div>
                </div>
                <template data-ui-demo-toast-template>
                    <div data-ui-demo-toast data-ui-demo-generated-toast class="ui-toast ui-toast-info hidden" role="status" aria-live="polite">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-semibold">Generated Example</p>
                                <p class="mt-1">Review the baseline toast entry and dismiss motion on a fresh example.</p>
                            </div>
                            <button type="button" class="ui-action ui-action-ghost ui-action-xs" data-ui-demo-toast-dismiss>Dismiss</button>
                        </div>
                    </div>
                </template>
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
                            <th class="px-4 py-3">Behavior Check</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 text-sm text-slate-200">
                        <tr>
                            <td class="px-4 py-3 text-white">Drawer baseline</td>
                            <td class="px-4 py-3">default, focus, active open, disabled trigger</td>
                            <td class="px-4 py-3">open trigger, `Escape`, backdrop click, focus return</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-white">Modal baseline</td>
                            <td class="px-4 py-3">default, focus, active open, disabled trigger, loading action</td>
                            <td class="px-4 py-3">open trigger, `Escape`, backdrop click, destructive confirmation copy</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-white">Inline alerts + toasts</td>
                            <td class="px-4 py-3">neutral, info, success, notice, warning, danger</td>
                            <td class="px-4 py-3">dismiss path, live-region role, no ad hoc feedback blocks</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <div data-ui-demo-overlay="reference-drawer" class="fixed inset-0 z-50 hidden bg-black/60" aria-hidden="true">
            <div class="ui-log-drawer-panel" data-ui-demo-panel tabindex="-1" role="dialog" aria-modal="true" aria-labelledby="reference-drawer-title">
                <div class="flex items-start justify-between gap-3 border-b border-slate-800 px-6 py-5">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Drawer Baseline</p>
                        <h2 id="reference-drawer-title" class="mt-2 text-2xl font-semibold text-white">Workspace Detail Drawer</h2>
                        <p class="mt-2 text-sm text-slate-400">Context stays intact while detail content is inspected in a right-side panel.</p>
                    </div>
                    <button type="button" class="ui-action ui-action-ghost" data-ui-demo-close>Close</button>
                </div>
                <div class="overflow-y-auto px-6 py-6">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                            <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Summary</h3>
                            <dl class="mt-3 space-y-2 text-sm text-slate-300">
                                <div class="flex items-center justify-between"><dt>Status</dt><dd><x-ui.badge status="active" :show-icon="false" /></dd></div>
                                <div class="flex items-center justify-between"><dt>Owner</dt><dd>Platform Team</dd></div>
                                <div class="flex items-center justify-between"><dt>Updated</dt><dd>Apr 16, 2026 09:30 AM EDT</dd></div>
                            </dl>
                        </div>
                        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                            <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Focus Return Rule</h3>
                            <p class="mt-3 text-sm text-slate-300">Close this drawer with the footer action or `Escape` and confirm focus returns to the triggering control.</p>
                        </div>
                    </div>
                    <div class="mt-4 rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Actions</h3>
                        <div class="mt-3 flex flex-wrap gap-3">
                            <button type="button" class="ui-action ui-action-ghost" data-ui-demo-close>Cancel</button>
                            <button type="button" class="ui-action ui-action-primary">Take Action</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div data-ui-demo-overlay="reference-modal" class="fixed inset-0 z-50 hidden bg-black/70 px-4 py-8" aria-hidden="true">
            <div class="mx-auto flex min-h-full max-w-xl items-center justify-center">
                <div class="w-full rounded-xl border border-slate-700 bg-slate-950 p-6 shadow-2xl shadow-black/40" data-ui-demo-panel tabindex="-1" role="dialog" aria-modal="true" aria-labelledby="reference-modal-title">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-300">Modal Baseline</p>
                    <h2 id="reference-modal-title" class="mt-2 text-2xl font-semibold text-white">Delete Workspace?</h2>
                    <p class="mt-3 text-sm text-slate-400">This destructive action is blocking, explicit, and keeps the consequence language visible.</p>
                    <div class="ui-inline-alert ui-inline-alert-danger mt-4">
                        This removes linked policies and cannot be undone.
                    </div>
                    <div class="mt-6 flex flex-wrap justify-end gap-3">
                        <button type="button" class="ui-action ui-action-ghost" data-ui-demo-close>Cancel</button>
                        <button type="button" class="ui-action ui-action-danger" aria-busy="true">
                            <span class="ui-spinner" aria-hidden="true"></span>
                            Deleting
                        </button>
                        <button type="button" class="ui-action ui-action-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
