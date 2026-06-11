<x-layouts.app title="UI Reference · Buttons And Icons">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'components.actions'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">Buttons And Icon Buttons</h1>
            <p class="ui-page-header-copy">Tier 1 contract for action hierarchy, state behavior, and light/dark parity.</p>
        </div>

        <x-ui.patterns.proof-review-banner
            :items="[
                ['id' => 'P2-B-CQ-014', 'note' => 'Review the shared action and menu-item colorway suite here before any narrower grouped-menu or account-menu retunes proceed.'],
                ['id' => 'P2-B-CQ-016', 'note' => 'Neutral ghost should now use the same borderless baseline as the semantic ghost variants across the shared action suite.'],
            ]"
            :focus="[
                'This page is the Tier 1 review surface for the shared action and menu-item entry points.',
                'Grouped-action pattern pages remain downstream validation surfaces for the same suite rather than separate local overrides.',
            ]"
        />

        <section class="ui-card" data-ui-guidance="action-usage" data-guidance-id="P2-F-CQ-008">
            <p class="ui-kicker">Button Variant Usage Guidance</p>
            <div class="mt-3 grid gap-4 lg:grid-cols-[minmax(0,1fr)_minmax(0,1fr)]">
                <div>
                    <h2 class="text-base font-semibold ui-reference-text-strong">Variant selection rules</h2>
                    <dl class="mt-3 space-y-3 text-sm ui-reference-text">
                        <div>
                            <dt class="font-semibold ui-reference-text-strong">G-ACT-01 - One primary action</dt>
                            <dd class="mt-1">Each page, modal, card region, or form action row gets one primary action. Additional actions must reduce emphasis before introducing another primary button.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold ui-reference-text-strong">G-ACT-02 - Standard button</dt>
                            <dd class="mt-1">Use the standard filled treatment for the dominant submit, create, save, or continue action in the current region.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold ui-reference-text-strong">G-ACT-03 - Soft button</dt>
                            <dd class="mt-1">Use soft when the action is important but supportive, such as a status-aware follow-up or review note that should not compete with the primary action.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold ui-reference-text-strong">G-ACT-04 - Ghost and outline buttons</dt>
                            <dd class="mt-1">Use ghost for cancel, close, reset, and low-emphasis navigation. Use outline for a visible alternate path that should remain secondary.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold ui-reference-text-strong">G-ACT-05 - Destructive actions</dt>
                            <dd class="mt-1">Use the danger semantic for delete, archive, disable, and irreversible actions. Do not hide destructive intent behind neutral ghost styling.</dd>
                        </div>
                    </dl>
                </div>

                <div data-ui-guidance="action-labels">
                    <h2 class="text-base font-semibold ui-reference-text-strong">Action label rules</h2>
                    <dl class="mt-3 space-y-3 text-sm ui-reference-text">
                        <div>
                            <dt class="font-semibold ui-reference-text-strong">G-LABEL-01 - Apply</dt>
                            <dd class="mt-1">Use Apply when the user stays on the same page and the current list, table, filter, or preview updates in place.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold ui-reference-text-strong">G-LABEL-02 - Save</dt>
                            <dd class="mt-1">Use Save when the user persists edits to the current resource. Pair with Cancel when leaving unsaved changes is possible.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold ui-reference-text-strong">G-LABEL-03 - Create / Submit / Send</dt>
                            <dd class="mt-1">Use a completion verb when the action creates a record, submits a workflow, sends data, or returns the user to the prior task surface.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold ui-reference-text-strong">G-LABEL-04 - Cancel / Close</dt>
                            <dd class="mt-1">Use Cancel for abandoning editable work and Close for dismissing read-only or completed surfaces.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold ui-reference-text-strong">G-LABEL-05 - Reset / Clear</dt>
                            <dd class="mt-1">Use Reset or Clear for removing filters or restoring defaults. These labels must not persist a resource.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold ui-reference-text-strong">G-LABEL-06 - Destructive verbs</dt>
                            <dd class="mt-1">Use Delete, Archive, Disable, or Remove with the target object named nearby and the danger semantic visible.</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </section>

        <section class="ui-card" data-ui-reference-example="button-variant-contract" data-guidance-id="P2-F-CQ-008">
            <p class="ui-kicker">Component Button Reference Examples</p>
            <h2 class="ui-card-title mt-2">Valid button variants and states</h2>
            <p class="ui-card-copy">Use these examples as the implementation contract before creating new action treatments. The filled primary example is the only primary action in this region.</p>

            <div class="mt-5 grid gap-4 lg:grid-cols-2 xl:grid-cols-3">
                <article class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Standard</p>
                    <x-ui.button semantic="primary" class="mt-3">Save Workspace</x-ui.button>
                    <code class="mt-3 block rounded-md ui-reference-code-surface px-3 py-2 text-xs ui-reference-text">&lt;x-ui.button semantic=&quot;primary&quot;&gt;Save Workspace&lt;/x-ui.button&gt;</code>
                </article>

                <article class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Soft</p>
                    <x-ui.button semantic="notice" variant="soft" class="mt-3">Queue Review</x-ui.button>
                    <code class="mt-3 block rounded-md ui-reference-code-surface px-3 py-2 text-xs ui-reference-text">&lt;x-ui.button semantic=&quot;notice&quot; variant=&quot;soft&quot;&gt;Queue Review&lt;/x-ui.button&gt;</code>
                </article>

                <article class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Ghost</p>
                    <x-ui.button variant="ghost" class="mt-3">Cancel</x-ui.button>
                    <code class="mt-3 block rounded-md ui-reference-code-surface px-3 py-2 text-xs ui-reference-text">&lt;x-ui.button variant=&quot;ghost&quot;&gt;Cancel&lt;/x-ui.button&gt;</code>
                </article>

                <article class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Outline</p>
                    <x-ui.button variant="outline" class="mt-3">Open Settings</x-ui.button>
                    <code class="mt-3 block rounded-md ui-reference-code-surface px-3 py-2 text-xs ui-reference-text">&lt;x-ui.button variant=&quot;outline&quot;&gt;Open Settings&lt;/x-ui.button&gt;</code>
                </article>

                <article class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Destructive</p>
                    <x-ui.button semantic="danger" class="mt-3">Delete Workspace</x-ui.button>
                    <code class="mt-3 block rounded-md ui-reference-code-surface px-3 py-2 text-xs ui-reference-text">&lt;x-ui.button semantic=&quot;danger&quot;&gt;Delete Workspace&lt;/x-ui.button&gt;</code>
                </article>

                <article class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Icon Only</p>
                    <x-ui.icon-button label="Open filters" class="mt-3">
                        <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                    </x-ui.icon-button>
                    <code class="mt-3 block rounded-md ui-reference-code-surface px-3 py-2 text-xs ui-reference-text">&lt;x-ui.icon-button label=&quot;Open filters&quot;&gt;...&lt;/x-ui.icon-button&gt;</code>
                </article>
            </div>

            <div class="mt-5 grid gap-4 lg:grid-cols-2" data-ui-reference-example="button-state-contract">
                <article class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Supported States</p>
                    <div class="mt-3 flex flex-wrap items-center gap-3">
                        <x-ui.button semantic="primary">Default</x-ui.button>
                        <x-ui.button semantic="primary" class="ring-2 is-focus">Focus</x-ui.button>
                        <x-ui.button semantic="primary" disabled>Disabled</x-ui.button>
                        <x-ui.button semantic="primary" loading>Loading</x-ui.button>
                    </div>
                </article>

                <article class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Icon Leading + Grouped Menu</p>
                    <div class="mt-3 flex flex-wrap items-center gap-3">
                        <x-ui.button variant="outline">
                            <x-heroicon-o-arrow-down-tray class="h-4 w-4" aria-hidden="true" />
                            Export Results
                        </x-ui.button>
                        <div class="ui-reference-subtle-surface p-2">
                            <x-ui.menu-item href="#" onclick="event.preventDefault()">Open details</x-ui.menu-item>
                            <x-ui.menu-item href="#" semantic="danger" onclick="event.preventDefault()">Archive workspace</x-ui.menu-item>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <section class="ui-card" data-ui-implementation-guide="actions" data-guidance-id="P2-F-CQ-008">
            <p class="ui-kicker">Action Implementation Guide</p>
            <div class="mt-4 ui-reference-table-shell overflow-x-auto">
                <table class="w-full min-w-[760px] text-left text-sm">
                    <thead class="ui-reference-table-head text-xs uppercase tracking-[0.16em]">
                        <tr>
                            <th class="px-4 py-3">Use</th>
                            <th class="px-4 py-3">Component</th>
                            <th class="px-4 py-3">Supported contract</th>
                            <th class="px-4 py-3">Owner routes</th>
                        </tr>
                    </thead>
                    <tbody class="ui-reference-table-body">
                        <tr>
                            <td class="px-4 py-3 ui-reference-text-strong">Button action</td>
                            <td class="px-4 py-3"><code>x-ui.button</code></td>
                            <td class="px-4 py-3"><code>semantic</code>: neutral, primary, success, warning, danger, notice, info. <code>variant</code>: standard, soft, ghost, outline. <code>size</code>, <code>disabled</code>, and <code>loading</code> are supported.</td>
                            <td class="px-4 py-3">/components/actions, /patterns/navigation, /patterns/forms, /patterns/tables</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 ui-reference-text-strong">Icon-only action</td>
                            <td class="px-4 py-3"><code>x-ui.icon-button</code></td>
                            <td class="px-4 py-3">Requires a visible accessible <code>label</code>. Use for compact tools such as filter, edit, close, and row utility actions.</td>
                            <td class="px-4 py-3">/components/actions, /patterns/tables, /patterns/overlays-feedback</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 ui-reference-text-strong">Grouped overflow</td>
                            <td class="px-4 py-3"><code>x-ui.patterns.dropdown-action-menu</code> + <code>x-ui.menu-item</code></td>
                            <td class="px-4 py-3">Use after one or two visible secondary actions. Destructive items follow a divider and keep <code>semantic=&quot;danger&quot;</code>.</td>
                            <td class="px-4 py-3">/patterns/navigation, /patterns/data-content, /patterns/tables</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Semantic Actions</p>
            <div class="mt-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                <x-ui.button>Neutral</x-ui.button>
                <x-ui.button semantic="primary">Primary</x-ui.button>
                <x-ui.button semantic="success">Success</x-ui.button>
                <x-ui.button semantic="warning">Warning</x-ui.button>
                <x-ui.button semantic="danger">Danger</x-ui.button>
                <x-ui.button semantic="notice">Notice</x-ui.button>
                <x-ui.button semantic="info">Info</x-ui.button>
                <x-ui.button variant="ghost">Ghost</x-ui.button>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Variant Styles</p>
            <p class="mt-2 text-sm ui-reference-text-muted">Soft and outline variants must preserve contrast in both themes.</p>
            <x-ui.patterns.proof-review-target
                class="mt-4"
                :items="[
                    ['id' => 'P2-B-CQ-014', 'note' => 'Verify the supported semantic colorways and their outline/ghost usage through this shared Tier 1 matrix instead of grouped-menu one-offs.'],
                    ['id' => 'P2-B-CQ-016', 'note' => 'Neutral ghost should now read as the same borderless low-emphasis treatment as the semantic ghost variants in this matrix.'],
                ]"
            />
            <div class="mt-4 space-y-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Soft</p>
                    <div class="mt-3 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                        <x-ui.button variant="soft">Soft Neutral</x-ui.button>
                        <x-ui.button semantic="primary" variant="soft">Soft Primary</x-ui.button>
                        <x-ui.button semantic="success" variant="soft">Soft Success</x-ui.button>
                        <x-ui.button semantic="warning" variant="soft">Soft Warning</x-ui.button>
                        <x-ui.button semantic="danger" variant="soft">Soft Danger</x-ui.button>
                        <x-ui.button semantic="notice" variant="soft">Soft Notice</x-ui.button>
                        <x-ui.button semantic="info" variant="soft">Soft Info</x-ui.button>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Outline</p>
                    <div class="mt-3 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                        <x-ui.button variant="outline">Outline Neutral</x-ui.button>
                        <x-ui.button semantic="primary" variant="outline">Outline Primary</x-ui.button>
                        <x-ui.button semantic="success" variant="outline">Outline Success</x-ui.button>
                        <x-ui.button semantic="warning" variant="outline">Outline Warning</x-ui.button>
                        <x-ui.button semantic="danger" variant="outline">Outline Danger</x-ui.button>
                        <x-ui.button semantic="notice" variant="outline">Outline Notice</x-ui.button>
                        <x-ui.button semantic="info" variant="outline">Outline Info</x-ui.button>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Ghost</p>
                    <div class="mt-3 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                        <x-ui.button variant="ghost">Ghost Neutral</x-ui.button>
                        <x-ui.button semantic="primary" variant="ghost">Ghost Primary</x-ui.button>
                        <x-ui.button semantic="success" variant="ghost">Ghost Success</x-ui.button>
                        <x-ui.button semantic="warning" variant="ghost">Ghost Warning</x-ui.button>
                        <x-ui.button semantic="danger" variant="ghost">Ghost Danger</x-ui.button>
                        <x-ui.button semantic="notice" variant="ghost">Ghost Notice</x-ui.button>
                        <x-ui.button semantic="info" variant="ghost">Ghost Info</x-ui.button>
                    </div>
                    <div class="mt-4 grid gap-4 md:grid-cols-2">
                        <div class="ui-reference-subtle-surface p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Neutral Ghost Baseline</p>
                            <x-ui.button variant="ghost" class="mt-3">Close review</x-ui.button>
                        </div>
                        <div class="ui-reference-subtle-surface p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Semantic Ghost Parity</p>
                            <x-ui.button semantic="notice" variant="ghost" class="mt-3">Open reviewer note</x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Menu Item Colorways</p>
            <p class="mt-2 text-sm ui-reference-text-muted">Grouped-action menus should consume one shared item treatment, including the canonical current-item state, instead of page-local text color overrides.</p>
            <x-ui.patterns.proof-review-target
                class="mt-4"
                :items="[
                    ['id' => 'P2-B-CQ-014', 'note' => 'All supported standard colorways, including the shared current-item state, should be reviewable here through the menu-item entry point before downstream consumers adopt them.'],
                ]"
            />
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <div class="ui-reference-subtle-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Standard Menu</p>
                    <div class="mt-3 rounded-lg border ui-reference-border ui-reference-subtle-surface p-2">
                        <x-ui.menu-item href="#" onclick="event.preventDefault()">Neutral action</x-ui.menu-item>
                        <x-ui.menu-item href="#" semantic="primary" onclick="event.preventDefault()">Primary follow-up</x-ui.menu-item>
                        <x-ui.menu-item href="#" semantic="success" onclick="event.preventDefault()">Approve queue item</x-ui.menu-item>
                        <x-ui.menu-item href="#" semantic="notice" onclick="event.preventDefault()">Open reviewer note</x-ui.menu-item>
                    </div>
                </div>
                <div class="ui-reference-subtle-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Caution Menu</p>
                    <div class="mt-3 rounded-lg border ui-reference-border ui-reference-subtle-surface p-2">
                        <x-ui.menu-item href="#" semantic="info" onclick="event.preventDefault()">View activity feed</x-ui.menu-item>
                        <x-ui.menu-item href="#" semantic="warning" onclick="event.preventDefault()">Escalate for review</x-ui.menu-item>
                        <div class="ui-pattern-dropdown-divider"></div>
                        <x-ui.menu-item href="#" semantic="danger" onclick="event.preventDefault()">Archive workspace</x-ui.menu-item>
                    </div>
                </div>
                <div class="ui-reference-subtle-surface p-4 lg:col-span-2">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Current Item States</p>
                    <div class="mt-3 grid gap-1 rounded-lg border ui-reference-border ui-reference-subtle-surface p-2 md:grid-cols-2 xl:grid-cols-3">
                        <x-ui.menu-item href="#" current onclick="event.preventDefault()">Current neutral item</x-ui.menu-item>
                        <x-ui.menu-item href="#" semantic="primary" current onclick="event.preventDefault()">Current primary item</x-ui.menu-item>
                        <x-ui.menu-item href="#" semantic="success" current onclick="event.preventDefault()">Current success item</x-ui.menu-item>
                        <x-ui.menu-item href="#" semantic="warning" current onclick="event.preventDefault()">Current warning item</x-ui.menu-item>
                        <x-ui.menu-item href="#" semantic="danger" current onclick="event.preventDefault()">Current danger item</x-ui.menu-item>
                        <x-ui.menu-item href="#" semantic="notice" current onclick="event.preventDefault()">Current notice item</x-ui.menu-item>
                        <x-ui.menu-item href="#" semantic="info" current onclick="event.preventDefault()">Current info item</x-ui.menu-item>
                    </div>
                </div>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Size And State</p>
            <div class="mt-4 flex flex-wrap items-center gap-3">
                <x-ui.button semantic="primary" size="xs">XS</x-ui.button>
                <x-ui.button semantic="primary" size="sm">SM</x-ui.button>
                <x-ui.button semantic="primary" size="md">MD</x-ui.button>
                <x-ui.button semantic="primary" size="lg">LG</x-ui.button>
                <x-ui.button semantic="primary" size="xl">XL</x-ui.button>
            </div>
            <div class="mt-4 flex flex-wrap items-center gap-3">
                <x-ui.button semantic="primary" disabled>Disabled</x-ui.button>
                <x-ui.button semantic="primary" loading>Loading…</x-ui.button>
                <x-ui.icon-button label="Filter results">
                    <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                </x-ui.icon-button>
                <x-ui.icon-button label="Disabled icon action" disabled>
                    <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                </x-ui.icon-button>
            </div>
            <div class="mt-4 grid gap-3 md:grid-cols-2 xl:grid-cols-3">
                <x-ui.button semantic="primary">
                    <x-heroicon-o-plus class="h-4 w-4" aria-hidden="true" />
                    Create Workspace
                </x-ui.button>
                <x-ui.button variant="outline">
                    <x-heroicon-o-cog-6-tooth class="h-4 w-4" aria-hidden="true" />
                    Open Settings
                </x-ui.button>
                <x-ui.button semantic="warning" variant="outline">
                    <x-heroicon-o-arrow-down-tray class="h-4 w-4" aria-hidden="true" />
                    Export Results
                </x-ui.button>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Review State Matrix</p>
            <p class="mt-2 text-sm ui-reference-text-muted">All required Tier 1 action states are visible here for manual inspection.</p>
            <div class="mt-4 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                <div class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Default</p>
                    <x-ui.button semantic="primary" class="mt-3">Primary Action</x-ui.button>
                </div>
                <div class="rounded-lg border ui-reference-border-strong ui-reference-subtle-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Hover Snapshot</p>
                    <x-ui.button semantic="primary" class="mt-3 border-blue-500/65 bg-blue-600/35 text-blue-50">Primary Action</x-ui.button>
                </div>
                <div class="rounded-lg border ui-reference-border-strong ui-reference-subtle-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Focus Snapshot</p>
                    <x-ui.button semantic="primary" class="mt-3 ring-2 is-focus">Primary Action</x-ui.button>
                </div>
                <div class="rounded-lg border ui-reference-border-strong ui-reference-subtle-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Danger Focus Snapshot</p>
                    <x-ui.button semantic="danger" class="mt-3 ring-2 is-focus">Danger Action</x-ui.button>
                </div>
                <div class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Active Snapshot</p>
                    <x-ui.button semantic="primary" class="mt-3 border-blue-700/70 bg-blue-700/45 text-blue-50">Primary Action</x-ui.button>
                </div>
                <div class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Disabled</p>
                    <x-ui.button semantic="primary" class="mt-3" disabled>Primary Action</x-ui.button>
                </div>
                <div class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Loading</p>
                    <x-ui.button semantic="primary" class="mt-3" loading>Loading</x-ui.button>
                </div>
            </div>
            <div class="mt-4 grid gap-4 md:grid-cols-2">
                <div class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Icon Button Focus</p>
                    <x-ui.icon-button label="Focused icon action" class="mt-3 ring-2 is-focus">
                        <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                    </x-ui.icon-button>
                </div>
                <div class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Icon Button Disabled</p>
                    <x-ui.icon-button label="Disabled icon action" class="mt-3" disabled>
                        <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                    </x-ui.icon-button>
                </div>
                <div class="rounded-lg border ui-reference-border-strong ui-reference-subtle-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Icon Button Hover Snapshot</p>
                    <x-ui.icon-button label="Hovered icon action" class="mt-3 is-hover">
                        <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                    </x-ui.icon-button>
                </div>
                <div class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Icon Button Active Snapshot</p>
                    <x-ui.icon-button label="Active icon action" class="mt-3 is-active">
                        <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                    </x-ui.icon-button>
                </div>
            </div>
        </section>
    </section>
</x-layouts.app>
