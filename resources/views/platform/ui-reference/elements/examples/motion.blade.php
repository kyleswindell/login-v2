<div class="space-y-6">
    <section class="ui-card" data-motion-example="easing-demos">
        <h2 class="ui-card-title">Motion Token And Easing Demos</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            @foreach ([
                ['Productive standard', 'transition-[width] duration-150 ease-out'],
                ['Productive entrance', 'transition-[width] duration-200 ease-out'],
                ['Productive exit', 'transition-[width] duration-150 ease-in'],
                ['Expressive standard', 'transition-[width] duration-300 ease-out'],
                ['Expressive entrance', 'transition-[width] duration-500 ease-out'],
                ['Expressive exit', 'transition-[width] duration-300 ease-in'],
            ] as [$label, $classes])
                <article class="group rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                    <p class="text-sm font-semibold">{{ $label }}</p>
                    <div class="mt-4 h-2 rounded" style="background: color-mix(in srgb, var(--ui-text-muted) 18%, var(--ui-surface-elevated));">
                        <div class="h-2 w-1/3 rounded {{ $classes }} group-hover:w-full" style="background: var(--ui-link-text);"></div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-motion-example="component-motion-previews">
        <h2 class="ui-card-title">Component Motion Previews</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="group rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <p class="text-sm font-semibold">Dropdown open</p>
                <button class="ui-button ui-button-neutral mt-3" type="button">Open menu</button>
                <div class="mt-3 origin-top rounded-md border p-3 text-sm opacity-80 transition duration-150 ease-out group-hover:translate-y-0 group-hover:opacity-100" style="border-color: var(--ui-border-default); background: var(--ui-surface); color: var(--ui-text-secondary); transform: translateY(-0.25rem);">Menu content appears near trigger.</div>
            </article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <p class="text-sm font-semibold">Modal enter / exit</p>
                <div class="mt-3 rounded-lg border p-3 shadow-xl transition duration-200 ease-out" style="border-color: var(--ui-border-default); background: var(--ui-surface); color: var(--ui-text-secondary);">Centered decision panel with short entrance motion.</div>
            </article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-alert-success-border); background: var(--ui-alert-success-bg); color: var(--ui-alert-success-text);">
                <p class="text-sm font-semibold">Toast notification</p>
                <div class="mt-3 rounded-md border px-3 py-2 text-sm transition duration-150 ease-out" style="border-color: var(--ui-alert-success-border); background: color-mix(in srgb, var(--ui-alert-success-bg) 80%, var(--ui-surface-elevated));">Slides/fades in without stealing focus.</div>
            </article>
            <details class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <summary class="cursor-pointer text-sm font-semibold">Accordion / collapse</summary>
                <p class="mt-3 text-sm" style="color: var(--ui-text-secondary);">Disclosure expands local content and preserves source order.</p>
            </details>
            <article class="overflow-hidden rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <p class="text-sm font-semibold">Side panel</p>
                <div class="mt-3 ml-auto w-2/3 rounded-md border p-3 text-sm transition duration-300 ease-out" style="border-color: var(--ui-border-default); background: var(--ui-surface); color: var(--ui-text-secondary);">Panel enters from edge.</div>
            </article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <p class="text-sm font-semibold">Table sort / reorder</p>
                <div class="mt-3 space-y-2">
                    <div class="rounded border px-3 py-2 text-sm transition hover:translate-x-1" style="border-color: var(--ui-border-default); color: var(--ui-text-secondary);">Row A</div>
                    <div class="rounded border px-3 py-2 text-sm transition hover:translate-x-1" style="border-color: var(--ui-border-default); color: var(--ui-text-secondary);">Row B</div>
                </div>
            </article>
        </div>
    </section>

    <section class="ui-card" data-motion-example="skeleton-transition">
        <h2 class="ui-card-title">Loading / Skeleton Transition</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-2">
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated);">
                <p class="text-sm font-semibold" style="color: var(--ui-text-strong);">Pending state</p>
                <div class="mt-4 space-y-3">
                    <div class="h-3 w-2/3 animate-pulse rounded" style="background: color-mix(in srgb, var(--ui-text-muted) 18%, var(--ui-surface-elevated));"></div>
                    <div class="h-3 w-1/2 animate-pulse rounded" style="background: color-mix(in srgb, var(--ui-text-muted) 18%, var(--ui-surface-elevated));"></div>
                </div>
            </article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <p class="text-sm font-semibold">Resolved state</p>
                <p class="mt-4 text-sm" style="color: var(--ui-text-secondary);">Content replaces skeleton without layout jump.</p>
            </article>
        </div>
    </section>

    <section class="ui-card" data-motion-example="reduced-motion-preview">
        <h2 class="ui-card-title">Reduced Motion Mode</h2>
        <p class="ui-card-copy mt-2">Respect `prefers-reduced-motion`. Non-essential movement should be removed, shortened, or replaced while preserving visible state and feedback.</p>
        <div class="mt-5 grid gap-4 xl:grid-cols-2">
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);"><p class="text-sm font-semibold">Normal preview</p><div class="mt-4 h-3 w-2/3 rounded transition-all duration-300 hover:w-full" style="background: var(--ui-link-text);"></div></article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);"><p class="text-sm font-semibold">Reduced preview</p><div class="mt-4 h-3 w-2/3 rounded" style="background: var(--ui-link-text);"></div></article>
        </div>
    </section>

    <section class="ui-card" data-motion-example="do-dont-samples">
        <h2 class="ui-card-title">Do / Do Not Motion Samples</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-5">
            <article class="ui-inline-alert flex items-start gap-3 ui-inline-alert-success"><x-heroicon-o-check-circle class="h-5 w-5 shrink-0" /><span>Do: subtle entrance</span></article>
            <article class="ui-inline-alert flex items-start gap-3 ui-inline-alert-success"><x-heroicon-o-check-circle class="h-5 w-5 shrink-0" /><span>Do: clear exit</span></article>
            <article class="ui-inline-alert flex items-start gap-3 ui-inline-alert-danger"><x-heroicon-o-x-circle class="h-5 w-5 shrink-0" /><span>Do not: bounce</span></article>
            <article class="ui-inline-alert flex items-start gap-3 ui-inline-alert-danger"><x-heroicon-o-x-circle class="h-5 w-5 shrink-0" /><span>Do not: decorative spin</span></article>
            <article class="ui-inline-alert flex items-start gap-3 ui-inline-alert-danger"><x-heroicon-o-x-circle class="h-5 w-5 shrink-0" /><span>Do not: delay usable content</span></article>
        </div>
    </section>
</div>
