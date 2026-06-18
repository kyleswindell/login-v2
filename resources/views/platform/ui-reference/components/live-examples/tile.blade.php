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
    <section class="ui-reference-layer-section" data-tile-live-section="approved-variants">
        <div class="ui-reference-section-heading">
            <h3>Approved Variants</h3>
            <p>Tile variants are separated by behavior. Each tab shows applicable states first, then live examples for that variant.</p>
        </div>

        <div class="ui-tabs ui-tabs-contained mt-4" data-ui-tabs data-ui-tabs-activation="manual" data-tile-variant-tabs>
            <div class="ui-tabs-list" role="tablist" aria-label="Tile approved variants">
                <button id="tile-base-tab" type="button" class="ui-tabs-tab" role="tab" aria-selected="true" aria-controls="tile-base-panel" data-ui-tabs-tab>
                    Base Tile
                </button>
                <button id="tile-clickable-tab" type="button" class="ui-tabs-tab" role="tab" aria-selected="false" aria-controls="tile-clickable-panel" tabindex="-1" data-ui-tabs-tab>
                    Clickable Tile
                </button>
                <button id="tile-selectable-tab" type="button" class="ui-tabs-tab" role="tab" aria-selected="false" aria-controls="tile-selectable-panel" tabindex="-1" data-ui-tabs-tab>
                    Selectable Tile
                </button>
                <button id="tile-expandable-tab" type="button" class="ui-tabs-tab" role="tab" aria-selected="false" aria-controls="tile-expandable-panel" tabindex="-1" data-ui-tabs-tab>
                    Expandable Tile
                </button>
                <button id="tile-expandable-interactive-tab" type="button" class="ui-tabs-tab" role="tab" aria-selected="false" aria-controls="tile-expandable-interactive-panel" tabindex="-1" data-ui-tabs-tab>
                    Expandable Tile with Interactive Elements
                </button>
            </div>

            <div class="ui-tabs-panels">
                <section id="tile-base-panel" class="ui-tabs-panel space-y-6" role="tabpanel" aria-labelledby="tile-base-tab" data-ui-tabs-panel>
                    <div class="ui-reference-section-heading">
                        <h3>Base Tile</h3>
                        <p>Base tiles are non-interactive layer surfaces. They do not add a border by default and may contain approved child actions because the tile itself is not a target.</p>
                    </div>

                    <section>
                        <h4 class="ui-reference-example-title">States applicable to base tile</h4>
                        <div class="mt-3 ui-tile-layout-standard">
                            <x-ui.tile title="Enabled base tile" description="Static content surface on its own UI layer." meta="Status summary" />
                            <x-ui.tile title="Base tile with actions" description="Child controls own interaction; the tile remains static.">
                                <x-slot name="actions">
                                    <x-ui.button semantic="tertiary" size="sm">Open</x-ui.button>
                                    <x-ui.link href="#" variant="standalone" size="sm">Learn more</x-ui.link>
                                </x-slot>
                            </x-ui.tile>
                        </div>
                    </section>

                    <section>
                        <h4 class="ui-reference-example-title">Live examples</h4>
                        <div class="mt-3 ui-tile-layout-standard">
                            <x-ui.tile title="Lite" meta="30-day free trial" description="Per month, no contract">
                                <div class="ui-tile__body">
                                    <x-ui.tag type="green" size="sm" text="Featured product" />
                                    <p class="mt-4 border-t pt-3" style="border-color: var(--ui-border-subtle-01);">Get started with your first assistant.</p>
                                </div>
                                <x-slot name="actions">
                                    <x-ui.button semantic="primary" size="sm">Get started</x-ui.button>
                                </x-slot>
                            </x-ui.tile>

                            <x-ui.tile title="Standard" meta="30-day free trial" description="Per month, no contract">
                                <div class="ui-tile__body">
                                    <x-ui.tag type="blue" size="sm" text="Recommended" />
                                    <p class="mt-4 border-t pt-3" style="border-color: var(--ui-border-subtle-01);">Build a more robust and faster assistant.</p>
                                </div>
                                <x-slot name="actions">
                                    <x-ui.button semantic="primary" size="sm">Get started</x-ui.button>
                                </x-slot>
                            </x-ui.tile>
                        </div>
                    </section>
                </section>

                <section id="tile-clickable-panel" class="ui-tabs-panel space-y-6" role="tabpanel" aria-labelledby="tile-clickable-tab" data-ui-tabs-panel hidden>
                    <div class="ui-reference-section-heading">
                        <h3>Clickable Tile</h3>
                        <p>Clickable tiles make the whole tile one link or one command. They do not contain nested independent controls.</p>
                    </div>

                    <section>
                        <h4 class="ui-reference-example-title">States applicable to clickable tile</h4>
                        <div class="mt-3 ui-tile-layout-standard">
                            <x-ui.tile variant="clickable" href="#" title="Enabled" description="Whole-container navigation." />
                            <x-ui.tile variant="clickable" href="#" title="Current route" description="Current state emits route context." current />
                            <x-ui.tile class="ui-reference-force-focus" variant="clickable" href="#" title="Focus" description="Focus applies to the operative tile." />
                            <x-ui.tile variant="clickable" title="Disabled" description="Unavailable and visually disabled." disabled />
                        </div>
                    </section>

                    <section>
                        <h4 class="ui-reference-example-title">Live examples</h4>
                        <div class="mt-3 ui-tile-layout-standard">
                            <x-ui.tile variant="clickable" href="#" title="Access review" description="Review active users, role assignments, and tenant access flags." meta="Navigation" />
                            <x-ui.tile variant="clickable" title="Run audit check" description="Starts one local command for the selected workspace." meta="Button action" />
                        </div>
                    </section>
                </section>

                <section id="tile-selectable-panel" class="ui-tabs-panel space-y-6" role="tabpanel" aria-labelledby="tile-selectable-tab" data-ui-tabs-panel hidden>
                    <div class="ui-reference-section-heading">
                        <h3>Selectable Tile</h3>
                        <p>Selectable tiles only change the selection indicator and border when selected. Single-select uses radio semantics; multi-select uses checkbox semantics.</p>
                    </div>

                    <section>
                        <h4 class="ui-reference-example-title">States applicable to selectable tile</h4>
                        <div class="mt-3 ui-tile-layout-standard">
                            <x-ui.tile variant="selectable" name="tile_single_states" value="enabled" selection-mode="single" title="Enabled" description="Unselected radio tile." />
                            <x-ui.tile variant="selectable" name="tile_single_states" value="selected" selection-mode="single" title="Enabled selected" description="Selected radio tile." selected />
                            <x-ui.tile class="ui-reference-force-focus" variant="selectable" name="tile_single_states" value="focus" selection-mode="single" title="Focus" description="Focused radio tile." />
                            <x-ui.tile variant="selectable" name="tile_single_states" value="disabled" selection-mode="single" title="Disabled" description="Unavailable radio tile." disabled />
                        </div>
                    </section>

                    <section>
                        <h4 class="ui-reference-example-title">Single-select live group</h4>
                        <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Use single-select tiles when the user can only select one tile from a group.</p>
                        <div class="mt-3 ui-tile-layout-standard" role="radiogroup" aria-label="Tile table setup">
                            <x-ui.tile variant="selectable" name="tile_table_setup" value="manual" selection-mode="single" title="Selectable tables" description="Select tables manually." selected />
                            <x-ui.tile variant="selectable" name="tile_table_setup" value="recommended" selection-mode="single" title="Discover related tables" description="Let the system recommend related tables." />
                        </div>
                    </section>

                    <section>
                        <h4 class="ui-reference-example-title">Multi-select live group</h4>
                        <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Use multi-select tiles when the user can select multiple tiles from a group.</p>
                        <div class="mt-3 ui-tile-layout-standard" role="group" aria-label="Tile capability selection">
                            <x-ui.tile variant="selectable" name="tile_capabilities[]" value="collaboration" selection-mode="multiple" title="SPSS Collaboration & Deployment" selected />
                            <x-ui.tile variant="selectable" name="tile_capabilities[]" value="openshift" selection-mode="multiple" title="Red Hat Openshift Container Platform for Power" selected />
                            <x-ui.tile variant="selectable" name="tile_capabilities[]" value="security" selection-mode="multiple" title="Security Verify Governance" />
                            <x-ui.tile variant="selectable" name="tile_capabilities[]" value="networking" selection-mode="multiple" title="VMware vCloud Networking & Security" />
                        </div>
                    </section>
                </section>

                <section id="tile-expandable-panel" class="ui-tabs-panel space-y-6" role="tabpanel" aria-labelledby="tile-expandable-tab" data-ui-tabs-panel hidden>
                    <div class="ui-reference-section-heading">
                        <h3>Expandable Tile</h3>
                        <p>Expandable tiles without internal controls use the full tile trigger. The whole surface may hover and focus because it is the operative target.</p>
                    </div>

                    <section>
                        <h4 class="ui-reference-example-title">States applicable to expandable tile</h4>
                        <div class="mt-3 ui-tile-layout-standard">
                            <x-ui.tile id="tile-expandable-state-enabled" variant="expandable" title="Enabled" description="Collapsed expandable tile.">
                                <x-slot name="details">
                                    <p class="text-sm">Collapsed details become available after expansion.</p>
                                </x-slot>
                            </x-ui.tile>
                            <x-ui.tile id="tile-expandable-state-focus" class="ui-reference-force-focus" variant="expandable" title="Focus" description="Focus applies to the full trigger.">
                                <x-slot name="details">
                                    <p class="text-sm">Focus remains on the full tile trigger.</p>
                                </x-slot>
                            </x-ui.tile>
                            <x-ui.tile id="tile-expandable-state-disabled" variant="expandable" title="Disabled" description="Disabled expansion is not operable." disabled>
                                <x-slot name="details">
                                    <p class="text-sm">Disabled details remain unavailable.</p>
                                </x-slot>
                            </x-ui.tile>
                        </div>
                    </section>

                    <section>
                        <h4 class="ui-reference-example-title">Live examples</h4>
                        <div class="mt-3 ui-tile-layout-standard">
                            <x-ui.tile id="tile-setup-collapsed" variant="expandable" title="Setup" description="Check the steps before provisioning.">
                                <x-slot name="details">
                                    <p class="text-sm">Determine the location connecting to the cloud provider.</p>
                                </x-slot>
                            </x-ui.tile>
                            <x-ui.tile id="tile-setup-expanded" variant="expandable" title="Setup" description="Check the steps before provisioning." expanded>
                                <x-slot name="details">
                                    <div class="space-y-3 text-sm">
                                        <p><strong style="color: var(--ui-text-primary);">Determine the location connecting to IBM Cloud</strong></p>
                                        <p>Verify your colocation provider or Network Service Provider capabilities.</p>
                                        <p><strong style="color: var(--ui-text-primary);">Market your request</strong></p>
                                        <p>Open a dedicated request and complete it.</p>
                                    </div>
                                </x-slot>
                            </x-ui.tile>
                        </div>
                    </section>
                </section>

                <section id="tile-expandable-interactive-panel" class="ui-tabs-panel space-y-6" role="tabpanel" aria-labelledby="tile-expandable-interactive-tab" data-ui-tabs-panel hidden>
                    <div class="ui-reference-section-heading">
                        <h3>Expandable Tile with Interactive Elements</h3>
                        <p>Interactive expandable tiles keep internal controls independent. Only the bottom-right expansion button toggles details and receives toggle focus.</p>
                    </div>

                    <section>
                        <h4 class="ui-reference-example-title">States applicable to expandable tile with interactive elements</h4>
                        <div class="mt-3 ui-tile-layout-standard">
                            <x-ui.tile id="tile-expandable-interactive-enabled" variant="expandable" title="Enabled interactive" description="Internal controls do not toggle expansion." interactive expand-button-label="Expand account details">
                                <x-slot name="actions">
                                    <x-ui.link href="#" variant="standalone" size="sm">Link</x-ui.link>
                                </x-slot>
                                <x-slot name="details">
                                    <p class="text-sm">Only the bottom-right button opens this content.</p>
                                </x-slot>
                            </x-ui.tile>
                            <x-ui.tile id="tile-expandable-interactive-expanded" variant="expandable" title="Expanded interactive" description="Expanded content is visible." interactive expanded expand-button-label="Collapse account details">
                                <x-slot name="actions">
                                    <x-ui.link href="#" variant="standalone" size="sm">Link</x-ui.link>
                                </x-slot>
                                <x-slot name="details">
                                    <div class="grid gap-0 border-t text-sm sm:grid-cols-2" style="border-color: var(--ui-border-subtle-01);">
                                        <div class="border-r p-3" style="border-color: var(--ui-border-subtle-01);">Business terms<br>25</div>
                                        <div class="p-3">Business terms<br>25</div>
                                        <div class="border-t border-r p-3" style="border-color: var(--ui-border-subtle-01);">Business terms<br>25</div>
                                        <div class="border-t p-3" style="border-color: var(--ui-border-subtle-01);">Business terms<br>25</div>
                                    </div>
                                </x-slot>
                            </x-ui.tile>
                            <x-ui.tile id="tile-expandable-interactive-focus" variant="expandable" title="Toggle focus" description="Focus is scoped to the expand button." interactive expand-button-label="Expand focused details">
                                <x-slot name="details">
                                    <p class="text-sm">The container does not receive duplicate focus when this button is focused.</p>
                                </x-slot>
                            </x-ui.tile>
                            <x-ui.tile id="tile-expandable-interactive-disabled" variant="expandable" title="Disabled interactive" description="Disabled expansion button and tile content use disabled tokens." interactive disabled expand-button-label="Expand disabled details">
                                <x-slot name="actions">
                                    <x-ui.link href="#" variant="standalone" size="sm">Link</x-ui.link>
                                </x-slot>
                                <x-slot name="details">
                                    <p class="text-sm">Disabled details remain closed.</p>
                                </x-slot>
                            </x-ui.tile>
                        </div>
                    </section>
                </section>
            </div>
        </div>
    </section>

    <section class="ui-reference-layer-section" data-tile-live-section="layout">
        <div class="ui-reference-section-heading">
            <h3>Layout</h3>
            <p>Parent patterns own grid placement. Tile layouts use matching variants, consistent spacing, and grid-aligned proportions.</p>
        </div>

        <div class="ui-tabs ui-tabs-contained mt-4" data-ui-tabs data-ui-tabs-activation="manual" data-tile-layout-tabs>
            <div class="ui-tabs-list" role="tablist" aria-label="Tile layouts">
                <button id="tile-layout-standard-tab" type="button" class="ui-tabs-tab" role="tab" aria-selected="true" aria-controls="tile-layout-standard-panel" data-ui-tabs-tab>
                    Standard layout
                </button>
                <button id="tile-layout-vertical-tab" type="button" class="ui-tabs-tab" role="tab" aria-selected="false" aria-controls="tile-layout-vertical-panel" tabindex="-1" data-ui-tabs-tab>
                    Vertical masonry layout
                </button>
                <button id="tile-layout-horizontal-tab" type="button" class="ui-tabs-tab" role="tab" aria-selected="false" aria-controls="tile-layout-horizontal-panel" tabindex="-1" data-ui-tabs-tab>
                    Horizontal masonry layout
                </button>
            </div>

            <div class="ui-tabs-panels">
                <section id="tile-layout-standard-panel" class="ui-tabs-panel space-y-5" role="tabpanel" aria-labelledby="tile-layout-standard-tab" data-ui-tabs-panel>
                    <h4 class="ui-reference-example-title">Standard layout</h4>
                    <p class="text-sm" style="color: var(--ui-text-secondary);">Tiles are the same height and width as other tiles in the group. Standard layout is the default.</p>
                    <div class="ui-tile-layout-standard">
                        <x-ui.tile title="Standard tile" description="Same height and width." />
                        <x-ui.tile title="Standard tile" description="Aligned to the same grid." />
                        <x-ui.tile title="Standard tile" description="Matching variant treatment." />
                        <x-ui.tile title="Standard tile" description="Consistent scanning rhythm." />
                    </div>
                </section>

                <section id="tile-layout-vertical-panel" class="ui-tabs-panel space-y-5" role="tabpanel" aria-labelledby="tile-layout-vertical-tab" data-ui-tabs-panel hidden>
                    <h4 class="ui-reference-example-title">Vertical masonry layout</h4>
                    <p class="text-sm" style="color: var(--ui-text-secondary);">Tiles may vary in height, but width remains consistent.</p>
                    <div class="ui-tile-layout-vertical-masonry">
                        <x-ui.tile title="Short tile" description="Width stays consistent." />
                        <x-ui.tile title="Tall tile" description="Height may vary when content needs more lines while the column width stays aligned to the grid and readable at narrow breakpoints." />
                        <x-ui.tile title="Medium tile" description="Use this when content naturally varies by amount." />
                        <x-ui.tile title="Supporting tile" description="Keep the same variant treatment within the group." />
                    </div>
                </section>

                <section id="tile-layout-horizontal-panel" class="ui-tabs-panel space-y-5" role="tabpanel" aria-labelledby="tile-layout-horizontal-tab" data-ui-tabs-panel hidden>
                    <h4 class="ui-reference-example-title">Horizontal masonry layout</h4>
                    <p class="text-sm" style="color: var(--ui-text-secondary);">Tiles may vary in width, and different rows may vary in height, while tiles within a row stay coherent.</p>
                    <div class="ui-tile-layout-horizontal-masonry">
                        <x-ui.tile title="Wide tile" description="Tiles may vary in width when the row remains coherent." />
                        <x-ui.tile title="Narrow tile" description="Avoid very small fractions at small breakpoints." />
                        <x-ui.tile title="Half-width tile" description="Content remains readable." />
                        <x-ui.tile title="Wide summary tile" description="Use width changes only when the content hierarchy requires it." />
                    </div>
                </section>
            </div>
        </div>

        <div class="ui-tile-grid-proportions mt-5">
            <h4 class="ui-reference-example-title">Grid proportions</h4>
            <div class="overflow-x-auto rounded-md border" style="border-color: var(--ui-border-subtle-01);">
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
    interactive expand-button-label="Expand integration details"
&gt;
    &lt;x-slot name="actions"&gt;...&lt;/x-slot&gt;
    &lt;x-slot name="details"&gt;...&lt;/x-slot&gt;
&lt;/x-ui.tile&gt;</code></pre>
    </section>
</div>
