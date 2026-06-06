<x-layouts.app :title="'UI Reference - '.$catalogElement['label']">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'elements.'.$catalogElement['slug']])
    </x-slot:sidebar>

    @php $slug = $catalogElement['slug']; @endphp

    <section class="flex flex-1 flex-col gap-6" data-ui-reference-foundation-element="{{ $slug }}" data-ui-reference-element-disposition="{{ $catalogElement['disposition'] }}">
        <div>
            <p class="ui-kicker">Foundation Element - {{ $catalogElement['disposition'] }}</p>
            <h1 class="ui-page-header-title">{{ $catalogElement['label'] }}</h1>
            <p class="ui-page-header-copy">{{ $catalogElement['summary'] }}</p>
        </div>

        <section class="ui-card">
            <div class="grid gap-5 xl:grid-cols-[minmax(0,1.4fr)_minmax(18rem,0.6fr)]">
                <div>
                    <h2 class="ui-card-title">Required UI Reference Display</h2>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach ($catalogElement['visible_examples'] as $example)
                            <span class="rounded-full border border-slate-700 bg-slate-950 px-3 py-1 text-xs font-semibold text-slate-300">{{ $example }}</span>
                        @endforeach
                    </div>
                    <dl class="mt-5 space-y-3 text-sm text-slate-300">
                        @foreach ($catalogElement['rules'] as $rule)
                            <div>
                                <dt class="font-semibold text-slate-100">Foundation rule</dt>
                                <dd class="mt-1">{{ $rule }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
                <aside class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                    <p class="ui-kicker">Canonical Standard</p>
                    <a wire:navigate href="{{ route('platform.docs.index', ['path' => $catalogElement['doc_path']]) }}" class="ui-link mt-3 inline-flex">Open canonical doc</a>
                    <dl class="mt-4 space-y-3 text-sm">
                        <div>
                            <dt class="text-slate-500">Doc path</dt>
                            <dd class="mt-1 break-all font-medium text-slate-200">{{ $catalogElement['doc_path'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Carbon comparison</dt>
                            <dd class="mt-1 text-slate-300">{{ $catalogElement['carbon_comparison'] }}</dd>
                        </div>
                    </dl>
                </aside>
            </div>
        </section>

        @if ($slug === 'color')
            <section class="ui-card" data-ui-reference-element-example="color-token-namespaces">
                <h2 class="ui-card-title">Color Token Namespaces</h2>
                <p class="ui-card-copy mt-2">Color is applied through semantic token namespaces. Content hierarchy and action intent are separate so text-primary never means the primary action color.</p>
                <div class="mt-5 grid gap-4 xl:grid-cols-3">
                    @foreach ([
                        ['Text', '--ui-text-strong', '--ui-text-secondary', '--ui-text-muted'],
                        ['Surface', '--ui-surface', '--ui-surface-muted', '--ui-surface-elevated'],
                        ['Action', '--ui-action-primary-bg', '--ui-action-primary-text', '--ui-action-danger-bg'],
                        ['Border', '--ui-border-subtle', '--ui-border-default', '--ui-border-strong'],
                        ['Status', '--ui-status-success-bg', '--ui-status-warning-bg', '--ui-status-danger-bg'],
                        ['Shadow', '--ui-shadow-color', 'color-mix()', 'surface elevation'],
                    ] as [$title, $one, $two, $three])
                        <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                            <h3 class="text-sm font-semibold text-white">{{ $title }}</h3>
                            <ul class="mt-3 space-y-2 font-mono text-xs text-slate-300">
                                <li>{{ $one }}</li>
                                <li>{{ $two }}</li>
                                <li>{{ $three }}</li>
                            </ul>
                        </article>
                    @endforeach
                </div>
                <div class="mt-5 grid gap-4 md:grid-cols-2">
                    <div class="rounded-lg border border-slate-800 bg-white p-4 text-slate-950">
                        <p class="text-sm font-semibold">Light mode token sample</p>
                        <p class="mt-2 text-sm text-slate-700">Primary content uses text hierarchy tokens. Interactive blue belongs to action/link tokens.</p>
                    </div>
                    <div class="rounded-lg border border-slate-700 bg-slate-950 p-4 text-slate-100">
                        <p class="text-sm font-semibold">Dark mode token sample</p>
                        <p class="mt-2 text-sm text-slate-400">The same semantic roles resolve through the active theme.</p>
                    </div>
                </div>
            </section>
        @elseif ($slug === 'themes')
            <section class="ui-card" data-ui-reference-element-example="theme-token-inheritance">
                <h2 class="ui-card-title">Theme Token Inheritance</h2>
                <p class="ui-card-copy mt-2">Theme behavior is resolved at the token layer. Component-level theme overrides are queued only when a standard owns the exception.</p>
                <div class="mt-5 grid gap-4 xl:grid-cols-2">
                    <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                        <p class="ui-kicker">Resolved dark theme</p>
                        <div class="mt-3 rounded-md border border-slate-700 bg-slate-900 p-4 text-slate-100">Surface, text, border, action, and status tokens inherit from dark-mode variables.</div>
                    </article>
                    <article class="rounded-lg border border-slate-300 bg-white p-4 text-slate-950">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Resolved light theme</p>
                        <div class="mt-3 rounded-md border border-slate-200 bg-slate-50 p-4 text-slate-900">The same component contract resolves to light-mode variables.</div>
                    </article>
                </div>
            </section>
        @elseif ($slug === 'spacing')
            <section class="ui-card" data-ui-reference-element-example="spacing-scale">
                <h2 class="ui-card-title">Spacing Scale And Ownership</h2>
                <p class="ui-card-copy mt-2">Login App uses a Tailwind-compatible, 8px-centered spacing model. Components own internal padding; parent layouts own external spacing through gap, stack, grid, row, or cell patterns.</p>
                <div class="mt-5 space-y-4">
                    @foreach ([['2px', '0.125rem'], ['4px', '0.25rem'], ['8px', '0.5rem'], ['12px', '0.75rem'], ['16px', '1rem'], ['24px', '1.5rem'], ['32px', '2rem'], ['48px', '3rem'], ['64px', '4rem']] as [$px, $rem])
                        <div class="grid grid-cols-[5rem_6rem_minmax(0,1fr)] items-center gap-4 text-sm">
                            <span class="font-mono text-slate-300">{{ $px }}</span>
                            <span class="font-mono text-slate-500">{{ $rem }}</span>
                            <span class="block h-3 rounded bg-sky-400" style="width: {{ $px }};"></span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 grid gap-4 xl:grid-cols-3">
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="font-semibold text-white">Stack / gap wrapper</p><p class="mt-2 text-sm text-slate-400">Parent controls vertical and horizontal distance.</p></div>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="font-semibold text-white">Action row</p><p class="mt-2 text-sm text-slate-400">Action groups own wrapping and button gaps.</p></div>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="font-semibold text-white">Table cell</p><p class="mt-2 text-sm text-slate-400">Cells own padding; badges/buttons do not add margins.</p></div>
                </div>
            </section>
        @elseif ($slug === 'typography')
            <section class="ui-card" data-ui-reference-element-example="typography-roles">
                <h2 class="ui-card-title">Typography Roles</h2>
                <div class="mt-5 space-y-4">
                    <div><p class="ui-page-header-title">Page title</p><p class="ui-card-copy">Used once per page-level surface.</p></div>
                    <div><h3 class="ui-card-title">Section title</h3><p class="ui-card-copy">Groups related content inside a page.</p></div>
                    <div><p class="text-base font-semibold text-white">Card title</p><p class="mt-1 text-sm text-slate-400">Compact title for framed repeated content.</p></div>
                    <div><p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Table header</p></div>
                    <div><p class="text-sm text-slate-300">Body text uses content hierarchy tokens and sentence case.</p></div>
                    <div><p class="text-sm text-slate-500">Muted text is supportive, not disabled content.</p></div>
                    <div><label class="text-sm font-medium text-slate-100">Field label</label><p class="mt-1 text-sm text-slate-400">Helper text explains expected input.</p><p class="mt-1 text-sm text-rose-200">Error text is semantic feedback.</p></div>
                    <code class="block rounded-md border border-slate-800 bg-slate-950 p-3 text-sm text-slate-200">code text</code>
                </div>
            </section>
        @elseif ($slug === 'icons')
            <section class="ui-card" data-ui-reference-element-example="iconography-rules">
                <h2 class="ui-card-title">Heroicon Usage</h2>
                <p class="ui-card-copy mt-2">Heroicons are the default UI icon library. Icons are monochrome, aligned with text, and semantic only when they convey meaning not already present in text.</p>
                <div class="mt-5 grid gap-4 xl:grid-cols-4">
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><x-heroicon-o-check-circle class="h-4 w-4 text-emerald-300" /><p class="mt-3 text-sm text-slate-300">16px inline icon</p></div>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><x-heroicon-o-cog-6-tooth class="h-5 w-5 text-slate-300" /><p class="mt-3 text-sm text-slate-300">20px action icon</p></div>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><button type="button" class="grid h-11 w-11 place-items-center rounded-md border border-slate-700" aria-label="Touch target sample"><x-heroicon-o-bell class="h-5 w-5 text-slate-200" /></button><p class="mt-3 text-sm text-slate-300">44px touch target</p></div>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="flex items-center gap-2 text-sm text-slate-200"><x-heroicon-o-information-circle class="h-4 w-4" aria-hidden="true" />Icon and text center-align</p></div>
                </div>
            </section>
        @elseif ($slug === 'grid')
            <section class="ui-card" data-ui-reference-element-example="grid-foundation">
                <h2 class="ui-card-title">Grid And Region Examples</h2>
                <p class="ui-card-copy mt-2">Grid rules define regions and spacing. Components use the available region; they do not create page layout by adding margins to themselves.</p>
                <div class="mt-5 grid gap-4 lg:grid-cols-4">
                    @foreach (['Header region', 'Sidebar region', 'Content region', 'Overlay region'] as $region)
                        <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4 text-sm text-slate-300">{{ $region }}</div>
                    @endforeach
                </div>
                <div class="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    @foreach (['Card grid', 'Form grid', 'Table region', 'Dashboard widget grid'] as $region)
                        <div class="min-h-24 rounded-lg border border-slate-700 bg-slate-900/80 p-4 text-sm text-slate-300">{{ $region }}</div>
                    @endforeach
                </div>
            </section>
        @elseif ($slug === 'motion')
            <section class="ui-card" data-ui-reference-element-example="motion-rules">
                <h2 class="ui-card-title">Motion Rules</h2>
                <div class="mt-5 grid gap-4 xl:grid-cols-4">
                    @foreach (['Hover transition', 'Focus transition', 'Toast motion', 'Reduced motion'] as $motion)
                        <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4 transition hover:border-sky-400 hover:bg-slate-900">
                            <p class="text-sm font-semibold text-white">{{ $motion }}</p>
                            <p class="mt-2 text-sm text-slate-400">Motion clarifies state change and must not carry meaning alone.</p>
                        </div>
                    @endforeach
                </div>
            </section>
        @else
            <section class="ui-card" data-ui-reference-element-example="pictogram-disposition">
                <h2 class="ui-card-title">Pictogram Disposition</h2>
                <p class="ui-card-copy mt-2">Pictograms are queued until a feature requires a larger illustrative symbol. They are not a replacement for UI icons and Carbon pictograms are not imported by default.</p>
                <div class="mt-5 grid gap-4 xl:grid-cols-3">
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><div class="grid h-16 w-16 place-items-center rounded-lg border border-slate-700 text-2xl text-slate-300">?</div><p class="mt-3 text-sm text-slate-300">Queued illustrative placeholder</p></div>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="text-sm font-semibold text-white">Trigger condition</p><p class="mt-2 text-sm text-slate-400">Use only when empty, onboarding, or explanatory states require a larger visual anchor.</p></div>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="text-sm font-semibold text-white">Asset decision</p><p class="mt-2 text-sm text-slate-400">A future ADR must approve any imported pictogram library.</p></div>
                </div>
            </section>
        @endif
    </section>
</x-layouts.app>
