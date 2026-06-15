@php
    $workspaceColumns = [
        ['key' => 'workspace', 'label' => 'Workspace', 'sortable' => true],
        ['key' => 'owner', 'label' => 'Owner'],
        ['key' => 'status', 'label' => 'Status', 'sortable' => true],
        ['key' => 'updated', 'label' => 'Updated', 'sortable' => true, 'align' => 'end'],
    ];

    $workspaceRows = [
        ['id' => 'acme', 'workspace' => 'Acme production', 'owner' => 'Sam Rivera', 'status' => 'Active', 'updated' => 'Today', 'current' => true],
        ['id' => 'northwind', 'workspace' => 'Northwind staging', 'owner' => 'Lee Chen', 'status' => 'Pending review', 'updated' => 'Yesterday'],
        ['id' => 'sandbox', 'workspace' => 'Sandbox tenant', 'owner' => 'Morgan Fox', 'status' => 'Paused', 'updated' => 'June 12'],
    ];

    $managementColumns = [
        ['key' => 'user', 'label' => 'User', 'sortable' => true],
        ['key' => 'role', 'label' => 'Role'],
        ['key' => 'last_seen', 'label' => 'Last seen', 'align' => 'end'],
    ];

    $managementRows = [
        ['id' => 'ana', 'user' => 'Ana Gomez', 'role' => 'Owner', 'last_seen' => '8 minutes ago', 'current' => true],
        ['id' => 'eli', 'user' => 'Eli Park', 'role' => 'Admin', 'last_seen' => '2 hours ago'],
        ['id' => 'maya', 'user' => 'Maya Patel', 'role' => 'Viewer', 'last_seen' => 'Disabled', 'disabled' => true],
    ];

    $wideColumns = [
        ['key' => 'workspace', 'label' => 'Workspace', 'sortable' => true],
        ['key' => 'tenant_id', 'label' => 'Tenant ID'],
        ['key' => 'owner', 'label' => 'Owner'],
        ['key' => 'region', 'label' => 'Region'],
        ['key' => 'domain', 'label' => 'Primary domain'],
        ['key' => 'status', 'label' => 'Status'],
        ['key' => 'updated', 'label' => 'Updated', 'align' => 'end'],
    ];

    $wideRows = [
        ['id' => 'acme-wide', 'workspace' => 'Acme production', 'tenant_id' => 'tenant-acme-prod-001', 'owner' => 'Sam Rivera', 'region' => 'US East', 'domain' => 'app.acme.example', 'status' => 'Active', 'updated' => 'Today'],
        ['id' => 'northwind-wide', 'workspace' => 'Northwind staging', 'tenant_id' => 'tenant-northwind-stage-014', 'owner' => 'Lee Chen', 'region' => 'US Central', 'domain' => 'stage.northwind.example', 'status' => 'Pending review', 'updated' => 'Yesterday'],
    ];

    $gateRows = [
        ['Capability', 'Current status', 'Required owner before live UI'],
        ['Checkbox selection', 'Gated', 'Header parent checkbox, indeterminate state, selected row state, and batch action rules.'],
        ['Radio selection', 'Gated', 'Single-row selection state, toolbar action ownership, and Radio button composition.'],
        ['Batch actions', 'Gated', 'Selected-count bar, deselect-all behavior, disabled row actions, and destructive-action guidance.'],
        ['Expandable rows', 'Gated', 'Disclosure control, expanded panel semantics, keyboard behavior, and loading boundaries.'],
        ['Editable cells', 'Deferred', 'Editable grid Pattern with validation, save/cancel, keyboard, and undo behavior.'],
    ];
@endphp

<div class="space-y-6" data-component-live-layout="data-table-matrix" data-ui-reference-sample-type="data-table">
    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-data-table-live-section="basic-sortable-table">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Basic sortable table</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Sortable headers expose the active state through <code>aria-sort</code>; unsorted sortable columns keep their own button target.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-3">
            <x-ui.data-table
                title="Sorted ascending"
                description="Workspace is the active sorted column."
                size="md"
                :columns="$workspaceColumns"
                :rows="$workspaceRows"
                sortable
                sort-by="workspace"
                sort-direction="asc"
            />

            <x-ui.data-table
                title="Sorted descending"
                description="Updated is sorted from newest to oldest."
                size="md"
                :columns="$workspaceColumns"
                :rows="$workspaceRows"
                sortable
                sort-by="updated"
                sort-direction="desc"
            />

            <x-ui.data-table
                title="Unsorted sortable"
                description="Sortable columns are available but none is active."
                size="md"
                :columns="$workspaceColumns"
                :rows="$workspaceRows"
                sortable
            />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-data-table-live-section="compact-management-table">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Compact management table</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Header and body row sizes are paired. Extra-large rows are reserved for two-line content; compact rows use the small toolbar treatment.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <x-ui.data-table
                title="Small toolbar with compact rows"
                description="Small table rows pair with the small toolbar height."
                size="sm"
                toolbar-size="sm"
                :columns="$managementColumns"
                :rows="$managementRows"
                sortable
                sort-by="user"
                sort-direction="asc"
                row-actions
            >
                <x-slot name="toolbar">
                    <x-ui.data-table-toolbar size="sm">
                        <span class="text-sm font-semibold" style="color: var(--ui-text-secondary);">3 users</span>
                        <x-ui.button semantic="ghost" size="sm">Export</x-ui.button>
                    </x-ui.data-table-toolbar>
                </x-slot>
            </x-ui.data-table>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Row size scale</h4>
                <div class="mt-4 grid gap-3">
                    @foreach (['xs' => 'Extra small rows', 'sm' => 'Small rows', 'md' => 'Medium rows', 'lg' => 'Large rows', 'xl' => 'Extra large rows'] as $size => $label)
                        <x-ui.data-table
                            :title="$label"
                            :size="$size"
                            :columns="[
                                ['key' => 'name', 'label' => 'Name'],
                                ['key' => 'status', 'label' => 'Status'],
                                ['key' => 'updated', 'label' => 'Updated', 'align' => 'end'],
                            ]"
                            :rows="[
                                ['id' => $size.'-row', 'name' => 'Example row', 'status' => 'Readable', 'updated' => 'Now'],
                            ]"
                        />
                    @endforeach
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-data-table-live-section="filterable-toolbar-table">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Filterable toolbar table</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Table search and filters are global controls in the toolbar. Search remains owned by the Search Component, while structured filters are Pattern-owned.</p>

        <div class="mt-4">
            <x-ui.data-table
                title="Filterable records"
                description="Search is persistent because text filtering is a primary table interaction."
                size="md"
                :columns="$workspaceColumns"
                :rows="$workspaceRows"
                sortable
                sort-by="status"
                sort-direction="asc"
                row-actions
            >
                <x-slot name="toolbar">
                    <x-ui.data-table-toolbar size="lg">
                        <div class="min-w-64 flex-1">
                            <x-ui.search name="workspace_table_search" label="Search workspaces" placeholder="Search workspaces" scope="table" size="md" value="tenant" />
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <x-ui.button semantic="ghost" size="md">Filters</x-ui.button>
                            <x-ui.button semantic="ghost" size="md">Export</x-ui.button>
                            <x-ui.button semantic="primary" size="md">Create workspace</x-ui.button>
                        </div>
                    </x-ui.data-table-toolbar>
                </x-slot>
            </x-ui.data-table>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-data-table-live-section="row-actions-table">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Row actions table</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Row commands stay in their own cell. Disabled row actions use Button disabled treatment while row data remains readable.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-[minmax(0,1fr)_minmax(18rem,0.65fr)]">
            <x-ui.data-table
                title="Row actions"
                description="Each repeated Open action has a row-specific accessible name."
                size="md"
                :columns="$managementColumns"
                :rows="$managementRows"
                row-actions
            />

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Overflow menu handoff</h4>
                <ul class="mt-3 list-disc space-y-2 pl-5 text-sm leading-6" style="color: var(--ui-text-secondary);">
                    <li>Fewer than three row actions may stay as visible inline buttons.</li>
                    <li>Three or more row actions move into Menu buttons or a row overflow menu.</li>
                    <li>Row action menus must remain discoverable on touch devices.</li>
                </ul>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-data-table-live-section="dynamic-states">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Dynamic states</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Loading uses skeleton rows, empty states explain why no rows appear, and error states provide non-color meaning.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-3">
            <x-ui.data-table
                title="Loading table"
                description="Skeleton rows preserve the expected table geometry."
                size="md"
                :columns="$workspaceColumns"
                :rows="[]"
                loading
            />

            <x-ui.data-table
                title="Empty table"
                description="No rows matched the current filters."
                size="md"
                :columns="$workspaceColumns"
                :rows="[]"
                empty-title="No workspaces found"
                empty-description="Clear the filters or create a workspace to add rows."
            />

            <x-ui.data-table
                title="Error table"
                description="The table failed to load."
                size="md"
                :columns="$workspaceColumns"
                :rows="[]"
                error="Retry the request or review the data source status."
            />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-data-table-live-section="responsive-overflow-pagination">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Responsive overflow and pagination</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Dense columns stay in a semantic table inside an overflow-safe wrapper. Pagination sits below the table and remains owned by the Pagination Component.</p>

        <div class="mt-4">
            <p class="mb-3 text-sm font-semibold" style="color: var(--ui-text-primary);">Pagination composition</p>
            <x-ui.data-table
                title="Responsive overflow table"
                description="A wide record table keeps native table semantics rather than collapsing rows into cards."
                size="md"
                :columns="$wideColumns"
                :rows="$wideRows"
                sortable
                sort-by="workspace"
                sort-direction="asc"
            >
                <x-slot name="paginationSlot">
                    <x-ui.pagination
                        id="data-table-pagination-composition"
                        label="Workspace table pagination"
                        variant="pagination"
                        size="md"
                        :current-page="3"
                        :total-pages="12"
                        :total-items="287"
                        :page-size="25"
                        :page-size-options="[10, 25, 50]"
                        base-url="/platform/ui-reference/components/data-table"
                    />
                </x-slot>
            </x-ui.data-table>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-data-table-live-section="selection-expansion-gates">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Selection and batch-action gate</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">These capabilities are required by the full Carbon coverage model, but they must not appear as fake static controls before the behavior contract is installed.</p>

        <div class="mt-4 overflow-x-auto rounded-md border" style="border-color: var(--ui-border-subtle-01);">
            <table class="min-w-full text-left text-sm">
                <thead style="background-color: var(--ui-layer-02); color: var(--ui-text-primary);">
                    <tr>
                        @foreach ($gateRows[0] as $header)
                            <th class="px-4 py-3 font-semibold">{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody style="color: var(--ui-text-secondary);">
                    @foreach (array_slice($gateRows, 1) as $row)
                        <tr class="border-t" style="border-color: var(--ui-border-subtle-01);">
                            <th scope="row" class="px-4 py-3 font-semibold" style="color: var(--ui-text-primary);">{{ $row[0] }}</th>
                            <td class="px-4 py-3">{{ $row[1] }}</td>
                            <td class="px-4 py-3">{{ $row[2] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 grid gap-3 md:grid-cols-2">
            <div class="rounded-md border p-3" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-data-table-gate="expandable-row-gate">
                <p class="text-sm font-semibold" style="color: var(--ui-text-primary);">Expandable-row gate</p>
                <p class="mt-1 text-sm leading-6" style="color: var(--ui-text-secondary);">Use a detail page, side panel, Modal, or Accordion until expandable row semantics and keyboard behavior are installed.</p>
            </div>
            <div class="rounded-md border p-3" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-data-table-gate="batch-expansion-gate">
                <p class="text-sm font-semibold" style="color: var(--ui-text-primary);">Batch expansion gate</p>
                <p class="mt-1 text-sm leading-6" style="color: var(--ui-text-secondary);">Expand-all is not enabled by default and requires performance and lazy-loading review before implementation.</p>
            </div>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-data-table-live-section="developer-implementation">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Developer implementation</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Use the app-owned Blade API, not local table wrappers or Carbon production classes.</p>
        <div class="mt-4">
            <x-ui.code-snippet language="Blade" copyable><span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.data-table</span>
    <span class="ui-code-token-property">title</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"Workspace access"</span>
    <span class="ui-code-token-property">description</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"Users with access to this workspace."</span>
    <span class="ui-code-token-property">size</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"md"</span>
    <span class="ui-code-token-property">:columns</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"$columns"</span>
    <span class="ui-code-token-property">:rows</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"$rows"</span>
    <span class="ui-code-token-property">sortable</span>
    <span class="ui-code-token-property">sort-by</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"workspace"</span>
    <span class="ui-code-token-property">sort-direction</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"asc"</span>
    <span class="ui-code-token-property">row-actions</span>
<span class="ui-code-token-punctuation">/&gt;</span></x-ui.code-snippet>
        </div>
    </section>
</div>
