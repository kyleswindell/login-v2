<x-layouts.app title="UI Reference · Layout And Dashboard Patterns">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.layout'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <x-ui.patterns.page-title-actions-row
            title="Layout And Dashboard Patterns"
            description="Tier 2 layout proof for content sections, dashboard grids, and shared internal page framing."
            kicker="Tier 2G"
        >
            <x-slot:actions>
                <x-ui.button variant="outline">Open dashboard proof</x-ui.button>
                <x-ui.button semantic="primary">Review responsive states</x-ui.button>
            </x-slot:actions>
        </x-ui.patterns.page-title-actions-row>

        <x-ui.patterns.content-section-block
            title="Dashboard Grid"
            description="The grid defines card spacing and repeatable placement rules only; feature widgets provide the content."
            kicker="Layout baseline"
        >
            <x-ui.patterns.dashboard-grid columns="3">
                <x-ui.patterns.stat-card label="Widgets visible" value="4" supporting-text="Current default dashboard arrangement." icon="heroicon-o-squares-2x2" />
                <x-ui.patterns.stat-card label="Profile tasks" value="2" supporting-text="Actions requiring account attention." trend-label="today" trend-semantic="info" icon="heroicon-o-user-circle" />
                <x-ui.patterns.stat-card label="Setup gaps" value="0" supporting-text="No unresolved setup scaffold blockers in this proof." trend-label="clear" trend-semantic="success" icon="heroicon-o-check-badge" />
            </x-ui.patterns.dashboard-grid>
        </x-ui.patterns.content-section-block>

        <div class="grid gap-6 xl:grid-cols-[1.45fr_minmax(0,1fr)]">
            <x-ui.patterns.content-section-block
                title="Content Section Block"
                description="Section blocks own title, support copy, and action placement while internal content stays flexible."
                kicker="Reusable content frame"
            >
                <div class="space-y-4">
                    <p class="text-sm text-slate-300">Use section blocks to group related data, proof summaries, or form scaffolding without reintroducing feature-specific card chrome.</p>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4 text-sm text-slate-300">
                        Nested content remains free to use other Tier 2 patterns such as lists, validation summaries, or key/value displays.
                    </div>
                </div>
            </x-ui.patterns.content-section-block>

            <x-ui.patterns.content-section-block
                title="Shell Family Notes"
                description="The dashboard, settings, setup, and account surfaces share the same page-header plus section-block scaffolding."
                kicker="Internal shell family"
            >
                <ul class="space-y-2 text-sm text-slate-300">
                    <li>1. Page title/action row stays outside the first section block.</li>
                    <li>2. Section blocks own internal grouping, not page-level navigation.</li>
                    <li>3. Dashboard grids host stat cards and widgets without changing shell framing.</li>
                    <li>4. Responsive stacking must preserve section order before introducing custom breakpoint hacks.</li>
                </ul>
            </x-ui.patterns.content-section-block>
        </div>
    </section>
</x-layouts.app>
