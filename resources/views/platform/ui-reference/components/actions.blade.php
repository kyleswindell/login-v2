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
                <button type="button" class="ui-action">Neutral</button>
                <button type="button" class="ui-action ui-action-primary">Primary</button>
                <button type="button" class="ui-action ui-action-success">Success</button>
                <button type="button" class="ui-action ui-action-warning">Warning</button>
                <button type="button" class="ui-action ui-action-danger">Danger</button>
                <button type="button" class="ui-action ui-action-notice">Notice</button>
                <button type="button" class="ui-action ui-action-info">Info</button>
                <button type="button" class="ui-action ui-action-ghost">Ghost</button>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Variant Styles</p>
            <p class="mt-2 text-sm text-slate-400">Soft and outline variants must preserve contrast in both themes.</p>
            <div class="mt-4 space-y-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Soft</p>
                    <div class="mt-3 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                        <button type="button" class="ui-action ui-action-soft">Soft Neutral</button>
                        <button type="button" class="ui-action ui-action-primary ui-action-soft">Soft Primary</button>
                        <button type="button" class="ui-action ui-action-success ui-action-soft">Soft Success</button>
                        <button type="button" class="ui-action ui-action-warning ui-action-soft">Soft Warning</button>
                        <button type="button" class="ui-action ui-action-danger ui-action-soft">Soft Danger</button>
                        <button type="button" class="ui-action ui-action-notice ui-action-soft">Soft Notice</button>
                        <button type="button" class="ui-action ui-action-info ui-action-soft">Soft Info</button>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Outline</p>
                    <div class="mt-3 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                        <button type="button" class="ui-action ui-action-outline">Outline Neutral</button>
                        <button type="button" class="ui-action ui-action-primary ui-action-outline">Outline Primary</button>
                        <button type="button" class="ui-action ui-action-success ui-action-outline">Outline Success</button>
                        <button type="button" class="ui-action ui-action-warning ui-action-outline">Outline Warning</button>
                        <button type="button" class="ui-action ui-action-danger ui-action-outline">Outline Danger</button>
                        <button type="button" class="ui-action ui-action-notice ui-action-outline">Outline Notice</button>
                        <button type="button" class="ui-action ui-action-info ui-action-outline">Outline Info</button>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Ghost</p>
                    <div class="mt-3 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                        <button type="button" class="ui-action ui-action-ghost">Ghost Neutral</button>
                        <button type="button" class="ui-action ui-action-primary ui-action-ghost">Ghost Primary</button>
                        <button type="button" class="ui-action ui-action-success ui-action-ghost">Ghost Success</button>
                        <button type="button" class="ui-action ui-action-warning ui-action-ghost">Ghost Warning</button>
                        <button type="button" class="ui-action ui-action-danger ui-action-ghost">Ghost Danger</button>
                        <button type="button" class="ui-action ui-action-notice ui-action-ghost">Ghost Notice</button>
                        <button type="button" class="ui-action ui-action-info ui-action-ghost">Ghost Info</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Size And State</p>
            <div class="mt-4 flex flex-wrap items-center gap-3">
                <button type="button" class="ui-action ui-action-primary ui-action-xs">XS</button>
                <button type="button" class="ui-action ui-action-primary ui-action-sm">SM</button>
                <button type="button" class="ui-action ui-action-primary ui-action-md">MD</button>
                <button type="button" class="ui-action ui-action-primary ui-action-lg">LG</button>
                <button type="button" class="ui-action ui-action-primary ui-action-xl">XL</button>
            </div>
            <div class="mt-4 flex flex-wrap items-center gap-3">
                <button type="button" disabled class="ui-action ui-action-primary">Disabled</button>
                <button type="button" class="ui-action ui-action-primary" aria-busy="true">
                    <span class="ui-spinner ui-spinner-inverse" aria-hidden="true"></span>
                    Loading…
                </button>
                <button type="button" class="ui-icon-button" aria-label="Filter results">
                    <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                </button>
                <button type="button" disabled class="ui-icon-button" aria-label="Disabled icon action">
                    <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                </button>
            </div>
            <div class="mt-4 grid gap-3 md:grid-cols-2 xl:grid-cols-3">
                <button type="button" class="ui-action ui-action-primary">
                    <x-heroicon-o-plus class="h-4 w-4" aria-hidden="true" />
                    Create Workspace
                </button>
                <button type="button" class="ui-action ui-action-outline">
                    <x-heroicon-o-cog-6-tooth class="h-4 w-4" aria-hidden="true" />
                    Open Settings
                </button>
                <button type="button" class="ui-action ui-action-warning ui-action-outline">
                    <x-heroicon-o-arrow-down-tray class="h-4 w-4" aria-hidden="true" />
                    Export Results
                </button>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Review State Matrix</p>
            <p class="mt-2 text-sm text-slate-400">All required Tier 1 action states are visible here for manual inspection.</p>
            <div class="mt-4 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Default</p>
                    <button type="button" class="mt-3 ui-action ui-action-primary">Primary Action</button>
                </div>
                <div class="rounded-lg border border-sky-400/40 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Hover Snapshot</p>
                    <button type="button" class="mt-3 ui-action ui-action-primary border-blue-500/65 bg-blue-600/35 text-blue-50">Primary Action</button>
                </div>
                <div class="rounded-lg border border-sky-400/40 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Focus Snapshot</p>
                    <button type="button" class="mt-3 ui-action ui-action-primary ring-2 ring-sky-400/50 ring-offset-2 ring-offset-slate-900">Primary Action</button>
                </div>
                <div class="rounded-lg border border-sky-400/40 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Danger Focus Snapshot</p>
                    <button type="button" class="mt-3 ui-action ui-action-danger ring-2 ring-sky-400/50 ring-offset-2 ring-offset-slate-900">Danger Action</button>
                </div>
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Active Snapshot</p>
                    <button type="button" class="mt-3 ui-action ui-action-primary border-blue-700/70 bg-blue-700/45 text-blue-50">Primary Action</button>
                </div>
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Disabled</p>
                    <button type="button" disabled class="mt-3 ui-action ui-action-primary">Primary Action</button>
                </div>
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Loading</p>
                    <button type="button" class="mt-3 ui-action ui-action-primary" aria-busy="true">
                        <span class="ui-spinner ui-spinner-inverse" aria-hidden="true"></span>
                        Loading
                    </button>
                </div>
            </div>
            <div class="mt-4 grid gap-4 md:grid-cols-2">
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Icon Button Focus</p>
                    <button type="button" class="mt-3 ui-icon-button ring-2 ring-sky-400/50 ring-offset-2 ring-offset-slate-900" aria-label="Focused icon action">
                        <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                    </button>
                </div>
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Icon Button Disabled</p>
                    <button type="button" disabled class="mt-3 ui-icon-button" aria-label="Disabled icon action">
                        <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                    </button>
                </div>
                <div class="rounded-lg border border-sky-400/40 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Icon Button Hover Snapshot</p>
                    <button type="button" class="mt-3 ui-icon-button border-slate-500 bg-slate-800 text-white shadow-lg shadow-slate-950/40" aria-label="Hovered icon action">
                        <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                    </button>
                </div>
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Icon Button Active Snapshot</p>
                    <button type="button" class="mt-3 ui-icon-button border-slate-600 bg-slate-950 text-white shadow-inner shadow-black/40" aria-label="Active icon action">
                        <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                    </button>
                </div>
            </div>
        </section>
    </section>
</x-layouts.app>
