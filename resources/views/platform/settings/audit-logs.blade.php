<x-layouts.app title="Audit Log Settings">
    <x-slot:sidebar>
        @include('platform.settings._sidebar', ['active' => 'audit-logs'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div class="rounded-3xl border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            <p class="text-sm font-medium uppercase tracking-[0.3em] text-sky-300">Settings — Audit Logs</p>
            <h1 class="mt-3 text-3xl font-semibold text-white">Audit Settings</h1>
            <p class="mt-2 text-slate-400">Configure log retention period and the severity level used for login events.</p>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-5 py-4 text-sm font-medium text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('platform.settings.audit-logs.update') }}" class="rounded-3xl border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            @csrf

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="retention_days" class="block text-sm font-semibold text-slate-200">Retention Period (days)</label>
                    <p class="mt-1 text-xs text-slate-500">Audit log rows older than this are eligible for pruning. Min 7, max 3650.</p>
                    <input
                        id="retention_days"
                        type="number"
                        name="retention_days"
                        value="{{ old('retention_days', $retentionDays) }}"
                        min="7"
                        max="3650"
                        class="mt-3 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-sky-400 focus:outline-none focus:ring-0"
                    >
                    @error('retention_days')
                        <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="login_event_severity" class="block text-sm font-semibold text-slate-200">Login Event Severity</label>
                    <p class="mt-1 text-xs text-slate-500">Severity applied to authentication events in the audit log.</p>
                    <select
                        id="login_event_severity"
                        name="login_event_severity"
                        class="mt-3 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-sky-400 focus:outline-none focus:ring-0"
                    >
                        @foreach (['info', 'notice', 'security'] as $option)
                            <option value="{{ $option }}" @selected(old('login_event_severity', $loginEventSeverity) === $option)>
                                {{ ucfirst($option) }}
                            </option>
                        @endforeach
                    </select>
                    @error('login_event_severity')
                        <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 border-t border-slate-800 pt-6">
                <button type="submit" class="rounded-2xl bg-sky-500/15 px-6 py-3 text-sm font-semibold text-sky-200 ring-1 ring-sky-500/30 transition hover:bg-sky-500/25 hover:text-sky-100">
                    Save Audit Log Settings
                </button>
            </div>
        </form>
    </section>
</x-layouts.app>
