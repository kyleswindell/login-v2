@php
    $neutralRamp = [
        ['Black', '#000000'], ['G100', '#09090b'], ['G90', '#18181b'], ['G80', '#27272a'], ['G70', '#3f3f46'], ['G60', '#52525b'],
        ['G50', '#71717a'], ['G40', '#a1a1aa'], ['G30', '#d4d4d8'], ['G20', '#e4e4e7'], ['G10', '#f4f4f5'], ['White', '#ffffff'],
    ];
    $blueRamp = [
        ['Blue 90', '#082f49'], ['Blue 80', '#075985'], ['Blue 70', '#0369a1'], ['Blue 60', '#0284c7'], ['Blue 50', '#0ea5e9'], ['Blue 40', '#38bdf8'],
        ['Blue 30', '#7dd3fc'], ['Blue 20', '#bae6fd'], ['Blue 10', '#e0f2fe'],
    ];
    $supportRamp = [
        ['Error', 'var(--ui-status-danger-solid-bg)', 'var(--ui-status-solid-text)'],
        ['Warning', 'var(--ui-status-warning-solid-bg)', 'var(--ui-status-solid-text)'],
        ['Success', 'var(--ui-status-success-solid-bg)', 'var(--ui-status-solid-text)'],
        ['Info', 'var(--ui-status-info-solid-bg)', 'var(--ui-status-solid-text)'],
    ];
    $themeLayers = [
        ['White-equivalent', '#ffffff', '#f8fafc', '#ffffff', '#f8fafc', '#0f172a'],
        ['Gray 10-equivalent', '#f8fafc', '#ffffff', '#f8fafc', '#ffffff', '#0f172a'],
        ['Gray 90-equivalent', '#18181b', '#27272a', '#3f3f46', '#52525b', '#f4f4f5'],
        ['Gray 100-equivalent', '#09090b', '#18181b', '#27272a', '#3f3f46', '#fafafa'],
    ];
@endphp

<div class="space-y-6">
    <section class="ui-card" data-color-example="full-palette">
        <h2 class="ui-card-title">Full App Palette</h2>
        <p class="ui-card-copy mt-2">Palette swatches show app-owned values used to resolve semantic tokens. These are not Carbon color tokens.</p>

        <div class="mt-5 space-y-5">
            <div>
                <p class="text-sm font-semibold" style="color: var(--ui-text-strong);">Neutral ramp</p>
                <div class="mt-3 grid grid-cols-2 overflow-hidden rounded-lg border sm:grid-cols-4 lg:grid-cols-6 xl:grid-cols-12" style="border-color: var(--ui-border-default);">
                    @foreach ($neutralRamp as [$label, $value])
                        <div class="min-h-20 p-3 text-xs font-semibold" style="background: {{ $value }}; color: {{ in_array($label, ['G20', 'G10', 'White'], true) ? '#0f172a' : '#f8fafc' }};">
                            {{ $label }}
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                <p class="text-sm font-semibold" style="color: var(--ui-text-strong);">Blue/action ramp</p>
                <div class="mt-3 grid grid-cols-3 overflow-hidden rounded-lg border lg:grid-cols-9" style="border-color: var(--ui-border-default);">
                    @foreach ($blueRamp as [$label, $value])
                        <div class="min-h-20 p-3 text-xs font-semibold" style="background: {{ $value }}; color: {{ in_array($label, ['Blue 20', 'Blue 10'], true) ? '#0f172a' : '#f8fafc' }};">
                            {{ $label }}
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                <p class="text-sm font-semibold" style="color: var(--ui-text-strong);">Support colors</p>
                <div class="mt-3 grid gap-3 sm:grid-cols-4">
                    @foreach ($supportRamp as [$label, $bg, $text])
                        <div class="rounded-lg px-4 py-5 text-sm font-semibold" style="background: {{ $bg }}; color: {{ $text }};">{{ $label }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="ui-card" data-color-example="token-role-groups">
        <h2 class="ui-card-title">Rendered Token Role Groups</h2>
        <p class="ui-card-copy mt-2">These examples use app variables and component classes directly so the page reflects actual light/dark behavior.</p>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <p class="text-sm font-semibold">Text / link / icon</p>
                <p class="mt-3 text-sm" style="color: var(--ui-text-secondary);">Secondary body copy resolves through text tokens.</p>
                <p class="mt-1 text-sm" style="color: var(--ui-text-muted);">Muted copy is visually distinct from disabled text.</p>
                <a href="#" class="ui-link mt-3 inline-flex items-center gap-2"><x-heroicon-o-arrow-top-right-on-square class="h-4 w-4" />Token-backed link</a>
            </article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface); color: var(--ui-text-strong);">
                <p class="text-sm font-semibold">Surface / field / border</p>
                <input class="ui-input mt-3" value="Field token example" aria-label="Field token example">
                <div class="mt-3 rounded-md border p-3 text-sm" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-secondary);">Nested surface</div>
            </article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <p class="text-sm font-semibold">Status / alert / skeleton</p>
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach (['success' => 'Success', 'warning' => 'Warning', 'danger' => 'Error', 'info' => 'Info'] as $tone => $label)
                        <span class="ui-status-pill ui-status-{{ $tone }}">{{ $label }}</span>
                    @endforeach
                </div>
                <div class="mt-4 h-3 w-full animate-pulse rounded" style="background: color-mix(in srgb, var(--ui-text-muted) 22%, var(--ui-surface-elevated));"></div>
            </article>
        </div>
    </section>

    <section class="ui-card" data-color-example="state-token-contract">
        <h2 class="ui-card-title">Interaction State Token Contract</h2>
        <p class="ui-card-copy mt-2">Carbon's one-step selected and two-step active model is used as comparison guidance. Login App maps that logic to explicit role tokens and component classes instead of IBM palette values.</p>
        <div class="mt-5 grid gap-4 lg:grid-cols-2 xl:grid-cols-3">
            @foreach ([
                ['Enabled', 'var(--ui-action-neutral-bg)', 'var(--ui-action-neutral-border)', 'var(--ui-action-neutral-text)', 'Base token value.'],
                ['Hover', 'var(--ui-action-neutral-bg-hover)', 'var(--ui-action-neutral-border-hover)', 'var(--ui-action-neutral-text-hover)', 'One-step emphasis for pointer hover.'],
                ['Active', 'var(--ui-action-primary-bg-hover)', 'var(--ui-action-primary-border-hover)', 'var(--ui-action-primary-text-hover)', 'Two-step press/down emphasis.'],
                ['Selected', 'var(--ui-action-soft-primary-bg)', 'var(--ui-action-soft-primary-border)', 'var(--ui-action-soft-primary-text)', 'Chosen item or option state.'],
                ['Focus', 'var(--ui-surface-elevated)', 'var(--ui-focus-ring, var(--ui-action-primary-border))', 'var(--ui-text-strong)', 'Required keyboard/voice navigation state.'],
                ['Disabled', 'var(--ui-action-disabled-bg)', 'var(--ui-action-disabled-border)', 'var(--ui-action-disabled-text)', 'Unavailable action state.'],
            ] as [$state, $bg, $border, $text, $copy])
                <article class="rounded-lg border p-4" style="background: {{ $bg }}; border-color: {{ $border }}; color: {{ $text }}; {{ $state === 'Focus' ? 'box-shadow: 0 0 0 2px var(--ui-focus-ring, var(--ui-action-primary-border)), 0 0 0 4px var(--ui-surface);' : '' }}">
                    <p class="text-sm font-semibold">{{ $state }}</p>
                    <p class="mt-2 text-xs opacity-80">{{ $copy }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-color-example="theme-layering-model">
        <h2 class="ui-card-title">Light And Dark Layering Model</h2>
        <p class="ui-card-copy mt-2">Light layers alternate between base and low-contrast layers. Dark layers step lighter as depth increases.</p>
        <div class="mt-5 grid gap-4 xl:grid-cols-4">
            @foreach ($themeLayers as [$name, $base, $layer1, $layer2, $layer3, $text])
                <article class="rounded-lg border p-4" style="background: {{ $base }}; color: {{ $text }}; border-color: color-mix(in srgb, {{ $text }} 18%, transparent);">
                    <p class="text-sm font-semibold">{{ $name }}</p>
                    <div class="mt-4 rounded-lg p-3" style="background: {{ $layer1 }};">
                        Layer 1
                        <div class="mt-3 rounded-md p-3" style="background: {{ $layer2 }};">Layer 2</div>
                        <div class="mt-3 rounded-md p-3" style="background: {{ $layer3 }};">Layer 3</div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-color-example="common-app-states">
        <h2 class="ui-card-title">Common App States</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="ui-inline-alert flex items-start gap-3 ui-inline-alert-success">
                <x-heroicon-o-check-circle class="h-5 w-5 shrink-0" />
                <div><p class="font-semibold">Success alert</p><p class="mt-1 text-sm">Alert colors resolve through theme tokens.</p></div>
            </article>
            <article class="ui-inline-alert flex items-start gap-3 ui-inline-alert-warning">
                <x-heroicon-o-exclamation-triangle class="h-5 w-5 shrink-0" />
                <div><p class="font-semibold">Warning alert</p><p class="mt-1 text-sm">Support colors are semantic, not decorative.</p></div>
            </article>
            <article class="ui-inline-alert flex items-start gap-3 ui-inline-alert-danger">
                <x-heroicon-o-x-circle class="h-5 w-5 shrink-0" />
                <div><p class="font-semibold">Error alert</p><p class="mt-1 text-sm">Validation and destructive states share danger roles.</p></div>
            </article>
        </div>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <label class="ui-control-label" for="color-demo-field">Form field</label>
                <input id="color-demo-field" class="ui-input mt-2" value="workspace@example.com">
                <p class="ui-control-error">Required field error uses alert tokens.</p>
            </article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-action-soft-primary-border); background: var(--ui-action-soft-primary-bg); color: var(--ui-action-soft-primary-text);">
                <p class="text-sm font-semibold">Selected table row</p>
                <p class="mt-2 text-sm">Selected state is distinct from hover and focus.</p>
            </article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-action-danger-border); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <button class="ui-button ui-button-danger" type="button"><x-heroicon-o-trash class="h-4 w-4" />Destructive action</button>
            </article>
        </div>
    </section>

    <section class="ui-card" data-color-example="high-contrast-inverse">
        <h2 class="ui-card-title">High-Contrast And Inverse Moments</h2>
        <p class="ui-card-copy mt-2">High contrast belongs to Color because it changes token context. Use it for tooltips, dark shell/header treatment on light pages, or intentional attention moments.</p>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="rounded-lg border p-4" style="background: #ffffff; color: #0f172a; border-color: #cbd5e1;">
                <div class="rounded-md px-4 py-3" style="background: #09090b; color: #fafafa;">Dark shell/header on light page</div>
            </article>
            <article class="rounded-lg border p-4" style="background: #09090b; color: #fafafa; border-color: #3f3f46;">
                <div class="rounded-md px-4 py-3" style="background: #ffffff; color: #0f172a;">Light component on dark background</div>
            </article>
            <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-surface-elevated); color: var(--ui-text-strong);">
                <div class="inline-flex rounded-md px-3 py-2 text-sm font-medium shadow-xl" style="background: var(--ui-text-strong); color: var(--ui-surface);">Inverse tooltip-style surface</div>
            </article>
        </div>
    </section>
</div>
