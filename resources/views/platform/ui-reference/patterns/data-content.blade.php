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
                ['id' => 'P2-B-CQ-009', 'note' => 'Identity summary should prove lighter and fuller variants, while staying one family for person and company/entity summaries.'],
                ['id' => 'P2-B-CQ-012', 'note' => 'Compact metadata rows should read as distinct pieces of information, not one run-on sentence.'],
                ['id' => 'P2-B-CQ-013', 'note' => 'This page also demonstrates the temporary active-batch review overlay system.'],
            ]"
            :focus="[
                'Separate permanent library guidance from temporary review context.',
                'Check the metadata treatment on both identity summaries and data-list rows.',
            ]"
        />

        <x-ui.patterns.proof-note semantic="notice" title="How to read this proof">
            These examples show the expected content shape for read-only summaries and fallback states. Values should render as plain text by default, with trusted linked content called out intentionally instead of leaking raw markup into the page.
        </x-ui.patterns.proof-note>

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
                <x-ui.patterns.data-list-item
                    title="General Settings Ownership"
                    description="Shared setup and settings registration fields are locked to the internal shell contract."
                    :meta="['Settings shell', 'Updated May 31', 'Owned by platform team']"
                >
                    <x-slot:actions>
                        <x-ui.patterns.dropdown-action-menu label="Open">
                            <a href="#" class="ui-pattern-dropdown-link" onclick="event.preventDefault()">View contract</a>
                            <a href="#" class="ui-pattern-dropdown-link" onclick="event.preventDefault()">Review proof surface</a>
                            <div class="ui-pattern-dropdown-divider"></div>
                            <a href="#" class="ui-pattern-dropdown-link text-rose-300" onclick="event.preventDefault()">Archive draft</a>
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
