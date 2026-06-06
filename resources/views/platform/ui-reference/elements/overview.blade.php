<x-layouts.app title="UI Reference - Foundation Elements">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'elements.overview'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <p class="ui-kicker">Foundation Elements</p>
            <h1 class="ui-page-header-title">Foundation Elements</h1>
            <p class="ui-page-header-copy">Primitive elements are the lowest-level visual decisions used across the application. They define layout, color, typography, spacing, motion, iconography, pictograms, and themes. Developers should use the tokens, helpers, utilities, and examples shown in this reference instead of creating one-off values.</p>
            <p class="ui-page-header-copy mt-3">These examples are rendered with the application’s actual CSS and JavaScript. When implementation differs from Carbon, the exception must be documented on the relevant page.</p>
        </div>

        <section class="ui-card">
            <h2 class="ui-card-title">System Hierarchy</h2>
            <div class="mt-5 grid gap-4 xl:grid-cols-4">
                @foreach ([
                    ['Foundation Elements', 'Tokens, grid, spacing, typography, iconography, motion, and themes.'],
                    ['T1 Components', 'Buttons, inputs, feedback, tables, tabs, and other primitive UI controls.'],
                    ['T2 Patterns', 'Forms, navigation compositions, data layouts, overlays, and reusable page sections.'],
                    ['T3 Feature Modules', 'App-specific workflows composed from approved lower tiers.'],
                ] as [$title, $copy])
                    <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                        <h3 class="text-sm font-semibold text-white">{{ $title }}</h3>
                        <p class="mt-2 text-sm text-slate-400">{{ $copy }}</p>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="ui-card" data-ui-reference-element-inventory>
            <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <h2 class="ui-card-title">Foundation Element Inventory</h2>
                    <p class="ui-card-copy mt-2">Each element has a canonical standard doc, a UI Reference owner route, a guide status for page readiness, and a system maturity status for enforcement/adoption.</p>
                </div>
                <a wire:navigate href="{{ route('platform.ui-reference.elements.show', ['element' => 'color']) }}" class="ui-link">Review color tokens</a>
            </div>

            <div class="mt-5 overflow-x-auto rounded-lg border border-slate-800 bg-slate-950/60">
                <table class="w-full min-w-[1120px] table-fixed divide-y divide-slate-800">
                    <colgroup>
                        <col class="w-[10rem]">
                        <col class="w-[13rem]">
                        <col class="w-[13rem]">
                        <col class="w-[19rem]">
                        <col>
                    </colgroup>
                    <thead class="bg-slate-900">
                        <tr class="text-left text-xs uppercase tracking-[0.18em] text-slate-500">
                            <th class="px-4 py-3">Element</th>
                            <th class="px-4 py-3 whitespace-nowrap">Guide Status</th>
                            <th class="px-4 py-3 whitespace-nowrap">System Maturity</th>
                            <th class="px-4 py-3">Canonical Doc</th>
                            <th class="px-4 py-3">Purpose</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 text-sm text-slate-300">
                        @foreach ($elementCatalog as $element)
                            <tr data-ui-reference-element-row="{{ $element['slug'] }}">
                                <td class="px-4 py-3 font-semibold text-white">
                                    <a wire:navigate href="{{ route('platform.ui-reference.elements.show', ['element' => $element['slug']]) }}" class="text-sky-300 hover:text-sky-200">{{ $element['label'] }}</a>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center whitespace-nowrap rounded-full border border-slate-700 px-2 py-1 text-xs font-semibold text-slate-200">{{ $element['guide_status'] }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center whitespace-nowrap rounded-full border border-slate-700 px-2 py-1 text-xs font-semibold text-slate-200">{{ $element['system_status'] }}</span>
                                </td>
                                <td class="px-4 py-3 break-words">
                                    <a wire:navigate href="{{ route('platform.docs.index', ['path' => $element['doc_path']]) }}" class="text-sky-300 hover:text-sky-200">{{ $element['doc_path'] }}</a>
                                </td>
                                <td class="px-4 py-3">{{ $element['summary'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </section>
</x-layouts.app>
