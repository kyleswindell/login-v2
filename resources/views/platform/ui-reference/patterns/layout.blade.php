<x-layouts.app title="UI Reference · Layout And Dashboard Patterns">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.layout'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <x-ui.patterns.page-title-actions-row
            title="Layout And Dashboard Patterns"
            description="Tier 2 layout proof for content sections, dashboard grids, and shared internal page framing."
            kicker="Tier 2G"
        >
            <x-slot:actions>
                <x-ui.button href="#dashboard-customization-proof" variant="outline">Open dashboard proof</x-ui.button>
                <x-ui.button :href="route('dashboard')" semantic="primary">Compare live dashboard</x-ui.button>
            </x-slot:actions>
        </x-ui.patterns.page-title-actions-row>

        <x-ui.patterns.proof-review-banner
            :items="[
                ['id' => 'P2-B-CQ-006', 'note' => 'Widget-shell anatomy and density remain in pending review on the dashboard/layout proof surfaces.'],
            ]"
            :focus="[
                'The current active review target on this page is the widget-shell contract, not the reopened row-span bug tracked separately on P2-B-CQ-005.',
            ]"
        />

        <x-ui.patterns.content-section-block
            title="Dashboard Grid"
            description="The grid defines card spacing and repeatable placement rules only; feature widgets provide the content."
            kicker="Layout baseline"
        >
            <div class="space-y-4">
                <x-ui.patterns.proof-review-target
                    :items="[
                        ['id' => 'P2-B-CQ-006', 'note' => 'Use this card to review the reusable widget-shell contract: allowed regions, density, and how the widget body stays one dashboard topic even when internal sections are present.'],
                    ]"
                />

                <x-ui.inline-alert semantic="notice" title="Widget sizing contract">
                    The shared dashboard grid now uses an explicit span model. `1x1`, `2x1`, `1x2`, `2x2`, `3x1`, and `3x2` are all valid proof sizes when the content density stays intentional and the widget still reads as one dashboard summary surface.
                </x-ui.inline-alert>

                <x-ui.patterns.dashboard-grid columns="widgets">
                    <x-ui.patterns.widget-shell
                        title="1x1 Summary"
                        description="Single-focus metric or quick status."
                        kicker="Span 1x1"
                        span="1x1"
                    >
                        <x-ui.patterns.stat-card label="Active queues" value="4" supporting-text="Compact summary-only widget." icon="heroicon-o-queue-list" />
                    </x-ui.patterns.widget-shell>

                    <x-ui.patterns.widget-shell
                        title="2x1 Wide Summary"
                        description="Two related signals in one wider row."
                        kicker="Span 2x1"
                        span="2x1"
                    >
                        <div class="grid gap-3 md:grid-cols-2">
                            <div class="ui-pattern-widget-shell-section">
                                <p class="ui-pattern-key-value-label">Open reviews</p>
                                <p class="ui-stat-value mt-3">12</p>
                            </div>
                            <div class="ui-pattern-widget-shell-section">
                                <p class="ui-pattern-key-value-label">Needs escalation</p>
                                <p class="ui-stat-value mt-3">2</p>
                            </div>
                        </div>
                    </x-ui.patterns.widget-shell>

                    <x-ui.patterns.widget-shell
                        title="1x2 Tall List"
                        description="Vertical room for ordered activity or queue items."
                        kicker="Span 1x2"
                        span="1x2"
                    >
                        <div class="space-y-3">
                            <div class="ui-pattern-widget-shell-section is-subtle">Assign reviewer to Settings proof surface</div>
                            <div class="ui-pattern-widget-shell-section is-subtle">Confirm dashboard widget spacing on mobile</div>
                            <div class="ui-pattern-widget-shell-section is-subtle">Lock Batch B follow-up routes</div>
                        </div>
                    </x-ui.patterns.widget-shell>

                    <x-ui.patterns.widget-shell
                        title="2x2 Mixed Widget"
                        description="Header, summary, and a second internal content block can coexist when the widget still reads as one topic."
                        kicker="Span 2x2"
                        :meta="['Summary + detail']"
                        span="2x2"
                    >
                        <div class="grid gap-3 md:grid-cols-2">
                            <div class="ui-pattern-widget-shell-section">
                                <p class="ui-pattern-key-value-label">Unread notifications</p>
                                <p class="ui-stat-value mt-3">7</p>
                            </div>
                            <div class="ui-pattern-widget-shell-section">
                                <p class="ui-pattern-key-value-label">Oldest item</p>
                                <p class="ui-stat-value mt-3">18m</p>
                            </div>
                        </div>
                        <div class="ui-pattern-widget-shell-section">
                            <p class="ui-control-copy">Use a second internal block only when it deepens the same dashboard subject instead of mixing unrelated content into one card.</p>
                        </div>
                    </x-ui.patterns.widget-shell>

                    <x-ui.patterns.widget-shell
                        title="3x1 Full-Row Surface"
                        description="Wider widgets are valid when they summarize one dashboard concern that naturally spans the whole row."
                        kicker="Span 3x1"
                        span="3x1"
                    >
                        <div class="grid gap-3 md:grid-cols-3">
                            <div class="ui-pattern-widget-shell-section is-subtle">Header actions stay widget-local.</div>
                            <div class="ui-pattern-widget-shell-section is-subtle">Internal sections may be divided once or twice.</div>
                            <div class="ui-pattern-widget-shell-section is-subtle">If the widget becomes a full workflow, escalate to a real page.</div>
                        </div>
                    </x-ui.patterns.widget-shell>
                </x-ui.patterns.dashboard-grid>

                <div class="grid gap-3 md:grid-cols-3 text-sm text-slate-300">
                    <p><span class="font-semibold text-slate-100">Allowed regions:</span> header, title, optional description/meta, primary body, optional footer, and at most a small number of internal sections.</p>
                    <p><span class="font-semibold text-slate-100">Density rule:</span> widgets may mix summary and detail only when the blocks still belong to one dashboard topic and can be scanned quickly.</p>
                    <p><span class="font-semibold text-slate-100">Escalation rule:</span> if the content starts requiring multiple workflows, deep forms, or complex drill-down controls, link out to a full page instead of growing the widget further.</p>
                </div>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Dashboard customization proof"
            description="Use this UI Reference-first proof to review lock/unlock, reorder, hide/show, and saved-layout behavior on dummy widgets before judging the live dashboard consumer."
            kicker="Customization states"
            id="dashboard-customization-proof"
        >
            <div
                class="space-y-4"
                x-data="dashboardProofDemo()"
                x-init="init()"
                data-dashboard-proof-demo
            >
                <x-ui.inline-alert semantic="notice" title="Saved per-user layout">
                    This proof uses dummy widgets and browser-local saved state so reviewers can exercise the interaction model directly on UI Reference first. The live dashboard should mirror the same lock/unlock, reorder, hide/show, and stable widget-identity layout rules after the proof is approved.
                </x-ui.inline-alert>

                <div class="flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-slate-800 bg-slate-950/70 p-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Interactive proof controls</p>
                        <h3 class="mt-2 text-lg font-semibold text-white">Locked and unlocked states are reviewable here</h3>
                        <p class="mt-2 text-sm text-slate-300">Unlock the proof to reorder the dummy widgets, hide one into the restore tray, then lock it again to confirm the saved layout state remains visible.</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <x-ui.button
                            x-on:click="reset()"
                            variant="ghost"
                            x-bind:disabled="!editing && hiddenWidgets.length === 0"
                        >
                            Reset proof
                        </x-ui.button>
                        <x-ui.button x-show="!editing" x-on:click="toggleEditing()" variant="outline">Customize proof</x-ui.button>
                        <x-ui.button x-show="editing" x-on:click="toggleEditing()" semantic="success">Lock proof</x-ui.button>
                    </div>
                </div>

                <div class="grid gap-4 xl:grid-cols-[1.65fr_minmax(0,1fr)]">
                    <div class="space-y-4">
                        <div
                            class="grid gap-4 xl:grid-cols-12 xl:auto-rows-[minmax(11rem,auto)]"
                            x-ref="visibleGrid"
                            x-bind:data-dashboard-proof-state="editing ? 'editing' : 'locked'"
                        >
                            <template x-for="widget in visibleWidgets" :key="widget.id">
                                <article
                                    class="col-span-12 rounded-2xl border p-4 shadow-sm transition"
                                    x-bind:class="[spanClass(widget), cardClass(widget), editing ? 'ring-1 ring-emerald-400/25' : '']"
                                    x-bind:data-proof-widget-id="widget.id"
                                    data-dashboard-proof-widget
                                >
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="space-y-2">
                                            <p class="text-[0.68rem] font-semibold uppercase tracking-[0.28em] text-slate-400" x-text="widget.kicker"></p>
                                            <div>
                                                <h4 class="text-lg font-semibold text-white" x-text="widget.title"></h4>
                                                <p class="mt-1 text-sm text-slate-300" x-text="widget.description"></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2" x-show="editing">
                                            <button
                                                type="button"
                                                class="dashboard-proof-drag-handle inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-700 bg-slate-900/80 text-slate-300 transition hover:border-slate-500 hover:text-white"
                                                title="Drag to reorder"
                                            >
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                    <path d="M7 2a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm6 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM7 8a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm6 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM7 14a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm6 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                                </svg>
                                            </button>
                                            <button
                                                type="button"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-700 bg-slate-900/80 text-slate-300 transition hover:border-slate-500 hover:text-white"
                                                x-on:click="hideWidget(widget.id)"
                                                title="Hide widget"
                                            >
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mt-4 grid gap-3 md:grid-cols-[minmax(0,1fr)_auto]">
                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400" x-text="widget.supporting"></p>
                                            <p class="mt-2 text-4xl font-semibold text-white" x-text="widget.metric"></p>
                                        </div>
                                        <div class="rounded-xl border border-white/10 bg-black/10 px-3 py-2 text-right">
                                            <p class="text-[0.68rem] font-semibold uppercase tracking-[0.24em] text-slate-400">Span</p>
                                            <p class="mt-2 text-sm font-medium text-slate-100" x-text="widget.span"></p>
                                            <p class="mt-1 text-xs text-slate-400" x-text="spanDescriptor(widget)"></p>
                                        </div>
                                    </div>

                                    <div class="mt-4 space-y-2">
                                        <template x-for="note in widget.notes" :key="note">
                                            <div class="rounded-xl border border-white/10 bg-black/10 px-3 py-2 text-sm text-slate-200" x-text="note"></div>
                                        </template>
                                    </div>
                                </article>
                            </template>
                        </div>

                        <div
                            class="rounded-2xl border border-slate-800 bg-slate-950/70 p-4"
                            x-show="editing && hiddenWidgets.length > 0"
                            x-cloak
                        >
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Hidden widget tray</p>
                            <p class="mt-2 text-sm text-slate-300">Restore a hidden dummy widget back into the visible proof order without losing its stable identity.</p>
                            <div class="mt-3 flex flex-wrap gap-2">
                                <template x-for="widget in hiddenWidgets" :key="widget.id">
                                    <button
                                        type="button"
                                        class="inline-flex items-center gap-2 rounded-xl border border-slate-700 bg-slate-900/80 px-3 py-2 text-sm font-medium text-slate-100 transition hover:border-slate-500"
                                        x-on:click="showWidget(widget.id)"
                                    >
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span x-text="widget.title"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Proof state</p>
                            <h3 class="mt-3 text-lg font-semibold text-white" x-text="editing ? 'Unlocked review state' : 'Locked review state'"></h3>
                            <p class="mt-2 text-sm text-slate-300" x-text="editing ? 'Drag handles and hide controls are available so the review can confirm behavior directly.' : 'The proof reads as a quiet dashboard surface until customization is intentionally enabled.'"></p>
                        </div>

                        <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/10 p-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-emerald-200/80">Saved layout preview</p>
                            <p class="mt-3 text-sm text-slate-200">This browser-local snapshot stands in for the live per-user persistence contract and makes the current widget order and visibility state directly inspectable during review.</p>
                            <pre class="mt-4 overflow-x-auto rounded-xl border border-white/10 bg-slate-950/80 p-3 text-xs text-slate-200" data-dashboard-proof-saved-layout x-text="savedLayoutPreview()"></pre>
                        </div>

                        <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Review cues</p>
                            <ul class="mt-3 space-y-2 text-sm text-slate-300">
                                <li>1. Unlock the proof and drag at least one widget.</li>
                                <li>2. Hide a widget, confirm it moves into the restore tray, then restore it.</li>
                                <li>3. Lock the proof again and verify the visible order remains intact.</li>
                                <li>4. Compare the resulting state to the live `/dashboard` consumer after the proof is accepted.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </x-ui.patterns.content-section-block>

        <div class="grid gap-6 xl:grid-cols-[1.45fr_minmax(0,1fr)]">
            <x-ui.patterns.content-section-block
                title="Content Section Block"
                description="Section blocks own title, support copy, and action placement while internal content stays flexible."
                kicker="Reusable content frame"
            >
                <div class="space-y-4">
                    <p class="text-sm text-slate-300">Use section blocks to group related data, proof summaries, or form scaffolding without reintroducing feature-specific card chrome.</p>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4 text-sm text-slate-300">
                        Nested content remains free to use other Tier 2 patterns such as lists, validation summaries, or key/value displays.
                    </div>
                </div>
            </x-ui.patterns.content-section-block>

            <x-ui.patterns.content-section-block
                title="Shell Family Notes"
                description="The dashboard, settings, setup, and account surfaces share the same page-header plus section-block scaffolding."
                kicker="Internal shell family"
            >
                <ul class="space-y-2 text-sm text-slate-300">
                    <li>1. Page title/action row stays outside the first section block.</li>
                    <li>2. Section blocks own internal grouping, not page-level navigation.</li>
                    <li>3. Dashboard grids host stat cards and widget shells without changing shell framing.</li>
                    <li>4. Responsive stacking must preserve section order before introducing custom breakpoint hacks.</li>
                </ul>
            </x-ui.patterns.content-section-block>
        </div>
    </section>
</x-layouts.app>
