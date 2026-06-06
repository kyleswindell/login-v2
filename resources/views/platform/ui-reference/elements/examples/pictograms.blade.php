<div class="space-y-6">
    <section class="ui-card" data-pictograms-example="asset-disposition">
        <h2 class="ui-card-title">Pictogram Disposition</h2>
        <p class="ui-card-copy mt-2">Pictograms remain an audited future asset category. Login App does not import Carbon pictograms or any third-party illustration library in this pass.</p>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="ui-inline-alert flex items-start gap-3 ui-inline-alert-info"><x-heroicon-o-information-circle class="h-5 w-5 shrink-0" /><div><p class="font-semibold">Current decision</p><p class="mt-1 text-sm">Keep queued until a real empty-state, onboarding, feature-card, or help-surface consumer exists.</p></div></article>
            <article class="ui-inline-alert flex items-start gap-3 ui-inline-alert-warning"><x-heroicon-o-exclamation-triangle class="h-5 w-5 shrink-0" /><div><p class="font-semibold">Dependency gate</p><p class="mt-1 text-sm">Any imported asset library requires licensing review and a separate decision record.</p></div></article>
            <article class="ui-inline-alert flex items-start gap-3 ui-inline-alert-danger"><x-heroicon-o-x-circle class="h-5 w-5 shrink-0" /><div><p class="font-semibold">Not allowed</p><p class="mt-1 text-sm">Do not import Carbon pictograms, unreviewed SVG packs, or decorative illustrations ad hoc.</p></div></article>
        </div>
    </section>

    <section class="ui-card" data-pictograms-example="candidate-library-audit">
        <h2 class="ui-card-title">Candidate Library Audit</h2>
        <div class="mt-5 overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated);">
            <table class="w-full min-w-[920px] divide-y text-sm" style="border-color: var(--ui-border-default);">
                <thead class="text-left text-xs uppercase tracking-[0.18em]" style="color: var(--ui-text-muted);">
                    <tr><th class="px-4 py-3">Option</th><th class="px-4 py-3">Fit</th><th class="px-4 py-3">Risk</th><th class="px-4 py-3">Recommendation</th></tr>
                </thead>
                <tbody class="divide-y" style="border-color: var(--ui-border-default); color: var(--ui-text-secondary);">
                    <tr><td class="px-4 py-3 font-semibold" style="color: var(--ui-text-strong);">Keep queued</td><td class="px-4 py-3">Best fit until a concrete app surface needs pictograms.</td><td class="px-4 py-3">No asset coverage yet.</td><td class="px-4 py-3">Recommended default.</td></tr>
                    <tr><td class="px-4 py-3 font-semibold" style="color: var(--ui-text-strong);">Carbon pictograms</td><td class="px-4 py-3">Strong category match to Carbon structure.</td><td class="px-4 py-3">Would import IBM visual language and require ADR.</td><td class="px-4 py-3">Do not adopt without decision record.</td></tr>
                    <tr><td class="px-4 py-3 font-semibold" style="color: var(--ui-text-strong);">unDraw / illustration packs</td><td class="px-4 py-3">Useful for broad empty states.</td><td class="px-4 py-3">License and style fit must be reviewed; may feel marketing-heavy.</td><td class="px-4 py-3">Audit only if onboarding/help surfaces need it.</td></tr>
                    <tr><td class="px-4 py-3 font-semibold" style="color: var(--ui-text-strong);">Iconoir / open icon sets</td><td class="px-4 py-3">May supplement icons, not true pictograms.</td><td class="px-4 py-3">Could duplicate Heroicons and blur icon/pictogram boundary.</td><td class="px-4 py-3">Not recommended for pictograms.</td></tr>
                    <tr><td class="px-4 py-3 font-semibold" style="color: var(--ui-text-strong);">App-specific SVG primitives</td><td class="px-4 py-3">Best long-term fit for Login visual language.</td><td class="px-4 py-3">Requires design ownership.</td><td class="px-4 py-3">Use when a real feature module needs repeated illustrations.</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="ui-card" data-pictograms-example="size-clearance-examples">
        <h2 class="ui-card-title">Size And Clearance Examples</h2>
        <div class="mt-5 flex flex-wrap items-end gap-5">
            @foreach ([48, 64, 80, 96, 128] as $size)
                <div class="text-center">
                    <div class="grid place-items-center rounded-lg border" style="width: {{ $size }}px; height: {{ $size }}px; border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-secondary);">{{ $size }}</div>
                    <p class="mt-2 text-xs" style="color: var(--ui-text-muted);">{{ $size }}px</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-pictograms-example="productive-expressive-comparison">
        <h2 class="ui-card-title">Productive Vs Expressive Comparison</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);"><div class="grid h-16 w-16 place-items-center rounded-lg border" style="border-color: var(--ui-border-default); color: var(--ui-text-secondary);">P</div><p class="mt-3 font-semibold">Productive empty state</p><p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Default future direction.</p></article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-action-soft-primary-border); background: var(--ui-action-soft-primary-bg); color: var(--ui-action-soft-primary-text);"><div class="grid h-20 w-20 place-items-center rounded-lg border" style="border-color: var(--ui-action-soft-primary-border);">P</div><p class="mt-3 font-semibold">Productive card illustration</p><p class="mt-2 text-sm">Supportive but restrained.</p></article>
            <article class="ui-inline-alert flex items-start gap-3 ui-inline-alert-warning"><div><p class="font-semibold">Expressive hero moment</p><p class="mt-1 text-sm">High-presence visuals require design ownership and should not be used by default in admin UI.</p></div></article>
        </div>
    </section>

    <section class="ui-card" data-pictograms-example="trigger-conditions">
        <h2 class="ui-card-title">Trigger Conditions</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-5">
            @foreach (['Empty state', 'Onboarding panel', 'Feature card', 'Help section', 'No results'] as $label)
                <article class="rounded-lg border p-4 text-center" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                    <div class="mx-auto grid h-16 w-16 place-items-center rounded-lg border" style="border-color: var(--ui-border-default); color: var(--ui-text-secondary);">?</div>
                    <p class="mt-3 text-sm font-semibold">{{ $label }}</p>
                </article>
            @endforeach
        </div>
    </section>
</div>
