@php
    $supportRunbookLink = new \Illuminate\Support\HtmlString(
        '<a href="#" class="ui-link" onclick="event.preventDefault()">Open documentation</a>'
    );
@endphp

<x-layouts.app title="UI Reference · Data And Content Patterns">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.data-content'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <x-ui.patterns.page-title-actions-row
            title="Data And Content Patterns"
            description="Reusable Tier 2 patterns for summaries, read-only displays, empty states, and list rows."
            kicker="Tier 2B"
        />

        <x-ui.patterns.proof-review-banner
            :items="[
                ['id' => 'P2-B-CQ-003', 'note' => 'Proof-only guidance on this page should use the shared notice treatment instead of blending into the component cards.'],
                ['id' => 'P2-B-CQ-014', 'note' => 'The grouped dropdown on this page should validate the shared action/menu-item colorway suite instead of local text-color exceptions.'],
                ['id' => 'P2-B-CQ-011', 'note' => 'The shared dropdown action menu still needs targeted review where it appears inside a content-section card.'],
            ]"
            :focus="[
                'Passed items should drop out of the active review overlay once review is complete.',
                'Only the current pending-review proof surfaces on this page should carry queue-ID targeting.',
            ]"
        />

        <x-ui.patterns.proof-note semantic="notice" title="How to read this proof">
            These examples show the expected content shape for read-only summaries and fallback states. Values should render as plain text by default, with trusted linked content called out intentionally instead of leaking raw markup into the page.
        </x-ui.patterns.proof-note>

        <section class="ui-card" data-ui-guidance="structured-list-tile-usage" data-guidance-id="P2-F-CQ-011">
            <p class="ui-kicker">Structured List And Tile Guidance</p>
            <div class="mt-3 grid gap-4 lg:grid-cols-2">
                <dl class="space-y-3 text-sm ui-reference-text">
                    <div>
                        <dt class="font-semibold ui-reference-text-strong">G-STRLIST-01 - Structured list vs data table</dt>
                        <dd class="mt-1">Use structured lists for compact comparison of a few attributes; use data tables when users sort, filter, scan many rows, or need column alignment.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold ui-reference-text-strong">G-STRLIST-02 - Selectable structured list vs radio group</dt>
                        <dd class="mt-1">Use selectable structured lists when each option needs rich metadata; use radio groups for short exclusive choices with simple labels.</dd>
                    </div>
                </dl>

                <dl class="space-y-3 text-sm ui-reference-text">
                    <div>
                        <dt class="font-semibold ui-reference-text-strong">G-TILE-01 - Tile variants</dt>
                        <dd class="mt-1">Use base tiles for static summaries, clickable tiles for navigation, selectable tiles for choice sets, and expandable tiles only when details must stay in context.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold ui-reference-text-strong">G-TILE-02 - Tile vs card</dt>
                        <dd class="mt-1">Use tiles for compact selectable or navigational units; use cards for richer content blocks with headings, metadata, actions, or composed components.</dd>
                    </div>
                </dl>
            </div>
        </section>

        <section class="ui-card" data-ui-reference-example="structured-list-tile-contract" data-guidance-id="P2-F-CQ-011">
            <p class="ui-kicker">Concrete Structured List And Tile Examples</p>
            <div class="mt-5 grid gap-5 xl:grid-cols-2">
                <article class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Structured list for compact comparison</p>
                    <dl class="mt-3 ui-reference-table-body ui-reference-subtle-surface text-sm">
                        <div class="grid gap-2 px-3 py-3 sm:grid-cols-3"><dt class="ui-reference-text-muted">Owner</dt><dd class="ui-reference-text-strong sm:col-span-2">Platform Team</dd></div>
                        <div class="grid gap-2 px-3 py-3 sm:grid-cols-3"><dt class="ui-reference-text-muted">Timezone</dt><dd class="ui-reference-text-strong sm:col-span-2">America/New_York</dd></div>
                        <div class="grid gap-2 px-3 py-3 sm:grid-cols-3"><dt class="ui-reference-text-muted">Status</dt><dd class="sm:col-span-2"><x-ui.badge label="active" semantic="success" /></dd></div>
                    </dl>
                </article>

                <article class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Selectable structured list</p>
                    <fieldset class="mt-3 space-y-3">
                        <legend class="sr-only">Choose support route</legend>
                        <label class="ui-selectable-option is-selected flex items-start gap-3 text-sm ui-reference-text-strong">
                            <input type="radio" checked name="support-route" class="mt-1 h-4 w-4 ui-platform-checkbox" />
                            <span><span class="block font-semibold ui-reference-text-strong">Platform escalation</span><span class="block text-xs ui-reference-text-muted">24-hour review with audit context.</span></span>
                        </label>
                        <label class="ui-selectable-option flex items-start gap-3 text-sm ui-reference-text-strong">
                            <input type="radio" name="support-route" class="mt-1 h-4 w-4 ui-platform-checkbox" />
                            <span><span class="block font-semibold ui-reference-text-strong">Security escalation</span><span class="block text-xs ui-reference-text-muted">Immediate review for blocked authentication.</span></span>
                        </label>
                    </fieldset>
                </article>

                <article class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Tile variants</p>
                    <div class="mt-3 grid gap-3 sm:grid-cols-2">
                        <div class="ui-reference-subtle-surface p-3"><p class="font-semibold ui-reference-text-strong">Base tile</p><p class="text-xs ui-reference-text-muted">Static summary.</p></div>
                        <a href="#" onclick="event.preventDefault()" class="ui-reference-interactive-surface p-3"><p class="font-semibold ui-reference-text-strong">Clickable tile</p><p class="text-xs ui-reference-text-muted">Navigation target.</p></a>
                        <label class="ui-selectable-option flex items-start gap-3 text-sm ui-reference-text-strong">
                            <input type="checkbox" checked class="mt-1 h-4 w-4 rounded ui-platform-checkbox" />
                            <span><span class="block font-semibold ui-reference-text-strong">Selectable tile</span><span class="block text-xs ui-reference-text-muted">Choice set with metadata.</span></span>
                        </label>
                        <details class="ui-reference-subtle-surface p-3 text-sm ui-reference-text">
                            <summary class="cursor-pointer font-semibold ui-reference-text-strong">Expandable tile</summary>
                            <p class="mt-2 text-xs ui-reference-text-muted">Use only when details must stay in context.</p>
                        </details>
                    </div>
                </article>

                <article class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Queued component gaps</p>
                    <p class="mt-3 text-sm ui-reference-text">No dedicated structured-list or tile Blade component exists yet. Use these examples as the reference contract and queue a component extraction only after multiple consumers need the same anatomy.</p>
                </article>
            </div>
        </section>

        <section class="ui-card" data-ui-implementation-guide="structured-list-tile" data-guidance-id="P2-F-CQ-011">
            <p class="ui-kicker">Data Content Implementation Guide</p>
            <p class="ui-card-copy mt-2">Owner route: <code>/platform/ui-reference/patterns/data-content</code>. Use <code>x-ui.patterns.key-value-display</code>, <code>x-ui.patterns.data-list-item</code>, <code>x-ui.patterns.identity-summary-card</code>, and local structured-list/tile markup until dedicated components are introduced. Use data tables instead when sorting, filtering, or column alignment is the core task.</p>
        </section>

        <x-ui.patterns.content-section-block
            title="Stat Cards"
            description="Use stat cards for small metric summaries with optional trend or support copy."
            kicker="Metric summary"
        >
            <x-ui.patterns.dashboard-grid columns="3">
                <x-ui.patterns.stat-card
                    label="Pending reviews"
                    value="14"
                    supporting-text="Across active implementation batches."
                    trend-label="+3 today"
                    trend-semantic="success"
                    icon="heroicon-o-clipboard-document-check"
                />
                <x-ui.patterns.stat-card
                    label="Settings surfaces"
                    value="6"
                    supporting-text="Currently aligned to the shared shell family."
                    trend-label="stable"
                    trend-semantic="notice"
                    icon="heroicon-o-cog-6-tooth"
                />
                <x-ui.patterns.stat-card
                    label="Open follow-ups"
                    value="2"
                    supporting-text="Scoped to later customer/public planning."
                    trend-label="deferred"
                    trend-semantic="warning"
                    icon="heroicon-o-flag"
                />
            </x-ui.patterns.dashboard-grid>
        </x-ui.patterns.content-section-block>

        <div class="grid gap-6 xl:grid-cols-2">
            <x-ui.patterns.content-section-block
                title="Identity Summary Card"
                description="Use identity summary cards when the surface needs avatar, name, status, and supporting metadata before deeper read-only detail."
                kicker="Identity summary"
            >
                <div class="space-y-4">
                    <x-ui.patterns.proof-review-target
                        :items="[
                            ['id' => 'P2-B-CQ-003', 'note' => 'This proof-note block remains under review for consistent library-guidance treatment on the card itself. The identity-summary density and metadata items have already passed and should not remain tagged as active review targets.'],
                        ]"
                    />

                    <x-ui.patterns.proof-note semantic="notice" title="Identity-summary variants">
                        Use the same identity-summary family for compact, standard, and detailed read-only summaries. Promote a separate company/entity component only if the required anatomy diverges beyond mark/avatar, name, metadata, status, and optional actions.
                    </x-ui.patterns.proof-note>

                    <x-ui.patterns.identity-summary-card
                        variant="compact"
                        name="Alex Operator"
                        subtitle="Platform super administrator"
                        initials="AO"
                        :meta="[
                            'alex.operator@parasolutions.com',
                            'Platform team',
                            'America/New_York',
                        ]"
                        status-label="Verified"
                        status-semantic="success"
                    />

                    <x-ui.patterns.identity-summary-card
                        name="Para Solutions"
                        subtitle="Primary internal company profile"
                        initials="PS"
                        :meta="[
                            'Company identity',
                            'Workspace owner',
                            'Updated May 31',
                        ]"
                        status-label="Active"
                        status-semantic="notice"
                    >
                        <x-slot:actions>
                            <x-ui.button variant="outline" size="sm">Open record</x-ui.button>
                        </x-slot:actions>
                    </x-ui.patterns.identity-summary-card>

                    <x-ui.patterns.identity-summary-card
                        variant="detailed"
                        name="Alex Operator"
                        subtitle="Platform super administrator"
                        initials="AO"
                        :meta="[
                            'alex.operator@parasolutions.com',
                            'Platform team',
                            'America/New_York',
                        ]"
                        status-label="Verified"
                        status-semantic="success"
                    >
                        <x-slot:actions>
                            <x-ui.button variant="outline" size="sm">Message</x-ui.button>
                            <x-ui.button semantic="primary" size="sm">Open profile</x-ui.button>
                        </x-slot:actions>

                        <x-ui.patterns.key-value-display
                            :items="[
                                ['label' => 'Default locale', 'value' => 'English (United States)'],
                                ['label' => 'Last sign-in', 'value' => 'Today at 8:41 AM'],
                            ]"
                        />
                    </x-ui.patterns.identity-summary-card>
                </div>
            </x-ui.patterns.content-section-block>

            <x-ui.patterns.content-section-block
                title="Key Value Display"
                description="Use read-only label/value pairs for account and configuration summaries."
                kicker="Read-only detail"
            >
                <x-ui.patterns.key-value-display
                    :items="[
                        ['label' => 'Owner', 'value' => 'Platform Administrator'],
                        ['label' => 'Timezone', 'value' => 'America/New_York'],
                        ['label' => 'Theme', 'value' => 'System'],
                        ['label' => 'Support Runbook', 'value' => $supportRunbookLink],
                    ]"
                />
            </x-ui.patterns.content-section-block>

        </div>

        <x-ui.patterns.content-section-block
            title="Empty State"
            description="Use a strong no-data treatment with one clear next action."
            kicker="Fallback state"
        >
            <x-ui.patterns.empty-state
                title="No review tasks assigned"
                description="This workspace has no active review tasks yet. Start by assigning the next proof surface."
                icon="heroicon-o-inbox-stack"
            >
                <x-slot:actions>
                    <x-ui.button semantic="primary">Assign Review</x-ui.button>
                    <x-ui.button variant="ghost">View Queue</x-ui.button>
                </x-slot:actions>
            </x-ui.patterns.empty-state>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Data List Item"
            description="List rows should provide a title, compact metadata, and optional trailing actions without turning into custom card designs."
            kicker="List row"
        >
            <div class="space-y-3">
                <x-ui.patterns.proof-review-target
                    :items="[
                        ['id' => 'P2-B-CQ-014', 'note' => 'Review the shared menu-item colorways here inside a content-section-backed list row, including the shared current-item state, so grouped actions do not rely on one-off link overrides.'],
                        ['id' => 'P2-B-CQ-011', 'note' => 'Review the shared dropdown menu here inside a content-section-backed list row so clipping and layering are judged where the pattern actually renders under card chrome.'],
                    ]"
                />

                <x-ui.patterns.data-list-item
                    title="General Settings Ownership"
                    description="Shared setup and settings registration fields are locked to the internal shell contract."
                    :meta="['Settings shell', 'Updated May 31', 'Owned by platform team']"
                >
                    <x-slot:actions>
                        <x-ui.patterns.dropdown-action-menu label="Open">
                            <x-ui.menu-item href="#" current onclick="event.preventDefault()">View contract</x-ui.menu-item>
                            <x-ui.menu-item href="#" semantic="notice" onclick="event.preventDefault()">Review proof surface</x-ui.menu-item>
                            <div class="ui-pattern-dropdown-divider"></div>
                            <x-ui.menu-item href="#" semantic="danger" onclick="event.preventDefault()">Archive draft</x-ui.menu-item>
                        </x-ui.patterns.dropdown-action-menu>
                    </x-slot:actions>
                </x-ui.patterns.data-list-item>

                <x-ui.patterns.data-list-item
                    title="Dashboard Widget Shell"
                    description="Widget framing stays reusable while the metric content remains module-specific."
                    :meta="['Dashboard shell', 'Stat card proof', 'Responsive validated']"
                />
            </div>
        </x-ui.patterns.content-section-block>
    </section>
</x-layouts.app>
