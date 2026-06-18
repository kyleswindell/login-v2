<x-layouts.app title="UI Reference - Widget Content 1×2">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.widget-content.1x2'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <x-ui.patterns.page-title-actions-row
            title="1×2 Widget Size Standard"
            description="Two 1×1 units stacked, or one unified vertical surface. Narrow timeline lists, activity feeds, or vertically oriented same-topic detail."
            kicker="Widget size · 1×2"
        >
            <x-slot:actions>
                <x-ui.button :href="route('platform.ui-reference.patterns.widget-content')" semantic="tertiary">Standards overview</x-ui.button>
                <x-ui.button :href="route('platform.ui-reference.patterns.widget-content.size', ['size' => 'shape-map'])" semantic="tertiary">Shape map</x-ui.button>
            </x-slot:actions>
        </x-ui.patterns.page-title-actions-row>

        <x-ui.patterns.content-section-block
            title="Shape capacity"
            description="A 1×2 widget spans one column and two row tracks. Total shell height is two 18rem tracks plus a 1rem grid gap."
            kicker="Capacity"
            data-widget-size-page="1x2"
        >
            <div class="grid gap-4 lg:grid-cols-3">
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Shell</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">37rem ≈ 592px</p>
                    <p class="ui-card-copy mt-1">Two row tracks (2 × 18rem + 1rem gap).</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Usable content area</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">≈ 488px</p>
                    <p class="ui-card-copy mt-1">After shell chrome. Enough for 4–6 compact list rows.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Column span</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">1 of 4</p>
                    <p class="ui-card-copy mt-1">One quarter of the dashboard row. Narrow vertical orientation.</p>
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
                    <p class="ui-card-copy mt-2">Four to six compact same-topic list rows or timeline entries with short labels.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Stretch limit</p>
                    <p class="ui-card-copy mt-2">One short footer note below the list. A seventh compact row if all entries remain single-line.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Escalate when</p>
                    <p class="ui-card-copy mt-2">Rows need inline actions, long sentences, or side-by-side layout. Escalate to 2×2 for wider row content or more vertical capacity.</p>
                </div>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Live example"
            description="A narrow activity feed with six compact timestamped entries. This is the reference content density for a filled 1×2 widget."
            kicker="Reference example"
        >
            <x-ui.patterns.dashboard-grid columns="widgets">
                <x-ui.patterns.widget-shell
                    title="Activity Feed"
                    description="Recent task timeline."
                    kicker="Example 1×2"
                    span="1x2"
                    data-widget-size-example="1x2"
                >
                    <div class="space-y-3">
                        @foreach ([
                            ['09:10', 'Lock widget shell contract'],
                            ['09:24', 'Recheck overlay publication'],
                            ['09:41', 'Publish menu-item re-review'],
                            ['10:05', 'Confirm form pattern owner'],
                            ['10:33', 'Assign dashboard density pass'],
                            ['10:58', 'Close stale review cue'],
                        ] as [$time, $label])
                            <div class="flex gap-3 rounded-md border p-3 text-sm" style="border-color: var(--ui-border-subtle);">
                                <span class="shrink-0 font-semibold" style="color: var(--ui-text-secondary);">{{ $time }}</span>
                                <span class="min-w-0" style="color: var(--ui-text-strong);">{{ $label }}</span>
                            </div>
                        @endforeach
                    </div>
                    <p class="ui-card-copy">4–6 compact same-topic rows. Escalate if rows need actions, filters, or long copy.</p>
                </x-ui.patterns.widget-shell>
            </x-ui.patterns.dashboard-grid>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Future approved module examples"
            description="Approved concrete module patterns for the 1×2 content-space unit will be added here after review."
            kicker="Module scaffold"
            data-widget-size-module-scaffold="1x2"
        >
            <div class="ui-pattern-widget-shell-section is-subtle">
                <p class="ui-card-copy" style="color: var(--ui-text-muted);">No approved module examples yet. Examples will be added by size after the content-space unit system is reviewed and approved.</p>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block title="Navigate sizes" kicker="Size navigation">
            <div class="flex flex-wrap gap-3">
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content') }}" class="ui-action ui-action-soft text-sm">Standards overview</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '1x1']) }}" class="ui-action ui-action-soft text-sm">1×1</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '2x1']) }}" class="ui-action ui-action-soft text-sm">2×1</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '2x2']) }}" class="ui-action ui-action-soft text-sm">2×2</a>
            </div>
        </x-ui.patterns.content-section-block>
    </section>
</x-layouts.app>
