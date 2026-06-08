<x-layouts.app title="UI Reference Workspace">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'overview'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">UI Reference Workspace</h1>
            <p class="ui-page-header-copy">Canonical UI/UX implementation workspace for Foundation Elements, Components, Patterns, behavior standards, and interaction proofs.</p>
        </div>

        <div class="grid gap-4 xl:grid-cols-3">
            <article class="ui-card">
                <p class="ui-kicker">Foundation Layer</p>
                <h2 class="ui-card-title mt-2">Foundation Elements</h2>
                <p class="ui-card-copy">Token, grid, spacing, typography, iconography, motion, and theme standards that T1 components consume rather than redefine.</p>
                <a wire:navigate href="{{ route('platform.ui-reference.elements.overview') }}" class="ui-link mt-3 inline-flex">Open foundation element catalog</a>
            </article>
            <article class="ui-card">
                <p class="ui-kicker">Component Library</p>
                <h2 class="ui-card-title mt-2">Components</h2>
                <p class="ui-card-copy">Component pages are catalog-driven and Carbon-aligned for inventory completeness, while Login App 2.0 keeps its own visual and behavior standards.</p>
                <a wire:navigate href="{{ route('platform.ui-reference.components.overview') }}" class="ui-link mt-3 inline-flex">Open component catalog</a>
            </article>
            <article class="ui-card">
                <p class="ui-kicker">Patterns</p>
                <h2 class="ui-card-title mt-2">Pattern Library</h2>
                <p class="ui-card-copy">Form, data, navigation, table, layout, and archetype pages carry reusable composition proof coverage built from Components.</p>
            </article>
            <article class="ui-card">
                <p class="ui-kicker">Review Workflow</p>
                <h2 class="ui-card-title mt-2">Ready For Review Gate</h2>
                <p class="ui-card-copy">Each component must prove light/dark parity, responsive behavior, and accessibility states before matrix status can be locked.</p>
            </article>
        </div>

        <section class="ui-card">
            <h2 class="ui-card-title">System Hierarchy</h2>
            <div class="mt-4 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                @foreach ([
                    ['label' => 'Foundation Elements', 'copy' => 'Tokens, grid, spacing, typography, iconography, motion, and themes.'],
                    ['label' => 'Components', 'copy' => 'Tier 1 primitives: buttons, inputs, tabs, notifications, tables, overlays, and other baseline UI.'],
                    ['label' => 'Patterns', 'copy' => 'Tier 2 reusable compositions built from Component owners, including forms, navigation, data, and overlays.'],
                    ['label' => 'T3 Feature Modules', 'copy' => 'App-specific workflows that consume the shared lower tiers.'],
                ] as $tier)
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                        <p class="text-sm font-semibold text-white">{{ $tier['label'] }}</p>
                        <p class="mt-2 text-sm text-slate-400">{{ $tier['copy'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="ui-card">
            <h2 class="ui-card-title">Current Component Scope</h2>
            <p class="ui-card-copy mt-2">The primary Component review surface is now the component catalog. Legacy grouped pages remain available only as index and compatibility surfaces.</p>
            <div class="mt-4 grid gap-4 md:grid-cols-2 xl:grid-cols-4" data-ui-reference-catalog-summary>
                @foreach ([
                    ['label' => 'Implement Component Page', 'count' => collect($componentCatalog)->where('disposition', 'Implement T1 Page')->count()],
                    ['label' => 'Represent As Pattern', 'count' => collect($componentCatalog)->where('disposition', 'Represent As T2 Pattern')->count()],
                    ['label' => 'Queued Gap', 'count' => collect($componentCatalog)->where('disposition', 'Queued Gap')->count()],
                    ['label' => 'Not Applicable Yet', 'count' => collect($componentCatalog)->where('disposition', 'Not Applicable Yet')->count()],
                ] as $metric)
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">{{ $metric['label'] }}</p>
                        <p class="mt-2 text-2xl font-semibold text-white">{{ $metric['count'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="ui-card">
            <h2 class="ui-card-title">Pattern Coverage</h2>
            <div class="mt-4 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.forms') }}" class="rounded-lg border border-slate-800 bg-slate-950/70 p-4 transition hover:border-slate-600 hover:bg-slate-900">
                    <p class="ui-kicker">Form Patterns</p>
                    <h3 class="mt-2 text-base font-semibold text-white">Form Group Through Validation Summary</h3>
                    <p class="mt-2 text-sm text-slate-400">Reusable form scaffolding built from the Tier 1 controls and feedback baseline.</p>
                </a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.data-content') }}" class="rounded-lg border border-slate-800 bg-slate-950/70 p-4 transition hover:border-slate-600 hover:bg-slate-900">
                    <p class="ui-kicker">Data + Content</p>
                    <h3 class="mt-2 text-base font-semibold text-white">Read-only, summary, and empty-state patterns</h3>
                    <p class="mt-2 text-sm text-slate-400">Shared content blocks, stat cards, key-value displays, and list rows.</p>
                </a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.navigation') }}" class="rounded-lg border border-slate-800 bg-slate-950/70 p-4 transition hover:border-slate-600 hover:bg-slate-900">
                    <p class="ui-kicker">Navigation + Actions</p>
                    <h3 class="mt-2 text-base font-semibold text-white">Page header, sub-navigation, grouped actions</h3>
                    <p class="mt-2 text-sm text-slate-400">Pattern-level proof for page title/action rows, section navigation, and compact action menus.</p>
                </a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.tables') }}" class="rounded-lg border border-slate-800 bg-slate-950/70 p-4 transition hover:border-slate-600 hover:bg-slate-900">
                    <p class="ui-kicker">Enhanced Data Table</p>
                    <h3 class="mt-2 text-base font-semibold text-white">Search, filter, sort, pagination, drawers</h3>
                    <p class="mt-2 text-sm text-slate-400">Advanced table proof for internal operator surfaces without feature coupling.</p>
                </a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.layout') }}" class="rounded-lg border border-slate-800 bg-slate-950/70 p-4 transition hover:border-slate-600 hover:bg-slate-900">
                    <p class="ui-kicker">Layout + Dashboard</p>
                    <h3 class="mt-2 text-base font-semibold text-white">Dashboard grid and section-block proof</h3>
                    <p class="mt-2 text-sm text-slate-400">Shared dashboard-shell and content-structure rules for internal pages.</p>
                </a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.archetypes') }}" class="rounded-lg border border-slate-800 bg-slate-950/70 p-4 transition hover:border-slate-600 hover:bg-slate-900">
                    <p class="ui-kicker">Archetype Proofs</p>
                    <h3 class="mt-2 text-base font-semibold text-white">Dashboard, list, detail, form, setup, settings, account</h3>
                    <p class="mt-2 text-sm text-slate-400">Batch B review targets for the reusable internal app-scaffolding contract.</p>
                </a>
            </div>
        </section>

        <section class="ui-card">
            <h2 class="ui-card-title">Component Implementation Checklist</h2>
            <p class="ui-card-copy mt-2">Use this checklist to validate each Component in `/platform/ui-reference` before moving matrix rows from `Ready For Review` to `Locked`.</p>

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
                            <td class="px-4 py-3">semantic, base, outline, inline status</td>
                            <td class="px-4 py-3">contrast-safe tokens</td>
                            <td class="px-4 py-3">table + inline display</td>
                            <td class="px-4 py-3">not color-only signal</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-white">Inputs + Forms</td>
                            <td class="px-4 py-3"><a wire:navigate href="{{ route('platform.ui-reference.components.forms') }}" class="text-sky-300 hover:text-sky-200">Components / Forms</a></td>
                            <td class="px-4 py-3">default, focus, error, readonly, disabled, selected</td>
                            <td class="px-4 py-3">light/dark parity required</td>
                            <td class="px-4 py-3">single + 2-col layouts</td>
                            <td class="px-4 py-3">labels + error links</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-white">Utility Primitives</td>
                            <td class="px-4 py-3"><a wire:navigate href="{{ route('platform.ui-reference.components.forms') }}" class="text-sky-300 hover:text-sky-200">Components / Forms</a></td>
                            <td class="px-4 py-3">default, hover, focus, loading</td>
                            <td class="px-4 py-3">token-aligned utility states</td>
                            <td class="px-4 py-3">inline + wrapped examples</td>
                            <td class="px-4 py-3">labels + tooltip semantics</td>
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
                        <tr>
                            <td class="px-4 py-3 text-white">Layout + Scaffolding</td>
                            <td class="px-4 py-3"><a wire:navigate href="{{ route('platform.ui-reference.patterns.navigation') }}" class="text-sky-300 hover:text-sky-200">Patterns / Navigation</a></td>
                            <td class="px-4 py-3">passive structural baseline</td>
                            <td class="px-4 py-3">spacing and panel tokens</td>
                            <td class="px-4 py-3">container + grid collapse</td>
                            <td class="px-4 py-3">structural grouping remains semantic</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </section>
</x-layouts.app>
