<x-layouts.app title="Platform Users Setup">
    <section class="flex flex-1 flex-col gap-6">
        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            <p class="text-sm font-medium uppercase tracking-[0.3em] text-sky-300">Setup</p>
            <h1 class="mt-3 text-3xl font-semibold text-white">Platform Users Setup</h1>
            <p class="mt-2 text-slate-400">Manage staff lifecycle actions from one setup surface instead of routing setup links directly into feature list pages.</p>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            <a wire:navigate href="{{ route('platform.users.create') }}" class="group rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30 transition hover:border-sky-500/40 hover:bg-slate-900">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-sky-300">Create</p>
                <h2 class="mt-2 text-xl font-semibold text-white">Add Staff Member</h2>
                <p class="mt-2 text-sm text-slate-400">Create a new platform user and assign initial role access.</p>
                <p class="mt-4 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 group-hover:text-sky-300">Open create form</p>
            </a>

            <a wire:navigate href="{{ route('platform.users.index') }}" class="group rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30 transition hover:border-sky-500/40 hover:bg-slate-900">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-sky-300">Review</p>
                <h2 class="mt-2 text-xl font-semibold text-white">Existing Staff</h2>
                <p class="mt-2 text-sm text-slate-400">View all users and open individual records for edit/update workflows.</p>
                <p class="mt-4 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 group-hover:text-sky-300">Open user list</p>
            </a>

            <a wire:navigate href="{{ route('platform.settings.users') }}" class="group rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30 transition hover:border-sky-500/40 hover:bg-slate-900">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-sky-300">Defaults</p>
                <h2 class="mt-2 text-xl font-semibold text-white">User Settings</h2>
                <p class="mt-2 text-sm text-slate-400">Set default role and default active/inactive behavior for new users.</p>
                <p class="mt-4 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 group-hover:text-sky-300">Open settings page</p>
            </a>
        </div>
    </section>
</x-layouts.app>
