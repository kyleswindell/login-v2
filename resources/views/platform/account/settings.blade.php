<x-layouts.app title="Account Settings">
    <section class="w-full space-y-6">
        <div>
            <h1 class="ui-page-header-title">Account Settings</h1>
            <p class="ui-page-header-copy">Update your profile details and security credentials.</p>
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

        <form method="POST" action="{{ route('platform.account.settings.update') }}" class="rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30">
            @csrf

            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="name" class="block text-sm font-semibold text-slate-200">Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950/70 px-3 py-2 text-sm text-slate-100 focus:border-slate-500 focus:outline-none">
                </div>
                <div class="sm:col-span-2">
                    <label for="email" class="block text-sm font-semibold text-slate-200">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950/70 px-3 py-2 text-sm text-slate-100 focus:border-slate-500 focus:outline-none">
                </div>
                <div class="sm:col-span-2">
                    <label for="phone" class="block text-sm font-semibold text-slate-200">Phone</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950/70 px-3 py-2 text-sm text-slate-100 focus:border-slate-500 focus:outline-none">
                </div>
            </div>

            <div class="mt-8 border-t border-slate-800 pt-6">
                <p class="text-sm font-semibold text-white">Password & Security</p>
                <p class="mt-1 text-xs text-slate-500">Provide your current password to set a new password.</p>

                <div class="mt-5 grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="current_password" class="block text-sm font-semibold text-slate-200">Current Password</label>
                        <input id="current_password" name="current_password" type="password" autocomplete="current-password" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950/70 px-3 py-2 text-sm text-slate-100 focus:border-slate-500 focus:outline-none">
                    </div>
                    <div>
                        <label for="new_password" class="block text-sm font-semibold text-slate-200">New Password</label>
                        <input id="new_password" name="new_password" type="password" autocomplete="new-password" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950/70 px-3 py-2 text-sm text-slate-100 focus:border-slate-500 focus:outline-none">
                    </div>
                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-semibold text-slate-200">Confirm New Password</label>
                        <input id="new_password_confirmation" name="new_password_confirmation" type="password" autocomplete="new-password" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950/70 px-3 py-2 text-sm text-slate-100 focus:border-slate-500 focus:outline-none">
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="inline-flex rounded-md border border-slate-700 px-4 py-2 text-sm font-semibold text-slate-100 transition hover:border-slate-500 hover:text-white">
                    Save Settings
                </button>
            </div>
        </form>
    </section>
</x-layouts.app>
