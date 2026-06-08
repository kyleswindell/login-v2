@php
    $typeScale = [
        ['0.75rem', 12],
        ['0.875rem', 14],
        ['1rem', 16],
        ['1.125rem', 18],
        ['1.25rem', 20],
        ['1.5rem', 24],
        ['1.75rem', 28],
        ['2rem', 32],
        ['2.25rem', 36],
        ['2.625rem', 42],
        ['3rem', 48],
        ['3.375rem', 54],
        ['3.75rem', 60],
        ['4.25rem', 68],
        ['4.75rem', 76],
        ['5.25rem', 84],
        ['5.75rem', 92],
    ];
@endphp

<div class="space-y-6">
    <section class="ui-card" data-typography-example="font-specimens">
        <h2 class="ui-card-title">Font Family Specimens</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <p class="text-sm font-semibold">Sans</p>
                <p class="mt-3 text-xl">Productive admin interface text</p>
            </article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <p class="text-sm font-semibold">Mono</p>
                <code class="mt-3 block text-sm" style="color: var(--ui-text-secondary);">--ui-text-strong</code>
            </article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-secondary);">
                <p class="text-sm font-semibold" style="color: var(--ui-text-strong);">Serif</p>
                <p class="mt-3 text-sm">Not currently used in product UI.</p>
            </article>
        </div>
    </section>

    <section class="ui-card" data-typography-example="type-scale">
        <h2 class="ui-card-title">Type Scale</h2>
        <p class="ui-card-copy mt-2">The reference scale runs from 12px through 92px. Product UI should still use assigned type roles rather than choosing sizes by eye.</p>
        <div class="mt-5 space-y-3">
            @foreach ($typeScale as [$rem, $size])
                <div class="grid gap-3 rounded-lg border p-4 lg:grid-cols-[8rem_minmax(0,1fr)] lg:items-center" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated);">
                    <div class="font-mono text-xs" style="color: var(--ui-text-muted);">
                        <p>{{ $rem }}</p>
                        <p>{{ $size }}px</p>
                    </div>
                    <p class="leading-none" style="font-size: {{ $size }}px; color: var(--ui-text-strong);">Aa</p>
                </div>
            @endforeach
        </div>
        <p class="mt-4 font-mono text-xs" style="color: var(--ui-text-muted);">Scale formula reference: Xn = Xn-1 + {INT[(n-2)/4] + 1} * 2</p>
    </section>

    <section class="ui-card" data-typography-example="type-role-examples">
        <h2 class="ui-card-title">Type Role Examples</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-2">
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated);">
                <h1 class="ui-page-header-title">Page title</h1>
                <h2 class="ui-card-title mt-4">Section heading</h2>
                <h3 class="mt-3 text-base font-semibold" style="color: var(--ui-text-strong);">Subsection heading</h3>
                <p class="mt-3 text-sm" style="color: var(--ui-text-secondary);">Body text uses neutral content color.</p>
                <p class="mt-1 text-xs" style="color: var(--ui-text-muted);">Caption text</p>
            </article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated);">
                <label class="ui-control-label" for="type-field">Label</label>
                <input id="type-field" class="ui-input mt-2" value="Typography field">
                <p class="ui-control-copy">Helper text</p>
                <p class="ui-control-error">Error text</p>
                <code class="mt-3 block rounded border p-3 text-sm" style="border-color: var(--ui-border-default); background: var(--ui-surface); color: var(--ui-text-secondary);">Code / mono text</code>
            </article>
        </div>
    </section>

    <section class="ui-card" data-typography-example="productive-content-examples">
        <h2 class="ui-card-title">Productive Content Examples</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <p class="text-lg font-semibold">Settings form</p>
                <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Compact hierarchy for repeated admin tasks.</p>
                <button class="ui-button ui-button-primary mt-4" type="button">Save settings</button>
            </article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <p class="text-xs font-semibold uppercase tracking-[0.18em]" style="color: var(--ui-text-muted);">Table header</p>
                <p class="mt-3 text-sm" style="color: var(--ui-text-secondary);">Table cell</p>
                <a href="#" class="ui-link mt-3 inline-flex">Link text</a>
            </article>
            <article class="ui-inline-alert flex items-start gap-3 ui-inline-alert-info">
                <x-heroicon-o-information-circle class="h-5 w-5 shrink-0" />
                <div><p class="font-semibold">Notification</p><p class="mt-1 text-sm">Inline validation and feedback use semantic copy but token-backed structure.</p></div>
            </article>
        </div>
    </section>

    <section class="ui-card" data-typography-example="weight-examples">
        <h2 class="ui-card-title">Weights And Italic</h2>
        <p class="ui-card-copy mt-2">Use semibold for headings and short emphasis. Do not use semibold for long body copy. Italic is limited to short emphasis such as terms, titles, captions, or technical distinctions.</p>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <p class="font-light">Light 300</p>
                <p class="mt-2 font-normal">Regular 400</p>
                <p class="mt-2 font-semibold">Semibold 600</p>
            </article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <p class="font-light italic">Light italic 300</p>
                <p class="mt-2 font-normal italic">Regular italic 400</p>
                <p class="mt-2 font-semibold italic">Semibold italic 600</p>
            </article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-secondary);">
                <p class="font-semibold" style="color: var(--ui-text-strong);">Hierarchy note</p>
                <p class="mt-2 text-sm">A larger regular heading can outrank smaller semibold text. Size, weight, and role must be balanced.</p>
            </article>
        </div>
    </section>

    <section class="ui-card" data-typography-example="type-color-examples">
        <h2 class="ui-card-title">Type Color</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated);">
                <p style="color: var(--ui-text-strong);">Neutral color for text</p>
                <p class="mt-2" style="color: var(--ui-text-secondary);">Secondary text has clear hierarchy.</p>
                <p class="mt-2" style="color: var(--ui-action-disabled-text);">Placeholder / disabled text is lower emphasis.</p>
            </article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-alert-warning-border); background: var(--ui-alert-warning-bg); color: var(--ui-alert-warning-text);">
                <p class="font-semibold">Color is not decoration</p>
                <p class="mt-2 text-sm">Use colored text only for semantic links, actions, warnings, alerts, and code highlights.</p>
            </article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated);">
                <a href="#" class="ui-link inline-flex items-center gap-2"><x-heroicon-o-arrow-down-tray class="h-4 w-4" />Link with icon</a>
                <p class="ui-status-inline ui-status-inline-danger mt-3"><x-heroicon-o-x-circle class="h-4 w-4" />Oops, something went wrong.</p>
                <code class="mt-3 block rounded px-2 py-1 text-sm" style="background: var(--ui-surface); color: var(--ui-text-secondary);">Code snippet with highlighted token</code>
            </article>
        </div>
    </section>
</div>
