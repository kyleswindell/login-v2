<div class="space-y-6">
    <section class="ui-card" data-motion-example="easing-demos">
        <h2 class="ui-card-title">Motion Token And Easing Demos</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            @foreach ([
                ['Productive standard', 'transition duration-150 ease-out'],
                ['Productive entrance', 'transition duration-200 ease-out'],
                ['Productive exit', 'transition duration-150 ease-in'],
                ['Expressive standard', 'transition duration-300 ease-out'],
                ['Expressive entrance', 'transition duration-500 ease-out'],
                ['Expressive exit', 'transition duration-300 ease-in'],
            ] as [$label, $classes])
                <article class="group rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                    <p class="text-sm font-semibold text-white">{{ $label }}</p>
                    <div class="mt-4 h-2 rounded bg-slate-800">
                        <div class="h-2 w-1/3 rounded bg-sky-400 {{ $classes }} group-hover:w-full"></div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-motion-example="common-ui-motion">
        <h2 class="ui-card-title">Common UI Motion Examples</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-4">
            @foreach ([
                ['Dropdown opening', 'Open state appears near trigger.'],
                ['Modal entering/exiting', 'Blocking overlay focuses the decision.'],
                ['Toast notification', 'Feedback appears without stealing workflow.'],
                ['Accordion/collapse', 'Disclosure expands local content.'],
                ['Side panel', 'Context slides from edge.'],
                ['Table sorting/reordering', 'State changes without losing row identity.'],
                ['Loading/skeleton transition', 'Pending shape resolves to content.'],
            ] as [$label, $copy])
                <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4 transition hover:border-sky-400 hover:bg-slate-900">
                    <p class="text-sm font-semibold text-white">{{ $label }}</p>
                    <p class="mt-2 text-sm text-slate-400">{{ $copy }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-motion-example="duration-examples">
        <h2 class="ui-card-title">Duration Examples</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-5">
            @foreach ([['Small movement', '100-150ms'], ['Medium movement', '150-250ms'], ['Large movement', '250-400ms'], ['Fast productive interaction', 'short'], ['Slower expressive transition', 'owner required']] as [$label, $duration])
                <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                    <p class="text-sm font-semibold text-white">{{ $label }}</p>
                    <p class="mt-2 font-mono text-xs text-slate-400">{{ $duration }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-motion-example="reduced-motion-preview">
        <h2 class="ui-card-title">Reduced Motion Mode</h2>
        <p class="ui-card-copy mt-2">Respect `prefers-reduced-motion`. Non-essential movement should be removed, shortened, or replaced while preserving visible state and feedback.</p>
        <div class="mt-5 grid gap-4 xl:grid-cols-2">
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="text-sm font-semibold text-white">Normal preview</p><div class="mt-4 h-3 w-2/3 rounded bg-sky-400 transition-all duration-300"></div></article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="text-sm font-semibold text-white">Reduced preview</p><div class="mt-4 h-3 w-2/3 rounded bg-sky-400"></div></article>
        </div>
    </section>

    <section class="ui-card" data-motion-example="do-dont-samples">
        <h2 class="ui-card-title">Do / Do Not Motion Samples</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-5">
            <article class="rounded-lg border border-emerald-500/40 bg-emerald-500/10 p-4"><p class="font-semibold text-emerald-100">Do: subtle entrance</p></article>
            <article class="rounded-lg border border-emerald-500/40 bg-emerald-500/10 p-4"><p class="font-semibold text-emerald-100">Do: clear exit</p></article>
            <article class="rounded-lg border border-rose-500/40 bg-rose-500/10 p-4"><p class="font-semibold text-rose-100">Do not: bounce</p></article>
            <article class="rounded-lg border border-rose-500/40 bg-rose-500/10 p-4"><p class="font-semibold text-rose-100">Do not: decorative spin</p></article>
            <article class="rounded-lg border border-rose-500/40 bg-rose-500/10 p-4"><p class="font-semibold text-rose-100">Do not: long delay before content is usable</p></article>
        </div>
    </section>
</div>
