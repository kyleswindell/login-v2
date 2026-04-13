<x-layouts.app title="Documentation Vault Setup">
    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">Documentation Vault Setup</h1>
            <p class="ui-page-header-copy">Manage vault access policy and then review rendered docs in the viewer.</p>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <a wire:navigate href="{{ route('platform.settings.docs') }}" class="group rounded-lg border border-slate-800 bg-slate-900/70 p-6 transition hover:border-slate-600 hover:bg-slate-900">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-300">Settings</p>
                <h2 class="mt-2 text-xl font-semibold text-white">Vault Access</h2>
                <p class="mt-2 text-sm text-slate-400">Define who can view docs: all platform users or super admins only.</p>
            </a>

            <a wire:navigate href="{{ route('platform.docs.index') }}" class="group rounded-lg border border-slate-800 bg-slate-900/70 p-6 transition hover:border-slate-600 hover:bg-slate-900">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-300">Viewer</p>
                <h2 class="mt-2 text-xl font-semibold text-white">Documentation Vault</h2>
                <p class="mt-2 text-sm text-slate-400">Open the docs repository viewer as currently exposed to your role.</p>
            </a>
        </div>
    </section>
</x-layouts.app>
