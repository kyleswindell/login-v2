<x-layouts.app title="UI Reference · Table Baselines">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.tables'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">Table Baselines</h1>
            <p class="ui-page-header-copy">Tier 1 contract for filters, pagination, rows-per-page controls, empty states, and log drawer interactions.</p>
        </div>

        <section class="ui-card">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <p class="ui-kicker">General Table</p>
                    <h2 class="ui-card-title mt-2">Operator Data Grid Baseline</h2>
                </div>
                <button type="button" class="ui-icon-button" data-filter-toggle aria-expanded="false" aria-label="Toggle workspace filters">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                        <path fill-rule="evenodd" d="M2.5 4.75A.75.75 0 0 1 3.25 4h13.5a.75.75 0 0 1 .53 1.28L12 10.56v4.19a.75.75 0 0 1-.44.68l-3 1.333A.75.75 0 0 1 7.5 16V10.56L2.22 5.28a.75.75 0 0 1 .28-1.28Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div class="mt-4 flex flex-wrap gap-3">
                <button type="button" class="ui-action ui-action-primary">Create</button>
                <button type="button" class="ui-action ui-action-warning">Settings</button>
                <button type="button" class="ui-action">Export</button>
            </div>

            <form method="GET" action="{{ route('platform.ui-reference.patterns.tables') }}" class="mt-4 hidden rounded-lg border border-slate-800 bg-slate-900/70 p-5" data-filter-panel>
                <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                <input type="hidden" name="error_per_page" value="{{ $errorPerPage }}">
                <div class="grid gap-4 md:grid-cols-3">
                    <label>
                        <span class="text-sm font-semibold text-slate-200">Status</span>
                        <select name="workspace_status" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-3 py-2.5 text-slate-100">
                            <option value="">Any</option>
                            <option value="active" @selected($workspaceFilters['status'] === 'active')>Active</option>
                            <option value="review" @selected($workspaceFilters['status'] === 'review')>Review</option>
                            <option value="disabled" @selected($workspaceFilters['status'] === 'disabled')>Disabled</option>
                        </select>
                    </label>
                    <label>
                        <span class="text-sm font-semibold text-slate-200">Owner</span>
                        <select name="workspace_owner" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-3 py-2.5 text-slate-100">
                            <option value="">Any</option>
                            @foreach (['Platform Team', 'Security', 'Operations', 'Docs Team'] as $owner)
                                <option value="{{ $owner }}" @selected($workspaceFilters['owner'] === $owner)>{{ $owner }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label>
                        <span class="text-sm font-semibold text-slate-200">Search</span>
                        <input type="text" name="workspace_search" value="{{ $workspaceFilters['search'] }}" placeholder="Search name or owner" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-3 py-2.5 text-slate-100 placeholder:text-slate-500" />
                    </label>
                </div>
                <div class="mt-4 flex flex-wrap gap-3">
                    <button type="submit" class="ui-action ui-action-primary">Apply</button>
                    <a wire:navigate href="{{ route('platform.ui-reference.patterns.tables') }}" class="ui-action ui-action-ghost">Reset</a>
                </div>
            </form>

            <div class="mt-4 overflow-x-auto rounded-lg border border-slate-800 bg-slate-900/70">
                <table class="min-w-[760px] w-full divide-y divide-slate-800">
                    <thead class="bg-slate-900">
                        <tr class="text-left text-xs uppercase tracking-[0.2em] text-slate-500">
                            <th class="px-5 py-3">Name</th>
                            <th class="px-5 py-3">Owner</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Updated</th>
                            <th class="px-5 py-3 sr-only">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 text-sm text-slate-200">
                        @forelse ($workspaceRows as $row)
                            <tr>
                                <td class="px-5 py-3 font-semibold text-white">{{ $row['name'] }}</td>
                                <td class="px-5 py-3">{{ $row['owner'] }}</td>
                                <td class="px-5 py-3">
                                    <span @class([
                                        'rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em]',
                                        'bg-emerald-500/15 text-emerald-300' => $row['status'] === 'active',
                                        'bg-amber-500/15 text-amber-300' => $row['status'] === 'review',
                                        'bg-rose-500/15 text-rose-300' => $row['status'] === 'disabled',
                                    ])>{{ $row['status'] }}</span>
                                </td>
                                <td class="px-5 py-3 text-slate-400">{{ $row['updated_at_label'] }}</td>
                                <td class="px-5 py-3 text-right"><button type="button" class="ui-action ui-action-primary">View</button></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-8 text-center text-sm text-slate-500">No workspace rows matched the current filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-800 px-5 py-3">
                    <div class="flex items-center gap-3">
                        <form method="GET" action="{{ route('platform.ui-reference.patterns.tables') }}" class="flex items-center gap-3">
                            <input type="hidden" name="workspace_status" value="{{ $workspaceFilters['status'] }}">
                            <input type="hidden" name="workspace_owner" value="{{ $workspaceFilters['owner'] }}">
                            <input type="hidden" name="workspace_search" value="{{ $workspaceFilters['search'] }}">
                            <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                            <input type="hidden" name="error_per_page" value="{{ $errorPerPage }}">
                            <label class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Rows</label>
                            <select name="workspace_per_page" onchange="this.form.submit()" class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-100">
                                @foreach ([10, 25, 50, 100] as $option)
                                    <option value="{{ $option }}" @selected($workspacePerPage === $option)>{{ $option }}</option>
                                @endforeach
                            </select>
                        </form>

                        <p class="text-sm text-slate-400">Showing {{ $workspaceRows->firstItem() ?? 0 }} to {{ $workspaceRows->lastItem() ?? 0 }} of {{ $workspaceRows->total() }} entries</p>
                    </div>

                    <div class="flex items-center gap-2">
                        @php($workspacePrev = max(1, $workspaceRows->currentPage() - 1))
                        @php($workspaceNext = min($workspaceRows->lastPage(), $workspaceRows->currentPage() + 1))

                        <a href="{{ $workspaceRows->onFirstPage() ? '#' : $workspaceRows->url($workspacePrev) }}" @class([
                            'rounded-lg border px-3 py-2 text-xs font-semibold uppercase tracking-[0.15em] transition',
                            'border-slate-700 text-slate-300 hover:border-slate-600 hover:text-white' => ! $workspaceRows->onFirstPage(),
                            'cursor-not-allowed border-slate-800 text-slate-600' => $workspaceRows->onFirstPage(),
                        ])>Prev</a>

                        <form method="GET" action="{{ route('platform.ui-reference.patterns.tables') }}">
                            <input type="hidden" name="workspace_status" value="{{ $workspaceFilters['status'] }}">
                            <input type="hidden" name="workspace_owner" value="{{ $workspaceFilters['owner'] }}">
                            <input type="hidden" name="workspace_search" value="{{ $workspaceFilters['search'] }}">
                            <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                            <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                            <input type="hidden" name="error_per_page" value="{{ $errorPerPage }}">
                            <select name="workspace_page" onchange="this.form.submit()" class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-xs font-semibold uppercase tracking-[0.1em] text-slate-200">
                                @for ($page = 1; $page <= $workspaceRows->lastPage(); $page++)
                                    <option value="{{ $page }}" @selected($page === $workspaceRows->currentPage())>Page {{ $page }}</option>
                                @endfor
                            </select>
                        </form>

                        <a href="{{ $workspaceRows->hasMorePages() ? $workspaceRows->url($workspaceNext) : '#' }}" @class([
                            'rounded-lg border px-3 py-2 text-xs font-semibold uppercase tracking-[0.15em] transition',
                            'border-slate-700 text-slate-300 hover:border-slate-600 hover:text-white' => $workspaceRows->hasMorePages(),
                            'cursor-not-allowed border-slate-800 text-slate-600' => ! $workspaceRows->hasMorePages(),
                        ])>Next</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="ui-card">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <p class="ui-kicker">Logs Table</p>
                    <h2 class="ui-card-title mt-2">Audit Drawer Example</h2>
                    <p class="ui-card-copy">Row clicks and explicit `View` actions both open the right-side drawer.</p>
                </div>
                <button type="button" class="ui-icon-button" data-filter-toggle aria-expanded="false" aria-label="Toggle audit demo filters">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                        <path fill-rule="evenodd" d="M2.5 4.75A.75.75 0 0 1 3.25 4h13.5a.75.75 0 0 1 .53 1.28L12 10.56v4.19a.75.75 0 0 1-.44.68l-3 1.333A.75.75 0 0 1 7.5 16V10.56L2.22 5.28a.75.75 0 0 1 .28-1.28Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <form method="GET" action="{{ route('platform.ui-reference.patterns.tables') }}" class="mt-4 hidden rounded-lg border border-slate-800 bg-slate-900/70 p-5" data-filter-panel>
                <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                <input type="hidden" name="error_per_page" value="{{ $errorPerPage }}">
                <div class="grid gap-4 md:grid-cols-3">
                    <label>
                        <span class="text-sm font-semibold text-slate-200">Severity</span>
                        <select name="audit_severity" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-3 py-2.5 text-slate-100">
                            <option value="">Any</option>
                            <option value="info" @selected($auditFilters['severity'] === 'info')>Info</option>
                            <option value="notice" @selected($auditFilters['severity'] === 'notice')>Notice</option>
                        </select>
                    </label>
                    <label>
                        <span class="text-sm font-semibold text-slate-200">Result</span>
                        <select name="audit_result" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-3 py-2.5 text-slate-100">
                            <option value="">Any</option>
                            <option value="success" @selected($auditFilters['result'] === 'success')>Success</option>
                        </select>
                    </label>
                    <label>
                        <span class="text-sm font-semibold text-slate-200">Search</span>
                        <input type="text" name="audit_search" value="{{ $auditFilters['search'] }}" placeholder="Event, actor, route" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-3 py-2.5 text-slate-100 placeholder:text-slate-500" />
                    </label>
                </div>
                <div class="mt-4 flex flex-wrap gap-3">
                    <button type="submit" class="ui-action ui-action-primary">Apply</button>
                    <a wire:navigate href="{{ route('platform.ui-reference.patterns.tables') }}" class="ui-action ui-action-ghost">Reset</a>
                </div>
            </form>

            <div class="mt-4 overflow-x-auto rounded-lg border border-slate-800 bg-slate-900/70">
                <table class="min-w-[920px] w-full divide-y divide-slate-800">
                    <thead class="bg-slate-900">
                        <tr class="text-left text-xs uppercase tracking-[0.2em] text-slate-500">
                            <th class="px-5 py-3">Occurred</th>
                            <th class="px-5 py-3">Event</th>
                            <th class="px-5 py-3">Actor</th>
                            <th class="px-5 py-3">Result</th>
                            <th class="px-5 py-3">Severity</th>
                            <th class="px-5 py-3">Route</th>
                            <th class="px-5 py-3 sr-only">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 text-sm text-slate-200">
                        @forelse ($auditSamples as $sample)
                            <tr class="cursor-pointer transition hover:bg-slate-950/40" data-audit-log-row data-audit-log-url="{{ route('platform.ui-reference.audit-samples.show', $sample['sample_key']) }}">
                                <td class="px-5 py-3 text-slate-400">{{ $sample['occurred_at_label'] }}</td>
                                <td class="px-5 py-3 font-semibold text-white">{{ $sample['event_type'] }}</td>
                                <td class="px-5 py-3">{{ $sample['actor_label'] }}</td>
                                <td class="px-5 py-3"><span class="rounded-full bg-emerald-500/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] text-emerald-300">{{ $sample['result'] }}</span></td>
                                <td class="px-5 py-3"><span class="rounded-full bg-violet-500/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] text-violet-300">{{ $sample['severity'] }}</span></td>
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
                        <form method="GET" action="{{ route('platform.ui-reference.patterns.tables') }}" class="flex items-center gap-3">
                            <input type="hidden" name="audit_severity" value="{{ $auditFilters['severity'] }}">
                            <input type="hidden" name="audit_result" value="{{ $auditFilters['result'] }}">
                            <input type="hidden" name="audit_search" value="{{ $auditFilters['search'] }}">
                            <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                            <input type="hidden" name="error_per_page" value="{{ $errorPerPage }}">
                            <label class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Rows</label>
                            <select name="audit_per_page" onchange="this.form.submit()" class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-100">
                                @foreach ([10, 25, 50, 100] as $option)
                                    <option value="{{ $option }}" @selected($auditPerPage === $option)>{{ $option }}</option>
                                @endforeach
                            </select>
                        </form>
                        <p class="text-sm text-slate-400">Showing {{ $auditSamples->firstItem() ?? 0 }} to {{ $auditSamples->lastItem() ?? 0 }} of {{ $auditSamples->total() }} entries</p>
                    </div>

                    <div class="flex items-center gap-2">
                        @php($auditPrev = max(1, $auditSamples->currentPage() - 1))
                        @php($auditNext = min($auditSamples->lastPage(), $auditSamples->currentPage() + 1))
                        <a href="{{ $auditSamples->onFirstPage() ? '#' : $auditSamples->url($auditPrev) }}" @class([
                            'rounded-lg border px-3 py-2 text-xs font-semibold uppercase tracking-[0.15em] transition',
                            'border-slate-700 text-slate-300 hover:border-slate-600 hover:text-white' => ! $auditSamples->onFirstPage(),
                            'cursor-not-allowed border-slate-800 text-slate-600' => $auditSamples->onFirstPage(),
                        ])>Prev</a>

                        <form method="GET" action="{{ route('platform.ui-reference.patterns.tables') }}">
                            <input type="hidden" name="audit_severity" value="{{ $auditFilters['severity'] }}">
                            <input type="hidden" name="audit_result" value="{{ $auditFilters['result'] }}">
                            <input type="hidden" name="audit_search" value="{{ $auditFilters['search'] }}">
                            <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                            <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                            <input type="hidden" name="error_per_page" value="{{ $errorPerPage }}">
                            <select name="audit_page" onchange="this.form.submit()" class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-xs font-semibold uppercase tracking-[0.1em] text-slate-200">
                                @for ($page = 1; $page <= $auditSamples->lastPage(); $page++)
                                    <option value="{{ $page }}" @selected($page === $auditSamples->currentPage())>Page {{ $page }}</option>
                                @endfor
                            </select>
                        </form>

                        <a href="{{ $auditSamples->hasMorePages() ? $auditSamples->url($auditNext) : '#' }}" @class([
                            'rounded-lg border px-3 py-2 text-xs font-semibold uppercase tracking-[0.15em] transition',
                            'border-slate-700 text-slate-300 hover:border-slate-600 hover:text-white' => $auditSamples->hasMorePages(),
                            'cursor-not-allowed border-slate-800 text-slate-600' => ! $auditSamples->hasMorePages(),
                        ])>Next</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="ui-card">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <p class="ui-kicker">Logs Table</p>
                    <h2 class="ui-card-title mt-2">Error Drawer Example</h2>
                </div>
                <button type="button" class="ui-icon-button" data-filter-toggle aria-expanded="false" aria-label="Toggle error demo filters">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                        <path fill-rule="evenodd" d="M2.5 4.75A.75.75 0 0 1 3.25 4h13.5a.75.75 0 0 1 .53 1.28L12 10.56v4.19a.75.75 0 0 1-.44.68l-3 1.333A.75.75 0 0 1 7.5 16V10.56L2.22 5.28a.75.75 0 0 1 .28-1.28Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <form method="GET" action="{{ route('platform.ui-reference.patterns.tables') }}" class="mt-4 hidden rounded-lg border border-slate-800 bg-slate-900/70 p-5" data-filter-panel>
                <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                <div class="grid gap-4 md:grid-cols-3">
                    <label>
                        <span class="text-sm font-semibold text-slate-200">Severity</span>
                        <select name="error_severity" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-3 py-2.5 text-slate-100">
                            <option value="">Any</option>
                            <option value="warning" @selected($errorFilters['severity'] === 'warning')>Warning</option>
                            <option value="error" @selected($errorFilters['severity'] === 'error')>Error</option>
                        </select>
                    </label>
                    <label>
                        <span class="text-sm font-semibold text-slate-200">Environment</span>
                        <select name="error_environment" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-3 py-2.5 text-slate-100">
                            <option value="">Any</option>
                            <option value="staging" @selected($errorFilters['environment'] === 'staging')>Staging</option>
                            <option value="production" @selected($errorFilters['environment'] === 'production')>Production</option>
                        </select>
                    </label>
                    <label>
                        <span class="text-sm font-semibold text-slate-200">Search</span>
                        <input type="text" name="error_search" value="{{ $errorFilters['search'] }}" placeholder="Message, exception, route" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-3 py-2.5 text-slate-100 placeholder:text-slate-500" />
                    </label>
                </div>
                <div class="mt-4 flex flex-wrap gap-3">
                    <button type="submit" class="ui-action ui-action-primary">Apply</button>
                    <a wire:navigate href="{{ route('platform.ui-reference.patterns.tables') }}" class="ui-action ui-action-ghost">Reset</a>
                </div>
            </form>

            <div class="mt-4 overflow-x-auto rounded-lg border border-slate-800 bg-slate-900/70">
                <table class="min-w-[920px] w-full divide-y divide-slate-800">
                    <thead class="bg-slate-900">
                        <tr class="text-left text-xs uppercase tracking-[0.2em] text-slate-500">
                            <th class="px-5 py-3">Occurred</th>
                            <th class="px-5 py-3">Message</th>
                            <th class="px-5 py-3">Exception</th>
                            <th class="px-5 py-3">Severity</th>
                            <th class="px-5 py-3">Environment</th>
                            <th class="px-5 py-3">Request</th>
                            <th class="px-5 py-3 sr-only">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 text-sm text-slate-200">
                        @forelse ($errorSamples as $sample)
                            <tr class="cursor-pointer transition hover:bg-slate-950/40" data-error-log-row data-error-log-url="{{ route('platform.ui-reference.error-samples.show', $sample['sample_key']) }}">
                                <td class="px-5 py-3 text-slate-400">{{ $sample['occurred_at_label'] }}</td>
                                <td class="px-5 py-3 font-semibold text-white">{{ $sample['message'] }}</td>
                                <td class="px-5 py-3">{{ $sample['exception_class'] }}</td>
                                <td class="px-5 py-3"><span class="rounded-full bg-rose-500/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] text-rose-300">{{ $sample['severity'] }}</span></td>
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
                        <form method="GET" action="{{ route('platform.ui-reference.patterns.tables') }}" class="flex items-center gap-3">
                            <input type="hidden" name="error_severity" value="{{ $errorFilters['severity'] }}">
                            <input type="hidden" name="error_environment" value="{{ $errorFilters['environment'] }}">
                            <input type="hidden" name="error_search" value="{{ $errorFilters['search'] }}">
                            <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                            <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                            <label class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Rows</label>
                            <select name="error_per_page" onchange="this.form.submit()" class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-100">
                                @foreach ([10, 25, 50, 100] as $option)
                                    <option value="{{ $option }}" @selected($errorPerPage === $option)>{{ $option }}</option>
                                @endforeach
                            </select>
                        </form>
                        <p class="text-sm text-slate-400">Showing {{ $errorSamples->firstItem() ?? 0 }} to {{ $errorSamples->lastItem() ?? 0 }} of {{ $errorSamples->total() }} entries</p>
                    </div>

                    <div class="flex items-center gap-2">
                        @php($errorPrev = max(1, $errorSamples->currentPage() - 1))
                        @php($errorNext = min($errorSamples->lastPage(), $errorSamples->currentPage() + 1))
                        <a href="{{ $errorSamples->onFirstPage() ? '#' : $errorSamples->url($errorPrev) }}" @class([
                            'rounded-lg border px-3 py-2 text-xs font-semibold uppercase tracking-[0.15em] transition',
                            'border-slate-700 text-slate-300 hover:border-slate-600 hover:text-white' => ! $errorSamples->onFirstPage(),
                            'cursor-not-allowed border-slate-800 text-slate-600' => $errorSamples->onFirstPage(),
                        ])>Prev</a>

                        <form method="GET" action="{{ route('platform.ui-reference.patterns.tables') }}">
                            <input type="hidden" name="error_severity" value="{{ $errorFilters['severity'] }}">
                            <input type="hidden" name="error_environment" value="{{ $errorFilters['environment'] }}">
                            <input type="hidden" name="error_search" value="{{ $errorFilters['search'] }}">
                            <input type="hidden" name="error_per_page" value="{{ $errorPerPage }}">
                            <input type="hidden" name="workspace_per_page" value="{{ $workspacePerPage }}">
                            <input type="hidden" name="audit_per_page" value="{{ $auditPerPage }}">
                            <select name="error_page" onchange="this.form.submit()" class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-xs font-semibold uppercase tracking-[0.1em] text-slate-200">
                                @for ($page = 1; $page <= $errorSamples->lastPage(); $page++)
                                    <option value="{{ $page }}" @selected($page === $errorSamples->currentPage())>Page {{ $page }}</option>
                                @endfor
                            </select>
                        </form>

                        <a href="{{ $errorSamples->hasMorePages() ? $errorSamples->url($errorNext) : '#' }}" @class([
                            'rounded-lg border px-3 py-2 text-xs font-semibold uppercase tracking-[0.15em] transition',
                            'border-slate-700 text-slate-300 hover:border-slate-600 hover:text-white' => $errorSamples->hasMorePages(),
                            'cursor-not-allowed border-slate-800 text-slate-600' => ! $errorSamples->hasMorePages(),
                        ])>Next</a>
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
                    <button type="button" class="ui-action ui-action-ghost" data-audit-log-close>Close</button>
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
                    <button type="button" class="ui-action ui-action-ghost" data-error-log-close>Close</button>
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
