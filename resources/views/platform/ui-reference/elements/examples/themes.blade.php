@php
    $themeContexts = [
        ['App default', 'var(--ui-surface)', 'var(--ui-surface-elevated)', 'var(--ui-text-strong)', 'var(--ui-text-secondary)', 'var(--ui-border-default)', 'var(--ui-link-text)', 'Current resolved app theme'],
        ['White-equivalent', '#ffffff', '#ffffff', '#0f172a', '#334155', '#cbd5e1', '#0369a1', 'Light default base'],
        ['Gray 10-equivalent', '#f8fafc', '#ffffff', '#0f172a', '#334155', '#cbd5e1', '#0369a1', 'Light muted base'],
        ['Gray 90-equivalent', '#18181b', '#27272a', '#f4f4f5', '#d4d4d8', '#52525b', '#7dd3fc', 'Dark layer base'],
        ['Gray 100-equivalent', '#09090b', '#18181b', '#fafafa', '#e4e4e7', '#3f3f46', '#bae6fd', 'Dark default base'],
    ];
@endphp

<div class="space-y-6">
    <section class="ui-card" data-theme-example="theme-terms">
        <h2 class="ui-card-title">Theming Basics</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-4">
            @foreach ([
                ['Theme', 'A collection of visual attributes assigned to tokens.'],
                ['Token', 'A role-based identifier that stays stable across themes.'],
                ['Role', 'The systematic use of a token; roles do not change by theme.'],
                ['Value', 'The actual color, spacing, type, or global value assigned to a token.'],
            ] as [$term, $definition])
                <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                    <p class="text-sm font-semibold">{{ $term }}</p>
                    <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">{{ $definition }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-theme-example="theme-matrix">
        <h2 class="ui-card-title">Applied Theme Matrix</h2>
        <p class="ui-card-copy mt-2">The same token roles appear in every theme context. Only the values change.</p>
        <div class="mt-5 grid gap-4 xl:grid-cols-5">
            @foreach ($themeContexts as [$name, $page, $layer, $text, $secondary, $border, $link, $note])
                <article class="rounded-lg border p-4" style="background: {{ $page }}; color: {{ $text }}; border-color: {{ $border }};">
                    <p class="text-sm font-semibold">{{ $name }}</p>
                    <p class="mt-2 text-xs" style="color: {{ $secondary }};">{{ $note }}</p>
                    <div class="mt-4 rounded-md border p-3" style="background: {{ $layer }}; border-color: {{ $border }};">
                        <p class="text-xs font-semibold">Layer</p>
                        <a href="#" class="mt-2 inline-flex text-xs font-semibold" style="color: {{ $link }};">Link role</a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-theme-example="token-role-value-matrix">
        <h2 class="ui-card-title">Token Role And Value Matrix</h2>
        <div class="mt-5 overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated);">
            <table class="w-full min-w-[820px] divide-y text-sm" style="border-color: var(--ui-border-default);">
                <thead class="text-left text-xs uppercase tracking-[0.18em]" style="color: var(--ui-text-muted);">
                    <tr><th class="px-4 py-3">Key</th><th class="px-4 py-3">Token</th><th class="px-4 py-3">Role</th><th class="px-4 py-3">Light value</th><th class="px-4 py-3">Dark value</th></tr>
                </thead>
                <tbody class="divide-y" style="border-color: var(--ui-border-default); color: var(--ui-text-secondary);">
                    <tr><td class="px-4 py-3">1</td><td class="px-4 py-3 font-mono text-xs">--ui-text-secondary</td><td class="px-4 py-3">Label/body support</td><td class="px-4 py-3">Slate 700</td><td class="px-4 py-3">Zinc 300</td></tr>
                    <tr><td class="px-4 py-3">2</td><td class="px-4 py-3 font-mono text-xs">--ui-text-strong</td><td class="px-4 py-3">Primary text</td><td class="px-4 py-3">Slate 900</td><td class="px-4 py-3">Zinc 50</td></tr>
                    <tr><td class="px-4 py-3">3</td><td class="px-4 py-3 font-mono text-xs">--ui-border-default</td><td class="px-4 py-3">Boundary</td><td class="px-4 py-3">Slate 300</td><td class="px-4 py-3">Zinc 700</td></tr>
                    <tr><td class="px-4 py-3">4</td><td class="px-4 py-3 font-mono text-xs">--ui-link-text</td><td class="px-4 py-3">Links/actions</td><td class="px-4 py-3">Sky 700</td><td class="px-4 py-3">Sky 200</td></tr>
                    <tr><td class="px-4 py-3">5</td><td class="px-4 py-3 font-mono text-xs">--ui-surface-elevated</td><td class="px-4 py-3">Field/layer</td><td class="px-4 py-3">White</td><td class="px-4 py-3">Zinc 900</td></tr>
                    <tr><td class="px-4 py-3">6</td><td class="px-4 py-3 font-mono text-xs">--ui-surface</td><td class="px-4 py-3">Page/card base</td><td class="px-4 py-3">White</td><td class="px-4 py-3">Zinc 950</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="ui-card" data-theme-example="component-preview-matrix">
        <h2 class="ui-card-title">Component Preview Matrix</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-4">
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <p class="text-sm font-semibold">Button + icon button</p>
                <div class="mt-3 flex items-center gap-2">
                    <button class="ui-button ui-button-primary" type="button">Save</button>
                    <button class="grid h-11 w-11 place-items-center rounded-md border" style="border-color: var(--ui-action-neutral-border); color: var(--ui-text-secondary);" type="button" aria-label="Open settings"><x-heroicon-o-cog-6-tooth class="h-5 w-5" /></button>
                </div>
            </article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <label class="ui-control-label" for="theme-field">Form field</label>
                <input id="theme-field" class="ui-input mt-2" value="Tenant domain">
            </article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <p class="text-sm font-semibold">Table row</p>
                <div class="mt-3 rounded-md border" style="border-color: var(--ui-border-default);">
                    <div class="grid grid-cols-2 border-b px-3 py-2 text-xs uppercase tracking-[0.16em]" style="border-color: var(--ui-border-default); color: var(--ui-text-muted);"><span>Name</span><span>Status</span></div>
                    <div class="grid grid-cols-2 px-3 py-2 text-sm" style="background: var(--ui-action-soft-primary-bg); color: var(--ui-action-soft-primary-text);"><span>Para Solutions</span><span>Selected</span></div>
                </div>
            </article>
            <article class="ui-inline-alert flex items-start gap-3 ui-inline-alert-success">
                <x-heroicon-o-check-circle class="h-5 w-5 shrink-0" />
                <div><p class="font-semibold">Notification</p><p class="mt-1 text-sm">Workspace saved.</p></div>
            </article>
        </div>
    </section>

    <section class="ui-card" data-theme-example="token-categories">
        <h2 class="ui-card-title">Token Categories</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-4">
            @foreach ([
                ['Color', 'Surface, text, border, icon, link, action, support, focus, and loading roles.'],
                ['Spacing', 'Component padding, layout gaps, density, and relationship tokens.'],
                ['Typography', 'Type roles, scale, weight, line height, code, and text color roles.'],
                ['Global/component-specific', 'Border radius, shadow, component state, and shell-specific variables.'],
            ] as [$category, $copy])
                <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                    <p class="text-sm font-semibold">{{ $category }}</p>
                    <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">{{ $copy }}</p>
                </article>
            @endforeach
        </div>
        <p class="ui-card-copy mt-5">High-contrast and inverse examples are owned by the <a class="ui-link" href="{{ route('platform.ui-reference.elements.show', ['element' => 'color']) }}">Color foundation page</a>.</p>
    </section>
</div>
