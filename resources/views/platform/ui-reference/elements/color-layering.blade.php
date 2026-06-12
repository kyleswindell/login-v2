<x-layouts.app :title="'UI Reference - Background Layering'">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'elements.color.layering'])
    </x-slot:sidebar>

    @php
        $layerRows = [
            ['Page background', '--ui-background', 'The app canvas behind content regions.', 'Application shell body and large empty regions.'],
            ['Layer 01', '--ui-layer-01', 'First content surface above the page.', 'Cards, panels, table shells, and primary component containers.'],
            ['Layer 02', '--ui-layer-02', 'Nested surface above Layer 01.', 'Example wells, nested cards, code snippet bodies, dropdowns, and menus.'],
            ['Layer 03', '--ui-layer-03', 'Fourth visible surface in a nested stack.', 'Deep contained regions when a component or pattern requires four visible layers.'],
            ['Layer accent 01', '--ui-layer-accent-01', 'Optional neutral accent strip on a layer.', 'Table headers, code snippet headers, and grouped section headers only when the owning API requires a persistent band.'],
            ['Inverse layer', '--ui-layer-inverse', 'High contrast layer for inverted affordances.', 'Tooltips and deliberate inverse moments only.'],
        ];

        $layerStacks = [
            ['Page to contained region', 'Generic page/card nesting', [
                ['Page background', '--ui-background', 'Light: G10'],
                ['Layer 01 card', '--ui-layer-01', 'Light: White'],
                ['Layer 02 nested region', '--ui-layer-02', 'Light: G10'],
                ['Layer 03 deepest region', '--ui-layer-03', 'Light: White'],
            ]],
            ['Component example region', 'UI Reference live-example nesting', [
                ['Page background', '--ui-background', 'Light: G10'],
                ['Layer 01 example card', '--ui-layer-01', 'Light: White'],
                ['Layer 02 component well', '--ui-layer-02', 'Light: G10'],
                ['Layer 03 contained component', '--ui-layer-03', 'Light: White'],
            ]],
            ['Documentation container', 'Documentation/code nesting', [
                ['Page background', '--ui-background', 'Light: G10'],
                ['Layer 01 documentation card', '--ui-layer-01', 'Light: White'],
                ['Layer 02 code shell', '--ui-layer-02', 'Light: G10'],
                ['Layer 03 code body', '--ui-layer-03', 'Light: White'],
            ]],
        ];
    @endphp

    <section class="flex min-w-0 flex-1 flex-col gap-6" data-ui-reference-foundation-element="color" data-color-background-layering-page>
        <div>
            <p class="ui-kicker">Foundation Element - Color</p>
            <h1 class="ui-page-header-title">Background Layering</h1>
            <p class="ui-page-header-copy">Canonical surface layering examples for cards, nested regions, headers, footers, and code/documentation containers.</p>
        </div>

        <section class="ui-card" data-background-layering-section="model">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <h2 class="ui-card-title">Layer Model</h2>
                    <p class="ui-card-copy mt-2">Layer tokens communicate hierarchy. They must not be chosen by visual preference or locally alternated until a component happens to look different.</p>
                </div>
                <a wire:navigate href="{{ route('platform.ui-reference.elements.color.tokens') }}" class="ui-link">Open token palette</a>
            </div>

            <div class="mt-5 overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-subtle-01); background: var(--ui-layer-01);">
                <table class="w-full min-w-[920px] table-fixed divide-y" style="border-color: var(--ui-border-subtle-01);">
                    <colgroup>
                        <col class="w-[13rem]">
                        <col class="w-[14rem]">
                        <col>
                        <col>
                    </colgroup>
                    <thead style="background: var(--ui-layer-accent-01);">
                        <tr class="text-left text-xs uppercase" style="color: var(--ui-text-helper);">
                            <th class="px-4 py-3">Role</th>
                            <th class="px-4 py-3">Token</th>
                            <th class="px-4 py-3">Meaning</th>
                            <th class="px-4 py-3">Use</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y text-sm" style="border-color: var(--ui-border-subtle-01); color: var(--ui-text-secondary);">
                        @foreach ($layerRows as [$role, $token, $meaning, $use])
                            <tr data-background-layering-token="{{ $token }}">
                                <td class="px-4 py-3 font-semibold" style="color: var(--ui-text-primary);">{{ $role }}</td>
                                <td class="px-4 py-3 font-mono text-xs" style="color: var(--ui-text-primary);">{{ $token }}</td>
                                <td class="px-4 py-3">{{ $meaning }}</td>
                                <td class="px-4 py-3">{{ $use }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section class="ui-card" data-background-layering-section="stack-sequence">
            <h2 class="ui-card-title">Stack Sequence</h2>
            <p class="ui-card-copy mt-2">Use the same sequence for every nested surface: page background, Layer 01, Layer 02, then Layer 03. In the light theme this alternates G10, White, G10, White.</p>

            <div class="mt-5 grid gap-4 xl:grid-cols-3">
                @foreach ($layerStacks as [$label, $summary, $layers])
                    @php
                        [$base, $first, $second, $third] = $layers;
                    @endphp
                    <article class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background: var({{ $base[1] }});" data-background-layer-stack="{{ Str::slug($label) }}" data-background-layer-depth="4" data-background-layer-stack-sequence="background-layer-01-layer-02-layer-03">
                        <p class="text-sm font-semibold" style="color: var(--ui-text-primary);">{{ $label }}</p>
                        <p class="mt-1 text-xs" style="color: var(--ui-text-secondary);">{{ $summary }}</p>
                        <p class="mt-1 font-mono text-xs" style="color: var(--ui-text-helper);">{{ $base[1] }}</p>
                        <p class="mt-1 text-xs" style="color: var(--ui-text-helper);">{{ $base[2] }}</p>
                        <div class="mt-4 rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background: var({{ $first[1] }});">
                            <p class="text-xs font-semibold" style="color: var(--ui-text-primary);">{{ $first[0] }}</p>
                            <p class="mt-1 font-mono text-xs" style="color: var(--ui-text-secondary);">{{ $first[1] }}</p>
                            <p class="mt-1 text-xs" style="color: var(--ui-text-helper);">{{ $first[2] }}</p>
                            <div class="mt-4 rounded border p-4" style="border-color: var(--ui-border-subtle-01); background: var({{ $second[1] }});">
                                <p class="text-xs font-semibold" style="color: var(--ui-text-primary);">{{ $second[0] }}</p>
                                <p class="mt-1 font-mono text-xs" style="color: var(--ui-text-secondary);">{{ $second[1] }}</p>
                                <p class="mt-1 text-xs" style="color: var(--ui-text-helper);">{{ $second[2] }}</p>
                                <div class="mt-4 rounded p-4" style="background: var({{ $third[1] }});">
                                    <p class="text-xs font-semibold" style="color: var(--ui-text-primary);">{{ $third[0] }}</p>
                                    <p class="mt-1 font-mono text-xs" style="color: var(--ui-text-secondary);">{{ $third[1] }}</p>
                                    <p class="mt-1 text-xs" style="color: var(--ui-text-helper);">{{ $third[2] }}</p>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="ui-card" data-background-layering-section="card-header-footer">
            <h2 class="ui-card-title">Cards With Header And Footer</h2>
            <p class="ui-card-copy mt-2">Headers and footers are part of the same card. Header, body, and footer share the same background layer by default, and card header/footer borders are opt-in separators rather than default structure.</p>

            <div class="mt-5 grid gap-5 xl:grid-cols-2">
                <article class="overflow-hidden rounded-lg border" style="border-color: var(--ui-border-subtle-01); background: var(--ui-layer-01);" data-background-layer-example="card-with-header-footer">
                    <header class="px-4 py-3" style="background: var(--ui-layer-01);">
                        <p class="text-sm font-semibold" style="color: var(--ui-text-primary);">Card header</p>
                    </header>
                    <div class="p-4" style="background: var(--ui-layer-01);">
                        <div class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background: var(--ui-layer-02);">
                            <p class="text-sm font-semibold" style="color: var(--ui-text-primary);">Nested region</p>
                            <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">The nested region steps one layer above the card body.</p>
                        </div>
                    </div>
                    <footer class="px-4 py-3 text-sm" style="background: var(--ui-layer-01); color: var(--ui-text-secondary);">
                        Footer actions or summary metadata
                    </footer>
                </article>

                <article class="overflow-hidden rounded-lg border" style="border-color: var(--ui-border-subtle-01); background: var(--ui-layer-01);" data-background-layer-example="same-layer-card">
                    <header class="px-4 py-3" style="background: var(--ui-layer-01);">
                        <p class="text-sm font-semibold" style="color: var(--ui-text-primary);">Default same-layer header</p>
                    </header>
                    <div class="p-4" style="background: var(--ui-layer-01);">
                        <p class="text-sm" style="color: var(--ui-text-secondary);">The card does not need a different header color or a separator line to be a card.</p>
                    </div>
                    <footer class="px-4 py-3 text-sm" style="background: var(--ui-layer-01); color: var(--ui-text-secondary);">
                        Default same-layer footer
                    </footer>
                </article>
            </div>
        </section>

        <section class="ui-card" data-background-layering-section="component-containers">
            <h2 class="ui-card-title">Component Container Examples</h2>
            <p class="ui-card-copy mt-2">Component examples should resolve through the same layer model. Code snippets, menu surfaces, table shells, and form groups must not invent a local background sequence.</p>

            <div class="mt-5 grid gap-5 xl:grid-cols-2">
                <div class="min-w-0" data-background-layer-example="code-snippet-container">
                    <p class="mb-3 text-sm font-semibold" style="color: var(--ui-text-primary);">Code snippet container</p>
                    <x-ui.code-snippet language="Blade" copyable><span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.card</span> <span class="ui-code-token-property">layer</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"01"</span><span class="ui-code-token-punctuation">&gt;</span>...<span class="ui-code-token-punctuation">&lt;/</span><span class="ui-code-token-keyword">x-ui.card</span><span class="ui-code-token-punctuation">&gt;</span></x-ui.code-snippet>
                </div>

                <div class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background: var(--ui-layer-01);" data-background-layer-example="form-group-container">
                    <p class="mb-3 text-sm font-semibold" style="color: var(--ui-text-primary);">Form group container</p>
                    <div class="rounded-md border p-3" style="border-color: var(--ui-border-subtle-01); background: var(--ui-layer-02);">
                        <label class="ui-control-label" for="layering-demo-field">Workspace name</label>
                        <input id="layering-demo-field" class="ui-input mt-2" value="Acme workspace">
                        <p class="mt-2 text-xs" style="color: var(--ui-text-helper);">Inputs remain field surfaces inside the nested layer.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="ui-card" data-background-layering-section="implementation-rules">
            <h2 class="ui-card-title">Implementation Rules</h2>
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <ul class="space-y-3 text-sm" style="color: var(--ui-text-secondary);">
                    <li>Use `--ui-background` for the page canvas, not for nested cards.</li>
                    <li>Use `--ui-layer-01` for first-level cards, panels, and table shells.</li>
                    <li>Use `--ui-layer-02` for nested example wells, component bodies, and contained regions.</li>
                    <li>Use `--ui-layer-03` when a component or pattern requires a fourth visible nested layer.</li>
                </ul>
                <ul class="space-y-3 text-sm" style="color: var(--ui-text-secondary);">
                    <li>Do not alternate white/gray manually in component examples.</li>
                    <li>Do not use accent layers or borders for card headers and footers by default.</li>
                    <li>Use `--ui-layer-accent-01` only for persistent structural bands owned by a component or pattern, such as table headers.</li>
                    <li>Do not solve contrast with raw slate, zinc, gray, or opacity utilities.</li>
                    <li>Do not put unrelated floating cards inside a card; use nested layers only for actual contained content.</li>
                    <li>When a component needs different layer behavior, update the owning Component standard and this Color reference together.</li>
                </ul>
            </div>
        </section>
    </section>
</x-layouts.app>
