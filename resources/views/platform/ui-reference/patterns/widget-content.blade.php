<x-layouts.app title="UI Reference - Widget Content Standards">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.widget-content'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <x-ui.patterns.page-title-actions-row
            title="Widget Content Standards"
            description="Content-space unit system, grid geometry, and px budget for dashboard widgets. Size-specific allowances live on the standalone size pages."
            kicker="Dashboard widgets"
        >
            <x-slot:actions>
                <x-ui.button :href="route('platform.ui-reference.patterns.layout')" variant="outline">Back to dashboard demo</x-ui.button>
                <x-ui.button :href="route('platform.ui-reference.patterns.widget-content.size', ['size' => 'shape-map'])" semantic="primary">View shape map</x-ui.button>
            </x-slot:actions>
        </x-ui.patterns.page-title-actions-row>

        <x-ui.patterns.proof-review-banner
            :items="[
                ['id' => 'P2-B-CQ-023', 'note' => 'Review the rebuilt widget content standards: content-space unit system, px budget, shape capacity map, and standalone size pages.'],
            ]"
            :focus="[
                'Confirm that the content-space unit framing replaces the old semantic-content allowance model, and that standalone size pages scaffold the approved capacity for 1x1 through 3x3 and the 4x0.5 strip.',
            ]"
        />

        <x-ui.patterns.content-section-block
            title="Geometry decision"
            description="This standards page uses a four-unit desktop model. The prior three-unit proof made small cards too wide and encouraged sparse placeholder content."
            kicker="Grid calibration"
            data-widget-geometry-decision
        >
            <div class="grid gap-4 lg:grid-cols-4">
                <div class="ui-card">
                    <p class="ui-kicker">Selected model</p>
                    <h3 class="ui-card-title mt-3">Four-unit dashboard model</h3>
                    <p class="ui-card-copy">At desktop review widths, `1x` is one quarter, `2x` is half width, and `3x` is three quarters of the widget row.</p>
                </div>
                <div class="ui-card">
                    <p class="ui-kicker">Row height</p>
                    <h3 class="ui-card-title mt-3">18rem one-row baseline</h3>
                    <p class="ui-card-copy">One-row widgets must prove content density inside an 18rem track. Two-row widgets reserve exactly two 18rem tracks plus the grid gap.</p>
                </div>
                <div class="ui-card">
                    <p class="ui-kicker">Full-row handling</p>
                    <h3 class="ui-card-title mt-3">No implicit 3x full row</h3>
                    <p class="ui-card-copy">Full-row widgets need a future explicit `4x` contract or a page-specific dashboard composition, not a silent reinterpretation of `3x`.</p>
                </div>
                <div class="ui-card">
                    <p class="ui-kicker">Proof scope</p>
                    <h3 class="ui-card-title mt-3">Shared standards only</h3>
                    <p class="ui-card-copy">The Layout + Dashboard customization proof keeps its approved 24rem row-height proof so `x2` span behavior remains visibly obvious.</p>
                </div>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Viewport review baseline"
            description="Validate these standards at constrained office-monitor widths before approving any size page. No example should depend on a large monitor to look correct."
            kicker="Review widths"
            data-widget-viewport-baseline
        >
            <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-5">
                @foreach (['1024', '1280', '1366', '1440', '1920'] as $width)
                    <div class="ui-pattern-widget-shell-section">
                        <p class="ui-pattern-key-value-label">{{ $width }}px</p>
                        <p class="ui-card-copy mt-2">No clipping, crowding, hidden controls, or internal scroll.</p>
                    </div>
                @endforeach
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Content-space unit system"
            description="Every widget size is defined by how many content-space units it can hold. Concrete content examples are approved later by showing how they consume these units."
            kicker="Unit system"
            data-widget-content-unit-system
        >
            <div class="grid gap-4 lg:grid-cols-2 xl:grid-cols-3">
                @foreach ([
                    ['0.5×0.5', 'Status atom', 'Tiny status indicator. Used only inside the 4×0.5 strip planning. No rich content or wrapping labels.'],
                    ['1×0.5', 'Compact status/counter', 'Half-height item for a top-of-dashboard strip. One label and one value only. No paragraphs, lists, or charts.'],
                    ['1×1', 'Base unit', 'One reusable content-space cell. Future approved compact modules will map to this atom. One scan target per unit.'],
                    ['2×1', 'Wide unit', 'Two 1×1 units side by side, or one unified 2×1 surface. Horizontal comparisons or wider single-topic summaries.'],
                    ['1×2', 'Tall unit', 'Two 1×1 units stacked, or one unified vertical surface. Timeline lists or vertically oriented same-topic detail.'],
                    ['2×2', 'Block unit', 'Four 1×1 units, two 2×1 units, or two 1×2 units. Rich same-topic summary without mixing subjects.'],
                    ['3×1', 'Wide summary unit', 'Three 1×1 units wide. Three-quarter-row summary in the four-unit model. Not a full-row contract.'],
                    ['3×2', 'Large block unit', 'Six 1×1 or mixed compositions. Largest approved standard widget surface: KPIs, compact visual, and list.'],
                    ['3×3', 'Maximum unit', 'Nine 1×1 units or mixed compositions. Upper-bound dashboard module capacity. Not a general page replacement.'],
                    ['4×0.5', 'Dashboard status strip', 'Four 1×0.5 status/counter cards across the full dashboard row. Specialized top-strip only. Not a normal widget body.'],
                ] as [$size, $label, $desc])
                    <div class="ui-pattern-widget-shell-section">
                        <div class="flex items-baseline gap-3">
                            <p class="font-mono text-base font-semibold" style="color: var(--ui-text-strong);">{{ $size }}</p>
                            <p class="ui-pattern-key-value-label">{{ $label }}</p>
                        </div>
                        <p class="ui-card-copy mt-2">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Pixel budget"
            description="Select a widget size based on the usable content area after shell chrome is subtracted, not the total shell height."
            kicker="Shell geometry"
            data-widget-px-budget
        >
            <div class="grid gap-4 lg:grid-cols-2">
                <div class="space-y-3">
                    <div class="ui-pattern-widget-shell-section">
                        <p class="ui-pattern-key-value-label">One-row shell (1×1, 2×1, 3×1)</p>
                        <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">18rem = 288px total</p>
                        <div class="mt-3 space-y-1 text-sm" style="color: var(--ui-text-muted);">
                            <div class="flex justify-between"><span>Widget shell padding (top + bottom)</span><span>≈ 40px</span></div>
                            <div class="flex justify-between"><span>Title, kicker, header row</span><span>≈ 48px</span></div>
                            <div class="flex justify-between"><span>Header bottom margin + body gap</span><span>≈ 16px</span></div>
                            <div class="mt-1 flex justify-between border-t pt-1 font-semibold" style="border-color: var(--ui-border-subtle); color: var(--ui-text-secondary);">
                                <span>Usable content area</span><span>≈ 184px</span>
                            </div>
                        </div>
                    </div>
                    <div class="ui-pattern-widget-shell-section">
                        <p class="ui-pattern-key-value-label">Two-row shell (1×2, 2×2, 3×2)</p>
                        <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">2 × 18rem + 1rem gap = 37rem ≈ 592px</p>
                        <div class="mt-3 space-y-1 text-sm" style="color: var(--ui-text-muted);">
                            <div class="flex justify-between"><span>Shell chrome (same as 1×1)</span><span>≈ 104px</span></div>
                            <div class="mt-1 flex justify-between border-t pt-1 font-semibold" style="border-color: var(--ui-border-subtle); color: var(--ui-text-secondary);">
                                <span>Usable content area</span><span>≈ 488px</span>
                            </div>
                        </div>
                    </div>
                    <div class="ui-pattern-widget-shell-section">
                        <p class="ui-pattern-key-value-label">Three-row shell (3×3)</p>
                        <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">3 × 18rem + 2rem gap = 56rem ≈ 896px</p>
                        <div class="mt-3 space-y-1 text-sm" style="color: var(--ui-text-muted);">
                            <div class="flex justify-between"><span>Shell chrome (same as 1×1)</span><span>≈ 104px</span></div>
                            <div class="mt-1 flex justify-between border-t pt-1 font-semibold" style="border-color: var(--ui-border-subtle); color: var(--ui-text-secondary);">
                                <span>Usable content area</span><span>≈ 792px</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ui-pattern-widget-shell-section flex flex-col gap-3">
                    <p class="ui-pattern-key-value-label">Fill guidance</p>
                    <p class="ui-card-copy">Use roughly 65–85% of the usable content area. Intentional breathing room is correct; a large unused lower half is a sign the widget size is too large.</p>
                    <p class="ui-pattern-key-value-label mt-2">Overflow rule</p>
                    <p class="ui-card-copy">Widgets must never introduce internal scrolling at baseline. If content overflows the declared size, reduce the content, choose a larger size, or move the workflow to a dedicated page.</p>
                    <p class="ui-pattern-key-value-label mt-2">Content fill target</p>
                    <p class="ui-card-copy">Examples should prove the size is usable without looking crammed. A size is wrong if the only way to fill it is to add unrelated content or repeat spacing.</p>
                </div>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Size-standard pages"
            description="Each standalone page defines shape capacity, composition rules, and content boundaries for one widget size. Approved concrete module examples will be added to each size page over time."
            kicker="Navigate by size"
            data-widget-size-navigation
        >
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => 'shape-map']) }}" class="ui-card block transition hover:ring-1" style="--tw-ring-color: var(--ui-border-default);" data-widget-size-nav-item="shape-map">
                    <p class="ui-kicker">Full map</p>
                    <h3 class="ui-card-title mt-2">Shape Map</h3>
                    <p class="ui-card-copy">All content-space shapes up to 3×3, compact status units, and the 4×0.5 strip in one visual reference.</p>
                </a>
                @foreach ([
                    ['1x1', '1×1', 'One compact scan target. Base unit for all larger compositions.'],
                    ['2x1', '2×1', 'Two base units wide. Horizontal summary or comparison.'],
                    ['1x2', '1×2', 'Two units tall. Narrow list or activity feed.'],
                    ['2x2', '2×2', 'Four-unit block. Primary metric plus same-topic detail.'],
                    ['3x1', '3×1', 'Three-quarter row. Wide single-row same-topic summary.'],
                    ['3x2', '3×2', 'Six-unit surface. Rich same-topic content with visualization.'],
                    ['3x3', '3×3', 'Maximum module surface. Upper-bound capacity standard.'],
                    ['4x0-5', '4×0.5 Strip', 'Dashboard-header status strip. Four compact cards across the full row.'],
                ] as [$slug, $display, $desc])
                    <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => $slug]) }}" class="ui-card block transition hover:ring-1" style="--tw-ring-color: var(--ui-border-default);" data-widget-size-nav-item="{{ $slug }}">
                        <p class="ui-kicker">Widget size</p>
                        <h3 class="ui-card-title mt-2">{{ $display }}</h3>
                        <p class="ui-card-copy">{{ $desc }}</p>
                    </a>
                @endforeach
            </div>
        </x-ui.patterns.content-section-block>
    </section>
</x-layouts.app>
