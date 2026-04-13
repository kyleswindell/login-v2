<x-layouts.app title="General Email Settings">
    <x-slot:sidebar>
        @include('platform.settings._sidebar', ['active' => 'general'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            <p class="text-sm font-medium uppercase tracking-[0.3em] text-slate-300">Settings — General</p>
            <h1 class="mt-3 text-3xl font-semibold text-white">Email</h1>
            <p class="mt-2 text-slate-400">Configure default sender profile and mail transport behavior.</p>
        </div>

        @if (session('success'))
            <div class="rounded-md border border-emerald-500/30 bg-emerald-500/10 px-5 py-4 text-sm font-medium text-emerald-300">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('platform.settings.general.email.update') }}" class="rounded-lg border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            @csrf
            <div class="grid gap-6 md:grid-cols-2">
                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">From Name</span>
                    <input type="text" name="from_name" value="{{ old('from_name', $fromName) }}" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100" required>
                </label>
                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">From Address</span>
                    <input type="email" name="from_address" value="{{ old('from_address', $fromAddress) }}" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100" required>
                </label>
                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Reply-To Address</span>
                    <input type="email" name="reply_to_address" value="{{ old('reply_to_address', $replyToAddress) }}" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100">
                </label>
                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Mail Driver</span>
                    <select name="mail_driver" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100" required>
                        @foreach (['smtp', 'sendmail', 'log', 'array'] as $driver)
                            <option value="{{ $driver }}" @selected(old('mail_driver', $mailDriver) === $driver)>{{ strtoupper($driver) }}</option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="mt-8 border-t border-slate-800 pt-6">
                <button type="submit" class="rounded-md bg-slate-700/60 px-6 py-3 text-sm font-semibold text-slate-200 ring-1 ring-slate-500/40">Save Email Settings</button>
            </div>
        </form>
    </section>
</x-layouts.app>
