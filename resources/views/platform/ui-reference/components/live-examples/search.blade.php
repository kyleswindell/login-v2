@php
    $boundaryRows = [
        ['Search', 'Free keyword query that finds page, table, or component content.', '<x-ui.search name="query" label="Search users" />', 'Installed here'],
        ['Text input', 'Ordinary single-line form value.', '<input type="text" class="ui-input">', 'Separate component'],
        ['Select', 'One short native option value.', '<x-ui.select ... />', 'Separate component'],
        ['Dropdown', 'Custom known-option selection for filters or sorting.', '<x-ui.dropdown ... />', 'Separate component'],
        ['Filter Pattern', 'Structured known dimensions, chips, and clear-all behavior.', 'Pattern-owned', 'Related Pattern'],
        ['Table toolbar Pattern', 'Placement, grouping, result count, and table filtering orchestration.', 'Pattern-owned', 'Related Pattern'],
    ];
@endphp

<div class="space-y-6" data-component-live-layout="search-matrix" data-ui-reference-sample-type="search">
    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-search-live-section="variants">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Variants</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Search supports default, fluid, and expandable variants. Expandable search starts as an icon-only trigger and expands into a focused search field.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-3">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Default search</h4>
                <div class="mt-4">
                    <x-ui.search name="search_default" label="Search users" placeholder="Search by name or email" scope="page" helper="Search applies to the current page region." />
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Fluid search</h4>
                <div class="mt-4">
                    <x-ui.search name="search_fluid" label="Search roles" placeholder="Search roles" scope="component" variant="fluid" helper="Fluid search uses a unified 64px field with right-side icon controls." />
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Expandable search</h4>
                <div class="mt-4">
                    <x-ui.search name="search_expandable_collapsed" label="Search" placeholder="Search table" scope="table" variant="expandable" open-label="Open search" />
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-search-live-section="expandable-search">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Expandable search behavior</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Expandable search preserves accessible labels in collapsed and expanded states. The trigger opens the field, moves focus to the input, and the clear control removes entered text.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Collapsed trigger</h4>
                <div class="mt-4">
                    <x-ui.search name="search_expandable_closed" label="Search" placeholder="Search rows" variant="expandable" open-label="Open search" />
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Expanded input</h4>
                <div class="mt-4">
                    <x-ui.search name="search_expandable_open" label="Search" placeholder="Search rows" variant="expandable" expanded />
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Entered value and clear</h4>
                <div class="mt-4">
                    <x-ui.search name="search_expandable_filled" label="Search" value="billing" placeholder="Search rows" variant="expandable" />
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Toolbar placement</h4>
                <div class="mt-4 flex items-center justify-between gap-3 rounded-md border p-3" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);">
                    <span class="text-sm font-medium" style="color: var(--ui-text-primary);">Table toolbar</span>
                    <x-ui.search name="search_toolbar_expandable" label="Search table" placeholder="Search table" scope="table" variant="expandable" open-label="Open table search" />
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-search-live-section="sizing">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Sizing</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Default search supports small, medium, and large. Medium is the default size. Fluid search is a separate 64px field treatment.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <x-ui.search name="search_size_sm" label="Small search, 32px" placeholder="Search" size="sm" scope="component" show-label />
            <x-ui.search name="search_size_md" label="Medium search, 40px" placeholder="Search records" size="md" scope="page" show-label />
            <x-ui.search name="search_size_lg" label="Large search, 48px" placeholder="Search invoices" size="lg" scope="page" show-label />
            <x-ui.search name="search_size_fluid" label="Fluid search, 64px" placeholder="Search roles" variant="fluid" scope="component" />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-search-live-section="states">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">States</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Search states are enabled, focus, filled, and disabled. Error and warning states are not Search component states.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <x-ui.search name="search_state_enabled" label="Enabled search" placeholder="Search" show-label />
            <x-ui.search name="search_state_focus" label="Focus search" placeholder="Search" class="is-focus" show-label />
            <x-ui.search name="search_state_filled" label="Filled search" value="tenant" placeholder="Search workspaces" show-label />
            <x-ui.search name="search_state_disabled" label="Disabled search" value="locked" placeholder="Search" disabled show-label />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-search-live-section="context-examples">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Context examples</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Search can be scoped to global, page-level, component-level, or table-toolbar contexts. Parent patterns own result rendering and filter orchestration.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <x-ui.search name="search_context_global" label="Global search" placeholder="Search the app" scope="global" show-label />
            <x-ui.search name="search_context_page" label="Page-level search" placeholder="Search page records" scope="page" show-label />
            <x-ui.search name="search_context_component" label="Component-level search" placeholder="Search roles" scope="component" show-label />
            <x-ui.search name="search_context_table" label="Table toolbar expandable search" placeholder="Search table" scope="table" variant="expandable" open-label="Open table search" expanded />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-search-live-section="search-boundaries">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Search vs related APIs</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Use Search for free keywords. Use other components or patterns for ordinary text entry, known options, structured filters, toolbar placement, and result rendering.</p>
        <div class="mt-4 overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-subtle-01);">
            <table class="min-w-full text-left text-sm">
                <thead style="background-color: var(--ui-layer-02); color: var(--ui-text-secondary);">
                    <tr>
                        <th class="px-3 py-2 font-medium">API</th>
                        <th class="px-3 py-2 font-medium">Owns</th>
                        <th class="px-3 py-2 font-medium">Example</th>
                        <th class="px-3 py-2 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody style="color: var(--ui-text-primary);">
                    @foreach ($boundaryRows as [$api, $owns, $example, $status])
                        <tr class="border-t" style="border-color: var(--ui-border-subtle-01);">
                            <td class="px-3 py-2 font-medium">{{ $api }}</td>
                            <td class="px-3 py-2">{{ $owns }}</td>
                            <td class="px-3 py-2"><code>{{ $example }}</code></td>
                            <td class="px-3 py-2">{{ $status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-search-live-section="deferred-capabilities">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Deferred and gated capabilities</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Search suggestions, typeahead, recent searches, focused search, result panels, scope filters inside search, and AI-assisted search require Pattern or feature ownership before they render as production controls.</p>
        <ul class="mt-4 grid gap-2 text-sm leading-6 md:grid-cols-2" style="color: var(--ui-text-secondary);">
            <li>Suggestions and typeahead require result-panel keyboard navigation.</li>
            <li>Global shell routing and shortcuts are owned by UI Shell patterns.</li>
            <li>Active result panels require debounce, loading, empty state, and result ownership.</li>
            <li>AI-assisted search requires approved AI disclosure and trust contracts.</li>
        </ul>
    </section>
</div>
