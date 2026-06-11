<x-layouts.app :title="'UI Reference - '.$catalogComponent['label']">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'components.'.$catalogComponent['slug']])
    </x-slot:sidebar>

    @php
        $slug = $catalogComponent['slug'];
        $examples = $catalogComponent['live_examples'] ?? [];
        $firstExample = $examples[0]['id'] ?? 'example';
    @endphp

    <section class="flex flex-1 flex-col gap-6" data-ui-reference-component="{{ $slug }}" data-ui-reference-t1-component="{{ $slug }}" data-ui-reference-component-disposition="{{ $catalogComponent['disposition'] }}" data-ui-reference-component-status="{{ $catalogComponent['status'] }}">
        <div>
            <p class="ui-kicker">{{ $catalogComponent['group'] }} - {{ $catalogComponent['priority_label'] }}</p>
            <h1 class="ui-page-header-title">{{ $catalogComponent['label'] }}</h1>
            <p class="ui-page-header-copy">{{ $catalogComponent['summary'] }}</p>
            <p class="ui-page-header-copy mt-3">Use this page to see what the component looks like in the app, when to use it, how it behaves, and which Foundation Elements it consumes. If a feature needs behavior that is not represented here, update this contract or compose a higher-level Pattern instead of creating local one-off UI.</p>
        </div>

        <section class="ui-card" data-component-card="purpose" data-component-section="purpose">
            <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_minmax(18rem,0.55fr)]">
                <div>
                    <div class="flex flex-wrap items-center gap-3">
                        <p class="ui-kicker">Component overview</p>
                        <span class="inline-flex items-center whitespace-nowrap rounded-full border px-2.5 py-1 text-xs font-semibold" style="border-color: var(--ui-border-subtle-01); color: var(--ui-text-secondary);">{{ $catalogComponent['status'] }}</span>
                    </div>
                    <h2 class="ui-card-title mt-2">{{ $catalogComponent['label'] }}</h2>
                    <p class="ui-card-copy mt-2">{{ $catalogComponent['purpose'] }}</p>
                    <p class="mt-4 text-sm leading-6" style="color: var(--ui-text-secondary);">{{ $catalogComponent['current_decision'] }}</p>
                </div>
                <aside class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-component-section="implementation-status">
                    <p class="ui-kicker">Implementation status</p>
                    <dl class="mt-3 space-y-3 text-sm">
                        <div>
                            <dt style="color: var(--ui-text-helper);">Category</dt>
                            <dd class="mt-1 font-semibold" style="color: var(--ui-text-primary);">{{ $catalogComponent['category'] }}</dd>
                        </div>
                        <div>
                            <dt style="color: var(--ui-text-helper);">Source ownership</dt>
                            <dd class="mt-1 break-all font-semibold" style="color: var(--ui-text-primary);">{{ $catalogComponent['source_owner'] }}</dd>
                        </div>
                        <div>
                            <dt style="color: var(--ui-text-helper);">Canonical doc</dt>
                            <dd class="mt-1 break-all font-semibold">
                                <a wire:navigate href="{{ route('platform.docs.index', ['path' => $catalogComponent['doc_path']]) }}" class="ui-link">{{ $catalogComponent['doc_path'] }}</a>
                            </dd>
                        </div>
                    </dl>
                    <p class="mt-4 text-xs leading-5" style="color: var(--ui-text-helper);">{{ $catalogComponent['carbon_parity_note'] }}</p>
                    @if (filled($catalogComponent['feature_flag_note'] ?? null))
                        <p class="mt-3 text-xs leading-5" style="color: var(--ui-text-helper);">{{ $catalogComponent['feature_flag_note'] }}</p>
                    @endif
                </aside>
            </div>
        </section>

        <section class="ui-card" data-component-card="use-cases">
            <p class="ui-kicker">Usage boundary</p>
            <h2 class="ui-card-title mt-2">Use cases</h2>
            <div class="mt-5 grid gap-4 xl:grid-cols-2">
                <article class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-component-section="use-when">
                    <h3 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Use when</h3>
                    <ul class="mt-3 space-y-2 text-sm leading-6" style="color: var(--ui-text-secondary);">
                        @foreach ($catalogComponent['use_when'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </article>
                <article class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-component-section="do-not-use-when">
                    <h3 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Do not use when</h3>
                    <ul class="mt-3 space-y-2 text-sm leading-6" style="color: var(--ui-text-secondary);">
                        @foreach ($catalogComponent['do_not_use_when'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </article>
            </div>
        </section>

        <section class="ui-card" data-component-card="component-contract">
            <p class="ui-kicker">Implementation rules</p>
            <h2 class="ui-card-title mt-2">Component contract</h2>
            <p class="ui-card-copy mt-2">Use these requirements when building, reviewing, or composing this component.</p>

            <div class="mt-5 grid gap-4 xl:grid-cols-2">
                <article class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-component-section="anatomy">
                    <h3 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Anatomy</h3>
                    <ul class="mt-3 space-y-2 text-sm leading-6" style="color: var(--ui-text-secondary);">
                        @foreach ($catalogComponent['anatomy'] as $part)
                            <li>{{ $part }}</li>
                        @endforeach
                    </ul>
                </article>
                <article class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-component-section="states">
                    <h3 class="text-sm font-semibold" style="color: var(--ui-text-primary);">States</h3>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach ($catalogComponent['states'] as $state)
                            <span class="inline-flex items-center whitespace-nowrap rounded-full border px-2.5 py-1 text-xs font-semibold" style="border-color: var(--ui-border-subtle-01); color: var(--ui-text-secondary); background-color: var(--ui-layer-01);">{{ $state }}</span>
                        @endforeach
                    </div>
                </article>
            </div>

            <div class="mt-4 grid gap-4 xl:grid-cols-2">
                <article class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-component-section="behavior">
                    <h3 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Behavior</h3>
                    <ul class="mt-3 space-y-2 text-sm leading-6" style="color: var(--ui-text-secondary);">
                        @foreach ($catalogComponent['behavior'] as $behavior)
                            <li>{{ $behavior }}</li>
                        @endforeach
                    </ul>
                </article>
                <article class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-component-section="developer-implementation">
                    <h3 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Developer implementation</h3>
                    <dl class="mt-3 space-y-3 text-sm">
                        @foreach ($catalogComponent['developer_api'] as $term => $value)
                            <div>
                                <dt style="color: var(--ui-text-helper);">{{ Str::headline($term) }}</dt>
                                <dd class="mt-1 font-medium" style="color: var(--ui-text-primary);">
                                    @if ($term === 'example')
                                        @php
                                            $developerExampleMarkup = $catalogComponent['developer_api_example_markup'] ?? ($slug === 'accordion' ? '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.accordion</span> <span class="ui-code-token-property">:items</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"$items"</span> <span class="ui-code-token-punctuation">/&gt;</span>' : null);
                                        @endphp
                                        <pre class="ui-code-snippet mt-2" data-component-section="developer-code-example"><code>{!! $developerExampleMarkup ?? e($value) !!}</code></pre>
                                    @else
                                        <span class="break-words">{{ $value }}</span>
                                    @endif
                                </dd>
                            </div>
                        @endforeach
                    </dl>
                    <div class="mt-4" data-component-section="foundation-elements-used">
                        <p class="text-xs font-semibold uppercase tracking-[0.14em]" style="color: var(--ui-text-helper);">Foundation Elements used</p>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @foreach ($catalogComponent['foundation_elements'] as $element)
                                <a wire:navigate href="{{ $element['href'] }}" class="ui-link text-xs font-semibold">{{ $element['label'] }}</a>
                            @endforeach
                        </div>
                    </div>
                </article>
                <article class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-component-section="content-guidance">
                    <h3 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Content guidance</h3>
                    <ul class="mt-3 space-y-2 text-sm leading-6" style="color: var(--ui-text-secondary);">
                        @foreach ($catalogComponent['content_guidance'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </article>
                <article class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-component-section="accessibility">
                    <h3 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Accessibility requirements</h3>
                    <ul class="mt-3 space-y-2 text-sm leading-6" style="color: var(--ui-text-secondary);">
                        @foreach ($catalogComponent['accessibility'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </article>
            </div>
        </section>

        <section class="ui-card" data-component-card="live-examples" data-component-section="live-examples">
            <div class="flex flex-col gap-2 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="ui-kicker">Rendered scenarios</p>
                    <h2 class="ui-card-title mt-2">Live examples</h2>
                    <p class="ui-card-copy mt-2">Each tab is a base usage scenario. Variants are shown inside the scenario they affect.</p>
                </div>
                <span class="inline-flex items-center whitespace-nowrap rounded-full border px-2.5 py-1 text-xs font-semibold" style="border-color: var(--ui-border-subtle-01); color: var(--ui-text-secondary);">{{ $catalogComponent['status'] }}</span>
            </div>

            @if (filled($catalogComponent['live_examples_view'] ?? null) && view()->exists($catalogComponent['live_examples_view']))
                <div class="mt-5" data-ui-reference-live-examples-layout="{{ $catalogComponent['live_examples_layout'] ?? 'custom' }}">
                    @include($catalogComponent['live_examples_view'], ['catalogComponent' => $catalogComponent])
                </div>
            @else
            <div class="mt-5" data-ui-reference-tabs data-ui-reference-component-tabs="{{ $slug }}">
                <div class="flex flex-wrap gap-2" role="tablist" aria-label="{{ $catalogComponent['label'] }} live examples">
                    @foreach ($examples as $example)
                        @php
                            $tabId = $slug.'-'.$example['id'].'-tab';
                            $panelId = $slug.'-'.$example['id'].'-panel';
                        @endphp
                        <button
                            id="{{ $tabId }}"
                            type="button"
                            class="ui-reference-tab"
                            role="tab"
                            aria-selected="{{ $example['id'] === $firstExample ? 'true' : 'false' }}"
                            aria-controls="{{ $panelId }}"
                            tabindex="{{ $example['id'] === $firstExample ? '0' : '-1' }}"
                            data-ui-reference-live-example-tab="{{ $example['id'] }}"
                        >
                            {{ $example['title'] }}
                        </button>
                    @endforeach
                </div>

                @foreach ($examples as $example)
                    @php
                        $tabId = $slug.'-'.$example['id'].'-tab';
                        $panelId = $slug.'-'.$example['id'].'-panel';
                    @endphp
                    <article
                        id="{{ $panelId }}"
                        class="mt-5 rounded-lg border p-4"
                        style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);"
                        role="tabpanel"
                        aria-labelledby="{{ $tabId }}"
                        data-ui-reference-live-example-panel="{{ $example['id'] }}"
                        @if ($example['id'] !== $firstExample) hidden @endif
                    >
                        <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_minmax(18rem,0.45fr)]">
                            <div>
                                <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">{{ $example['title'] }}</h3>
                                <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">{{ $example['description'] }}</p>
                            </div>
                            @if (! empty($example['context_notes']))
                                <aside class="rounded-lg border p-3" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);">
                                    <p class="text-xs font-semibold uppercase tracking-[0.14em]" style="color: var(--ui-text-helper);">Context notes</p>
                                    <ul class="mt-2 space-y-2 text-sm leading-5" style="color: var(--ui-text-secondary);">
                                        @foreach ($example['context_notes'] as $note)
                                            <li>{{ $note }}</li>
                                        @endforeach
                                    </ul>
                                </aside>
                            @endif
                        </div>

                        <div class="mt-5" data-ui-reference-live-example="{{ $example['id'] }}">
                            @if (filled($example['view'] ?? null) && view()->exists($example['view']))
                                @include($example['view'])
                            @elseif (! empty($example['sample'] ?? null))
                                @include('platform.ui-reference.components.examples.sample', ['sample' => $example['sample']])
                            @else
                                <div class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);">
                                    <p class="text-sm font-semibold" style="color: var(--ui-text-primary);">Component-specific correction pending</p>
                                    <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">{{ $example['description'] }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="mt-5 rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-component-section="variants-for-example">
                            <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Variants for this example</h4>
                            <div class="mt-3 grid gap-3 md:grid-cols-2">
                                @foreach ($example['variants'] ?? [] as $variant)
                                    <div
                                        @class([
                                            'rounded-md border p-3',
                                            'md:col-span-2' => (($variant['sample']['type'] ?? null) === 'breadcrumb'),
                                        ])
                                        style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);"
                                    >
                                        <div class="flex flex-wrap items-center gap-2">
                                            <p class="text-sm font-semibold" style="color: var(--ui-text-primary);">{{ $variant['label'] }}</p>
                                            <span class="inline-flex items-center whitespace-nowrap rounded-full border px-2 py-0.5 text-[0.68rem] font-semibold" style="border-color: var(--ui-border-subtle-01); color: var(--ui-text-secondary);">{{ $variant['status'] ?? 'Supported' }}</span>
                                        </div>
                                        @if (filled($variant['view'] ?? null) && view()->exists($variant['view']))
                                            <div class="mt-3" data-ui-reference-variant-example="{{ Str::slug($variant['label']) }}">
                                                @include($variant['view'])
                                            </div>
                                        @elseif (! empty($variant['sample'] ?? null))
                                            <div class="mt-3" data-ui-reference-variant-example="{{ Str::slug($variant['label']) }}">
                                                @include('platform.ui-reference.components.examples.sample', ['sample' => $variant['sample']])
                                            </div>
                                        @endif
                                        @if (filled($variant['notes'] ?? null))
                                            <p class="mt-2 text-xs leading-5" style="color: var(--ui-text-helper);">{{ $variant['notes'] }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            @endif
        </section>

        <section class="ui-card" data-component-card="related-components-and-patterns" data-component-section="related-components-and-patterns">
            <p class="ui-kicker">Composition links</p>
            <h2 class="ui-card-title mt-2">Related components and patterns</h2>
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach ($catalogComponent['related'] as $related)
                    <a wire:navigate href="{{ $related['href'] }}" class="rounded-full border px-3 py-1.5 text-xs font-semibold transition" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02); color: var(--ui-text-secondary);">{{ $related['label'] }}</a>
                @endforeach
            </div>
        </section>
    </section>
</x-layouts.app>
