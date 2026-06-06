<div class="space-y-6">
    <section class="ui-card" data-grid-example="responsive-grid-visualizer">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h2 class="ui-card-title">Responsive Grid Visualizer</h2>
                <p class="ui-card-copy mt-2">Columns, margins, padding, and gutters should resolve through approved layout utilities and spacing tokens.</p>
            </div>
            <label class="inline-flex items-center gap-2 text-sm text-slate-300">
                <input type="checkbox" checked class="rounded border-slate-700 bg-slate-950">
                Show grid overlay
            </label>
        </div>
        <div class="mt-5 rounded-lg border border-slate-800 bg-slate-950/70 p-4">
            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Viewport width indicator: 320 / 672 / 1056 / 1312 / 1584px</p>
            <div class="mt-4 grid grid-cols-4 gap-2 md:grid-cols-8 xl:grid-cols-16" aria-label="Responsive columns">
                @for ($column = 1; $column <= 16; $column++)
                    <div class="min-h-14 rounded border border-sky-400/40 bg-sky-400/10 text-center text-xs leading-[3.5rem] text-sky-100">{{ $column }}</div>
                @endfor
            </div>
        </div>
    </section>

    <section class="ui-card" data-grid-example="breakpoint-examples">
        <h2 class="ui-card-title">Breakpoint Examples</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-5">
            @foreach ([['Small', '320px', '4 columns'], ['Medium', '672px', '8 columns'], ['Large', '1056px', '16 columns'], ['X-Large', '1312px', '16 columns'], ['Max', '1584px', '16 columns']] as [$name, $width, $cols])
                <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                    <p class="text-sm font-semibold text-white">{{ $name }}</p>
                    <p class="mt-2 font-mono text-xs text-slate-400">{{ $width }}</p>
                    <p class="mt-2 text-sm text-slate-300">{{ $cols }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-grid-example="column-span-examples">
        <h2 class="ui-card-title">Column Span Examples</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-4">
            <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4 xl:col-span-4">Full-width content</div>
            <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4 xl:col-span-2">Half-width content</div>
            <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4 xl:col-span-2">Half-width content</div>
            <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">Quarter-width card</div>
            <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">Quarter-width card</div>
            <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">Quarter-width card</div>
            <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">Quarter-width card</div>
            <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4 xl:col-span-1">Sidebar</div>
            <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4 xl:col-span-3">Content region</div>
        </div>
    </section>

    <section class="ui-card" data-grid-example="gutter-padding-margin-examples">
        <h2 class="ui-card-title">Gutters, Padding, And Margins</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><div class="grid grid-cols-3 gap-0"><span class="h-12 bg-slate-800"></span><span class="h-12 bg-slate-700"></span><span class="h-12 bg-slate-800"></span></div><p class="mt-3 text-sm text-slate-300">Gutterless layout</p></article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><div class="grid grid-cols-3 gap-4"><span class="h-12 bg-slate-800"></span><span class="h-12 bg-slate-700"></span><span class="h-12 bg-slate-800"></span></div><p class="mt-3 text-sm text-slate-300">Standard gutter layout</p></article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><div class="space-y-2"><p class="border-l border-sky-400 pl-4 text-sm text-slate-200">Type aligns to padding edge.</p><p class="border-l border-slate-700 pl-4 text-sm text-slate-400">No arbitrary floating text.</p></div><p class="mt-3 text-sm text-slate-300">Padding alignment</p></article>
        </div>
    </section>

    <section class="ui-card" data-grid-example="fluid-fixed-hybrid">
        <h2 class="ui-card-title">Fluid, Fixed, And Hybrid Regions</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="font-semibold text-white">Fluid</p><p class="mt-2 text-sm text-slate-400">Dashboards, tables, charts, and large content regions.</p></article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="font-semibold text-white">Fixed</p><p class="mt-2 text-sm text-slate-400">Tiles, icon groups, and compact card grids.</p></article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="font-semibold text-white">Hybrid</p><p class="mt-2 text-sm text-slate-400">Header, toolbar, side panel, data table, and app shell.</p></article>
        </div>
    </section>

    <section class="ui-card" data-grid-example="app-scaffold">
        <h2 class="ui-card-title">App Scaffold Example</h2>
        <div class="mt-5 grid min-h-80 grid-cols-12 grid-rows-[auto_1fr_auto] gap-3 rounded-lg border border-slate-800 bg-slate-950/70 p-4 text-sm text-slate-300">
            <div class="col-span-12 rounded bg-slate-900 p-3">Header</div>
            <div class="col-span-12 rounded bg-slate-900 p-3 md:col-span-2">Global side nav</div>
            <div class="col-span-12 rounded bg-slate-900 p-3 md:col-span-2">Local side nav</div>
            <div class="col-span-12 rounded bg-slate-900 p-3 md:col-span-6">Main content</div>
            <div class="col-span-12 rounded bg-slate-900 p-3 md:col-span-2">Right panel</div>
            <div class="col-span-12 rounded border border-sky-500/40 bg-sky-500/10 p-3">Dialog / modal overlay target</div>
        </div>
    </section>
</div>
