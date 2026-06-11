<x-layouts.app title="Audit Log Detail">
    @php($viewerTimezone = auth()->user()?->timezone ?: config('app.timezone'))

    <section class="flex flex-1 flex-col gap-6">
        <div class="flex items-start justify-between gap-4 ui-platform-surface p-8">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.3em] ui-platform-text">Platform Management</p>
                <h1 class="mt-3 text-3xl font-semibold ui-platform-text-strong">Audit Log Detail</h1>
                <p class="mt-2 ui-platform-text-muted">{{ $log->event_type }}</p>
            </div>
            <a wire:navigate href="{{ route('platform.audit-logs.index') }}" class="ui-action ui-action-ghost mt-1 shrink-0">
                Back to list
            </a>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="ui-platform-surface p-6">
                <h2 class="text-sm font-semibold uppercase tracking-[0.25em] ui-platform-text-muted">Summary</h2>
                <dl class="mt-5 space-y-4">
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">Occurred At</dt>
                        <dd class="text-sm ui-platform-text-strong">{{ $log->occurredAtForTimezone($viewerTimezone)?->format('M j, Y g:i:s A T') ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">Action</dt>
                        <dd class="text-sm ui-platform-text-strong">{{ $log->action ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">Result</dt>
                        <dd class="text-sm ui-platform-text-strong">{{ $log->result ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">Severity</dt>
                        <dd class="text-sm ui-platform-text-strong">{{ $log->severity ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="ui-platform-surface p-6">
                <h2 class="text-sm font-semibold uppercase tracking-[0.25em] ui-platform-text-muted">Actor And Request</h2>
                <dl class="mt-5 space-y-4">
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">Actor</dt>
                        <dd class="text-sm ui-platform-text-strong">{{ $log->actorUser?->name ?? 'System' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">Email</dt>
                        <dd class="text-sm ui-platform-text-strong">{{ $log->actorUser?->email ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">Route</dt>
                        <dd class="text-sm ui-platform-text-strong">{{ $log->route ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">Method</dt>
                        <dd class="text-sm ui-platform-text-strong">{{ $log->method ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">Request ID</dt>
                        <dd class="break-all text-xs font-mono ui-platform-text-muted">{{ $log->request_id ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">Trace ID</dt>
                        <dd class="break-all text-xs font-mono ui-platform-text-muted">{{ $log->trace_id ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">IP Address</dt>
                        <dd class="text-sm ui-platform-text-strong">{{ $log->ip_address ?? '—' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="ui-platform-surface p-6">
            <h2 class="text-sm font-semibold uppercase tracking-[0.25em] ui-platform-text-muted">Subject</h2>
            <p class="mt-4 text-sm ui-platform-text">{{ collect([$log->subject_type, $log->subject_id])->filter()->implode(' #') ?: '—' }}</p>
        </div>

        <div class="ui-platform-surface p-6">
            <h2 class="text-sm font-semibold uppercase tracking-[0.25em] ui-platform-text-muted">Metadata</h2>
            <pre class="mt-4 overflow-x-auto ui-platform-code-surface p-5 text-xs font-mono leading-relaxed ui-platform-text">{{ json_encode($log->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '—' }}</pre>
        </div>
    </section>
</x-layouts.app>