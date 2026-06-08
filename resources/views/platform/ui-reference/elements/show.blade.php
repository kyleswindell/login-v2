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
                            <span class="rounded-full border px-3 py-1 text-xs font-semibold" style="border-color: var(--ui-border-strong-01); background: var(--ui-layer-02); color: var(--ui-text-primary);">{{ $example }}</span>
                        @endforeach
                    </div>
                </div>
                <aside class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background: var(--ui-layer-01);" data-foundation-section="implementation-status">
                    <p class="ui-kicker">Guide Status</p>
                    <p class="mt-3 text-2xl font-semibold" style="color: var(--ui-text-primary);">{{ $catalogElement['guide_status'] }}</p>
                    <p class="mt-3 text-xs font-semibold uppercase tracking-[0.16em]" style="color: var(--ui-text-helper);">System Maturity</p>
                    <p class="mt-1 text-sm font-semibold" style="color: var(--ui-text-secondary);">{{ $catalogElement['system_status'] }}</p>
                    <a wire:navigate href="{{ route('platform.docs.index', ['path' => $catalogElement['doc_path']]) }}" class="ui-link mt-3 inline-flex">Open canonical doc</a>
                    <p class="mt-3 break-all text-xs" style="color: var(--ui-text-helper);">{{ $catalogElement['doc_path'] }}</p>
                </aside>
            </div>
        </section>

        <section data-foundation-section="live-examples">
            @include($examplePartial, ['element' => $catalogElement])
        </section>

        <section class="ui-card" data-foundation-section="token-class-api-reference">
            <h2 class="ui-card-title">Token / Class / API Reference</h2>
            <p class="ui-card-copy mt-2">Use these app-owned tokens, CSS variables, helpers, utilities, or components when building this primitive. Token names are labels beside rendered examples, not substitutes for rendering the final UI.</p>
            <div class="mt-5 w-full max-w-full overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-subtle-01); background: var(--ui-layer-01);">
                <table class="w-full table-auto divide-y lg:min-w-[920px] lg:table-fixed" style="border-color: var(--ui-border-subtle-01);">
                    <colgroup>
                        <col class="lg:w-[13rem]">
                        <col class="lg:w-[19rem]">
                        <col class="lg:w-[18rem]">
                        <col>
                    </colgroup>
                    <thead style="background: var(--ui-layer-accent-01);">
                        <tr class="text-left text-xs uppercase tracking-[0.18em]" style="color: var(--ui-text-helper);">
                            <th class="px-4 py-3">Token / Role</th>
                            <th class="px-4 py-3">Variable</th>
                            <th class="px-4 py-3">Class / Helper / API</th>
                            <th class="px-4 py-3">Example Usage</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y text-sm" style="border-color: var(--ui-border-subtle-01); color: var(--ui-text-secondary);">
                        @foreach ($catalogElement['token_reference'] as $reference)
                            <tr>
                                <td class="px-4 py-3 font-semibold" style="color: var(--ui-text-primary);">{{ $reference['name'] }}</td>
                                <td class="px-4 py-3 font-mono text-xs" style="color: var(--ui-text-secondary);">{{ $reference['variable'] }}</td>
                                <td class="px-4 py-3">{{ $reference['api'] }}</td>
                                <td class="px-4 py-3 font-mono text-xs" style="color: var(--ui-text-secondary);">{{ $reference['example'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section class="grid gap-4 xl:grid-cols-3">
            <article class="ui-card" data-foundation-section="usage-guidance">
                <h2 class="ui-card-title">Usage Guidance</h2>
                <ul class="mt-4 space-y-3 text-sm" style="color: var(--ui-text-secondary);">
                    @foreach ($catalogElement['usage_guidance'] as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </article>

            <article class="ui-card" data-foundation-section="accessibility-notes">
                <h2 class="ui-card-title">Accessibility Notes</h2>
                <ul class="mt-4 space-y-3 text-sm" style="color: var(--ui-text-secondary);">
                    @foreach ($catalogElement['accessibility_notes'] as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </article>

            <article class="ui-card" data-foundation-section="developer-notes">
                <h2 class="ui-card-title">Developer Notes</h2>
                <ul class="mt-4 space-y-3 text-sm" style="color: var(--ui-text-secondary);">
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
                            @continue(str_contains($link['label'], 'Carbon') || str_contains($link['href'], 'carbondesignsystem.com'))
                            <a wire:navigate href="{{ $link['href'] }}" class="ui-link">{{ $link['label'] }}</a>
                        @endforeach
                    </div>
                </div>
                <aside class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background: var(--ui-layer-01);">
                    <p class="ui-kicker">Standard Reference Notes</p>
                    <p class="mt-3 text-sm" style="color: var(--ui-text-secondary);">This page defines the current Login App expectation for {{ $catalogElement['label'] }}. Use the visible examples, canonical doc, and related implementation links as the app standard.</p>
                </aside>
            </div>
        </section>
    </section>
</x-layouts.app>
