<div class="space-y-6">
    <section class="ui-card" data-pictograms-example="queued-library">
        <h2 class="ui-card-title">Approved Pictogram Library Disposition</h2>
        <p class="ui-card-copy mt-2">No pictogram asset library is approved yet. The table documents the trigger conditions a future decision must satisfy.</p>
        <div class="mt-5 overflow-x-auto rounded-lg border border-slate-800 bg-slate-950/60">
            <table class="w-full min-w-[760px] divide-y divide-slate-800 text-sm">
                <thead class="bg-slate-900 text-left text-xs uppercase tracking-[0.18em] text-slate-500">
                    <tr><th class="px-4 py-3">Type</th><th class="px-4 py-3">Disposition</th><th class="px-4 py-3">Usage Context</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-800 text-slate-300">
                    <tr><td class="px-4 py-3">Productive pictograms</td><td class="px-4 py-3">Queued Gap</td><td class="px-4 py-3">Empty states, onboarding, feature cards, help panels.</td></tr>
                    <tr><td class="px-4 py-3">Expressive pictograms</td><td class="px-4 py-3">Needs audit</td><td class="px-4 py-3">High-presence moments only; not admin/product UI by default.</td></tr>
                    <tr><td class="px-4 py-3">Carbon pictograms</td><td class="px-4 py-3">Not imported</td><td class="px-4 py-3">Requires separate decision record.</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="ui-card" data-pictograms-example="size-examples">
        <h2 class="ui-card-title">Size Examples</h2>
        <div class="mt-5 flex flex-wrap items-end gap-5">
            @foreach ([48, 64, 80, 96, 128] as $size)
                <div class="text-center">
                    <div class="grid place-items-center rounded-lg border border-slate-700 bg-slate-950 text-slate-300" style="width: {{ $size }}px; height: {{ $size }}px;">{{ $size }}</div>
                    <p class="mt-2 text-xs text-slate-500">{{ $size }}px</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-pictograms-example="productive-expressive-comparison">
        <h2 class="ui-card-title">Productive Vs Expressive Comparison</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><div class="grid h-16 w-16 place-items-center rounded-lg border border-slate-700 text-slate-300">P</div><p class="mt-3 font-semibold text-white">Productive empty state</p><p class="mt-2 text-sm text-slate-400">Default future direction.</p></article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><div class="grid h-20 w-20 place-items-center rounded-lg border border-sky-500/40 bg-sky-500/10 text-sky-100">P</div><p class="mt-3 font-semibold text-white">Productive card illustration</p><p class="mt-2 text-sm text-slate-400">Supportive but restrained.</p></article>
            <article class="rounded-lg border border-amber-500/40 bg-amber-500/10 p-4"><div class="grid h-24 w-24 place-items-center rounded-xl border border-amber-400/40 text-amber-100">E</div><p class="mt-3 font-semibold text-amber-100">Expressive hero moment</p><p class="mt-2 text-sm text-amber-200">Do not overuse expressive pictograms.</p></article>
        </div>
    </section>

    <section class="ui-card" data-pictograms-example="container-clearance-theme">
        <h2 class="ui-card-title">Containers, Clearance, And Theme Contexts</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-4">
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><div class="grid h-16 w-16 place-items-center text-slate-300">No container</div><p class="mt-3 text-sm text-slate-400">Allowed when background contrast is sufficient.</p></article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><div class="grid h-16 w-16 place-items-center rounded-full border border-slate-700 text-slate-300">Circle</div><p class="mt-3 text-sm text-slate-400">Circle container with clearance.</p></article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><div class="grid h-16 w-16 place-items-center rounded-lg border border-slate-700 text-slate-300">Square</div><p class="mt-3 text-sm text-slate-400">Square container with padding.</p></article>
            <article class="rounded-lg border border-rose-500/40 bg-rose-500/10 p-4"><div class="grid h-12 w-12 place-items-center overflow-hidden rounded border border-rose-400 text-rose-100">Crop</div><p class="mt-3 text-sm text-rose-200">Incorrect cropping/collapsed spacing.</p></article>
        </div>
    </section>

    <section class="ui-card" data-pictograms-example="app-usage-examples">
        <h2 class="ui-card-title">App Usage Examples</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-5">
            @foreach (['Empty state', 'Onboarding panel', 'Feature card', 'Help section', 'No results'] as $label)
                <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4 text-center">
                    <div class="mx-auto grid h-16 w-16 place-items-center rounded-lg border border-slate-700 text-slate-300">?</div>
                    <p class="mt-3 text-sm font-semibold text-white">{{ $label }}</p>
                </article>
            @endforeach
        </div>
    </section>
</div>
