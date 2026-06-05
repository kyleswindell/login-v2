        <section class="ui-card">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <p class="ui-kicker">Logs Table</p>
                    <h2 class="ui-card-title mt-2">Audit Drawer Example</h2>
                    <p class="ui-card-copy">Row clicks and explicit `View` actions both open the right-side drawer.</p>
                </div>
                <button type="button" class="ui-icon-button" data-filter-toggle aria-expanded="false" aria-label="Toggle audit demo filters">
                    <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                </button>
            </div>

            <form method="GET" action="{{ route('platform.ui-reference.index') }}" class="mt-4 hidden rounded-lg border border-slate-800 bg-slate-900/70 p-5" data-filter-panel>
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
                    <a wire:navigate href="{{ route('platform.ui-reference.index') }}" class="ui-action ui-action-ghost">Reset</a>
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
                        <form method="GET" action="{{ route('platform.ui-reference.index') }}" class="flex items-center gap-3">
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

                        <form method="GET" action="{{ route('platform.ui-reference.index') }}">
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
