<x-layouts.app
    title="System And Server Info"
    page-title="System/Server Info"
    page-subtitle="Read-only runtime diagnostics for fast environment checks."
>
    <x-slot:pageTabs>
        @include('settings::_general-tabs', ['generalTab' => 'system-server-info'])
    </x-slot:pageTabs>

    <x-ui.grid-column tag="section" span="100" lg="12" xlg="12">
        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            <dl class="grid gap-6 md:grid-cols-2">
                <div><dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Application Environment</dt><dd class="mt-2 text-sm font-semibold text-white">{{ $appEnvironment }}</dd></div>
                <div><dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Laravel Version</dt><dd class="mt-2 text-sm font-semibold text-white">{{ $appVersion }}</dd></div>
                <div><dt class="text-xs uppercase tracking-[0.2em] text-slate-500">PHP Version</dt><dd class="mt-2 text-sm font-semibold text-white">{{ $phpVersion }}</dd></div>
                <div><dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Server Software</dt><dd class="mt-2 text-sm font-semibold text-white">{{ $serverSoftware }}</dd></div>
                <div><dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Database Connection</dt><dd class="mt-2 text-sm font-semibold text-white">{{ $dbConnection }}</dd></div>
                <div><dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Cache Driver</dt><dd class="mt-2 text-sm font-semibold text-white">{{ $cacheDriver }}</dd></div>
                <div><dt class="text-xs uppercase tracking-[0.2em] text-slate-500">Queue Driver</dt><dd class="mt-2 text-sm font-semibold text-white">{{ $queueDriver }}</dd></div>
            </dl>
        </div>
    </x-ui.grid-column>
</x-layouts.app>
