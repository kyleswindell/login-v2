@php
    $examples = $catalogComponent['live_examples'] ?? [];
@endphp

<div class="space-y-6" data-component-live-layout="menu-matrix">
    @foreach ($examples as $example)
        <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-menu-live-section="{{ $example['id'] }}">
            <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">{{ $example['title'] }}</h3>
            <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">{{ $example['description'] }}</p>
            @if (! empty($example['context_notes']))
                <ul class="mt-3 space-y-1 text-xs leading-5" style="color: var(--ui-text-helper);">
                    @foreach ($example['context_notes'] as $note)
                        <li>{{ $note }}</li>
                    @endforeach
                </ul>
            @endif

            <div class="mt-4">
                @include('platform.ui-reference.components.live-examples.partials.menu-proof', ['sample' => $example['sample'] ?? []])
            </div>

            @if (! empty($example['variants']))
                <div class="mt-5 grid gap-3 xl:grid-cols-2">
                    @foreach ($example['variants'] as $variant)
                        <article class="min-w-0 rounded-md border p-3" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-menu-live-variant="{{ Str::slug($variant['label']) }}">
                            <div class="mb-3 flex flex-wrap items-center gap-2">
                                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">{{ $variant['label'] }}</h4>
                                <span class="inline-flex items-center rounded-full border px-2 py-0.5 text-[0.68rem] font-semibold" style="border-color: var(--ui-border-subtle-01); color: var(--ui-text-secondary);">{{ $variant['status'] ?? 'Supported' }}</span>
                            </div>
                            @include('platform.ui-reference.components.live-examples.partials.menu-proof', ['sample' => $variant['sample'] ?? []])
                            @if (filled($variant['notes'] ?? null))
                                <p class="mt-2 text-xs leading-5" style="color: var(--ui-text-helper);">{{ $variant['notes'] }}</p>
                            @endif
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    @endforeach
</div>
