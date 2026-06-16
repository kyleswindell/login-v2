@php
    $singleLineRows = [
        ['title' => 'Domain rules', 'meta' => 'Ready'],
        ['title' => 'Security settings', 'meta' => 'Pending'],
        ['title' => 'Billing profile', 'meta' => 'Synced'],
        ['title' => 'Team access', 'meta' => 'Updated'],
        ['title' => 'Audit export', 'meta' => 'Scheduled'],
    ];

    $notificationRows = [
        ['title' => 'API sync completed', 'description' => 'All workspace records were updated.', 'meta' => 'Success', 'status' => 'success'],
        ['title' => 'Owner approval needed', 'description' => 'Security changes are waiting for review.', 'meta' => 'Warning', 'status' => 'warning'],
        ['title' => 'Billing method failed', 'description' => 'Update the payment method before renewal.', 'meta' => 'Error', 'status' => 'error'],
        ['title' => 'New tenant domain', 'description' => 'A domain was added to the routing table.', 'meta' => 'Info', 'status' => 'info'],
        ['title' => 'Export ready', 'description' => 'The audit export is available for download.', 'meta' => 'Ready', 'icon' => 'heroicon-o-document-arrow-down'],
    ];

    $dynamicRows = [
        ['title' => 'Short row', 'meta' => 'Small'],
        ['title' => 'A long row title wraps naturally instead of truncating important content', 'meta' => 'Wraps'],
        ['title' => 'Policy update', 'description' => 'This row includes a short description and still follows the default row height when one line is enough.', 'meta' => 'Medium'],
        ['title' => 'Domain routing exception', 'description' => 'Longer content can increase the row height while keeping the header height fixed and preserving consistent row alignment across the list.', 'meta' => 'Dynamic'],
        ['title' => 'Compact metadata', 'description' => 'Secondary copy remains optional; rows should stay structurally consistent inside a single production list.', 'meta' => 'Review'],
    ];

    $linkedRows = [
        ['title' => 'Open domain rules', 'description' => 'Whole row is one navigation target.', 'href' => '#contained-list-actionable-row', 'current' => true],
        ['title' => 'Open security settings', 'description' => 'Hover and focus apply to the row surface.', 'href' => '#contained-list-actionable-row'],
        ['title' => 'Open billing profile', 'description' => 'Active state uses the layer active token.', 'href' => '#contained-list-actionable-row'],
        ['title' => 'Open team access', 'description' => 'Disabled rows do not become links.', 'disabled' => true],
        ['title' => 'Open audit export', 'description' => 'The example target stays on this page.', 'href' => '#contained-list-actionable-row'],
    ];

    $actionRows = [
        ['title' => 'laura@example.com', 'description' => 'One row action remains inline.', 'meta' => 'Pending', 'actions' => [
            ['label' => 'Resend', 'semantic' => 'ghost', 'icon_only' => false],
        ]],
        ['title' => 'sam@example.com', 'description' => 'Multiple actions collapse into an overflow menu.', 'meta' => 'Pending', 'actions' => [
            ['label' => 'Resend', 'semantic' => 'neutral'],
            ['label' => 'Cancel invitation', 'semantic' => 'danger'],
        ]],
        ['title' => 'lee@example.com', 'description' => 'Rows keep a consistent action location.', 'meta' => 'Expired', 'actions' => [
            ['label' => 'Resend', 'semantic' => 'neutral'],
            ['label' => 'Archive invitation', 'semantic' => 'neutral'],
        ]],
        ['title' => 'morgan@example.com', 'description' => 'Disabled row action remains visibly unavailable.', 'meta' => 'Locked', 'actions' => [
            ['label' => 'Resend', 'semantic' => 'neutral', 'disabled' => true],
        ]],
        ['title' => 'jamie@example.com', 'description' => 'Do not mix different action positions within the same list.', 'meta' => 'Pending', 'actions' => [
            ['label' => 'Resend', 'semantic' => 'neutral'],
            ['label' => 'Remove', 'semantic' => 'danger'],
        ]],
    ];

    $scrollRows = [
        ['title' => 'January review', 'description' => 'Completed account review.', 'meta' => 'Jan 8'],
        ['title' => 'February review', 'description' => 'Completed account review.', 'meta' => 'Feb 12'],
        ['title' => 'March review', 'description' => 'Completed account review.', 'meta' => 'Mar 9'],
        ['title' => 'April review', 'description' => 'Completed account review.', 'meta' => 'Apr 11'],
        ['title' => 'May review', 'description' => 'Completed account review.', 'meta' => 'May 14'],
        ['title' => 'June review', 'description' => 'Completed account review.', 'meta' => 'Jun 10'],
        ['title' => 'July review', 'description' => 'Scheduled account review.', 'meta' => 'Jul 15'],
    ];

    $sectionRows = [
        ['title' => 'Recent filters', 'description' => 'Used in a temporary disclosure surface.', 'meta' => '3'],
        ['title' => 'Saved views', 'description' => 'Available to this workspace.', 'meta' => '2'],
        ['title' => 'Pinned report', 'description' => 'Shown at the top of the popover.', 'meta' => '1'],
        ['title' => 'Shared report', 'description' => 'Visible to managers.', 'meta' => '4'],
        ['title' => 'Archived view', 'description' => 'Kept for audit history.', 'meta' => '9'],
    ];
@endphp

<div id="contained-list-actionable-row" class="space-y-8" data-component-live-layout="contained-list-matrix" data-ui-reference-sample-type="contained-list">
    <section class="space-y-4" data-contained-list-live-section="on-page-list">
        <div>
            <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">On-page contained list</h3>
            <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Contained lists are the bounded list surface. They do not need to be wrapped in a separate card for ordinary on-page usage.</p>
        </div>

        <x-ui.contained-list
            title="Workspace checks"
            description="Single-line rows keep row height compact while the header height remains fixed."
            :items="$singleLineRows"
            variant="on-page"
            size="md"
        />
    </section>

    <section class="space-y-4" data-contained-list-live-section="sizing-and-dynamic-content">
        <div>
            <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Sizing and dynamic content</h3>
            <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Row heights can grow with content. Do not truncate important row labels just to preserve a fixed visual height.</p>
        </div>

        <div class="grid gap-5 xl:grid-cols-2">
            <x-ui.contained-list title="Notification-style rows" description="Status rows include title, description, metadata, and status icon support." :items="$notificationRows" variant="on-page" size="lg" inset-dividers />
            <x-ui.contained-list title="Dynamic row height" description="Long row text wraps and increases row height while the list header remains fixed." :items="$dynamicRows" variant="on-page" size="xl" />
        </div>
    </section>

    <section class="space-y-4" data-contained-list-live-section="interactive-elements">
        <div>
            <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Interactive elements</h3>
            <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Use one interaction type consistently within a row set. Multiple row actions collapse into an overflow menu instead of rendering several inline controls.</p>
        </div>

        <div class="grid gap-5 xl:grid-cols-2">
            <x-ui.contained-list title="Linked rows" description="The whole row is one target. Example links point to this section so the page does not leave the reference view." :items="$linkedRows" variant="on-page" size="lg" />
            <x-ui.contained-list title="Row actions" description="One action stays inline; multiple actions use the overflow menu button." :items="$actionRows" variant="on-page" size="lg" />
        </div>
    </section>

    <section class="space-y-4" data-contained-list-live-section="interactive-states">
        <div>
            <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Interactive states</h3>
            <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Interactive row surfaces and row controls use layer hover, focus, active, selected/current, and disabled tokens. Static rows do not receive hover treatment.</p>
        </div>

        <x-ui.contained-list
            title="Row state examples"
            description="Hover and focus are visible on linked rows and row controls; current state uses the current-row marker."
            :items="[
                ['title' => 'Default linked row', 'description' => 'Hover the row to see layer-hover.', 'href' => '#contained-list-actionable-row'],
                ['title' => 'Current linked row', 'description' => 'Current state is semantic and visible.', 'href' => '#contained-list-actionable-row', 'current' => true],
                ['title' => 'Selected row', 'description' => 'Selection remains gated to workflows with an approved selection model.', 'selected' => true],
                ['title' => 'Disabled row', 'description' => 'Disabled state uses disabled text and no link.', 'disabled' => true],
                ['title' => 'Inline action state', 'description' => 'The action control receives its own hover and focus state.', 'actions' => [['label' => 'Open', 'semantic' => 'ghost', 'icon_only' => false]]],
            ]"
            variant="on-page"
            size="lg"
        />
    </section>

    <section class="space-y-4" data-contained-list-live-section="search-and-filter">
        <div>
            <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Search and filtering</h3>
            <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Search/filter behavior belongs to the owning Pattern. Contained list can host a header action entry point or sit below a persistent search field.</p>
        </div>

        <div class="grid gap-5 xl:grid-cols-2">
            <x-ui.contained-list
                title="Header search action"
                description="The header action can open list-local search or filtering in an owning Pattern."
                header-action-label="Search rows"
                header-action-icon="heroicon-o-magnifying-glass"
                :items="$singleLineRows"
                variant="on-page"
            />

            <div class="space-y-3">
                <x-ui.search name="contained_list_filter" label="Filter workspaces" placeholder="Filter rows" />
                <x-ui.contained-list title="Persistent filter composition" aria-label="Filtered workspace checks" :items="$singleLineRows" variant="on-page" />
            </div>
        </div>
    </section>

    <section class="space-y-4" data-contained-list-live-section="scrolling-and-sticky-header">
        <div>
            <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Scrolling and sticky header</h3>
            <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">A constrained parent may own vertical scrolling. Sticky headers remain optional and must not trap keyboard or screen-reader users.</p>
        </div>

        <div class="max-h-80 overflow-y-auto">
            <x-ui.contained-list title="Scrollable review history" description="The header remains fixed while rows scroll underneath." :items="$scrollRows" variant="on-page" size="lg" sticky-header />
        </div>
    </section>

    <section class="space-y-4" data-contained-list-live-section="disclosed-list">
        <div>
            <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Disclosed list</h3>
            <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Use the disclosed variant inside temporary contexts such as popovers, drawers, or disclosures. This is the case where an enclosing border or elevated container is expected.</p>
        </div>

        <div class="rounded-lg border p-4 shadow-sm" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02); box-shadow: 0 18px 34px color-mix(in srgb, var(--ui-shadow-color) 16%, transparent);">
            <div class="max-h-96 overflow-y-auto">
                <div class="space-y-4">
                    <x-ui.contained-list title="Saved filters" :items="$sectionRows" variant="disclosed" size="lg" sticky-header />
                    <x-ui.contained-list title="Recent reports" :items="$notificationRows" variant="disclosed" size="lg" sticky-header />
                </div>
            </div>
        </div>
    </section>

    <section class="space-y-4" data-contained-list-live-section="boundaries-and-gates">
        <div>
            <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Boundaries and gates</h3>
            <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Use Data table for sorting, pagination, bulk actions, or complex comparison. Use Structured list when rows need comparable multi-field structure. Use List for content-only documentation lists.</p>
        </div>

        <div class="overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-subtle-01);">
            <table class="min-w-full text-left text-sm">
                <thead style="background-color: var(--ui-layer-02); color: var(--ui-text-secondary);">
                    <tr>
                        <th class="px-3 py-2 font-medium">Need</th>
                        <th class="px-3 py-2 font-medium">Use</th>
                        <th class="px-3 py-2 font-medium">Reason</th>
                    </tr>
                </thead>
                <tbody style="color: var(--ui-text-primary);">
                    <tr class="border-t" style="border-color: var(--ui-border-subtle-01);"><td class="px-3 py-2">Sorting, pagination, or bulk actions</td><td class="px-3 py-2">Data table</td><td class="px-3 py-2">Table owns those controls and row models.</td></tr>
                    <tr class="border-t" style="border-color: var(--ui-border-subtle-01);"><td class="px-3 py-2">Comparable multi-field rows</td><td class="px-3 py-2">Structured list</td><td class="px-3 py-2">Structured list owns row/column comparison without table tooling.</td></tr>
                    <tr class="border-t" style="border-color: var(--ui-border-subtle-01);"><td class="px-3 py-2">Body copy bullets</td><td class="px-3 py-2">List</td><td class="px-3 py-2">Content lists should remain native prose lists.</td></tr>
                    <tr class="border-t" style="border-color: var(--ui-border-subtle-01);"><td class="px-3 py-2">Rich object cards</td><td class="px-3 py-2">Tile/Card composition</td><td class="px-3 py-2">Tiles and cards own richer object surfaces.</td></tr>
                    <tr class="border-t" style="border-color: var(--ui-border-subtle-01);"><td class="px-3 py-2">Expandable row content</td><td class="px-3 py-2">Accordion</td><td class="px-3 py-2">Accordion owns disclosure behavior.</td></tr>
                </tbody>
            </table>
        </div>
    </section>
</div>
