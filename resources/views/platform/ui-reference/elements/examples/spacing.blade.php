<div class="space-y-6">
    <section class="ui-card" data-spacing-example="spacing-scale">
        <h2 class="ui-card-title">Spacing Scale</h2>
        <div class="mt-5 space-y-3">
            @foreach ([
                ['$spacing-01', '0.125rem', '2px', 'gap-0.5 / p-0.5'],
                ['$spacing-02', '0.25rem', '4px', 'gap-1 / p-1'],
                ['$spacing-03', '0.5rem', '8px', 'gap-2 / p-2'],
                ['$spacing-04', '0.75rem', '12px', 'gap-3 / p-3'],
                ['$spacing-05', '1rem', '16px', 'gap-4 / p-4'],
                ['$spacing-06', '1.5rem', '24px', 'gap-6 / p-6'],
                ['$spacing-07', '2rem', '32px', 'gap-8 / p-8'],
                ['$spacing-08', '2.5rem', '40px', 'gap-10 / p-10'],
                ['$spacing-09', '3rem', '48px', 'gap-12 / p-12'],
                ['$spacing-10', '4rem', '64px', 'gap-16 / p-16'],
                ['$spacing-11', '5rem', '80px', 'gap-20 / p-20'],
                ['$spacing-12', '6rem', '96px', 'gap-24 / p-24'],
                ['$spacing-13', '10rem', '160px', 'large layout only'],
            ] as [$token, $rem, $px, $utility])
                <div class="grid min-w-0 gap-2 text-sm sm:grid-cols-[8rem_6rem_5rem_minmax(0,1fr)] sm:items-center xl:grid-cols-[8rem_6rem_5rem_9rem_minmax(0,1fr)]">
                    <span class="font-mono ui-reference-text">{{ $token }}</span>
                    <span class="font-mono ui-reference-text-muted">{{ $rem }}</span>
                    <span class="font-mono ui-reference-text-muted">{{ $px }}</span>
                    <span class="font-mono text-xs ui-reference-text-muted sm:col-span-4 xl:col-span-1">{{ $utility }}</span>
                    <span class="block h-3 max-w-full rounded ui-reference-spacing-bar sm:col-span-4 xl:col-span-1" style="width: {{ $px }};"></span>
                </div>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-spacing-example="margin-padding-examples">
        <h2 class="ui-card-title">Margin And Padding Examples</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="ui-reference-subtle-surface p-4">
                <p class="font-semibold ui-reference-text-strong">Margin directions</p>
                <div class="mt-4 grid grid-cols-2 gap-3 text-sm ui-reference-text">
                    <span class="border-t ui-reference-spacing-edge pt-2">Top</span>
                    <span class="border-r ui-reference-spacing-edge pr-2 text-right">Right</span>
                    <span class="border-b ui-reference-spacing-edge pb-2">Bottom</span>
                    <span class="border-l ui-reference-border-strong pl-2">Left</span>
                    <span class="col-span-2 border-x ui-reference-spacing-edge px-3">Horizontal</span>
                    <span class="col-span-2 border-y ui-reference-spacing-edge py-3">Vertical</span>
                </div>
            </article>
            <article class="ui-reference-subtle-surface p-4">
                <p class="font-semibold ui-reference-text-strong">Padding</p>
                <div class="mt-4 space-y-3">
                    <div class="rounded border ui-reference-border-strong p-4 text-sm ui-reference-text">Card padding</div>
                    <div class="rounded border ui-reference-border-strong p-3 text-sm ui-reference-text">Form group padding</div>
                    <div class="rounded border ui-reference-border-strong px-3 py-2 text-sm ui-reference-text">Dense table padding</div>
                </div>
            </article>
            <article class="ui-reference-subtle-surface p-4">
                <p class="font-semibold ui-reference-text-strong">No default external margins</p>
                <p class="mt-3 text-sm ui-reference-text-muted">Components sit flush inside their parent. Parent wrappers apply stack, grid, or gap utilities.</p>
                <div class="mt-4 grid gap-3">
                    <button class="ui-button ui-button-primary" type="button">Component</button>
                    <button class="ui-button ui-button-neutral" type="button">Component</button>
                </div>
            </article>
        </div>
    </section>

    <section class="ui-card" data-spacing-example="stack-examples">
        <h2 class="ui-card-title">Stack And Gap Examples</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="ui-reference-subtle-surface p-4"><p class="font-semibold ui-reference-text-strong">Vertical stack</p><div class="mt-4 space-y-2"><div class="rounded ui-reference-grid-block p-2">Small gap</div><div class="rounded ui-reference-grid-block p-2">Small gap</div></div></article>
            <article class="ui-reference-subtle-surface p-4"><p class="font-semibold ui-reference-text-strong">Horizontal stack</p><div class="mt-4 flex flex-wrap gap-3"><span class="rounded ui-reference-grid-block px-3 py-2">One</span><span class="rounded ui-reference-grid-block px-3 py-2">Two</span><span class="rounded ui-reference-grid-block px-3 py-2">Three</span></div></article>
            <article class="ui-reference-subtle-surface p-4"><p class="font-semibold ui-reference-text-strong">Button group</p><div class="mt-4 flex flex-wrap justify-end gap-3"><button class="ui-button ui-button-neutral" type="button">Cancel</button><button class="ui-button ui-button-primary" type="button">Save</button></div></article>
        </div>
    </section>

    <section class="ui-card" data-spacing-example="relationship-density-examples">
        <h2 class="ui-card-title">Relationships And Density</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="ui-reference-subtle-surface p-4">
                <label class="text-sm font-semibold ui-reference-text-strong" for="spacing-field">Label to input</label>
                <input id="spacing-field" class="ui-input mt-2" value="example">
                <p class="mt-1 text-sm ui-reference-text-muted">Input to helper text.</p>
            </article>
            <article class="ui-reference-subtle-surface p-4">
                <p class="text-sm font-semibold ui-reference-text-strong">Card title to body</p>
                <p class="mt-2 text-sm ui-reference-text-muted">Close spacing signals direct relationship.</p>
                <div class="mt-6 rounded border ui-reference-border-strong p-3 text-sm ui-reference-text">Section separation uses larger spacing.</div>
            </article>
            <article class="ui-reference-subtle-surface p-4">
                <p class="font-semibold ui-reference-text-strong">Density examples</p>
                <div class="mt-4 space-y-3 text-sm">
                    <div class="rounded border ui-reference-border-strong px-3 py-2">Dense admin table row</div>
                    <div class="rounded border ui-reference-border-strong p-4">Standard form group</div>
                    <div class="rounded border ui-reference-border-strong p-6">Spacious help panel</div>
                </div>
            </article>
        </div>
    </section>
</div>
