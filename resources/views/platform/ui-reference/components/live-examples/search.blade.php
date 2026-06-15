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
    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-search-live-section="page-search">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Page search</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Page search uses a native search input with a scoped accessible label, short placeholder, search icon, and clear action when filled.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Default page query</h4>
                <div class="mt-4 max-w-md">
                    <x-ui.search
                        name="search_page_users"
                        label="Search users"
                        placeholder="Search by name or email"
                        scope="page"
                        helper="Search applies to the current page region."
                    />
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Clear action</h4>
                <div class="mt-4 max-w-md">
                    <x-ui.search
                        name="search_page_filled"
                        label="Search workspaces"
                        value="tenant"
                        placeholder="Search workspaces"
                        scope="page"
                        helper="Filled search reveals a keyboard-reachable clear button."
                    />
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-search-live-section="table-and-component-search">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Table and component search</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Search can be composed into table toolbars or bounded components. The parent pattern owns placement, result count, empty states, and filtering orchestration.</p>
        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Table search</h4>
                <div class="mt-4 max-w-sm">
                    <x-ui.search
                        name="search_table_audit"
                        label="Search table"
                        placeholder="Search audit events"
                        scope="table"
                        size="sm"
                        active
                        debounce="300"
                        results-region="search-table-results"
                        helper="Table toolbar Pattern owns result count and filtering."
                    />
                </div>
                <p id="search-table-results" class="mt-3 text-xs leading-5" style="color: var(--ui-text-helper);">Result updates belong to the table region.</p>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Component search</h4>
                <div class="mt-4">
                    <x-ui.search
                        name="search_component_roles"
                        label="Search roles"
                        placeholder="Search roles"
                        scope="component"
                        variant="fluid"
                        helper="Fluid search fills a contained component region."
                    />
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-search-live-section="sizes-and-states">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Sizes and states</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Default search supports small, medium, and large heights. Fluid search uses the 64px field treatment.</p>
        <div class="mt-4 grid gap-4 xl:grid-cols-3">
            <x-ui.search name="search_size_sm" label="Small search" placeholder="Search" size="sm" scope="component" />
            <x-ui.search name="search_size_md" label="Medium search" placeholder="Search records" size="md" scope="page" />
            <x-ui.search name="search_size_lg" label="Large search" placeholder="Search invoices" size="lg" scope="page" />
        </div>
        <div class="mt-4 grid gap-4 xl:grid-cols-3">
            <x-ui.search name="search_disabled" label="Disabled search" value="locked" placeholder="Search" disabled helper="Search is unavailable in this state." />
            <x-ui.search name="search_readonly" label="Read-only search" value="applied query" placeholder="Search" readonly helper="The applied query is fixed in this context." />
            <x-ui.search name="search_loading" label="Loading search" value="invoice" placeholder="Search invoices" loading results-region="search-loading-results" />
        </div>
        <p id="search-loading-results" class="mt-3 text-xs leading-5" style="color: var(--ui-text-helper);">Loading search announces that related results are updating.</p>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-search-live-section="validation-and-no-results">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Validation search and no-results handoff</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Invalid queries and failed requests can use field-level messages. No-results content belongs to the result region, not the search field.</p>
        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <x-ui.search
                name="search_invalid"
                label="Search audit events"
                value="?"
                placeholder="Search by actor, event, or IP address"
                invalid
                invalid-text="Enter at least two searchable characters."
            />
            <x-ui.search
                name="search_warning"
                label="Search invoices"
                value="all"
                placeholder="Search invoices"
                warn
                warn-text="Broad searches may take longer to return."
            />
        </div>
        <div class="mt-4 rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
            <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">No-results handoff</h4>
            <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">No results for <strong style="color: var(--ui-text-primary);">tenant archive</strong>. Clear the search or check spelling.</p>
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
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Search suggestions, typeahead, recent searches, focused search, global shell search, scope filters inside search, and AI-assisted search require Pattern or feature ownership before they render as production controls.</p>
        <ul class="mt-4 grid gap-2 text-sm leading-6 md:grid-cols-2" style="color: var(--ui-text-secondary);">
            <li>Suggestions and typeahead require result-panel keyboard navigation.</li>
            <li>Global shell search requires UI Shell routing and shortcut ownership.</li>
            <li>Active result panels require debounce, loading, empty state, and result ownership.</li>
            <li>AI-assisted search requires approved AI disclosure and trust contracts.</li>
        </ul>
    </section>
</div>
