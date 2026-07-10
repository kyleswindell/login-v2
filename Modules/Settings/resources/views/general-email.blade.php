<x-layouts.app
    title="General Email Settings"
    page-title="Email"
    page-subtitle="Configure default sender profile and mail transport behavior."
>
    <x-slot:pageTabs>
        @include('settings::_general-tabs', ['generalTab' => 'email'])
    </x-slot:pageTabs>

    <x-ui.grid-column tag="section" span="100" lg="12" xlg="12">
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
    </x-ui.grid-column>
</x-layouts.app>
