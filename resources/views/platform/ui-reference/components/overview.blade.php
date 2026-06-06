<x-layouts.app title="UI Reference - T1 Component Library">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'components.overview'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">T1 Component Library</h1>
            <p class="ui-page-header-copy">Carbon-aligned inventory for Login App 2.0 component coverage. Carbon is used as a completeness benchmark only; this catalog keeps Login App visual, behavior, and implementation ownership.</p>
        </div>

        <div class="grid gap-4 xl:grid-cols-4">
            @foreach ([
                ['label' => 'Implement T1 Page', 'count' => collect($componentCatalog)->where('disposition', 'Implement T1 Page')->count()],
                ['label' => 'Represent As T2 Pattern', 'count' => collect($componentCatalog)->where('disposition', 'Represent As T2 Pattern')->count()],
                ['label' => 'Queued Gap', 'count' => collect($componentCatalog)->where('disposition', 'Queued Gap')->count()],
                ['label' => 'Not Applicable Yet', 'count' => collect($componentCatalog)->where('disposition', 'Not Applicable Yet')->count()],
            ] as $metric)
                <article class="ui-card">
                    <p class="ui-kicker">{{ $metric['label'] }}</p>
                    <p class="mt-3 text-3xl font-semibold text-white">{{ $metric['count'] }}</p>
                </article>
            @endforeach
        </div>

        <section class="ui-card" data-ui-reference-component-inventory>
            <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <h2 class="ui-card-title">Carbon Component Disposition Matrix</h2>
                    <p class="ui-card-copy mt-2">Every component from the reviewed Carbon component menu is mapped to a Login App 2.0 disposition and owner route.</p>
                </div>
                <a wire:navigate href="{{ route('platform.ui-reference.components.show', ['component' => 'number-input']) }}" class="ui-link">Review number input</a>
            </div>

            <div class="mt-5 overflow-x-auto rounded-lg border border-slate-800 bg-slate-950/60">
                <table class="w-full min-w-[1240px] table-fixed divide-y divide-slate-800">
                    <colgroup>
                        <col class="w-[11rem]">
                        <col class="w-[12rem]">
                        <col class="w-[13.5rem]">
                        <col class="w-[20rem]">
                        <col class="w-[18rem]">
                        <col>
                    </colgroup>
                    <thead class="bg-slate-900">
                        <tr class="text-left text-xs uppercase tracking-[0.18em] text-slate-500">
                            <th class="px-4 py-3">Carbon Component</th>
                            <th class="px-4 py-3">Login App Group</th>
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
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center whitespace-nowrap rounded-full border border-slate-700 px-2 py-1 text-xs font-semibold text-slate-200">{{ $component['disposition'] }}</span>
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
