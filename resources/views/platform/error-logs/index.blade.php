<x-layouts.app title="Error Logs">
    @php($viewerTimezone = auth()->user()?->timezone ?: config('app.timezone'))

    <section class="flex flex-1 flex-col gap-6">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <h1 class="ui-page-header-title">Error Logs</h1>
            <p class="ui-page-header-copy">Review platform-level errors and operational failures captured at runtime.</p>
            <button
                type="button"
                class="ui-icon-button"
                data-filter-toggle
                aria-expanded="false"
                aria-label="Toggle error log filters"
            >
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                    <path fill-rule="evenodd" d="M2.5 4.75A.75.75 0 0 1 3.25 4h13.5a.75.75 0 0 1 .53 1.28L12 10.56v4.19a.75.75 0 0 1-.44.68l-3 1.333A.75.75 0 0 1 7.5 16V10.56L2.22 5.28a.75.75 0 0 1 .28-1.28Z" clip-rule="evenodd" />
                </svg>
                <span class="sr-only">Filters</span>
            </button>
        </div>

        <form method="GET" action="{{ route('platform.error-logs.index') }}" class="ui-platform-surface hidden p-6" data-filter-panel>
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                <label class="block">
                    <span class="text-sm font-semibold ui-platform-text-strong">Severity</span>
                    <select name="severity" class="ui-select mt-2">
                        <option value="">Any severity</option>
                        <option value="debug" @selected($filters['severity'] === 'debug')>Debug</option>
                        <option value="info" @selected($filters['severity'] === 'info')>Info</option>
                        <option value="warning" @selected($filters['severity'] === 'warning')>Warning</option>
                        <option value="error" @selected($filters['severity'] === 'error')>Error</option>
                        <option value="critical" @selected($filters['severity'] === 'critical')>Critical</option>
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold ui-platform-text-strong">Handled</span>
                    <select name="handled" class="ui-select mt-2">
                        <option value="">Any</option>
                        <option value="1" @selected($filters['handled'] === '1')>Handled</option>
                        <option value="0" @selected($filters['handled'] === '0')>Unhandled</option>
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold ui-platform-text-strong">Environment</span>
                    <select name="environment" class="ui-select mt-2">
                        <option value="">Any environment</option>
                        @foreach ($environments as $environment)
                            <option value="{{ $environment }}" @selected($filters['environment'] === $environment)>{{ $environment }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold ui-platform-text-strong">Exception Class</span>
                    <select name="exception_class" class="ui-select mt-2">
                        <option value="">Any exception</option>
                        @foreach ($exceptionClasses as $exceptionClass)
                            <option value="{{ $exceptionClass }}" @selected($filters['exception_class'] === $exceptionClass)>{{ $exceptionClass }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold ui-platform-text-strong">From</span>
                    <input type="date" name="date_from" value="{{ $filters['date_from'] }}" class="ui-input mt-2">
                </label>

                <label class="block">
                    <span class="text-sm font-semibold ui-platform-text-strong">To</span>
                    <input type="date" name="date_to" value="{{ $filters['date_to'] }}" class="ui-input mt-2">
                </label>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <button type="submit" class="ui-action ui-action-primary">
                    Apply Filters
                </button>
                <a wire:navigate href="{{ route('platform.error-logs.index') }}" class="ui-action ui-action-ghost">
                    Reset
                </a>
            </div>
        </form>

        <div class="flex flex-wrap items-center gap-3">
            <a wire:navigate href="{{ route('platform.setup.error-logs') }}" class="ui-action ui-action-warning">
                Error Setup
            </a>
        </div>

        <div class="ui-platform-table-shell">
            <table class="min-w-full ui-platform-table-body">
                <thead class="ui-platform-table-head">
                    <tr class="text-left text-xs uppercase tracking-[0.2em] ui-platform-text-muted">
                        <th class="px-6 py-4">Occurred</th>
                        <th class="px-6 py-4">Severity</th>
                        <th class="px-6 py-4">Message</th>
                        <th class="px-6 py-4">Exception</th>
                        <th class="px-6 py-4">Handled</th>
                        <th class="px-6 py-4">Environment</th>
                        <th class="px-6 py-4 sr-only">Actions</th>
                    </tr>
                </thead>
                <tbody class="ui-platform-table-body">
                    @forelse ($logs as $log)
                        <tr class="ui-platform-table-row align-top text-sm transition cursor-pointer" data-error-log-row data-error-log-url="{{ route('platform.error-logs.show', $log) }}">
                            <td class="px-6 py-4 ui-platform-text-muted">
                                {{ $log->occurredAtForTimezone($viewerTimezone)?->format('M j, Y g:i A T') ?? '—' }}
                            </td>
                            <td class="px-6 py-4">
                                <x-ui.badge :status="match ($log->severity) { 'warning' => 'warning', 'error', 'critical' => 'danger', default => 'neutral' }" :label="$log->severity" :show-icon="false" />
                            </td>
                            <td class="max-w-xs px-6 py-4">
                                <p class="truncate font-semibold ui-platform-text-strong">{{ $log->message }}</p>
                                @if ($log->file_path)
                                    <p class="mt-1 truncate text-xs ui-platform-text-muted">{{ $log->file_path }}{{ $log->line_number ? ':' . $log->line_number : '' }}</p>
                                @endif
                            </td>
                            <td class="max-w-xs px-6 py-4">
                                <p class="truncate ui-platform-text">{{ $log->exception_class ?? '—' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if ($log->handled)
                                    <x-ui.badge label="Handled" semantic="success" :show-icon="false" />
                                @else
                                    <x-ui.badge label="Unhandled" semantic="danger" :show-icon="false" />
                                @endif
                            </td>
                            <td class="px-6 py-4 ui-platform-text-muted">
                                {{ $log->environment ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a
                                    href="{{ route('platform.error-logs.show', $log) }}"
                                    class="ui-action ui-action-primary"
                                    data-error-log-view
                                    data-error-log-url="{{ route('platform.error-logs.show', $log) }}"
                                >
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-sm ui-platform-text-muted">No error log rows match the current filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="flex flex-wrap items-center justify-between gap-4 border-t ui-platform-border px-6 py-4">
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('platform.error-logs.index') }}" class="flex items-center gap-3">
                        <input type="hidden" name="severity" value="{{ $filters['severity'] }}">
                        <input type="hidden" name="handled" value="{{ $filters['handled'] }}">
                        <input type="hidden" name="environment" value="{{ $filters['environment'] }}">
                        <input type="hidden" name="exception_class" value="{{ $filters['exception_class'] }}">
                        <input type="hidden" name="date_from" value="{{ $filters['date_from'] }}">
                        <input type="hidden" name="date_to" value="{{ $filters['date_to'] }}">
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

                    <form method="GET" action="{{ route('platform.error-logs.index') }}">
                        <input type="hidden" name="severity" value="{{ $filters['severity'] }}">
                        <input type="hidden" name="handled" value="{{ $filters['handled'] }}">
                        <input type="hidden" name="environment" value="{{ $filters['environment'] }}">
                        <input type="hidden" name="exception_class" value="{{ $filters['exception_class'] }}">
                        <input type="hidden" name="date_from" value="{{ $filters['date_from'] }}">
                        <input type="hidden" name="date_to" value="{{ $filters['date_to'] }}">
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

        <div
            class="ui-platform-backdrop fixed inset-0 z-50 hidden"
            data-error-log-modal
            aria-hidden="true"
        >
            <div class="ui-log-drawer-panel" data-log-drawer-panel tabindex="-1" role="dialog" aria-modal="true" aria-labelledby="error-log-drawer-title">
                <div class="flex items-start justify-between gap-3 border-b ui-platform-border px-6 py-5">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] ui-platform-text-muted">Error Log Detail</p>
                        <h2 id="error-log-drawer-title" class="mt-2 text-2xl font-semibold ui-platform-text-strong" data-error-log-title>—</h2>
                        <p class="mt-2 text-sm ui-platform-text-muted" data-error-log-subtitle>—</p>
                    </div>
                    <button type="button" class="ui-action ui-action-ghost" data-error-log-close>Close</button>
                </div>

                <div class="overflow-y-auto px-6 py-6">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="ui-platform-surface p-4">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.2em] ui-platform-text-muted">Summary</h3>
                        <dl class="mt-3 space-y-2 text-sm ui-platform-text">
                            <div class="flex items-center justify-between"><dt>Occurred</dt><dd data-error-log-occurred>—</dd></div>
                            <div class="flex items-center justify-between"><dt>Severity</dt><dd data-error-log-severity>—</dd></div>
                            <div class="flex items-center justify-between"><dt>Handled</dt><dd data-error-log-handled>—</dd></div>
                            <div class="flex items-center justify-between"><dt>Environment</dt><dd data-error-log-environment>—</dd></div>
                        </dl>
                    </div>

                        <div class="ui-platform-surface p-4">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.2em] ui-platform-text-muted">Exception</h3>
                        <dl class="mt-3 space-y-2 text-sm ui-platform-text">
                            <div><dt>Class</dt><dd data-error-log-exception>—</dd></div>
                            <div><dt>Code</dt><dd data-error-log-code>—</dd></div>
                            <div><dt>File</dt><dd class="break-all" data-error-log-file>—</dd></div>
                        </dl>
                    </div>
                </div>

                    <div class="mt-4 ui-platform-surface p-4">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.2em] ui-platform-text-muted">Request Context</h3>
                        <dl class="mt-3 grid gap-2 text-sm ui-platform-text md:grid-cols-2">
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

                    <div class="mt-4 ui-platform-surface p-4">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.2em] ui-platform-text-muted">Message</h3>
                        <p class="mt-2 text-sm ui-platform-text" data-error-log-message>—</p>
                    </div>

                    <div class="mt-4 ui-platform-surface p-4">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.2em] ui-platform-text-muted">Stack Trace</h3>
                        <pre class="mt-2 max-h-64 overflow-y-auto whitespace-pre-wrap text-xs ui-platform-text" data-error-log-trace-stack>—</pre>
                    </div>

                    <div class="mt-4 ui-platform-surface p-4">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.2em] ui-platform-text-muted">Context</h3>
                        <pre class="mt-2 max-h-64 overflow-y-auto whitespace-pre-wrap text-xs ui-platform-text" data-error-log-context>—</pre>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
