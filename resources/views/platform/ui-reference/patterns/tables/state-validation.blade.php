        <section class="ui-card">
            <p class="ui-kicker">Table State Validation</p>
            <p class="mt-2 text-sm text-slate-400">These static review surfaces make loading and empty states explicit without relying on filter setup during manual review.</p>
            <div class="mt-4 grid gap-6 xl:grid-cols-2">
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Loading State</p>
                    <div class="mt-3 overflow-x-auto rounded-lg border border-slate-800 bg-slate-950/70">
                        <table class="min-w-[640px] w-full divide-y divide-slate-800">
                            <thead class="bg-slate-900">
                                <tr class="text-left text-xs uppercase tracking-[0.2em] text-slate-500">
                                    <th class="px-5 py-3">Name</th>
                                    <th class="px-5 py-3">Owner</th>
                                    <th class="px-5 py-3">Status</th>
                                    <th class="px-5 py-3">Updated</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-slate-300">
                                <tr>
                                    <td colspan="4" class="px-5 py-10">
                                        <div class="flex flex-col items-center justify-center gap-3 text-center">
                                            <span class="ui-spinner" aria-hidden="true"></span>
                                            <div>
                                                <p class="font-semibold text-white">Loading workspace rows</p>
                                                <p class="mt-1 text-slate-400">Use this baseline to verify centered feedback, table framing, and non-jumping layout.</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Empty State</p>
                    <div class="mt-3 overflow-x-auto rounded-lg border border-slate-800 bg-slate-950/70">
                        <table class="min-w-[640px] w-full divide-y divide-slate-800">
                            <thead class="bg-slate-900">
                                <tr class="text-left text-xs uppercase tracking-[0.2em] text-slate-500">
                                    <th class="px-5 py-3">Name</th>
                                    <th class="px-5 py-3">Owner</th>
                                    <th class="px-5 py-3">Status</th>
                                    <th class="px-5 py-3">Updated</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-slate-300">
                                <tr>
                                    <td colspan="4" class="px-5 py-10 text-center">
                                        <p class="font-semibold text-white">No workspace rows matched the current filters.</p>
                                        <p class="mt-2 text-slate-400">The empty state stays inside the table baseline and preserves table structure for review.</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
