<x-layouts.app title="UI Reference - Widget Content 2×2">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.widget-content.2x2'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <x-ui.patterns.page-title-actions-row
            title="2×2 Widget Size Standard"
            description="Four 1×1 units, two 2×1 units, two 1×2 units, or one unified block surface. Rich single-topic summary with primary metric, body, and a same-topic list."
            kicker="Widget size · 2×2"
        >
            <x-slot:actions>
                <x-ui.button :href="route('platform.ui-reference.patterns.widget-content')" variant="outline">Standards overview</x-ui.button>
                <x-ui.button :href="route('platform.ui-reference.patterns.widget-content.size', ['size' => 'shape-map'])" variant="outline">Shape map</x-ui.button>
            </x-slot:actions>
        </x-ui.patterns.page-title-actions-row>

        <x-ui.patterns.content-section-block
            title="Shape capacity"
            description="A 2×2 widget spans two columns and two row tracks."
            kicker="Capacity"
            data-widget-size-page="2x2"
        >
            <div class="grid gap-4 lg:grid-cols-3">
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Shell</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">37rem ≈ 592px</p>
                    <p class="ui-card-copy mt-1">Two row tracks (2 × 18rem + 1rem gap). Wider than 1×2.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Usable content area</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">≈ 488px × 2 cols wide</p>
                    <p class="ui-card-copy mt-1">Enough for a metric group, a body section, and a short same-topic list.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Column span</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">2 of 4</p>
                    <p class="ui-card-copy mt-1">Half the dashboard row across two row tracks.</p>
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
                    <p class="ui-card-copy mt-2">A metric group, one short body block or explanation, and a same-topic compact list or exception group.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Stretch limit</p>
                    <p class="ui-card-copy mt-2">A small compact visualization or exception group can replace the body block if the scan target stays clear.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Escalate when</p>
                    <p class="ui-card-copy mt-2">It becomes a workflow, a form, or a mixed-topic card. Escalate to 3×2 for more horizontal and vertical capacity.</p>
                </div>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Live example"
            description="A metric group with a body block and a compact exception list. This is the reference content density for a filled 2×2 widget."
            kicker="Reference example"
        >
            <x-ui.patterns.dashboard-grid columns="widgets">
                <x-ui.patterns.widget-shell
                    title="Notifications"
                    description="Current period summary."
                    kicker="Example 2×2"
                    span="2x2"
                    data-widget-size-example="2x2"
                >
                    <div class="grid gap-3 sm:grid-cols-3">
                        <div>
                            <p class="ui-pattern-key-value-label">Unread</p>
                            <p class="ui-stat-value">7</p>
                            <p class="ui-card-copy">notifications</p>
                        </div>
                        <div>
                            <p class="ui-pattern-key-value-label">Routed</p>
                            <p class="ui-stat-value">3</p>
                            <p class="ui-card-copy">to operations</p>
                        </div>
                        <div>
                            <p class="ui-pattern-key-value-label">Pinned</p>
                            <p class="ui-stat-value">1</p>
                            <p class="ui-card-copy">manual review</p>
                        </div>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-md border p-3" style="border-color: var(--ui-border-subtle);">
                            <p class="ui-pattern-key-value-label">Detail body</p>
                            <p class="ui-card-copy mt-2">A two-row detail widget can carry one short explanatory paragraph tied to the primary metric.</p>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="rounded-md border px-3 py-2" style="border-color: var(--ui-border-subtle);">Oldest alert: 18m</div>
                            <div class="rounded-md border px-3 py-2" style="border-color: var(--ui-border-subtle);">3 routed to operations</div>
                            <div class="rounded-md border px-3 py-2" style="border-color: var(--ui-border-subtle);">1 pinned for manual review</div>
                        </div>
                    </div>
                </x-ui.patterns.widget-shell>
            </x-ui.patterns.dashboard-grid>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Future approved module examples"
            description="Approved concrete module patterns for the 2×2 content-space unit will be added here after review."
            kicker="Module scaffold"
            data-widget-size-module-scaffold="2x2"
        >
            <div class="ui-pattern-widget-shell-section is-subtle">
                <p class="ui-card-copy" style="color: var(--ui-text-muted);">No approved module examples yet. Examples will be added by size after the content-space unit system is reviewed and approved.</p>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block title="Navigate sizes" kicker="Size navigation">
            <div class="flex flex-wrap gap-3">
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content') }}" class="ui-action ui-action-soft text-sm">Standards overview</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '1x2']) }}" class="ui-action ui-action-soft text-sm">1×2</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '2x1']) }}" class="ui-action ui-action-soft text-sm">2×1</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '3x2']) }}" class="ui-action ui-action-soft text-sm">3×2</a>
            </div>
        </x-ui.patterns.content-section-block>
    </section>
</x-layouts.app>
