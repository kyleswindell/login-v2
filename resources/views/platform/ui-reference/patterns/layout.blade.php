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

                <x-ui.patterns.proof-review-target
                    :items="[
                        ['id' => 'P2-B-CQ-018', 'note' => 'Use the multi-row examples below to verify that 1x2, 2x2, and 3x2 widgets read as visibly taller dashboard states in context.'],
                    ]"
                />

                <x-ui.patterns.proof-note semantic="neutral" title="Multi-row span proof">
                    Review the deterministic pairings below: `1x2` beside `2x2`, `1x2` beside stacked one-row widgets, and `3x2` directly compared with `3x1`. Each two-row widget must reserve and occupy two complete grid rows before this pattern is reused on production dashboards.
                </x-ui.patterns.proof-note>

                <x-ui.patterns.dashboard-grid columns="widgets" data-dashboard-span-proof>
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
                        title="1x2 Stack Comparison"
                        description="Second tall proof beside two independent one-row widgets."
                        kicker="Span 1x2"
                        span="1x2"
                    >
                        <div class="space-y-3">
                            <div class="ui-pattern-widget-shell-section is-subtle">Occupies row one beside the first one-row neighbor.</div>
                            <div class="ui-pattern-widget-shell-section is-subtle">Occupies row two beside the second one-row neighbor.</div>
                        </div>
                    </x-ui.patterns.widget-shell>

                    <x-ui.patterns.widget-shell
                        title="2x1 First Neighbor"
                        description="One-row widget placed beside the first half of a tall item."
                        kicker="Span 2x1"
                        span="2x1"
                    >
                        <div class="ui-pattern-widget-shell-section is-subtle">This card must not stretch just because its neighbor is `1x2`.</div>
                    </x-ui.patterns.widget-shell>

                    <x-ui.patterns.widget-shell
                        title="2x1 Second Neighbor"
                        description="Second one-row widget placed below the first neighbor."
                        kicker="Span 2x1"
                        span="2x1"
                    >
                        <div class="ui-pattern-widget-shell-section is-subtle">This card proves the second occupied row next to the same `1x2` item.</div>
                    </x-ui.patterns.widget-shell>

                    <x-ui.patterns.widget-shell
                        title="3x2 Review Surface"
                        description="Full-width two-row proof for dense dashboard states that still summarize one subject."
                        kicker="Span 3x2"
                        :meta="['Full width + two rows']"
                        span="3x2"
                    >
                        <div class="grid gap-3 md:grid-cols-3">
                            <div class="ui-pattern-widget-shell-section">
                                <p class="ui-pattern-key-value-label">Open workstreams</p>
                                <p class="ui-stat-value mt-3">6</p>
                            </div>
                            <div class="ui-pattern-widget-shell-section">
                                <p class="ui-pattern-key-value-label">Reviewer capacity</p>
                                <p class="ui-stat-value mt-3">72%</p>
                            </div>
                            <div class="ui-pattern-widget-shell-section">
                                <p class="ui-pattern-key-value-label">Oldest blocker</p>
                                <p class="ui-stat-value mt-3">41m</p>
                            </div>
                        </div>
                        <div class="grid gap-3 md:grid-cols-2">
                            <div class="ui-pattern-widget-shell-section is-subtle">Second-row space supports related detail without turning the widget into a workflow page.</div>
                            <div class="ui-pattern-widget-shell-section is-subtle">The card should visibly occupy two grid rows beside shorter dashboard summaries.</div>
                        </div>
                    </x-ui.patterns.widget-shell>

                    <x-ui.patterns.widget-shell
                        title="3x1 Full-Row Surface"
                        description="One-row full-width comparison immediately after the `3x2` surface."
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

                <div class="ui-card flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="ui-kicker">Interactive proof controls</p>
                        <h3 class="ui-card-title mt-2">Locked and unlocked states are reviewable here</h3>
                        <p class="ui-card-copy">Unlock the proof to reorder the dummy widgets, hide one into the restore tray, then lock it again to confirm the saved layout state remains visible.</p>
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

                <div class="space-y-4" data-dashboard-proof-main-content>
                        <x-ui.patterns.proof-note semantic="neutral" title="Span comparison order" data-dashboard-proof-comparison-contract>
                            Resetting the proof restores a deliberate review order: `1x1` + `2x1`, then `1x2` + `2x2`, then `3x1` followed by `3x2`. The grid size should remain span-driven after drag, hide/show, and lock/unlock interactions.
                        </x-ui.patterns.proof-note>

                        <div
                            class="dashboard-proof-grid grid gap-4"
                            x-ref="visibleGrid"
                            x-bind:data-dashboard-proof-state="editing ? 'editing' : 'locked'"
                            data-dashboard-reorder-surface
                        >
                            <template x-for="widget in visibleWidgets" :key="widget.id">
                                <article
                                    class="dashboard-proof-widget-card ui-pattern-widget-shell relative min-w-0 transition"
                                    x-bind:class="[spanClass(widget), editing ? 'ring-1 ring-emerald-400/25' : '']"
                                    x-bind:data-proof-widget-id="widget.id"
                                    x-bind:data-dashboard-proof-widget-span="widget.span"
                                    data-dashboard-proof-widget
                                    data-dashboard-proof-widget-card
                                >
                                    <div class="ui-pattern-widget-shell-header">
                                        <div class="min-w-0 flex-1 space-y-2">
                                            <p class="ui-kicker" x-text="widget.kicker"></p>
                                            <div>
                                                <h4 class="ui-card-title break-words" x-text="widget.title"></h4>
                                                <p class="ui-card-copy break-words" x-text="widget.description"></p>
                                            </div>
                                        </div>
                                        <div class="flex shrink-0 items-center gap-2" x-show="editing">
                                            <button
                                                type="button"
                                                class="dashboard-proof-drag-handle ui-icon-button h-9 w-9"
                                                title="Drag to reorder"
                                            >
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                    <path d="M7 2a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm6 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM7 8a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm6 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM7 14a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm6 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                                </svg>
                                            </button>
                                            <button
                                                type="button"
                                                class="ui-icon-button h-9 w-9"
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

                                    <div class="ui-pattern-widget-shell-body">
                                        <div class="grid min-w-0 gap-3 xl:grid-cols-2">
                                            <div class="ui-pattern-widget-shell-section min-w-0">
                                                <p class="ui-pattern-key-value-label">Header content</p>
                                                <p class="ui-card-title mt-2 break-words text-sm" x-text="widget.bodyHeading"></p>
                                            </div>

                                            <div class="ui-pattern-widget-shell-section min-w-0">
                                                <p class="ui-pattern-key-value-label">Body content</p>
                                                <p class="ui-card-copy break-words" x-text="widget.bodyCopy"></p>
                                            </div>
                                        </div>

                                        <div class="grid min-w-0 gap-3 2xl:grid-cols-[minmax(0,1fr)_minmax(7rem,9rem)]">
                                            <div class="min-w-0">
                                                <p class="ui-pattern-key-value-label" x-text="widget.supporting"></p>
                                                <p class="ui-stat-value mt-2 break-words" x-text="widget.metric"></p>
                                            </div>
                                            <div class="ui-pattern-widget-shell-section min-w-0 text-left 2xl:text-right">
                                                <p class="ui-pattern-key-value-label">Span</p>
                                                <p class="ui-card-title mt-2 text-sm" x-text="widget.span"></p>
                                                <p class="ui-card-copy break-words text-xs" x-text="spanDescriptor(widget)"></p>
                                            </div>
                                        </div>

                                        <div class="space-y-2">
                                            <template x-for="note in widget.notes" :key="note">
                                                <div class="ui-pattern-widget-shell-section is-subtle break-words text-sm" x-text="note"></div>
                                            </template>
                                        </div>
                                    </div>
                                </article>
                            </template>
                        </div>

                        <div
                            class="ui-card"
                            x-show="editing && hiddenWidgets.length > 0"
                            x-cloak
                        >
                            <p class="ui-kicker">Hidden widget tray</p>
                            <p class="ui-card-copy">Restore a hidden dummy widget back into the visible proof order without losing its stable identity.</p>
                            <div class="mt-3 flex flex-wrap gap-2">
                                <template x-for="widget in hiddenWidgets" :key="widget.id">
                                    <button
                                        type="button"
                                        class="ui-action ui-action-ghost !border-0 !shadow-none !px-[calc(0.875rem+1px)] !py-[calc(0.5rem+1px)]"
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

                    <div class="grid gap-4 xl:grid-cols-3" data-dashboard-proof-support>
                        <div class="ui-card">
                            <p class="ui-kicker">Proof state</p>
                            <h3 class="ui-card-title mt-3" x-text="editing ? 'Unlocked review state' : 'Locked review state'"></h3>
                            <p class="ui-card-copy" x-text="editing ? 'Drag handles and hide controls are available so the review can confirm behavior directly.' : 'The proof reads as a quiet dashboard surface until customization is intentionally enabled.'"></p>
                        </div>

                        <div class="ui-card" data-dashboard-proof-saved-layout-card>
                            <p class="ui-kicker">Saved layout preview</p>
                            <p class="ui-card-copy">
                                This browser-local snapshot stands in for the live per-user persistence contract and makes the current widget order and visibility state directly inspectable during review.
                                <a href="{{ route('dashboard') }}" class="font-semibold underline-offset-4 hover:underline">Compare the live dashboard consumer</a>.
                            </p>
                            <pre class="ui-pattern-widget-shell-section mt-4 overflow-x-auto text-xs" data-dashboard-proof-saved-layout x-text="savedLayoutPreview()"></pre>
                            <x-ui.button href="#dashboard-customization-proof" variant="ghost" class="mt-4">Review saved snapshot</x-ui.button>
                        </div>

                        <div class="ui-card">
                            <p class="ui-kicker">Review cues</p>
                            <ul class="ui-card-copy space-y-2">
                                <li>1. Unlock the proof and drag at least one widget.</li>
                                <li>2. Watch the insertion line and swap target before dropping.</li>
                                <li>3. Hide a widget, confirm it moves into the restore tray, then restore it.</li>
                                <li>4. Lock the proof again and verify the visible order remains intact.</li>
                            </ul>
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
