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

        <section class="ui-card" data-ui-reference-example="t2-action-composition" data-guidance-id="P2-F-CQ-008">
            <p class="ui-kicker">T2 Action Composition Examples</p>
            <div class="mt-4 grid gap-4 xl:grid-cols-2">
                <article class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Page-header actions</p>
                    <div class="mt-3 flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <h2 class="text-base font-semibold text-white">Workspace Settings</h2>
                            <p class="text-sm text-slate-400">One primary action remains visible; secondary choices reduce emphasis.</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            <x-ui.button variant="ghost" size="sm">Cancel</x-ui.button>
                            <x-ui.button variant="outline" size="sm">Preview</x-ui.button>
                            <x-ui.button semantic="primary" size="sm">Save Workspace</x-ui.button>
                        </div>
                    </div>
                </article>

                <article class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Filter actions stay on page</p>
                    <div class="mt-3 flex flex-wrap items-center gap-3">
                        <input type="search" value="policy" class="ui-input w-full sm:w-56" aria-label="Search current list" />
                        <select class="ui-select w-full sm:w-44" aria-label="Filter by owner">
                            <option>Any owner</option>
                            <option selected>Platform Team</option>
                        </select>
                        <x-ui.button variant="ghost">Reset</x-ui.button>
                        <x-ui.button semantic="primary">Apply</x-ui.button>
                    </div>
                    <p class="mt-3 text-sm text-slate-400">Use Apply for same-page filtering and Save/Create/Submit only when the resource or workflow completes.</p>
                </article>

                <article class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Form action bar</p>
                    <div class="mt-3 flex flex-wrap items-center justify-between gap-3">
                        <x-ui.button variant="ghost">Cancel</x-ui.button>
                        <div class="flex flex-wrap items-center gap-2">
                            <x-ui.button semantic="danger" variant="soft">Archive</x-ui.button>
                            <x-ui.button semantic="primary">Save Workspace</x-ui.button>
                        </div>
                    </div>
                </article>

                <article class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Row action overflow</p>
                    <div class="mt-3 flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-white">North Region Tenant</p>
                            <p class="text-xs text-slate-500">Two visible actions max; rarer and destructive actions move to overflow.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-ui.icon-button label="Edit tenant">
                                <x-heroicon-o-pencil-square class="h-4 w-4" aria-hidden="true" />
                            </x-ui.icon-button>
                            <x-ui.patterns.dropdown-action-menu label="More tenant actions" :icon-only="true">
                                <x-ui.menu-item href="#" onclick="event.preventDefault()">View audit trail</x-ui.menu-item>
                                <x-ui.menu-item href="#" semantic="info" onclick="event.preventDefault()">Export summary</x-ui.menu-item>
                                <div class="ui-pattern-dropdown-divider"></div>
                                <x-ui.menu-item href="#" semantic="danger" onclick="event.preventDefault()">Disable tenant</x-ui.menu-item>
                            </x-ui.patterns.dropdown-action-menu>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <section class="ui-card" data-ui-guidance="navigation-search-overflow-usage" data-guidance-id="P2-F-CQ-011">
            <p class="ui-kicker">Navigation, Search, Overflow, And Breadcrumb Guidance</p>
            <div class="mt-3 grid gap-4 lg:grid-cols-2">
                <dl class="space-y-3 text-sm text-slate-300">
                    <div>
                        <dt class="font-semibold text-slate-100">G-TABS-01 - Tab variants</dt>
                        <dd class="mt-1">Use line tabs for peer sections, contained tabs for dense panels, and vertical tabs only when long labels or nested settings groups need persistent scanability.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-slate-100">G-TABS-02 - Tablist behavior</dt>
                        <dd class="mt-1">Use automatic activation for fast local panels; use manual activation when panel changes trigger expensive loading or form state changes.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-slate-100">G-SEARCH-01 - Search scope</dt>
                        <dd class="mt-1">Global search belongs in the shell, page search belongs near the page title or table controls, and component search stays inside the dropdown or panel it filters.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-slate-100">G-SEARCH-02 - Search vs filter</dt>
                        <dd class="mt-1">Search handles free-entry keywords; filters handle known dimensions and should sit beside Apply, Reset, or Clear controls.</dd>
                    </div>
                </dl>

                <dl class="space-y-3 text-sm text-slate-300">
                    <div>
                        <dt class="font-semibold text-slate-100">G-OVERFLOW-01 - Overflow threshold</dt>
                        <dd class="mt-1">Use overflow menus when a row, card, or header has more than two secondary actions or needs rare actions out of the primary scan path.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-slate-100">G-OVERFLOW-02 - Destructive placement</dt>
                        <dd class="mt-1">Place destructive overflow actions after a divider, keep danger styling visible, and label the object or consequence nearby.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-slate-100">G-BREADCRUMB-01 - Breadcrumb vs progress</dt>
                        <dd class="mt-1">Use breadcrumb for location within information architecture; use progress indicators for ordered task completion.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-slate-100">G-BREADCRUMB-02 - Overflow and truncation</dt>
                        <dd class="mt-1">Collapse middle breadcrumb items first, preserve the current page label, and expose hidden ancestors through an accessible overflow control.</dd>
                    </div>
                </dl>
            </div>
        </section>

        <section class="ui-card" data-ui-reference-example="navigation-search-contract" data-guidance-id="P2-F-CQ-011">
            <p class="ui-kicker">Concrete Navigation, Search, Overflow, And Breadcrumb Examples</p>
            <div class="mt-5 grid gap-5 xl:grid-cols-2">
                <article class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Line tabs for peer sections</p>
                    <div class="mt-3 flex gap-1 border-b border-slate-800">
                        <button type="button" class="border-b-2 border-sky-400 px-3 py-2 text-sm font-semibold text-white">Overview</button>
                        <button type="button" class="border-b-2 border-transparent px-3 py-2 text-sm text-slate-400">Activity</button>
                        <button type="button" class="border-b-2 border-transparent px-3 py-2 text-sm text-slate-400">Settings</button>
                    </div>
                </article>

                <article class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Contained tabs for dense panels</p>
                    <div class="mt-3 inline-flex rounded-lg border border-slate-800 bg-slate-950 p-1">
                        <button type="button" class="rounded-md bg-slate-800 px-3 py-2 text-sm font-semibold text-white">Queue</button>
                        <button type="button" class="rounded-md px-3 py-2 text-sm text-slate-400">History</button>
                        <button type="button" class="rounded-md px-3 py-2 text-sm text-slate-400">Notes</button>
                    </div>
                    <p class="mt-3 text-sm text-slate-400">Queued gap: dedicated tab component with keyboard behavior; these examples document visual and usage boundaries only.</p>
                </article>

                <article class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Page search + known filters</p>
                    <div class="mt-3 flex flex-wrap items-center gap-3">
                        <input type="search" placeholder="Search workspaces" class="ui-input w-full sm:w-64" />
                        <select class="ui-select w-full sm:w-44">
                            <option>Any status</option>
                            <option>Needs review</option>
                        </select>
                        <x-ui.button variant="ghost">Clear</x-ui.button>
                        <x-ui.button semantic="primary">Apply</x-ui.button>
                    </div>
                </article>

                <article class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Breadcrumb with middle overflow</p>
                    <nav class="mt-3 flex flex-wrap items-center gap-2 text-sm text-slate-300" aria-label="Breadcrumb">
                        <a href="#" onclick="event.preventDefault()" class="ui-link">Dashboard</a>
                        <span>/</span>
                        <button type="button" class="ui-icon-button h-8 w-8" aria-label="Show hidden ancestors">
                            <x-heroicon-o-ellipsis-horizontal class="h-4 w-4" aria-hidden="true" />
                        </button>
                        <span>/</span>
                        <span class="font-semibold text-white">Workspace Settings</span>
                    </nav>
                    <p class="mt-3 text-sm text-slate-400">Use breadcrumb for location, not workflow progress.</p>
                </article>
            </div>
        </section>

        <section class="ui-card" data-ui-implementation-guide="navigation-search-overflow" data-guidance-id="P2-F-CQ-011">
            <p class="ui-kicker">Navigation Implementation Guide</p>
            <p class="ui-card-copy mt-2">Owner route: <code>/platform/ui-reference/patterns/navigation</code>. Use <code>x-ui.patterns.sub-navigation-bar</code> for peer shell sections, <code>x-ui.patterns.search-filter-bar</code> for page-local search/filter rows, <code>x-ui.patterns.dropdown-action-menu</code> for overflow, and native links/buttons for breadcrumb until a dedicated breadcrumb component is queued and implemented.</p>
        </section>

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
