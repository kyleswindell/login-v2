<x-layouts.app :title="'UI Reference - Color Token Palette'">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'elements.color.tokens'])
    </x-slot:sidebar>

    <section class="flex min-w-0 flex-1 flex-col gap-6" data-ui-reference-foundation-element="color" data-ui-reference-color-token-palette>
        <div>
            <p class="ui-kicker">Foundation Element - Color</p>
            <h1 class="ui-page-header-title">Color Token Palette</h1>
            <p class="ui-page-header-copy">Token role coverage for Login App 2.0, separated from the Color Overview so the token matrix can stay reviewable and complete.</p>
        </div>

        <section class="ui-card" data-color-token-section="inventory-map">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <h2 class="ui-card-title">Color Token Inventory</h2>
                    <p class="ui-card-copy mt-2">Every color-token family is mapped to a Login App disposition. Token values are evaluated for contrast, hierarchy, layer depth, state behavior, and semantic clarity.</p>
                </div>
                <a wire:navigate href="{{ route('platform.ui-reference.elements.show', ['element' => 'color']) }}" class="ui-link">Back to Color Overview</a>
            </div>

            <div class="mt-5 overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-subtle-01); background: var(--ui-layer-01);">
                <table class="w-full min-w-[1040px] table-fixed divide-y" style="border-color: var(--ui-border-subtle-01);">
                    <colgroup>
                        <col class="w-[12rem]">
                        <col class="w-[13rem]">
                        <col class="w-[13rem]">
                        <col class="w-[18rem]">
                        <col>
                    </colgroup>
                    <thead style="background: var(--ui-layer-accent-01);">
                        <tr class="text-left text-xs uppercase tracking-[0.18em]" style="color: var(--ui-text-helper);">
                            <th class="px-4 py-3">Login Family</th>
                            <th class="px-4 py-3">Reference Family</th>
                            <th class="px-4 py-3">Disposition</th>
                            <th class="px-4 py-3">Owner</th>
                            <th class="px-4 py-3">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y text-sm" style="border-color: var(--ui-border-subtle-01); color: var(--ui-text-secondary);">
                        @foreach ($tokenInventory as $item)
                            <tr data-color-token-inventory-family="{{ Str::slug($item['family']) }}">
                                <td class="px-4 py-3 font-semibold" style="color: var(--ui-text-primary);">{{ $item['family'] }}</td>
                                <td class="px-4 py-3">{{ $item['carbon_family'] }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center whitespace-nowrap rounded-full border px-2.5 py-1 text-xs font-semibold" style="border-color: var(--ui-border-strong-01); color: var(--ui-text-primary);">{{ $item['disposition'] }}</span>
                                </td>
                                <td class="px-4 py-3 font-mono text-xs">{{ $item['owner'] }}</td>
                                <td class="px-4 py-3">{{ $item['notes'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        @foreach ($tokenFamilies as $family)
            <section id="{{ $family['slug'] }}" class="ui-card scroll-mt-24" data-color-token-section="{{ $family['slug'] }}" data-color-token-family="{{ $family['slug'] }}">
                <h2 class="ui-card-title">{{ $family['label'] }}</h2>
                <p class="ui-card-copy mt-2">{{ $family['summary'] }}</p>

                <div class="mt-5 overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-subtle-01); background: var(--ui-layer-01);">
                    <table class="w-full min-w-[1120px] table-fixed divide-y" style="border-color: var(--ui-border-subtle-01);">
                        <colgroup>
                            <col class="w-[9rem]">
                            <col class="w-[13rem]">
                            <col class="w-[17rem]">
                            <col class="w-[14rem]">
                            <col class="w-[14rem]">
                            <col class="w-[11rem]">
                            <col>
                        </colgroup>
                        <thead style="background: var(--ui-layer-accent-01);">
                            <tr class="text-left text-xs uppercase tracking-[0.18em]" style="color: var(--ui-text-helper);">
                                <th class="px-4 py-3">Family</th>
                                <th class="px-4 py-3">Role</th>
                                <th class="px-4 py-3">CSS Variable</th>
                                <th class="px-4 py-3">Light Value</th>
                                <th class="px-4 py-3">Dark Value</th>
                                <th class="px-4 py-3">Swatches</th>
                                <th class="px-4 py-3">Role Notes</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y text-sm" style="border-color: var(--ui-border-subtle-01); color: var(--ui-text-secondary);">
                            @foreach ($family['rows'] as $row)
                                <tr data-color-token-variable="{{ $row['variable'] }}">
                                    <td class="px-4 py-3 font-semibold" style="color: var(--ui-text-primary);">{{ $row['family'] }}</td>
                                    <td class="px-4 py-3">{{ $row['role'] }}</td>
                                    <td class="px-4 py-3 font-mono text-xs" style="color: var(--ui-text-primary);">{{ $row['variable'] }}</td>
                                    <td class="px-4 py-3 font-mono text-xs">{{ $row['light'] }}</td>
                                    <td class="px-4 py-3 font-mono text-xs">{{ $row['dark'] }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex gap-2">
                                            <span class="h-8 w-8 rounded border" style="border-color: var(--ui-border-strong-01); background: {{ $row['light'] }};" aria-label="Light value swatch"></span>
                                            <span class="h-8 w-8 rounded border" style="border-color: var(--ui-border-strong-01); background: {{ $row['dark'] }};" aria-label="Dark value swatch"></span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">{{ $row['comparison'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endforeach

        <section id="component-ai-disposition" class="ui-card scroll-mt-24" data-color-token-section="component-ai-disposition">
            <h2 class="ui-card-title">Component And AI Token Disposition</h2>
            <div class="mt-5 grid gap-4 xl:grid-cols-2">
                <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-layer-01); color: var(--ui-text-primary);">
                    <p class="text-sm font-semibold">Component tokens</p>
                    <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Login App currently uses T1 component classes backed by role tokens. A separate component-token layer is queued only if component-specific overrides become too complex for role tokens.</p>
                </article>
                <article class="rounded-lg border p-4" style="border-color: var(--ui-border-default); background: var(--ui-layer-01); color: var(--ui-text-primary);">
                    <p class="text-sm font-semibold">AI tokens</p>
                    <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">AI color roles are not applicable until an AI feature or decision record defines the product semantics and required disclosure states.</p>
                </article>
            </div>
        </section>

        <section class="ui-card" data-color-token-section="related-links">
            <h2 class="ui-card-title">Related Implementation Links</h2>
            <div class="mt-4 flex flex-wrap gap-3">
                @foreach ($relatedLinks as $link)
                    @continue(str_contains($link['label'], 'Carbon') || str_contains($link['href'], 'carbondesignsystem.com'))
                    <a wire:navigate href="{{ $link['href'] }}" class="ui-link">{{ $link['label'] }}</a>
                @endforeach
            </div>
        </section>
    </section>
</x-layouts.app>
