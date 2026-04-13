<x-layouts.app title="Platform User Settings">
    <x-slot:sidebar>
        @include('platform.settings._sidebar', ['active' => 'users'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">User Defaults</h1>
            <p class="ui-page-header-copy">Configure default role assignment and active state for newly created platform users.</p>
        </div>

        @if (session('success'))
            <div class="rounded-md border border-emerald-500/30 bg-emerald-500/10 px-5 py-4 text-sm font-medium text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('platform.settings.users.update') }}" class="rounded-lg border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            @csrf

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="default_role" class="block text-sm font-semibold text-slate-200">Default Role</label>
                    <p class="mt-1 text-xs text-slate-500">Role assigned to new platform users when no role is specified at creation.</p>
                    <select
                        id="default_role"
                        name="default_role"
                        class="mt-3 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-slate-500 focus:outline-none focus:ring-0"
                    >
                        <option value="platform_operator" @selected(old('default_role', $defaultRole) === 'platform_operator')>Platform Operator</option>
                        <option value="platform_admin" @selected(old('default_role', $defaultRole) === 'platform_admin')>Platform Admin</option>
                        <option value="platform_super_admin" @selected(old('default_role', $defaultRole) === 'platform_super_admin')>Super Admin</option>
                    </select>
                    @error('default_role')
                        <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <fieldset>
                        <legend class="text-sm font-semibold text-slate-200">Default Active State</legend>
                        <p class="mt-1 text-xs text-slate-500">Whether new platform users are set as active immediately upon creation.</p>

                        <div class="mt-3 space-y-2">
                            <label class="flex cursor-pointer items-center gap-3">
                                <input
                                    type="radio"
                                    name="default_active"
                                    value="1"
                                    @checked((bool) old('default_active', $defaultActive))
                                    class="accent-slate-300"
                                >
                                <span class="text-sm text-slate-200">Active</span>
                            </label>
                            <label class="flex cursor-pointer items-center gap-3">
                                <input
                                    type="radio"
                                    name="default_active"
                                    value="0"
                                    @checked(! (bool) old('default_active', $defaultActive))
                                    class="accent-slate-300"
                                >
                                <span class="text-sm text-slate-200">Inactive (requires manual activation)</span>
                            </label>
                        </div>
                    </fieldset>
                    @error('default_active')
                        <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 border-t border-slate-800 pt-6">
                <button type="submit" class="rounded-md bg-slate-700/60 px-6 py-3 text-sm font-semibold text-slate-200 ring-1 ring-slate-500/40 transition hover:bg-slate-700/80 hover:text-white">
                    Save User Settings
                </button>
            </div>
        </form>
    </section>
</x-layouts.app>
