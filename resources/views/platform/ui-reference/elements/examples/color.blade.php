<div class="space-y-6">
    <section class="ui-card" data-color-example="theme-aware-swatches">
        <h2 class="ui-card-title">Theme-Aware Color Swatches</h2>
        <p class="ui-card-copy mt-2">Login App maps Carbon's White, Gray 10, Gray 90, and Gray 100 concept to app-owned theme layers. These are equivalence examples, not Carbon token adoption.</p>
        <div class="mt-5 grid gap-4 xl:grid-cols-5">
            @foreach ([
                ['App default', 'var(--ui-surface)', 'var(--ui-text-strong)', 'var(--ui-border-default)', 'Current application card/page surface'],
                ['White equivalent', '#ffffff', '#0f172a', '#cbd5e1', 'Light base surface'],
                ['Gray 10 equivalent', '#f8fafc', '#0f172a', '#cbd5e1', 'Light layer or muted surface'],
                ['Gray 90 equivalent', '#18181b', '#f4f4f5', '#3f3f46', 'Dark layer surface'],
                ['Gray 100 equivalent', '#09090b', '#fafafa', '#27272a', 'Dark base surface'],
            ] as [$name, $bg, $text, $border, $note])
                <article class="rounded-lg border p-4" style="background: {{ $bg }}; color: {{ $text }}; border-color: {{ $border }};">
                    <p class="text-sm font-semibold">{{ $name }}</p>
                    <p class="mt-2 text-xs opacity-80">{{ $note }}</p>
                    <div class="mt-4 h-8 rounded border" style="border-color: {{ $border }}; background: color-mix(in srgb, {{ $bg }} 82%, {{ $text }} 18%);"></div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-color-example="rendered-token-examples">
        <h2 class="ui-card-title">Rendered Token Groups</h2>
        <p class="ui-card-copy mt-2">Each group below shows the final UI behavior beside the token role. Do not use token names as the only review artifact.</p>
        <div class="mt-5 grid gap-4 xl:grid-cols-2">
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                <p class="text-sm font-semibold text-white">Text, link, and icon tokens</p>
                <p class="mt-3 text-sm text-slate-100">Strong text: primary content hierarchy.</p>
                <p class="mt-1 text-sm text-slate-400">Secondary and muted copy supports the main content.</p>
                <a href="#" class="ui-link mt-3 inline-flex items-center gap-2"><x-heroicon-o-arrow-top-right-on-square class="h-4 w-4" />Link color is an action role</a>
            </article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                <p class="text-sm font-semibold text-white">Border, surface, and shadow tokens</p>
                <div class="mt-3 rounded-lg border border-slate-700 bg-slate-900 p-4 shadow-xl">
                    <p class="text-sm text-slate-200">Elevated nested surface with border and shadow.</p>
                </div>
            </article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                <p class="text-sm font-semibold text-white">Action and focus tokens</p>
                <div class="mt-3 flex flex-wrap gap-3">
                    <button type="button" class="ui-button ui-button-primary">Primary action</button>
                    <button type="button" class="ui-button ui-button-outline-primary ring-2 ring-sky-400 ring-offset-2 ring-offset-slate-950">Focused action</button>
                    <button type="button" class="ui-button ui-button-neutral" disabled>Disabled</button>
                </div>
            </article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                <p class="text-sm font-semibold text-white">Support, status, and skeleton tokens</p>
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach (['success' => 'Success', 'warning' => 'Warning', 'danger' => 'Error', 'info' => 'Info'] as $tone => $label)
                        <span class="ui-status ui-status-{{ $tone }}">{{ $label }}</span>
                    @endforeach
                </div>
                <div class="mt-4 h-3 w-full animate-pulse rounded bg-slate-800"></div>
            </article>
        </div>
    </section>

    <section class="ui-card" data-color-example="stacked-surface-levels">
        <h2 class="ui-card-title">Layering Model Demo</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-2">
            <article class="rounded-lg border border-slate-300 bg-white p-4 text-slate-950">
                <p class="text-sm font-semibold">Light stack: base -> Gray 10-style layer -> nested white element</p>
                <div class="mt-4 rounded-lg border border-slate-200 bg-slate-50 p-4">
                    <p class="text-sm">First layer</p>
                    <div class="mt-3 rounded-md border border-slate-200 bg-white p-3 shadow-sm">Nested elevated/default element</div>
                </div>
            </article>
            <article class="rounded-lg border border-slate-700 bg-slate-950 p-4 text-slate-100">
                <p class="text-sm font-semibold">Dark stack: Gray 100-style base -> Gray 90-style layer -> nested dark element</p>
                <div class="mt-4 rounded-lg border border-slate-700 bg-slate-900 p-4">
                    <p class="text-sm">First dark layer</p>
                    <div class="mt-3 rounded-md border border-slate-700 bg-slate-950 p-3 shadow-xl">Nested dark elevated element</div>
                </div>
            </article>
        </div>
    </section>

    <section class="ui-card" data-color-example="hover-delta">
        <h2 class="ui-card-title">Interaction State Examples</h2>
        <p class="ui-card-copy mt-2">Hover and active colors are state tokens. Existing components apply them automatically through their component classes; custom inline themed regions must choose the appropriate hover/focus state explicitly.</p>
        <div class="mt-5 grid gap-4 xl:grid-cols-6">
            @foreach (['Enabled', 'Hover', 'Active', 'Selected', 'Focus', 'Disabled'] as $state)
                <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4 text-sm text-slate-300">
                    <p class="font-semibold text-white">{{ $state }}</p>
                    <button type="button" @disabled($state === 'Disabled') class="mt-3 w-full rounded-md border px-3 py-2 text-sm {{ $state === 'Selected' ? 'border-sky-400 bg-sky-500/20 text-sky-100' : 'border-slate-700 bg-slate-900 text-slate-200' }} {{ $state === 'Focus' ? 'ring-2 ring-sky-400 ring-offset-2 ring-offset-slate-950' : '' }} {{ $state === 'Hover' ? 'bg-slate-800' : '' }} {{ $state === 'Active' ? 'bg-slate-700' : '' }}">State</button>
                </div>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-color-example="common-app-examples">
        <h2 class="ui-card-title">Common App Examples</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                <label class="text-sm font-semibold text-slate-100" for="color-demo-field">Form field</label>
                <input id="color-demo-field" class="ui-input mt-2" value="workspace@example.com">
                <p class="mt-2 text-sm text-rose-200">Required field error uses semantic color.</p>
            </article>
            <article class="rounded-lg border border-sky-500/60 bg-sky-500/10 p-4">
                <p class="text-sm font-semibold text-sky-100">Selected table row</p>
                <p class="mt-2 text-sm text-sky-200">Selected state must remain distinct from hover and focus.</p>
            </article>
            <article class="rounded-lg border border-emerald-500/40 bg-emerald-500/10 p-4">
                <p class="flex items-center gap-2 text-sm font-semibold text-emerald-100"><x-heroicon-o-check-circle class="h-4 w-4" />Status tag</p>
                <p class="mt-2 text-sm text-emerald-200">Status color is semantic, not decorative.</p>
            </article>
        </div>
    </section>

    <section class="ui-card" data-color-example="inverse-moment">
        <h2 class="ui-card-title">High-Contrast And Inverse Moments</h2>
        <p class="ui-card-copy mt-2">Use high contrast deliberately to focus attention. Inverse contexts are appropriate for tooltips, dark shell/header treatment on a light page, or a dark panel inside a light workflow.</p>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="rounded-lg border border-slate-300 bg-white p-4 text-slate-950">
                <div class="rounded-md bg-slate-950 p-4 text-slate-100">Light component area with dark shell/header treatment.</div>
            </article>
            <article class="rounded-lg border border-slate-700 bg-slate-950 p-4 text-slate-100">
                <div class="rounded-md bg-white p-4 text-slate-950">Light component on dark background.</div>
            </article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                <div class="inline-flex rounded-md bg-slate-100 px-3 py-2 text-sm font-medium text-slate-950 shadow-xl">Inverse tooltip-style surface</div>
            </article>
        </div>
    </section>
</div>
