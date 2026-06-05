<x-layouts.app title="UI Reference · Navigation And Action Patterns">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.navigation'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <x-ui.patterns.page-title-actions-row
            title="Navigation And Action Patterns"
            description="Tier 2 proof for page title rows, shared section navigation, grouped actions, and shell-aligned navigation behavior."
            kicker="Tier 2C / Tier 2E / Tier 2F"
        >
            <x-slot:context>
                <div class="flex flex-wrap items-center gap-2 text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">
                    <span class="rounded-full border border-slate-700 px-3 py-1">dashboard shell</span>
                    <span class="rounded-full border border-slate-700 px-3 py-1">settings shell</span>
                    <span class="rounded-full border border-slate-700 px-3 py-1">setup shell</span>
                </div>
            </x-slot:context>
            <x-slot:actions>
                <x-ui.button variant="ghost">Secondary</x-ui.button>
                <x-ui.button semantic="primary">Primary Action</x-ui.button>
            </x-slot:actions>
        </x-ui.patterns.page-title-actions-row>

        <x-ui.patterns.proof-review-banner
            :items="[
                ['id' => 'P2-B-CQ-003', 'note' => 'Proof-only guidance should use one clearly defined shared notice treatment instead of blending into the component examples.'],
                ['id' => 'P2-B-CQ-004', 'note' => 'Dropdown action menus should dismiss when pointer or focus moves outside the open menu.'],
                ['id' => 'P2-B-CQ-014', 'note' => 'Grouped-action menus on this page should now consume the shared action/menu-item colorway suite instead of one-off link styling.'],
                ['id' => 'P2-B-CQ-016', 'note' => 'Neutral ghost actions on this page should match the borderless shared ghost baseline used by the semantic ghost variants.'],
                ['id' => 'P2-B-CQ-008', 'note' => 'Date-range filtering should stay reviewable as one reusable Tier 2 control row.'],
                ['id' => 'P2-B-CQ-010', 'note' => 'The sub-navigation active state remains under review for clear readability.'],
                ['id' => 'P2-B-CQ-011', 'note' => 'Grouped-action menus should render above surrounding cards without clipping.'],
            ]"
            :focus="[
                'The grouped-action and filter examples are library proofs, not live remote behaviors.',
                'Section-level targeting on this page should show which specific navigation/action cards still belong to the current pending-review queue.',
            ]"
        />

        <x-ui.patterns.proof-note semantic="notice" title="How to read this proof">
            These patterns define structural action and navigation contracts. The examples below show what each control row is responsible for, but they do not imply remote autocomplete or bespoke menu behavior unless that note appears directly in the proof.
        </x-ui.patterns.proof-note>

        <x-ui.patterns.proof-note semantic="info" title="Page action and label guidance">
            <div data-ui-guidance="page-action-hierarchy" data-guidance-id="P2-F-CQ-008">
                <ul class="list-disc space-y-1 pl-5">
                    <li><span class="font-semibold">G-ACT-01:</span> the page title row keeps one primary action; secondary options use ghost, outline, or a grouped menu.</li>
                    <li><span class="font-semibold">G-LABEL-01:</span> Apply means the user stays on the current page while filters, range choices, or previews update in place.</li>
                    <li><span class="font-semibold">G-LABEL-03:</span> Submit, Create, Send, and Run report are completion verbs; use them when the action advances or returns from the current task.</li>
                    <li><span class="font-semibold">G-LABEL-06:</span> destructive verbs stay explicit and use danger styling in the grouped action menu.</li>
                </ul>
            </div>
        </x-ui.patterns.proof-note>

        <x-ui.patterns.content-section-block
            title="Sub-navigation Bar"
            description="Use sub-navigation only for peer content areas that already belong to the same internal shell family."
            kicker="Section navigation"
        >
            <x-ui.patterns.proof-review-target
                :items="[
                    ['id' => 'P2-B-CQ-010', 'note' => 'Review the active-state readability on this proof card itself. The current item should remain clearly legible in both dark and light themes.'],
                ]"
            />
            <x-ui.patterns.sub-navigation-bar
                :items="[
                    ['label' => 'General', 'href' => '#', 'current' => true],
                    ['label' => 'Company Info', 'href' => '#'],
                    ['label' => 'Localization', 'href' => '#'],
                    ['label' => 'Email', 'href' => '#'],
                    ['label' => 'System Update', 'href' => '#', 'disabled' => true],
                ]"
            />
        </x-ui.patterns.content-section-block>

        <div class="grid gap-6 xl:grid-cols-[1.2fr_minmax(0,0.8fr)]">
            <x-ui.patterns.content-section-block
                title="Dropdown Action Menu"
                description="Compact grouped actions should sit behind a trigger without becoming a one-off feature menu."
                kicker="Grouped actions"
            >
                <div class="flex flex-wrap items-center gap-3">
                    <x-ui.patterns.proof-review-target
                        class="w-full"
                        :items="[
                            ['id' => 'P2-B-CQ-004', 'note' => 'This shared dropdown pattern still needs human confirmation that outside-click and focus-away dismissal behave as the default contract.'],
                            ['id' => 'P2-B-CQ-014', 'note' => 'Review the grouped-action menu items here as consumers of the shared menu-item colorway suite, including the shared current-item state, rather than page-local text treatments.'],
                            ['id' => 'P2-B-CQ-016', 'note' => 'The ghost trigger/reset actions on this page should reflect the shared neutral-ghost parity pass.'],
                            ['id' => 'P2-B-CQ-011', 'note' => 'This same proof card remains the clipping/layering review target; the open panel must render above nearby card chrome and section borders.'],
                        ]"
                    />

                    <x-ui.patterns.dropdown-action-menu label="Workspace Actions">
                        <x-ui.menu-item href="#" current onclick="event.preventDefault()">View details</x-ui.menu-item>
                        <x-ui.menu-item href="#" semantic="notice" onclick="event.preventDefault()">Open proof surface</x-ui.menu-item>
                        <div class="ui-pattern-dropdown-divider"></div>
                        <x-ui.menu-item href="#" semantic="danger" onclick="event.preventDefault()">Archive workspace</x-ui.menu-item>
                    </x-ui.patterns.dropdown-action-menu>

                    <x-ui.patterns.dropdown-action-menu label="More" :icon-only="true">
                        <x-ui.menu-item href="#" semantic="primary" current onclick="event.preventDefault()">Edit labels</x-ui.menu-item>
                        <x-ui.menu-item href="#" semantic="info" onclick="event.preventDefault()">Export summary</x-ui.menu-item>
                    </x-ui.patterns.dropdown-action-menu>
                </div>
            </x-ui.patterns.content-section-block>

            <x-ui.patterns.content-section-block
                title="Search And Filter Bar"
                description="Search, filter, and reset controls should align as one reusable control row above list or table content."
                kicker="Operator controls"
            >
                <div class="space-y-4">
                    <x-ui.patterns.proof-review-target
                        :items="[
                            ['id' => 'P2-B-CQ-003', 'note' => 'The explanatory guidance blocks in this card should keep the shared proof-note treatment instead of reading like component chrome.'],
                            ['id' => 'P2-B-CQ-008', 'note' => 'This card is the review target for the reusable Tier 2 date-range filter pattern and its shared action row.'],
                        ]"
                    />

                    <x-ui.patterns.search-filter-bar>
                        <label class="relative block w-full max-w-sm">
                            <span class="sr-only">Search records</span>
                            <span class="pointer-events-none absolute inset-y-0 left-0 inline-flex w-9 items-center justify-center text-slate-500">
                                <x-heroicon-o-magnifying-glass class="h-4 w-4" aria-hidden="true" />
                            </span>
                            <input type="text" placeholder="Search name or owner" class="ui-input w-full pl-9" />
                        </label>
                        <select class="ui-select w-full sm:w-56">
                            <option>Any owner</option>
                            <option>Platform Team</option>
                            <option>Security</option>
                        </select>
                        <x-slot:actions>
                            <x-ui.button variant="ghost">Reset</x-ui.button>
                            <x-ui.button semantic="primary">Apply</x-ui.button>
                        </x-slot:actions>
                    </x-ui.patterns.search-filter-bar>

                    <x-ui.patterns.proof-note semantic="notice" title="Search and filter intent">
                        <ul class="list-disc space-y-1 pl-5">
                            <li><span class="font-semibold">Search field:</span> models free-entry keyword search across the current list or table surface.</li>
                            <li><span class="font-semibold">Owner filter:</span> models a known-option narrowing control; use the searchable selector baseline only when the option set becomes too long for a simple select.</li>
                            <li><span class="font-semibold">Reset / Apply:</span> demonstrate shared action placement and intent, not live query execution on this proof page.</li>
                        </ul>
                    </x-ui.patterns.proof-note>

                    <x-ui.patterns.date-range-filter
                        from-id="reporting-from"
                        to-id="reporting-to"
                        from-name="reporting_from"
                        to-name="reporting_to"
                        from-value="2026-05-01"
                        to-value="2026-05-31"
                        preset-id="reporting-preset"
                        preset-name="reporting_preset"
                        preset-value="last_30_days"
                        :preset-options="[
                            'last_7_days' => 'Last 7 days',
                            'last_30_days' => 'Last 30 days',
                            'quarter_to_date' => 'Quarter to date',
                        ]"
                    >
                        <x-slot:actions>
                            <x-ui.button variant="ghost">Clear range</x-ui.button>
                            <x-ui.button semantic="primary">Run report</x-ui.button>
                        </x-slot:actions>
                    </x-ui.patterns.date-range-filter>

                    <x-ui.patterns.proof-note semantic="notice" title="Date-range intent">
                        <ul class="list-disc space-y-1 pl-5">
                            <li><span class="font-semibold">Date baseline:</span> both controls remain native Tier 1 date inputs, so calendar entry stays consistent with the shared input contract.</li>
                            <li><span class="font-semibold">Preset select:</span> use for common windows such as last 7 or last 30 days, not to replace explicit from/to visibility.</li>
                            <li><span class="font-semibold">Range actions:</span> keep actions with the range so reporting and list/index surfaces avoid ad hoc date bars.</li>
                        </ul>
                    </x-ui.patterns.proof-note>
                </div>
            </x-ui.patterns.content-section-block>
        </div>

        <x-ui.patterns.content-section-block
            title="Shell Navigation Behavior"
            description="Tier 1 shell regions stay structural; these notes define how the shared navigation patterns should present inside those shells."
            kicker="Shell family rules"
        >
            <div class="grid gap-4 lg:grid-cols-3">
                <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.15em] text-slate-300">Dashboard</h3>
                    <ul class="mt-3 list-disc space-y-1 pl-4 text-sm text-slate-300">
                        <li>Header title row leads the page.</li>
                        <li>Widget actions stay local to widgets or the page header.</li>
                        <li>Dashboard grid owns summary layout only.</li>
                    </ul>
                </article>
                <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.15em] text-slate-300">Settings / Setup</h3>
                    <ul class="mt-3 list-disc space-y-1 pl-4 text-sm text-slate-300">
                        <li>Sub-navigation sits below the page title row.</li>
                        <li>Secondary shell navigation stays separate from field-group actions.</li>
                        <li>Registration fields belong inside dedicated content sections.</li>
                    </ul>
                </article>
                <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.15em] text-slate-300">Mobile / Narrow Width</h3>
                    <ul class="mt-3 list-disc space-y-1 pl-4 text-sm text-slate-300">
                        <li>Header actions wrap before introducing bespoke mobile controls.</li>
                        <li>Sub-navigation remains horizontally scrollable.</li>
                        <li>Grouped action menus must remain keyboard reachable.</li>
                    </ul>
                </article>
            </div>
        </x-ui.patterns.content-section-block>
    </section>
</x-layouts.app>
