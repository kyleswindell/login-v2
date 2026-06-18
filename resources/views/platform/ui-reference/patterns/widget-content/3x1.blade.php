<x-layouts.app title="UI Reference - Widget Content 3×1">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.widget-content.3x1'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <x-ui.patterns.page-title-actions-row
            title="3×1 Widget Size Standard"
            description="Three 1×1 units wide in a single row. Three-quarter of the dashboard row in the four-unit model. A horizontal same-topic summary, not a full-row contract."
            kicker="Widget size · 3×1"
        >
            <x-slot:actions>
                <x-ui.button :href="route('platform.ui-reference.patterns.widget-content')" semantic="tertiary">Standards overview</x-ui.button>
                <x-ui.button :href="route('platform.ui-reference.patterns.widget-content.size', ['size' => 'shape-map'])" semantic="tertiary">Shape map</x-ui.button>
            </x-slot:actions>
        </x-ui.patterns.page-title-actions-row>

        <x-ui.patterns.content-section-block
            title="Shape capacity"
            description="A 3×1 widget spans three columns of the four-unit dashboard grid at a single 18rem shell height."
            kicker="Capacity"
            data-widget-size-page="3x1"
        >
            <div class="grid gap-4 lg:grid-cols-3">
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Shell</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">18rem = 288px</p>
                    <p class="ui-card-copy mt-1">One row track. Wide but not tall.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Usable content area</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">≈ 184px × 3 cols wide</p>
                    <p class="ui-card-copy mt-1">Wide horizontal layout for multi-column summaries.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Column span</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">3 of 4</p>
                    <p class="ui-card-copy mt-1">Three-quarter row. Not a full-row contract. Full-row requires a future explicit 4×1 approval.</p>
                </div>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Content boundary"
            kicker="Boundary rules"
        >
            <div class="grid gap-4 lg:grid-cols-3">
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Fits</p>
                    <p class="ui-card-copy mt-2">A horizontal same-topic summary across three or four compact columns with short labels and values.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Stretch limit</p>
                    <p class="ui-card-copy mt-2">Four compact columns if labels remain short. One narrow status block on the right edge if the metric columns stay readable.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Escalate when</p>
                    <p class="ui-card-copy mt-2">It requires full-row ownership, second-row detail, or more than four columns. Escalate to 3×2 for a second row or use a 4×1 dashboard-row contract when available.</p>
                </div>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Live example"
            description="Four compact metric columns with two compact status rows. This is the reference content density for a filled 3×1 widget."
            kicker="Reference example"
        >
            <x-ui.patterns.dashboard-grid columns="widgets">
                <x-ui.patterns.widget-shell
                    title="Deploy Pipeline"
                    description="Three-quarter row summary."
                    kicker="Example 3×1"
                    span="3x1"
                    data-widget-size-example="3x1"
                >
                    <div class="grid gap-3 sm:grid-cols-4">
                        <div>
                            <p class="ui-pattern-key-value-label">Ready</p>
                            <p class="ui-stat-value">18</p>
                            <p class="ui-card-copy">deploys</p>
                        </div>
                        <div>
                            <p class="ui-pattern-key-value-label">Held</p>
                            <p class="ui-stat-value">3</p>
                            <p class="ui-card-copy">owner review</p>
                        </div>
                        <div>
                            <p class="ui-pattern-key-value-label">Risk</p>
                            <p class="ui-stat-value">1</p>
                            <p class="ui-card-copy">rollback note</p>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="rounded-md border px-3 py-2" style="border-color: var(--ui-border-subtle);">Staging owner assigned</div>
                            <div class="rounded-md border px-3 py-2" style="border-color: var(--ui-border-subtle);">Production hold active</div>
                        </div>
                    </div>
                    <p class="ui-card-copy">Fits one horizontal same-topic summary. It is not a full-row contract.</p>
                </x-ui.patterns.widget-shell>
            </x-ui.patterns.dashboard-grid>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Future approved module examples"
            description="Approved concrete module patterns for the 3×1 content-space unit will be added here after review."
            kicker="Module scaffold"
            data-widget-size-module-scaffold="3x1"
        >
            <div class="ui-pattern-widget-shell-section is-subtle">
                <p class="ui-card-copy" style="color: var(--ui-text-muted);">No approved module examples yet. Examples will be added by size after the content-space unit system is reviewed and approved.</p>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block title="Navigate sizes" kicker="Size navigation">
            <div class="flex flex-wrap gap-3">
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content') }}" class="ui-action ui-action-soft text-sm">Standards overview</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '2x1']) }}" class="ui-action ui-action-soft text-sm">2×1</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '3x2']) }}" class="ui-action ui-action-soft text-sm">3×2</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '3x3']) }}" class="ui-action ui-action-soft text-sm">3×3</a>
            </div>
        </x-ui.patterns.content-section-block>
    </section>
</x-layouts.app>
