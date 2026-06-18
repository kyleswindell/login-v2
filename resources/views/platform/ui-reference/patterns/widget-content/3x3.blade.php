<x-layouts.app title="UI Reference - Widget Content 3×3">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.widget-content.3x3'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <x-ui.patterns.page-title-actions-row
            title="3×3 Widget Size Standard"
            description="Nine 1×1 units or mixed compositions. The upper-bound dashboard module capacity. Not a general page replacement."
            kicker="Widget size · 3×3"
        >
            <x-slot:actions>
                <x-ui.button :href="route('platform.ui-reference.patterns.widget-content')" semantic="tertiary">Standards overview</x-ui.button>
                <x-ui.button :href="route('platform.ui-reference.patterns.widget-content.size', ['size' => 'shape-map'])" semantic="tertiary">Shape map</x-ui.button>
            </x-slot:actions>
        </x-ui.patterns.page-title-actions-row>

        <x-ui.patterns.content-section-block
            title="Shape capacity"
            description="A 3×3 widget spans three columns and three row tracks. This is the maximum defined content-space unit in the current standard."
            kicker="Capacity"
            data-widget-size-page="3x3"
        >
            <div class="grid gap-4 lg:grid-cols-3">
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Shell</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">56rem ≈ 896px</p>
                    <p class="ui-card-copy mt-1">Three row tracks (3 × 18rem + 2rem gap). Maximum height in the standard.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Usable content area</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">≈ 792px × 3 cols wide</p>
                    <p class="ui-card-copy mt-1">Very large. This size must justify its full content capacity before use.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Column span</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">3 of 4</p>
                    <p class="ui-card-copy mt-1">Three-quarter row across three row tracks. Maximum defined standard.</p>
                </div>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Content boundary"
            description="The 3×3 size requires a very strong same-topic content justification. Most dashboard modules do not need this size."
            kicker="Boundary rules"
        >
            <div class="grid gap-4 lg:grid-cols-3">
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Valid use</p>
                    <p class="ui-card-copy mt-2">Nine 1×1 units of genuinely related content. Three 3×1 rows. Three 1×3 columns (pending future approval). One unified 3×3 surface with rich same-topic content.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Fill requirement</p>
                    <p class="ui-card-copy mt-2">The 65–85% fill rule applies strictly. A 3×3 surface that is half empty means the content belongs in a smaller widget. Do not pad with unrelated content to fill the space.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Not allowed</p>
                    <p class="ui-card-copy mt-2">Treating it as a general page replacement. Independent workflows, forms, multi-section mixed-topic panels, or tables that should live on a dedicated page.</p>
                </div>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Shape composition examples"
            description="Examples of valid compositions for the 3×3 surface. All examples must use the full content area with same-topic content."
            kicker="Compositions"
        >
            <div class="grid gap-4 lg:grid-cols-2">
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Nine 1×1 units</p>
                    <p class="ui-card-copy mt-2">Three rows of three compact scan targets each. All nine units must be occupied by related content from the same subject area.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Three 3×1 rows</p>
                    <p class="ui-card-copy mt-2">Three stacked horizontal summary rows. Each row is a full-width summary of the same subject area at different granularity or time periods.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">One 2×2 block + supporting units</p>
                    <p class="ui-card-copy mt-2">A primary 2×2 block occupies four units. Remaining five units carry supporting same-topic summary data around it.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">One unified 3×3</p>
                    <p class="ui-card-copy mt-2">A single rich same-topic module that needs the full block. Rare. Requires strong justification that no smaller size provides the required capacity.</p>
                </div>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Future approved module examples"
            description="Approved concrete module patterns for the 3×3 content-space unit will be added here after review. This is the highest-capacity standard size and requires the most rigorous content justification before approval."
            kicker="Module scaffold"
            data-widget-size-module-scaffold="3x3"
        >
            <div class="ui-pattern-widget-shell-section is-subtle">
                <p class="ui-card-copy" style="color: var(--ui-text-muted);">No approved module examples yet. Examples will be added by size after the content-space unit system is reviewed and approved.</p>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block title="Navigate sizes" kicker="Size navigation">
            <div class="flex flex-wrap gap-3">
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content') }}" class="ui-action ui-action-soft text-sm">Standards overview</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '3x2']) }}" class="ui-action ui-action-soft text-sm">3×2</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '3x1']) }}" class="ui-action ui-action-soft text-sm">3×1</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '4x0-5']) }}" class="ui-action ui-action-soft text-sm">4×0.5 Strip</a>
            </div>
        </x-ui.patterns.content-section-block>
    </section>
</x-layouts.app>
