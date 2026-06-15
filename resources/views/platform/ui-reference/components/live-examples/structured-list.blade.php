@php
    $workspaceColumns = [
        ['key' => 'workspace', 'label' => 'Workspace'],
        ['key' => 'role', 'label' => 'Role'],
        ['key' => 'status', 'label' => 'Status'],
    ];

    $workspaceRows = [
        ['id' => 'acme', 'cells' => ['workspace' => 'Acme production', 'role' => 'Owner', 'status' => 'Active']],
        ['id' => 'northwind', 'cells' => ['workspace' => 'Northwind staging', 'role' => 'Editor', 'status' => 'Pending review']],
        ['id' => 'sandbox', 'cells' => ['workspace' => 'Sandbox tenant', 'role' => 'Viewer', 'status' => 'Disabled'], 'disabled' => true],
    ];

    $metadataColumns = [
        ['key' => 'token', 'label' => 'Token'],
        ['key' => 'scope', 'label' => 'Scope'],
        ['key' => 'expires', 'label' => 'Expires'],
    ];

    $metadataRows = [
        ['id' => 'api-read', 'cells' => ['token' => 'Read API', 'scope' => 'Read only', 'expires' => 'June 30, 2026']],
        ['id' => 'audit-export', 'cells' => ['token' => 'Audit export', 'scope' => 'Reports', 'expires' => 'July 15, 2026']],
    ];

    $planColumns = [
        ['key' => 'plan', 'label' => 'Plan'],
        ['key' => 'price', 'label' => 'Price'],
        ['key' => 'features', 'label' => 'Features'],
    ];

    $planRows = [
        ['id' => 'starter', 'value' => 'starter', 'cells' => ['plan' => 'Starter', 'price' => '$49', 'features' => 'Core workspace tools']],
        ['id' => 'growth', 'value' => 'growth', 'cells' => ['plan' => 'Growth', 'price' => '$149', 'features' => 'Automation and review workflows']],
        ['id' => 'enterprise', 'value' => 'enterprise', 'cells' => ['plan' => 'Enterprise', 'price' => 'Custom', 'features' => 'Tenant controls and audit exports'], 'disabled' => true],
    ];

    $boundaryRows = [
        ['Structured list', 'Simple row/column comparison with optional single row choice.', '<x-ui.structured-list :columns="$columns" :rows="$rows" />', 'Installed here'],
        ['Data table', 'Sorting, filtering, pagination, bulk actions, row expansion, or large datasets.', '<x-ui.data-table ... />', 'Separate component'],
        ['Contained list', 'Small compact list inside cards, panels, sidebars, or modals.', '<x-ui.contained-list ... />', 'Separate component'],
        ['List', 'Plain prose or content list without comparable columns.', '<ul class="ui-list">...</ul>', 'Separate component'],
        ['Accordion', 'Expand/collapse sections.', '<x-ui.accordion ... />', 'Separate component'],
    ];
@endphp

<div class="space-y-6" data-component-live-layout="structured-list-matrix" data-ui-reference-sample-type="structured-list">
    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-structured-list-live-section="default-list">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Default structured list</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Default structured lists are read-only native tables for simple grouped comparison. Rows do not have interactive behavior.</p>

        <div class="mt-4">
            <x-ui.structured-list
                id="structured-list-default"
                caption="Workspace access summary"
                :columns="$workspaceColumns"
                :rows="$workspaceRows"
                alignment="hang"
            />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-structured-list-live-section="density-and-alignment">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Density and alignment</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Structured list supports default 60px rows, condensed 36px rows, hang alignment, and flush alignment for read-only lists only.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Condensed list</h4>
                <div class="mt-4">
                    <x-ui.structured-list
                        id="structured-list-condensed"
                        caption="API token metadata"
                        :columns="$metadataColumns"
                        :rows="$metadataRows"
                        size="condensed"
                    />
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Flush alignment</h4>
                <div class="mt-4">
                    <x-ui.structured-list
                        id="structured-list-flush"
                        caption="Flush metadata"
                        :columns="$metadataColumns"
                        :rows="$metadataRows"
                        alignment="flush"
                        size="condensed"
                    />
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-structured-list-live-section="background-modifier">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Background modifier</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Background color is available only with hang alignment when the list needs separation from the page layer.</p>
        <div class="mt-4">
            <x-ui.structured-list
                id="structured-list-background"
                caption="Feature comparison"
                :columns="$workspaceColumns"
                :rows="$workspaceRows"
                background
                alignment="hang"
            />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-structured-list-live-section="selectable-list">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Selectable structured list</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Selectable structured lists are single-selection controls. The radio icon is visible on the left, and the selected value is scalar.</p>
        <div class="mt-4">
            <x-ui.structured-list
                id="structured-list-selectable"
                name="plan"
                caption="Plan selection"
                variant="selectable"
                :columns="$planColumns"
                :rows="$planRows"
                value="growth"
            />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-structured-list-live-section="empty-and-skeleton">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Empty and skeleton states</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Empty rows show a status message. Skeleton rows preserve the table shape while data is pending.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Empty state</h4>
                <div class="mt-4">
                    <x-ui.structured-list
                        id="structured-list-empty"
                        caption="Empty workspace list"
                        :columns="$workspaceColumns"
                        :rows="[]"
                        empty-text="No workspaces match this view."
                    />
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Skeleton state</h4>
                <div class="mt-4">
                    <x-ui.structured-list
                        id="structured-list-skeleton"
                        caption="Loading structured list"
                        :columns="$workspaceColumns"
                        skeleton
                    />
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-structured-list-live-section="structured-list-boundaries">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Structured list vs related APIs</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Use Structured list for compact comparison. Move to Data table for sorting, filtering, pagination, bulk actions, row expansion, or multiple row selection.</p>
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
</div>
