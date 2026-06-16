@php
    $boundaryRows = [
        ['Base/static tile', 'Short grouped content that may contain child links or buttons.', '<x-ui.tile variant="static" ... />', 'Implemented'],
        ['Clickable tile', 'One whole-tile link or command with no nested controls.', '<x-ui.tile variant="clickable" href="..." />', 'Implemented'],
        ['Selectable tile', 'One option in a visible choice set, backed by radio or checkbox semantics.', '<x-ui.tile variant="selectable" name="plan" value="growth" />', 'Implemented'],
        ['Expandable tile', 'Whole-tile disclosure when no nested interactive controls are present.', '<x-ui.tile variant="expandable" />', 'Implemented'],
        ['Expandable tile with interactive elements', 'Disclosure tile with internal controls and a bottom-right expand button.', '<x-ui.tile variant="expandable" interactive />', 'Implemented'],
        ['Media tile', 'Tile with image or illustration area.', 'none', 'Deferred'],
        ['Tile group helper', 'Reusable group/grid behavior, labels, and responsive orchestration.', 'none', 'Pattern-owned'],
        ['AI presence', 'AI-labelled tile treatment with explainability disclosure.', 'none', 'Gated'],
    ];

    $gridProportions = [
        ['100%', 'Supported', 'Supported', 'Supported', 'Supported', 'Supported'],
        ['1/2', 'Supported', 'Supported', 'Supported', 'Supported', 'Supported'],
        ['2/3', 'Supported', 'Supported', 'Supported', 'Supported', 'Not recommended'],
        ['1/3', 'Supported', 'Supported', 'Supported', 'Supported', 'Not recommended'],
        ['1/4', 'Supported', 'Supported', 'Supported', 'Supported', 'Not recommended'],
        ['1/6', 'Supported', 'Supported', 'Not recommended', 'Not recommended', 'Not recommended'],
    ];
@endphp

<div class="space-y-6" data-component-live-layout="tile-matrix" data-ui-reference-sample-type="tile">
    <section class="ui-reference-layer-section" data-tile-live-section="variants">
        <div class="ui-reference-section-heading">
            <h3>Variants</h3>
            <p>Tile owns the full component family: base, clickable, selectable, expandable, and expandable with interactive elements. Interactive variants use the feature-flag border treatment as the current standard.</p>
        </div>

        <div class="mt-4 ui-tile-layout-standard">
            <x-ui.tile title="Base tile" description="Non-interactive content block." meta="Static" />
            <x-ui.tile variant="clickable" href="#" title="Clickable tile" description="One whole-container action." meta="Feature border" />
            <x-ui.tile variant="selectable" name="tile_variant" value="selectable" title="Selectable tile" description="Radio-style selected state." selected />
            <x-ui.tile id="tile-variant-expandable" variant="expandable" title="Expandable tile" description="Full-container disclosure.">
                <x-slot name="details">
                    <p class="text-sm">The whole tile trigger opens and closes this supporting detail.</p>
                </x-slot>
            </x-ui.tile>
            <x-ui.tile id="tile-variant-interactive" variant="expandable" title="Expandable tile with interactive elements" description="Internal controls keep their own click targets." interactive>
                <x-slot name="actions">
                    <x-ui.link href="#" variant="standalone" size="sm">Open details</x-ui.link>
                    <x-ui.button semantic="neutral" size="sm">Test action</x-ui.button>
                </x-slot>
                <x-slot name="details">
                    <p class="text-sm">Only the bottom-right expansion button controls this region.</p>
                </x-slot>
            </x-ui.tile>
        </div>
    </section>

    <section class="ui-reference-layer-section" data-tile-live-section="clickable-tile">
        <div class="ui-reference-section-heading">
            <h3>Clickable tile</h3>
            <p>Clickable tiles make the full container one link or one command. The arrow affordance sits bottom-right and nested controls are not allowed.</p>
        </div>

        <div class="mt-4 ui-tile-layout-standard">
            <x-ui.tile variant="clickable" href="#" title="Default clickable tile" description="Open access, roles, and status." meta="Navigation" />
            <x-ui.tile class="ui-reference-force-focus" variant="clickable" href="#" title="Focused clickable tile" description="Focus applies to the container." meta="Focus" />
            <x-ui.tile variant="clickable" title="Run audit check" description="Starts one local command." meta="Button action" />
            <x-ui.tile variant="clickable" title="Disabled clickable tile" description="Unavailable because billing is managed upstream." meta="Disabled" disabled />
        </div>
    </section>

    <section class="ui-reference-layer-section" data-tile-live-section="selectable-tile">
        <div class="ui-reference-section-heading">
            <h3>Selectable tile</h3>
            <p>Selectable tile groups use matching variants. Single select uses radio-style icons and multi-select uses checkbox-style icons that remain visible in the enabled state.</p>
        </div>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <fieldset class="min-w-0 rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <legend class="text-sm font-semibold" style="color: var(--ui-text-primary);">Single-select tile group</legend>
                <div class="mt-3 grid gap-3">
                    <x-ui.tile variant="selectable" name="tile_plan" value="starter" selection-mode="single" title="Starter" description="Core workspace tools." />
                    <x-ui.tile variant="selectable" name="tile_plan" value="growth" selection-mode="single" title="Growth" description="Automation and review workflows." selected />
                    <x-ui.tile class="ui-reference-force-focus" variant="selectable" name="tile_plan" value="scale" selection-mode="single" title="Scale" description="Focused option state." />
                    <x-ui.tile variant="selectable" name="tile_plan" value="enterprise" selection-mode="single" title="Enterprise" description="Unavailable for this tenant." disabled />
                </div>
            </fieldset>

            <fieldset class="min-w-0 rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <legend class="text-sm font-semibold" style="color: var(--ui-text-primary);">Multi-select tile group</legend>
                <div class="mt-3 grid gap-3">
                    <x-ui.tile variant="selectable" name="tile_features[]" value="audit" selection-mode="multiple" title="Audit export" description="Scheduled account exports." selected />
                    <x-ui.tile class="ui-reference-force-focus" variant="selectable" name="tile_features[]" value="roles" selection-mode="multiple" title="Role review" description="Manager approval workflow." />
                    <x-ui.tile variant="selectable" name="tile_features[]" value="search" selection-mode="multiple" title="Advanced search" description="Saved filters and bulk review." selected />
                    <x-ui.tile variant="selectable" name="tile_features[]" value="api" selection-mode="multiple" title="API access" description="Disabled until owner approval." disabled />
                </div>
            </fieldset>
        </div>
    </section>

    <section class="ui-reference-layer-section" data-tile-live-section="expandable-tile">
        <div class="ui-reference-section-heading">
            <h3>Expandable tile</h3>
            <p>Expandable tiles without internal controls use the whole tile trigger. Expandable tiles with internal controls use only the bottom-right expansion button.</p>
        </div>

        <div class="mt-4 grid gap-4 lg:grid-cols-2">
            <x-ui.tile id="tile-billing-details" variant="expandable" title="Expandable expanded" description="View short billing metadata." expanded>
                <x-slot name="details">
                    <dl class="grid gap-2 text-sm">
                        <div>
                            <dt class="font-semibold" style="color: var(--ui-text-primary);">Billing contact</dt>
                            <dd>Accounting team</dd>
                        </div>
                        <div>
                            <dt class="font-semibold" style="color: var(--ui-text-primary);">Status</dt>
                            <dd>Active</dd>
                        </div>
                    </dl>
                </x-slot>
            </x-ui.tile>

            <x-ui.tile id="tile-security-details" class="ui-reference-force-focus" variant="expandable" title="Expandable focus state" description="Collapsed state keeps secondary content hidden.">
                <x-slot name="details">
                    <p class="text-sm">This detail is hidden until the owning state opens the tile.</p>
                </x-slot>
            </x-ui.tile>

            <x-ui.tile id="tile-locked-details" variant="expandable" title="Disabled expandable tile" description="Disabled expansion is visually distinct and not operable." disabled>
                <x-slot name="details">
                    <p class="text-sm">Disabled expandable content is not reachable until enabled.</p>
                </x-slot>
            </x-ui.tile>

            <x-ui.tile id="tile-integration-details" variant="expandable" title="Expandable with internal link and button" description="The internal controls do not toggle expansion." interactive expand-button-label="Expand integration details">
                <x-slot name="actions">
                    <x-ui.link href="#" variant="standalone" size="sm">Open integration</x-ui.link>
                    <x-ui.button semantic="neutral" size="sm">Test connection</x-ui.button>
                </x-slot>
                <x-slot name="details">
                    <p class="text-sm">The expansion button is the only disclosure trigger for this tile.</p>
                </x-slot>
            </x-ui.tile>
        </div>
    </section>

    <section class="ui-reference-layer-section" data-tile-live-section="layout">
        <div class="ui-reference-section-heading">
            <h3>Layout</h3>
            <p>Parent Patterns own grid placement. Tile groups should use matching variants, consistent spacing, and grid-aligned proportions.</p>
        </div>

        <div class="mt-4 space-y-5">
            <div>
                <h4 class="ui-reference-example-title">Standard layout</h4>
                <div class="mt-3 ui-tile-layout-standard">
                    <x-ui.tile title="Standard tile" description="Same height and width is the preferred default." />
                    <x-ui.tile title="Standard tile" description="Tile groups usually flow left to right." />
                    <x-ui.tile title="Standard tile" description="Keep variants consistent inside a group." />
                </div>
            </div>

            <div>
                <h4 class="ui-reference-example-title">Vertical masonry layout</h4>
                <div class="mt-3 ui-tile-layout-vertical-masonry">
                    <x-ui.tile title="Short tile" description="Width stays consistent." />
                    <x-ui.tile title="Tall tile" description="Height may vary when content needs more lines while the column width stays aligned to the grid and readable at narrow breakpoints." />
                    <x-ui.tile title="Medium tile" description="Use this when content naturally varies by amount." />
                </div>
            </div>

            <div>
                <h4 class="ui-reference-example-title">Horizontal masonry layout</h4>
                <div class="mt-3 ui-tile-layout-horizontal-masonry">
                    <x-ui.tile title="Wide tile" description="Tiles may vary in width when the row remains coherent." />
                    <x-ui.tile title="Narrow tile" description="Avoid very small fractions at small breakpoints." />
                </div>
            </div>

            <div>
                <h4 class="ui-reference-example-title">Grid proportions</h4>
                <div class="mt-3 overflow-x-auto rounded-md border" style="border-color: var(--ui-border-subtle-01);">
                    <table class="min-w-full text-left text-sm">
                        <thead style="background-color: var(--ui-layer-02); color: var(--ui-text-secondary);">
                            <tr>
                                <th class="px-3 py-2 font-medium">Percentage</th>
                                <th class="px-3 py-2 font-medium">XL</th>
                                <th class="px-3 py-2 font-medium">L</th>
                                <th class="px-3 py-2 font-medium">M</th>
                                <th class="px-3 py-2 font-medium">S</th>
                                <th class="px-3 py-2 font-medium">XS</th>
                            </tr>
                        </thead>
                        <tbody style="color: var(--ui-text-primary);">
                            @foreach ($gridProportions as [$percentage, $xl, $lg, $md, $sm, $xs])
                                <tr class="border-t" style="border-color: var(--ui-border-subtle-01);">
                                    <th class="px-3 py-2 font-medium" scope="row">{{ $percentage }}</th>
                                    <td class="px-3 py-2">{{ $xl }}</td>
                                    <td class="px-3 py-2">{{ $lg }}</td>
                                    <td class="px-3 py-2">{{ $md }}</td>
                                    <td class="px-3 py-2">{{ $sm }}</td>
                                    <td class="px-3 py-2">{{ $xs }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <section class="ui-reference-layer-section" data-tile-live-section="states-and-accessibility">
        <div class="ui-reference-section-heading">
            <h3>States and accessibility</h3>
            <p>Interactive tile states are token-backed and semantic: focus-visible outlines the operative surface, selected/current state is not color-only, and disabled interactive tiles are not activatable.</p>
        </div>

        <div class="mt-4 ui-tile-layout-standard">
            <x-ui.tile variant="clickable" href="#" title="Enabled" description="Default interactive state." />
            <x-ui.tile variant="clickable" href="#" title="Current route" description="Current state emits aria-current." current />
            <x-ui.tile variant="selectable" name="tile_state" value="selected" title="Selected" description="Selected border and icon are visible." selected />
            <x-ui.tile variant="selectable" name="tile_state" value="disabled" title="Disabled selectable" description="Disabled state removes interaction." disabled />
            <x-ui.tile id="tile-disabled-interactive-expand" variant="expandable" title="Disabled interactive expandable" description="Disabled expansion button is not operable." interactive disabled>
                <x-slot name="actions">
                    <x-ui.link href="#" variant="standalone" size="sm">Internal CTA</x-ui.link>
                </x-slot>
                <x-slot name="details">
                    <p class="text-sm">Disabled expandable content remains closed.</p>
                </x-slot>
            </x-ui.tile>
        </div>
    </section>

    <section class="ui-reference-layer-section" data-tile-live-section="boundaries-and-gates">
        <div class="ui-reference-section-heading">
            <h3>Boundaries and gates</h3>
            <p>Tile owns compact surfaces and simple whole-tile behavior. Rich cards, media tiles, reusable tile groups, and AI presence require their owning standards before production use.</p>
        </div>

        <div class="mt-4 overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-subtle-01);">
            <table class="min-w-full text-left text-sm">
                <thead style="background-color: var(--ui-layer-02); color: var(--ui-text-secondary);">
                    <tr>
                        <th class="px-3 py-2 font-medium">Capability</th>
                        <th class="px-3 py-2 font-medium">Owns</th>
                        <th class="px-3 py-2 font-medium">API</th>
                        <th class="px-3 py-2 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody style="color: var(--ui-text-primary);">
                    @foreach ($boundaryRows as [$capability, $owns, $api, $status])
                        <tr class="border-t" style="border-color: var(--ui-border-subtle-01);">
                            <td class="px-3 py-2 font-medium">{{ $capability }}</td>
                            <td class="px-3 py-2">{{ $owns }}</td>
                            <td class="px-3 py-2"><code>{{ $api }}</code></td>
                            <td class="px-3 py-2">{{ $status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="ui-reference-layer-section" data-tile-live-section="developer-implementation">
        <div class="ui-reference-section-heading">
            <h3>Developer implementation</h3>
            <p>Use the component API and state props. Do not hand-build tile borders, selected states, hover treatment, or local disclosure cards.</p>
        </div>

        <pre class="ui-code-snippet mt-4" data-component-section="developer-code-example"><code>&lt;x-ui.tile
    variant="selectable"
    name="plan"
    value="growth"
    title="Growth"
    description="Automation and review workflows."
    selected
/&gt;

&lt;x-ui.tile
    variant="expandable"
    title="Integration details"
    interactive
&gt;
    &lt;x-slot name="actions"&gt;...&lt;/x-slot&gt;
    &lt;x-slot name="details"&gt;...&lt;/x-slot&gt;
&lt;/x-ui.tile&gt;</code></pre>
    </section>
</div>
