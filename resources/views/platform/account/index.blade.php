<x-layouts.app title="My Account">
    <section class="w-full space-y-6">
        <div>
            <h1 class="ui-page-header-title">My Account</h1>
            <p class="ui-page-header-copy">Manage your profile identity and personal preferences.</p>
        </div>

        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30">
            <dl class="grid gap-5 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Name</dt>
                    <dd class="mt-2 text-sm text-slate-100">{{ $user->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Email</dt>
                    <dd class="mt-2 text-sm text-slate-100">{{ $user->email }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Phone</dt>
                    <dd class="mt-2 text-sm text-slate-100">{{ $user->phone ?: 'Not set' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Timezone</dt>
                    <dd class="mt-2 text-sm text-slate-100">{{ $user->timezone ?: 'Not set' }}</dd>
                </div>
            </dl>
        </div>
    </section>
</x-layouts.app>
