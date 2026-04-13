<x-layouts.app title="Platform Notifications Setup">
    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">Platform Notifications Setup</h1>
            <p class="ui-page-header-copy">Use setup surfaces to manage notification behavior and operational defaults.</p>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <a wire:navigate href="{{ route('platform.administration.notifications.index') }}" class="group rounded-lg border border-slate-800 bg-slate-900/70 p-6 transition hover:border-slate-600 hover:bg-slate-900">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-300">Inbox</p>
                <h2 class="mt-2 text-xl font-semibold text-white">Notification Stream</h2>
                <p class="mt-2 text-sm text-slate-400">Review delivery history and perform read/dismiss workflows.</p>
            </a>

            <a wire:navigate href="{{ route('platform.settings.notifications') }}" class="group rounded-lg border border-slate-800 bg-slate-900/70 p-6 transition hover:border-slate-600 hover:bg-slate-900">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-300">Settings</p>
                <h2 class="mt-2 text-xl font-semibold text-white">Notification Defaults</h2>
                <p class="mt-2 text-sm text-slate-400">Configure default severity and retention policy values.</p>
            </a>
        </div>
    </section>
</x-layouts.app>
