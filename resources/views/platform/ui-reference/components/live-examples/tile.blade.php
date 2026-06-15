@php
    $boundaryRows = [
        ['Base/static tile', 'Short grouped content that may contain child links or buttons.', '<x-ui.tile variant="static" ... />', 'Implemented'],
        ['Clickable tile', 'One whole-tile link or command with no nested controls.', '<x-ui.tile variant="clickable" href="..." />', 'Implemented'],
        ['Selectable tile', 'One option in a visible choice set, backed by radio or checkbox semantics.', '<x-ui.tile variant="selectable" name="plan" value="growth" />', 'Implemented'],
        ['Expandable tile', 'Reveals a short secondary detail region with component-owned disclosure semantics.', '<x-ui.tile variant="expandable" expanded />', 'Implemented'],
        ['Media tile', 'Tile with image or illustration area.', 'none', 'Deferred'],
        ['Tile group helper', 'Reusable group/grid behavior, labels, and responsive orchestration.', 'none', 'Pattern-owned'],
        ['AI presence', 'AI-labelled tile treatment with explainability disclosure.', 'none', 'Gated'],
    ];
@endphp

<div class="space-y-6" data-component-live-layout="tile-matrix" data-ui-reference-sample-type="tile">
    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tile-live-section="base-tile">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Base tile</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Base tiles are non-interactive surfaces. They may contain approved child actions because the tile itself is not a target.</p>

        <div class="mt-4 grid gap-4 lg:grid-cols-2">
            <x-ui.tile title="Workspace activity" description="Review recent account events and user access changes." meta="Updated today" />

            <x-ui.tile title="Static tile with child actions" description="Child controls keep their own target and focus behavior.">
                <x-slot name="actions">
                    <x-ui.link href="#" variant="standalone" size="sm">Open activity</x-ui.link>
                    <x-ui.button semantic="neutral" size="sm">Download</x-ui.button>
                </x-slot>
            </x-ui.tile>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tile-live-section="clickable-tile">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Clickable tile</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Clickable tiles make the full container one link or one command. The arrow affordance sits bottom-right and nested controls are not allowed.</p>

        <div class="mt-4 grid gap-4 lg:grid-cols-3">
            <x-ui.tile variant="clickable" href="#" title="Manage users" description="Open access, roles, and status." meta="Navigation" />
            <x-ui.tile variant="clickable" title="Run audit check" description="Starts one local command." meta="Button action" />
            <x-ui.tile variant="clickable" title="Billing locked" description="Unavailable because billing is managed upstream." meta="Disabled" disabled />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tile-live-section="selectable-tile">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Selectable tile</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Selectable tiles keep the selection icon visible in the enabled state. Single choice uses radio-style icons; multi-select uses checkbox-style icons.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <fieldset class="min-w-0 rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <legend class="text-sm font-semibold" style="color: var(--ui-text-primary);">Single-select plan</legend>
                <div class="mt-3 grid gap-3">
                    <x-ui.tile variant="selectable" name="tile_plan" value="starter" selection-mode="single" title="Starter" description="Core workspace tools." />
                    <x-ui.tile variant="selectable" name="tile_plan" value="growth" selection-mode="single" title="Growth" description="Automation and review workflows." selected />
                    <x-ui.tile variant="selectable" name="tile_plan" value="enterprise" selection-mode="single" title="Enterprise" description="Unavailable for this tenant." disabled />
                </div>
            </fieldset>

            <fieldset class="min-w-0 rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <legend class="text-sm font-semibold" style="color: var(--ui-text-primary);">Multi-select features</legend>
                <div class="mt-3 grid gap-3">
                    <x-ui.tile variant="selectable" name="tile_features[]" value="audit" selection-mode="multiple" title="Audit export" description="Scheduled account exports." selected />
                    <x-ui.tile variant="selectable" name="tile_features[]" value="roles" selection-mode="multiple" title="Role review" description="Manager approval workflow." />
                    <x-ui.tile variant="selectable" name="tile_features[]" value="api" selection-mode="multiple" title="API access" description="Disabled until owner approval." disabled />
                </div>
            </fieldset>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tile-live-section="expandable-tile">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Expandable tile</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Expandable tiles reveal short supporting detail. If the revealed area needs interactive controls, use a static tile or a higher-level disclosure Pattern until that focus model is installed.</p>

        <div class="mt-4 grid gap-4 lg:grid-cols-2">
            <x-ui.tile id="tile-billing-details" variant="expandable" title="Billing details" description="View short billing metadata." expanded>
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

            <x-ui.tile id="tile-security-details" variant="expandable" title="Security summary" description="Collapsed state keeps secondary content hidden.">
                <x-slot name="details">
                    <p class="text-sm">This detail is hidden until the owning state opens the tile.</p>
                </x-slot>
            </x-ui.tile>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tile-live-section="layout-and-groups">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Tile groups and layout</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Parent Patterns own group labels, grid columns, and responsive placement. A related group should use the same tile variant and avoid mixed click targets.</p>

        <div class="mt-4 grid gap-4 lg:grid-cols-3">
            <x-ui.tile variant="clickable" href="#" title="Full width" description="Allowed at all breakpoints." />
            <x-ui.tile variant="clickable" href="#" title="One half" description="Allowed at all breakpoints." />
            <x-ui.tile variant="clickable" href="#" title="One third" description="Avoid at the smallest breakpoint." />
        </div>

        <div class="mt-4 grid gap-4 lg:grid-cols-[2fr_1fr]">
            <x-ui.tile title="Horizontal masonry" description="Tiles may vary in width when the row still stays coherent." />
            <x-ui.tile title="Standard grid" description="Same height and width is the default for scannable sets." />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tile-live-section="states-and-accessibility">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">States and accessibility</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Interactive tile states are token-backed and semantic: focus-visible outlines the operative surface, selected/current state is not color-only, and disabled interactive tiles are not activatable.</p>

        <div class="mt-4 grid gap-4 lg:grid-cols-4">
            <x-ui.tile variant="clickable" href="#" title="Hover target" description="Hover uses layer hover." />
            <x-ui.tile variant="clickable" href="#" title="Current route" description="Current state emits aria-current." current />
            <x-ui.tile variant="selectable" name="tile_state" value="selected" title="Selected option" description="Selected border and icon are visible." selected />
            <x-ui.tile variant="clickable" title="Disabled target" description="Unavailable command." disabled />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tile-live-section="boundaries-and-gates">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Boundaries and gates</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Tile owns compact surfaces and simple whole-tile behavior. Rich cards, media tiles, reusable tile groups, and AI presence require their owning standards before production use.</p>

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

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tile-live-section="developer-implementation">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Developer implementation</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Use the component API and state props. Do not hand-build tile borders, selected states, hover treatment, or local disclosure cards.</p>

        <pre class="ui-code-snippet mt-4" data-component-section="developer-code-example"><code>&lt;x-ui.tile
    variant="selectable"
    name="plan"
    value="growth"
    title="Growth"
    description="Automation and review workflows."
    selected
/&gt;</code></pre>
    </section>
</div>
