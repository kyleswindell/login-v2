<x-layouts.app title="UI Reference - Widget Content 4×0.5 Strip">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.widget-content.4x0-5'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <x-ui.patterns.page-title-actions-row
            title="4×0.5 Dashboard Status Strip"
            description="Four 1×0.5 status/counter cards across the full dashboard row. A specialized top-of-dashboard strip, not a standard widget body pattern."
            kicker="Widget size · 4×0.5 strip"
        >
            <x-slot:actions>
                <x-ui.button :href="route('platform.ui-reference.patterns.widget-content')" variant="outline">Standards overview</x-ui.button>
                <x-ui.button :href="route('platform.ui-reference.patterns.widget-content.size', ['size' => 'shape-map'])" variant="outline">Shape map</x-ui.button>
            </x-slot:actions>
        </x-ui.patterns.page-title-actions-row>

        <x-ui.patterns.content-section-block
            title="Strip definition"
            description="The 4×0.5 status strip is represented as four 1×0.5 status/counter cards placed side by side across the full dashboard row."
            kicker="Shape definition"
            data-widget-size-page="4x0-5"
        >
            <div class="grid gap-4 lg:grid-cols-3">
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Strip composition</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">4 × (1×0.5)</p>
                    <p class="ui-card-copy mt-1">Four compact cards placed side by side to form a full-row status strip. Each card is one 1×0.5 unit.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Card height</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">Half-height</p>
                    <p class="ui-card-copy mt-1">Each card occupies roughly half the height of a 1×1 widget. One label and one value only.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Column coverage</p>
                    <p class="mt-2 font-mono text-sm font-semibold" style="color: var(--ui-text-strong);">4 of 4</p>
                    <p class="ui-card-copy mt-1">Full dashboard row. This is the only approved full-row surface in the current standard.</p>
                </div>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Content boundary"
            description="The 4×0.5 strip has strict content constraints. Each card may only carry one compact label and one value."
            kicker="Boundary rules"
        >
            <div class="grid gap-4 lg:grid-cols-3">
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Allowed per card</p>
                    <p class="ui-card-copy mt-2">One compact label (short, uppercase or small text) and one value. An optional minimal indicator such as a color dot or compact badge.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Not allowed</p>
                    <p class="ui-card-copy mt-2">Paragraphs, lists, charts, icons that need labels, multi-action controls, or content that requires wrapping text inside the compact card height.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Escalate when</p>
                    <p class="ui-card-copy mt-2">Any card in the strip needs more than one label and one value. Use a 1×1 or 2×1 standard widget instead of stretching the strip format.</p>
                </div>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Strip composition proof"
            description="Four 1×0.5 compact status cards representing the dashboard strip. Each card shows a single label and value at half the normal widget height."
            kicker="Reference proof"
        >
            <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4" data-widget-strip-proof>
                @foreach ([
                    ['SLA Health', '84%'],
                    ['Queue Age', '18m'],
                    ['Open Reviews', '12'],
                    ['Blocked', '0'],
                ] as [$label, $value])
                    <div class="ui-pattern-widget-shell-section flex flex-col justify-center" data-widget-strip-card>
                        <p class="ui-pattern-key-value-label">{{ $label }}</p>
                        <p class="mt-1 text-2xl font-semibold leading-tight" style="color: var(--ui-text-strong);">{{ $value }}</p>
                    </div>
                @endforeach
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Important constraints"
            description="The 4×0.5 strip occupies the full dashboard row. Misuse as a standard widget body pattern is not approved."
            kicker="Usage rules"
        >
            <div class="grid gap-4 lg:grid-cols-2">
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Specialized surface only</p>
                    <p class="ui-card-copy mt-2">The 4×0.5 strip is defined as four 1×0.5 status/counter cards. It must not be reused as a normal widget body without a separate explicit review and approval.</p>
                </div>
                <div class="ui-pattern-widget-shell-section">
                    <p class="ui-pattern-key-value-label">Full-row ownership</p>
                    <p class="ui-card-copy mt-2">Because it spans all four columns, the strip must not coexist on the same row as other dashboard widgets. It always occupies a dedicated row at the top of the dashboard.</p>
                </div>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Future approved module examples"
            description="Approved concrete module patterns for the 4×0.5 strip will be added here after review."
            kicker="Module scaffold"
            data-widget-size-module-scaffold="4x0-5"
        >
            <div class="ui-pattern-widget-shell-section is-subtle">
                <p class="ui-card-copy" style="color: var(--ui-text-muted);">No approved module examples yet. Examples will be added by size after the content-space unit system is reviewed and approved.</p>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block title="Navigate sizes" kicker="Size navigation">
            <div class="flex flex-wrap gap-3">
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content') }}" class="ui-action ui-action-soft text-sm">Standards overview</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => 'shape-map']) }}" class="ui-action ui-action-soft text-sm">Shape map</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '1x1']) }}" class="ui-action ui-action-soft text-sm">1×1</a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => '3x3']) }}" class="ui-action ui-action-soft text-sm">3×3</a>
            </div>
        </x-ui.patterns.content-section-block>
    </section>
</x-layouts.app>
