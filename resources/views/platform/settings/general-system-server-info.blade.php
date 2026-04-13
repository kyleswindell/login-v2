<x-layouts.app title="System And Server Info">
    <x-slot:sidebar>
        @include('platform.settings._sidebar', ['active' => 'general'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">System/Server Info</h1>
            <p class="ui-page-header-copy">Read-only runtime diagnostics for fast environment checks.</p>
        </div>

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
    </section>
</x-layouts.app>
