<x-layouts.app title="Account Preferences">
    <section class="mx-auto w-full max-w-4xl space-y-6">
        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30">
            <p class="text-sm font-medium uppercase tracking-[0.3em] text-slate-300">Account</p>
            <h1 class="mt-3 text-2xl font-semibold text-white">Account Preferences</h1>
            <p class="mt-2 text-sm text-slate-400">Set your personal display defaults for timezone and language.</p>
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
            </div>

            <div class="mt-6">
                <button type="submit" class="inline-flex rounded-md border border-slate-700 px-4 py-2 text-sm font-semibold text-slate-100 transition hover:border-slate-500 hover:text-white">
                    Save Preferences
                </button>
            </div>
        </form>
    </section>
</x-layouts.app>
