<x-layouts.app title="UI Reference - Components">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'components.overview'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">Components</h1>
            <p class="ui-page-header-copy">Components are reusable UI building blocks that solve specific interaction, presentation, input, feedback, or navigation problems. The examples in this library are rendered with application code and define the approved component contract for additional development. Use these examples and implementation notes instead of creating one-off component markup, colors, spacing, or behaviors.</p>
        </div>

        <section class="ui-card" data-ui-reference-component-foundation-dependency>
            <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_minmax(20rem,0.7fr)]">
                <div>
                    <p class="ui-kicker">Required Foundation Inputs</p>
                    <h2 class="ui-card-title mt-2">Components consume Elements</h2>
                    <p class="ui-card-copy mt-2">Every Component, Pattern, and later feature view must use the approved Foundation Elements for color tokens, spacing, grid, typography, icons, motion, and themes. Component pages document which Elements are used so downstream work can compose instead of redefining.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach ([
                        ['Color', 'color'],
                        ['Spacing', 'spacing'],
                        ['Typography', 'typography'],
                        ['Icons', 'icons'],
                        ['Motion', 'motion'],
                        ['Themes', 'themes'],
                        ['2x Grid', 'grid'],
                    ] as [$label, $slug])
                        <a wire:navigate href="{{ route('platform.ui-reference.elements.show', ['element' => $slug]) }}" class="rounded-full border border-slate-700 bg-slate-950 px-3 py-1.5 text-xs font-semibold text-slate-200 transition hover:border-slate-500 hover:text-white">{{ $label }}</a>
                    @endforeach
                </div>
            </div>
        </section>

        <div class="grid gap-4 xl:grid-cols-4">
            @foreach ([
                ['label' => 'Implement Component Page', 'count' => collect($componentCatalog)->where('disposition', 'Implement Component Page')->count()],
                ['label' => 'Represent As Pattern', 'count' => collect($componentCatalog)->where('disposition', 'Represent As Pattern')->count()],
                ['label' => 'Queued Gap', 'count' => collect($componentCatalog)->where('disposition', 'Queued Gap')->count()],
                ['label' => 'Not Applicable Yet', 'count' => collect($componentCatalog)->where('disposition', 'Not Applicable Yet')->count()],
            ] as $metric)
                <article class="ui-card">
                    <p class="ui-kicker">{{ $metric['label'] }}</p>
                    <p class="mt-3 text-3xl font-semibold text-white">{{ $metric['count'] }}</p>
                </article>
            @endforeach
        </div>

        <section class="ui-card" data-ui-reference-component-priority-buckets>
            <h2 class="ui-card-title">Implementation Priority</h2>
            <p class="ui-card-copy mt-2">Priority describes implementation order, not visual importance. Tier A items are required for baseline app development, Tier B items are common reusable components, and Tier C items are contextual or deferred until product need is clear.</p>
            <div class="mt-5 grid gap-4 xl:grid-cols-3">
                @foreach (['A' => 'Tier A - Baseline', 'B' => 'Tier B - Common', 'C' => 'Tier C - Contextual'] as $priority => $title)
                    <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4" data-ui-reference-component-priority="{{ $priority }}">
                        <p class="ui-kicker">{{ $title }}</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach (collect($componentCatalog)->where('priority', $priority) as $component)
                                <a wire:navigate href="{{ route('platform.ui-reference.components.show', ['component' => $component['slug']]) }}" class="rounded-full border border-slate-700 px-2.5 py-1 text-xs font-semibold text-slate-200 transition hover:border-slate-500 hover:text-white">{{ $component['label'] }}</a>
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="ui-card" data-ui-reference-component-status-legend>
            <h2 class="ui-card-title">Implementation Status</h2>
            <div class="mt-4 grid gap-3 md:grid-cols-2 xl:grid-cols-5">
                @foreach ([
                    ['Implemented - pending manual review', 'Ready for local review after automated coverage and browser inspection.'],
                    ['Partial', 'Some contract pieces exist, but a complete component page or reusable API is missing.'],
                    ['Deferred', 'Visible catalog entry with trigger conditions; no speculative UI.'],
                    ['Do not implement', 'Not applicable until a product decision creates a real need.'],
                    ['App-specific exception', 'Owned by a Pattern or app-specific composition instead of a primitive page.'],
                ] as [$status, $copy])
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-3">
                        <p class="text-sm font-semibold text-white">{{ $status }}</p>
                        <p class="mt-1 text-xs text-slate-400">{{ $copy }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="ui-card" data-ui-reference-component-inventory>
            <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <h2 class="ui-card-title">Component Inventory</h2>
                    <p class="ui-card-copy mt-2">Every reviewed component family has a Login App disposition, owner route, canonical doc, priority, and implementation scope. Carbon remains a completeness benchmark; Login App owns the contract.</p>
                </div>
                <a wire:navigate href="{{ route('platform.ui-reference.components.show', ['component' => 'number-input']) }}" class="ui-link">Review number input</a>
            </div>

            <div class="mt-5 overflow-x-auto rounded-lg border border-slate-800 bg-slate-950/60">
                <table class="w-full min-w-[1320px] table-fixed divide-y divide-slate-800">
                    <colgroup>
                        <col class="w-[11rem]">
                        <col class="w-[12rem]">
                        <col class="w-[8rem]">
                        <col class="w-[13.5rem]">
                        <col class="w-[20rem]">
                        <col class="w-[18rem]">
                        <col>
                    </colgroup>
                    <thead class="bg-slate-900">
                        <tr class="text-left text-xs uppercase tracking-[0.18em] text-slate-500">
                            <th class="px-4 py-3">Component</th>
                            <th class="px-4 py-3">Login App Group</th>
                            <th class="px-4 py-3">Priority</th>
                            <th class="px-4 py-3 whitespace-nowrap">Disposition</th>
                            <th class="px-4 py-3">Owner Route</th>
                            <th class="px-4 py-3">Canonical Doc</th>
                            <th class="px-4 py-3">Implementation Scope</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 text-sm text-slate-300">
                        @foreach ($componentCatalog as $component)
                            <tr data-ui-reference-component-row="{{ $component['slug'] }}">
                                <td class="px-4 py-3 font-semibold text-white">{{ $component['label'] }}</td>
                                <td class="px-4 py-3">{{ $component['group'] }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $component['priority'] }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center whitespace-nowrap rounded-full border border-slate-700 px-2 py-1 text-xs font-semibold text-slate-200">
                                        {{ match ($component['disposition']) {
                                            'Implement Component Page' => 'Implement Component Page',
                                            'Represent As Pattern' => 'Represent As Pattern',
                                            default => $component['disposition'],
                                        } }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 break-words">
                                    @if (str_starts_with($component['owner_route'], '/platform/ui-reference/components/'))
                                        <a wire:navigate href="{{ route('platform.ui-reference.components.show', ['component' => $component['slug']]) }}" class="text-sky-300 hover:text-sky-200">{{ $component['owner_route'] }}</a>
                                    @else
                                        <a wire:navigate href="{{ $component['owner_route'] }}" class="text-sky-300 hover:text-sky-200">{{ $component['owner_route'] }}</a>
                                    @endif
                                </td>
                                <td class="px-4 py-3 break-words">
                                    <a wire:navigate href="{{ route('platform.docs.index', ['path' => $component['doc_path']]) }}" class="text-sky-300 hover:text-sky-200">{{ $component['doc_path'] }}</a>
                                </td>
                                <td class="px-4 py-3 whitespace-normal">{{ $component['summary'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </section>
</x-layouts.app>
