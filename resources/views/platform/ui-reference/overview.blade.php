<x-layouts.app title="UI Reference Workspace">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'overview'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">UI Reference Workspace</h1>
            <p class="ui-page-header-copy">Canonical UI/UX implementation workspace for Tier 1 components, behavior standards, and interaction proofs.</p>
        </div>

        <div class="grid gap-4 xl:grid-cols-3">
            <article class="ui-card">
                <p class="ui-kicker">Component Library</p>
                <h2 class="ui-card-title mt-2">Tier 1 Components</h2>
                <p class="ui-card-copy">Buttons, status badges, and form controls are separated into focused views so each state can be reviewed consistently.</p>
            </article>
            <article class="ui-card">
                <p class="ui-kicker">Pattern Standards</p>
                <h2 class="ui-card-title mt-2">Complex Behavior</h2>
                <p class="ui-card-copy">Table, overlay, and navigation pages show complete interaction standards (filtering, pagination, drawers, toasts, mobile nav).</p>
            </article>
            <article class="ui-card">
                <p class="ui-kicker">Review Workflow</p>
                <h2 class="ui-card-title mt-2">Ready For Review Gate</h2>
                <p class="ui-card-copy">Each component must prove light/dark parity, responsive behavior, and accessibility states before matrix status can be locked.</p>
            </article>
        </div>

        <section class="ui-card">
            <h2 class="ui-card-title">Current Tier 1 Scope</h2>
            <ul class="mt-4 space-y-2 text-sm text-slate-300">
                <li>1. Buttons and icon buttons</li>
                <li>2. Badges and status indicators</li>
                <li>3. Inputs, textareas, and selects</li>
                <li>4. Table standards (general + log table)</li>
                <li>5. Drawer and modal behavior</li>
                <li>6. Toast and inline alert feedback</li>
                <li>7. Sidebar and account-menu behavior standards</li>
            </ul>
        </section>

        <section class="ui-card">
            <h2 class="ui-card-title">Tier 1 Implementation Checklist</h2>
            <p class="ui-card-copy mt-2">Use this checklist to validate each Tier 1 component in `/platform/ui-reference` before moving matrix rows from `Ready For Review` to `Locked`.</p>

            <div class="mt-4 overflow-x-auto rounded-lg border border-slate-800 bg-slate-900/70">
                <table class="min-w-[920px] w-full divide-y divide-slate-800">
                    <thead class="bg-slate-900">
                        <tr class="text-left text-xs uppercase tracking-[0.2em] text-slate-500">
                            <th class="px-4 py-3">Component Group</th>
                            <th class="px-4 py-3">UI Reference View</th>
                            <th class="px-4 py-3">States</th>
                            <th class="px-4 py-3">Theme</th>
                            <th class="px-4 py-3">Responsive</th>
                            <th class="px-4 py-3">A11y</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 text-sm text-slate-200">
                        <tr>
                            <td class="px-4 py-3 text-white">Buttons + Icon Buttons</td>
                            <td class="px-4 py-3"><a wire:navigate href="{{ route('platform.ui-reference.components.actions') }}" class="text-sky-300 hover:text-sky-200">Components / Actions</a></td>
                            <td class="px-4 py-3">default, hover, focus, active, disabled, loading</td>
                            <td class="px-4 py-3">light/dark parity required</td>
                            <td class="px-4 py-3">stack + wrap verified</td>
                            <td class="px-4 py-3">label + focus visible</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-white">Badges + Status</td>
                            <td class="px-4 py-3"><a wire:navigate href="{{ route('platform.ui-reference.components.status') }}" class="text-sky-300 hover:text-sky-200">Components / Status</a></td>
                            <td class="px-4 py-3">semantic, soft, outline, disabled</td>
                            <td class="px-4 py-3">contrast-safe tokens</td>
                            <td class="px-4 py-3">table + inline display</td>
                            <td class="px-4 py-3">not color-only signal</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-white">Inputs + Forms</td>
                            <td class="px-4 py-3"><a wire:navigate href="{{ route('platform.ui-reference.components.forms') }}" class="text-sky-300 hover:text-sky-200">Components / Forms</a></td>
                            <td class="px-4 py-3">default, focus, error, readonly, disabled</td>
                            <td class="px-4 py-3">light/dark parity required</td>
                            <td class="px-4 py-3">single + 2-col layouts</td>
                            <td class="px-4 py-3">labels + error links</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-white">Table Baseline</td>
                            <td class="px-4 py-3"><a wire:navigate href="{{ route('platform.ui-reference.patterns.tables') }}" class="text-sky-300 hover:text-sky-200">Patterns / Tables</a></td>
                            <td class="px-4 py-3">filters, rows/page, paging, empty, row action</td>
                            <td class="px-4 py-3">light/dark parity required</td>
                            <td class="px-4 py-3">overflow wrappers</td>
                            <td class="px-4 py-3">table semantics + keyboard</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-white">Drawer + Modal</td>
                            <td class="px-4 py-3"><a wire:navigate href="{{ route('platform.ui-reference.patterns.overlays') }}" class="text-sky-300 hover:text-sky-200">Patterns / Overlays</a></td>
                            <td class="px-4 py-3">open, close, focus return, danger confirm</td>
                            <td class="px-4 py-3">theme-safe layering</td>
                            <td class="px-4 py-3">mobile panel fit</td>
                            <td class="px-4 py-3">escape + aria-modal</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-white">Toast + Inline Alert</td>
                            <td class="px-4 py-3"><a wire:navigate href="{{ route('platform.ui-reference.patterns.overlays') }}" class="text-sky-300 hover:text-sky-200">Patterns / Overlays</a></td>
                            <td class="px-4 py-3">info, success, warning, danger, dismiss</td>
                            <td class="px-4 py-3">semantic token map</td>
                            <td class="px-4 py-3">stack behavior</td>
                            <td class="px-4 py-3">live region + role</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-white">Sidebar + Account Menu</td>
                            <td class="px-4 py-3"><a wire:navigate href="{{ route('platform.ui-reference.patterns.navigation') }}" class="text-sky-300 hover:text-sky-200">Patterns / Navigation</a></td>
                            <td class="px-4 py-3">open/close, active route, context switch</td>
                            <td class="px-4 py-3">theme-safe shell</td>
                            <td class="px-4 py-3">desktop + mobile modal</td>
                            <td class="px-4 py-3">escape + focus order</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </section>
</x-layouts.app>
