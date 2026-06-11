@php
    $accordionItems = [
        [
            'title' => 'Motion ownership review',
            'meta' => 'Component-owned disclosure',
            'body' => 'Accordion motion is owned by the Accordion Component API and reduced by the Motion Element when reduced motion is requested.',
            'open' => true,
        ],
        [
            'title' => 'Deferred expressive motion',
            'meta' => 'Gated capability',
            'body' => 'Expressive motion requires product ownership, accessibility review, reduced-motion fallback, and UI Reference proof before use.',
        ],
    ];

    $menuItems = [
        ['label' => 'Open details', 'shortcut' => 'Enter'],
        ['label' => 'Export report'],
        ['divider' => true],
        ['label' => 'Delete report', 'danger' => true],
    ];
@endphp

<div class="space-y-6" data-motion-proof="installed-api">
    <section class="ui-card" data-motion-example="easing-demos">
        <h2 class="ui-card-title">Productive Motion Examples</h2>
        <p class="ui-card-copy mt-2">Productive motion is the installed default for Login App admin UI. These examples use current app utilities and component APIs.</p>

        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            @foreach ([
                ['Hover/focus transition', 'Element-owned utility', 'transition duration-150 ease-out', 'Button and link state feedback.'],
                ['Disclosure reveal', 'Accordion component', 'component-owned measured panel motion', 'Local content opens without moving focus.'],
                ['Feedback entrance', 'Toast component', 'transition duration-150 ease-out', 'Status appears without blocking interaction.'],
            ] as [$label, $owner, $api, $copy])
                <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                    <span class="ui-status-pill ui-status-pill-info">{{ $owner }}</span>
                    <p class="mt-3 text-sm font-semibold">{{ $label }}</p>
                    <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">{{ $copy }}</p>
                    <code class="ui-code-snippet mt-4 block">{{ $api }}</code>
                </article>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-motion-example="expressive-motion-gate">
        <h2 class="ui-card-title">Expressive Motion Gate</h2>
        <p class="ui-card-copy mt-2">Expressive motion is not installed as a general app API. Do not use expressive timing in feature work until a product-owned workflow approves it.</p>

        <div class="mt-5 grid gap-4 xl:grid-cols-4">
            @foreach ([
                ['Status', 'Gated'],
                ['Required trigger', 'Major workflow or high-attention system moment'],
                ['Required owner', 'Pattern or product workflow owner'],
                ['Fallback', 'Reduced-motion static state with equivalent meaning'],
            ] as [$label, $value])
                <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                    <p class="ui-kicker">{{ $label }}</p>
                    <p class="mt-2 text-sm font-semibold">{{ $value }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-motion-example="component-motion-previews">
        <h2 class="ui-card-title">Component-Owned Motion Proof</h2>
        <p class="ui-card-copy mt-2">Motion is consumed through the owning Component or Pattern API. The Motion Element defines timing and reduced-motion rules; it does not replace component behavior.</p>

        <div class="mt-5 grid gap-5 xl:grid-cols-2">
            <article class="rounded-lg border p-4" data-motion-owner="component-button" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold">Button and link feedback</p>
                        <p class="mt-1 text-sm" style="color: var(--ui-text-secondary);">Component-owned hover, focus-visible, and active state transitions.</p>
                    </div>
                    <span class="ui-status-pill ui-status-pill-success">Component-owned</span>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <x-ui.button semantic="primary" class="transition duration-150 ease-out">Save changes</x-ui.button>
                    <a href="#" class="ui-link transition duration-150 ease-out">View implementation notes</a>
                </div>
            </article>

            <article class="rounded-lg border p-4" data-motion-owner="component-menu" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold">Menu open surface</p>
                        <p class="mt-1 text-sm" style="color: var(--ui-text-secondary);">The current Menu API owns trigger state and rendered menu surface.</p>
                    </div>
                    <span class="ui-status-pill ui-status-pill-info">Component-owned</span>
                </div>
                <x-ui.menu :items="$menuItems" trigger-label="Review actions" size="sm" open />
            </article>

            <article class="rounded-lg border p-4 xl:col-span-2" data-motion-owner="component-accordion" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold">Accordion open and close</p>
                        <p class="mt-1 text-sm" style="color: var(--ui-text-secondary);">Uses the canonical Accordion API, measured panel motion, and reduced-motion override.</p>
                    </div>
                    <span class="ui-status-pill ui-status-pill-success">Component-owned</span>
                </div>
                <x-ui.accordion :items="$accordionItems" id="motion-reference-accordion" />
            </article>
        </div>
    </section>

    <section class="ui-card" data-motion-example="pattern-motion-gates">
        <h2 class="ui-card-title">Pattern-Owned Motion Gates</h2>
        <p class="ui-card-copy mt-2">Larger surface motion is owned by Patterns. Use the current Pattern route before adding overlay, shell, route, or cross-component choreography.</p>

        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            @foreach ([
                ['Modal / overlay entrance', 'Overlays and actions pattern', '/platform/ui-reference/patterns/overlays-feedback'],
                ['App shell panel motion', 'Layout and navigation patterns', '/platform/ui-reference/patterns/layout'],
                ['Route or page choreography', 'Gated Pattern capability', '/platform/ui-reference/patterns/navigation'],
            ] as [$label, $owner, $route])
                <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                    <span class="ui-status-pill ui-status-pill-warning">Pattern gate</span>
                    <p class="mt-3 text-sm font-semibold">{{ $label }}</p>
                    <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">{{ $owner }}</p>
                    <code class="ui-code-snippet mt-4 block">{{ $route }}</code>
                </article>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-motion-example="skeleton-transition">
        <h2 class="ui-card-title">Loading And Skeleton Transition</h2>
        <p class="ui-card-copy mt-2">Loading motion is owned by Loading and Inline loading Components. Reduced-motion users receive static placeholders with the same layout and meaning.</p>

        <div class="mt-5 grid gap-4 xl:grid-cols-2">
            <article class="rounded-lg border p-4" data-motion-state="animated-loading" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated);">
                <p class="text-sm font-semibold" style="color: var(--ui-text-strong);">Default pending state</p>
                <div class="mt-4 space-y-3" aria-hidden="true">
                    <div class="h-3 w-2/3 animate-pulse rounded ui-motion-reducible" style="background: color-mix(in srgb, var(--ui-text-muted) 18%, var(--ui-surface-elevated));"></div>
                    <div class="h-3 w-1/2 animate-pulse rounded ui-motion-reducible" style="background: color-mix(in srgb, var(--ui-text-muted) 18%, var(--ui-surface-elevated));"></div>
                </div>
                <p class="mt-4 text-sm" style="color: var(--ui-text-secondary);">Animation loops only while work is active.</p>
            </article>
            <article class="rounded-lg border p-4" data-motion-state="reduced-loading" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <p class="text-sm font-semibold">Reduced/static fallback</p>
                <div class="mt-4 space-y-3" aria-hidden="true">
                    <div class="h-3 w-2/3 rounded" style="background: color-mix(in srgb, var(--ui-text-muted) 18%, var(--ui-surface-elevated));"></div>
                    <div class="h-3 w-1/2 rounded" style="background: color-mix(in srgb, var(--ui-text-muted) 18%, var(--ui-surface-elevated));"></div>
                </div>
                <p class="mt-4 text-sm" style="color: var(--ui-text-secondary);">Shape, space, and status remain available without movement.</p>
            </article>
        </div>
    </section>

    <section class="ui-card" data-motion-example="reduced-motion-preview">
        <h2 class="ui-card-title">Reduced Motion Mode</h2>
        <p class="ui-card-copy mt-2">Respect `prefers-reduced-motion`. Non-essential transform, width, scale, shimmer, and movement are removed or shortened while visible state remains clear.</p>

        <div class="mt-5 grid gap-4 xl:grid-cols-2">
            <article class="group rounded-lg border p-4" data-motion-state="normal-preview" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <p class="text-sm font-semibold">Default preview</p>
                <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Hover grows the indicator using approved productive timing.</p>
                <div class="mt-4 h-3 w-2/3 rounded transition-all duration-150 ease-out group-hover:w-full" style="background: var(--ui-link-text);"></div>
            </article>
            <article class="rounded-lg border p-4" data-motion-state="reduced-preview" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <p class="text-sm font-semibold">Reduced preview</p>
                <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Static state preserves hierarchy without transform or width motion.</p>
                <div class="mt-4 h-3 w-full rounded" style="background: var(--ui-link-text);"></div>
            </article>
        </div>

        <code class="ui-code-snippet mt-5 block">@media (prefers-reduced-motion: reduce) { .ui-motion-reducible { transition-duration: 0.01ms; animation-duration: 0.01ms; } }</code>
    </section>

    <section class="ui-card" data-motion-example="do-dont-samples">
        <h2 class="ui-card-title">Do And Do Not Motion Samples</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-2">
            <x-ui.inline-alert semantic="success" title="Do: use component-owned productive motion">
                Hover/focus transitions, accordion disclosure, toast feedback, and loading placeholders must preserve meaning without relying on motion alone.
            </x-ui.inline-alert>
            <x-ui.inline-alert semantic="danger" title="Do not: add decorative animation">
                Bounce, decorative spin, shake validation, route fades, and expressive timing are not allowed without a documented owner and reduced-motion fallback.
            </x-ui.inline-alert>
        </div>
    </section>
</div>
