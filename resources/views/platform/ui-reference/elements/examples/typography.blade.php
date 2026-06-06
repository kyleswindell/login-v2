<div class="space-y-6">
    <section class="ui-card" data-typography-example="font-specimens">
        <h2 class="ui-card-title">Font Family Specimens</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="text-sm font-semibold text-white">Sans</p><p class="mt-3 text-xl text-slate-100">Productive admin interface text</p></article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="text-sm font-semibold text-white">Mono</p><code class="mt-3 block text-sm text-slate-200">--ui-text-strong</code></article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="text-sm font-semibold text-white">Serif</p><p class="mt-3 text-sm text-slate-400">Not currently used in product UI.</p></article>
        </div>
    </section>

    <section class="ui-card" data-typography-example="type-scale">
        <h2 class="ui-card-title">Type Scale</h2>
        <div class="mt-5 space-y-3">
            @foreach ([12, 14, 16, 18, 20, 24, 28, 32] as $size)
                <div class="grid grid-cols-[5rem_minmax(0,1fr)] items-baseline gap-4">
                    <span class="font-mono text-xs text-slate-500">{{ $size }}px</span>
                    <p class="text-slate-200" style="font-size: {{ $size }}px;">{{ $size }}px productive type sample</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-typography-example="type-role-examples">
        <h2 class="ui-card-title">Type Role Examples</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-2">
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                <h1 class="ui-page-header-title">Page title</h1>
                <h2 class="ui-card-title mt-4">Section heading</h2>
                <h3 class="mt-3 text-base font-semibold text-white">Subsection heading</h3>
                <p class="mt-3 text-sm text-slate-300">Body text uses neutral content color.</p>
                <p class="mt-1 text-xs text-slate-500">Caption text</p>
            </article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                <label class="text-sm font-semibold text-slate-100" for="type-field">Label</label>
                <input id="type-field" class="ui-input mt-2" value="Typography field">
                <p class="mt-1 text-sm text-slate-400">Helper text</p>
                <p class="mt-1 text-sm text-rose-200">Error text</p>
                <code class="mt-3 block rounded border border-slate-800 bg-slate-950 p-3 text-sm text-slate-200">Code / mono text</code>
            </article>
        </div>
    </section>

    <section class="ui-card" data-typography-example="productive-content-examples">
        <h2 class="ui-card-title">Productive Content Examples</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="text-lg font-semibold text-white">Settings form</p><p class="mt-2 text-sm text-slate-400">Compact hierarchy for repeated admin tasks.</p><button class="ui-button ui-button-primary mt-4" type="button">Save settings</button></article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Table header</p><p class="mt-3 text-sm text-slate-200">Table cell</p><a href="#" class="ui-link mt-3 inline-flex">Link text</a></article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="text-base font-semibold text-white">Notification</p><p class="mt-2 text-sm text-slate-300">Inline validation and feedback use semantic copy but neutral structure.</p></article>
        </div>
    </section>

    <section class="ui-card" data-typography-example="productive-vs-expressive">
        <h2 class="ui-card-title">Productive Vs Expressive</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-2">
            <article class="rounded-lg border border-emerald-500/40 bg-emerald-500/10 p-4"><p class="text-base font-semibold text-emerald-100">Productive type: allowed by default</p><p class="mt-2 text-sm text-emerald-200">Use for app pages, dense admin UI, forms, tables, and workflow screens.</p></article>
            <article class="rounded-lg border border-amber-500/40 bg-amber-500/10 p-4"><p class="text-2xl font-semibold text-amber-100">Expressive type</p><p class="mt-2 text-sm text-amber-200">Not for admin/product UI unless a landing, onboarding, or marketing-style page owns it.</p></article>
        </div>
    </section>

    <section class="ui-card" data-typography-example="weight-color-examples">
        <h2 class="ui-card-title">Weight And Color Examples</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="font-normal text-slate-200">Regular body</p><p class="mt-2 font-semibold text-white">Semibold heading/emphasis</p><p class="mt-2 italic text-slate-400">Italic only for limited emphasis</p></article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="text-slate-100">Primary text</p><p class="mt-2 text-slate-400">Secondary text</p><p class="mt-2 text-slate-500">Placeholder / disabled text</p></article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><a href="#" class="ui-link">Link text</a><p class="mt-2 text-rose-200">Error/helper text</p><p class="mt-2 text-slate-500">Disabled text</p></article>
        </div>
    </section>
</div>
