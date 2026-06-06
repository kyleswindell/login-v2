<x-layouts.app :title="'UI Reference - '.$catalogElement['label']">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'elements.'.$catalogElement['slug']])
    </x-slot:sidebar>

    @php
        $slug = $catalogElement['slug'];
        $examplePartial = 'platform.ui-reference.elements.examples.'.$slug;
    @endphp

    <section class="flex min-w-0 flex-1 flex-col gap-6" data-ui-reference-foundation-element="{{ $slug }}" data-ui-reference-element-disposition="{{ $catalogElement['guide_status'] }}" data-ui-reference-element-system-status="{{ $catalogElement['system_status'] }}">
        <div>
            <p class="ui-kicker">Foundation Element - {{ $catalogElement['guide_status'] }}</p>
            <h1 class="ui-page-header-title">{{ $catalogElement['label'] }}</h1>
            <p class="ui-page-header-copy">{{ $catalogElement['summary'] }}</p>
        </div>

        <section class="ui-card" data-foundation-section="purpose">
            <div class="grid gap-5 xl:grid-cols-[minmax(0,1.35fr)_minmax(18rem,0.65fr)]">
                <div>
                    <h2 class="ui-card-title">Purpose</h2>
                    <p class="ui-card-copy mt-2">{{ $catalogElement['purpose'] }}</p>
                    <div class="mt-4 flex flex-wrap gap-2" aria-label="Required live example coverage">
                        @foreach ($catalogElement['live_examples'] as $example)
                            <span class="rounded-full border border-slate-700 bg-slate-950 px-3 py-1 text-xs font-semibold text-slate-300">{{ $example }}</span>
                        @endforeach
                    </div>
                </div>
                <aside class="rounded-lg border border-slate-800 bg-slate-950/70 p-4" data-foundation-section="implementation-status">
                    <p class="ui-kicker">Guide Status</p>
                    <p class="mt-3 text-2xl font-semibold text-white">{{ $catalogElement['guide_status'] }}</p>
                    <p class="mt-3 text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">System Maturity</p>
                    <p class="mt-1 text-sm font-semibold text-slate-300">{{ $catalogElement['system_status'] }}</p>
                    <a wire:navigate href="{{ route('platform.docs.index', ['path' => $catalogElement['doc_path']]) }}" class="ui-link mt-3 inline-flex">Open canonical doc</a>
                    <p class="mt-3 break-all text-xs text-slate-500">{{ $catalogElement['doc_path'] }}</p>
                </aside>
            </div>
        </section>

        <section data-foundation-section="live-examples">
            @include($examplePartial, ['element' => $catalogElement])
        </section>

        <section class="ui-card" data-foundation-section="token-class-api-reference">
            <h2 class="ui-card-title">Token / Class / API Reference</h2>
            <p class="ui-card-copy mt-2">Use these app-owned tokens, CSS variables, helpers, utilities, or components when building this primitive. Token names are labels beside rendered examples, not substitutes for rendering the final UI.</p>
            <div class="mt-5 w-full max-w-full overflow-x-auto rounded-lg border border-slate-800 bg-slate-950/60">
                <table class="w-full table-auto divide-y divide-slate-800 lg:min-w-[920px] lg:table-fixed">
                    <colgroup>
                        <col class="lg:w-[13rem]">
                        <col class="lg:w-[19rem]">
                        <col class="lg:w-[18rem]">
                        <col>
                    </colgroup>
                    <thead class="bg-slate-900">
                        <tr class="text-left text-xs uppercase tracking-[0.18em] text-slate-500">
                            <th class="px-4 py-3">Token / Role</th>
                            <th class="px-4 py-3">Variable</th>
                            <th class="px-4 py-3">Class / Helper / API</th>
                            <th class="px-4 py-3">Example Usage</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 text-sm text-slate-300">
                        @foreach ($catalogElement['token_reference'] as $reference)
                            <tr>
                                <td class="px-4 py-3 font-semibold text-white">{{ $reference['name'] }}</td>
                                <td class="px-4 py-3 font-mono text-xs text-slate-300">{{ $reference['variable'] }}</td>
                                <td class="px-4 py-3">{{ $reference['api'] }}</td>
                                <td class="px-4 py-3 font-mono text-xs text-slate-300">{{ $reference['example'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section class="grid gap-4 xl:grid-cols-3">
            <article class="ui-card" data-foundation-section="usage-guidance">
                <h2 class="ui-card-title">Usage Guidance</h2>
                <ul class="mt-4 space-y-3 text-sm text-slate-300">
                    @foreach ($catalogElement['usage_guidance'] as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </article>

            <article class="ui-card" data-foundation-section="accessibility-notes">
                <h2 class="ui-card-title">Accessibility Notes</h2>
                <ul class="mt-4 space-y-3 text-sm text-slate-300">
                    @foreach ($catalogElement['accessibility_notes'] as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </article>

            <article class="ui-card" data-foundation-section="developer-notes">
                <h2 class="ui-card-title">Developer Notes</h2>
                <ul class="mt-4 space-y-3 text-sm text-slate-300">
                    @foreach ($catalogElement['developer_notes'] as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </article>
        </section>

        <section class="ui-card" data-foundation-section="related-implementation-links">
            <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_minmax(20rem,0.8fr)]">
                <div>
                    <h2 class="ui-card-title">Related Implementation Links</h2>
                    <div class="mt-4 flex flex-wrap gap-3">
                        @foreach ($catalogElement['related_links'] as $link)
                            <a wire:navigate href="{{ $link['href'] }}" class="ui-link">{{ $link['label'] }}</a>
                        @endforeach
                    </div>
                </div>
                <aside class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                    <p class="ui-kicker">Carbon Source Reference</p>
                    <p class="mt-3 text-sm text-slate-300">{{ $catalogElement['carbon_comparison'] }}</p>
                </aside>
            </div>
        </section>
    </section>
</x-layouts.app>
