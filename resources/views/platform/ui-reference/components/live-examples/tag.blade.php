@php
    $tagColors = [
        ['label' => 'Gray', 'color' => 'gray'],
        ['label' => 'Cool gray', 'color' => 'cool-gray'],
        ['label' => 'Warm gray', 'color' => 'warm-gray'],
        ['label' => 'Red', 'color' => 'red'],
        ['label' => 'Magenta', 'color' => 'magenta'],
        ['label' => 'Purple', 'color' => 'purple'],
        ['label' => 'Blue', 'color' => 'blue'],
        ['label' => 'Cyan', 'color' => 'cyan'],
        ['label' => 'Teal', 'color' => 'teal'],
        ['label' => 'Green', 'color' => 'green'],
    ];

    $sections = [
        ['id' => 'variant-family', 'title' => 'Variants'],
        ['id' => 'sizes-and-anatomy', 'title' => 'Sizes and anatomy'],
        ['id' => 'color-token-matrix', 'title' => 'Color token matrix'],
        ['id' => 'interactive-states', 'title' => 'Interactive states'],
        ['id' => 'overflow-tooltips', 'title' => 'Overflow and tooltips'],
        ['id' => 'tag-groups', 'title' => 'Tag groups'],
        ['id' => 'tag-related-apis', 'title' => 'Tag versus related APIs'],
    ];

    $boundaryRows = [
        ['Tag', 'Compact metadata, filters, selectable choices, and overflow tag disclosure.', '<x-ui.tag variant="dismissible">Region</x-ui.tag>', 'Canonical component'],
        ['Badge / Status', 'Legacy taxonomy helper only where existing status wrappers remain.', '<x-ui.badge status="pending review" />', 'Related transitional API'],
        ['Notification', 'Explanatory feedback that needs message content or recovery guidance.', '<x-ui.inline-alert semantic="danger">...</x-ui.inline-alert>', 'Separate component'],
        ['Button / Menu button', 'Commands, action groups, and menus.', '<x-ui.button>Save</x-ui.button>', 'Use owning action API'],
    ];
@endphp

<div class="space-y-6" data-component-live-layout="tag-matrix" data-ui-reference-sample-type="tags">
    <nav class="flex flex-wrap gap-2" aria-label="Tag example sections">
        @foreach ($sections as $section)
            <a class="ui-link text-sm" href="#tag-{{ $section['id'] }}">{{ $section['title'] }}</a>
        @endforeach
    </nav>

    <section id="tag-variant-family" class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tag-live-section="variant-family">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Variants</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Tag is the canonical component family for read-only labels, dismissible filters, selectable choices, and operational overflow disclosure.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Read-only</h4>
                <div class="mt-4 flex flex-wrap gap-2">
                    <x-ui.tag color="gray">Internal</x-ui.tag>
                    <x-ui.tag color="green" icon="heroicon-o-check-circle">Verified</x-ui.tag>
                    <x-ui.tag color="blue" disabled>Disabled label</x-ui.tag>
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Dismissible</h4>
                <div class="mt-4 flex flex-wrap gap-2">
                    <x-ui.tag variant="dismissible" color="blue" remove-label="Remove region filter">Region</x-ui.tag>
                    <x-ui.tag variant="dismissible" color="purple" icon="heroicon-o-sparkles" remove-label="Remove AI filter">AI assisted</x-ui.tag>
                    <x-ui.tag variant="dismissible" color="gray" remove-label="Remove disabled filter" disabled>Disabled</x-ui.tag>
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Selectable</h4>
                <div class="mt-4 flex flex-wrap gap-2">
                    <x-ui.tag variant="selectable">Unselected</x-ui.tag>
                    <x-ui.tag variant="selectable" selected>Selected</x-ui.tag>
                    <x-ui.tag variant="selectable" icon="heroicon-o-user-group">Teams</x-ui.tag>
                    <x-ui.tag variant="selectable" disabled>Disabled</x-ui.tag>
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Operational</h4>
                <div class="mt-4 flex flex-wrap items-start gap-3">
                    <x-ui.tag variant="operational" color="teal">More tags</x-ui.tag>
                    <details class="ui-tag-disclosure">
                        <summary class="ui-tag ui-tag-operational ui-tag-color-teal ui-tag-md" data-ui-component="tag" data-ui-tag-variant="operational" data-ui-tag-color="teal">
                            <span class="ui-tag-label">Overflow tags</span>
                            <x-heroicon-o-chevron-down class="ui-tag-action-icon" aria-hidden="true" />
                        </summary>
                        <div class="ui-tag-disclosure-panel">
                            <x-ui.tag color="teal" size="sm">Finance</x-ui.tag>
                            <x-ui.tag color="teal" size="sm">Legal</x-ui.tag>
                            <x-ui.tag color="teal" size="sm">Security</x-ui.tag>
                        </div>
                    </details>
                    <x-ui.tag variant="operational" color="teal" disabled>Disabled</x-ui.tag>
                </div>
            </article>
        </div>
    </section>

    <section id="tag-sizes-and-anatomy" class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tag-live-section="sizes-and-anatomy">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Sizes and anatomy</h3>
        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Small, medium, large</h4>
                <div class="mt-4 flex flex-wrap items-center gap-2">
                    <x-ui.tag size="sm">Small tag</x-ui.tag>
                    <x-ui.tag size="md" icon="heroicon-o-information-circle">Medium tag</x-ui.tag>
                    <x-ui.tag size="lg" icon="heroicon-o-check-circle">Large tag</x-ui.tag>
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Variant anatomy</h4>
                <div class="mt-4 flex flex-wrap gap-2">
                    <x-ui.tag color="cool-gray" icon="heroicon-o-tag">Icon label</x-ui.tag>
                    <x-ui.tag variant="dismissible" color="magenta" icon="heroicon-o-tag" remove-label="Remove campaign">Campaign</x-ui.tag>
                    <x-ui.tag variant="selectable" selected>Selectable border</x-ui.tag>
                    <x-ui.tag variant="operational" color="cyan">Operational border</x-ui.tag>
                </div>
            </article>
        </div>
    </section>

    <section id="tag-color-token-matrix" class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tag-live-section="color-token-matrix">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Color token matrix</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Read-only, dismissible, and operational tags use component tag color tokens. Selectable tags are shown separately because they use core tokens only.</p>
        <div class="mt-4 grid gap-4 xl:grid-cols-3">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Read-only colors</h4>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($tagColors as $tag)
                        <x-ui.tag :color="$tag['color']">{{ $tag['label'] }}</x-ui.tag>
                    @endforeach
                    <x-ui.tag color="high-contrast">High contrast</x-ui.tag>
                    <x-ui.tag color="outline">Outline</x-ui.tag>
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Dismissible colors</h4>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($tagColors as $tag)
                        <x-ui.tag variant="dismissible" :color="$tag['color']" remove-label="Remove {{ $tag['label'] }}">{{ $tag['label'] }}</x-ui.tag>
                    @endforeach
                    <x-ui.tag variant="dismissible" color="high-contrast" remove-label="Remove high contrast">High contrast</x-ui.tag>
                    <x-ui.tag variant="dismissible" color="outline" remove-label="Remove outline">Outline</x-ui.tag>
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Operational colors</h4>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($tagColors as $tag)
                        <x-ui.tag variant="operational" :color="$tag['color']">{{ $tag['label'] }}</x-ui.tag>
                    @endforeach
                    <x-ui.tag variant="operational" color="high-contrast">High contrast</x-ui.tag>
                    <x-ui.tag variant="operational" color="outline">Outline</x-ui.tag>
                </div>
            </article>
        </div>
    </section>

    <section id="tag-interactive-states" class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tag-live-section="interactive-states">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Interactive states</h3>
        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Dismissible and operational</h4>
                <div class="mt-4 flex flex-wrap gap-2">
                    <x-ui.tag variant="dismissible" color="red" remove-label="Remove hover proof">Dismissible hover</x-ui.tag>
                    <x-ui.tag variant="dismissible" color="red" remove-label="Remove focus proof" class="ui-reference-force-focus">Dismissible focus</x-ui.tag>
                    <x-ui.tag variant="dismissible" color="red" remove-label="Remove disabled proof" disabled>Dismissible disabled</x-ui.tag>
                    <x-ui.tag variant="operational" color="blue">Operational hover</x-ui.tag>
                    <x-ui.tag variant="operational" color="blue" class="ui-reference-force-focus">Operational focus</x-ui.tag>
                    <x-ui.tag variant="operational" color="blue" disabled>Operational disabled</x-ui.tag>
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Selectable and skeleton</h4>
                <div class="mt-4 flex flex-wrap gap-2">
                    <x-ui.tag variant="selectable">Selectable hover</x-ui.tag>
                    <x-ui.tag variant="selectable" class="ui-reference-force-focus">Selectable focus</x-ui.tag>
                    <x-ui.tag variant="selectable" selected>Selectable selected</x-ui.tag>
                    <x-ui.tag variant="selectable" disabled>Selectable disabled</x-ui.tag>
                    <x-ui.tag skeleton>Loading tag</x-ui.tag>
                </div>
            </article>
        </div>
    </section>

    <section id="tag-overflow-tooltips" class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tag-live-section="overflow-tooltips">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Overflow and tooltips</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Long titles remain single-line, truncate with ellipsis, and expose the full value through the browser title tooltip.</p>
        <div class="mt-4 flex max-w-xl flex-wrap gap-2">
            <x-ui.tag class="max-w-48" truncate="end" title="Customer analytics export workspace">Customer analytics export workspace</x-ui.tag>
            <x-ui.tag class="max-w-48" truncate="middle" title="tenant-prod-us-east-2-938473829">tenant-prod-us-east-2-938473829</x-ui.tag>
            <x-ui.tag class="max-w-48" truncate="start" title="Global reporting and compliance workspace">Global reporting and compliance workspace</x-ui.tag>
            <x-ui.tag variant="selectable" class="max-w-48" truncate="end" title="Keyboard focus shows the full title">Keyboard focus shows the full title</x-ui.tag>
        </div>
    </section>

    <section id="tag-tag-groups" class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tag-live-section="tag-groups">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Tag groups</h3>
        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Wrapping group</h4>
                <div class="ui-tag-group mt-4">
                    @foreach ($tagColors as $tag)
                        <x-ui.tag :color="$tag['color']">{{ $tag['label'] }}</x-ui.tag>
                    @endforeach
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Selectable and filter groups</h4>
                <div class="ui-tag-group mt-4">
                    <x-ui.tag variant="selectable" selected>Open</x-ui.tag>
                    <x-ui.tag variant="selectable">Closed</x-ui.tag>
                    <x-ui.tag variant="selectable">Archived</x-ui.tag>
                </div>
                <div class="ui-tag-group mt-4">
                    <x-ui.tag variant="dismissible" color="gray" remove-label="Remove owner filter">Owner: Kim</x-ui.tag>
                    <x-ui.tag variant="dismissible" color="gray" remove-label="Remove region filter">Region: North</x-ui.tag>
                    <x-ui.tag variant="dismissible" color="gray" remove-label="Remove status filter">Status: Active</x-ui.tag>
                </div>
            </article>
        </div>
    </section>

    <section id="tag-tag-related-apis" class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tag-live-section="tag-related-apis">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Tag versus related APIs</h3>
        <div class="mt-4 overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-subtle-01);">
            <table class="min-w-full text-left text-sm">
                <thead style="background-color: var(--ui-layer-02); color: var(--ui-text-secondary);">
                    <tr>
                        <th class="px-3 py-2 font-medium">API</th>
                        <th class="px-3 py-2 font-medium">Owns</th>
                        <th class="px-3 py-2 font-medium">Example</th>
                        <th class="px-3 py-2 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody style="color: var(--ui-text-primary);">
                    @foreach ($boundaryRows as [$api, $owns, $example, $status])
                        <tr class="border-t" style="border-color: var(--ui-border-subtle-01);">
                            <td class="px-3 py-2 font-medium">{{ $api }}</td>
                            <td class="px-3 py-2">{{ $owns }}</td>
                            <td class="px-3 py-2"><code>{{ $example }}</code></td>
                            <td class="px-3 py-2">{{ $status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
