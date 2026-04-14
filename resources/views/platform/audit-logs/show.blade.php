<x-layouts.app title="Audit Log Detail">
    @php($viewerTimezone = auth()->user()?->timezone ?: config('app.timezone'))

    <section class="flex flex-1 flex-col gap-6">
        <div class="flex items-start justify-between gap-4 rounded-lg border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.3em] text-slate-300">Platform Management</p>
                <h1 class="mt-3 text-3xl font-semibold text-white">Audit Log Detail</h1>
                <p class="mt-2 text-slate-400">{{ $log->event_type }}</p>
            </div>
            <a wire:navigate href="{{ route('platform.audit-logs.index') }}" class="ui-action ui-action-ghost mt-1 shrink-0">
                Back to list
            </a>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30">
                <h2 class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Summary</h2>
                <dl class="mt-5 space-y-4">
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Occurred At</dt>
                        <dd class="text-sm text-slate-200">{{ $log->occurredAtForTimezone($viewerTimezone)?->format('M j, Y g:i:s A T') ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Action</dt>
                        <dd class="text-sm text-slate-200">{{ $log->action ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Result</dt>
                        <dd class="text-sm text-slate-200">{{ $log->result ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Severity</dt>
                        <dd class="text-sm text-slate-200">{{ $log->severity ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30">
                <h2 class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Actor And Request</h2>
                <dl class="mt-5 space-y-4">
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Actor</dt>
                        <dd class="text-sm text-slate-200">{{ $log->actorUser?->name ?? 'System' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Email</dt>
                        <dd class="text-sm text-slate-200">{{ $log->actorUser?->email ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Route</dt>
                        <dd class="text-sm text-slate-200">{{ $log->route ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Method</dt>
                        <dd class="text-sm text-slate-200">{{ $log->method ?? '—' }}</dd>
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
                        <dt class="text-xs uppercase tracking-[0.2em] text-slate-500">IP Address</dt>
                        <dd class="text-sm text-slate-200">{{ $log->ip_address ?? '—' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30">
            <h2 class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Subject</h2>
            <p class="mt-4 text-sm text-slate-300">{{ collect([$log->subject_type, $log->subject_id])->filter()->implode(' #') ?: '—' }}</p>
        </div>

        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30">
            <h2 class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-400">Metadata</h2>
            <pre class="mt-4 overflow-x-auto rounded-md border border-slate-700 bg-slate-950 p-5 text-xs font-mono leading-relaxed text-slate-300">{{ json_encode($log->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '—' }}</pre>
        </div>
    </section>
</x-layouts.app>