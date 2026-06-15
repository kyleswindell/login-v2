@php
    $metadataTags = [
        ['label' => 'Internal', 'tone' => 'neutral', 'size' => 'md'],
        ['label' => 'Trial', 'tone' => 'neutral', 'size' => 'sm'],
        ['label' => 'Owner', 'tone' => 'neutral', 'size' => 'sm'],
    ];

    $semanticTags = [
        ['label' => 'Information', 'tone' => 'info', 'icon' => 'heroicon-o-information-circle'],
        ['label' => 'Active', 'tone' => 'success', 'icon' => 'heroicon-o-check-circle'],
        ['label' => 'Pending review', 'tone' => 'warning', 'icon' => 'heroicon-o-exclamation-triangle'],
        ['label' => 'Blocked', 'tone' => 'error', 'icon' => 'heroicon-o-x-circle'],
    ];

    $boundaryRows = [
        ['Tag', 'Compact metadata or semantic state marker.', '<x-ui.tag tone="success">Active</x-ui.tag>', 'Approved here'],
        ['Badge / Status', 'Existing taxonomy wrapper for common status labels.', '<x-ui.badge status="pending review" />', 'Transitional related API'],
        ['Notification', 'Message that needs explanation, recovery, or dismissal.', '<x-ui.inline-alert semantic="danger">...</x-ui.inline-alert>', 'Separate component'],
        ['Filter chip', 'Interactive selected-filter token with removal behavior.', '<x-ui.tag removable>...</x-ui.tag>', 'Gated by Filter/Search Pattern'],
        ['Tabs / Button', 'View switching or commands.', '<x-ui.button>Save</x-ui.button>', 'Use the owning action/navigation API'],
    ];
@endphp

<div class="space-y-6" data-component-live-layout="tag-matrix" data-ui-reference-sample-type="tags">
    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tag-live-section="metadata-tags">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Metadata tags</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Neutral tags label category, ownership, or type without implying system status.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Card metadata</h4>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($metadataTags as $tag)
                        <x-ui.tag :tone="$tag['tone']" :size="$tag['size']">{{ $tag['label'] }}</x-ui.tag>
                    @endforeach
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Table row density</h4>
                <div class="mt-4 overflow-x-auto rounded-md border" style="border-color: var(--ui-border-subtle-01);">
                    <table class="min-w-full text-left text-sm">
                        <thead style="background-color: var(--ui-layer-03); color: var(--ui-text-secondary);">
                            <tr>
                                <th class="px-3 py-2 font-medium">Workspace</th>
                                <th class="px-3 py-2 font-medium">Type</th>
                                <th class="px-3 py-2 font-medium">Owner</th>
                            </tr>
                        </thead>
                        <tbody style="color: var(--ui-text-primary);">
                            <tr class="border-t" style="border-color: var(--ui-border-subtle-01);">
                                <td class="px-3 py-2">North region</td>
                                <td class="px-3 py-2"><x-ui.tag size="sm">Production</x-ui.tag></td>
                                <td class="px-3 py-2"><x-ui.tag size="sm">Platform</x-ui.tag></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tag-live-section="semantic-status-tags">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Semantic status tags</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Semantic tones are reserved for real meaning. The visible label carries the status so the tag does not rely on color alone.</p>
        <div class="mt-4 flex flex-wrap gap-2">
            @foreach ($semanticTags as $tag)
                <x-ui.tag :tone="$tag['tone']" :icon="$tag['icon']">{{ $tag['label'] }}</x-ui.tag>
            @endforeach
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tag-live-section="sizes-and-icons">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Sizes and icon support</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Small tags support dense rows. Medium tags are the default. Icons remain decorative and reinforce visible text.</p>
        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Size comparison</h4>
                <div class="mt-4 flex flex-wrap items-center gap-2">
                    <x-ui.tag size="sm">Small tag</x-ui.tag>
                    <x-ui.tag size="md">Medium tag</x-ui.tag>
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Icon-supported</h4>
                <div class="mt-4 flex flex-wrap gap-2">
                    <x-ui.tag tone="success" icon="heroicon-o-check-circle">Verified</x-ui.tag>
                    <x-ui.tag tone="info" icon="heroicon-o-information-circle">Synced</x-ui.tag>
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tag-live-section="filter-removable-boundary">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Filter and removable boundary</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Static tags are not buttons and do not receive focus. Removable/filter tags stay gated until the owning filter or search Pattern defines removal, focus, persistence, and empty-state behavior.</p>
        <div class="mt-4 flex flex-wrap gap-2">
            <x-ui.tag tone="neutral" removable remove-label="Remove region filter">Region: North</x-ui.tag>
            <span class="inline-flex items-center rounded-full border px-2 py-1 text-xs font-semibold" style="border-color: var(--ui-border-subtle-01); color: var(--ui-text-secondary);">Gated: no remove button rendered</span>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tag-live-section="tag-related-apis">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Tag versus related APIs</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Use the API that owns the behavior. Tag is for compact labels, not commands, navigation, or full feedback messages.</p>
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
