        <x-ui.patterns.page-title-actions-row
            title="Table And Advanced Data Patterns"
            description="Tier 1 table baseline plus the Tier 2 enhanced table treatment for shared search, filter, sort, pagination, and row-detail behavior."
            kicker="Tier 1 + Tier 2"
        />

        <section class="ui-card" data-ui-guidance="table-pagination-usage" data-guidance-id="P2-F-CQ-011">
            <p class="ui-kicker">Table And Pagination Guidance</p>
            <div class="mt-3 grid gap-4 lg:grid-cols-2">
                <dl class="space-y-3 text-sm ui-reference-text">
                    <div>
                        <dt class="font-semibold ui-reference-text-strong">G-TABLE-01 - Table variants</dt>
                        <dd class="mt-1">Use a basic table for read-only rows, selectable table when bulk or row selection is required, and expandable/detail rows only when context must stay beside the table.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold ui-reference-text-strong">G-TABLE-02 - Row action threshold</dt>
                        <dd class="mt-1">Show one or two common inline icon actions; move three or more actions, uncommon actions, and destructive actions into an overflow menu.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold ui-reference-text-strong">G-TABLE-03 - Table skeleton loading</dt>
                        <dd class="mt-1">Use a table skeleton when table shape is known and data is loading; use an empty state only after loading completes with no results.</dd>
                    </div>
                </dl>

                <dl class="space-y-3 text-sm ui-reference-text">
                    <div>
                        <dt class="font-semibold ui-reference-text-strong">G-PAGIN-01 - Pagination variant</dt>
                        <dd class="mt-1">Use full pagination for large managed datasets and compact pagination navigation for short lists or adjacent detail browsing.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold ui-reference-text-strong">G-PAGIN-02 - Page size and placement</dt>
                        <dd class="mt-1">Place page size controls with table pagination, offer only meaningful sizes, and keep pagination below the result set.</dd>
                    </div>
                </dl>
            </div>
        </section>

        <section class="ui-card" data-ui-reference-example="table-pagination-contract" data-guidance-id="P2-F-CQ-011">
            <p class="ui-kicker">Concrete Table, Pagination, And Loading Examples</p>
            <div class="mt-5 grid gap-5 xl:grid-cols-2">
                <article class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Basic read-only table</p>
                    <div class="mt-3 overflow-x-auto rounded-md border ui-reference-border">
                        <table class="w-full min-w-[520px] ui-reference-table-body text-sm">
                            <thead class="ui-reference-table-head text-left text-xs uppercase tracking-[0.16em] ui-reference-text-muted">
                                <tr><th class="px-3 py-2">Workspace</th><th class="px-3 py-2">Owner</th><th class="px-3 py-2">Status</th></tr>
                            </thead>
                            <tbody class="ui-reference-table-body ui-reference-text">
                                <tr><td class="px-3 py-2 ui-reference-text-strong">North Region</td><td class="px-3 py-2">Platform Team</td><td class="px-3 py-2"><x-ui.badge label="active" semantic="success" /></td></tr>
                                <tr><td class="px-3 py-2 ui-reference-text-strong">Replay Service</td><td class="px-3 py-2">Security</td><td class="px-3 py-2"><x-ui.badge label="review" semantic="notice" /></td></tr>
                            </tbody>
                        </table>
                    </div>
                </article>

                <article class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Selectable row + overflow action</p>
                    <div class="mt-3 flex items-center justify-between gap-3 ui-reference-subtle-surface px-3 py-3">
                        <label class="flex items-center gap-3 text-sm ui-reference-text-strong">
                            <input type="checkbox" class="h-4 w-4 rounded ui-platform-checkbox" />
                            <span>Messaging Queue</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <x-ui.icon-button label="Open queue details">
                                <x-heroicon-o-eye class="h-4 w-4" aria-hidden="true" />
                            </x-ui.icon-button>
                            <x-ui.patterns.dropdown-action-menu label="More row actions" :icon-only="true">
                                <x-ui.menu-item href="#" onclick="event.preventDefault()">Open detail row</x-ui.menu-item>
                                <div class="ui-pattern-dropdown-divider"></div>
                                <x-ui.menu-item href="#" semantic="danger" onclick="event.preventDefault()">Disable queue</x-ui.menu-item>
                            </x-ui.patterns.dropdown-action-menu>
                        </div>
                    </div>
                </article>

                <article class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Table skeleton while loading</p>
                    <div class="mt-3 space-y-2" aria-label="Loading table rows">
                        <div class="h-9 rounded-md ui-reference-skeleton-line"></div>
                        <div class="h-9 rounded-md ui-reference-skeleton-line opacity-75"></div>
                        <div class="h-9 rounded-md ui-reference-skeleton-line opacity-60"></div>
                    </div>
                    <p class="mt-3 text-sm ui-reference-text-muted">Use skeleton rows when the table shape is known; use empty state only after loading completes.</p>
                </article>

                <article class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Pagination placement</p>
                    <div class="mt-3 flex flex-wrap items-center justify-between gap-3">
                        <label class="flex items-center gap-2 text-sm ui-reference-text">
                            Rows
                            <select class="ui-select w-24">
                                <option>25</option>
                                <option>50</option>
                            </select>
                        </label>
                        <div class="flex items-center gap-2 text-sm ui-reference-text">
                            <x-ui.button variant="ghost" size="sm">Previous</x-ui.button>
                            <span>Page 2 of 7</span>
                            <x-ui.button variant="outline" size="sm">Next</x-ui.button>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <section class="ui-card" data-ui-implementation-guide="tables-pagination" data-guidance-id="P2-F-CQ-011">
            <p class="ui-kicker">Table Implementation Guide</p>
            <p class="ui-card-copy mt-2">Owner route: <code>/platform/ui-reference/patterns/tables</code>. Use <code>x-ui.patterns.enhanced-data-table</code> for table surfaces that need toolbar, search, filters, sort state, pagination, and row detail. Use <code>x-ui.patterns.dropdown-action-menu</code> for row action overflow and <code>x-ui.badge</code> or <code>x-ui.status</code> for row state display.</p>
        </section>

        <x-ui.patterns.enhanced-data-table
            label="Enhanced Data Table"
            description="Use the enhanced table pattern when the surface needs reusable operator controls above the shared table baseline."
        >
            <x-slot:toolbar>
                <x-ui.patterns.search-filter-bar>
                    <label class="relative block w-full max-w-sm">
                        <span class="sr-only">Search workspace rows</span>
                        <span class="pointer-events-none absolute inset-y-0 left-0 inline-flex w-9 items-center justify-center ui-reference-text-muted">
                            <x-heroicon-o-magnifying-glass class="h-4 w-4" aria-hidden="true" />
                        </span>
                        <input type="text" value="Active owner filters" class="ui-input w-full pl-9" />
                    </label>
                    <select class="ui-select w-full sm:w-56">
                        <option>Owner: Platform Team</option>
                        <option>Owner: Security</option>
                    </select>
                    <x-slot:actions>
                        <x-ui.button variant="ghost">Reset</x-ui.button>
                        <x-ui.button semantic="primary">Apply</x-ui.button>
                    </x-slot:actions>
                </x-ui.patterns.search-filter-bar>
            </x-slot:toolbar>

            <div class="px-5 py-4 text-sm ui-reference-text">
                The workspace, audit log, and error log examples below are the canonical proof surfaces for sort state, active filters, row actions, empty states, drawer detail views, and responsive pagination controls.
            </div>
        </x-ui.patterns.enhanced-data-table>
