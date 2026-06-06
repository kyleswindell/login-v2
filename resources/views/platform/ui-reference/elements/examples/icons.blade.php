<div class="space-y-6">
    <section class="ui-card" data-icons-example="approved-heroicons-list">
        <h2 class="ui-card-title">Approved Icon Library</h2>
        <div class="mt-5 overflow-x-auto rounded-lg border border-slate-800 bg-slate-950/60">
            <table class="w-full min-w-[760px] divide-y divide-slate-800 text-sm">
                <thead class="bg-slate-900 text-left text-xs uppercase tracking-[0.18em] text-slate-500">
                    <tr><th class="px-4 py-3">Icon</th><th class="px-4 py-3">Category</th><th class="px-4 py-3">Sizes</th><th class="px-4 py-3">Helper Reference</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-800 text-slate-300">
                    <tr><td class="px-4 py-3"><x-heroicon-o-magnifying-glass class="h-4 w-4" /> Search</td><td class="px-4 py-3">Action</td><td class="px-4 py-3">16, 20</td><td class="px-4 py-3 font-mono text-xs">x-heroicon-o-magnifying-glass</td></tr>
                    <tr><td class="px-4 py-3"><x-heroicon-o-check-circle class="h-4 w-4" /> Check circle</td><td class="px-4 py-3">Status</td><td class="px-4 py-3">16, 20, 24</td><td class="px-4 py-3 font-mono text-xs">x-heroicon-o-check-circle</td></tr>
                    <tr><td class="px-4 py-3"><x-heroicon-o-cog-6-tooth class="h-4 w-4" /> Settings</td><td class="px-4 py-3">Navigation/action</td><td class="px-4 py-3">20, 24</td><td class="px-4 py-3 font-mono text-xs">x-heroicon-o-cog-6-tooth</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="ui-card" data-icons-example="icon-size-matrix">
        <h2 class="ui-card-title">Icon Sizes</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-4">
            @foreach ([['16px', 'h-4 w-4'], ['20px', 'h-5 w-5'], ['24px', 'h-6 w-6'], ['32px', 'h-8 w-8']] as [$label, $class])
                <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                    <x-heroicon-o-bell class="{{ $class }} text-slate-200" />
                    <p class="mt-3 text-sm text-slate-300">{{ $label }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-icons-example="icon-with-text">
        <h2 class="ui-card-title">Icon With Text</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-5">
            <button class="ui-button ui-button-neutral" type="button"><x-heroicon-o-arrow-down-tray class="h-4 w-4" />Leading icon</button>
            <button class="ui-button ui-button-neutral" type="button">Trailing icon<x-heroicon-o-chevron-right class="h-4 w-4" /></button>
            <a href="#" class="ui-link inline-flex items-center gap-2"><x-heroicon-o-arrow-top-right-on-square class="h-4 w-4" />Inline link</a>
            <button class="ui-button ui-button-primary" type="button"><x-heroicon-o-plus class="h-4 w-4" />Button</button>
            <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-3 text-sm text-slate-200"><x-heroicon-o-ellipsis-horizontal class="mr-2 inline h-4 w-4" />Menu item</div>
        </div>
    </section>

    <section class="ui-card" data-icons-example="icon-only-controls">
        <h2 class="ui-card-title">Icon-Only Controls</h2>
        <div class="mt-5 flex flex-wrap gap-3">
            @foreach (['Default', 'Hover', 'Active', 'Focus', 'Disabled', 'Loading'] as $state)
                <button type="button" @disabled($state === 'Disabled') class="grid h-11 w-11 place-items-center rounded-md border border-slate-700 text-slate-200 {{ $state === 'Hover' ? 'bg-slate-800' : 'bg-slate-950' }} {{ $state === 'Active' ? 'bg-slate-700' : '' }} {{ $state === 'Focus' ? 'ring-2 ring-sky-400 ring-offset-2 ring-offset-slate-950' : '' }}" aria-label="{{ $state }} icon control">
                    @if ($state === 'Loading')
                        <span class="ui-spinner"></span>
                    @else
                        <x-heroicon-o-cog-6-tooth class="h-5 w-5" />
                    @endif
                </button>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-icons-example="status-decorative-meaningful">
        <h2 class="ui-card-title">Status, Decorative, And Meaningful Icons</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="flex items-center gap-2 text-sm text-emerald-200"><x-heroicon-o-check-circle class="h-4 w-4" />Success</p><p class="mt-2 flex items-center gap-2 text-sm text-amber-200"><x-heroicon-o-exclamation-triangle class="h-4 w-4" />Warning</p><p class="mt-2 flex items-center gap-2 text-sm text-rose-200"><x-heroicon-o-x-circle class="h-4 w-4" />Error</p><p class="mt-2 flex items-center gap-2 text-sm text-sky-200"><x-heroicon-o-information-circle class="h-4 w-4" />Info / in progress</p></article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><x-heroicon-o-sparkles class="h-5 w-5 text-slate-400" aria-hidden="true" /><p class="mt-3 text-sm text-slate-300">Decorative icon hidden from assistive tech.</p></article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><button class="grid h-11 w-11 place-items-center rounded-md border border-slate-700" aria-label="Open notifications" type="button"><x-heroicon-o-bell class="h-5 w-5 text-slate-200" /></button><p class="mt-3 text-sm text-slate-300">Meaningful icon-only button with accessible name and 44px hit target.</p></article>
        </div>
    </section>
</div>
