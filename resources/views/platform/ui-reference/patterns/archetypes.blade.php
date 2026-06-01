<x-layouts.app title="UI Reference · Archetype Proofs">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.archetypes'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <x-ui.patterns.page-title-actions-row
            title="Archetype Proofs"
            description="Reviewable internal page archetypes that future modules should inherit instead of inventing new shell structure."
            kicker="Batch B proof surfaces"
        />

        <div class="space-y-6">
            <x-ui.patterns.content-section-block title="Dashboard / Overview" description="Page title row, dashboard grid, explicit widget-shell spans, and grouped summary sections." kicker="Archetype">
                <x-ui.patterns.dashboard-grid columns="widgets">
                    <x-ui.patterns.widget-shell title="Overview summary" description="Compact KPI widget." kicker="1x1" span="1x1">
                        <x-ui.patterns.stat-card label="Overview blocks" value="3" supporting-text="Summary-first layout." />
                    </x-ui.patterns.widget-shell>
                    <x-ui.patterns.widget-shell title="Escalation queue" description="Wider queue summary." kicker="2x1" span="2x1">
                        <div class="grid gap-3 md:grid-cols-2">
                            <div class="ui-pattern-widget-shell-section">
                                <p class="ui-pattern-key-value-label">Primary actions</p>
                                <p class="ui-stat-value mt-3">2</p>
                            </div>
                            <div class="ui-pattern-widget-shell-section">
                                <p class="ui-pattern-key-value-label">Widget shell</p>
                                <p class="ui-stat-value mt-3">Locked</p>
                            </div>
                        </div>
                    </x-ui.patterns.widget-shell>
                </x-ui.patterns.dashboard-grid>
            </x-ui.patterns.content-section-block>

            <x-ui.patterns.content-section-block title="List / Index" description="Search/filter bar above an enhanced data table or data-list proof." kicker="Archetype">
                <div class="space-y-4">
                    <x-ui.patterns.search-filter-bar>
                        <label class="relative block w-full max-w-sm">
                            <span class="sr-only">Search records</span>
                            <span class="pointer-events-none absolute inset-y-0 left-0 inline-flex w-9 items-center justify-center text-slate-500">
                                <x-heroicon-o-magnifying-glass class="h-4 w-4" aria-hidden="true" />
                            </span>
                            <input type="text" placeholder="Search name or owner" class="ui-input w-full pl-9" />
                        </label>
                        <select class="ui-select w-full sm:w-56">
                            <option>Any status</option>
                            <option>Active</option>
                            <option>Review</option>
                        </select>
                        <x-slot:actions>
                            <x-ui.button variant="ghost">Reset</x-ui.button>
                            <x-ui.button semantic="primary">Apply</x-ui.button>
                        </x-slot:actions>
                    </x-ui.patterns.search-filter-bar>

                    <x-ui.patterns.date-range-filter
                        from-id="archetype-from"
                        to-id="archetype-to"
                        from-value="2026-05-01"
                        to-value="2026-05-31"
                        preset-id="archetype-preset"
                        preset-value="last_30_days"
                        :preset-options="[
                            'last_7_days' => 'Last 7 days',
                            'last_30_days' => 'Last 30 days',
                            'quarter_to_date' => 'Quarter to date',
                        ]"
                    >
                        <x-slot:actions>
                            <x-ui.button variant="ghost">Clear range</x-ui.button>
                            <x-ui.button semantic="primary">Apply range</x-ui.button>
                        </x-slot:actions>
                    </x-ui.patterns.date-range-filter>
                </div>
            </x-ui.patterns.content-section-block>

            <div class="grid gap-6 xl:grid-cols-2">
                <x-ui.patterns.content-section-block title="Detail / Read-only" description="Use a key-value display for summary detail, then section blocks for supporting context." kicker="Archetype">
                    <x-ui.patterns.key-value-display
                        :items="[
                            ['label' => 'Module owner', 'value' => 'Platform team'],
                            ['label' => 'Registration path', 'value' => 'Settings > General'],
                            ['label' => 'UI ownership', 'value' => 'Internal shell family'],
                            ['label' => 'Review status', 'value' => 'Review ready'],
                        ]"
                    />
                </x-ui.patterns.content-section-block>

                <x-ui.patterns.content-section-block title="Create / Edit Form" description="Stack validation summary, sectioned fields, and a dedicated actions bar." kicker="Archetype">
                    <x-ui.patterns.validation-summary :errors="['Display name is required.', 'Support email must be a valid address.']" />
                </x-ui.patterns.content-section-block>
            </div>

            <div class="grid gap-6 xl:grid-cols-3">
                <x-ui.patterns.content-section-block title="Setup / Configuration" description="Setup surfaces stay task-oriented with shared section and navigation rules." kicker="Archetype">
                    <ul class="space-y-2 text-sm text-slate-300">
                        <li>1. Task-entry cards lead into deeper configuration pages.</li>
                        <li>2. Sub-navigation appears only where peer setup sections already exist.</li>
                        <li>3. Registration fields are grouped separately from immediate setup tasks.</li>
                    </ul>
                </x-ui.patterns.content-section-block>

                <x-ui.patterns.content-section-block title="Settings" description="Settings surfaces share form scaffolding, internal navigation, and action placement." kicker="Archetype">
                    <ul class="space-y-2 text-sm text-slate-300">
                        <li>1. Page header stays consistent across all settings children.</li>
                        <li>2. Form sections own grouped fields and support copy.</li>
                        <li>3. Save/reset actions remain in a canonical footer bar.</li>
                    </ul>
                </x-ui.patterns.content-section-block>

                <x-ui.patterns.content-section-block title="Account / Profile" description="Account detail and preferences prove shared identity summaries and editable scaffolding reuse without changing feature behavior." kicker="Archetype">
                    <x-ui.patterns.identity-summary-card
                        variant="standard"
                        name="Jordan Reviewer"
                        subtitle="Platform operator"
                        initials="JR"
                        :meta="['jordan@example.com', 'Platform team', 'Reviewer role']"
                        status-label="MFA enabled"
                        status-semantic="notice"
                    >
                        <x-ui.patterns.key-value-display
                            :items="[
                                ['label' => 'Timezone', 'value' => 'America/New_York'],
                                ['label' => 'Theme', 'value' => 'System'],
                            ]"
                        />
                    </x-ui.patterns.identity-summary-card>
                </x-ui.patterns.content-section-block>
            </div>
        </div>
    </section>
</x-layouts.app>
