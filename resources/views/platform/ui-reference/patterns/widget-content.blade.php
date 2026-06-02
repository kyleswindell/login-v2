<x-layouts.app title="UI Reference · Widget Content Standards">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.widget-content'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <x-ui.patterns.page-title-actions-row
            title="Widget Content Standards"
            description="Size-aware content allowance proof for reusable dashboard widgets. These examples define baseline density by width and height without pretending to enumerate every future widget type."
            kicker="Dashboard widgets"
        >
            <x-slot:actions>
                <x-ui.button :href="route('platform.ui-reference.patterns.layout')" variant="outline">Back to dashboard demo</x-ui.button>
                <x-ui.button :href="route('dashboard')" semantic="primary">Compare live dashboard</x-ui.button>
            </x-slot:actions>
        </x-ui.patterns.page-title-actions-row>

        <x-ui.patterns.proof-review-banner
            :items="[
                ['id' => 'P2-B-CQ-021', 'note' => 'Review the standalone size-aware widget content allowance standard.'],
            ]"
            :focus="[
                'Confirm each supported widget size has an explicit baseline for what amount of header, body, metric, list, and footer content can fit before future modules design against it.',
            ]"
        />

        <x-ui.patterns.content-section-block
            title="Content allowance rules"
            description="Use these rules before selecting a widget span. The span should be chosen because the content fits that surface, not because the card can be stretched until it fits."
            kicker="Baseline contract"
        >
            <div class="grid gap-4 lg:grid-cols-3">
                <div class="ui-card">
                    <p class="ui-kicker">Regions</p>
                    <h3 class="ui-card-title mt-3">Allowed widget regions</h3>
                    <p class="ui-card-copy">A reusable widget may contain a header/title area, optional description/meta, one primary body, optional same-topic detail blocks, and an optional footer action or status row.</p>
                </div>
                <div class="ui-card">
                    <p class="ui-kicker">Density</p>
                    <h3 class="ui-card-title mt-3">Size controls content volume</h3>
                    <p class="ui-card-copy">Small spans must stay summary-first. Two-row or full-row spans may include related detail, but the widget must still scan as one dashboard topic.</p>
                </div>
                <div class="ui-card">
                    <p class="ui-kicker">Escalation</p>
                    <h3 class="ui-card-title mt-3">Use a page for workflows</h3>
                    <p class="ui-card-copy">If the content needs forms, tabs, complex filters, multi-step actions, or unrelated subjects, the widget should link to a dedicated page instead of expanding.</p>
                </div>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Supported widget sizes"
            description="Each example intentionally uses neutral dashboard styling. Semantic colors remain reserved for alerts, notices, status, or other meaning-bearing states."
            kicker="Size allowances"
            data-widget-content-standards
        >
            <x-ui.patterns.dashboard-grid columns="widgets" data-widget-content-size-grid>
                <x-ui.patterns.widget-shell
                    title="1x1 Summary"
                    description="One primary signal with brief context."
                    kicker="Allowance 1x1"
                    span="1x1"
                    data-widget-content-size="1x1"
                >
                    <div class="ui-pattern-widget-shell-section">
                        <p class="ui-pattern-key-value-label">Allowed content</p>
                        <p class="ui-stat-value mt-3">1 metric</p>
                    </div>
                    <p class="ui-card-copy">Use for one title, one value, and one short support line. Avoid lists, multiple metrics, or dense body copy.</p>
                </x-ui.patterns.widget-shell>

                <x-ui.patterns.widget-shell
                    title="2x1 Wide Summary"
                    description="Two related summary signals across one row."
                    kicker="Allowance 2x1"
                    span="2x1"
                    data-widget-content-size="2x1"
                >
                    <div class="grid gap-3 md:grid-cols-2">
                        <div class="ui-pattern-widget-shell-section">
                            <p class="ui-pattern-key-value-label">Primary</p>
                            <p class="ui-stat-value mt-3">12</p>
                        </div>
                        <div class="ui-pattern-widget-shell-section">
                            <p class="ui-pattern-key-value-label">Secondary</p>
                            <p class="ui-stat-value mt-3">2</p>
                        </div>
                    </div>
                    <p class="ui-card-copy">Use for two compact signals or one signal plus a short same-topic explanation.</p>
                </x-ui.patterns.widget-shell>

                <x-ui.patterns.widget-shell
                    title="1x2 Tall List"
                    description="Vertical room for ordered same-topic items."
                    kicker="Allowance 1x2"
                    span="1x2"
                    data-widget-content-size="1x2"
                >
                    <div class="space-y-3">
                        <div class="ui-pattern-widget-shell-section is-subtle">One compact list item with one sentence max.</div>
                        <div class="ui-pattern-widget-shell-section is-subtle">Second compact list item.</div>
                        <div class="ui-pattern-widget-shell-section is-subtle">Third compact list item.</div>
                    </div>
                    <p class="ui-card-copy">Use for short ordered lists or activity feeds. Avoid side-by-side content because the width is intentionally narrow.</p>
                </x-ui.patterns.widget-shell>

                <x-ui.patterns.widget-shell
                    title="2x2 Detail"
                    description="Mixed summary and detail for one dashboard topic."
                    kicker="Allowance 2x2"
                    span="2x2"
                    data-widget-content-size="2x2"
                >
                    <div class="grid gap-3 md:grid-cols-2">
                        <div class="ui-pattern-widget-shell-section">
                            <p class="ui-pattern-key-value-label">Metric</p>
                            <p class="ui-stat-value mt-3">84%</p>
                        </div>
                        <div class="ui-pattern-widget-shell-section">
                            <p class="ui-pattern-key-value-label">Detail</p>
                            <p class="ui-card-copy">One short explanatory paragraph or equivalent body block.</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="ui-pattern-widget-shell-section is-subtle">Same-topic supporting item one.</div>
                        <div class="ui-pattern-widget-shell-section is-subtle">Same-topic supporting item two.</div>
                    </div>
                    <p class="ui-card-copy">Use for one primary summary plus a small supporting list or body block.</p>
                </x-ui.patterns.widget-shell>

                <x-ui.patterns.widget-shell
                    title="3x1 Full Row"
                    description="Full-width row for broad summary without second-row detail."
                    kicker="Allowance 3x1"
                    span="3x1"
                    data-widget-content-size="3x1"
                >
                    <div class="grid gap-3 md:grid-cols-3">
                        <div class="ui-pattern-widget-shell-section is-subtle">Primary summary block.</div>
                        <div class="ui-pattern-widget-shell-section is-subtle">Secondary summary block.</div>
                        <div class="ui-pattern-widget-shell-section is-subtle">Tertiary summary block or one action cue.</div>
                    </div>
                    <p class="ui-card-copy">Use for horizontal comparison or broad status summaries that do not need stacked detail.</p>
                </x-ui.patterns.widget-shell>

                <x-ui.patterns.widget-shell
                    title="3x2 Tall Surface"
                    description="Largest approved dashboard widget surface for one rich topic."
                    kicker="Allowance 3x2"
                    span="3x2"
                    data-widget-content-size="3x2"
                >
                    <div class="grid gap-3 md:grid-cols-3">
                        <div class="ui-pattern-widget-shell-section">
                            <p class="ui-pattern-key-value-label">Capacity</p>
                            <p class="ui-stat-value mt-3">72%</p>
                        </div>
                        <div class="ui-pattern-widget-shell-section">
                            <p class="ui-pattern-key-value-label">Open items</p>
                            <p class="ui-stat-value mt-3">6</p>
                        </div>
                        <div class="ui-pattern-widget-shell-section">
                            <p class="ui-pattern-key-value-label">Oldest</p>
                            <p class="ui-stat-value mt-3">41m</p>
                        </div>
                    </div>
                    <div class="grid gap-3 md:grid-cols-2">
                        <div class="ui-pattern-widget-shell-section is-subtle">One larger related detail block may occupy the second row.</div>
                        <div class="ui-pattern-widget-shell-section is-subtle">A short same-topic list or summary may sit beside it.</div>
                    </div>
                    <p class="ui-card-copy">Use for dense same-topic summaries only. If it needs independent sections, move the content to a full page.</p>
                </x-ui.patterns.widget-shell>
            </x-ui.patterns.dashboard-grid>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Future module design baseline"
            description="Module teams should select the smallest widget size that supports the required scan target and supporting detail without clipping, crowding, or adding unrelated workflows."
            kicker="Implementation guidance"
        >
            <div class="grid gap-4 lg:grid-cols-2">
                <div class="ui-card">
                    <p class="ui-kicker">Allowed examples</p>
                    <ul class="ui-card-copy space-y-2">
                        <li>1. Summary metric with short support text.</li>
                        <li>2. Short same-topic list or activity feed in a tall narrow widget.</li>
                        <li>3. Related metric group plus one explanatory block in a two-row widget.</li>
                        <li>4. Full-row comparison across two or three compact summary blocks.</li>
                    </ul>
                </div>
                <div class="ui-card">
                    <p class="ui-kicker">Not allowed by default</p>
                    <ul class="ui-card-copy space-y-2">
                        <li>1. Multiple unrelated dashboard subjects in one widget.</li>
                        <li>2. Embedded create/edit forms or multi-step workflows.</li>
                        <li>3. Complex filtering, tabs, or table-like controls inside a widget.</li>
                        <li>4. More content than the declared span can show without scroll, clipping, or visual crowding.</li>
                    </ul>
                </div>
            </div>
        </x-ui.patterns.content-section-block>
    </section>
</x-layouts.app>
