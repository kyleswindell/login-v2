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
