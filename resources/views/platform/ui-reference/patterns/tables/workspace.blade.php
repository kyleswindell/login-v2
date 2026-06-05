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
