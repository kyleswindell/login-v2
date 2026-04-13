<x-layouts.app title="Error Logs Setup">
    <section class="flex flex-1 flex-col gap-6">
        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            <p class="text-sm font-medium uppercase tracking-[0.3em] text-slate-300">Setup</p>
            <h1 class="mt-3 text-3xl font-semibold text-white">Error Logs Setup</h1>
            <p class="mt-2 text-slate-400">Use this setup entry to reach operational error review surfaces and related policies.</p>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <a wire:navigate href="{{ route('platform.operations.error-logs.index') }}" class="group rounded-lg border border-slate-800 bg-slate-900/70 p-6 transition hover:border-slate-600 hover:bg-slate-900">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-300">Viewer</p>
                <h2 class="mt-2 text-xl font-semibold text-white">Error Log Viewer</h2>
                <p class="mt-2 text-sm text-slate-400">Inspect runtime failures with filterable list and detailed stack traces.</p>
            </a>

            <a wire:navigate href="{{ route('platform.settings.general.system-server-info') }}" class="group rounded-lg border border-slate-800 bg-slate-900/70 p-6 transition hover:border-slate-600 hover:bg-slate-900">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-300">System</p>
                <h2 class="mt-2 text-xl font-semibold text-white">System/Server Info</h2>
                <p class="mt-2 text-sm text-slate-400">Open runtime system information for fast environment diagnostics.</p>
            </a>
        </div>
    </section>
</x-layouts.app>
