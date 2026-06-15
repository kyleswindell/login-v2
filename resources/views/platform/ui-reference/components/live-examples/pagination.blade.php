@php
    $pageSizeOptions = [
        ['value' => 10, 'label' => '10'],
        ['value' => 25, 'label' => '25'],
        ['value' => 50, 'label' => '50'],
        ['value' => 100, 'label' => '100'],
    ];

    $implementationRows = [
        ['Pagination bar', 'Data table footer with items-per-page, range, page selector, previous, and next.', '<x-ui.pagination variant="pagination" :page-size-options="$options" />', 'Installed here'],
        ['Pagination nav', 'Page-button navigation below page, section, list, or search-result content.', '<x-ui.pagination variant="pagination-nav" alignment="right" />', 'Installed here'],
        ['Looping nav', 'Optional cycling for content where continuous page loops make sense.', '<x-ui.pagination variant="pagination-nav" loop />', 'Modifier'],
        ['Progression flows', 'Linear steps are not pagination.', '<x-ui.progress-indicator ... />', 'Use another component'],
        ['Small result sets', 'No pagination when all content fits clearly in one view.', 'No component', 'Do not render fake controls'],
    ];
@endphp

<div class="space-y-6" data-component-live-layout="pagination-matrix" data-ui-reference-sample-type="pagination">
    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-pagination-live-section="pagination-bar">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Pagination bar</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Use the pagination variant below tables or large record regions when users need item range, page size, page selection, and previous or next navigation.</p>

        <div class="mt-4 overflow-hidden border" style="border-color: var(--ui-border-subtle-01);">
            <div class="grid grid-cols-3 gap-px" style="background-color: var(--ui-border-subtle-01);">
                @foreach (['Workspace', 'Owner', 'Status'] as $header)
                    <div class="px-4 py-3 text-sm font-semibold" style="background-color: var(--ui-layer-01); color: var(--ui-text-primary);">{{ $header }}</div>
                @endforeach
                @foreach ([['Acme production', 'Sam Rivera', 'Active'], ['Northwind staging', 'Lee Chen', 'Pending'], ['Sandbox tenant', 'Morgan Fox', 'Paused']] as $row)
                    @foreach ($row as $cell)
                        <div class="px-4 py-3 text-sm" style="background-color: var(--ui-layer-01); color: var(--ui-text-secondary);">{{ $cell }}</div>
                    @endforeach
                @endforeach
            </div>

            <x-ui.pagination
                id="pagination-bar-standard"
                label="Workspace table pagination"
                variant="pagination"
                size="md"
                :current-page="3"
                :total-pages="12"
                :total-items="287"
                :page-size="25"
                :page-size-options="$pageSizeOptions"
                base-url="/platform/ui-reference/components/pagination"
            />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-pagination-live-section="pagination-nav">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Pagination nav</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Use pagination nav beneath page or section content. The current page uses a selected border and overflow controls expose hidden pages without crowding the row.</p>

        <div class="mt-4 grid gap-4 lg:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Right aligned</h4>
                <div class="mt-4">
                    <x-ui.pagination
                        id="pagination-nav-right"
                        label="Search results pagination"
                        variant="pagination-nav"
                        size="md"
                        alignment="right"
                        :current-page="8"
                        :total-pages="24"
                        :total-items="590"
                        :page-size="25"
                        base-url="/platform/ui-reference/components/pagination"
                    />
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Left aligned</h4>
                <div class="mt-4">
                    <x-ui.pagination
                        id="pagination-nav-left"
                        label="Activity feed pagination"
                        variant="pagination-nav"
                        size="md"
                        alignment="left"
                        :current-page="4"
                        :total-pages="10"
                        base-url="/platform/ui-reference/components/pagination"
                    />
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-pagination-live-section="sizes-boundaries">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Sizes and boundary states</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Pagination supports small, medium, and large controls. Previous disables on the first page and next disables on the last page when looping is off.</p>

        <div class="mt-4 grid gap-4">
            <x-ui.pagination id="pagination-size-sm" label="Small pagination" variant="pagination-nav" size="sm" alignment="left" :current-page="1" :total-pages="5" base-url="/platform/ui-reference/components/pagination" />
            <x-ui.pagination id="pagination-size-md" label="Medium pagination" variant="pagination-nav" size="md" alignment="left" :current-page="3" :total-pages="5" base-url="/platform/ui-reference/components/pagination" />
            <x-ui.pagination id="pagination-size-lg" label="Large pagination" variant="pagination-nav" size="lg" alignment="left" :current-page="5" :total-pages="5" base-url="/platform/ui-reference/components/pagination" />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-pagination-live-section="looping-responsive">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Looping and responsive behavior</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Looping keeps previous and next enabled at boundaries only when continuous cycling makes sense. Responsive bar examples preserve range and previous/next controls at small widths.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Looping nav</h4>
                <div class="mt-4">
                    <x-ui.pagination id="pagination-loop" label="Gallery pagination" variant="pagination-nav" size="md" alignment="left" :current-page="5" :total-pages="5" loop base-url="/platform/ui-reference/components/pagination" />
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Narrow bar fallback</h4>
                <div class="mt-4 max-w-sm overflow-hidden border" style="border-color: var(--ui-border-subtle-01);">
                    <x-ui.pagination
                        id="pagination-responsive"
                        label="Narrow table pagination"
                        variant="pagination"
                        size="sm"
                        :current-page="2"
                        :total-pages="9"
                        :total-items="90"
                        :page-size="10"
                        :page-size-options="[10, 25, 50]"
                        base-url="/platform/ui-reference/components/pagination"
                    />
                </div>
            </article>
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
