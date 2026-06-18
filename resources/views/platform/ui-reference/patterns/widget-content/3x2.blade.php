<x-layouts.app title="UI Reference - Widget Content 3×2">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.widget-content.3x2'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <x-ui.patterns.page-title-actions-row
            title="3×2 Widget Size Standard"
            description="Six 1×1 units or mixed compositions. The largest approved standard widget surface: a rich same-topic area with KPIs, compact visualization, and a same-topic list."
            kicker="Widget size · 3×2"
        >
            <x-slot:actions>
                <x-ui.button :href="route('platform.ui-reference.patterns.widget-content')" semantic="tertiary">Standards overview</x-ui.button>
                <x-ui.button :href="route('platform.ui-reference.patterns.widget-content.size', ['size' => 'shape-map'])" semantic="tertiary">Shape map</x-ui.button>
            </x-slot:actions>
        </x-ui.patterns.page-title-actions-row>

        <x-ui.patterns.content-section-block
            title="Shape capacity"
            description="A 3×2 widget spans three columns and two row tracks."
            kicker="Capacity"
            data-widget-size-page="3x2"
        >
            <div class="grid gap-4 lg:grid-cols-3">
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Shell</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">37rem ≈ 592px</p>
                    <p class="ui-card-copy mt-1">Two row tracks (2 × 18rem + 1rem gap). Three columns wide.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Usable content area</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">≈ 488px × 3 cols wide</p>
                    <p class="ui-card-copy mt-1">Enough for KPIs, a compact visualization, and an exception list.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Column span</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">3 of 4</p>
                    <p class="ui-card-copy mt-1">Three-quarter row across two row tracks. Largest approved standard widget.</p>
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
                    <p class="ui-card-copy mt-2">Rich same-topic summary with a KPI group, a compact visualization area, an exception or detail list, and one footer support line.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Stretch limit</p>
                    <p class="ui-card-copy mt-2">One dense support area if the primary scan target remains clear. Four compact KPI columns with short labels.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Escalate when</p>
                    <p class="ui-card-copy mt-2">It needs tabs, independent filters, data tables, or unrelated sections. Escalate to 3×3 or move the workflow to a dedicated page.</p>
                </div>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Live example"
            description="KPI group, compact bar chart visualization, and an exception list. This is the reference content density for a filled 3×2 widget."
            kicker="Reference example"
        >
            <x-ui.patterns.dashboard-grid columns="widgets">
                <x-ui.patterns.widget-shell
                    title="Reviewer Load"
                    description="Rich same-topic two-row summary."
                    kicker="Example 3×2"
                    span="3x2"
                    data-widget-size-example="3x2"
                >
                    <div class="grid gap-3 sm:grid-cols-4">
                        <div>
                            <p class="ui-pattern-key-value-label">Capacity</p>
                            <p class="ui-stat-value">72%</p>
                            <p class="ui-card-copy">reviewer load</p>
                        </div>
                        <div>
                            <p class="ui-pattern-key-value-label">Open</p>
                            <p class="ui-stat-value">6</p>
                            <p class="ui-card-copy">workstreams</p>
                        </div>
                        <div>
                            <p class="ui-pattern-key-value-label">Oldest</p>
                            <p class="ui-stat-value">41m</p>
                            <p class="ui-card-copy">blocker age</p>
                        </div>
                        <div>
                            <p class="ui-pattern-key-value-label">Owner SLA</p>
                            <p class="ui-stat-value">92%</p>
                            <p class="ui-card-copy">on target</p>
                        </div>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-[1.2fr_0.8fr]">
                        <div class="rounded-md border p-3" style="border-color: var(--ui-border-subtle);">
                            <p class="ui-pattern-key-value-label">Throughput trend</p>
                            <div class="mt-4 grid h-24 grid-cols-7 items-end gap-2">
                                @foreach ([36, 58, 44, 71, 63, 82, 76] as $height)
                                    <span class="rounded-t" style="height: {{ $height }}%; background-color: color-mix(in srgb, var(--ui-text-muted) 34%, transparent);"></span>
                                @endforeach
                            </div>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="rounded-md border px-3 py-2" style="border-color: var(--ui-border-subtle);">6 open workstreams</div>
                            <div class="rounded-md border px-3 py-2" style="border-color: var(--ui-border-subtle);">Oldest blocker: 41m</div>
                            <div class="rounded-md border px-3 py-2" style="border-color: var(--ui-border-subtle);">Two reviewer gaps</div>
                            <div class="rounded-md border px-3 py-2" style="border-color: var(--ui-border-subtle);">No production hold</div>
                        </div>
                    </div>
                    <p class="ui-card-copy">Rich same-topic summary with KPIs, compact visualization, exception list, and one support line.</p>
                </x-ui.patterns.widget-shell>
            </x-ui.patterns.dashboard-grid>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Future approved module examples"
            description="Approved concrete module patterns for the 3×2 content-space unit will be added here after review."
            kicker="Module scaffold"
            data-widget-size-module-scaffold="3x2"
        >
            <div class="ui-pattern-widget-shell-section is-subtle">
                <p class="ui-card-copy" style="color: var(--ui-text-muted);">No approved module examples yet. Examples will be added by size after the content-space unit system is reviewed and approved.</p>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block title="Navigate sizes" kicker="Size navigation">
            <div class="flex flex-wrap gap-3">
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content') }}" class="ui-action ui-action-soft text-sm">Standards overview</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '3x1']) }}" class="ui-action ui-action-soft text-sm">3×1</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '2x2']) }}" class="ui-action ui-action-soft text-sm">2×2</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '3x3']) }}" class="ui-action ui-action-soft text-sm">3×3</a>
            </div>
        </x-ui.patterns.content-section-block>
    </section>
</x-layouts.app>
