<section class="rounded-lg border border-slate-800 bg-slate-900/70 p-5">
    <div class="mb-4 flex items-center justify-between gap-3">
        <div>
            <h2 class="text-base font-semibold text-white">Platform Overview</h2>
            <p class="text-sm text-slate-400">Current account and notification totals.</p>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-3">
        @foreach ($stats as $stat)
            <article class="rounded-lg border px-4 py-4 {{ match ($stat['tone']) {
                'emerald' => 'border-emerald-500/30 bg-emerald-500/10',
                'amber' => 'border-amber-500/30 bg-amber-500/10',
                default => 'border-slate-700 bg-slate-950/70',
            } }}">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">{{ $stat['label'] }}</p>
                <p class="mt-3 text-3xl font-semibold text-white">{{ number_format($stat['value']) }}</p>
            </article>
        @endforeach
    </div>
</section>
