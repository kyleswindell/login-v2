<x-ui.patterns.widget-shell
    title="Platform Overview"
    description="Current account and notification totals."
    :meta="['Summary widget']"
>
    <div class="grid gap-4 md:grid-cols-3">
        @foreach ($stats as $stat)
            <article class="ui-pattern-widget-shell-section {{ match ($stat['tone']) {
                'emerald' => 'border-emerald-500/30 bg-emerald-500/10',
                'amber' => 'border-amber-500/30 bg-amber-500/10',
                default => 'border-slate-700 bg-slate-950/70',
            } }}">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">{{ $stat['label'] }}</p>
                <p class="mt-3 text-3xl font-semibold text-white">{{ number_format($stat['value']) }}</p>
            </article>
        @endforeach
    </div>
</x-ui.patterns.widget-shell>
