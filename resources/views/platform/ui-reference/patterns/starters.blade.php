<x-layouts.app title="UI Reference - Starter Catalog">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.starters'])
    </x-slot:sidebar>

    @php
        $starterGroups = [
            'Module and dashboard starters' => [
                ['name' => 'Module Home / Module Overview', 'route' => '/platform/ui-reference/patterns/starters/module-home', 'owner' => 'P2-F-CQ-002', 'states' => 'default, empty, loading', 'patterns' => 'Page Title And Actions Row; Content Section Block; Stat Card; Widget Shell'],
                ['name' => 'Dashboard / Module Summary', 'route' => '/platform/ui-reference/patterns/starters/dashboard-summary', 'owner' => 'P2-F-CQ-002', 'states' => 'default, empty, widget-error fallback', 'patterns' => 'Dashboard Grid; Widget Shell; Stat Card'],
                ['name' => 'Dashboard Widget Examples By Content Type', 'route' => '/platform/ui-reference/patterns/widget-content/{size}', 'owner' => 'P2-F-CQ-002', 'states' => 'default per size variant', 'patterns' => 'Widget Shell; Stat Card; Data List Item'],
            ],
            'Settings, setup, and account starters' => [
                ['name' => 'Settings Page', 'route' => '/platform/ui-reference/patterns/starters/settings', 'owner' => 'P2-F-CQ-003', 'states' => 'default, validation error, saved inline confirmation', 'patterns' => 'Sub-navigation Bar; Form Section; Form Actions Bar; Validation Summary'],
                ['name' => 'Setup / Configuration Page', 'route' => '/platform/ui-reference/patterns/starters/setup', 'owner' => 'P2-F-CQ-003', 'states' => 'default, step-incomplete, step-done', 'patterns' => 'Content Section Block; Form Section; Form Actions Bar'],
                ['name' => 'Account / Profile Read-Only', 'route' => '/platform/ui-reference/patterns/starters/account-read-only', 'owner' => 'P2-F-CQ-004', 'states' => 'default, empty-field fallback', 'patterns' => 'Identity Summary Card; Key Value Display; Content Section Block'],
                ['name' => 'Account / Profile Editable', 'route' => '/platform/ui-reference/patterns/starters/account-editable', 'owner' => 'P2-F-CQ-004', 'states' => 'default, editing, validation error, saved', 'patterns' => 'Form Section; Inline Form Row; Form Actions Bar; Validation Summary'],
            ],
            'Operational starters' => [
                ['name' => 'List / Index', 'route' => '/platform/ui-reference/patterns/starters/list-index', 'owner' => 'P2-F-CQ-005', 'states' => 'default, search-active, filter-active, empty, loading', 'patterns' => 'Search And Filter Bar; Enhanced Data Table; Empty State'],
                ['name' => 'Table Management Index', 'route' => '/platform/ui-reference/patterns/starters/table-management', 'owner' => 'P2-F-CQ-005', 'states' => 'default, row-selected, bulk-action-active, empty', 'patterns' => 'Enhanced Data Table; Data List Item; row actions'],
                ['name' => 'Operational Log / Detail', 'route' => '/platform/ui-reference/patterns/starters/operational-log', 'owner' => 'P2-F-CQ-005', 'states' => 'default, empty, drawer-open', 'patterns' => 'Content Section Block; Key Value Display; Data List Item'],
                ['name' => 'Content Browser / Split View', 'route' => '/platform/ui-reference/patterns/starters/content-browser', 'owner' => 'P2-F-CQ-005', 'states' => 'default, row-selected, detail-open, empty', 'patterns' => 'Enhanced Data Table or Data List Item; Drawer or Side Panel'],
                ['name' => 'Detail / Read-Only', 'route' => '/platform/ui-reference/patterns/starters/detail-read-only', 'owner' => 'P2-F-CQ-005', 'states' => 'default, empty-section', 'patterns' => 'Content Section Block; Key Value Display; Data List Item'],
                ['name' => 'Create / Edit Form', 'route' => '/platform/ui-reference/patterns/starters/create-edit-form', 'owner' => 'P2-F-CQ-005', 'states' => 'default, validation-error, submitting', 'patterns' => 'Validation Summary; Form Section; Inline Form Row; Form Actions Bar'],
                ['name' => 'Blocked / Empty / Unavailable', 'route' => '/platform/ui-reference/patterns/starters/empty-unavailable', 'owner' => 'P2-F-CQ-005', 'states' => 'permission-blocked, no-data, service-unavailable, search-no-results', 'patterns' => 'Empty State; Page Title And Actions Row; Content Section Block'],
            ],
        ];

        $dispositionRows = [
            ['/platform/ui-reference', 'Overview workspace', 'Update', 'Keep as workspace overview; add starter catalog link only if later navigation density needs a dashboard tile.', 'P2-F-CQ-007'],
            ['/platform/ui-reference/components/actions', 'Buttons and icon buttons', 'Update', 'Keep current examples; add variant/action-label usage rules under P2-F-CQ-008.', 'P2-F-CQ-008'],
            ['/platform/ui-reference/components/status', 'Badges and status', 'Update', 'Keep current primitives; expand color semantics and status indicator examples under P2-F-CQ-009.', 'P2-F-CQ-009'],
            ['/platform/ui-reference/components/forms', 'Input and form primitives', 'Update', 'Keep primitives; expand required/optional, warning, selection, and field-state guidance under P2-F-CQ-010.', 'P2-F-CQ-010'],
            ['/platform/ui-reference/patterns/forms', 'Form patterns', 'Update', 'Keep as Tier 2 form pattern surface; consume standards from P2-F-CQ-010 before starter form pages are built.', 'P2-F-CQ-010'],
            ['/platform/ui-reference/patterns/data-content', 'Data and content patterns', 'Update', 'Keep as Tier 2 surface; add structured list, tile/card, and read-only data guidance under P2-F-CQ-011.', 'P2-F-CQ-011'],
            ['/platform/ui-reference/patterns/tables', 'Table baselines', 'Update', 'Keep as table proof surface; add table variant, skeleton loading, pagination, overflow, and list/index starter references.', 'P2-F-CQ-011'],
            ['/platform/ui-reference/patterns/overlays-feedback', 'Overlays and feedback', 'Update', 'Keep as feedback proof surface; expand alert/toast and modal guidance under P2-F-CQ-009 and P2-F-CQ-011.', 'P2-F-CQ-009 / P2-F-CQ-011'],
            ['/platform/ui-reference/patterns/navigation', 'Navigation and actions', 'Update', 'Keep navigation patterns; add breadcrumb, tabs, search/filter, overflow, and action-label guidance.', 'P2-F-CQ-008 / P2-F-CQ-011'],
            ['/platform/ui-reference/patterns/layout', 'Layout and dashboard', 'Update', 'Keep dashboard/layout proof; add grid guidance and link module/dashboard starters.', 'P2-F-CQ-002 / P2-F-CQ-011'],
            ['/platform/ui-reference/patterns/widget-content', 'Widget content standards', 'Keep and extend', 'Retain as existing dashboard widget starter family; P2-F-CQ-002 validates and extends without duplicate routes.', 'P2-F-CQ-002'],
            ['/platform/ui-reference/patterns/widget-content/{size}', 'Widget size examples', 'Keep and extend', 'Retain as concrete widget content examples; add content-type variants only where needed.', 'P2-F-CQ-002'],
            ['/platform/ui-reference/patterns/archetypes', 'Archetype vocabulary proof', 'Keep', 'Keep as vocabulary context; do not treat as concrete starter catalog after this route exists.', 'P2-F-CQ-007'],
            ['/platform/ui-reference/patterns/starters', 'Starter catalog index', 'Add', 'This page: starter discovery, owner routing, and route disposition matrix.', 'P2-F-CQ-007'],
            ['/platform/ui-reference/patterns/starters/*', 'Concrete starter pages', 'Add', 'Add individual starter pages under P2-F-CQ-002 through P2-F-CQ-005.', 'P2-F-CQ-002 through P2-F-CQ-005'],
            ['/platform/ui-reference/audit-logs/{sample}', 'Audit JSON sample route', 'Keep as support route', 'Use only as sample payload/proof support for operational-log and content-browser starters.', 'P2-F-CQ-005'],
            ['/platform/ui-reference/error-logs/{sample}', 'Error JSON sample route', 'Keep as support route', 'Use only as sample payload/proof support for operational-log starters.', 'P2-F-CQ-005'],
        ];
    @endphp

    <section class="flex flex-1 flex-col gap-6" data-ui-reference-starter-catalog>
        <x-ui.patterns.page-title-actions-row
            title="Starter Catalog"
            description="Batch F route map for concrete starter-page examples, existing UI Reference disposition, and ownership of the remaining starter implementation work."
            kicker="P2-F-CQ-007"
        >
            <x-slot:actions>
                <x-ui.button :href="route('platform.ui-reference.patterns.archetypes')" variant="outline">Archetype vocabulary</x-ui.button>
                <x-ui.button :href="route('platform.ui-reference.patterns.widget-content')" semantic="primary">Widget examples</x-ui.button>
            </x-slot:actions>
        </x-ui.patterns.page-title-actions-row>

        <x-ui.inline-alert semantic="notice" title="Catalog entry point">
            Individual starter pages are implemented by P2-F-CQ-002 through P2-F-CQ-005. This route owns discoverability, ownership routing, and route disposition so those later passes do not make ad hoc decisions about existing UI Reference surfaces.
        </x-ui.inline-alert>

        <div class="grid gap-6 xl:grid-cols-3">
            @foreach ($starterGroups as $group => $starters)
                <x-ui.patterns.content-section-block title="{{ $group }}" description="Required starter rows from the Batch F Starter Catalog Matrix." kicker="Starter group">
                    <div class="space-y-3">
                        @foreach ($starters as $starter)
                            <article class="rounded-lg border border-slate-800 bg-slate-950/60 p-4" data-starter-catalog-item="{{ $starter['owner'] }}">
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <div>
                                        <h3 class="text-base font-semibold text-white">{{ $starter['name'] }}</h3>
                                        <p class="mt-1 text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">{{ $starter['owner'] }}</p>
                                    </div>
                                    <span class="rounded-full border border-amber-400/30 bg-amber-400/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.14em] text-amber-200">Planned</span>
                                </div>
                                <dl class="mt-4 space-y-2 text-sm text-slate-300">
                                    <div>
                                        <dt class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Target route</dt>
                                        <dd class="mt-1 break-all font-mono text-xs text-slate-200" data-starter-route="{{ $starter['route'] }}">{{ $starter['route'] }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Required states</dt>
                                        <dd class="mt-1">{{ $starter['states'] }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Primary patterns</dt>
                                        <dd class="mt-1">{{ $starter['patterns'] }}</dd>
                                    </div>
                                </dl>
                            </article>
                        @endforeach
                    </div>
                </x-ui.patterns.content-section-block>
            @endforeach
        </div>

        <x-ui.patterns.content-section-block
            title="UI Reference Route Disposition Matrix"
            description="Route-level plan for what to keep, update, re-home, or add before the remaining starter and usage-guidance passes implement concrete examples."
            kicker="Implementation routing"
            id="ui-reference-route-disposition"
        >
            <div class="overflow-x-auto rounded-lg border border-slate-800 bg-slate-950/60" data-route-disposition-matrix>
                <table class="min-w-[980px] w-full divide-y divide-slate-800 text-sm">
                    <thead class="bg-slate-900">
                        <tr class="text-left text-xs uppercase tracking-[0.16em] text-slate-500">
                            <th class="px-4 py-3">Route</th>
                            <th class="px-4 py-3">Current purpose</th>
                            <th class="px-4 py-3">Disposition</th>
                            <th class="px-4 py-3">Required action</th>
                            <th class="px-4 py-3">Owner</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 text-slate-300">
                        @foreach ($dispositionRows as [$route, $purpose, $disposition, $action, $owner])
                            <tr>
                                <td class="px-4 py-3 font-mono text-xs text-slate-200">{{ $route }}</td>
                                <td class="px-4 py-3">{{ $purpose }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full border border-slate-700 bg-slate-900 px-2.5 py-1 text-xs font-semibold uppercase tracking-[0.12em] text-slate-200">{{ $disposition }}</span>
                                </td>
                                <td class="px-4 py-3">{{ $action }}</td>
                                <td class="px-4 py-3 font-semibold text-slate-100">{{ $owner }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-ui.patterns.content-section-block>
    </section>
</x-layouts.app>
