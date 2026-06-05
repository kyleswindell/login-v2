        <div class="fixed inset-0 z-50 hidden bg-black/60" data-error-log-modal aria-hidden="true">
            <div class="ui-log-drawer-panel" data-log-drawer-panel tabindex="-1" role="dialog" aria-modal="true" aria-labelledby="error-log-drawer-title">
                <div class="flex items-start justify-between gap-3 border-b border-slate-800 px-6 py-5">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Error Log Detail</p>
                        <h2 id="error-log-drawer-title" class="mt-2 text-2xl font-semibold text-white" data-error-log-title>—</h2>
                        <p class="mt-2 text-sm text-slate-400" data-error-log-subtitle>—</p>
                    </div>
                    <button type="button" class="ui-action ui-action-ghost" data-error-log-close>Close</button>
                </div>

                <div class="overflow-y-auto px-6 py-6">
                    <div class="grid gap-4 md:grid-cols-2">
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
                        <pre class="mt-2 max-h-56 overflow-y-auto whitespace-pre-wrap text-xs text-slate-300" data-error-log-trace-stack>—</pre>
                    </div>

                    <div class="mt-4 rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Context</h3>
                        <pre class="mt-2 max-h-56 overflow-y-auto whitespace-pre-wrap text-xs text-slate-300" data-error-log-context>—</pre>
                    </div>
                </div>
            </div>
        </div>
