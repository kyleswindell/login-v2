        <section class="ui-card">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <p class="ui-kicker">Logs Table</p>
                    <h2 class="ui-card-title mt-2">Error Drawer Example</h2>
                </div>
                <button type="button" class="ui-icon-button" data-filter-toggle aria-expanded="false" aria-label="Toggle error demo filters">
                    <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                </button>
            </div>

            <form method="GET" action="{{ route('platform.ui-reference.index') }}" class="mt-4 hidden ui-reference-example-surface p-5" data-filter-panel>
                <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                <div class="grid gap-4 md:grid-cols-3">
                    <label>
                        <span class="text-sm font-semibold ui-reference-text-strong">Severity</span>
                        <select name="error_severity" class="ui-select mt-2">
                            <option value="">Any</option>
                            <option value="warning" @selected($errorFilters['severity'] === 'warning')>Warning</option>
                            <option value="error" @selected($errorFilters['severity'] === 'error')>Error</option>
                        </select>
                    </label>
                    <label>
                        <span class="text-sm font-semibold ui-reference-text-strong">Environment</span>
                        <select name="error_environment" class="ui-select mt-2">
                            <option value="">Any</option>
                            <option value="staging" @selected($errorFilters['environment'] === 'staging')>Staging</option>
                            <option value="production" @selected($errorFilters['environment'] === 'production')>Production</option>
                        </select>
                    </label>
                    <label>
                        <span class="text-sm font-semibold ui-reference-text-strong">Search</span>
                        <input type="text" name="error_search" value="{{ $errorFilters['search'] }}" placeholder="Message, exception, route" class="ui-input mt-2" />
                    </label>
                </div>
                <div class="mt-4 flex flex-wrap gap-3">
                    <button type="submit" class="ui-action ui-action-primary">Apply</button>
                    <a wire:navigate href="{{ route('platform.ui-reference.index') }}" class="ui-action ui-action-ghost">Reset</a>
                </div>
            </form>

            <div class="mt-4 ui-reference-table-shell overflow-x-auto">
                <table class="min-w-[920px] w-full ui-reference-table-body">
                    <thead class="ui-reference-table-head">
                        <tr class="text-left text-xs uppercase tracking-[0.2em] ui-reference-text-muted">
                            <th class="px-5 py-3">Occurred</th>
                            <th class="px-5 py-3">Message</th>
                            <th class="px-5 py-3">Exception</th>
                            <th class="px-5 py-3">Severity</th>
                            <th class="px-5 py-3">Environment</th>
                            <th class="px-5 py-3">Request</th>
                            <th class="px-5 py-3 sr-only">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="ui-reference-table-body text-sm ui-reference-text-strong">
                        @forelse ($errorSamples as $sample)
                            <tr class="ui-reference-table-row cursor-pointer transition" data-error-log-row data-error-log-url="{{ route('platform.ui-reference.error-samples.show', $sample['sample_key']) }}">
                                <td class="px-5 py-3 ui-reference-text-muted">{{ $sample['occurred_at_label'] }}</td>
                                <td class="px-5 py-3 font-semibold ui-reference-text-strong">{{ $sample['message'] }}</td>
                                <td class="px-5 py-3">{{ $sample['exception_class'] }}</td>
                                <td class="px-5 py-3"><x-ui.badge :label="$sample['severity']" semantic="danger" :show-icon="false" /></td>
                                <td class="px-5 py-3 ui-reference-text-muted">{{ $sample['environment'] }}</td>
                                <td class="px-5 py-3 ui-reference-text-muted">{{ $sample['request_id'] }}</td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('platform.ui-reference.error-samples.show', $sample['sample_key']) }}" class="ui-action ui-action-primary" data-error-log-view data-error-log-url="{{ route('platform.ui-reference.error-samples.show', $sample['sample_key']) }}">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-8 text-center text-sm ui-reference-text-muted">No error demo rows matched the current filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="flex flex-wrap items-center justify-between gap-3 border-t ui-reference-border px-5 py-3">
                    <div class="flex items-center gap-3">
                        <form method="GET" action="{{ route('platform.ui-reference.index') }}" class="flex items-center gap-3">
                            <input type="hidden" name="error_severity" value="{{ $errorFilters['severity'] }}">
                            <input type="hidden" name="error_environment" value="{{ $errorFilters['environment'] }}">
                            <input type="hidden" name="error_search" value="{{ $errorFilters['search'] }}">
                            <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                            <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                            <label class="text-xs font-semibold uppercase tracking-[0.2em] ui-reference-text-muted">Rows</label>
                            <select name="error_per_page" onchange="this.form.submit()" class="ui-select !w-auto px-3 py-2 text-sm">
                                @foreach ([10, 25, 50, 100] as $option)
                                    <option value="{{ $option }}" @selected($errorPerPage === $option)>{{ $option }}</option>
                                @endforeach
                            </select>
                        </form>
                        <p class="text-sm ui-reference-text-muted">Showing {{ $errorSamples->firstItem() ?? 0 }} to {{ $errorSamples->lastItem() ?? 0 }} of {{ $errorSamples->total() }} entries</p>
                    </div>

                    <div class="flex items-center gap-2">
                        @php($errorPrev = max(1, $errorSamples->currentPage() - 1))
                        @php($errorNext = min($errorSamples->lastPage(), $errorSamples->currentPage() + 1))
                        <a href="{{ $errorSamples->onFirstPage() ? '#' : $errorSamples->url($errorPrev) }}" @class([
                            'ui-action ui-action-xs',
                            'ui-action-ghost' => ! $errorSamples->onFirstPage(),
                            'cursor-not-allowed opacity-60' => $errorSamples->onFirstPage(),
                        ])>Prev</a>

                        <form method="GET" action="{{ route('platform.ui-reference.index') }}">
                            <input type="hidden" name="error_severity" value="{{ $errorFilters['severity'] }}">
                            <input type="hidden" name="error_environment" value="{{ $errorFilters['environment'] }}">
                            <input type="hidden" name="error_search" value="{{ $errorFilters['search'] }}">
                            <input type="hidden" name="error_per_page" value="{{ $errorPerPage }}">
                            <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                            <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                            <select name="error_page" onchange="this.form.submit()" class="ui-select !w-auto px-3 py-2 text-xs font-semibold uppercase tracking-[0.1em]">
                                @for ($page = 1; $page <= $errorSamples->lastPage(); $page++)
                                    <option value="{{ $page }}" @selected($page === $errorSamples->currentPage())>Page {{ $page }}</option>
                                @endfor
                            </select>
                        </form>

                        <a href="{{ $errorSamples->hasMorePages() ? $errorSamples->url($errorNext) : '#' }}" @class([
                            'ui-action ui-action-xs',
                            'ui-action-ghost' => $errorSamples->hasMorePages(),
                            'cursor-not-allowed opacity-60' => ! $errorSamples->hasMorePages(),
                        ])>Next</a>
                    </div>
                </div>
            </div>
        </section>
