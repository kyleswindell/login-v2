<x-layouts.app title="UI Reference - Widget Content 2×1">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.widget-content.2x1'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <x-ui.patterns.page-title-actions-row
            title="2×1 Widget Size Standard"
            description="Two 1×1 units wide, or one unified horizontal surface. Horizontal comparisons or multi-signal same-topic summaries."
            kicker="Widget size · 2×1"
        >
            <x-slot:actions>
                <x-ui.button :href="route('platform.ui-reference.patterns.widget-content')" variant="outline">Standards overview</x-ui.button>
                <x-ui.button :href="route('platform.ui-reference.patterns.widget-content.size', ['size' => 'shape-map'])" variant="outline">Shape map</x-ui.button>
            </x-slot:actions>
        </x-ui.patterns.page-title-actions-row>

        <x-ui.patterns.content-section-block
            title="Shape capacity"
            description="A 2×1 widget spans two columns of the four-unit dashboard grid at an 18rem shell height."
            kicker="Capacity"
            data-widget-size-page="2x1"
        >
            <div class="grid gap-4 lg:grid-cols-3">
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Shell</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">18rem = 288px</p>
                    <p class="ui-card-copy mt-1">One row track. No row-span.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Usable content area</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">≈ 184px × 2 cols wide</p>
                    <p class="ui-card-copy mt-1">After shell chrome. Wider layout space for horizontal groupings.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Column span</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">2 of 4</p>
                    <p class="ui-card-copy mt-1">Half the dashboard row in the four-unit model.</p>
                </div>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Content boundary"
            description="What fits, what stretches, and when to escalate to a larger widget size."
            kicker="Boundary rules"
        >
            <div class="grid gap-4 lg:grid-cols-3">
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Fits</p>
                    <p class="ui-card-copy mt-2">Two or three related metrics, one compact status strip below them, or a split horizontal summary with short labels.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Stretch limit</p>
                    <p class="ui-card-copy mt-2">One short explanation can replace a metric column. Four compact columns remain readable if labels are brief.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Escalate when</p>
                    <p class="ui-card-copy mt-2">It needs stacked multi-row detail, independent sections, or more than four columns. Escalate to 2×2 for a second row or 3×1 for three-quarter width.</p>
                </div>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Live example"
            description="Three related metrics with two compact status rows below. This is the reference content density for a filled 2×1 widget."
            kicker="Reference example"
        >
            <x-ui.patterns.dashboard-grid columns="widgets">
                <x-ui.patterns.widget-shell
                    title="Review Queue"
                    description="Open review signals."
                    kicker="Example 2×1"
                    span="2x1"
                    data-widget-size-example="2x1"
                >
                    <div class="grid gap-3 sm:grid-cols-3">
                        <div>
                            <p class="ui-pattern-key-value-label">Open</p>
                            <p class="ui-stat-value">12</p>
                            <p class="ui-card-copy">reviews</p>
                        </div>
                        <div>
                            <p class="ui-pattern-key-value-label">Escalated</p>
                            <p class="ui-stat-value">2</p>
                            <p class="ui-card-copy">owner needed</p>
                        </div>
                        <div>
                            <p class="ui-pattern-key-value-label">Median</p>
                            <p class="ui-stat-value">31m</p>
                            <p class="ui-card-copy">age stable</p>
                        </div>
                    </div>
                    <div class="grid gap-2 text-sm sm:grid-cols-2">
                        <div class="rounded-md border px-3 py-2" style="border-color: var(--ui-border-subtle);">4 awaiting design sign-off</div>
                        <div class="rounded-md border px-3 py-2" style="border-color: var(--ui-border-subtle);">2 need escalation review</div>
                    </div>
                </x-ui.patterns.widget-shell>
            </x-ui.patterns.dashboard-grid>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Future approved module examples"
            description="Approved concrete module patterns for the 2×1 content-space unit will be added here after review."
            kicker="Module scaffold"
            data-widget-size-module-scaffold="2x1"
        >
            <div class="ui-pattern-widget-shell-section is-subtle">
                <p class="ui-card-copy" style="color: var(--ui-text-muted);">No approved module examples yet. Examples will be added by size after the content-space unit system is reviewed and approved.</p>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block title="Navigate sizes" kicker="Size navigation">
            <div class="flex flex-wrap gap-3">
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content') }}" class="ui-action ui-action-soft text-sm">Standards overview</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '1x1']) }}" class="ui-action ui-action-soft text-sm">1×1</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '1x2']) }}" class="ui-action ui-action-soft text-sm">1×2</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '2x2']) }}" class="ui-action ui-action-soft text-sm">2×2</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '3x1']) }}" class="ui-action ui-action-soft text-sm">3×1</a>
            </div>
        </x-ui.patterns.content-section-block>
    </section>
</x-layouts.app>
