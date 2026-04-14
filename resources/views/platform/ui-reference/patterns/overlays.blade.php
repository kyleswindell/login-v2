<x-layouts.app title="UI Reference · Overlays And Feedback">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.overlays'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">Overlays And Feedback</h1>
            <p class="ui-page-header-copy">Tier 1 contract for drawer/modal containers plus toast and inline alert feedback semantics.</p>
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
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Modal Baseline</p>
            <div class="mt-4 rounded-lg border border-slate-800 bg-slate-900/70 p-5">
                <div class="mx-auto max-w-lg rounded-xl border border-slate-700 bg-slate-950 p-5 shadow-2xl shadow-black/40">
                    <h2 class="text-lg font-semibold text-white">Delete Workspace?</h2>
                    <p class="mt-2 text-sm text-slate-400">This action removes linked policies and cannot be undone.</p>
                    <div class="mt-5 flex flex-wrap justify-end gap-3">
                        <button type="button" class="ui-action ui-action-ghost">Cancel</button>
                        <button type="button" class="ui-action ui-action-danger">Delete</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Inline Alerts</p>
            <div class="mt-4 grid gap-3">
                <div class="rounded-lg border border-sky-500/40 bg-sky-500/10 px-4 py-3 text-sm text-sky-100" role="status">Info: Workspace settings were loaded from policy defaults.</div>
                <div class="rounded-lg border border-emerald-500/40 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-100" role="status">Success: Notification digest preferences updated.</div>
                <div class="rounded-lg border border-amber-500/40 bg-amber-500/10 px-4 py-3 text-sm text-amber-100" role="alert">Warning: Audit export contains redacted values.</div>
                <div class="rounded-lg border border-rose-500/40 bg-rose-500/10 px-4 py-3 text-sm text-rose-100" role="alert">Danger: Failed to persist queue escalation policy.</div>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Toast Baseline</p>
            <p class="mt-2 text-sm text-slate-400">Toasts should use a polite live region for non-critical updates and an assertive region for high-severity failures.</p>
            <div class="mt-4 flex flex-col gap-3">
                <div class="ml-auto w-full max-w-md rounded-lg border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 shadow-xl shadow-black/30" role="status" aria-live="polite">
                    <p class="font-semibold text-white">Saved</p>
                    <p class="mt-1 text-slate-400">Workspace defaults were updated.</p>
                </div>
                <div class="ml-auto w-full max-w-md rounded-lg border border-rose-500/50 bg-rose-500/10 px-4 py-3 text-sm text-rose-100 shadow-xl shadow-black/30" role="alert" aria-live="assertive">
                    <p class="font-semibold">Action Failed</p>
                    <p class="mt-1">Could not reach notification provider. Retry in 30 seconds.</p>
                </div>
            </div>
        </section>
    </section>
</x-layouts.app>
