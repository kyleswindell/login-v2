<x-layouts.app title="Platform Notifications Setup">
    <section class="flex flex-1 flex-col gap-6">
        <div class="rounded-3xl border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            <p class="text-sm font-medium uppercase tracking-[0.3em] text-sky-300">Setup</p>
            <h1 class="mt-3 text-3xl font-semibold text-white">Platform Notifications Setup</h1>
            <p class="mt-2 text-slate-400">Use setup surfaces to manage notification behavior and operational defaults.</p>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <a href="{{ route('platform.administration.notifications.index') }}" class="group rounded-3xl border border-slate-800 bg-slate-900/70 p-6 transition hover:border-sky-500/40 hover:bg-slate-900">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-sky-300">Inbox</p>
                <h2 class="mt-2 text-xl font-semibold text-white">Notification Stream</h2>
                <p class="mt-2 text-sm text-slate-400">Review delivery history and perform read/dismiss workflows.</p>
            </a>

            <a href="{{ route('platform.settings.notifications') }}" class="group rounded-3xl border border-slate-800 bg-slate-900/70 p-6 transition hover:border-sky-500/40 hover:bg-slate-900">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-sky-300">Settings</p>
                <h2 class="mt-2 text-xl font-semibold text-white">Notification Defaults</h2>
                <p class="mt-2 text-sm text-slate-400">Configure default severity and retention policy values.</p>
            </a>
        </div>
    </section>
</x-layouts.app>
