<x-layouts.app title="Account Preferences">
    <section class="w-full space-y-6">
        <div>
            <h1 class="ui-page-header-title">Account Preferences</h1>
            <p class="ui-page-header-copy">Set your personal defaults for timezone, language, and theme mode.</p>
        </div>

        @if (session('success'))
            <div class="rounded-md border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-md border border-rose-500/30 bg-rose-500/10 px-4 py-3 text-sm text-rose-200">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('platform.account.preferences.update') }}" class="rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30">
            @csrf

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="timezone" class="block text-sm font-semibold text-slate-200">Timezone</label>
                    <input id="timezone" name="timezone" type="text" value="{{ old('timezone', $user->timezone) }}" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950/70 px-3 py-2 text-sm text-slate-100 focus:border-slate-500 focus:outline-none">
                </div>
                <div>
                    <label for="default_language" class="block text-sm font-semibold text-slate-200">Default Language</label>
                    <input id="default_language" name="default_language" type="text" value="{{ old('default_language', $user->default_language) }}" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950/70 px-3 py-2 text-sm text-slate-100 focus:border-slate-500 focus:outline-none">
                </div>
                <div>
                    <label for="theme_preference" class="block text-sm font-semibold text-slate-200">Theme Mode</label>
                    <select id="theme_preference" name="theme_preference" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950/70 px-3 py-2 text-sm text-slate-100 focus:border-slate-500 focus:outline-none">
                        <option value="system" @selected(old('theme_preference', $user->theme_preference ?? 'system') === 'system')>System</option>
                        <option value="dark" @selected(old('theme_preference', $user->theme_preference ?? 'system') === 'dark')>Dark</option>
                        <option value="light" @selected(old('theme_preference', $user->theme_preference ?? 'system') === 'light')>Light</option>
                    </select>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="inline-flex rounded-md border border-slate-700 px-4 py-2 text-sm font-semibold text-slate-100 transition hover:border-slate-500 hover:text-white">
                    Save Preferences
                </button>
            </div>
        </form>
    </section>
</x-layouts.app>
