<x-layouts.app :title="'UI Reference - Typography Type Sets'">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'elements.typography.type-sets'])
    </x-slot:sidebar>

    <section class="flex min-w-0 flex-1 flex-col gap-6" data-typography-type-sets-page data-ui-reference-foundation-element="typography">
        <div>
            <p class="ui-kicker">Foundation Element - Typography</p>
            <h1 class="ui-page-header-title">Type Sets</h1>
            <p class="ui-page-header-copy">Productive and Expressive Type Sets are app-owned Typography standards. Productive type is the default for operational UI; expressive type is available for approved high-presence content moments while keeping components and controls productive.</p>
        </div>

        <section class="ui-card" data-type-set-section="status-summary">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <h2 class="ui-card-title">Type-Set Status Summary</h2>
                    <p class="ui-card-copy mt-2">Both type sets use Login App system fonts, app tokens, and `ui-type-*` classes. Productive uses a 14px base and fixed productive headings. Expressive uses a 16px base with fixed smaller roles and fluid expressive headings for higher-presence surfaces.</p>
                </div>
                <a wire:navigate href="{{ route('platform.ui-reference.elements.show', ['element' => 'typography']) }}" class="ui-link">Back to Typography Overview</a>
            </div>

            <div class="mt-5 grid gap-4 lg:grid-cols-2">
                <article class="rounded-lg border p-4 ui-type-set-productive" style="border-color: var(--ui-border-subtle-01); background: var(--ui-layer-01);" data-type-set="productive">
                    <p class="ui-kicker">Productive Type Set</p>
                    <h3 class="ui-type-productive-heading-05 mt-3">Operational hierarchy</h3>
                    <p class="ui-type-productive-body mt-3">14px productive base, fixed productive headings, and compact text roles for admin screens, forms, tables, cards, and repeated controls.</p>
                    <p class="mt-3 font-mono text-xs" style="color: var(--ui-text-helper);">--ui-type-productive-base-size: 14px</p>
                </article>

                <article class="rounded-lg border p-4 ui-type-set-expressive" style="border-color: var(--ui-border-subtle-01); background: var(--ui-layer-01);" data-type-set="expressive">
                    <p class="ui-kicker">Expressive Type Set</p>
                    <h3 class="ui-type-expressive-heading-05 mt-3">High-presence content</h3>
                    <p class="ui-type-expressive-body mt-3">16px expressive base, fixed support roles, and fluid expressive headings for empty states, onboarding, docs, and help moments.</p>
                    <p class="mt-3 font-mono text-xs" style="color: var(--ui-text-helper);">--ui-type-expressive-base-size: 16px</p>
                </article>
            </div>
        </section>

        <section class="ui-card" data-type-set-section="productive-matrix" data-type-set="productive">
            <h2 class="ui-card-title">Productive Type Set</h2>
            <p class="ui-card-copy mt-2">Productive roles are the default for product UI. They keep dense screens readable and predictable.</p>

            @include('platform.ui-reference.elements.partials.typography-type-set-table', [
                'rows' => $productiveRows,
                'setName' => 'Productive',
            ])
        </section>

        <section class="ui-card" data-type-set-section="expressive-matrix" data-type-set="expressive">
            <h2 class="ui-card-title">Expressive Type Set</h2>
            <p class="ui-card-copy mt-2">Expressive roles are installed but selected intentionally by Components or Patterns. Use them for content presence, not for local component decoration.</p>

            @include('platform.ui-reference.elements.partials.typography-type-set-table', [
                'rows' => $expressiveRows,
                'setName' => 'Expressive',
            ])
        </section>

        <section class="ui-card" data-type-set-example="comparison">
            <h2 class="ui-card-title">Same-Content Comparison</h2>
            <p class="ui-card-copy mt-2">The same message changes hierarchy and rhythm when it moves from a productive operations surface to an expressive content surface.</p>

            <div class="mt-5 grid gap-4 xl:grid-cols-2">
                <article class="rounded-lg border p-5 ui-type-set-productive" style="border-color: var(--ui-border-subtle-01); background: var(--ui-layer-01);">
                    <p class="ui-type-productive-label">Productive treatment</p>
                    <h3 class="ui-type-productive-heading-03 mt-3">No records match these filters</h3>
                    <p class="ui-type-productive-body mt-2">Adjust the filter values or clear the table search to review the full dataset.</p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <x-ui.button size="sm">Clear filters</x-ui.button>
                        <x-ui.button semantic="tertiary" size="sm">Save view</x-ui.button>
                    </div>
                </article>

                <article class="rounded-lg border p-5 ui-type-set-expressive" style="border-color: var(--ui-border-subtle-01); background: var(--ui-layer-01);">
                    <p class="ui-type-expressive-label">Expressive treatment</p>
                    <h3 class="ui-type-expressive-heading-05 mt-3">No records match these filters</h3>
                    <p class="ui-type-expressive-body mt-2">This surface can use stronger hierarchy when the empty state needs to slow the reader down and explain recovery.</p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <x-ui.button size="sm">Clear filters</x-ui.button>
                        <x-ui.button semantic="tertiary" size="sm">Save view</x-ui.button>
                    </div>
                </article>
            </div>
        </section>

        <section class="ui-card" data-type-set-example="blending">
            <h2 class="ui-card-title">Approved Blending Examples</h2>
            <p class="ui-card-copy mt-2">Use expressive text to create presence, then return operational controls and implementation details to productive roles.</p>

            <div class="mt-5 grid gap-4 xl:grid-cols-3">
                @foreach ($blendingExamples as $example)
                    <article class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background: var(--ui-layer-01);">
                        <p class="ui-kicker">Approved Blend</p>
                        <h3 class="{{ $example['heading_class'] }} mt-3">{{ $example['name'] }}</h3>
                        <p class="{{ $example['body_class'] }} mt-3" style="color: var(--ui-text-secondary);">{{ $example['summary'] }}</p>

                        @if (str_contains($example['name'], 'code snippet'))
                            <pre class="ui-code-snippet ui-type-code-02 mt-4"><code><span class="ui-code-token-keyword">class</span>=<span class="ui-code-token-string">"ui-type-productive-body"</span></code></pre>
                        @else
                            <div class="mt-4 flex flex-wrap gap-2">
                                <x-ui.button size="sm">Continue</x-ui.button>
                                <x-ui.button semantic="ghost" size="sm">Cancel</x-ui.button>
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>
        </section>

        <section class="ui-card" data-type-set-section="api-matrix">
            <h2 class="ui-card-title">API Matrix</h2>
            <p class="ui-card-copy mt-2">Use these app classes and variables as the public Typography Type Sets API.</p>

            <div class="mt-5 overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-subtle-01); background: var(--ui-layer-01);">
                <table class="w-full min-w-[1180px] table-fixed divide-y" style="border-color: var(--ui-border-subtle-01);">
                    <colgroup>
                        <col class="w-[12rem]">
                        <col class="w-[18rem]">
                        <col class="w-[9rem]">
                        <col class="w-[8rem]">
                        <col class="w-[13rem]">
                        <col class="w-[15rem]">
                        <col class="w-[15rem]">
                        <col>
                    </colgroup>
                    <thead style="background: var(--ui-layer-accent-01);">
                        <tr class="text-left text-xs uppercase tracking-[0.18em]" style="color: var(--ui-text-helper);">
                            <th class="px-4 py-3">Role</th>
                            <th class="px-4 py-3">Class</th>
                            <th class="px-4 py-3">Base size</th>
                            <th class="px-4 py-3">Weight</th>
                            <th class="px-4 py-3">Line height behavior</th>
                            <th class="px-4 py-3">Owner</th>
                            <th class="px-4 py-3">Allowed contexts</th>
                            <th class="px-4 py-3">Avoid contexts</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y text-sm" style="border-color: var(--ui-border-subtle-01); color: var(--ui-text-secondary);">
                        @foreach ($apiRows as $row)
                            <tr data-type-set-api-role="{{ Str::slug($row['role']) }}">
                                <td class="px-4 py-3 font-semibold" style="color: var(--ui-text-primary);">{{ $row['role'] }}</td>
                                <td class="px-4 py-3 font-mono text-xs" style="color: var(--ui-text-primary);">{{ $row['class'] }}</td>
                                <td class="px-4 py-3">{{ $row['base'] }}</td>
                                <td class="px-4 py-3">{{ $row['weight'] }}</td>
                                <td class="px-4 py-3">{{ $row['line_height'] }}</td>
                                <td class="px-4 py-3">{{ $row['owner'] }}</td>
                                <td class="px-4 py-3">{{ $row['allowed'] }}</td>
                                <td class="px-4 py-3">{{ $row['avoid'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section class="grid gap-4 xl:grid-cols-2">
            <article class="ui-card" data-type-set-section="prohibited-usage">
                <h2 class="ui-card-title">Prohibited Usage</h2>
                <div class="mt-4 space-y-3">
                    @foreach ($prohibitedUsage as $item)
                        <div class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background: var(--ui-layer-01);">
                            <p class="text-sm font-semibold" style="color: var(--ui-text-primary);">{{ $item['label'] }}</p>
                            <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">{{ $item['reason'] }}</p>
                        </div>
                    @endforeach
                </div>
            </article>

            <article class="ui-card" data-type-set-section="gated-capabilities">
                <h2 class="ui-card-title">Deferred Or Gated Capabilities</h2>
                <div class="mt-4 space-y-3">
                    @foreach ($gatedCapabilities as $item)
                        <div class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background: var(--ui-layer-01);">
                            <p class="text-sm font-semibold" style="color: var(--ui-text-primary);">{{ $item['label'] }}</p>
                            <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">{{ $item['gate'] }}</p>
                        </div>
                    @endforeach
                </div>
            </article>
        </section>
    </section>
</x-layouts.app>
