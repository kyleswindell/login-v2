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
