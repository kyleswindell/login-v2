<x-layouts.app title="UI Reference · Layout And Dashboard Patterns">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.layout'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <x-ui.patterns.page-title-actions-row
            title="Layout And Dashboard Patterns"
            description="Dashboard configuration, layout behavior, customization state, and saved-layout proof for shared internal dashboard surfaces."
            kicker="Tier 2G"
        >
            <x-slot:actions>
                <x-ui.button :href="route('platform.ui-reference.patterns.widget-content')" variant="outline">Open widget standards</x-ui.button>
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

        <x-ui.patterns.content-section-block
            title="Dashboard support boundaries"
            description="Keep this page focused on dashboard configuration and state behavior. Widget-specific content density standards now live on the standalone Widget Content page."
            kicker="Dashboard configuration"
            data-dashboard-support-boundaries
        >
            <div class="grid gap-4 lg:grid-cols-3">
                <div class="ui-card">
                    <p class="ui-kicker">Layout behavior</p>
                    <h3 class="ui-card-title mt-3">Grid placement is span-driven</h3>
                    <p class="ui-card-copy">The dashboard proof should validate lock/unlock, reorder, hide/show, and declared span placement. Widget content density is reviewed separately.</p>
                </div>
                <div class="ui-card">
                    <p class="ui-kicker">Saved state</p>
                    <h3 class="ui-card-title mt-3">Persistence uses stable identity</h3>
                    <p class="ui-card-copy">Saved layout review should focus on visible order, hidden widgets, and restored widget identity rather than changing widget-specific designs.</p>
                </div>
                <div class="ui-card">
                    <p class="ui-kicker">Widget standards</p>
                    <h3 class="ui-card-title mt-3">Content allowances moved</h3>
                    <p class="ui-card-copy">
                        Review size-aware widget content rules on
                        <a href="{{ route('platform.ui-reference.patterns.widget-content') }}" class="font-semibold underline-offset-4 hover:underline">Widget Content Standards</a>.
                    </p>
                </div>
            </div>
        </x-ui.patterns.content-section-block>
    </section>
</x-layouts.app>
