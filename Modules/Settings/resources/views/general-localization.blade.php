<x-layouts.app
    title="Localization Settings"
    page-title="Localization"
    page-subtitle="Default locale formats for language, date/time display, and week start."
>
    <x-slot:pageTabs>
        @include('settings::_general-tabs', ['generalTab' => 'localization'])
    </x-slot:pageTabs>

    <x-ui.grid-column tag="section" span="100" lg="12" xlg="12">
        @if (session('success'))
            <div class="rounded-md border border-emerald-500/30 bg-emerald-500/10 px-5 py-4 text-sm font-medium text-emerald-300">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('platform.settings.general.localization.update') }}" class="rounded-lg border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            @csrf
            <div class="grid gap-6 md:grid-cols-2">
                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Default Language</span>
                    <input type="text" name="default_language" value="{{ old('default_language', $defaultLanguage) }}" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100" required>
                </label>
                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Date Format</span>
                    <input type="text" name="date_format" value="{{ old('date_format', $dateFormat) }}" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100" required>
                </label>
                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Time Format</span>
                    <input type="text" name="time_format" value="{{ old('time_format', $timeFormat) }}" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100" required>
                </label>
                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">First Day Of Week</span>
                    <select name="first_day_of_week" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100" required>
                        <option value="monday" @selected(old('first_day_of_week', $firstDayOfWeek) === 'monday')>Monday</option>
                        <option value="sunday" @selected(old('first_day_of_week', $firstDayOfWeek) === 'sunday')>Sunday</option>
                    </select>
                </label>
            </div>

            <div class="mt-8 border-t border-slate-800 pt-6">
                <button type="submit" class="rounded-md bg-slate-700/60 px-6 py-3 text-sm font-semibold text-slate-200 ring-1 ring-slate-500/40">Save Localization</button>
            </div>
        </form>
    </x-ui.grid-column>
</x-layouts.app>
