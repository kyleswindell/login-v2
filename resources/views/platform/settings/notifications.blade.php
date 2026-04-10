<x-layouts.app title="Notification Settings">
    <x-slot:sidebar>
        @include('platform.settings._sidebar', ['active' => 'notifications'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div class="rounded-3xl border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            <p class="text-sm font-medium uppercase tracking-[0.3em] text-sky-300">Settings — Platform Notifications</p>
            <h1 class="mt-3 text-3xl font-semibold text-white">Notification Defaults</h1>
            <p class="mt-2 text-slate-400">Configure default severity and per-user notification retention limits.</p>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-5 py-4 text-sm font-medium text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('platform.settings.notifications.update') }}" class="rounded-3xl border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            @csrf

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="default_severity" class="block text-sm font-semibold text-slate-200">Default Severity</label>
                    <p class="mt-1 text-xs text-slate-500">Applied when a notification is created without an explicit severity.</p>
                    <select
                        id="default_severity"
                        name="default_severity"
                        class="mt-3 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-sky-400 focus:outline-none focus:ring-0"
                    >
                        @foreach (['info', 'notice', 'success', 'warning', 'error', 'urgent'] as $option)
                            <option value="{{ $option }}" @selected(old('default_severity', $defaultSeverity) === $option)>
                                {{ ucfirst($option) }}
                            </option>
                        @endforeach
                    </select>
                    @error('default_severity')
                        <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="max_per_user" class="block text-sm font-semibold text-slate-200">Max Notifications Per User</label>
                    <p class="mt-1 text-xs text-slate-500">Oldest notifications are pruned when this limit is exceeded. Min 10, max 10000.</p>
                    <input
                        id="max_per_user"
                        type="number"
                        name="max_per_user"
                        value="{{ old('max_per_user', $maxPerUser) }}"
                        min="10"
                        max="10000"
                        class="mt-3 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-sky-400 focus:outline-none focus:ring-0"
                    >
                    @error('max_per_user')
                        <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 border-t border-slate-800 pt-6">
                <button type="submit" class="rounded-2xl bg-sky-500/15 px-6 py-3 text-sm font-semibold text-sky-200 ring-1 ring-sky-500/30 transition hover:bg-sky-500/25 hover:text-sky-100">
                    Save Notification Settings
                </button>
            </div>
        </form>
    </section>
</x-layouts.app>
