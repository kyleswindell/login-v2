<aside class="w-full lg:w-72">
    <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4 shadow-2xl shadow-black/20 lg:sticky lg:top-24">
        <p class="px-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">UI Reference</p>

        <nav class="mt-3 space-y-1">
            <a wire:navigate href="{{ route('platform.ui-reference.index') }}" @class([
                'flex items-center gap-2 rounded-md px-3 py-3 text-sm font-medium transition',
                'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? 'overview') === 'overview',
                'text-slate-300 hover:bg-slate-800 hover:text-white' => ($currentSection ?? 'overview') !== 'overview',
            ])>
                <x-layouts.nav-icon icon="home" />
                <span>Overview</span>
            </a>
        </nav>

        <div class="mt-4 border-t border-slate-800 pt-4">
            @php $isComponentSection = str_starts_with($currentSection ?? '', 'components.'); @endphp
            <details class="group" open>
                <summary class="flex cursor-pointer list-none items-center justify-between rounded-md px-2 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 transition hover:bg-slate-800/70 hover:text-slate-300">
                    <span>T1 Components</span>
                    <span class="text-slate-500 transition group-open:rotate-180">v</span>
                </summary>

                <nav class="mt-2 max-h-[34rem] space-y-3 overflow-y-auto pr-1" data-ui-reference-component-sidebar>
                    <a wire:navigate href="{{ route('platform.ui-reference.components.overview') }}" @class([
                        'flex items-center gap-2 rounded-md px-3 py-2.5 text-sm font-medium transition',
                        'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? '') === 'components.overview',
                        'text-slate-300 hover:bg-slate-800 hover:text-white' => ($currentSection ?? '') !== 'components.overview',
                    ])>
                        <x-layouts.nav-icon icon="docs" />
                        <span>Overview</span>
                    </a>

                    @foreach (($componentGroups ?? []) as $groupLabel => $components)
                        <div class="space-y-1" data-ui-reference-component-sidebar-group="{{ Str::slug($groupLabel) }}">
                            <p class="px-3 text-[0.66rem] font-semibold uppercase tracking-[0.16em] text-slate-600">{{ $groupLabel }}</p>
                            @foreach ($components as $component)
                                @php $isActiveComponent = ($currentSection ?? '') === 'components.'.$component['slug']; @endphp
                                <a wire:navigate href="{{ route('platform.ui-reference.components.show', ['component' => $component['slug']]) }}" @class([
                                    'flex items-center justify-between gap-2 rounded-md px-3 py-2 text-sm font-medium transition',
                                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => $isActiveComponent,
                                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ! $isActiveComponent,
                                ]) data-ui-reference-component-sidebar-item="{{ $component['slug'] }}">
                                    <span>{{ $component['label'] }}</span>
                                    @if ($component['disposition'] !== 'Implement T1 Page')
                                        <span class="rounded-full border border-slate-700 px-1.5 py-0.5 text-[0.62rem] font-semibold uppercase tracking-[0.12em] text-slate-500">
                                            {{ match ($component['disposition']) {
                                                'Represent As T2 Pattern' => 'T2',
                                                'Queued Gap' => 'Gap',
                                                default => 'Gate',
                                            } }}
                                        </span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @endforeach

                    <div class="border-t border-slate-800 pt-2">
                        <p class="px-3 text-[0.66rem] font-semibold uppercase tracking-[0.16em] text-slate-600">Legacy Index Surfaces</p>
                        <a wire:navigate href="{{ route('platform.ui-reference.components.actions') }}" class="mt-1 block rounded-md px-3 py-1.5 text-xs font-medium text-slate-500 transition hover:bg-slate-800 hover:text-slate-300">Buttons + Icons</a>
                        <a wire:navigate href="{{ route('platform.ui-reference.components.status') }}" class="block rounded-md px-3 py-1.5 text-xs font-medium text-slate-500 transition hover:bg-slate-800 hover:text-slate-300">Badges + Status</a>
                        <a wire:navigate href="{{ route('platform.ui-reference.components.forms') }}" class="block rounded-md px-3 py-1.5 text-xs font-medium text-slate-500 transition hover:bg-slate-800 hover:text-slate-300">Inputs + Forms</a>
                    </div>
                </nav>
            </details>
        </div>

        <div class="mt-4 border-t border-slate-800 pt-4">
            <p class="px-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Pattern Standards</p>
            <nav class="mt-2 space-y-1">
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.forms') }}" @class([
                    'flex items-center gap-2 rounded-md px-3 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? '') === 'patterns.forms',
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ($currentSection ?? '') !== 'patterns.forms',
                ])>
                    <x-layouts.nav-icon icon="docs" />
                    <span>Form Patterns</span>
                </a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.data-content') }}" @class([
                    'flex items-center gap-2 rounded-md px-3 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? '') === 'patterns.data-content',
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ($currentSection ?? '') !== 'patterns.data-content',
                ])>
                    <x-layouts.nav-icon icon="users" />
                    <span>Data + Content</span>
                </a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.tables') }}" @class([
                    'flex items-center gap-2 rounded-md px-3 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? '') === 'patterns.tables',
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ($currentSection ?? '') !== 'patterns.tables',
                ])>
                    <x-layouts.nav-icon icon="users" />
                    <span>Table Baselines</span>
                </a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.overlays') }}" @class([
                    'flex items-center gap-2 rounded-md px-3 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? '') === 'patterns.overlays',
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ($currentSection ?? '') !== 'patterns.overlays',
                ])>
                    <x-layouts.nav-icon icon="error-log" />
                    <span>Overlays + Feedback</span>
                </a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.navigation') }}" @class([
                    'flex items-center gap-2 rounded-md px-3 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? '') === 'patterns.navigation',
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ($currentSection ?? '') !== 'patterns.navigation',
                ])>
                    <x-layouts.nav-icon icon="home" />
                    <span>Navigation + Actions</span>
                </a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.layout') }}" @class([
                    'flex items-center gap-2 rounded-md px-3 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? '') === 'patterns.layout',
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ($currentSection ?? '') !== 'patterns.layout',
                ])>
                    <x-layouts.nav-icon icon="settings" />
                    <span>Layout + Dashboard</span>
                </a>
                @php $isWidgetContentSection = str_starts_with($currentSection ?? '', 'patterns.widget-content'); @endphp
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content') }}" @class([
                    'flex items-center gap-2 rounded-md px-3 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => $isWidgetContentSection,
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ! $isWidgetContentSection,
                ])>
                    <x-layouts.nav-icon icon="settings" />
                    <span>Widget Content</span>
                </a>
                @if ($isWidgetContentSection)
                    <nav class="ml-5 mt-1 flex flex-col gap-1 border-l border-slate-700 pl-3">
                        @foreach ([
                            ['shape-map', 'Shape Map'],
                            ['1x1', '1×1'],
                            ['2x1', '2×1'],
                            ['1x2', '1×2'],
                            ['2x2', '2×2'],
                            ['3x1', '3×1'],
                            ['3x2', '3×2'],
                            ['3x3', '3×3'],
                            ['4x0-5', '4×0.5 Strip'],
                        ] as [$slug, $label])
                            <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => $slug]) }}" @class([
                                'rounded-md px-2 py-1.5 text-xs font-medium transition',
                                'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? '') === 'patterns.widget-content.'.$slug,
                                'text-slate-400 hover:bg-slate-800 hover:text-white' => ($currentSection ?? '') !== 'patterns.widget-content.'.$slug,
                            ])>{{ $label }}</a>
                        @endforeach
                    </nav>
                @endif
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.starters') }}" @class([
                    'flex items-center gap-2 rounded-md px-3 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? '') === 'patterns.starters',
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ($currentSection ?? '') !== 'patterns.starters',
                ])>
                    <x-layouts.nav-icon icon="docs" />
                    <span>Starter Catalog</span>
                </a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.archetypes') }}" @class([
                    'flex items-center gap-2 rounded-md px-3 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? '') === 'patterns.archetypes',
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ($currentSection ?? '') !== 'patterns.archetypes',
                ])>
                    <x-layouts.nav-icon icon="audit-log" />
                    <span>Archetype Proofs</span>
                </a>
            </nav>
        </div>
    </div>
</aside>
