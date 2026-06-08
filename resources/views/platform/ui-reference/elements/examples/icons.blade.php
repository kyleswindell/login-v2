<div class="space-y-6">
    <section class="ui-card" data-icons-example="approved-heroicons-list">
        <h2 class="ui-card-title">Approved Icon Library</h2>
        <p class="ui-card-copy mt-2">Heroicons remain the approved UI icon library. Do not import another icon set without a decision record.</p>
        <div class="mt-5 overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated);">
            <table class="w-full min-w-[760px] divide-y text-sm" style="border-color: var(--ui-border-default);">
                <thead class="text-left text-xs uppercase tracking-[0.18em]" style="color: var(--ui-text-muted);">
                    <tr><th class="px-4 py-3">Icon</th><th class="px-4 py-3">Category</th><th class="px-4 py-3">Sizes</th><th class="px-4 py-3">Helper Reference</th></tr>
                </thead>
                <tbody class="divide-y" style="border-color: var(--ui-border-default); color: var(--ui-text-secondary);">
                    <tr><td class="px-4 py-3"><span class="inline-flex items-center gap-2"><x-heroicon-o-magnifying-glass class="h-4 w-4" />Search</span></td><td class="px-4 py-3">Action</td><td class="px-4 py-3">16, 20</td><td class="px-4 py-3 font-mono text-xs">x-heroicon-o-magnifying-glass</td></tr>
                    <tr><td class="px-4 py-3"><span class="inline-flex items-center gap-2"><x-heroicon-o-check-circle class="h-4 w-4" />Check circle</span></td><td class="px-4 py-3">Status</td><td class="px-4 py-3">16, 20, 24</td><td class="px-4 py-3 font-mono text-xs">x-heroicon-o-check-circle</td></tr>
                    <tr><td class="px-4 py-3"><span class="inline-flex items-center gap-2"><x-heroicon-o-cog-6-tooth class="h-4 w-4" />Settings</span></td><td class="px-4 py-3">Navigation/action</td><td class="px-4 py-3">20, 24</td><td class="px-4 py-3 font-mono text-xs">x-heroicon-o-cog-6-tooth</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="ui-card" data-icons-example="icon-size-matrix">
        <h2 class="ui-card-title">Icon Sizes And Text Pairing</h2>
        <p class="ui-card-copy mt-2">16px and 20px icons are optimized for dense UI with 14px and 16px text. Use 24px and 32px for larger UI moments.</p>
        <div class="mt-5 grid gap-4 xl:grid-cols-4">
            @foreach ([['16px', 'h-4 w-4', 'Pairs with 14px text'], ['20px', 'h-5 w-5', 'Pairs with 16px text'], ['24px', 'h-6 w-6', 'Larger control or panel'], ['32px', 'h-8 w-8', 'Large visual anchor']] as [$label, $class, $copy])
                <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                    <x-heroicon-o-bell class="{{ $class }}" style="color: var(--ui-text-secondary);" />
                    <p class="mt-3 text-sm font-semibold">{{ $label }}</p>
                    <p class="mt-1 text-xs" style="color: var(--ui-text-muted);">{{ $copy }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-icons-example="icon-with-text">
        <h2 class="ui-card-title">Icon With Text</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-5">
            <button class="ui-button ui-button-neutral justify-center" type="button"><x-heroicon-o-arrow-down-tray class="h-4 w-4" />Leading icon</button>
            <button class="ui-button ui-button-neutral justify-center" type="button">Trailing icon<x-heroicon-o-chevron-right class="h-4 w-4" /></button>
            <a href="#" class="ui-link inline-flex min-h-11 items-center justify-center gap-2"><x-heroicon-o-arrow-top-right-on-square class="h-4 w-4" />Inline link</a>
            <button class="ui-button ui-button-primary justify-center" type="button"><x-heroicon-o-plus class="h-4 w-4" />Button</button>
            <div class="inline-flex min-h-11 items-center justify-center gap-2 rounded-lg border px-3 text-sm" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);"><x-heroicon-o-ellipsis-horizontal class="h-4 w-4" />Menu item</div>
        </div>
    </section>

    <section class="ui-card" data-icons-example="icon-only-controls">
        <h2 class="ui-card-title">Icon-Only Controls</h2>
        <div class="mt-5 flex flex-wrap gap-3">
            @foreach (['Default', 'Hover', 'Active', 'Focus', 'Disabled', 'Loading'] as $state)
                <button type="button" @disabled($state === 'Disabled') class="grid h-11 w-11 place-items-center rounded-md border transition" style="border-color: {{ $state === 'Hover' ? 'var(--ui-action-neutral-border-hover)' : 'var(--ui-action-neutral-border)' }}; background: {{ $state === 'Hover' ? 'var(--ui-action-neutral-bg-hover)' : ($state === 'Active' ? 'var(--ui-action-soft-neutral-bg-hover)' : 'var(--ui-action-neutral-bg)') }}; color: {{ $state === 'Disabled' ? 'var(--ui-action-disabled-text)' : 'var(--ui-text-secondary)' }}; {{ $state === 'Focus' ? 'box-shadow: 0 0 0 2px var(--ui-focus-ring, var(--ui-action-primary-border)), 0 0 0 4px var(--ui-surface);' : '' }}" aria-label="{{ $state }} icon control">
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
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated);">
                <p class="ui-status-inline ui-status-inline-success"><x-heroicon-o-check-circle class="h-4 w-4" />Success</p>
                <p class="ui-status-inline ui-status-inline-warning mt-2"><x-heroicon-o-exclamation-triangle class="h-4 w-4" />Warning</p>
                <p class="ui-status-inline ui-status-inline-danger mt-2"><x-heroicon-o-x-circle class="h-4 w-4" />Error</p>
                <p class="ui-status-inline ui-status-inline-info mt-2"><x-heroicon-o-information-circle class="h-4 w-4" />Info / in progress</p>
            </article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-secondary);">
                <x-heroicon-o-sparkles class="h-5 w-5" aria-hidden="true" />
                <p class="mt-3 text-sm">Decorative icon hidden from assistive tech.</p>
            </article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-secondary);">
                <button class="grid h-11 w-11 place-items-center rounded-md border" style="border-color: var(--ui-action-neutral-border); color: var(--ui-text-secondary);" aria-label="Open notifications" type="button"><x-heroicon-o-bell class="h-5 w-5" /></button>
                <p class="mt-3 text-sm">Meaningful icon-only button with accessible name and 44px hit target.</p>
            </article>
        </div>
    </section>
</div>
