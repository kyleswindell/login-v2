<x-layouts.app title="UI Reference · Buttons And Icons">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'components.actions'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">Buttons And Icon Buttons</h1>
            <p class="ui-page-header-copy">Tier 1 contract for action hierarchy, state behavior, and light/dark parity.</p>
        </div>

        <section class="ui-card">
            <p class="ui-kicker">Semantic Actions</p>
            <div class="mt-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                <x-ui.button>Neutral</x-ui.button>
                <x-ui.button semantic="primary">Primary</x-ui.button>
                <x-ui.button semantic="success">Success</x-ui.button>
                <x-ui.button semantic="warning">Warning</x-ui.button>
                <x-ui.button semantic="danger">Danger</x-ui.button>
                <x-ui.button semantic="notice">Notice</x-ui.button>
                <x-ui.button semantic="info">Info</x-ui.button>
                <x-ui.button variant="ghost">Ghost</x-ui.button>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Variant Styles</p>
            <p class="mt-2 text-sm text-slate-400">Soft and outline variants must preserve contrast in both themes.</p>
            <div class="mt-4 space-y-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Soft</p>
                    <div class="mt-3 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                        <x-ui.button variant="soft">Soft Neutral</x-ui.button>
                        <x-ui.button semantic="primary" variant="soft">Soft Primary</x-ui.button>
                        <x-ui.button semantic="success" variant="soft">Soft Success</x-ui.button>
                        <x-ui.button semantic="warning" variant="soft">Soft Warning</x-ui.button>
                        <x-ui.button semantic="danger" variant="soft">Soft Danger</x-ui.button>
                        <x-ui.button semantic="notice" variant="soft">Soft Notice</x-ui.button>
                        <x-ui.button semantic="info" variant="soft">Soft Info</x-ui.button>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Outline</p>
                    <div class="mt-3 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                        <x-ui.button variant="outline">Outline Neutral</x-ui.button>
                        <x-ui.button semantic="primary" variant="outline">Outline Primary</x-ui.button>
                        <x-ui.button semantic="success" variant="outline">Outline Success</x-ui.button>
                        <x-ui.button semantic="warning" variant="outline">Outline Warning</x-ui.button>
                        <x-ui.button semantic="danger" variant="outline">Outline Danger</x-ui.button>
                        <x-ui.button semantic="notice" variant="outline">Outline Notice</x-ui.button>
                        <x-ui.button semantic="info" variant="outline">Outline Info</x-ui.button>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Ghost</p>
                    <div class="mt-3 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                        <x-ui.button variant="ghost">Ghost Neutral</x-ui.button>
                        <x-ui.button semantic="primary" variant="ghost">Ghost Primary</x-ui.button>
                        <x-ui.button semantic="success" variant="ghost">Ghost Success</x-ui.button>
                        <x-ui.button semantic="warning" variant="ghost">Ghost Warning</x-ui.button>
                        <x-ui.button semantic="danger" variant="ghost">Ghost Danger</x-ui.button>
                        <x-ui.button semantic="notice" variant="ghost">Ghost Notice</x-ui.button>
                        <x-ui.button semantic="info" variant="ghost">Ghost Info</x-ui.button>
                    </div>
                </div>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Size And State</p>
            <div class="mt-4 flex flex-wrap items-center gap-3">
                <x-ui.button semantic="primary" size="xs">XS</x-ui.button>
                <x-ui.button semantic="primary" size="sm">SM</x-ui.button>
                <x-ui.button semantic="primary" size="md">MD</x-ui.button>
                <x-ui.button semantic="primary" size="lg">LG</x-ui.button>
                <x-ui.button semantic="primary" size="xl">XL</x-ui.button>
            </div>
            <div class="mt-4 flex flex-wrap items-center gap-3">
                <x-ui.button semantic="primary" disabled>Disabled</x-ui.button>
                <x-ui.button semantic="primary" loading>Loading…</x-ui.button>
                <x-ui.icon-button label="Filter results">
                    <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                </x-ui.icon-button>
                <x-ui.icon-button label="Disabled icon action" disabled>
                    <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                </x-ui.icon-button>
            </div>
            <div class="mt-4 grid gap-3 md:grid-cols-2 xl:grid-cols-3">
                <x-ui.button semantic="primary">
                    <x-heroicon-o-plus class="h-4 w-4" aria-hidden="true" />
                    Create Workspace
                </x-ui.button>
                <x-ui.button variant="outline">
                    <x-heroicon-o-cog-6-tooth class="h-4 w-4" aria-hidden="true" />
                    Open Settings
                </x-ui.button>
                <x-ui.button semantic="warning" variant="outline">
                    <x-heroicon-o-arrow-down-tray class="h-4 w-4" aria-hidden="true" />
                    Export Results
                </x-ui.button>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Review State Matrix</p>
            <p class="mt-2 text-sm text-slate-400">All required Tier 1 action states are visible here for manual inspection.</p>
            <div class="mt-4 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Default</p>
                    <x-ui.button semantic="primary" class="mt-3">Primary Action</x-ui.button>
                </div>
                <div class="rounded-lg border border-sky-400/40 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Hover Snapshot</p>
                    <x-ui.button semantic="primary" class="mt-3 border-blue-500/65 bg-blue-600/35 text-blue-50">Primary Action</x-ui.button>
                </div>
                <div class="rounded-lg border border-sky-400/40 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Focus Snapshot</p>
                    <x-ui.button semantic="primary" class="mt-3 ring-2 ring-sky-400/50 ring-offset-2 ring-offset-slate-900">Primary Action</x-ui.button>
                </div>
                <div class="rounded-lg border border-sky-400/40 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Danger Focus Snapshot</p>
                    <x-ui.button semantic="danger" class="mt-3 ring-2 ring-sky-400/50 ring-offset-2 ring-offset-slate-900">Danger Action</x-ui.button>
                </div>
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Active Snapshot</p>
                    <x-ui.button semantic="primary" class="mt-3 border-blue-700/70 bg-blue-700/45 text-blue-50">Primary Action</x-ui.button>
                </div>
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Disabled</p>
                    <x-ui.button semantic="primary" class="mt-3" disabled>Primary Action</x-ui.button>
                </div>
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Loading</p>
                    <x-ui.button semantic="primary" class="mt-3" loading>Loading</x-ui.button>
                </div>
            </div>
            <div class="mt-4 grid gap-4 md:grid-cols-2">
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Icon Button Focus</p>
                    <x-ui.icon-button label="Focused icon action" class="mt-3 ring-2 ring-sky-400/50 ring-offset-2 ring-offset-slate-900">
                        <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                    </x-ui.icon-button>
                </div>
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Icon Button Disabled</p>
                    <x-ui.icon-button label="Disabled icon action" class="mt-3" disabled>
                        <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                    </x-ui.icon-button>
                </div>
                <div class="rounded-lg border border-sky-400/40 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Icon Button Hover Snapshot</p>
                    <x-ui.icon-button label="Hovered icon action" class="mt-3 border-slate-500 bg-slate-800 text-white shadow-lg shadow-slate-950/40">
                        <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                    </x-ui.icon-button>
                </div>
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Icon Button Active Snapshot</p>
                    <x-ui.icon-button label="Active icon action" class="mt-3 border-slate-600 bg-slate-950 text-white shadow-inner shadow-black/40">
                        <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                    </x-ui.icon-button>
                </div>
            </div>
        </section>
    </section>
</x-layouts.app>
