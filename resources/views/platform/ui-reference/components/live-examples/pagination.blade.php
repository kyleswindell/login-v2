@php
    $pageSizeOptions = [
        ['value' => 10, 'label' => '10'],
        ['value' => 25, 'label' => '25'],
        ['value' => 50, 'label' => '50'],
        ['value' => 100, 'label' => '100'],
    ];

    $tableColumns = [
        ['key' => 'workspace', 'label' => 'Workspace'],
        ['key' => 'owner', 'label' => 'Owner'],
        ['key' => 'status', 'label' => 'Status'],
    ];

    $tableRows = [
        ['workspace' => 'Acme production', 'owner' => 'Sam Rivera', 'status' => 'Active'],
        ['workspace' => 'Northwind staging', 'owner' => 'Lee Chen', 'status' => 'Pending'],
        ['workspace' => 'Sandbox tenant', 'owner' => 'Morgan Fox', 'status' => 'Paused'],
    ];

    $sizePairings = [
        ['Extra small table rows', 'xs', 'sm'],
        ['Small table rows', 'sm', 'sm'],
        ['Medium table rows', 'md', 'md'],
        ['Large table rows', 'lg', 'lg'],
        ['Extra large table rows', 'xl', 'lg'],
    ];

    $implementationRows = [
        ['Pagination bar', 'Data table footer with items-per-page, range, page selector, previous, and next.', '<x-ui.pagination variant="pagination" :page-size-options="$options" />', 'Installed here'],
        ['Pagination nav', 'Page-button navigation below page, section, list, or search-result content.', '<x-ui.pagination variant="pagination-nav" alignment="right" />', 'Installed here'],
        ['Responsive small breakpoint', 'Select controls are removed while total/range and previous/next remain available.', '<x-ui.pagination small-breakpoint />', 'Installed here'],
        ['Progression flows', 'Linear steps are not pagination.', '<x-ui.progress-indicator ... />', 'Use another component'],
        ['Small result sets', 'No pagination when all content fits clearly in one view.', 'No component', 'Do not render fake controls'],
    ];
@endphp

<div class="space-y-6" data-component-live-layout="pagination-matrix" data-ui-reference-sample-type="pagination">
    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-pagination-live-section="pagination-bar-sizes">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Pagination bar sizes</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Small, medium, and large pagination bars use the same working controls with size-specific heights and spacing.</p>

        <div class="mt-4 grid gap-4">
            <x-ui.pagination id="pagination-bar-sm" label="Small workspace table pagination" variant="pagination" size="sm" :current-page="1" :total-pages="12" :total-items="287" :page-size="25" :page-size-options="$pageSizeOptions" base-url="#" interactive />
            <x-ui.pagination id="pagination-bar-md" label="Medium workspace table pagination" variant="pagination" size="md" :current-page="3" :total-pages="12" :total-items="287" :page-size="25" :page-size-options="$pageSizeOptions" base-url="#" interactive />
            <x-ui.pagination id="pagination-bar-lg" label="Large workspace table pagination" variant="pagination" size="lg" :current-page="12" :total-pages="12" :total-items="287" :page-size="25" :page-size-options="$pageSizeOptions" base-url="#" interactive />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-pagination-live-section="pagination-nav-sizes">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Pagination nav sizes</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Pagination nav shows page buttons, selected page state, disabled boundaries, and overflow menus for hidden pages.</p>

        <div class="mt-4 grid gap-4">
            <x-ui.pagination id="pagination-nav-sm" label="Small search results pagination" variant="pagination-nav" size="sm" alignment="left" :current-page="1" :total-pages="24" base-url="#" interactive />
            <x-ui.pagination id="pagination-nav-md" label="Medium search results pagination" variant="pagination-nav" size="md" alignment="left" :current-page="8" :total-pages="24" base-url="#" interactive />
            <x-ui.pagination id="pagination-nav-lg" label="Large search results pagination" variant="pagination-nav" size="lg" alignment="left" :current-page="24" :total-pages="24" base-url="#" interactive />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-pagination-live-section="data-table-size-pairings">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Data table size pairings</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Pagination pairs to the connected data table row height. Pagination supports small, medium, and large only; extra-small tables use small pagination and extra-large tables use large pagination.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Pairing matrix</h4>
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full text-left text-sm">
                        <thead>
                            <tr style="color: var(--ui-text-primary);">
                                <th class="px-3 py-2 font-semibold">Data table row size</th>
                                <th class="px-3 py-2 font-semibold">Table API</th>
                                <th class="px-3 py-2 font-semibold">Pagination size</th>
                            </tr>
                        </thead>
                        <tbody style="color: var(--ui-text-secondary);">
                            @foreach ($sizePairings as [$label, $tableSize, $paginationSize])
                                <tr class="border-t" style="border-color: var(--ui-border-subtle-01);">
                                    <td class="px-3 py-2 font-semibold" style="color: var(--ui-text-primary);">{{ $label }}</td>
                                    <td class="px-3 py-2"><code>{{ $tableSize }}</code></td>
                                    <td class="px-3 py-2"><code>{{ $paginationSize }}</code></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Attached below a data table</h4>
                <div class="mt-4">
                    <x-ui.data-table
                        id="pagination-paired-table"
                        title="Medium table with medium pagination"
                        :columns="$tableColumns"
                        :rows="$tableRows"
                        size="md"
                    >
                        <x-slot name="paginationSlot">
                            <x-ui.pagination id="pagination-paired-table-control" label="Medium table pagination" variant="pagination" size="md" :current-page="3" :total-pages="12" :total-items="287" :page-size="25" :page-size-options="$pageSizeOptions" base-url="#" interactive />
                        </x-slot>
                    </x-ui.data-table>
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-pagination-live-section="overflow-menu-behavior">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Overflow menu behavior</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">The ellipsis opens a menu of hidden pages, supports keyboard navigation, closes after selection, closes on outside click, and scrolls when many pages are hidden.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Overflow ellipsis</h4>
                <div class="mt-4">
                    <x-ui.pagination id="pagination-nav-overflow" label="Overflow pagination nav" variant="pagination-nav" size="md" alignment="left" :current-page="18" :total-pages="42" :window="1" base-url="#" interactive />
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Overflow menu open</h4>
                <div class="mt-4">
                    <x-ui.pagination id="pagination-nav-overflow-open" label="Open overflow pagination nav" variant="pagination-nav" size="md" alignment="left" :current-page="20" :total-pages="75" :window="1" base-url="#" interactive data-ui-pagination-overflow-open-example="true" />
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-pagination-live-section="responsive-small-breakpoint">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Small-breakpoint responsive pagination</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">At the small breakpoint, select controls are removed while total item information, current item range, previous, and next remain visible and usable.</p>

        <div class="mt-4 max-w-md">
            <x-ui.pagination
                id="pagination-small-breakpoint"
                label="Small breakpoint pagination"
                variant="pagination"
                size="sm"
                :current-page="2"
                :total-pages="9"
                :total-items="90"
                :page-size="10"
                :page-size-options="[10, 25, 50]"
                base-url="#"
                interactive
                small-breakpoint
            />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-pagination-live-section="api-boundaries">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Pagination versus related APIs</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Pagination owns page navigation controls. Tables, search results, and lists own the content being paginated.</p>

        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead>
                    <tr style="color: var(--ui-text-primary);">
                        <th class="px-4 py-3 font-semibold">Need</th>
                        <th class="px-4 py-3 font-semibold">Use</th>
                        <th class="px-4 py-3 font-semibold">Canonical call</th>
                        <th class="px-4 py-3 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody style="color: var(--ui-text-secondary);">
                    @foreach ($implementationRows as $row)
                        <tr class="border-t" style="border-color: var(--ui-border-subtle-01);">
                            <td class="px-4 py-3 font-semibold" style="color: var(--ui-text-primary);">{{ $row[0] }}</td>
                            <td class="px-4 py-3">{{ $row[1] }}</td>
                            <td class="px-4 py-3"><code>{{ $row[2] }}</code></td>
                            <td class="px-4 py-3">{{ $row[3] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
