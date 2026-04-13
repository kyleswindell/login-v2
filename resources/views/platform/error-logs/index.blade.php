<x-layouts.app title="Error Logs">
    @php($viewerTimezone = auth()->user()?->timezone ?: config('app.timezone'))

    <section class="flex flex-1 flex-col gap-6">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <h1 class="ui-page-header-title">Error Logs</h1>
            <p class="ui-page-header-copy">Review platform-level errors and operational failures captured at runtime.</p>
            <button
                type="button"
                class="inline-flex items-center gap-2 rounded-md border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-300 transition hover:border-slate-500 hover:text-white"
                data-filter-toggle
            >
                <span>Filters</span>
                <span aria-hidden="true">▾</span>
            </button>
        </div>

        <form method="GET" action="{{ route('platform.error-logs.index') }}" class="hidden rounded-lg border border-slate-800 bg-slate-900/70 p-6" data-filter-panel>
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Severity</span>
                    <select name="severity" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-slate-500 focus:outline-none focus:ring-0">
                        <option value="">Any severity</option>
                        <option value="debug" @selected($filters['severity'] === 'debug')>Debug</option>
                        <option value="info" @selected($filters['severity'] === 'info')>Info</option>
                        <option value="warning" @selected($filters['severity'] === 'warning')>Warning</option>
                        <option value="error" @selected($filters['severity'] === 'error')>Error</option>
                        <option value="critical" @selected($filters['severity'] === 'critical')>Critical</option>
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Handled</span>
                    <select name="handled" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-slate-500 focus:outline-none focus:ring-0">
                        <option value="">Any</option>
                        <option value="1" @selected($filters['handled'] === '1')>Handled</option>
                        <option value="0" @selected($filters['handled'] === '0')>Unhandled</option>
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Environment</span>
                    <select name="environment" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-slate-500 focus:outline-none focus:ring-0">
                        <option value="">Any environment</option>
                        @foreach ($environments as $environment)
                            <option value="{{ $environment }}" @selected($filters['environment'] === $environment)>{{ $environment }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Exception Class</span>
                    <select name="exception_class" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-slate-500 focus:outline-none focus:ring-0">
                        <option value="">Any exception</option>
                        @foreach ($exceptionClasses as $exceptionClass)
                            <option value="{{ $exceptionClass }}" @selected($filters['exception_class'] === $exceptionClass)>{{ $exceptionClass }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">From</span>
                    <input type="date" name="date_from" value="{{ $filters['date_from'] }}" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-slate-500 focus:outline-none focus:ring-0">
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">To</span>
                    <input type="date" name="date_to" value="{{ $filters['date_to'] }}" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-slate-500 focus:outline-none focus:ring-0">
                </label>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <button type="submit" class="inline-flex rounded-md border border-slate-700 px-4 py-3 text-sm font-semibold text-slate-100 transition hover:border-slate-500 hover:text-slate-300">
                    Apply Filters
                </button>
                <a wire:navigate href="{{ route('platform.error-logs.index') }}" class="inline-flex rounded-md border border-slate-800 px-4 py-3 text-sm font-semibold text-slate-300 transition hover:border-slate-600 hover:text-white">
                    Reset
                </a>
            </div>
        </form>

        <div class="flex flex-wrap items-center gap-3">
            <a wire:navigate href="{{ route('platform.setup.error-logs') }}" class="inline-flex items-center rounded-md border border-amber-500/50 bg-amber-500/15 px-4 py-2.5 text-sm font-semibold text-amber-100 transition hover:border-amber-400/70 hover:bg-amber-500/25 hover:text-amber-50">
                Error Setup
            </a>
        </div>

        <div class="overflow-hidden rounded-lg border border-slate-800 bg-slate-900/70">
            <table class="min-w-full divide-y divide-slate-800">
                <thead class="bg-slate-900">
                    <tr class="text-left text-xs uppercase tracking-[0.2em] text-slate-500">
                        <th class="px-6 py-4">Occurred</th>
                        <th class="px-6 py-4">Severity</th>
                        <th class="px-6 py-4">Message</th>
                        <th class="px-6 py-4">Exception</th>
                        <th class="px-6 py-4">Handled</th>
                        <th class="px-6 py-4">Environment</th>
                        <th class="px-6 py-4 sr-only">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse ($logs as $log)
                        <tr class="align-top text-sm text-slate-200">
                            <td class="px-6 py-4 text-slate-400">
                                {{ $log->occurredAtForTimezone($viewerTimezone)?->format('M j, Y g:i A T') ?? '—' }}
                            </td>
                            <td class="px-6 py-4">
                                <span @class([
                                    'inline-flex rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em]',
                                    'bg-slate-500/15 text-slate-300' => $log->severity === 'debug',
                                    'bg-slate-700/60 text-slate-300' => $log->severity === 'info',
                                    'bg-amber-500/15 text-amber-300' => $log->severity === 'warning',
                                    'bg-rose-500/15 text-rose-300' => $log->severity === 'error',
                                    'bg-red-600/20 text-red-300' => $log->severity === 'critical',
                                ])>
                                    {{ $log->severity }}
                                </span>
                            </td>
                            <td class="max-w-xs px-6 py-4">
                                <p class="truncate font-semibold text-white">{{ $log->message }}</p>
                                @if ($log->file_path)
                                    <p class="mt-1 truncate text-xs text-slate-500">{{ $log->file_path }}{{ $log->line_number ? ':' . $log->line_number : '' }}</p>
                                @endif
                            </td>
                            <td class="max-w-xs px-6 py-4">
                                <p class="truncate text-slate-300">{{ $log->exception_class ?? '—' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if ($log->handled)
                                    <span class="inline-flex rounded-full bg-emerald-500/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] text-emerald-300">Handled</span>
                                @else
                                    <span class="inline-flex rounded-full bg-rose-500/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] text-rose-300">Unhandled</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-400">
                                {{ $log->environment ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button
                                    type="button"
                                    class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-300 transition hover:text-white"
                                    data-error-log-view
                                    data-error-log='@json([
                                        "occurred_at" => $log->occurredAtForTimezone($viewerTimezone)?->format("M j, Y g:i A T"),
                                        "severity" => $log->severity,
                                        "handled" => $log->handled,
                                        "environment" => $log->environment,
                                        "message" => $log->message,
                                        "exception_class" => $log->exception_class,
                                        "error_code" => $log->error_code,
                                        "file_path" => $log->file_path,
                                        "line_number" => $log->line_number,
                                        "route" => $log->route,
                                        "method" => $log->method,
                                        "status_code" => $log->status_code,
                                        "request_id" => $log->request_id,
                                        "trace_id" => $log->trace_id,
                                        "user_id" => $log->user_id,
                                        "ip_address" => $log->ip_address,
                                        "hostname" => $log->hostname,
                                        "stack_trace" => $log->stack_trace,
                                        "context" => $log->getRawOriginal('context'),
                                    ], JSON_PARTIAL_OUTPUT_ON_ERROR | JSON_INVALID_UTF8_SUBSTITUTE)'
                                >
                                    View
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-sm text-slate-500">No error log rows match the current filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="flex flex-wrap items-center justify-between gap-4 border-t border-slate-800 px-6 py-4">
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('platform.error-logs.index') }}" class="flex items-center gap-3">
                        <input type="hidden" name="severity" value="{{ $filters['severity'] }}">
                        <input type="hidden" name="handled" value="{{ $filters['handled'] }}">
                        <input type="hidden" name="environment" value="{{ $filters['environment'] }}">
                        <input type="hidden" name="exception_class" value="{{ $filters['exception_class'] }}">
                        <input type="hidden" name="date_from" value="{{ $filters['date_from'] }}">
                        <input type="hidden" name="date_to" value="{{ $filters['date_to'] }}">
                        <label class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Rows</label>
                        <select name="per_page" onchange="this.form.submit()" class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-100">
                            @foreach ([10, 25, 50, 100] as $option)
                                <option value="{{ $option }}" @selected($perPage === $option)>{{ $option }}</option>
                            @endforeach
                        </select>
                    </form>

                    <p class="text-sm text-slate-400">
                        Showing {{ $logs->firstItem() ?? 0 }} to {{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }} entries
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    @php($prevPage = max(1, $logs->currentPage() - 1))
                    @php($nextPage = min($logs->lastPage(), $logs->currentPage() + 1))
                    <a href="{{ $logs->onFirstPage() ? '#' : $logs->url($prevPage) }}" @class([
                        'rounded-lg border px-3 py-2 text-xs font-semibold uppercase tracking-[0.15em] transition',
                        'border-slate-700 text-slate-300 hover:border-slate-600 hover:text-white' => ! $logs->onFirstPage(),
                        'cursor-not-allowed border-slate-800 text-slate-600' => $logs->onFirstPage(),
                    ])>Prev</a>

                    <form method="GET" action="{{ route('platform.error-logs.index') }}">
                        <input type="hidden" name="severity" value="{{ $filters['severity'] }}">
                        <input type="hidden" name="handled" value="{{ $filters['handled'] }}">
                        <input type="hidden" name="environment" value="{{ $filters['environment'] }}">
                        <input type="hidden" name="exception_class" value="{{ $filters['exception_class'] }}">
                        <input type="hidden" name="date_from" value="{{ $filters['date_from'] }}">
                        <input type="hidden" name="date_to" value="{{ $filters['date_to'] }}">
                        <input type="hidden" name="per_page" value="{{ $perPage }}">
                        <select name="page" onchange="this.form.submit()" class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-xs font-semibold uppercase tracking-[0.1em] text-slate-200">
                            @for ($page = 1; $page <= $logs->lastPage(); $page++)
                                <option value="{{ $page }}" @selected($page === $logs->currentPage())>Page {{ $page }}</option>
                            @endfor
                        </select>
                    </form>

                    <a href="{{ $logs->hasMorePages() ? $logs->url($nextPage) : '#' }}" @class([
                        'rounded-lg border px-3 py-2 text-xs font-semibold uppercase tracking-[0.15em] transition',
                        'border-slate-700 text-slate-300 hover:border-slate-600 hover:text-white' => $logs->hasMorePages(),
                        'cursor-not-allowed border-slate-800 text-slate-600' => ! $logs->hasMorePages(),
                    ])>Next</a>
                </div>
            </div>
        </div>

        <div
            class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-4"
            data-error-log-modal
        >
            <div class="max-h-[90vh] w-full max-w-4xl overflow-y-auto rounded-lg border border-slate-800 bg-slate-950 p-6 shadow-2xl shadow-black/40">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Error Log Detail</p>
                        <h2 class="mt-2 text-2xl font-semibold text-white" data-error-log-title>—</h2>
                        <p class="mt-2 text-sm text-slate-400" data-error-log-subtitle>—</p>
                    </div>
                    <button type="button" class="rounded-md border border-slate-700 px-3 py-2 text-xs font-semibold text-slate-300 transition hover:border-slate-500 hover:text-white" data-error-log-close>Close</button>
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-2">
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
                    <pre class="mt-2 max-h-64 overflow-y-auto whitespace-pre-wrap text-xs text-slate-300" data-error-log-trace-stack>—</pre>
                </div>

                <div class="mt-4 rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Context</h3>
                    <pre class="mt-2 max-h-64 overflow-y-auto whitespace-pre-wrap text-xs text-slate-300" data-error-log-context>—</pre>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
