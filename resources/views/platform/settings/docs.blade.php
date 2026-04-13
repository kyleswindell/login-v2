<x-layouts.app title="Documentation Vault Settings">
    <x-slot:sidebar>
        @include('platform.settings._sidebar', ['active' => 'docs'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">Vault Access</h1>
            <p class="ui-page-header-copy">Control which platform users can access the internal documentation vault.</p>
        </div>

        @if (session('success'))
            <div class="rounded-md border border-emerald-500/30 bg-emerald-500/10 px-5 py-4 text-sm font-medium text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('platform.settings.docs.update') }}" class="rounded-lg border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            @csrf

            <div>
                <fieldset>
                    <legend class="text-sm font-semibold text-slate-200">Access Scope</legend>
                    <p class="mt-1 text-xs text-slate-500">Determines which authenticated platform users can view documentation vault pages.</p>

                    <div class="mt-4 space-y-3">
                        <label class="flex cursor-pointer items-start gap-4 rounded-md border border-slate-700 bg-slate-950/50 px-5 py-4 transition has-[:checked]:border-slate-500/40 has-[:checked]:bg-slate-700/30">
                            <input
                                type="radio"
                                name="access_scope"
                                value="all_platform_users"
                                @checked(old('access_scope', $accessScope) === 'all_platform_users')
                                class="mt-0.5 accent-slate-300"
                            >
                            <div>
                                <p class="text-sm font-semibold text-white">All Platform Users</p>
                                <p class="mt-1 text-xs text-slate-400">Any authenticated platform user can access the documentation vault.</p>
                            </div>
                        </label>

                        <label class="flex cursor-pointer items-start gap-4 rounded-md border border-slate-700 bg-slate-950/50 px-5 py-4 transition has-[:checked]:border-slate-500/40 has-[:checked]:bg-slate-700/30">
                            <input
                                type="radio"
                                name="access_scope"
                                value="super_admins_only"
                                @checked(old('access_scope', $accessScope) === 'super_admins_only')
                                class="mt-0.5 accent-slate-300"
                            >
                            <div>
                                <p class="text-sm font-semibold text-white">Super Admins Only</p>
                                <p class="mt-1 text-xs text-slate-400">Only users with the platform_super_admin role can access the documentation vault.</p>
                            </div>
                        </label>
                    </div>
                </fieldset>
                @error('access_scope')
                    <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-8 border-t border-slate-800 pt-6">
                <button type="submit" class="rounded-md bg-slate-700/60 px-6 py-3 text-sm font-semibold text-slate-200 ring-1 ring-slate-500/40 transition hover:bg-slate-700/80 hover:text-white">
                    Save Vault Settings
                </button>
            </div>
        </form>
    </section>
</x-layouts.app>
