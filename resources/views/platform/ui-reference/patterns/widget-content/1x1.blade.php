<x-layouts.app title="UI Reference - Widget Content 1×1">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.widget-content.1x1'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <x-ui.patterns.page-title-actions-row
            title="1×1 Widget Size Standard"
            description="One base content-space unit. The smallest standard widget size and the atom for all larger compositions."
            kicker="Widget size · 1×1"
        >
            <x-slot:actions>
                <x-ui.button :href="route('platform.ui-reference.patterns.widget-content')" variant="outline">Standards overview</x-ui.button>
                <x-ui.button :href="route('platform.ui-reference.patterns.widget-content.size', ['size' => 'shape-map'])" variant="outline">Shape map</x-ui.button>
            </x-slot:actions>
        </x-ui.patterns.page-title-actions-row>

        <x-ui.patterns.content-section-block
            title="Shape capacity"
            description="A 1×1 widget occupies one content-space unit with an 18rem (288px) shell height and roughly 184px of usable content area after shell chrome."
            kicker="Capacity"
            data-widget-size-page="1x1"
        >
            <div class="grid gap-4 lg:grid-cols-3">
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Shell</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">18rem = 288px</p>
                    <p class="ui-card-copy mt-1">One row track. No row-span.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Usable content area</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">≈ 184px</p>
                    <p class="ui-card-copy mt-1">After title, kicker, padding, and gap.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Column span</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">1 of 4</p>
                    <p class="ui-card-copy mt-1">One quarter of the dashboard row in the four-unit model.</p>
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
                    <p class="ui-card-copy mt-2">One metric or status value, one status chip, and up to two compact support rows with short labels.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Stretch limit</p>
                    <p class="ui-card-copy mt-2">A third support row only if all labels are short and the metric is compact. No wrapping allowed.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Escalate when</p>
                    <p class="ui-card-copy mt-2">It needs a list, body copy, actions, or a chart. Escalate to 2×1 for horizontal expansion or 1×2 for more vertical rows.</p>
                </div>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Live example"
            description="A compact single-topic summary using one metric, one chip, and two support rows. This is the reference content density for a filled 1×1 widget."
            kicker="Reference example"
        >
            <x-ui.patterns.dashboard-grid columns="widgets">
                <x-ui.patterns.widget-shell
                    title="SLA Health"
                    description="Current period summary."
                    kicker="Example 1×1"
                    span="1x1"
                    data-widget-size-example="1x1"
                >
                    <div class="flex items-end justify-between gap-3">
                        <div>
                            <p class="ui-pattern-key-value-label">SLA health</p>
                            <p class="ui-stat-value">84%</p>
                        </div>
                        <span class="rounded-full border px-3 py-1 text-xs font-semibold" style="border-color: var(--ui-border-default); color: var(--ui-text-secondary);">+6%</span>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center justify-between gap-3">
                            <span class="truncate" style="color: var(--ui-text-muted);">Queue age</span>
                            <strong class="shrink-0" style="color: var(--ui-text-strong);">18m</strong>
                        </div>
                        <div class="flex items-center justify-between gap-3">
                            <span class="truncate" style="color: var(--ui-text-muted);">Blocked deploys</span>
                            <strong class="shrink-0" style="color: var(--ui-text-strong);">0</strong>
                        </div>
                    </div>
                </x-ui.patterns.widget-shell>
            </x-ui.patterns.dashboard-grid>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Future approved module examples"
            description="Approved concrete module patterns that consume the 1×1 content-space unit will be added here after review. No module examples have been approved yet for this size."
            kicker="Module scaffold"
            data-widget-size-module-scaffold="1x1"
        >
            <div class="ui-pattern-widget-shell-section is-subtle">
                <p class="ui-card-copy" style="color: var(--ui-text-muted);">No approved module examples yet. Examples will be added by size after the content-space unit system is reviewed and approved.</p>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Navigate sizes"
            description="View capacity, boundary rules, and examples for adjacent widget sizes."
            kicker="Size navigation"
        >
            <div class="flex flex-wrap gap-3">
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content') }}" class="ui-action ui-action-soft text-sm">Standards overview</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => 'shape-map']) }}" class="ui-action ui-action-soft text-sm">Shape map</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '2x1']) }}" class="ui-action ui-action-soft text-sm">2×1</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '1x2']) }}" class="ui-action ui-action-soft text-sm">1×2</a>
            </div>
        </x-ui.patterns.content-section-block>
    </section>
</x-layouts.app>
