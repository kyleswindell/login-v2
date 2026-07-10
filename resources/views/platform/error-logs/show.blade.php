<x-layouts.app title="Error Log Detail">
    @php($viewerTimezone = auth()->user()?->timezone ?: config('app.timezone'))

    <section class="flex flex-1 flex-col gap-6">
        <div class="flex items-start justify-between gap-4 ui-platform-surface p-8">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.3em] ui-platform-text">Platform Management</p>
                <h1 class="mt-3 text-3xl font-semibold ui-platform-text-strong">Error Log Detail</h1>
                <p class="mt-2 ui-platform-text-muted">{{ $log->message }}</p>
            </div>
            <a wire:navigate href="{{ route('platform.error-logs.index') }}" class="mt-1 shrink-0 rounded-md ui-platform-border-strong border px-4 py-3 text-sm font-semibold ui-platform-text transition ">
                ← Back to list
            </a>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            {{-- Identity and classification --}}
            <div class="ui-platform-surface p-6">
                <h2 class="text-sm font-semibold uppercase tracking-[0.25em] ui-platform-text-muted">Classification</h2>
                <dl class="mt-5 space-y-4">
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">Severity</dt>
                        <dd>
                            <x-ui.tag
                                :label="$log->severity"
                                :tone="match ($log->severity) { 'warning' => 'warning', 'error', 'critical' => 'danger', 'info' => 'info', default => 'neutral' }"
                                size="sm"
                            />
                        </dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">Handled</dt>
                        <dd>
                            @if ($log->handled)
                                <x-ui.tag label="Handled" tone="success" size="sm" />
                            @else
                                <x-ui.tag label="Unhandled" tone="danger" size="sm" />
                            @endif
                        </dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">Exception Class</dt>
                        <dd class="text-sm ui-platform-text-strong">{{ $log->exception_class ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">Error Code</dt>
                        <dd class="text-sm ui-platform-text-strong">{{ $log->error_code ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">File</dt>
                        <dd class="break-all text-sm font-mono ui-platform-text">{{ $log->file_path ?? '—' }}{{ $log->line_number ? ':' . $log->line_number : '' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">Fingerprint</dt>
                        <dd class="break-all text-xs font-mono ui-platform-text-muted">{{ $log->fingerprint ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Request context --}}
            <div class="ui-platform-surface p-6">
                <h2 class="text-sm font-semibold uppercase tracking-[0.25em] ui-platform-text-muted">Request Context</h2>
                <dl class="mt-5 space-y-4">
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">Occurred At</dt>
                        <dd class="text-sm ui-platform-text-strong">{{ $log->occurredAtForTimezone($viewerTimezone)?->format('M j, Y g:i:s A T') ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">Environment</dt>
                        <dd class="text-sm ui-platform-text-strong">{{ $log->environment ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">Route</dt>
                        <dd class="text-sm ui-platform-text-strong">
                            @if ($log->route || $log->method)
                                <span class="mr-2 rounded ui-platform-code-chip text-xs">{{ $log->method }}</span>{{ $log->route }}
                            @else
                                —
                            @endif
                        </dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">Status Code</dt>
                        <dd class="text-sm ui-platform-text-strong">{{ $log->status_code ?? '—' }}</dd>
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
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">User / IP</dt>
                        <dd class="text-sm ui-platform-text-strong">{{ $log->user_id ? 'User #' . $log->user_id : 'Guest' }} — {{ $log->ip_address ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">Hostname</dt>
                        <dd class="text-sm ui-platform-text-strong">{{ $log->hostname ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-[0.2em] ui-platform-text-muted">Release Version</dt>
                        <dd class="text-sm ui-platform-text-strong">{{ $log->release_version ?? '—' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Stack trace --}}
        @if ($log->stack_trace)
            <div class="ui-platform-surface p-6">
                <h2 class="text-sm font-semibold uppercase tracking-[0.25em] ui-platform-text-muted">Stack Trace</h2>
                <pre class="mt-4 overflow-x-auto ui-platform-code-surface p-5 text-xs font-mono leading-relaxed ui-platform-text">{{ $log->stack_trace }}</pre>
            </div>
        @endif

        {{-- Additional context --}}
        @if ($log->context)
            <div class="ui-platform-surface p-6">
                <h2 class="text-sm font-semibold uppercase tracking-[0.25em] ui-platform-text-muted">Context</h2>
                <pre class="mt-4 overflow-x-auto ui-platform-code-surface p-5 text-xs font-mono leading-relaxed ui-platform-text">{{ json_encode($log->context, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
        @endif
    </section>
</x-layouts.app>
