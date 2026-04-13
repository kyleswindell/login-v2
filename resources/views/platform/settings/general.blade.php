<x-layouts.app title="Platform General Settings">
    <x-slot:sidebar>
        @include('platform.settings._sidebar', ['active' => 'general'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            <p class="text-sm font-medium uppercase tracking-[0.3em] text-slate-300">Settings — General</p>
            <h1 class="mt-3 text-3xl font-semibold text-white">Platform General</h1>
            <p class="mt-2 text-slate-400">Configure the platform display name, default timezone, and locale.</p>
        </div>

        @include('platform.settings._general-tabs', ['generalTab' => 'general'])

        @if (session('success'))
            <div class="rounded-md border border-emerald-500/30 bg-emerald-500/10 px-5 py-4 text-sm font-medium text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('platform.settings.general.update') }}" class="rounded-lg border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            @csrf

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="display_name" class="block text-sm font-semibold text-slate-200">Display Name</label>
                    <p class="mt-1 text-xs text-slate-500">The name shown in the platform header and emails.</p>
                    <input
                        id="display_name"
                        type="text"
                        name="display_name"
                        value="{{ old('display_name', $displayName) }}"
                        class="mt-3 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-slate-500 focus:outline-none focus:ring-0"
                    >
                    @error('display_name')
                        <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="timezone" class="block text-sm font-semibold text-slate-200">Default Timezone</label>
                    <p class="mt-1 text-xs text-slate-500">Used for display formatting where no user timezone is set.</p>
                    <input
                        id="timezone"
                        type="text"
                        name="timezone"
                        value="{{ old('timezone', $timezone) }}"
                        placeholder="e.g. America/New_York"
                        class="mt-3 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-slate-500 focus:outline-none focus:ring-0"
                    >
                    @error('timezone')
                        <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="locale" class="block text-sm font-semibold text-slate-200">Default Locale</label>
                    <p class="mt-1 text-xs text-slate-500">Used for formatting numbers, dates, and currency.</p>
                    <input
                        id="locale"
                        type="text"
                        name="locale"
                        value="{{ old('locale', $locale) }}"
                        placeholder="e.g. en"
                        class="mt-3 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-slate-500 focus:outline-none focus:ring-0"
                    >
                    @error('locale')
                        <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 border-t border-slate-800 pt-6">
                <button type="submit" class="rounded-md bg-slate-700/60 px-6 py-3 text-sm font-semibold text-slate-200 ring-1 ring-slate-500/40 transition hover:bg-slate-700/80 hover:text-white">
                    Save General Settings
                </button>
            </div>
        </form>
    </section>
</x-layouts.app>
