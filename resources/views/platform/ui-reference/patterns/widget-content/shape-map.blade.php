<x-layouts.app title="UI Reference - Widget Content Shape Map">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.widget-content.shape-map'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <x-ui.patterns.page-title-actions-row
            title="Content-Space Shape Map"
            description="Every supported widget shape visualized by unit count. Use this as the composition reference before selecting a widget size for a new module."
            kicker="Widget content shapes"
        >
            <x-slot:actions>
                <x-ui.button :href="route('platform.ui-reference.patterns.widget-content')" semantic="tertiary">Back to standards</x-ui.button>
            </x-slot:actions>
        </x-ui.patterns.page-title-actions-row>

        <x-ui.patterns.content-section-block
            title="Content-space unit shapes"
            description="Each block represents one 1×1 content-space unit. Shapes are visualized inside neutral widget shells at standard proportions. The colored fill blocks use the Current Item States palette for shape differentiation only."
            kicker="Shape visualization"
            data-widget-shape-map
        >
            @php
                $unitColor = 'background-color: var(--ui-action-soft-neutral-bg); border: 1px solid var(--ui-action-soft-neutral-border);';
                $accentColor = 'background-color: var(--ui-action-soft-primary-bg); border: 1px solid var(--ui-action-soft-primary-border);';
                $halfColor = 'background-color: var(--ui-action-soft-warning-bg); border: 1px solid var(--ui-action-soft-warning-border);';
                $stripColor = 'background-color: var(--ui-action-soft-success-bg); border: 1px solid var(--ui-action-soft-success-border);';
                $cellBase = 'rounded text-center text-xs font-semibold flex items-center justify-center';
                $cellH = 'h-8'; // 2rem unit cell height
                $cellHalf = 'h-4'; // 0.5 unit half-height
            @endphp

            {{-- Compact status/counter shapes --}}
            <div class="grid gap-4 lg:grid-cols-3 xl:grid-cols-4">
                <div class="ui-pattern-widget-shell-section" data-shape="0.5x0.5">
                    <p class="ui-pattern-key-value-label mb-3">0.5×0.5 — Status atom</p>
                    <div class="flex gap-1">
                        <div class="{{ $cellBase }} {{ $cellHalf }} w-8 rounded" style="{{ $halfColor }}">
                            <span class="text-[0.6rem]" style="color: var(--ui-action-soft-warning-text);">½</span>
                        </div>
                    </div>
                    <p class="ui-card-copy mt-3">Tiny status indicator. Used only inside the 4×0.5 strip. No standalone widget use.</p>
                </div>

                <div class="ui-pattern-widget-shell-section" data-shape="1x0.5">
                    <p class="ui-pattern-key-value-label mb-3">1×0.5 — Compact counter</p>
                    <div class="flex gap-1">
                        <div class="{{ $cellBase }} {{ $cellHalf }} w-32 rounded" style="{{ $halfColor }}">
                            <span class="text-xs" style="color: var(--ui-action-soft-warning-text);">label · value</span>
                        </div>
                    </div>
                    <p class="ui-card-copy mt-3">Half-height status/counter item for the dashboard top strip. One label and one value only.</p>
                </div>

                <div class="ui-pattern-widget-shell-section" data-shape="1x1">
                    <p class="ui-pattern-key-value-label mb-3">1×1 — Base unit</p>
                    <div class="flex gap-1">
                        <div class="{{ $cellBase }} {{ $cellH }} w-12 rounded" style="{{ $unitColor }}">
                            <span class="text-xs" style="color: var(--ui-action-soft-neutral-text);">1×1</span>
                        </div>
                    </div>
                    <p class="ui-card-copy mt-3">One content-space cell. The atomic unit for all larger compositions.</p>
                </div>

                <div class="ui-pattern-widget-shell-section" data-shape="2x1">
                    <p class="ui-pattern-key-value-label mb-3">2×1 — Wide unit</p>
                    <div class="flex gap-1">
                        <div class="{{ $cellBase }} {{ $cellH }} w-12 rounded" style="{{ $unitColor }}">
                            <span class="text-xs" style="color: var(--ui-action-soft-neutral-text);">1</span>
                        </div>
                        <div class="{{ $cellBase }} {{ $cellH }} w-12 rounded" style="{{ $accentColor }}">
                            <span class="text-xs" style="color: var(--ui-action-soft-primary-text);">2</span>
                        </div>
                    </div>
                    <p class="ui-card-copy mt-3">Two 1×1 units side by side, or one unified horizontal surface.</p>
                </div>

                <div class="ui-pattern-widget-shell-section" data-shape="1x2">
                    <p class="ui-pattern-key-value-label mb-3">1×2 — Tall unit</p>
                    <div class="flex flex-col gap-1">
                        <div class="{{ $cellBase }} {{ $cellH }} w-12 rounded" style="{{ $unitColor }}">
                            <span class="text-xs" style="color: var(--ui-action-soft-neutral-text);">1</span>
                        </div>
                        <div class="{{ $cellBase }} {{ $cellH }} w-12 rounded" style="{{ $accentColor }}">
                            <span class="text-xs" style="color: var(--ui-action-soft-primary-text);">2</span>
                        </div>
                    </div>
                    <p class="ui-card-copy mt-3">Two 1×1 units stacked, or one unified vertical surface.</p>
                </div>

                <div class="ui-pattern-widget-shell-section" data-shape="2x2">
                    <p class="ui-pattern-key-value-label mb-3">2×2 — Block unit</p>
                    <div class="flex flex-col gap-1">
                        <div class="flex gap-1">
                            <div class="{{ $cellBase }} {{ $cellH }} w-12 rounded" style="{{ $unitColor }}">
                                <span class="text-xs" style="color: var(--ui-action-soft-neutral-text);">1</span>
                            </div>
                            <div class="{{ $cellBase }} {{ $cellH }} w-12 rounded" style="{{ $accentColor }}">
                                <span class="text-xs" style="color: var(--ui-action-soft-primary-text);">2</span>
                            </div>
                        </div>
                        <div class="flex gap-1">
                            <div class="{{ $cellBase }} {{ $cellH }} w-12 rounded" style="{{ $accentColor }}">
                                <span class="text-xs" style="color: var(--ui-action-soft-primary-text);">3</span>
                            </div>
                            <div class="{{ $cellBase }} {{ $cellH }} w-12 rounded" style="{{ $unitColor }}">
                                <span class="text-xs" style="color: var(--ui-action-soft-neutral-text);">4</span>
                            </div>
                        </div>
                    </div>
                    <p class="ui-card-copy mt-3">Four 1×1, two 2×1, or two 1×2 units. Rich single-topic surface.</p>
                </div>

                <div class="ui-pattern-widget-shell-section" data-shape="3x1">
                    <p class="ui-pattern-key-value-label mb-3">3×1 — Wide summary unit</p>
                    <div class="flex gap-1">
                        <div class="{{ $cellBase }} {{ $cellH }} w-12 rounded" style="{{ $unitColor }}">
                            <span class="text-xs" style="color: var(--ui-action-soft-neutral-text);">1</span>
                        </div>
                        <div class="{{ $cellBase }} {{ $cellH }} w-12 rounded" style="{{ $accentColor }}">
                            <span class="text-xs" style="color: var(--ui-action-soft-primary-text);">2</span>
                        </div>
                        <div class="{{ $cellBase }} {{ $cellH }} w-12 rounded" style="{{ $unitColor }}">
                            <span class="text-xs" style="color: var(--ui-action-soft-neutral-text);">3</span>
                        </div>
                    </div>
                    <p class="ui-card-copy mt-3">Three 1×1 units wide. Three-quarter row. Not a full-row contract.</p>
                </div>

                <div class="ui-pattern-widget-shell-section" data-shape="3x2">
                    <p class="ui-pattern-key-value-label mb-3">3×2 — Large block unit</p>
                    <div class="flex flex-col gap-1">
                        <div class="flex gap-1">
                            <div class="{{ $cellBase }} {{ $cellH }} w-12 rounded" style="{{ $unitColor }}">
                                <span class="text-xs" style="color: var(--ui-action-soft-neutral-text);">1</span>
                            </div>
                            <div class="{{ $cellBase }} {{ $cellH }} w-12 rounded" style="{{ $accentColor }}">
                                <span class="text-xs" style="color: var(--ui-action-soft-primary-text);">2</span>
                            </div>
                            <div class="{{ $cellBase }} {{ $cellH }} w-12 rounded" style="{{ $unitColor }}">
                                <span class="text-xs" style="color: var(--ui-action-soft-neutral-text);">3</span>
                            </div>
                        </div>
                        <div class="flex gap-1">
                            <div class="{{ $cellBase }} {{ $cellH }} w-12 rounded" style="{{ $accentColor }}">
                                <span class="text-xs" style="color: var(--ui-action-soft-primary-text);">4</span>
                            </div>
                            <div class="{{ $cellBase }} {{ $cellH }} w-12 rounded" style="{{ $unitColor }}">
                                <span class="text-xs" style="color: var(--ui-action-soft-neutral-text);">5</span>
                            </div>
                            <div class="{{ $cellBase }} {{ $cellH }} w-12 rounded" style="{{ $accentColor }}">
                                <span class="text-xs" style="color: var(--ui-action-soft-primary-text);">6</span>
                            </div>
                        </div>
                    </div>
                    <p class="ui-card-copy mt-3">Six 1×1 or mixed compositions. Largest standard widget surface.</p>
                </div>

                <div class="ui-pattern-widget-shell-section" data-shape="3x3">
                    <p class="ui-pattern-key-value-label mb-3">3×3 — Maximum unit</p>
                    <div class="flex flex-col gap-1">
                        @foreach ([['1','2','3'],['4','5','6'],['7','8','9']] as $row)
                            <div class="flex gap-1">
                                @foreach ($row as $i => $n)
                                    <div class="{{ $cellBase }} {{ $cellH }} w-12 rounded" style="{{ $i % 2 === 0 ? $unitColor : $accentColor }}">
                                        <span class="text-xs" style="color: {{ $i % 2 === 0 ? 'var(--ui-action-soft-neutral-text)' : 'var(--ui-action-soft-primary-text)' }};">{{ $n }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    <p class="ui-card-copy mt-3">Nine 1×1 or mixed compositions. Upper-bound capacity. Not a page replacement.</p>
                </div>

                <div class="ui-pattern-widget-shell-section xl:col-span-2" data-shape="4x0.5">
                    <p class="ui-pattern-key-value-label mb-3">4×0.5 — Dashboard status strip</p>
                    <div class="flex gap-1">
                        @foreach (['SLA', 'Queue', 'Open', 'Risk'] as $label)
                            <div class="{{ $cellBase }} {{ $cellHalf }} flex-1 rounded" style="{{ $stripColor }}">
                                <span class="text-[0.6rem]" style="color: var(--ui-action-soft-success-text);">{{ $label }}</span>
                            </div>
                        @endforeach
                    </div>
                    <p class="ui-card-copy mt-3">Four 1×0.5 status/counter cards across the full dashboard row. Specialized top-of-dashboard strip only. Not reusable as a normal widget body without separate approval.</p>
                </div>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Composition matrix"
            description="Which smaller units may combine to form each supported size. Any valid composition must use the full content area without leaving large empty regions."
            kicker="Shape compositions"
            data-widget-composition-matrix
        >
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="text-xs uppercase tracking-[0.18em]" style="color: var(--ui-text-secondary);">
                        <tr>
                            <th class="border-b px-3 py-3" style="border-color: var(--ui-border-subtle);">Size</th>
                            <th class="border-b px-3 py-3" style="border-color: var(--ui-border-subtle);">Valid compositions</th>
                            <th class="border-b px-3 py-3" style="border-color: var(--ui-border-subtle);">Not valid</th>
                        </tr>
                    </thead>
                    <tbody class="align-top" style="color: var(--ui-text-strong);">
                        @foreach ([
                            ['1×1', 'One 1×1 unit. No sub-division.', 'Split into 0.5×0.5 atoms outside the status strip.'],
                            ['2×1', 'Two 1×1 units, or one unified 2×1 surface.', 'Stacking content that needs a second row.'],
                            ['1×2', 'Two 1×1 units stacked, or one unified 1×2 surface.', 'Side-by-side content that requires 2×1 width.'],
                            ['2×2', 'Four 1×1 · two 2×1 · two 1×2 · one 2×2 unified.', 'Mixing unrelated subjects. Forms or filter panels.'],
                            ['3×1', 'Three 1×1 · one 2×1 + one 1×1 · one unified 3×1.', 'Full-row ownership or second-row content.'],
                            ['3×2', 'Six 1×1 · three 1×2 · two 3×1 · one 2×2 + one 1×2 · one 3×2 unified.', 'Tabs, independent filters, table workflows, unrelated subjects.'],
                            ['3×3', 'Nine 1×1 · three 3×1 · three 1×3 (pending approval) · one 3×3 unified.', 'Treating it as a general page replacement.'],
                            ['4×0.5', 'Four 1×0.5 status cards only.', 'Using it as a standard widget body or adding rows beyond 0.5.'],
                        ] as [$size, $valid, $invalid])
                            <tr>
                                <th class="border-b px-3 py-3 font-mono font-semibold" style="border-color: var(--ui-border-subtle);">{{ $size }}</th>
                                <td class="border-b px-3 py-3" style="border-color: var(--ui-border-subtle);">{{ $valid }}</td>
                                <td class="border-b px-3 py-3" style="border-color: var(--ui-border-subtle);">{{ $invalid }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Size-standard pages"
            description="Jump to a standalone size page to see shape capacity, content boundary rules, and scaffolded module examples for that size."
            kicker="Navigate"
        >
            <div class="flex flex-wrap gap-3">
                @foreach ([
                    ['platform.ui-reference.patterns.widget-content', [], 'Standards overview'],
                    ['platform.ui-reference.patterns.widget-content.size', ['size' => '1x1'], '1×1'],
                    ['platform.ui-reference.patterns.widget-content.size', ['size' => '2x1'], '2×1'],
                    ['platform.ui-reference.patterns.widget-content.size', ['size' => '1x2'], '1×2'],
                    ['platform.ui-reference.patterns.widget-content.size', ['size' => '2x2'], '2×2'],
                    ['platform.ui-reference.patterns.widget-content.size', ['size' => '3x1'], '3×1'],
                    ['platform.ui-reference.patterns.widget-content.size', ['size' => '3x2'], '3×2'],
                    ['platform.ui-reference.patterns.widget-content.size', ['size' => '3x3'], '3×3'],
                    ['platform.ui-reference.patterns.widget-content.size', ['size' => '4x0-5'], '4×0.5 Strip'],
                ] as [$routeName, $routeParams, $label])
                    <a wire:navigate href="{{ route($routeName, $routeParams) }}" class="ui-action ui-action-soft text-sm">{{ $label }}</a>
                @endforeach
            </div>
        </x-ui.patterns.content-section-block>
    </section>
</x-layouts.app>
