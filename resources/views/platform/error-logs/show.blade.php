<x-layouts.app title="Error Log Detail">
    @php($viewerTimezone = auth()->user()?->timezone ?: config('app.timezone'))

    <section class="flex flex-1 flex-col gap-6">
        <div class="flex items-start justify-between gap-4 rounded-lg border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.3em] text-sky-300">Platform Management</p>
                <h1 class="mt-3 text-3xl font-semibold text-white">Error Log Detail</h1>
                <p class="mt-2 text-slate-400">{{ $log->message }}</p>
            </div>
            <a wire:navigate href="{{ route('platform.error-logs.index') }}" class="mt-1 shrink-0 rounded-md border border-slate-700 px-4 py-3 text-sm font-semibold text-slate-300 transition hover:border-slate-600 hover:text-white">
                ← Back to list
            </a>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            {{-- Identity and classification --}}
            <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30">
                <h2 class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Classification</h2>
                <dl class="mt-5 space-y-4">
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Severity</dt>
                        <dd>
                            <span @class([
                                'inline-flex rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em]',
                                'bg-slate-500/15 text-slate-300' => $log->severity === 'debug',
                                'bg-sky-500/15 text-sky-300' => $log->severity === 'info',
                                'bg-amber-500/15 text-amber-300' => $log->severity === 'warning',
                                'bg-rose-500/15 text-rose-300' => $log->severity === 'error',
                                'bg-red-600/20 text-red-300' => $log->severity === 'critical',
                            ])>
                                {{ $log->severity }}
                            </span>
                        </dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Handled</dt>
                        <dd>
                            @if ($log->handled)
                                <span class="inline-flex rounded-full bg-emerald-500/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] text-emerald-300">Handled</span>
                            @else
                                <span class="inline-flex rounded-full bg-rose-500/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] text-rose-300">Unhandled</span>
                            @endif
                        </dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Exception Class</dt>
                        <dd class="text-sm text-slate-200">{{ $log->exception_class ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Error Code</dt>
                        <dd class="text-sm text-slate-200">{{ $log->error_code ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">File</dt>
                        <dd class="break-all text-sm font-mono text-slate-300">{{ $log->file_path ?? '—' }}{{ $log->line_number ? ':' . $log->line_number : '' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Fingerprint</dt>
                        <dd class="break-all text-xs font-mono text-slate-400">{{ $log->fingerprint ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Request context --}}
            <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30">
                <h2 class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Request Context</h2>
                <dl class="mt-5 space-y-4">
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Occurred At</dt>
                        <dd class="text-sm text-slate-200">{{ $log->occurredAtForTimezone($viewerTimezone)?->format('M j, Y g:i:s A T') ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Environment</dt>
                        <dd class="text-sm text-slate-200">{{ $log->environment ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Route</dt>
                        <dd class="text-sm text-slate-200">
                            @if ($log->route || $log->method)
                                <span class="mr-2 rounded bg-slate-800 px-2 py-0.5 text-xs font-mono text-slate-400">{{ $log->method }}</span>{{ $log->route }}
                            @else
                                —
                            @endif
                        </dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Status Code</dt>
                        <dd class="text-sm text-slate-200">{{ $log->status_code ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Request ID</dt>
                        <dd class="break-all text-xs font-mono text-slate-400">{{ $log->request_id ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Trace ID</dt>
                        <dd class="break-all text-xs font-mono text-slate-400">{{ $log->trace_id ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">User / IP</dt>
                        <dd class="text-sm text-slate-200">{{ $log->user_id ? 'User #' . $log->user_id : 'Guest' }} — {{ $log->ip_address ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Hostname</dt>
                        <dd class="text-sm text-slate-200">{{ $log->hostname ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Release Version</dt>
                        <dd class="text-sm text-slate-200">{{ $log->release_version ?? '—' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Stack trace --}}
        @if ($log->stack_trace)
            <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30">
                <h2 class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Stack Trace</h2>
                <pre class="mt-4 overflow-x-auto rounded-md border border-slate-700 bg-slate-950 p-5 text-xs font-mono leading-relaxed text-slate-300">{{ $log->stack_trace }}</pre>
            </div>
        @endif

        {{-- Additional context --}}
        @if ($log->context)
            <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30">
                <h2 class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Context</h2>
                <pre class="mt-4 overflow-x-auto rounded-md border border-slate-700 bg-slate-950 p-5 text-xs font-mono leading-relaxed text-slate-300">{{ json_encode($log->context, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
        @endif
    </section>
</x-layouts.app>
