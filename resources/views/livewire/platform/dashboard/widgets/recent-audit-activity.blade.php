<section class="overflow-hidden rounded-lg border border-slate-800 bg-slate-900/70">
    <div class="flex items-center justify-between gap-3 border-b border-slate-800 px-5 py-4">
        <div>
            <h2 class="text-base font-semibold text-white">Recent Audit Activity</h2>
            <p class="text-sm text-slate-400">Latest 10 platform audit log entries.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-800">
            <thead class="bg-slate-950/70">
                <tr class="text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                    <th class="px-5 py-3">When</th>
                    <th class="px-5 py-3">Type</th>
                    <th class="px-5 py-3">Action</th>
                    <th class="px-5 py-3">Actor</th>
                    <th class="px-5 py-3">Result</th>
                    <th class="px-5 py-3">Severity</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800 text-sm text-slate-200">
                @forelse ($logs as $log)
                    <tr>
                        <td class="px-5 py-3 text-slate-300">{{ optional($log->occurred_at)->format('Y-m-d H:i') ?? '—' }}</td>
                        <td class="px-5 py-3">{{ $log->event_type }}</td>
                        <td class="px-5 py-3">{{ $log->action }}</td>
                        <td class="px-5 py-3">{{ $log->actor_user_id ?? '—' }}</td>
                        <td class="px-5 py-3">{{ $log->result ?? '—' }}</td>
                        <td class="px-5 py-3">{{ $log->severity ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-6 text-center text-sm text-slate-400">No audit activity recorded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
