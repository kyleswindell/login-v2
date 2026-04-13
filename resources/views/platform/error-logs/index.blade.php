<x-layouts.app title="Error Logs">
    @php($viewerTimezone = auth()->user()?->timezone ?: config('app.timezone'))

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">Error Logs</h1>
            <p class="ui-page-header-copy">Review platform-level errors and operational failures captured at runtime.</p>
        </div>

        <form method="GET" action="{{ route('platform.error-logs.index') }}" class="rounded-lg border border-slate-800 bg-slate-900/70 p-6">
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
                    <input type="text" name="environment" value="{{ $filters['environment'] }}" placeholder="e.g. staging" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-slate-500 focus:outline-none focus:ring-0">
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Exception Class</span>
                    <input type="text" name="exception_class" value="{{ $filters['exception_class'] }}" placeholder="e.g. RuntimeException" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-slate-500 focus:outline-none focus:ring-0">
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
                                <a wire:navigate href="{{ route('platform.error-logs.show', $log) }}" class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-300 transition hover:text-slate-300">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-sm text-slate-500">No error log rows match the current filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $logs->links() }}
    </section>
</x-layouts.app>
