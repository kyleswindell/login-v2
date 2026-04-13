@php($generalTab = $generalTab ?? 'general')

<div class="rounded-md border border-slate-800 bg-slate-900/60 p-2">
    <nav class="grid gap-2 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-6">
        <a wire:navigate href="{{ route('platform.settings.general') }}" @class([
            'rounded-md px-3 py-2 text-xs font-semibold uppercase tracking-[0.15em] transition',
            'bg-slate-700/60 text-slate-200 ring-1 ring-slate-500/40' => $generalTab === 'general',
            'text-slate-300 hover:bg-slate-800 hover:text-white' => $generalTab !== 'general',
        ])>General</a>

        <a wire:navigate href="{{ route('platform.settings.general.company-information') }}" @class([
            'rounded-md px-3 py-2 text-xs font-semibold uppercase tracking-[0.15em] transition',
            'bg-slate-700/60 text-slate-200 ring-1 ring-slate-500/40' => $generalTab === 'company-information',
            'text-slate-300 hover:bg-slate-800 hover:text-white' => $generalTab !== 'company-information',
        ])>Company Information</a>

        <a wire:navigate href="{{ route('platform.settings.general.localization') }}" @class([
            'rounded-md px-3 py-2 text-xs font-semibold uppercase tracking-[0.15em] transition',
            'bg-slate-700/60 text-slate-200 ring-1 ring-slate-500/40' => $generalTab === 'localization',
            'text-slate-300 hover:bg-slate-800 hover:text-white' => $generalTab !== 'localization',
        ])>Localization</a>

        <a wire:navigate href="{{ route('platform.settings.general.email') }}" @class([
            'rounded-md px-3 py-2 text-xs font-semibold uppercase tracking-[0.15em] transition',
            'bg-slate-700/60 text-slate-200 ring-1 ring-slate-500/40' => $generalTab === 'email',
            'text-slate-300 hover:bg-slate-800 hover:text-white' => $generalTab !== 'email',
        ])>Email</a>

        <a wire:navigate href="{{ route('platform.settings.general.system-update') }}" @class([
            'rounded-md px-3 py-2 text-xs font-semibold uppercase tracking-[0.15em] transition',
            'bg-slate-700/60 text-slate-200 ring-1 ring-slate-500/40' => $generalTab === 'system-update',
            'text-slate-300 hover:bg-slate-800 hover:text-white' => $generalTab !== 'system-update',
        ])>System Update</a>

        <a wire:navigate href="{{ route('platform.settings.general.system-server-info') }}" @class([
            'rounded-md px-3 py-2 text-xs font-semibold uppercase tracking-[0.15em] transition',
            'bg-slate-700/60 text-slate-200 ring-1 ring-slate-500/40' => $generalTab === 'system-server-info',
            'text-slate-300 hover:bg-slate-800 hover:text-white' => $generalTab !== 'system-server-info',
        ])>System/Server Info</a>
    </nav>
</div>
