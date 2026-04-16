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
            <div class="mt-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                <button type="button" class="ui-action ui-action-soft">Soft Neutral</button>
                <button type="button" class="ui-action ui-action-primary ui-action-soft">Soft Primary</button>
                <button type="button" class="ui-action ui-action-danger ui-action-soft">Soft Danger</button>
                <button type="button" class="ui-action ui-action-info ui-action-soft">Soft Info</button>
                <button type="button" class="ui-action ui-action-outline">Outline Neutral</button>
                <button type="button" class="ui-action ui-action-primary ui-action-outline">Outline Primary</button>
                <button type="button" class="ui-action ui-action-warning ui-action-outline">Outline Warning</button>
                <button type="button" class="ui-action ui-action-danger ui-action-outline">Outline Danger</button>
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
                <button type="button" disabled class="ui-action ui-action-primary opacity-60">Disabled</button>
                <button type="button" class="ui-action ui-action-primary" aria-busy="true">Loading…</button>
                <button type="button" class="ui-icon-button" aria-label="Filter results">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                        <path fill-rule="evenodd" d="M2.5 4.75A.75.75 0 0 1 3.25 4h13.5a.75.75 0 0 1 .53 1.28L12 10.56v4.19a.75.75 0 0 1-.44.68l-3 1.333A.75.75 0 0 1 7.5 16V10.56L2.22 5.28a.75.75 0 0 1 .28-1.28Z" clip-rule="evenodd" />
                    </svg>
                </button>
                <button type="button" disabled class="ui-icon-button opacity-60" aria-label="Disabled icon action">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                        <path d="M4.25 3A2.25 2.25 0 0 0 2 5.25v9.5A2.25 2.25 0 0 0 4.25 17h11.5A2.25 2.25 0 0 0 18 14.75v-9.5A2.25 2.25 0 0 0 15.75 3H4.25Z" />
                    </svg>
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
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Active Snapshot</p>
                    <button type="button" class="mt-3 ui-action ui-action-primary border-blue-700/70 bg-blue-700/45 text-blue-50">Primary Action</button>
                </div>
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Disabled</p>
                    <button type="button" disabled class="mt-3 ui-action ui-action-primary opacity-60">Primary Action</button>
                </div>
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Loading</p>
                    <button type="button" class="mt-3 ui-action ui-action-primary" aria-busy="true">
                        <span class="ui-spinner" aria-hidden="true"></span>
                        Loading
                    </button>
                </div>
            </div>
            <div class="mt-4 grid gap-4 md:grid-cols-2">
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Icon Button Focus</p>
                    <button type="button" class="mt-3 ui-icon-button ring-2 ring-sky-400/50 ring-offset-2 ring-offset-slate-900" aria-label="Focused icon action">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                            <path fill-rule="evenodd" d="M2.5 4.75A.75.75 0 0 1 3.25 4h13.5a.75.75 0 0 1 .53 1.28L12 10.56v4.19a.75.75 0 0 1-.44.68l-3 1.333A.75.75 0 0 1 7.5 16V10.56L2.22 5.28a.75.75 0 0 1 .28-1.28Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Icon Button Disabled</p>
                    <button type="button" disabled class="mt-3 ui-icon-button opacity-60" aria-label="Disabled icon action">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                            <path d="M4.25 3A2.25 2.25 0 0 0 2 5.25v9.5A2.25 2.25 0 0 0 4.25 17h11.5A2.25 2.25 0 0 0 18 14.75v-9.5A2.25 2.25 0 0 0 15.75 3H4.25Z" />
                        </svg>
                    </button>
                </div>
                <div class="rounded-lg border border-sky-400/40 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Icon Button Hover Snapshot</p>
                    <button type="button" class="mt-3 ui-icon-button border-slate-500 bg-slate-800 text-white shadow-lg shadow-slate-950/40" aria-label="Hovered icon action">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                            <path fill-rule="evenodd" d="M2.5 4.75A.75.75 0 0 1 3.25 4h13.5a.75.75 0 0 1 .53 1.28L12 10.56v4.19a.75.75 0 0 1-.44.68l-3 1.333A.75.75 0 0 1 7.5 16V10.56L2.22 5.28a.75.75 0 0 1 .28-1.28Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Icon Button Active Snapshot</p>
                    <button type="button" class="mt-3 ui-icon-button border-slate-600 bg-slate-950 text-white shadow-inner shadow-black/40" aria-label="Active icon action">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                            <path fill-rule="evenodd" d="M2.5 4.75A.75.75 0 0 1 3.25 4h13.5a.75.75 0 0 1 .53 1.28L12 10.56v4.19a.75.75 0 0 1-.44.68l-3 1.333A.75.75 0 0 1 7.5 16V10.56L2.22 5.28a.75.75 0 0 1 .28-1.28Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </section>
    </section>
</x-layouts.app>
