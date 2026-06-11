<div class="space-y-6">
    <section class="ui-card" data-grid-example="responsive-grid-visualizer">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h2 class="ui-card-title">Responsive Grid Visualizer</h2>
                <p class="ui-card-copy mt-2">Columns, margins, padding, and gutters should resolve through approved layout utilities and spacing tokens.</p>
            </div>
            <label class="inline-flex items-center gap-2 text-sm ui-reference-text">
                <input type="checkbox" checked class="rounded ui-platform-checkbox">
                Show grid overlay
            </label>
        </div>
        <div class="mt-5 ui-reference-subtle-surface p-4">
            <p class="text-xs font-semibold uppercase tracking-[0.16em] ui-reference-text-muted">Viewport width indicator: 320 / 672 / 1056 / 1312 / 1584px</p>
            <div class="mt-4 grid grid-cols-4 gap-2 md:grid-cols-8 xl:grid-cols-16" aria-label="Responsive columns">
                @for ($column = 1; $column <= 16; $column++)
                    <div class="ui-reference-grid-column">{{ $column }}</div>
                @endfor
            </div>
        </div>
    </section>

    <section class="ui-card" data-grid-example="breakpoint-examples">
        <h2 class="ui-card-title">Breakpoint Examples</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-5">
            @foreach ([['Small', '320px', '4 columns'], ['Medium', '672px', '8 columns'], ['Large', '1056px', '16 columns'], ['X-Large', '1312px', '16 columns'], ['Max', '1584px', '16 columns']] as [$name, $width, $cols])
                <article class="ui-reference-subtle-surface p-4">
                    <p class="text-sm font-semibold ui-reference-text-strong">{{ $name }}</p>
                    <p class="mt-2 font-mono text-xs ui-reference-text-muted">{{ $width }}</p>
                    <p class="mt-2 text-sm ui-reference-text">{{ $cols }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-grid-example="column-span-examples">
        <h2 class="ui-card-title">Column Span Examples</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-4">
            <div class="ui-reference-subtle-surface p-4 xl:col-span-4">Full-width content</div>
            <div class="ui-reference-subtle-surface p-4 xl:col-span-2">Half-width content</div>
            <div class="ui-reference-subtle-surface p-4 xl:col-span-2">Half-width content</div>
            <div class="ui-reference-subtle-surface p-4">Quarter-width card</div>
            <div class="ui-reference-subtle-surface p-4">Quarter-width card</div>
            <div class="ui-reference-subtle-surface p-4">Quarter-width card</div>
            <div class="ui-reference-subtle-surface p-4">Quarter-width card</div>
            <div class="ui-reference-subtle-surface p-4 xl:col-span-1">Sidebar</div>
            <div class="ui-reference-subtle-surface p-4 xl:col-span-3">Content region</div>
        </div>
    </section>

    <section class="ui-card" data-grid-example="gutter-padding-margin-examples">
        <h2 class="ui-card-title">Gutters, Padding, And Margins</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="ui-reference-subtle-surface p-4"><div class="grid grid-cols-3 gap-0"><span class="h-12 ui-reference-grid-block"></span><span class="h-12 ui-reference-grid-block"></span><span class="h-12 ui-reference-grid-block"></span></div><p class="mt-3 text-sm ui-reference-text">Gutterless layout</p></article>
            <article class="ui-reference-subtle-surface p-4"><div class="grid grid-cols-3 gap-4"><span class="h-12 ui-reference-grid-block"></span><span class="h-12 ui-reference-grid-block"></span><span class="h-12 ui-reference-grid-block"></span></div><p class="mt-3 text-sm ui-reference-text">Standard gutter layout</p></article>
            <article class="ui-reference-subtle-surface p-4"><div class="space-y-2"><p class="border-l ui-reference-border-strong pl-4 text-sm ui-reference-text-strong">Type aligns to padding edge.</p><p class="border-l ui-reference-border pl-4 text-sm ui-reference-text-muted">No arbitrary floating text.</p></div><p class="mt-3 text-sm ui-reference-text">Padding alignment</p></article>
        </div>
    </section>

    <section class="ui-card" data-grid-example="fluid-fixed-hybrid">
        <h2 class="ui-card-title">Fluid, Fixed, And Hybrid Regions</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="ui-reference-subtle-surface p-4"><p class="font-semibold ui-reference-text-strong">Fluid</p><p class="mt-2 text-sm ui-reference-text-muted">Dashboards, tables, charts, and large content regions.</p></article>
            <article class="ui-reference-subtle-surface p-4"><p class="font-semibold ui-reference-text-strong">Fixed</p><p class="mt-2 text-sm ui-reference-text-muted">Tiles, icon groups, and compact card grids.</p></article>
            <article class="ui-reference-subtle-surface p-4"><p class="font-semibold ui-reference-text-strong">Hybrid</p><p class="mt-2 text-sm ui-reference-text-muted">Header, toolbar, side panel, data table, and app shell.</p></article>
        </div>
    </section>

    <section class="ui-card" data-grid-example="app-scaffold">
        <h2 class="ui-card-title">App Scaffold Example</h2>
        <div class="mt-5 grid min-h-80 grid-cols-12 grid-rows-[auto_1fr_auto] gap-3 ui-reference-subtle-surface p-4 text-sm ui-reference-text">
            <div class="col-span-12 rounded ui-reference-table-head p-3">Header</div>
            <div class="col-span-12 rounded ui-reference-table-head p-3 md:col-span-2">Global side nav</div>
            <div class="col-span-12 rounded ui-reference-table-head p-3 md:col-span-2">Local side nav</div>
            <div class="col-span-12 rounded ui-reference-table-head p-3 md:col-span-6">Main content</div>
            <div class="col-span-12 rounded ui-reference-table-head p-3 md:col-span-2">Right panel</div>
            <div class="col-span-12 rounded border ui-reference-grid-accent p-3">Dialog / modal overlay target</div>
        </div>
    </section>
</div>
