        <div class="fixed inset-0 z-50 hidden bg-black/60" data-audit-log-modal aria-hidden="true">
            <div class="ui-log-drawer-panel" data-log-drawer-panel tabindex="-1" role="dialog" aria-modal="true" aria-labelledby="audit-log-drawer-title">
                <div class="flex items-start justify-between gap-3 border-b border-slate-800 px-6 py-5">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Audit Log Detail</p>
                        <h2 id="audit-log-drawer-title" class="mt-2 text-2xl font-semibold text-white" data-audit-log-title>—</h2>
                        <p class="mt-2 text-sm text-slate-400" data-audit-log-subtitle>—</p>
                    </div>
                    <button type="button" class="ui-action ui-action-ghost" data-audit-log-close>Close</button>
                </div>

                <div class="overflow-y-auto px-6 py-6">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                            <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Summary</h3>
                            <dl class="mt-3 space-y-2 text-sm text-slate-300">
                                <div class="flex items-center justify-between"><dt>Occurred</dt><dd data-audit-log-occurred>—</dd></div>
                                <div class="flex items-center justify-between"><dt>Result</dt><dd data-audit-log-result>—</dd></div>
                                <div class="flex items-center justify-between"><dt>Severity</dt><dd data-audit-log-severity>—</dd></div>
                                <div class="flex items-center justify-between"><dt>Action</dt><dd data-audit-log-action>—</dd></div>
                            </dl>
                        </div>

                        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                            <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Actor</h3>
                            <dl class="mt-3 space-y-2 text-sm text-slate-300">
                                <div><dt>Name</dt><dd data-audit-log-actor-name>—</dd></div>
                                <div><dt>Email</dt><dd data-audit-log-actor-email>—</dd></div>
                            </dl>
                        </div>
                    </div>

                    <div class="mt-4 rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Request Context</h3>
                        <dl class="mt-3 grid gap-2 text-sm text-slate-300 md:grid-cols-2">
                            <div><dt>Route</dt><dd data-audit-log-route>—</dd></div>
                            <div><dt>Method</dt><dd data-audit-log-method>—</dd></div>
                            <div><dt>Request ID</dt><dd class="break-all" data-audit-log-request>—</dd></div>
                            <div><dt>Trace ID</dt><dd class="break-all" data-audit-log-trace>—</dd></div>
                            <div><dt>IP</dt><dd data-audit-log-ip>—</dd></div>
                            <div><dt>Subject</dt><dd data-audit-log-subject>—</dd></div>
                        </dl>
                    </div>

                    <div class="mt-4 rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Metadata</h3>
                        <pre class="mt-2 max-h-64 overflow-y-auto whitespace-pre-wrap text-xs text-slate-300" data-audit-log-metadata>—</pre>
                    </div>
                </div>
            </div>
        </div>
