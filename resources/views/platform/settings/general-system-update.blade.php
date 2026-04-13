<x-layouts.app title="System Update Settings">
    <x-slot:sidebar>
        @include('platform.settings._sidebar', ['active' => 'general'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            <p class="text-sm font-medium uppercase tracking-[0.3em] text-slate-300">Settings — General</p>
            <h1 class="mt-3 text-3xl font-semibold text-white">System Update</h1>
            <p class="mt-2 text-slate-400">Choose update channel policy and operational maintenance defaults.</p>
        </div>

        @include('platform.settings._general-tabs', ['generalTab' => 'system-update'])

        @if (session('success'))
            <div class="rounded-md border border-emerald-500/30 bg-emerald-500/10 px-5 py-4 text-sm font-medium text-emerald-300">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('platform.settings.general.system-update.update') }}" class="rounded-lg border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            @csrf
            <div class="grid gap-6 md:grid-cols-2">
                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Update Channel</span>
                    <select name="update_channel" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100" required>
                        <option value="stable" @selected(old('update_channel', $updateChannel) === 'stable')>Stable</option>
                        <option value="preview" @selected(old('update_channel', $updateChannel) === 'preview')>Preview</option>
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Maintenance Window</span>
                    <input type="text" name="maintenance_window" value="{{ old('maintenance_window', $maintenanceWindow) }}" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100">
                </label>

                <label class="flex items-center gap-3 rounded-md border border-slate-800 bg-slate-950 px-4 py-3 text-sm text-slate-200 md:col-span-2">
                    <input type="hidden" name="auto_check" value="0">
                    <input type="checkbox" name="auto_check" value="1" @checked((bool) old('auto_check', $autoCheck)) class="rounded border-slate-600 bg-slate-900 text-slate-300 focus:ring-slate-500">
                    <span>Enable automatic update checks</span>
                </label>
            </div>

            <div class="mt-8 border-t border-slate-800 pt-6">
                <button type="submit" class="rounded-md bg-slate-700/60 px-6 py-3 text-sm font-semibold text-slate-200 ring-1 ring-slate-500/40">Save Update Policy</button>
            </div>
        </form>
    </section>
</x-layouts.app>
