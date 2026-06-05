        <x-ui.patterns.page-title-actions-row
            title="Table And Advanced Data Patterns"
            description="Tier 1 table baseline plus the Tier 2 enhanced table treatment for shared search, filter, sort, pagination, and row-detail behavior."
            kicker="Tier 1 + Tier 2"
        />

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
