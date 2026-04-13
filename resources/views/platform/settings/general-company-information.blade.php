<x-layouts.app title="Company Information Settings">
    <x-slot:sidebar>
        @include('platform.settings._sidebar', ['active' => 'general'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">Company Information</h1>
            <p class="ui-page-header-copy">Core organization details used across platform communication and branding surfaces.</p>
        </div>

        @if (session('success'))
            <div class="rounded-md border border-emerald-500/30 bg-emerald-500/10 px-5 py-4 text-sm font-medium text-emerald-300">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('platform.settings.general.company-information.update') }}" class="rounded-lg border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            @csrf
            <div class="grid gap-6 md:grid-cols-2">
                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Company Name</span>
                    <input type="text" name="company_name" value="{{ old('company_name', $companyName) }}" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100" required>
                </label>
                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Company Email</span>
                    <input type="email" name="company_email" value="{{ old('company_email', $companyEmail) }}" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100">
                </label>
                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Company Phone</span>
                    <input type="text" name="company_phone" value="{{ old('company_phone', $companyPhone) }}" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100">
                </label>
                <label class="block md:col-span-2">
                    <span class="text-sm font-semibold text-slate-200">Company Address</span>
                    <textarea name="company_address" rows="4" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100">{{ old('company_address', $companyAddress) }}</textarea>
                </label>
            </div>

            <div class="mt-8 border-t border-slate-800 pt-6">
                <button type="submit" class="rounded-md bg-slate-700/60 px-6 py-3 text-sm font-semibold text-slate-200 ring-1 ring-slate-500/40">Save Company Information</button>
            </div>
        </form>
    </section>
</x-layouts.app>
