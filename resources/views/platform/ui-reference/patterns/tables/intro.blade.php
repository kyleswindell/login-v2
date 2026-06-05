        <x-ui.patterns.page-title-actions-row
            title="Table And Advanced Data Patterns"
            description="Tier 1 table baseline plus the Tier 2 enhanced table treatment for shared search, filter, sort, pagination, and row-detail behavior."
            kicker="Tier 1 + Tier 2"
        />

        <section class="ui-card" data-ui-guidance="table-pagination-usage" data-guidance-id="P2-F-CQ-011">
            <p class="ui-kicker">Table And Pagination Guidance</p>
            <div class="mt-3 grid gap-4 lg:grid-cols-2">
                <dl class="space-y-3 text-sm text-slate-300">
                    <div>
                        <dt class="font-semibold text-slate-100">G-TABLE-01 - Table variants</dt>
                        <dd class="mt-1">Use a basic table for read-only rows, selectable table when bulk or row selection is required, and expandable/detail rows only when context must stay beside the table.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-slate-100">G-TABLE-02 - Row action threshold</dt>
                        <dd class="mt-1">Show one or two common inline icon actions; move three or more actions, uncommon actions, and destructive actions into an overflow menu.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-slate-100">G-TABLE-03 - Table skeleton loading</dt>
                        <dd class="mt-1">Use a table skeleton when table shape is known and data is loading; use an empty state only after loading completes with no results.</dd>
                    </div>
                </dl>

                <dl class="space-y-3 text-sm text-slate-300">
                    <div>
                        <dt class="font-semibold text-slate-100">G-PAGIN-01 - Pagination variant</dt>
                        <dd class="mt-1">Use full pagination for large managed datasets and compact pagination navigation for short lists or adjacent detail browsing.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-slate-100">G-PAGIN-02 - Page size and placement</dt>
                        <dd class="mt-1">Place page size controls with table pagination, offer only meaningful sizes, and keep pagination below the result set.</dd>
                    </div>
                </dl>
            </div>
        </section>

        <x-ui.patterns.enhanced-data-table
            label="Enhanced Data Table"
            description="Use the enhanced table pattern when the surface needs reusable operator controls above the shared table baseline."
        >
            <x-slot:toolbar>
                <x-ui.patterns.search-filter-bar>
                    <label class="relative block w-full max-w-sm">
                        <span class="sr-only">Search workspace rows</span>
                        <span class="pointer-events-none absolute inset-y-0 left-0 inline-flex w-9 items-center justify-center text-slate-500">
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

            <div class="px-5 py-4 text-sm text-slate-300">
                The workspace, audit log, and error log examples below are the canonical proof surfaces for sort state, active filters, row actions, empty states, drawer detail views, and responsive pagination controls.
            </div>
        </x-ui.patterns.enhanced-data-table>
