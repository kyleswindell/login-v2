<x-layouts.app title="UI Reference · Overlays And Feedback">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.overlays'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">Overlays And Feedback</h1>
            <p class="ui-page-header-copy">Tier 1 contract for drawer/modal containers plus toast and inline alert feedback semantics.</p>
        </div>

        <div class="pointer-events-none fixed right-6 top-24 z-40 w-[min(100%-3rem,28rem)]" data-ui-demo-toast-page-stack data-ui-demo-toast-generated-overlay>
            <div class="pointer-events-auto flex flex-col gap-3" data-ui-demo-toast-generated-stack aria-live="polite" aria-label="Generated toast stack"></div>
        </div>

        <section class="ui-card" data-ui-guidance="notification-feedback-usage" data-guidance-id="P2-F-CQ-009">
            <p class="ui-kicker">Notification And Feedback Usage Guidance</p>
            <div class="mt-3 grid gap-4 lg:grid-cols-2">
                <div>
                    <h2 class="text-base font-semibold text-slate-100">Feedback surface selection</h2>
                    <dl class="mt-3 space-y-3 text-sm text-slate-300">
                        <div>
                            <dt class="font-semibold text-slate-100">G-NOTIF-01 - Inline alert</dt>
                            <dd class="mt-1">Use inline alerts for feedback that belongs inside a form, card, table, or persistent content region.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-slate-100">G-NOTIF-02 - Toast</dt>
                            <dd class="mt-1">Use toasts for transient AJAX feedback after same-page saves, generated reports, background updates, or dismissible confirmations.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-slate-100">G-NOTIF-03 - Callout or banner</dt>
                            <dd class="mt-1">Use a callout or banner when the message applies to the whole page, blocks a workflow, or must remain visible across scroll.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-slate-100">G-NOTIF-04 - Severity and live region</dt>
                            <dd class="mt-1">Use polite live regions for neutral, info, success, and notice feedback; use alert semantics for warning and danger feedback.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-slate-100">G-NOTIF-05 - Stacking and placement</dt>
                            <dd class="mt-1">Stack toasts from newest to oldest in the top-right feedback region, cap visible messages, and keep inline alerts near the triggering content.</dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <h2 class="text-base font-semibold text-slate-100">Same-page feedback rules</h2>
                    <ul class="mt-3 list-disc space-y-2 pl-5 text-sm text-slate-300">
                        <li>AJAX feedback should not imply a full page refresh unless the action actually navigates or reloads.</li>
                        <li>Multi-notification stacking must preserve placement, dismiss controls, and live-region behavior.</li>
                        <li>Persisted notifications belong in the notification center or page content, not only in a transient toast.</li>
                        <li>Guidance remains Login App 2.0-specific and does not adopt Carbon visual tokens.</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="ui-card" data-ui-guidance="overlay-loading-usage" data-guidance-id="P2-F-CQ-011">
            <p class="ui-kicker">Overlay, Tooltip, And Loading Guidance</p>
            <div class="mt-3 grid gap-4 lg:grid-cols-3">
                <dl class="space-y-3 text-sm text-slate-300">
                    <div>
                        <dt class="font-semibold text-slate-100">G-MODAL-01 - Modal variants</dt>
                        <dd class="mt-1">Use passive modals for read-only notices, transactional modals for decisions, danger modals for destructive confirmation, acknowledgment modals for required confirmation, and progress modals only for blocking tasks.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-slate-100">G-MODAL-02 - Focus trap</dt>
                        <dd class="mt-1">Modals must move focus inside on open, trap keyboard focus while open, close through approved exits, and return focus to the trigger.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-slate-100">G-MODAL-03 - Modal vs page or panel</dt>
                        <dd class="mt-1">Use a dedicated page or side panel when the task needs deep navigation, large forms, or long-lived context instead of a blocking modal.</dd>
                    </div>
                </dl>

                <dl class="space-y-3 text-sm text-slate-300">
                    <div>
                        <dt class="font-semibold text-slate-100">G-TOOLTIP-01 - Tooltip vs toggletip</dt>
                        <dd class="mt-1">Use tooltip for short non-interactive help; use toggletip or disclosure for interactive, focusable, or dismissible explanatory content.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-slate-100">G-TOOLTIP-02 - Definition tooltip</dt>
                        <dd class="mt-1">Use definition tooltip behavior only for terms that need concise glossary help and keep the term visible in the source text.</dd>
                    </div>
                </dl>

                <dl class="space-y-3 text-sm text-slate-300">
                    <div>
                        <dt class="font-semibold text-slate-100">G-LOAD-01 - Spinner vs skeleton</dt>
                        <dd class="mt-1">Use skeletons when layout shape is known and loading affects structured content; use spinners for short indeterminate actions.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-slate-100">G-LOAD-02 - Full-page vs inline loading</dt>
                        <dd class="mt-1">Use full-page loading only for initial route or shell blocking states; use inline loading for local widgets, rows, forms, and panels.</dd>
                    </div>
                </dl>
            </div>
        </section>

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
                    <x-ui.button semantic="primary" data-ui-demo-overlay-open="reference-drawer">Open Drawer</x-ui.button>
                    <x-ui.button variant="outline" class="ring-2 ring-sky-400/40 ring-offset-2 ring-offset-slate-950" data-ui-demo-overlay-open="reference-drawer">Focused Trigger</x-ui.button>
                    <x-ui.button semantic="primary" disabled>Disabled Trigger</x-ui.button>
                </div>
                <p class="mt-3 text-sm text-slate-400">Open the drawer and verify focus lands inside the panel, `Escape` closes it, backdrop click closes it, and focus returns to the trigger.</p>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Modal Baseline</p>
            <div class="mt-4 rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                <div class="flex flex-wrap items-center gap-3">
                    <x-ui.button semantic="danger" data-ui-demo-overlay-open="reference-modal">Open Destructive Modal</x-ui.button>
                    <x-ui.button variant="outline" class="ring-2 ring-sky-400/40 ring-offset-2 ring-offset-slate-950" data-ui-demo-overlay-open="reference-modal">Focused Trigger</x-ui.button>
                    <x-ui.button semantic="danger" disabled>Disabled Trigger</x-ui.button>
                </div>
                <p class="mt-3 text-sm text-slate-400">This modal is the blocking Tier 1 confirmation baseline. It should close via explicit action, `Escape`, or backdrop click.</p>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Inline Alerts</p>
            <p class="mt-2 text-sm text-slate-400">Tier 1 inline alerts use the base display only and cover the canonical severity map.</p>
            <div class="mt-4 grid gap-3">
                <x-ui.inline-alert semantic="neutral">Neutral: Workspace defaults are unchanged.</x-ui.inline-alert>
                <x-ui.inline-alert semantic="info">Info: Workspace settings were loaded from policy defaults.</x-ui.inline-alert>
                <x-ui.inline-alert semantic="success">Success: Notification digest preferences updated.</x-ui.inline-alert>
                <x-ui.inline-alert semantic="notice">Notice: Review handoff was scheduled for the next batch pass.</x-ui.inline-alert>
                <x-ui.inline-alert semantic="warning">Warning: Audit export contains redacted values.</x-ui.inline-alert>
                <x-ui.inline-alert semantic="danger">Danger: Failed to persist queue escalation policy.</x-ui.inline-alert>
            </div>
        </section>

        <section class="ui-card" data-ui-demo-toast-root>
            <p class="ui-kicker">Toast Baseline</p>
            <div class="mt-2 flex flex-wrap items-center gap-3">
                <p class="text-sm text-slate-400">Toasts should use a polite live region for non-critical updates, an assertive region for high-severity failures, and only minimal baseline entry/exit motion.</p>
                <x-ui.button variant="ghost" size="xs" data-ui-demo-toast-reset>Reset Toast Stack</x-ui.button>
                <x-ui.button semantic="info" variant="soft" size="xs" data-ui-demo-toast-generate>Generate Example Toast</x-ui.button>
            </div>
            <div class="mt-4 flex flex-col gap-3" data-ui-demo-toast-stack>
                <x-ui.toast semantic="neutral" title="Neutral" data-ui-demo-toast>
                    Workspace baseline saved without further action.
                    <x-slot:actions>
                        <x-ui.button variant="ghost" size="xs" data-ui-demo-toast-dismiss>Dismiss</x-ui.button>
                    </x-slot:actions>
                </x-ui.toast>
                <x-ui.toast semantic="info" title="Info" data-ui-demo-toast>
                    A new reference sample is available for review.
                    <x-slot:actions>
                        <x-ui.button variant="ghost" size="xs" data-ui-demo-toast-dismiss>Dismiss</x-ui.button>
                    </x-slot:actions>
                </x-ui.toast>
                <x-ui.toast semantic="success" title="Success" data-ui-demo-toast>
                    Notification digest preferences updated.
                    <x-slot:actions>
                        <x-ui.button variant="ghost" size="xs" data-ui-demo-toast-dismiss>Dismiss</x-ui.button>
                    </x-slot:actions>
                </x-ui.toast>
                <x-ui.toast semantic="notice" title="Notice" data-ui-demo-toast>
                    Batch handoff is queued after documentation sync.
                    <x-slot:actions>
                        <x-ui.button variant="ghost" size="xs" data-ui-demo-toast-dismiss>Dismiss</x-ui.button>
                    </x-slot:actions>
                </x-ui.toast>
                <x-ui.toast semantic="warning" title="Warning" data-ui-demo-toast>
                    Audit export contains redacted values.
                    <x-slot:actions>
                        <x-ui.button variant="ghost" size="xs" data-ui-demo-toast-dismiss>Dismiss</x-ui.button>
                    </x-slot:actions>
                </x-ui.toast>
                <x-ui.toast semantic="danger" title="Danger" data-ui-demo-toast>
                    Could not reach notification provider. Retry in 30 seconds.
                    <x-slot:actions>
                        <x-ui.button variant="ghost" size="xs" data-ui-demo-toast-dismiss>Dismiss</x-ui.button>
                    </x-slot:actions>
                </x-ui.toast>
                <template data-ui-demo-toast-template>
                    <x-ui.toast semantic="info" title="Generated Example" data-ui-demo-toast data-ui-demo-generated-toast class="hidden">
                        Review the baseline toast entry and dismiss motion on a fresh example.
                        <x-slot:actions>
                            <x-ui.button variant="ghost" size="xs" data-ui-demo-toast-dismiss>Dismiss</x-ui.button>
                        </x-slot:actions>
                    </x-ui.toast>
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

        <x-ui.drawer
            data-ui-demo-overlay="reference-drawer"
            title-id="reference-drawer-title"
            kicker="Drawer Baseline"
            title="Workspace Detail Drawer"
            description="Context stays intact while detail content is inspected in a right-side panel."
        >
            <x-slot:headerActions>
                <x-ui.button variant="ghost" data-ui-demo-close>Close</x-ui.button>
            </x-slot:headerActions>

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

            <x-slot:actions>
                <x-ui.button variant="ghost" data-ui-demo-close>Cancel</x-ui.button>
                <x-ui.button semantic="primary">Take Action</x-ui.button>
            </x-slot:actions>
        </x-ui.drawer>

        <x-ui.modal
            data-ui-demo-overlay="reference-modal"
            title-id="reference-modal-title"
            kicker="Modal Baseline"
            title="Delete Workspace?"
            description="This destructive action is blocking, explicit, and keeps the consequence language visible."
            tone="danger"
        >
            <x-ui.inline-alert semantic="danger">
                This removes linked policies and cannot be undone.
            </x-ui.inline-alert>

            <x-slot:actions>
                <x-ui.button variant="ghost" data-ui-demo-close>Cancel</x-ui.button>
                <x-ui.button semantic="danger" loading>Deleting</x-ui.button>
                <x-ui.button semantic="danger">Delete</x-ui.button>
            </x-slot:actions>
        </x-ui.modal>
    </section>
</x-layouts.app>
