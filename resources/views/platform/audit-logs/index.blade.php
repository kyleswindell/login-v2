<x-layouts.app title="Audit Logs">
    @php($viewerTimezone = auth()->user()?->timezone ?: config('app.timezone'))

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">Audit Logs</h1>
            <p class="ui-page-header-copy">Review current platform activity events and auth-related audit history.</p>
        </div>

        <form method="GET" action="{{ route('platform.audit-logs.index') }}" class="rounded-lg border border-slate-800 bg-slate-900/70 p-6">
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Event Type</span>
                    <input type="text" name="event_type" value="{{ $filters['event_type'] }}" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-slate-500 focus:outline-none focus:ring-0">
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Actor</span>
                    <input type="text" name="actor" value="{{ $filters['actor'] }}" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-slate-500 focus:outline-none focus:ring-0">
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

        <div class="overflow-hidden rounded-lg border border-slate-800 bg-slate-900/70">
            <table class="min-w-full divide-y divide-slate-800">
                <thead class="bg-slate-900">
                    <tr class="text-left text-xs uppercase tracking-[0.2em] text-slate-500">
                        <th class="px-6 py-4">Occurred</th>
                        <th class="px-6 py-4">Event</th>
                        <th class="px-6 py-4">Actor</th>
                        <th class="px-6 py-4">Result</th>
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

                                <div class="mt-2 text-xs text-slate-500">{{ $log->severity }}</div>
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
                            <td colspan="6" class="px-6 py-8 text-center text-sm text-slate-500">No audit log rows match the current filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $logs->links() }}
    </section>
</x-layouts.app>
