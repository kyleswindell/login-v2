<x-layouts.app title="UI Reference · Table Baselines">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.tables'])
    </x-slot:sidebar>

    @php
        $tablesUrl = function (array $overrides = [], string $anchor = '') {
            $query = array_merge(request()->query(), $overrides);

            return route('platform.ui-reference.patterns.tables').($query !== [] ? '?'.http_build_query($query) : '').$anchor;
        };

        $sortMeta = function (
            string $currentSort,
            string $currentDirection,
            string $column,
            string $defaultDirection = 'asc'
        ): array {
            $active = $currentSort === $column;
            $nextDirection = $active && $currentDirection === 'asc' ? 'desc' : 'asc';
            $initialDirection = $active ? $currentDirection : $defaultDirection;

            return [
                'active' => $active,
                'aria' => $active ? ($currentDirection === 'asc' ? 'ascending' : 'descending') : null,
                'next' => $nextDirection,
                'icon_component' => $active
                    ? ($currentDirection === 'asc' ? 'heroicon-o-arrow-small-up' : 'heroicon-o-arrow-small-down')
                    : 'heroicon-o-arrows-up-down',
                'sr_label' => $active
                    ? 'Sorted '.($currentDirection === 'asc' ? 'ascending' : 'descending').'. Activate to sort '.($nextDirection === 'asc' ? 'ascending' : 'descending').'.'
                    : 'Not currently sorted. Activate to sort '.($initialDirection === 'asc' ? 'ascending' : 'descending').'.',
            ];
        };
    @endphp

    <section class="flex flex-1 flex-col gap-6" data-ui-reference-tables-root>
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

        <section id="workspace-table-baseline" class="ui-card relative" data-table-section="workspace">
            <div class="pointer-events-none absolute inset-0 z-10 hidden items-center justify-center rounded-lg bg-slate-950/65" data-table-loading-overlay aria-hidden="true">
                <div class="rounded-lg border border-slate-800 bg-slate-900/90 px-5 py-4 text-center shadow-2xl shadow-black/30">
                    <span class="ui-spinner" aria-hidden="true"></span>
                    <p class="mt-3 text-sm font-semibold text-white">Refreshing workspace rows</p>
                    <p class="mt-1 text-xs text-slate-400">Applying the current table controls without a full page reload.</p>
                </div>
            </div>
            <div>
                <p class="ui-kicker">General Table</p>
                <h2 class="ui-card-title mt-2">Operator Data Grid Baseline</h2>
            </div>

            <div class="relative mt-4">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div class="flex flex-wrap items-center gap-3">
                        <form method="GET" action="{{ route('platform.ui-reference.patterns.tables') }}" class="flex items-center gap-3">
                            <input type="hidden" name="workspace_status" value="{{ $workspaceFilters['status'] }}">
                            <input type="hidden" name="workspace_owner" value="{{ $workspaceFilters['owner'] }}">
                            <input type="hidden" name="workspace_search" value="{{ $workspaceFilters['search'] }}">
                            <input type="hidden" name="workspace_sort" value="{{ $workspaceSort }}">
                            <input type="hidden" name="workspace_direction" value="{{ $workspaceDirection }}">
                            <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                            <input type="hidden" name="error_per_page" value="{{ $errorPerPage }}">
                            <label class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Rows</label>
                            <select name="workspace_per_page" onchange="this.form.submit()" class="ui-select ui-select-compact rounded-lg text-sm">
                                @foreach ([10, 25, 50, 100] as $option)
                                    <option value="{{ $option }}" @selected($workspacePerPage === $option)>{{ $option }}</option>
                                @endforeach
                            </select>
                        </form>

                        <button type="button" class="ui-action ui-action-primary">Create</button>
                        <button type="button" class="ui-action">
                            <x-heroicon-o-cog-6-tooth class="h-4 w-4" aria-hidden="true" />
                            Settings
                        </button>
                        <button type="button" class="ui-action ui-action-warning ui-action-outline">
                            <x-heroicon-o-arrow-down-tray class="h-4 w-4" aria-hidden="true" />
                            Export
                        </button>
                    </div>

                    <div class="ml-auto flex max-w-full items-center justify-end gap-3">
                        <form method="GET" action="{{ route('platform.ui-reference.patterns.tables') }}#workspace-table-baseline" class="relative w-64 max-w-full flex-shrink-0" data-table-search-form>
                            <input type="hidden" name="workspace_status" value="{{ $workspaceFilters['status'] }}">
                            <input type="hidden" name="workspace_owner" value="{{ $workspaceFilters['owner'] }}">
                            <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                            <input type="hidden" name="workspace_sort" value="{{ $workspaceSort }}">
                            <input type="hidden" name="workspace_direction" value="{{ $workspaceDirection }}">
                            <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                            <input type="hidden" name="error_per_page" value="{{ $errorPerPage }}">
                            <label for="workspace-table-search" class="sr-only">Search workspace rows</label>
                            <span class="pointer-events-none absolute inset-y-0 left-0 inline-flex w-9 items-center justify-center text-slate-500">
                                <x-heroicon-o-magnifying-glass class="h-4 w-4" aria-hidden="true" />
                            </span>
                            <input
                                id="workspace-table-search"
                                type="text"
                                name="workspace_search"
                                value="{{ $workspaceFilters['search'] }}"
                                data-table-search-input
                                data-initial-search="{{ $workspaceFilters['search'] }}"
                                placeholder="Search name or owner"
                                aria-label="Search workspace rows"
                                class="w-full rounded-md border border-slate-700 bg-slate-950 py-2 pl-9 pr-9 text-sm text-slate-100 placeholder:text-slate-500"
                            />
                            <button type="button" class="absolute inset-y-0 right-0 hidden w-9 items-center justify-center text-slate-500 transition hover:text-slate-300" data-table-search-clear aria-label="Clear search text">
                                <x-heroicon-o-x-mark class="h-4 w-4" aria-hidden="true" />
                            </button>
                            <button type="button" class="absolute inset-y-0 right-0 hidden w-9 items-center justify-center text-rose-500 transition hover:text-rose-400" data-table-search-reset aria-label="Reset applied search filter">
                                <x-heroicon-o-x-mark class="h-4 w-4" aria-hidden="true" />
                            </button>
                        </form>
                        <button type="button" class="ui-icon-button" data-filter-toggle aria-expanded="false" aria-label="Toggle workspace filters">
                            <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                        </button>
                    </div>
                </div>

                <form method="GET" action="{{ route('platform.ui-reference.patterns.tables') }}" class="ui-table-filter-panel hidden" data-filter-panel>
                    <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                    <input type="hidden" name="workspace_search" value="{{ $workspaceFilters['search'] }}">
                    <input type="hidden" name="workspace_sort" value="{{ $workspaceSort }}">
                    <input type="hidden" name="workspace_direction" value="{{ $workspaceDirection }}">
                    <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                    <input type="hidden" name="error_per_page" value="{{ $errorPerPage }}">
                    <div class="grid gap-4 md:grid-cols-2">
                    <label>
                        <span class="text-sm font-semibold text-slate-200">Status</span>
                        <select name="workspace_status" class="ui-select ui-select-compact mt-2 text-slate-100">
                            <option value="">Any</option>
                            <option value="active" @selected($workspaceFilters['status'] === 'active')>Active</option>
                            <option value="review" @selected($workspaceFilters['status'] === 'review')>Review</option>
                            <option value="disabled" @selected($workspaceFilters['status'] === 'disabled')>Disabled</option>
                        </select>
                    </label>
                    <label>
                        <span class="text-sm font-semibold text-slate-200">Owner</span>
                        <select name="workspace_owner" class="ui-select ui-select-compact mt-2 text-slate-100">
                            <option value="">Any</option>
                            @foreach (['Platform Team', 'Security', 'Operations', 'Docs Team'] as $owner)
                                <option value="{{ $owner }}" @selected($workspaceFilters['owner'] === $owner)>{{ $owner }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <button type="submit" class="ui-action ui-action-primary">Apply</button>
                        <a wire:navigate href="{{ route('platform.ui-reference.patterns.tables') }}" class="ui-action ui-action-ghost">Reset</a>
                    </div>
                </form>
            </div>

            <div class="mt-4 overflow-x-auto rounded-lg border border-slate-800 bg-slate-900/70">
                <table class="min-w-[860px] w-full divide-y divide-slate-800">
                    <thead class="bg-slate-900">
                        <tr class="text-left text-xs uppercase tracking-[0.2em] text-slate-500">
                            @php($workspaceNameSort = $sortMeta($workspaceSort, $workspaceDirection, 'name'))
                            @php($workspaceOwnerSort = $sortMeta($workspaceSort, $workspaceDirection, 'owner'))
                            @php($workspacePolicySort = $sortMeta($workspaceSort, $workspaceDirection, 'policy_count', 'desc'))
                            @php($workspaceUpdatedSort = $sortMeta($workspaceSort, $workspaceDirection, 'updated_at_timestamp', 'desc'))
                            <th class="px-5 py-3" @if ($workspaceNameSort['aria']) aria-sort="{{ $workspaceNameSort['aria'] }}" @endif>
                                <a href="{{ $tablesUrl(['workspace_sort' => 'name', 'workspace_direction' => $workspaceNameSort['next'], 'workspace_page' => 1], '#workspace-table-baseline') }}" @class(['ui-table-sort', 'is-active' => $workspaceNameSort['active']])>
                                    <span>Name</span>
                                    <span class="sr-only">{{ $workspaceNameSort['sr_label'] }}</span>
                                    <span class="ui-table-sort-icon" aria-hidden="true">
                                        <x-dynamic-component :component="$workspaceNameSort['icon_component']" class="h-3.5 w-3.5" />
                                    </span>
                                </a>
                            </th>
                            <th class="px-5 py-3" @if ($workspaceOwnerSort['aria']) aria-sort="{{ $workspaceOwnerSort['aria'] }}" @endif>
                                <a href="{{ $tablesUrl(['workspace_sort' => 'owner', 'workspace_direction' => $workspaceOwnerSort['next'], 'workspace_page' => 1], '#workspace-table-baseline') }}" @class(['ui-table-sort', 'is-active' => $workspaceOwnerSort['active']])>
                                    <span>Owner</span>
                                    <span class="sr-only">{{ $workspaceOwnerSort['sr_label'] }}</span>
                                    <span class="ui-table-sort-icon" aria-hidden="true">
                                        <x-dynamic-component :component="$workspaceOwnerSort['icon_component']" class="h-3.5 w-3.5" />
                                    </span>
                                </a>
                            </th>
                            <th class="px-5 py-3" @if ($workspacePolicySort['aria']) aria-sort="{{ $workspacePolicySort['aria'] }}" @endif>
                                <a href="{{ $tablesUrl(['workspace_sort' => 'policy_count', 'workspace_direction' => $workspacePolicySort['next'], 'workspace_page' => 1], '#workspace-table-baseline') }}" @class(['ui-table-sort', 'is-active' => $workspacePolicySort['active']])>
                                    <span>Policies</span>
                                    <span class="sr-only">{{ $workspacePolicySort['sr_label'] }}</span>
                                    <span class="ui-table-sort-icon" aria-hidden="true">
                                        <x-dynamic-component :component="$workspacePolicySort['icon_component']" class="h-3.5 w-3.5" />
                                    </span>
                                </a>
                            </th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3" @if ($workspaceUpdatedSort['aria']) aria-sort="{{ $workspaceUpdatedSort['aria'] }}" @endif>
                                <a href="{{ $tablesUrl(['workspace_sort' => 'updated_at_timestamp', 'workspace_direction' => $workspaceUpdatedSort['next'], 'workspace_page' => 1], '#workspace-table-baseline') }}" @class(['ui-table-sort', 'is-active' => $workspaceUpdatedSort['active']])>
                                    <span>Updated</span>
                                    <span class="sr-only">{{ $workspaceUpdatedSort['sr_label'] }}</span>
                                    <span class="ui-table-sort-icon" aria-hidden="true">
                                        <x-dynamic-component :component="$workspaceUpdatedSort['icon_component']" class="h-3.5 w-3.5" />
                                    </span>
                                </a>
                            </th>
                            <th class="px-5 py-3 sr-only">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 text-sm text-slate-200">
                        @forelse ($workspaceRows as $row)
                            <tr class="ui-table-row">
                                <td class="px-5 py-3 font-semibold text-white">{{ $row['name'] }}</td>
                                <td class="px-5 py-3">{{ $row['owner'] }}</td>
                                <td class="px-5 py-3">{{ $row['policy_count'] }}</td>
                                <td class="px-5 py-3">
                                    <x-ui.badge :status="$row['status'] === 'review' ? 'pending review' : $row['status']" :show-icon="false" />
                                </td>
                                <td class="px-5 py-3 text-slate-400">{{ $row['updated_at_label'] }}</td>
                                <td class="px-5 py-3 text-right"><button type="button" class="ui-action ui-action-primary">View</button></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-sm text-slate-500">No workspace rows matched the current filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-800 px-5 py-3">
                    <div class="flex items-center gap-3">
                        <p class="text-sm text-slate-400">Showing {{ $workspaceRows->firstItem() ?? 0 }} to {{ $workspaceRows->lastItem() ?? 0 }} of {{ $workspaceRows->total() }} entries</p>
                    </div>

                    <div class="flex items-center gap-2">
                        @php($workspacePrev = max(1, $workspaceRows->currentPage() - 1))
                        @php($workspaceNext = min($workspaceRows->lastPage(), $workspaceRows->currentPage() + 1))

                        @if ($workspaceRows->onFirstPage())
                            <span class="ui-pagination-control is-disabled" aria-disabled="true">Prev</span>
                        @else
                            <a href="{{ $workspaceRows->url($workspacePrev) }}" class="ui-pagination-control">Prev</a>
                        @endif

                        <form method="GET" action="{{ route('platform.ui-reference.patterns.tables') }}">
                            <input type="hidden" name="workspace_status" value="{{ $workspaceFilters['status'] }}">
                            <input type="hidden" name="workspace_owner" value="{{ $workspaceFilters['owner'] }}">
                            <input type="hidden" name="workspace_search" value="{{ $workspaceFilters['search'] }}">
                            <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                            <input type="hidden" name="workspace_sort" value="{{ $workspaceSort }}">
                            <input type="hidden" name="workspace_direction" value="{{ $workspaceDirection }}">
                            <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                            <input type="hidden" name="error_per_page" value="{{ $errorPerPage }}">
                            <select name="workspace_page" onchange="this.form.submit()" class="ui-select ui-select-compact rounded-lg text-xs font-semibold uppercase tracking-[0.1em] text-slate-200">
                                @for ($page = 1; $page <= $workspaceRows->lastPage(); $page++)
                                    <option value="{{ $page }}" @selected($page === $workspaceRows->currentPage())>Page {{ $page }}</option>
                                @endfor
                            </select>
                        </form>

                        @if ($workspaceRows->hasMorePages())
                            <a href="{{ $workspaceRows->url($workspaceNext) }}" class="ui-pagination-control">Next</a>
                        @else
                            <span class="ui-pagination-control is-disabled" aria-disabled="true">Next</span>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Table State Validation</p>
            <p class="mt-2 text-sm text-slate-400">These static review surfaces make loading and empty states explicit without relying on filter setup during manual review.</p>
            <div class="mt-4 grid gap-6 xl:grid-cols-2">
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Loading State</p>
                    <div class="mt-3 overflow-x-auto rounded-lg border border-slate-800 bg-slate-950/70">
                        <table class="min-w-[640px] w-full divide-y divide-slate-800">
                            <thead class="bg-slate-900">
                                <tr class="text-left text-xs uppercase tracking-[0.2em] text-slate-500">
                                    <th class="px-5 py-3">Name</th>
                                    <th class="px-5 py-3">Owner</th>
                                    <th class="px-5 py-3">Status</th>
                                    <th class="px-5 py-3">Updated</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-slate-300">
                                <tr>
                                    <td colspan="4" class="px-5 py-10">
                                        <div class="flex flex-col items-center justify-center gap-3 text-center">
                                            <span class="ui-spinner" aria-hidden="true"></span>
                                            <div>
                                                <p class="font-semibold text-white">Loading workspace rows</p>
                                                <p class="mt-1 text-slate-400">Use this baseline to verify centered feedback, table framing, and non-jumping layout.</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Empty State</p>
                    <div class="mt-3 overflow-x-auto rounded-lg border border-slate-800 bg-slate-950/70">
                        <table class="min-w-[640px] w-full divide-y divide-slate-800">
                            <thead class="bg-slate-900">
                                <tr class="text-left text-xs uppercase tracking-[0.2em] text-slate-500">
                                    <th class="px-5 py-3">Name</th>
                                    <th class="px-5 py-3">Owner</th>
                                    <th class="px-5 py-3">Status</th>
                                    <th class="px-5 py-3">Updated</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-slate-300">
                                <tr>
                                    <td colspan="4" class="px-5 py-10 text-center">
                                        <p class="font-semibold text-white">No workspace rows matched the current filters.</p>
                                        <p class="mt-2 text-slate-400">The empty state stays inside the table baseline and preserves table structure for review.</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <section id="audit-table-baseline" class="ui-card relative" data-table-section="audit">
            <div class="pointer-events-none absolute inset-0 z-10 hidden items-center justify-center rounded-lg bg-slate-950/65" data-table-loading-overlay aria-hidden="true">
                <div class="rounded-lg border border-slate-800 bg-slate-900/90 px-5 py-4 text-center shadow-2xl shadow-black/30">
                    <span class="ui-spinner" aria-hidden="true"></span>
                    <p class="mt-3 text-sm font-semibold text-white">Refreshing audit rows</p>
                    <p class="mt-1 text-xs text-slate-400">Applying the current table controls without a full page reload.</p>
                </div>
            </div>
            <div>
                <p class="ui-kicker">Logs Table</p>
                <h2 class="ui-card-title mt-2">Audit Drawer Example</h2>
                <p class="ui-card-copy">Row clicks and explicit `View` actions both open the right-side drawer.</p>
            </div>

            <div class="relative mt-4">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <form method="GET" action="{{ route('platform.ui-reference.patterns.tables') }}" class="flex items-center gap-3">
                        <input type="hidden" name="audit_severity" value="{{ $auditFilters['severity'] }}">
                        <input type="hidden" name="audit_result" value="{{ $auditFilters['result'] }}">
                        <input type="hidden" name="audit_search" value="{{ $auditFilters['search'] }}">
                        <input type="hidden" name="audit_sort" value="{{ $auditSort }}">
                        <input type="hidden" name="audit_direction" value="{{ $auditDirection }}">
                        <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                        <input type="hidden" name="error_per_page" value="{{ $errorPerPage }}">
                        <label class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Rows</label>
                        <select name="audit_per_page" onchange="this.form.submit()" class="ui-select ui-select-compact rounded-lg text-sm">
                            @foreach ([10, 25, 50, 100] as $option)
                                <option value="{{ $option }}" @selected($auditPerPage === $option)>{{ $option }}</option>
                            @endforeach
                        </select>
                    </form>

                    <div class="ml-auto flex max-w-full items-center justify-end gap-3">
                        <form method="GET" action="{{ route('platform.ui-reference.patterns.tables') }}#audit-table-baseline" class="relative w-64 max-w-full flex-shrink-0" data-table-search-form>
                            <input type="hidden" name="audit_severity" value="{{ $auditFilters['severity'] }}">
                            <input type="hidden" name="audit_result" value="{{ $auditFilters['result'] }}">
                            <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                            <input type="hidden" name="audit_sort" value="{{ $auditSort }}">
                            <input type="hidden" name="audit_direction" value="{{ $auditDirection }}">
                            <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                            <input type="hidden" name="error_per_page" value="{{ $errorPerPage }}">
                            <label for="audit-table-search" class="sr-only">Search audit rows</label>
                            <span class="pointer-events-none absolute inset-y-0 left-0 inline-flex w-9 items-center justify-center text-slate-500">
                                <x-heroicon-o-magnifying-glass class="h-4 w-4" aria-hidden="true" />
                            </span>
                            <input
                                id="audit-table-search"
                                type="text"
                                name="audit_search"
                                value="{{ $auditFilters['search'] }}"
                                data-table-search-input
                                data-initial-search="{{ $auditFilters['search'] }}"
                                placeholder="Event, actor, route"
                                aria-label="Search audit rows"
                                class="w-full rounded-md border border-slate-700 bg-slate-950 py-2 pl-9 pr-9 text-sm text-slate-100 placeholder:text-slate-500"
                            />
                            <button type="button" class="absolute inset-y-0 right-0 hidden w-9 items-center justify-center text-slate-500 transition hover:text-slate-300" data-table-search-clear aria-label="Clear search text">
                                <x-heroicon-o-x-mark class="h-4 w-4" aria-hidden="true" />
                            </button>
                            <button type="button" class="absolute inset-y-0 right-0 hidden w-9 items-center justify-center text-rose-500 transition hover:text-rose-400" data-table-search-reset aria-label="Reset applied search filter">
                                <x-heroicon-o-x-mark class="h-4 w-4" aria-hidden="true" />
                            </button>
                        </form>
                        <button type="button" class="ui-icon-button" data-filter-toggle aria-expanded="false" aria-label="Toggle audit demo filters">
                            <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                        </button>
                    </div>
                </div>

                <form method="GET" action="{{ route('platform.ui-reference.patterns.tables') }}" class="ui-table-filter-panel hidden" data-filter-panel>
                    <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                    <input type="hidden" name="error_per_page" value="{{ $errorPerPage }}">
                    <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                    <input type="hidden" name="audit_search" value="{{ $auditFilters['search'] }}">
                    <input type="hidden" name="audit_sort" value="{{ $auditSort }}">
                    <input type="hidden" name="audit_direction" value="{{ $auditDirection }}">
                    <div class="grid gap-4 md:grid-cols-2">
                    <label>
                        <span class="text-sm font-semibold text-slate-200">Severity</span>
                        <select name="audit_severity" class="ui-select ui-select-compact mt-2 text-slate-100">
                            <option value="">Any</option>
                            <option value="info" @selected($auditFilters['severity'] === 'info')>Info</option>
                            <option value="notice" @selected($auditFilters['severity'] === 'notice')>Notice</option>
                        </select>
                    </label>
                    <label>
                        <span class="text-sm font-semibold text-slate-200">Result</span>
                        <select name="audit_result" class="ui-select ui-select-compact mt-2 text-slate-100">
                            <option value="">Any</option>
                            <option value="success" @selected($auditFilters['result'] === 'success')>Success</option>
                        </select>
                    </label>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <button type="submit" class="ui-action ui-action-primary">Apply</button>
                        <a wire:navigate href="{{ route('platform.ui-reference.patterns.tables') }}" class="ui-action ui-action-ghost">Reset</a>
                    </div>
                </form>
            </div>

            <div class="mt-4 overflow-x-auto rounded-lg border border-slate-800 bg-slate-900/70">
                <table class="min-w-[920px] w-full divide-y divide-slate-800">
                    <thead class="bg-slate-900">
                        <tr class="text-left text-xs uppercase tracking-[0.2em] text-slate-500">
                            @php($auditOccurredSort = $sortMeta($auditSort, $auditDirection, 'occurred_at_timestamp', 'desc'))
                            @php($auditEventSort = $sortMeta($auditSort, $auditDirection, 'event_type'))
                            @php($auditActorSort = $sortMeta($auditSort, $auditDirection, 'actor_label'))
                            @php($auditRouteSort = $sortMeta($auditSort, $auditDirection, 'route'))
                            <th class="px-5 py-3" @if ($auditOccurredSort['aria']) aria-sort="{{ $auditOccurredSort['aria'] }}" @endif>
                                <a href="{{ $tablesUrl(['audit_sort' => 'occurred_at_timestamp', 'audit_direction' => $auditOccurredSort['next'], 'audit_page' => 1], '#audit-table-baseline') }}" @class(['ui-table-sort', 'is-active' => $auditOccurredSort['active']])>
                                    <span>Occurred</span>
                                    <span class="sr-only">{{ $auditOccurredSort['sr_label'] }}</span>
                                    <span class="ui-table-sort-icon" aria-hidden="true">
                                        <x-dynamic-component :component="$auditOccurredSort['icon_component']" class="h-3.5 w-3.5" />
                                    </span>
                                </a>
                            </th>
                            <th class="px-5 py-3" @if ($auditEventSort['aria']) aria-sort="{{ $auditEventSort['aria'] }}" @endif>
                                <a href="{{ $tablesUrl(['audit_sort' => 'event_type', 'audit_direction' => $auditEventSort['next'], 'audit_page' => 1], '#audit-table-baseline') }}" @class(['ui-table-sort', 'is-active' => $auditEventSort['active']])>
                                    <span>Event</span>
                                    <span class="sr-only">{{ $auditEventSort['sr_label'] }}</span>
                                    <span class="ui-table-sort-icon" aria-hidden="true">
                                        <x-dynamic-component :component="$auditEventSort['icon_component']" class="h-3.5 w-3.5" />
                                    </span>
                                </a>
                            </th>
                            <th class="px-5 py-3" @if ($auditActorSort['aria']) aria-sort="{{ $auditActorSort['aria'] }}" @endif>
                                <a href="{{ $tablesUrl(['audit_sort' => 'actor_label', 'audit_direction' => $auditActorSort['next'], 'audit_page' => 1], '#audit-table-baseline') }}" @class(['ui-table-sort', 'is-active' => $auditActorSort['active']])>
                                    <span>Actor</span>
                                    <span class="sr-only">{{ $auditActorSort['sr_label'] }}</span>
                                    <span class="ui-table-sort-icon" aria-hidden="true">
                                        <x-dynamic-component :component="$auditActorSort['icon_component']" class="h-3.5 w-3.5" />
                                    </span>
                                </a>
                            </th>
                            <th class="px-5 py-3">Result</th>
                            <th class="px-5 py-3">Severity</th>
                            <th class="px-5 py-3" @if ($auditRouteSort['aria']) aria-sort="{{ $auditRouteSort['aria'] }}" @endif>
                                <a href="{{ $tablesUrl(['audit_sort' => 'route', 'audit_direction' => $auditRouteSort['next'], 'audit_page' => 1], '#audit-table-baseline') }}" @class(['ui-table-sort', 'is-active' => $auditRouteSort['active']])>
                                    <span>Route</span>
                                    <span class="sr-only">{{ $auditRouteSort['sr_label'] }}</span>
                                    <span class="ui-table-sort-icon" aria-hidden="true">
                                        <x-dynamic-component :component="$auditRouteSort['icon_component']" class="h-3.5 w-3.5" />
                                    </span>
                                </a>
                            </th>
                            <th class="px-5 py-3 sr-only">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 text-sm text-slate-200">
                        @forelse ($auditSamples as $sample)
                            <tr class="ui-table-row cursor-pointer" data-audit-log-row data-audit-log-url="{{ route('platform.ui-reference.audit-samples.show', $sample['sample_key']) }}">
                                <td class="px-5 py-3 text-slate-400">{{ $sample['occurred_at_label'] }}</td>
                                <td class="px-5 py-3 font-semibold text-white">{{ $sample['event_type'] }}</td>
                                <td class="px-5 py-3">{{ $sample['actor_label'] }}</td>
                                <td class="px-5 py-3"><x-ui.badge :status="$sample['result']" :show-icon="false" /></td>
                                <td class="px-5 py-3"><x-ui.badge :status="$sample['severity']" :show-icon="false" /></td>
                                <td class="px-5 py-3 text-slate-400">{{ $sample['route'] }}</td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('platform.ui-reference.audit-samples.show', $sample['sample_key']) }}" class="ui-action ui-action-primary" data-audit-log-view data-audit-log-url="{{ route('platform.ui-reference.audit-samples.show', $sample['sample_key']) }}">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-8 text-center text-sm text-slate-500">No audit demo rows matched the current filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-800 px-5 py-3">
                    <div class="flex items-center gap-3">
                        <p class="text-sm text-slate-400">Showing {{ $auditSamples->firstItem() ?? 0 }} to {{ $auditSamples->lastItem() ?? 0 }} of {{ $auditSamples->total() }} entries</p>
                    </div>

                    <div class="flex items-center gap-2">
                        @php($auditPrev = max(1, $auditSamples->currentPage() - 1))
                        @php($auditNext = min($auditSamples->lastPage(), $auditSamples->currentPage() + 1))
                        @if ($auditSamples->onFirstPage())
                            <span class="ui-pagination-control is-disabled" aria-disabled="true">Prev</span>
                        @else
                            <a href="{{ $auditSamples->url($auditPrev) }}" class="ui-pagination-control">Prev</a>
                        @endif

                        <form method="GET" action="{{ route('platform.ui-reference.patterns.tables') }}">
                            <input type="hidden" name="audit_severity" value="{{ $auditFilters['severity'] }}">
                            <input type="hidden" name="audit_result" value="{{ $auditFilters['result'] }}">
                            <input type="hidden" name="audit_search" value="{{ $auditFilters['search'] }}">
                            <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                            <input type="hidden" name="audit_sort" value="{{ $auditSort }}">
                            <input type="hidden" name="audit_direction" value="{{ $auditDirection }}">
                            <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                            <input type="hidden" name="error_per_page" value="{{ $errorPerPage }}">
                            <select name="audit_page" onchange="this.form.submit()" class="ui-select ui-select-compact rounded-lg text-xs font-semibold uppercase tracking-[0.1em] text-slate-200">
                                @for ($page = 1; $page <= $auditSamples->lastPage(); $page++)
                                    <option value="{{ $page }}" @selected($page === $auditSamples->currentPage())>Page {{ $page }}</option>
                                @endfor
                            </select>
                        </form>

                        @if ($auditSamples->hasMorePages())
                            <a href="{{ $auditSamples->url($auditNext) }}" class="ui-pagination-control">Next</a>
                        @else
                            <span class="ui-pagination-control is-disabled" aria-disabled="true">Next</span>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <section id="error-table-baseline" class="ui-card relative" data-table-section="error">
            <div class="pointer-events-none absolute inset-0 z-10 hidden items-center justify-center rounded-lg bg-slate-950/65" data-table-loading-overlay aria-hidden="true">
                <div class="rounded-lg border border-slate-800 bg-slate-900/90 px-5 py-4 text-center shadow-2xl shadow-black/30">
                    <span class="ui-spinner" aria-hidden="true"></span>
                    <p class="mt-3 text-sm font-semibold text-white">Refreshing error rows</p>
                    <p class="mt-1 text-xs text-slate-400">Applying the current table controls without a full page reload.</p>
                </div>
            </div>
            <div>
                <p class="ui-kicker">Logs Table</p>
                <h2 class="ui-card-title mt-2">Error Drawer Example</h2>
            </div>

            <div class="relative mt-4">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <form method="GET" action="{{ route('platform.ui-reference.patterns.tables') }}" class="flex items-center gap-3">
                        <input type="hidden" name="error_severity" value="{{ $errorFilters['severity'] }}">
                        <input type="hidden" name="error_environment" value="{{ $errorFilters['environment'] }}">
                        <input type="hidden" name="error_search" value="{{ $errorFilters['search'] }}">
                        <input type="hidden" name="error_sort" value="{{ $errorSort }}">
                        <input type="hidden" name="error_direction" value="{{ $errorDirection }}">
                        <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                        <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                        <label class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Rows</label>
                        <select name="error_per_page" onchange="this.form.submit()" class="ui-select ui-select-compact rounded-lg text-sm">
                            @foreach ([10, 25, 50, 100] as $option)
                                <option value="{{ $option }}" @selected($errorPerPage === $option)>{{ $option }}</option>
                            @endforeach
                        </select>
                    </form>

                    <div class="ml-auto flex max-w-full items-center justify-end gap-3">
                        <form method="GET" action="{{ route('platform.ui-reference.patterns.tables') }}#error-table-baseline" class="relative w-64 max-w-full flex-shrink-0" data-table-search-form>
                            <input type="hidden" name="error_severity" value="{{ $errorFilters['severity'] }}">
                            <input type="hidden" name="error_environment" value="{{ $errorFilters['environment'] }}">
                            <input type="hidden" name="error_per_page" value="{{ $errorPerPage }}">
                            <input type="hidden" name="error_sort" value="{{ $errorSort }}">
                            <input type="hidden" name="error_direction" value="{{ $errorDirection }}">
                            <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                            <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                            <label for="error-table-search" class="sr-only">Search error rows</label>
                            <span class="pointer-events-none absolute inset-y-0 left-0 inline-flex w-9 items-center justify-center text-slate-500">
                                <x-heroicon-o-magnifying-glass class="h-4 w-4" aria-hidden="true" />
                            </span>
                            <input
                                id="error-table-search"
                                type="text"
                                name="error_search"
                                value="{{ $errorFilters['search'] }}"
                                data-table-search-input
                                data-initial-search="{{ $errorFilters['search'] }}"
                                placeholder="Message, exception, route"
                                aria-label="Search error rows"
                                class="w-full rounded-md border border-slate-700 bg-slate-950 py-2 pl-9 pr-9 text-sm text-slate-100 placeholder:text-slate-500"
                            />
                            <button type="button" class="absolute inset-y-0 right-0 hidden w-9 items-center justify-center text-slate-500 transition hover:text-slate-300" data-table-search-clear aria-label="Clear search text">
                                <x-heroicon-o-x-mark class="h-4 w-4" aria-hidden="true" />
                            </button>
                            <button type="button" class="absolute inset-y-0 right-0 hidden w-9 items-center justify-center text-rose-500 transition hover:text-rose-400" data-table-search-reset aria-label="Reset applied search filter">
                                <x-heroicon-o-x-mark class="h-4 w-4" aria-hidden="true" />
                            </button>
                        </form>
                        <button type="button" class="ui-icon-button" data-filter-toggle aria-expanded="false" aria-label="Toggle error demo filters">
                            <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                        </button>
                    </div>
                </div>

                <form method="GET" action="{{ route('platform.ui-reference.patterns.tables') }}" class="ui-table-filter-panel hidden" data-filter-panel>
                    <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                    <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                    <input type="hidden" name="error_per_page" value="{{ $errorPerPage }}">
                    <input type="hidden" name="error_search" value="{{ $errorFilters['search'] }}">
                    <input type="hidden" name="error_sort" value="{{ $errorSort }}">
                    <input type="hidden" name="error_direction" value="{{ $errorDirection }}">
                    <div class="grid gap-4 md:grid-cols-2">
                    <label>
                        <span class="text-sm font-semibold text-slate-200">Severity</span>
                        <select name="error_severity" class="ui-select ui-select-compact mt-2 text-slate-100">
                            <option value="">Any</option>
                            <option value="warning" @selected($errorFilters['severity'] === 'warning')>Warning</option>
                            <option value="error" @selected($errorFilters['severity'] === 'error')>Error</option>
                        </select>
                    </label>
                    <label>
                        <span class="text-sm font-semibold text-slate-200">Environment</span>
                        <select name="error_environment" class="ui-select ui-select-compact mt-2 text-slate-100">
                            <option value="">Any</option>
                            <option value="staging" @selected($errorFilters['environment'] === 'staging')>Staging</option>
                            <option value="production" @selected($errorFilters['environment'] === 'production')>Production</option>
                        </select>
                    </label>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <button type="submit" class="ui-action ui-action-primary">Apply</button>
                        <a wire:navigate href="{{ route('platform.ui-reference.patterns.tables') }}" class="ui-action ui-action-ghost">Reset</a>
                    </div>
                </form>
            </div>

            <div class="mt-4 overflow-x-auto rounded-lg border border-slate-800 bg-slate-900/70">
                <table class="min-w-[920px] w-full divide-y divide-slate-800">
                    <thead class="bg-slate-900">
                        <tr class="text-left text-xs uppercase tracking-[0.2em] text-slate-500">
                            @php($errorOccurredSort = $sortMeta($errorSort, $errorDirection, 'occurred_at_timestamp', 'desc'))
                            @php($errorMessageSort = $sortMeta($errorSort, $errorDirection, 'message'))
                            @php($errorExceptionSort = $sortMeta($errorSort, $errorDirection, 'exception_class'))
                            @php($errorRequestSort = $sortMeta($errorSort, $errorDirection, 'request_id'))
                            <th class="px-5 py-3" @if ($errorOccurredSort['aria']) aria-sort="{{ $errorOccurredSort['aria'] }}" @endif>
                                <a href="{{ $tablesUrl(['error_sort' => 'occurred_at_timestamp', 'error_direction' => $errorOccurredSort['next'], 'error_page' => 1], '#error-table-baseline') }}" @class(['ui-table-sort', 'is-active' => $errorOccurredSort['active']])>
                                    <span>Occurred</span>
                                    <span class="sr-only">{{ $errorOccurredSort['sr_label'] }}</span>
                                    <span class="ui-table-sort-icon" aria-hidden="true">
                                        <x-dynamic-component :component="$errorOccurredSort['icon_component']" class="h-3.5 w-3.5" />
                                    </span>
                                </a>
                            </th>
                            <th class="px-5 py-3" @if ($errorMessageSort['aria']) aria-sort="{{ $errorMessageSort['aria'] }}" @endif>
                                <a href="{{ $tablesUrl(['error_sort' => 'message', 'error_direction' => $errorMessageSort['next'], 'error_page' => 1], '#error-table-baseline') }}" @class(['ui-table-sort', 'is-active' => $errorMessageSort['active']])>
                                    <span>Message</span>
                                    <span class="sr-only">{{ $errorMessageSort['sr_label'] }}</span>
                                    <span class="ui-table-sort-icon" aria-hidden="true">
                                        <x-dynamic-component :component="$errorMessageSort['icon_component']" class="h-3.5 w-3.5" />
                                    </span>
                                </a>
                            </th>
                            <th class="px-5 py-3" @if ($errorExceptionSort['aria']) aria-sort="{{ $errorExceptionSort['aria'] }}" @endif>
                                <a href="{{ $tablesUrl(['error_sort' => 'exception_class', 'error_direction' => $errorExceptionSort['next'], 'error_page' => 1], '#error-table-baseline') }}" @class(['ui-table-sort', 'is-active' => $errorExceptionSort['active']])>
                                    <span>Exception</span>
                                    <span class="sr-only">{{ $errorExceptionSort['sr_label'] }}</span>
                                    <span class="ui-table-sort-icon" aria-hidden="true">
                                        <x-dynamic-component :component="$errorExceptionSort['icon_component']" class="h-3.5 w-3.5" />
                                    </span>
                                </a>
                            </th>
                            <th class="px-5 py-3">Severity</th>
                            <th class="px-5 py-3">Environment</th>
                            <th class="px-5 py-3" @if ($errorRequestSort['aria']) aria-sort="{{ $errorRequestSort['aria'] }}" @endif>
                                <a href="{{ $tablesUrl(['error_sort' => 'request_id', 'error_direction' => $errorRequestSort['next'], 'error_page' => 1], '#error-table-baseline') }}" @class(['ui-table-sort', 'is-active' => $errorRequestSort['active']])>
                                    <span>Request</span>
                                    <span class="sr-only">{{ $errorRequestSort['sr_label'] }}</span>
                                    <span class="ui-table-sort-icon" aria-hidden="true">
                                        <x-dynamic-component :component="$errorRequestSort['icon_component']" class="h-3.5 w-3.5" />
                                    </span>
                                </a>
                            </th>
                            <th class="px-5 py-3 sr-only">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 text-sm text-slate-200">
                        @forelse ($errorSamples as $sample)
                            <tr class="ui-table-row cursor-pointer" data-error-log-row data-error-log-url="{{ route('platform.ui-reference.error-samples.show', $sample['sample_key']) }}">
                                <td class="px-5 py-3 text-slate-400">{{ $sample['occurred_at_label'] }}</td>
                                <td class="px-5 py-3 font-semibold text-white">{{ $sample['message'] }}</td>
                                <td class="px-5 py-3">{{ $sample['exception_class'] }}</td>
                                <td class="px-5 py-3"><x-ui.badge :status="$sample['severity']" :show-icon="false" /></td>
                                <td class="px-5 py-3 text-slate-400">{{ $sample['environment'] }}</td>
                                <td class="px-5 py-3 text-slate-400">{{ $sample['request_id'] }}</td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('platform.ui-reference.error-samples.show', $sample['sample_key']) }}" class="ui-action ui-action-primary" data-error-log-view data-error-log-url="{{ route('platform.ui-reference.error-samples.show', $sample['sample_key']) }}">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-8 text-center text-sm text-slate-500">No error demo rows matched the current filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-800 px-5 py-3">
                    <div class="flex items-center gap-3">
                        <p class="text-sm text-slate-400">Showing {{ $errorSamples->firstItem() ?? 0 }} to {{ $errorSamples->lastItem() ?? 0 }} of {{ $errorSamples->total() }} entries</p>
                    </div>

                    <div class="flex items-center gap-2">
                        @php($errorPrev = max(1, $errorSamples->currentPage() - 1))
                        @php($errorNext = min($errorSamples->lastPage(), $errorSamples->currentPage() + 1))
                        @if ($errorSamples->onFirstPage())
                            <span class="ui-pagination-control is-disabled" aria-disabled="true">Prev</span>
                        @else
                            <a href="{{ $errorSamples->url($errorPrev) }}" class="ui-pagination-control">Prev</a>
                        @endif

                        <form method="GET" action="{{ route('platform.ui-reference.patterns.tables') }}">
                            <input type="hidden" name="error_severity" value="{{ $errorFilters['severity'] }}">
                            <input type="hidden" name="error_environment" value="{{ $errorFilters['environment'] }}">
                            <input type="hidden" name="error_search" value="{{ $errorFilters['search'] }}">
                            <input type="hidden" name="error_per_page" value="{{ $errorPerPage }}">
                            <input type="hidden" name="error_sort" value="{{ $errorSort }}">
                            <input type="hidden" name="error_direction" value="{{ $errorDirection }}">
                            <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                            <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                            <select name="error_page" onchange="this.form.submit()" class="ui-select ui-select-compact rounded-lg text-xs font-semibold uppercase tracking-[0.1em] text-slate-200">
                                @for ($page = 1; $page <= $errorSamples->lastPage(); $page++)
                                    <option value="{{ $page }}" @selected($page === $errorSamples->currentPage())>Page {{ $page }}</option>
                                @endfor
                            </select>
                        </form>

                        @if ($errorSamples->hasMorePages())
                            <a href="{{ $errorSamples->url($errorNext) }}" class="ui-pagination-control">Next</a>
                        @else
                            <span class="ui-pagination-control is-disabled" aria-disabled="true">Next</span>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <div class="fixed inset-0 z-50 hidden bg-black/60" data-audit-log-modal aria-hidden="true">
            <div class="ui-log-drawer-panel" data-log-drawer-panel tabindex="-1" role="dialog" aria-modal="true" aria-labelledby="audit-log-drawer-title">
                <div class="flex items-start justify-between gap-3 border-b border-slate-800 px-6 py-5">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Audit Log Detail</p>
                        <h2 id="audit-log-drawer-title" class="mt-2 text-2xl font-semibold text-white" data-audit-log-title>—</h2>
                        <p class="mt-2 text-sm text-slate-400" data-audit-log-subtitle>—</p>
                    </div>
                    <button type="button" class="ui-action ui-action-outline" data-audit-log-close>Close</button>
                </div>

                <div class="overflow-y-auto px-6 py-6">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                            <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Summary</h3>
                            <dl class="mt-3 space-y-2 text-sm text-slate-300">
                                <div class="flex items-center justify-between"><dt>Occurred</dt><dd data-audit-log-occurred>—</dd></div>
                                <div class="flex items-center justify-between"><dt>Result</dt><dd data-audit-log-result>—</dd></div>
                                <div class="flex items-center justify-between"><dt>Severity</dt><dd data-audit-log-severity>—</dd></div>
                                <div class="flex items-center justify-between"><dt>Action</dt><dd data-audit-log-action>—</dd></div>
                            </dl>
                        </div>

                        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                            <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Actor</h3>
                            <dl class="mt-3 space-y-2 text-sm text-slate-300">
                                <div><dt>Name</dt><dd data-audit-log-actor-name>—</dd></div>
                                <div><dt>Email</dt><dd data-audit-log-actor-email>—</dd></div>
                            </dl>
                        </div>
                    </div>

                    <div class="mt-4 rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Request Context</h3>
                        <dl class="mt-3 grid gap-2 text-sm text-slate-300 md:grid-cols-2">
                            <div><dt>Route</dt><dd data-audit-log-route>—</dd></div>
                            <div><dt>Method</dt><dd data-audit-log-method>—</dd></div>
                            <div><dt>Request ID</dt><dd class="break-all" data-audit-log-request>—</dd></div>
                            <div><dt>Trace ID</dt><dd class="break-all" data-audit-log-trace>—</dd></div>
                            <div><dt>IP</dt><dd data-audit-log-ip>—</dd></div>
                            <div><dt>Subject</dt><dd data-audit-log-subject>—</dd></div>
                        </dl>
                    </div>

                    <div class="mt-4 rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Metadata</h3>
                        <pre class="mt-2 max-h-64 overflow-y-auto whitespace-pre-wrap text-xs text-slate-300" data-audit-log-metadata>—</pre>
                    </div>
                </div>
            </div>
        </div>

        <div class="fixed inset-0 z-50 hidden bg-black/60" data-error-log-modal aria-hidden="true">
            <div class="ui-log-drawer-panel" data-log-drawer-panel tabindex="-1" role="dialog" aria-modal="true" aria-labelledby="error-log-drawer-title">
                <div class="flex items-start justify-between gap-3 border-b border-slate-800 px-6 py-5">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Error Log Detail</p>
                        <h2 id="error-log-drawer-title" class="mt-2 text-2xl font-semibold text-white" data-error-log-title>—</h2>
                        <p class="mt-2 text-sm text-slate-400" data-error-log-subtitle>—</p>
                    </div>
                    <button type="button" class="ui-action ui-action-outline" data-error-log-close>Close</button>
                </div>

                <div class="overflow-y-auto px-6 py-6">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                            <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Summary</h3>
                            <dl class="mt-3 space-y-2 text-sm text-slate-300">
                                <div class="flex items-center justify-between"><dt>Occurred</dt><dd data-error-log-occurred>—</dd></div>
                                <div class="flex items-center justify-between"><dt>Severity</dt><dd data-error-log-severity>—</dd></div>
                                <div class="flex items-center justify-between"><dt>Handled</dt><dd data-error-log-handled>—</dd></div>
                                <div class="flex items-center justify-between"><dt>Environment</dt><dd data-error-log-environment>—</dd></div>
                            </dl>
                        </div>

                        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                            <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Exception</h3>
                            <dl class="mt-3 space-y-2 text-sm text-slate-300">
                                <div><dt>Class</dt><dd data-error-log-exception>—</dd></div>
                                <div><dt>Code</dt><dd data-error-log-code>—</dd></div>
                                <div><dt>File</dt><dd class="break-all" data-error-log-file>—</dd></div>
                            </dl>
                        </div>
                    </div>

                    <div class="mt-4 rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Request Context</h3>
                        <dl class="mt-3 grid gap-2 text-sm text-slate-300 md:grid-cols-2">
                            <div><dt>Route</dt><dd data-error-log-route>—</dd></div>
                            <div><dt>Method</dt><dd data-error-log-method>—</dd></div>
                            <div><dt>Status</dt><dd data-error-log-status>—</dd></div>
                            <div><dt>User</dt><dd data-error-log-user>—</dd></div>
                            <div><dt>Request ID</dt><dd class="break-all" data-error-log-request>—</dd></div>
                            <div><dt>Trace ID</dt><dd class="break-all" data-error-log-trace>—</dd></div>
                            <div><dt>IP</dt><dd data-error-log-ip>—</dd></div>
                            <div><dt>Host</dt><dd data-error-log-host>—</dd></div>
                        </dl>
                    </div>

                    <div class="mt-4 rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Message</h3>
                        <p class="mt-2 text-sm text-slate-300" data-error-log-message>—</p>
                    </div>

                    <div class="mt-4 rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Stack Trace</h3>
                        <pre class="mt-2 max-h-56 overflow-y-auto whitespace-pre-wrap text-xs text-slate-300" data-error-log-trace-stack>—</pre>
                    </div>

                    <div class="mt-4 rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Context</h3>
                        <pre class="mt-2 max-h-56 overflow-y-auto whitespace-pre-wrap text-xs text-slate-300" data-error-log-context>—</pre>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
