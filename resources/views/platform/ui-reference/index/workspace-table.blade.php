        <section class="ui-card">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <p class="ui-kicker">General Table</p>
                    <h2 class="ui-card-title mt-2">Operator Data Grid Baseline</h2>
                </div>
                <button type="button" class="ui-icon-button" data-filter-toggle aria-expanded="false" aria-label="Toggle workspace filters">
                    <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                </button>
            </div>

            <div class="mt-4 flex flex-wrap gap-3">
                <button type="button" class="ui-action ui-action-primary">Create</button>
                <button type="button" class="ui-action ui-action-warning">Settings</button>
                <button type="button" class="ui-action">Export</button>
            </div>

            <form method="GET" action="{{ route('platform.ui-reference.index') }}" class="mt-4 hidden ui-reference-example-surface p-5" data-filter-panel>
                <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                <input type="hidden" name="error_per_page" value="{{ $errorPerPage }}">
                <div class="grid gap-4 md:grid-cols-3">
                    <label>
                        <span class="text-sm font-semibold ui-reference-text-strong">Status</span>
                        <select name="workspace_status" class="ui-select mt-2">
                            <option value="">Any</option>
                            <option value="active" @selected($workspaceFilters['status'] === 'active')>Active</option>
                            <option value="review" @selected($workspaceFilters['status'] === 'review')>Review</option>
                            <option value="disabled" @selected($workspaceFilters['status'] === 'disabled')>Disabled</option>
                        </select>
                    </label>
                    <label>
                        <span class="text-sm font-semibold ui-reference-text-strong">Owner</span>
                        <select name="workspace_owner" class="ui-select mt-2">
                            <option value="">Any</option>
                            @foreach (['Platform Team', 'Security', 'Operations', 'Docs Team'] as $owner)
                                <option value="{{ $owner }}" @selected($workspaceFilters['owner'] === $owner)>{{ $owner }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label>
                        <span class="text-sm font-semibold ui-reference-text-strong">Search</span>
                        <input type="text" name="workspace_search" value="{{ $workspaceFilters['search'] }}" placeholder="Search name or owner" class="ui-input mt-2" />
                    </label>
                </div>
                <div class="mt-4 flex flex-wrap gap-3">
                    <button type="submit" class="ui-action ui-action-primary">Apply</button>
                    <a wire:navigate href="{{ route('platform.ui-reference.index') }}" class="ui-action ui-action-ghost">Reset</a>
                </div>
            </form>

            <div class="mt-4 ui-reference-table-shell overflow-x-auto">
                <table class="min-w-[760px] w-full ui-reference-table-body">
                    <thead class="ui-reference-table-head">
                        <tr class="text-left text-xs uppercase tracking-[0.2em] ui-reference-text-muted">
                            <th class="px-5 py-3">Name</th>
                            <th class="px-5 py-3">Owner</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Updated</th>
                            <th class="px-5 py-3 sr-only">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="ui-reference-table-body text-sm ui-reference-text-strong">
                        @forelse ($workspaceRows as $row)
                            <tr>
                                <td class="px-5 py-3 font-semibold ui-reference-text-strong">{{ $row['name'] }}</td>
                                <td class="px-5 py-3">{{ $row['owner'] }}</td>
                                <td class="px-5 py-3">
                                    <x-ui.badge
                                        :label="$row['status']"
                                        :semantic="match ($row['status']) { 'active' => 'success', 'review' => 'notice', 'disabled' => 'danger', default => 'neutral' }"
                                        :show-icon="false"
                                    />
                                </td>
                                <td class="px-5 py-3 ui-reference-text-muted">{{ $row['updated_at_label'] }}</td>
                                <td class="px-5 py-3 text-right"><button type="button" class="ui-action ui-action-primary">View</button></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-8 text-center text-sm ui-reference-text-muted">No workspace rows matched the current filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="flex flex-wrap items-center justify-between gap-3 border-t ui-reference-border px-5 py-3">
                    <div class="flex items-center gap-3">
                        <form method="GET" action="{{ route('platform.ui-reference.index') }}" class="flex items-center gap-3">
                            <input type="hidden" name="workspace_status" value="{{ $workspaceFilters['status'] }}">
                            <input type="hidden" name="workspace_owner" value="{{ $workspaceFilters['owner'] }}">
                            <input type="hidden" name="workspace_search" value="{{ $workspaceFilters['search'] }}">
                            <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                            <input type="hidden" name="error_per_page" value="{{ $errorPerPage }}">
                            <label class="text-xs font-semibold uppercase tracking-[0.2em] ui-reference-text-muted">Rows</label>
                            <select name="workspace_per_page" onchange="this.form.submit()" class="ui-select !w-auto px-3 py-2 text-sm">
                                @foreach ([10, 25, 50, 100] as $option)
                                    <option value="{{ $option }}" @selected($workspacePerPage === $option)>{{ $option }}</option>
                                @endforeach
                            </select>
                        </form>

                        <p class="text-sm ui-reference-text-muted">Showing {{ $workspaceRows->firstItem() ?? 0 }} to {{ $workspaceRows->lastItem() ?? 0 }} of {{ $workspaceRows->total() }} entries</p>
                    </div>

                    <div class="flex items-center gap-2">
                        @php($workspacePrev = max(1, $workspaceRows->currentPage() - 1))
                        @php($workspaceNext = min($workspaceRows->lastPage(), $workspaceRows->currentPage() + 1))

                        <a href="{{ $workspaceRows->onFirstPage() ? '#' : $workspaceRows->url($workspacePrev) }}" @class([
                            'ui-action ui-action-xs',
                            'ui-action-ghost' => ! $workspaceRows->onFirstPage(),
                            'cursor-not-allowed opacity-60' => $workspaceRows->onFirstPage(),
                        ])>Prev</a>

                        <form method="GET" action="{{ route('platform.ui-reference.index') }}">
                            <input type="hidden" name="workspace_status" value="{{ $workspaceFilters['status'] }}">
                            <input type="hidden" name="workspace_owner" value="{{ $workspaceFilters['owner'] }}">
                            <input type="hidden" name="workspace_search" value="{{ $workspaceFilters['search'] }}">
                            <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                            <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                            <input type="hidden" name="error_per_page" value="{{ $errorPerPage }}">
                            <select name="workspace_page" onchange="this.form.submit()" class="ui-select !w-auto px-3 py-2 text-xs font-semibold uppercase tracking-[0.1em]">
                                @for ($page = 1; $page <= $workspaceRows->lastPage(); $page++)
                                    <option value="{{ $page }}" @selected($page === $workspaceRows->currentPage())>Page {{ $page }}</option>
                                @endfor
                            </select>
                        </form>

                        <a href="{{ $workspaceRows->hasMorePages() ? $workspaceRows->url($workspaceNext) : '#' }}" @class([
                            'ui-action ui-action-xs',
                            'ui-action-ghost' => $workspaceRows->hasMorePages(),
                            'cursor-not-allowed opacity-60' => ! $workspaceRows->hasMorePages(),
                        ])>Next</a>
                    </div>
                </div>
            </div>
        </section>
