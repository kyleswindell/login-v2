<x-layouts.app title="Audit Logs">
    @php($viewerTimezone = auth()->user()?->timezone ?: config('app.timezone'))

    <section class="flex flex-1 flex-col gap-6">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <h1 class="ui-page-header-title">Audit Logs</h1>
            <p class="ui-page-header-copy">Review current platform activity events and auth-related audit history.</p>
            <button
                type="button"
                class="inline-flex items-center gap-2 rounded-md border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-300 transition hover:border-slate-500 hover:text-white"
                data-filter-toggle
            >
                <span>Filters</span>
                <span aria-hidden="true">▾</span>
            </button>
        </div>

        <form method="GET" action="{{ route('platform.audit-logs.index') }}" class="hidden rounded-lg border border-slate-800 bg-slate-900/70 p-6" data-filter-panel>
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Event Type</span>
                    <select name="event_type" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-slate-500 focus:outline-none focus:ring-0">
                        <option value="">Any event type</option>
                        @foreach ($eventTypes as $eventType)
                            <option value="{{ $eventType }}" @selected($filters['event_type'] === $eventType)>{{ $eventType }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Actor</span>
                    <select name="actor_id" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-slate-500 focus:outline-none focus:ring-0">
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
                    <span class="text-sm font-semibold text-slate-200">Result</span>
                    <select name="result" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-slate-500 focus:outline-none focus:ring-0">
                        <option value="">Any result</option>
                        <option value="success" @selected($filters['result'] === 'success')>Success</option>
                        <option value="failure" @selected($filters['result'] === 'failure')>Failure</option>
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Severity</span>
                    <select name="severity" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-slate-500 focus:outline-none focus:ring-0">
                        <option value="">Any severity</option>
                        <option value="info" @selected($filters['severity'] === 'info')>Info</option>
                        <option value="notice" @selected($filters['severity'] === 'notice')>Notice</option>
                        <option value="warning" @selected($filters['severity'] === 'warning')>Warning</option>
                        <option value="error" @selected($filters['severity'] === 'error')>Error</option>
                    </select>
                </label>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <button type="submit" class="inline-flex rounded-md border border-slate-700 px-4 py-3 text-sm font-semibold text-slate-100 transition hover:border-slate-500 hover:text-slate-300">
                    Apply Filters
                </button>

                <a wire:navigate href="{{ route('platform.audit-logs.index') }}" class="inline-flex rounded-md border border-slate-800 px-4 py-3 text-sm font-semibold text-slate-300 transition hover:border-slate-600 hover:text-white">
                    Reset
                </a>
            </div>
        </form>

        <div class="flex flex-wrap items-center gap-3">
            <a wire:navigate href="{{ route('platform.settings.audit-logs') }}" class="inline-flex items-center rounded-md border border-amber-500/50 bg-amber-500/15 px-4 py-2.5 text-sm font-semibold text-amber-100 transition hover:border-amber-400/70 hover:bg-amber-500/25 hover:text-amber-50">
                Audit Settings
            </a>
        </div>

        <div class="overflow-hidden rounded-lg border border-slate-800 bg-slate-900/70">
            <table class="min-w-full divide-y divide-slate-800">
                <thead class="bg-slate-900">
                    <tr class="text-left text-xs uppercase tracking-[0.2em] text-slate-500">
                        <th class="px-6 py-4">Occurred</th>
                        <th class="px-6 py-4">Event</th>
                        <th class="px-6 py-4">Actor</th>
                        <th class="px-6 py-4">Result</th>
                        <th class="px-6 py-4">Severity</th>
                        <th class="px-6 py-4">Route</th>
                        <th class="px-6 py-4">Request</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse ($logs as $log)
                        <tr class="align-top text-sm text-slate-200">
                            <td class="px-6 py-4 text-slate-400">
                                {{ $log->occurredAtForTimezone($viewerTimezone)?->format('M j, Y g:i A T') ?? '—' }}
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-white">{{ $log->event_type }}</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.15em] text-slate-500">{{ $log->action }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if ($log->actorUser)
                                    <p class="font-semibold text-white">{{ $log->actorUser->name }}</p>
                                    <p class="mt-1 text-slate-400">{{ $log->actorUser->email }}</p>
                                @else
                                    <span class="text-slate-500">System</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span @class([
                                    'inline-flex rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em]',
                                    'bg-emerald-500/15 text-emerald-300' => $log->result === 'success',
                                    'bg-rose-500/15 text-rose-300' => $log->result !== 'success',
                                ])>
                                    {{ $log->result }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span @class([
                                    'inline-flex rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em]',
                                    'bg-slate-700/60 text-slate-300' => $log->severity === 'info',
                                    'bg-violet-500/15 text-violet-300' => $log->severity === 'notice',
                                    'bg-amber-500/15 text-amber-300' => $log->severity === 'warning',
                                    'bg-rose-500/15 text-rose-300' => $log->severity === 'error',
                                    'bg-red-600/20 text-red-300' => $log->severity === 'critical',
                                ])>
                                    {{ $log->severity }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-400">
                                <p>{{ $log->route ?? 'n/a' }}</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.15em] text-slate-500">{{ $log->method ?? 'n/a' }}</p>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500">
                                {{ $log->request_id ?? 'n/a' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-sm text-slate-500">No audit log rows match the current filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="flex flex-wrap items-center justify-between gap-4 border-t border-slate-800 px-6 py-4">
                <div class="flex items-center gap-3">
                    <form method="GET" action="{{ route('platform.audit-logs.index') }}" class="flex items-center gap-3">
                        <input type="hidden" name="event_type" value="{{ $filters['event_type'] }}">
                        <input type="hidden" name="actor_id" value="{{ $filters['actor_id'] }}">
                        <input type="hidden" name="result" value="{{ $filters['result'] }}">
                        <input type="hidden" name="severity" value="{{ $filters['severity'] }}">
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

                    <form method="GET" action="{{ route('platform.audit-logs.index') }}">
                        <input type="hidden" name="event_type" value="{{ $filters['event_type'] }}">
                        <input type="hidden" name="actor_id" value="{{ $filters['actor_id'] }}">
                        <input type="hidden" name="result" value="{{ $filters['result'] }}">
                        <input type="hidden" name="severity" value="{{ $filters['severity'] }}">
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
    </section>
</x-layouts.app>
