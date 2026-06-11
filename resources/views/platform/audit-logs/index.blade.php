<x-layouts.app title="Audit Logs">
    @php($viewerTimezone = auth()->user()?->timezone ?: config('app.timezone'))

    <section class="flex flex-1 flex-col gap-6">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <h1 class="ui-page-header-title">Audit Logs</h1>
            <p class="ui-page-header-copy">Review current platform activity events and auth-related audit history.</p>
            <button
                type="button"
                class="ui-icon-button"
                data-filter-toggle
                aria-expanded="false"
                aria-label="Toggle audit log filters"
            >
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                    <path fill-rule="evenodd" d="M2.5 4.75A.75.75 0 0 1 3.25 4h13.5a.75.75 0 0 1 .53 1.28L12 10.56v4.19a.75.75 0 0 1-.44.68l-3 1.333A.75.75 0 0 1 7.5 16V10.56L2.22 5.28a.75.75 0 0 1 .28-1.28Z" clip-rule="evenodd" />
                </svg>
                <span class="sr-only">Filters</span>
            </button>
        </div>

        <form method="GET" action="{{ route('platform.audit-logs.index') }}" class="ui-platform-surface hidden p-6" data-filter-panel>
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <label class="block">
                    <span class="text-sm font-semibold ui-platform-text-strong">Event Type</span>
                    <select name="event_type" class="ui-select mt-2">
                        <option value="">Any event type</option>
                        @foreach ($eventTypes as $eventType)
                            <option value="{{ $eventType }}" @selected($filters['event_type'] === $eventType)>{{ $eventType }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold ui-platform-text-strong">Actor</span>
                    <select name="actor_id" class="ui-select mt-2">
                        <option value="">Any actor</option>
                        <option value="system" @selected($filters['actor_id'] === 'system')>System</option>
                        @foreach ($actorUsers as $actor)
                            <option value="{{ $actor->id }}" @selected($filters['actor_id'] == $actor->id)>
                                {{ $actor->name }} ({{ $actor->email }})
                            </option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold ui-platform-text-strong">Result</span>
                    <select name="result" class="ui-select mt-2">
                        <option value="">Any result</option>
                        <option value="success" @selected($filters['result'] === 'success')>Success</option>
                        <option value="failure" @selected($filters['result'] === 'failure')>Failure</option>
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold ui-platform-text-strong">Severity</span>
                    <select name="severity" class="ui-select mt-2">
                        <option value="">Any severity</option>
                        <option value="info" @selected($filters['severity'] === 'info')>Info</option>
                        <option value="notice" @selected($filters['severity'] === 'notice')>Notice</option>
                        <option value="warning" @selected($filters['severity'] === 'warning')>Warning</option>
                        <option value="error" @selected($filters['severity'] === 'error')>Error</option>
                    </select>
                </label>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <button type="submit" class="ui-action ui-action-primary">
                    Apply Filters
                </button>

                <a wire:navigate href="{{ route('platform.audit-logs.index') }}" class="ui-action ui-action-ghost">
                    Reset
                </a>
            </div>
        </form>

        <div class="flex flex-wrap items-center gap-3">
            <a wire:navigate href="{{ route('platform.settings.audit-logs') }}" class="ui-action ui-action-warning">
                Audit Settings
            </a>
        </div>

        <div class="ui-platform-table-shell">
            <table class="min-w-full ui-platform-table-body">
                <thead class="ui-platform-table-head">
                    <tr class="text-left text-xs uppercase tracking-[0.2em] ui-platform-text-muted">
                        <th class="px-6 py-4">Occurred</th>
                        <th class="px-6 py-4">Event</th>
                        <th class="px-6 py-4">Actor</th>
                        <th class="px-6 py-4">Result</th>
                        <th class="px-6 py-4">Severity</th>
                        <th class="px-6 py-4">Route</th>
                        <th class="px-6 py-4">Request</th>
                        <th class="px-6 py-4 sr-only">Actions</th>
                    </tr>
                </thead>
                <tbody class="ui-platform-table-body">
                    @forelse ($logs as $log)
                        <tr class="ui-platform-table-row align-top text-sm transition cursor-pointer" data-audit-log-row data-audit-log-url="{{ route('platform.audit-logs.show', $log) }}">
                            <td class="px-6 py-4 ui-platform-text-muted">
                                {{ $log->occurredAtForTimezone($viewerTimezone)?->format('M j, Y g:i A T') ?? '—' }}
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold ui-platform-text-strong">{{ $log->event_type }}</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.15em] ui-platform-text-muted">{{ $log->action }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if ($log->actorUser)
                                    <p class="font-semibold ui-platform-text-strong">{{ $log->actorUser->name }}</p>
                                    <p class="mt-1 ui-platform-text-muted">{{ $log->actorUser->email }}</p>
                                @else
                                    <span class="ui-platform-text-muted">System</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <x-ui.badge :status="$log->result === 'success' ? 'success' : 'failed'" :show-icon="false" />
                            </td>
                            <td class="px-6 py-4">
                                <x-ui.badge :status="$log->severity === 'error' || $log->severity === 'critical' ? 'danger' : $log->severity" :label="$log->severity" :show-icon="false" />
                            </td>
                            <td class="px-6 py-4 ui-platform-text-muted">
                                <p>{{ $log->route ?? 'n/a' }}</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.15em] ui-platform-text-muted">{{ $log->method ?? 'n/a' }}</p>
                            </td>
                            <td class="px-6 py-4 text-xs ui-platform-text-muted">
                                {{ $log->request_id ?? 'n/a' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('platform.audit-logs.show', $log) }}" class="ui-action ui-action-primary" data-audit-log-view data-audit-log-url="{{ route('platform.audit-logs.show', $log) }}">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-sm ui-platform-text-muted">No audit log rows match the current filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="flex flex-wrap items-center justify-between gap-4 border-t ui-platform-border px-6 py-4">
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('platform.audit-logs.index') }}" class="flex items-center gap-3">
                        <input type="hidden" name="event_type" value="{{ $filters['event_type'] }}">
                        <input type="hidden" name="actor_id" value="{{ $filters['actor_id'] }}">
                        <input type="hidden" name="result" value="{{ $filters['result'] }}">
                        <input type="hidden" name="severity" value="{{ $filters['severity'] }}">
                        <label class="text-xs font-semibold uppercase tracking-[0.2em] ui-platform-text-muted">Rows</label>
                        <select name="per_page" onchange="this.form.submit()" class="ui-select !w-auto px-3 py-2 text-sm">
                            @foreach ([10, 25, 50, 100] as $option)
                                <option value="{{ $option }}" @selected($perPage === $option)>{{ $option }}</option>
                            @endforeach
                        </select>
                    </form>

                    <p class="text-sm ui-platform-text-muted">
                        Showing {{ $logs->firstItem() ?? 0 }} to {{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }} entries
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    @php($prevPage = max(1, $logs->currentPage() - 1))
                    @php($nextPage = min($logs->lastPage(), $logs->currentPage() + 1))
                    <a href="{{ $logs->onFirstPage() ? '#' : $logs->url($prevPage) }}" @class([
                        'ui-action ui-action-xs',
                        'ui-action-ghost' => ! $logs->onFirstPage(),
                        'cursor-not-allowed ui-platform-border ui-platform-text-muted opacity-60' => $logs->onFirstPage(),
                    ])>Prev</a>

                    <form method="GET" action="{{ route('platform.audit-logs.index') }}">
                        <input type="hidden" name="event_type" value="{{ $filters['event_type'] }}">
                        <input type="hidden" name="actor_id" value="{{ $filters['actor_id'] }}">
                        <input type="hidden" name="result" value="{{ $filters['result'] }}">
                        <input type="hidden" name="severity" value="{{ $filters['severity'] }}">
                        <input type="hidden" name="per_page" value="{{ $perPage }}">
                        <select name="page" onchange="this.form.submit()" class="ui-select !w-auto px-3 py-2 text-xs font-semibold uppercase tracking-[0.1em]">
                            @for ($page = 1; $page <= $logs->lastPage(); $page++)
                                <option value="{{ $page }}" @selected($page === $logs->currentPage())>Page {{ $page }}</option>
                            @endfor
                        </select>
                    </form>

                    <a href="{{ $logs->hasMorePages() ? $logs->url($nextPage) : '#' }}" @class([
                        'ui-action ui-action-xs',
                        'ui-action-ghost' => $logs->hasMorePages(),
                        'cursor-not-allowed ui-platform-border ui-platform-text-muted opacity-60' => ! $logs->hasMorePages(),
                    ])>Next</a>
                </div>
            </div>
        </div>

        <div class="ui-platform-backdrop fixed inset-0 z-50 hidden" data-audit-log-modal aria-hidden="true">
            <div class="ui-log-drawer-panel" data-log-drawer-panel tabindex="-1" role="dialog" aria-modal="true" aria-labelledby="audit-log-drawer-title">
                <div class="flex items-start justify-between gap-3 border-b ui-platform-border px-6 py-5">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] ui-platform-text-muted">Audit Log Detail</p>
                        <h2 id="audit-log-drawer-title" class="mt-2 text-2xl font-semibold ui-platform-text-strong" data-audit-log-title>—</h2>
                        <p class="mt-2 text-sm ui-platform-text-muted" data-audit-log-subtitle>—</p>
                    </div>
                    <button type="button" class="ui-action ui-action-ghost" data-audit-log-close>Close</button>
                </div>

                <div class="overflow-y-auto px-6 py-6">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="ui-platform-surface p-4">
                            <h3 class="text-xs font-semibold uppercase tracking-[0.2em] ui-platform-text-muted">Summary</h3>
                            <dl class="mt-3 space-y-2 text-sm ui-platform-text">
                                <div class="flex items-center justify-between"><dt>Occurred</dt><dd data-audit-log-occurred>—</dd></div>
                                <div class="flex items-center justify-between"><dt>Result</dt><dd data-audit-log-result>—</dd></div>
                                <div class="flex items-center justify-between"><dt>Severity</dt><dd data-audit-log-severity>—</dd></div>
                                <div class="flex items-center justify-between"><dt>Action</dt><dd data-audit-log-action>—</dd></div>
                            </dl>
                        </div>

                        <div class="ui-platform-surface p-4">
                            <h3 class="text-xs font-semibold uppercase tracking-[0.2em] ui-platform-text-muted">Actor</h3>
                            <dl class="mt-3 space-y-2 text-sm ui-platform-text">
                                <div><dt>Name</dt><dd data-audit-log-actor-name>—</dd></div>
                                <div><dt>Email</dt><dd data-audit-log-actor-email>—</dd></div>
                            </dl>
                        </div>
                    </div>

                    <div class="mt-4 ui-platform-surface p-4">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.2em] ui-platform-text-muted">Request Context</h3>
                        <dl class="mt-3 grid gap-2 text-sm ui-platform-text md:grid-cols-2">
                            <div><dt>Route</dt><dd data-audit-log-route>—</dd></div>
                            <div><dt>Method</dt><dd data-audit-log-method>—</dd></div>
                            <div><dt>Request ID</dt><dd class="break-all" data-audit-log-request>—</dd></div>
                            <div><dt>Trace ID</dt><dd class="break-all" data-audit-log-trace>—</dd></div>
                            <div><dt>IP</dt><dd data-audit-log-ip>—</dd></div>
                            <div><dt>Subject</dt><dd data-audit-log-subject>—</dd></div>
                        </dl>
                    </div>

                    <div class="mt-4 ui-platform-surface p-4">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.2em] ui-platform-text-muted">Metadata</h3>
                        <pre class="mt-2 max-h-64 overflow-y-auto whitespace-pre-wrap text-xs ui-platform-text" data-audit-log-metadata>—</pre>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
