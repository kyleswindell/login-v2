@php
$tagTypes = [
['label' => 'Gray', 'type' => 'gray'],
['label' => 'Cool gray', 'type' => 'cool-gray'],
['label' => 'Warm gray', 'type' => 'warm-gray'],
['label' => 'Red', 'type' => 'red'],
['label' => 'Magenta', 'type' => 'magenta'],
['label' => 'Purple', 'type' => 'purple'],
['label' => 'Blue', 'type' => 'blue'],
['label' => 'Cyan', 'type' => 'cyan'],
['label' => 'Teal', 'type' => 'teal'],
['label' => 'Green', 'type' => 'green'],
];

$allTagTypes = [
...$tagTypes,
['label' => 'High contrast', 'type' => 'high-contrast'],
['label' => 'Outline', 'type' => 'outline'],
];

$sizes = [
['size' => 'sm', 'label' => 'Small', 'height' => '18px'],
['size' => 'md', 'label' => 'Medium', 'height' => '24px'],
['size' => 'lg', 'label' => 'Large', 'height' => '32px'],
];

$structureRows = [
['variant' => 'read-only', 'label' => 'Read-only', 'type' => 'gray'],
['variant' => 'dismissible', 'label' => 'Dismissible', 'type' => 'blue'],
['variant' => 'selectable', 'label' => 'Selectable', 'type' => 'gray'],
['variant' => 'operational', 'label' => 'Operational', 'type' => 'teal'],
];

$boundaryRows = [
['Tag', 'Compact metadata, filters, selectable choices, and overflow tag disclosure.', '<x-ui.tag text="Region" variant="dismissible" />', 'Canonical component'],
['Badge / Status', 'Legacy taxonomy helper only where existing status wrappers remain.', '<x-ui.badge status="pending review" />', 'Deprecated for new tag work'],
['Notification', 'Explanatory feedback that needs message content or recovery guidance.', '<x-ui.inline-alert semantic="danger">...</x-ui.inline-alert>', 'Separate component'],
['Button / Menu button', 'Commands, action groups, and menus.', '<x-ui.button>Save</x-ui.button>', 'Use owning action API'],
];
@endphp

<div class="space-y-6" data-component-live-layout="tag-matrix" data-ui-reference-sample-type="tags">
    <section class="ui-reference-layer-section" data-tag-live-section="approved-variants">
        <div class="ui-reference-section-heading">
            <div>
                <p class="ui-reference-section-kicker">Approved variants</p>
                <h3 class="ui-reference-section-title">Tag</h3>
                <p class="ui-reference-section-description">Tags are compact labels for metadata, filters, selectable choices, or tag overflow disclosure. Each variant owns its own structure and interaction contract.</p>
            </div>
        </div>

        <div class="ui-tabs ui-tabs-contained mt-4" data-ui-tabs data-ui-tabs-activation="manual" data-tag-variant-tabs>
            <div class="ui-tabs-list" role="tablist" aria-label="Tag approved variants">
                <button id="tag-read-only-tab" type="button" class="ui-tabs-tab" role="tab" aria-selected="true" aria-controls="tag-read-only-panel" data-ui-tabs-tab>Read-only</button>
                <button id="tag-dismissible-tab" type="button" class="ui-tabs-tab" role="tab" aria-selected="false" aria-controls="tag-dismissible-panel" tabindex="-1" data-ui-tabs-tab>Dismissible</button>
                <button id="tag-selectable-tab" type="button" class="ui-tabs-tab" role="tab" aria-selected="false" aria-controls="tag-selectable-panel" tabindex="-1" data-ui-tabs-tab>Selectable</button>
                <button id="tag-operational-tab" type="button" class="ui-tabs-tab" role="tab" aria-selected="false" aria-controls="tag-operational-panel" tabindex="-1" data-ui-tabs-tab>Operational</button>
            </div>

            <div class="ui-tabs-panels">
                <section id="tag-read-only-panel" class="ui-tabs-panel space-y-6" role="tabpanel" aria-labelledby="tag-read-only-tab" data-ui-tabs-panel data-tag-panel="read-only">
                    <div class="ui-reference-example-card" data-ui-layer="01">
                        <div class="ui-reference-card-header">
                            <div>
                                <h4>Read-only tag</h4>
                                <p>Use read-only tags for short metadata, category, owner, or state labels that do not trigger an action.</p>
                            </div>
                        </div>
                        <div class="ui-reference-card-body">
                            <div class="ui-reference-grid ui-reference-grid-3">
                                <div class="ui-reference-example-card" data-ui-layer="02">
                                    <div class="ui-reference-card-header">
                                        <h5>Type hooks</h5>
                                    </div>
                                    <div class="ui-reference-card-body">
                                        <x-ui.tag-group label="Read-only tag type examples">
                                            @foreach ($tagTypes as $tag)
                                            <x-ui.tag :type="$tag['type']" :text="$tag['label']" />
                                            @endforeach
                                            <x-ui.tag type="high-contrast" text="High contrast" />
                                            <x-ui.tag type="outline" text="Outline" />
                                        </x-ui.tag-group>
                                    </div>
                                </div>

                                <div class="ui-reference-example-card" data-ui-layer="02">
                                    <div class="ui-reference-card-header">
                                        <h5>Structure and sizing</h5>
                                    </div>
                                    <div class="ui-reference-card-body">
                                        <div class="space-y-3">
                                            @foreach ($sizes as $row)
                                            <div class="flex flex-wrap items-center gap-3">
                                                <x-ui.tag :size="$row['size']" type="blue" :text="$row['label']" />
                                                <x-ui.tag :size="$row['size']" type="blue" icon="heroicon-o-tag" text="With icon" />
                                                <span class="text-xs" style="color: var(--ui-text-secondary);">{{ $row['height'] }} height</span>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="ui-reference-example-card" data-ui-layer="02">
                                    <div class="ui-reference-card-header">
                                        <h5>Content behavior</h5>
                                    </div>
                                    <div class="ui-reference-card-body">
                                        <x-ui.tag-group label="Read-only content examples">
                                            <x-ui.tag type="green" icon="heroicon-o-check-circle" text="Verified" />
                                            <x-ui.tag type="gray" text="Disabled label" disabled />
                                            <x-ui.tag class="max-w-48" truncate="end" tag-title="Customer analytics export workspace" text="Customer analytics export workspace" />
                                            <x-ui.tag class="max-w-48" truncate="middle" tag-title="tenant-prod-us-east-2-938473829" text="tenant-prod-us-east-2-938473829" />
                                        </x-ui.tag-group>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="tag-dismissible-panel" class="ui-tabs-panel space-y-6" role="tabpanel" aria-labelledby="tag-dismissible-tab" data-ui-tabs-panel data-tag-panel="dismissible" hidden>
                    <div class="ui-reference-example-card" data-ui-layer="01">
                        <div class="ui-reference-card-header">
                            <div>
                                <h4>Dismissible tag</h4>
                                <p>Use dismissible tags for filters or user-generated labels. Only the close icon removes the tag.</p>
                            </div>
                        </div>
                        <div class="ui-reference-card-body">
                            <div class="ui-reference-grid ui-reference-grid-3">
                                <div class="ui-reference-example-card" data-ui-layer="02">
                                    <div class="ui-reference-card-header">
                                        <h5>Live removal</h5>
                                    </div>
                                    <div class="ui-reference-card-body">
                                        <x-ui.tag-group label="Applied filters">
                                            <x-ui.tag variant="dismissible" type="gray" text="Owner: Kim" dismiss-label="Remove owner filter" />
                                            <x-ui.tag variant="dismissible" type="gray" text="Region: North" dismiss-label="Remove region filter" />
                                            <x-ui.tag variant="dismissible" type="gray" text="AI assisted" icon="heroicon-o-sparkles" dismiss-label="Remove AI assisted filter" />
                                        </x-ui.tag-group>
                                    </div>
                                </div>

                                <div class="ui-reference-example-card" data-ui-layer="02">
                                    <div class="ui-reference-card-header">
                                        <h5>States</h5>
                                    </div>
                                    <div class="ui-reference-card-body">
                                        <x-ui.tag-group label="Dismissible state examples">
                                            <x-ui.tag variant="dismissible" type="blue" text="Region" dismiss-label="Remove region filter" />
                                            <x-ui.tag variant="dismissible" type="blue" text="Close hover" dismiss-label="Remove hover proof" class="is-hover" />
                                            <x-ui.tag variant="dismissible" type="blue" text="Close focus" dismiss-label="Remove focus proof" class="is-focus" />
                                            <x-ui.tag variant="dismissible" type="blue" text="Disabled" dismiss-label="Remove disabled proof" disabled />
                                        </x-ui.tag-group>
                                    </div>
                                </div>

                                <div class="ui-reference-example-card" data-ui-layer="02">
                                    <div class="ui-reference-card-header">
                                        <h5>Type hooks</h5>
                                    </div>
                                    <div class="ui-reference-card-body">
                                        <x-ui.tag-group label="Dismissible tag type examples">
                                            @foreach ($tagTypes as $tag)
                                            <x-ui.tag variant="dismissible" :type="$tag['type']" :text="$tag['label']" dismiss-label="Remove {{ $tag['label'] }} filter" />
                                            @endforeach
                                        </x-ui.tag-group>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="tag-selectable-panel" class="ui-tabs-panel space-y-6" role="tabpanel" aria-labelledby="tag-selectable-tab" data-ui-tabs-panel data-tag-panel="selectable" hidden>
                    <div class="ui-reference-example-card" data-ui-layer="01">
                        <div class="ui-reference-card-header">
                            <div>
                                <h4>Selectable tag</h4>
                                <p>Use selectable tags for compact choices. Selectable tags use core interaction tokens, not the color family matrix.</p>
                            </div>
                        </div>
                        <div class="ui-reference-card-body">
                            <div class="ui-reference-grid ui-reference-grid-3">
                                <div class="ui-reference-example-card" data-ui-layer="02">
                                    <div class="ui-reference-card-header">
                                        <h5>Single select group</h5>
                                    </div>
                                    <div class="ui-reference-card-body">
                                        <x-ui.tag-group label="Status filters" selection-mode="single">
                                            <x-ui.tag variant="selectable" text="Open" selected />
                                            <x-ui.tag variant="selectable" text="Closed" />
                                            <x-ui.tag variant="selectable" text="Archived" />
                                        </x-ui.tag-group>
                                    </div>
                                </div>

                                <div class="ui-reference-example-card" data-ui-layer="02">
                                    <div class="ui-reference-card-header">
                                        <h5>Multiple select group</h5>
                                    </div>
                                    <div class="ui-reference-card-body">
                                        <x-ui.tag-group label="Team filters" selection-mode="multiple">
                                            <x-ui.tag variant="selectable" text="Finance" default-selected />
                                            <x-ui.tag variant="selectable" text="Legal" />
                                            <x-ui.tag variant="selectable" text="Security" icon="heroicon-o-shield-check" />
                                        </x-ui.tag-group>
                                    </div>
                                </div>

                                <div class="ui-reference-example-card" data-ui-layer="02">
                                    <div class="ui-reference-card-header">
                                        <h5>States and overflow</h5>
                                    </div>
                                    <div class="ui-reference-card-body">
                                        <x-ui.tag-group label="Selectable state examples">
                                            <x-ui.tag variant="selectable" text="Selectable" />
                                            <x-ui.tag variant="selectable" text="Hover" class="is-hover" />
                                            <x-ui.tag variant="selectable" text="Focus" class="is-focus" />
                                            <x-ui.tag variant="selectable" text="Selected" selected />
                                            <x-ui.tag variant="selectable" text="Disabled" disabled />
                                            <x-ui.tag variant="selectable" class="max-w-48" truncate="middle" tag-title="tenant-prod-us-east-2-938473829" text="tenant-prod-us-east-2-938473829" />
                                        </x-ui.tag-group>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="tag-operational-panel" class="ui-tabs-panel space-y-6" role="tabpanel" aria-labelledby="tag-operational-tab" data-ui-tabs-panel data-tag-panel="operational" hidden>
                    <div class="ui-reference-example-card" data-ui-layer="01">
                        <div class="ui-reference-card-header">
                            <div>
                                <h4>Operational tag</h4>
                                <p>Use operational tags to disclose additional tags or compact related tag content. The trigger remains a tag, not a menu button.</p>
                            </div>
                        </div>
                        <div class="ui-reference-card-body">
                            <div class="ui-reference-grid ui-reference-grid-3">
                                <div class="ui-reference-example-card" data-ui-layer="02">
                                    <div class="ui-reference-card-header">
                                        <h5>Disclosure proof</h5>
                                    </div>
                                    <div class="ui-reference-card-body">
                                        <div class="flex flex-wrap items-start gap-4">
                                            <div class="ui-tag-disclosure">
                                                <x-ui.tag variant="operational" type="teal" text="View more" disclosure-target="tag-disclosure-text-list" />
                                                <div id="tag-disclosure-text-list" class="ui-tag-disclosure-panel ui-tag-disclosure-panel-text-list" data-ui-tag-disclosure hidden>
                                                    <div class="ui-tag-disclosure-row">Finance</div>
                                                    <div class="ui-tag-disclosure-row">Legal</div>
                                                    <div class="ui-tag-disclosure-row">Security</div>
                                                    <div class="ui-tag-disclosure-row">Retention</div>
                                                    <div class="ui-tag-disclosure-row">Audit</div>
                                                </div>
                                            </div>

                                            <div class="ui-tag-disclosure">
                                                <x-ui.tag variant="operational" type="cyan" text="Tag list" disclosure-target="tag-disclosure-tag-list" />
                                                <div id="tag-disclosure-tag-list" class="ui-tag-disclosure-panel ui-tag-disclosure-panel-tag-list" data-ui-tag-disclosure hidden>
                                                    <x-ui.tag-group label="Overflow tags">
                                                        <x-ui.tag type="cyan" size="sm" text="Subnet" />
                                                        <x-ui.tag type="cyan" size="sm" text="Gateway" />
                                                        <x-ui.tag type="cyan" size="sm" text="Firewall" />
                                                        <x-ui.tag type="cyan" size="sm" text="Load balancer" />
                                                        <x-ui.tag type="cyan" size="sm" text="VPC" />
                                                    </x-ui.tag-group>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="ui-reference-example-card" data-ui-layer="02">
                                    <div class="ui-reference-card-header">
                                        <h5>States</h5>
                                    </div>
                                    <div class="ui-reference-card-body">
                                        <x-ui.tag-group label="Operational state examples">
                                            <x-ui.tag variant="operational" type="teal" text="Operational" />
                                            <x-ui.tag variant="operational" type="teal" text="Hover" class="is-hover" />
                                            <x-ui.tag variant="operational" type="teal" text="Focus" class="is-focus" />
                                            <x-ui.tag variant="operational" type="teal" text="Disabled" disabled />
                                        </x-ui.tag-group>
                                    </div>
                                </div>

                                <div class="ui-reference-example-card" data-ui-layer="02">
                                    <div class="ui-reference-card-header">
                                        <h5>Type hooks</h5>
                                    </div>
                                    <div class="ui-reference-card-body">
                                        <x-ui.tag-group label="Operational type examples">
                                            @foreach ($tagTypes as $tag)
                                            <x-ui.tag variant="operational" :type="$tag['type']" :text="$tag['label']" />
                                            @endforeach
                                        </x-ui.tag-group>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>

    <section class="ui-reference-layer-section" data-tag-live-section="tag-structure-proof">
        <div class="ui-reference-section-heading">
            <div>
                <p class="ui-reference-section-kicker">Structure proof</p>
                <h3 class="ui-reference-section-title">Fixed-height tag construction</h3>
                <p class="ui-reference-section-description">Tags use fixed heights, a 16px radius, horizontal-only padding, 16px icons, label title metadata, and an 8px group gap. These examples intentionally separate physical construction from color-token coverage.</p>
            </div>
        </div>

        <div class="ui-reference-grid ui-reference-grid-2 mt-4">
            <div class="ui-reference-example-card" data-ui-layer="01">
                <div class="ui-reference-card-header">
                    <h4>Heights and radius</h4>
                </div>
                <div class="ui-reference-card-body">
                    <div class="space-y-4">
                        @foreach ($sizes as $row)
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="w-16 text-xs font-medium" style="color: var(--ui-text-secondary);">{{ $row['label'] }}</span>
                            <x-ui.tag :size="$row['size']" type="gray" text="Metadata" />
                            <x-ui.tag :size="$row['size']" type="green" text="Verified" icon="heroicon-o-check-circle" />
                            <span class="text-xs" style="color: var(--ui-text-secondary);">{{ $row['height'] }}, radius 16px</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="ui-reference-example-card" data-ui-layer="01">
                <div class="ui-reference-card-header">
                    <h4>Dismissible spacing</h4>
                </div>
                <div class="ui-reference-card-body">
                    <div class="space-y-4">
                        @foreach ($sizes as $row)
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="w-16 text-xs font-medium" style="color: var(--ui-text-secondary);">{{ $row['label'] }}</span>
                            <x-ui.tag variant="dismissible" :size="$row['size']" type="blue" text="Owner" dismiss-label="Remove owner tag" />
                            <x-ui.tag variant="dismissible" :size="$row['size']" type="blue" text="AI assisted" icon="heroicon-o-sparkles" dismiss-label="Remove AI assisted tag" />
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="ui-reference-example-card" data-ui-layer="01">
                <div class="ui-reference-card-header">
                    <h4>Interactive borders</h4>
                </div>
                <div class="ui-reference-card-body">
                    <x-ui.tag-group label="Interactive tag structure examples">
                        @foreach ($structureRows as $row)
                        @if ($row['variant'] === 'read-only')
                        <x-ui.tag :type="$row['type']" :text="$row['label']" />
                        @elseif ($row['variant'] === 'dismissible')
                        <x-ui.tag variant="dismissible" :type="$row['type']" :text="$row['label']" dismiss-label="Remove dismissible tag" />
                        @else
                        <x-ui.tag :variant="$row['variant']" :type="$row['type']" :text="$row['label']" />
                        @endif
                        @endforeach
                    </x-ui.tag-group>
                </div>
            </div>

            <div class="ui-reference-example-card" data-ui-layer="01">
                <div class="ui-reference-card-header">
                    <h4>Truncation and label metadata</h4>
                </div>
                <div class="ui-reference-card-body">
                    <x-ui.tag-group label="Tag truncation examples">
                        <x-ui.tag class="max-w-48" truncate="end" tag-title="Customer analytics export workspace" text="Customer analytics export workspace" />
                        <x-ui.tag class="max-w-48" truncate="start" tag-title="customer-analytics-production-cluster" text="customer-analytics-production-cluster" />
                        <x-ui.tag class="max-w-48" truncate="middle" tag-title="tenant-prod-us-east-2-938473829" text="tenant-prod-us-east-2-938473829" />
                    </x-ui.tag-group>
                </div>
            </div>
        </div>
    </section>

    <section class="ui-reference-layer-section" data-tag-live-section="tag-color-tokens">
        <div class="ui-reference-section-heading">
            <div>
                <p class="ui-reference-section-kicker">Color tokens</p>
                <h3 class="ui-reference-section-title">Tag color token proof</h3>
                <p class="ui-reference-section-description">Read-only, dismissible, and operational tags consume component color tokens. Selectable tags use core tokens only and are intentionally shown outside the color family matrix.</p>
            </div>
        </div>

        <div class="ui-reference-grid ui-reference-grid-2 mt-4">
            <div class="ui-reference-example-card" data-ui-layer="01">
                <div class="ui-reference-card-header">
                    <h4>Read-only color matrix</h4>
                </div>
                <div class="ui-reference-card-body">
                    <x-ui.tag-group label="Read-only color token examples">
                        @foreach ($allTagTypes as $tag)
                        <x-ui.tag :type="$tag['type']" :text="$tag['label']" />
                        @endforeach
                    </x-ui.tag-group>
                </div>
            </div>

            <div class="ui-reference-example-card" data-ui-layer="01">
                <div class="ui-reference-card-header">
                    <h4>Dismissible color matrix</h4>
                </div>
                <div class="ui-reference-card-body">
                    <x-ui.tag-group label="Dismissible color token examples">
                        @foreach ($allTagTypes as $tag)
                        <x-ui.tag variant="dismissible" :type="$tag['type']" :text="$tag['label']" dismiss-label="Remove {{ $tag['label'] }} tag" />
                        @endforeach
                    </x-ui.tag-group>
                </div>
            </div>

            <div class="ui-reference-example-card" data-ui-layer="01">
                <div class="ui-reference-card-header">
                    <h4>Operational color matrix</h4>
                </div>
                <div class="ui-reference-card-body">
                    <x-ui.tag-group label="Operational color token examples">
                        @foreach ($tagTypes as $tag)
                        <x-ui.tag variant="operational" :type="$tag['type']" :text="$tag['label']" />
                        @endforeach
                    </x-ui.tag-group>
                    <p class="mt-3 text-xs leading-5" style="color: var(--ui-text-secondary);">Operational tags use the same component color families plus the border token. High contrast and outline are read-only/dismissible treatments.</p>
                </div>
            </div>

            <div class="ui-reference-example-card" data-ui-layer="01">
                <div class="ui-reference-card-header">
                    <h4>Selectable core-token states</h4>
                </div>
                <div class="ui-reference-card-body">
                    <x-ui.tag-group label="Selectable core-token state examples">
                        <x-ui.tag variant="selectable" text="Enabled" />
                        <x-ui.tag variant="selectable" text="Hover" class="is-hover" />
                        <x-ui.tag variant="selectable" text="Focus" class="is-focus" />
                        <x-ui.tag variant="selectable" text="Selected" selected />
                        <x-ui.tag variant="selectable" text="Disabled" disabled />
                        <x-ui.tag variant="selectable" text="Skeleton" class="ui-tag-skeleton" />
                    </x-ui.tag-group>
                </div>
            </div>
        </div>

        <div class="ui-reference-grid ui-reference-grid-4 mt-4">
            <div class="ui-reference-example-card" data-ui-layer="01">
                <div class="ui-reference-card-header">
                    <h4>Read-only states</h4>
                </div>
                <div class="ui-reference-card-body">
                    <x-ui.tag-group label="Read-only state examples">
                        <x-ui.tag type="green" text="Enabled" />
                        <x-ui.tag type="green" text="Disabled" disabled />
                        <x-ui.tag type="green" text="Skeleton" class="ui-tag-skeleton" />
                    </x-ui.tag-group>
                </div>
            </div>

            <div class="ui-reference-example-card" data-ui-layer="01">
                <div class="ui-reference-card-header">
                    <h4>Dismissible states</h4>
                </div>
                <div class="ui-reference-card-body">
                    <x-ui.tag-group label="Dismissible state examples with close target">
                        <x-ui.tag variant="dismissible" type="blue" text="Enabled" dismiss-label="Remove enabled tag" />
                        <x-ui.tag variant="dismissible" type="blue" text="Close hover" dismiss-label="Remove hover tag" class="is-hover" />
                        <x-ui.tag variant="dismissible" type="blue" text="Close focus" dismiss-label="Remove focus tag" class="is-focus" />
                        <x-ui.tag variant="dismissible" type="blue" text="Disabled" dismiss-label="Remove disabled tag" disabled />
                        <x-ui.tag variant="dismissible" type="blue" text="Skeleton" dismiss-label="Remove skeleton tag" class="ui-tag-skeleton" />
                    </x-ui.tag-group>
                </div>
            </div>

            <div class="ui-reference-example-card" data-ui-layer="01">
                <div class="ui-reference-card-header">
                    <h4>Operational states</h4>
                </div>
                <div class="ui-reference-card-body">
                    <x-ui.tag-group label="Operational state examples with border token">
                        <x-ui.tag variant="operational" type="teal" text="Enabled" />
                        <x-ui.tag variant="operational" type="teal" text="Hover" class="is-hover" />
                        <x-ui.tag variant="operational" type="teal" text="Focus" class="is-focus" />
                        <x-ui.tag variant="operational" type="teal" text="Disabled" disabled />
                        <x-ui.tag variant="operational" type="teal" text="Skeleton" class="ui-tag-skeleton" />
                    </x-ui.tag-group>
                </div>
            </div>

            <div class="ui-reference-example-card" data-ui-layer="01">
                <div class="ui-reference-card-header">
                    <h4>Special type states</h4>
                </div>
                <div class="ui-reference-card-body">
                    <x-ui.tag-group label="High contrast and outline states">
                        <x-ui.tag type="high-contrast" text="High contrast" />
                        <x-ui.tag variant="dismissible" type="high-contrast" text="Close hover" dismiss-label="Remove high contrast tag" class="is-hover" />
                        <x-ui.tag type="outline" text="Outline" />
                        <x-ui.tag variant="dismissible" type="outline" text="Close focus" dismiss-label="Remove outline tag" class="is-focus" />
                    </x-ui.tag-group>
                </div>
            </div>
        </div>
    </section>

    <section class="ui-reference-layer-section" data-tag-live-section="tag-groups">
        <div class="ui-reference-section-heading">
            <div>
                <p class="ui-reference-section-kicker">Grouping</p>
                <h3 class="ui-reference-section-title">Tag groups</h3>
                <p class="ui-reference-section-description">Groups use 8px spacing, wrap naturally, and declare selection mode only when selectable tags need coordinated behavior.</p>
            </div>
        </div>

        <div class="ui-reference-grid ui-reference-grid-2 mt-4">
            <div class="ui-reference-example-card" data-ui-layer="01">
                <div class="ui-reference-card-header">
                    <h4>Wrapping read-only group</h4>
                </div>
                <div class="ui-reference-card-body">
                    <x-ui.tag-group label="Network tags">
                        <x-ui.tag type="blue" text="Subnet" />
                        <x-ui.tag type="magenta" text="Floating IP" />
                        <x-ui.tag type="green" text="VPC" />
                        <x-ui.tag type="purple" text="Load balancer" />
                        <x-ui.tag type="teal" text="Flow log" />
                        <x-ui.tag type="cyan" text="Gateway" />
                    </x-ui.tag-group>
                </div>
            </div>

            <div class="ui-reference-example-card" data-ui-layer="01">
                <div class="ui-reference-card-header">
                    <h4>Dismissible filter group</h4>
                </div>
                <div class="ui-reference-card-body">
                    <x-ui.tag-group label="Invoice filters">
                        <x-ui.tag variant="dismissible" type="gray" text="Type: Invoice" dismiss-label="Remove type filter" />
                        <x-ui.tag variant="dismissible" type="gray" text="Owner: Avery" dismiss-label="Remove owner filter" />
                        <x-ui.tag variant="dismissible" type="gray" text="Due this week" dismiss-label="Remove due date filter" />
                    </x-ui.tag-group>
                </div>
            </div>
        </div>
    </section>

    <section class="ui-reference-layer-section" data-tag-live-section="tag-related-apis">
        <div class="ui-reference-section-heading">
            <div>
                <p class="ui-reference-section-kicker">Boundaries</p>
                <h3 class="ui-reference-section-title">Tag versus related APIs</h3>
                <p class="ui-reference-section-description">Tags do not replace notifications, commands, status taxonomy wrappers, or long-form feedback surfaces.</p>
            </div>
        </div>

        <div class="mt-4 overflow-x-auto border" style="border-color: var(--ui-border-subtle-01);">
            <table class="min-w-full text-left text-sm">
                <thead style="background-color: var(--ui-layer-01); color: var(--ui-text-secondary);">
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