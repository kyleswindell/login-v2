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
                <x-ui.button variant="outline">Open dashboard proof</x-ui.button>
                <x-ui.button semantic="primary">Review responsive states</x-ui.button>
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
            description="Use this section to review the live dashboard customization contract before judging the worker-facing `/dashboard` surface."
            kicker="Customization states"
        >
            <div class="space-y-4">
                <x-ui.inline-alert semantic="notice" title="Saved per-user layout">
                    The dashboard saves customization per signed-in user. The durable saved state should be keyed by stable widget identity and validated placement metadata, not by page-local placeholder slots that can drift when widget definitions evolve.
                </x-ui.inline-alert>

                <div class="grid gap-4 xl:grid-cols-3">
                    <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Locked state</p>
                        <h3 class="mt-3 text-lg font-semibold text-white">Review-ready default view</h3>
                        <p class="mt-2 text-sm text-slate-300">Widget chrome stays quiet until the operator chooses to customize, so the dashboard still reads like an operational summary instead of an editor.</p>
                    </div>
                    <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-emerald-200/80">Unlocked state</p>
                        <h3 class="mt-3 text-lg font-semibold text-white">Drag, toggle, then lock</h3>
                        <p class="mt-2 text-sm text-slate-200">Visible widgets show drag handles, hidden widgets move into a restore tray, and locking the page preserves the personalized order for that user account.</p>
                    </div>
                    <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Persistence contract</p>
                        <h3 class="mt-3 text-lg font-semibold text-white">Stable widget identity first</h3>
                        <p class="mt-2 text-sm text-slate-300">Save `widget_key` plus validated placement metadata such as order, span, and visibility. If a widget disappears, changes permission, or regains a default, the next load should reconcile safely instead of trusting stale slot coordinates blindly.</p>
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
