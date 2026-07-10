<x-layouts.app
    title="Audit Log Settings"
    page-title="Audit Settings"
    page-subtitle="Configure log retention period and the severity level used for login events."
    :reserve-page-tabs="true"
>
    <x-ui.grid-column tag="section" span="100" lg="12" xlg="12">
        @if (session('success'))
            <div class="rounded-md border border-emerald-500/30 bg-emerald-500/10 px-5 py-4 text-sm font-medium text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('platform.settings.audit-logs.update') }}" class="rounded-lg border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
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
                        class="mt-3 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-slate-500 focus:outline-none focus:ring-0"
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
                        class="mt-3 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-slate-500 focus:outline-none focus:ring-0"
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
                <button type="submit" class="rounded-md bg-slate-700/60 px-6 py-3 text-sm font-semibold text-slate-200 ring-1 ring-slate-500/40 transition hover:bg-slate-700/80 hover:text-white">
                    Save Audit Log Settings
                </button>
            </div>
        </form>
    </x-ui.grid-column>
</x-layouts.app>
