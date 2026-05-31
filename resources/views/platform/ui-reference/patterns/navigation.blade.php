<x-layouts.app title="UI Reference · Navigation And Action Patterns">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.navigation'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <x-ui.patterns.page-title-actions-row
            title="Navigation And Action Patterns"
            description="Tier 2 proof for page title rows, shared section navigation, grouped actions, and shell-aligned navigation behavior."
            kicker="Tier 2C / Tier 2E / Tier 2F"
        >
            <x-slot:context>
                <div class="flex flex-wrap items-center gap-2 text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">
                    <span class="rounded-full border border-slate-700 px-3 py-1">dashboard shell</span>
                    <span class="rounded-full border border-slate-700 px-3 py-1">settings shell</span>
                    <span class="rounded-full border border-slate-700 px-3 py-1">setup shell</span>
                </div>
            </x-slot:context>
            <x-slot:actions>
                <x-ui.button variant="ghost">Secondary</x-ui.button>
                <x-ui.button semantic="primary">Primary Action</x-ui.button>
            </x-slot:actions>
        </x-ui.patterns.page-title-actions-row>

        <x-ui.patterns.content-section-block
            title="Sub-navigation Bar"
            description="Use sub-navigation only for peer content areas that already belong to the same internal shell family."
            kicker="Section navigation"
        >
            <x-ui.patterns.sub-navigation-bar
                :items="[
                    ['label' => 'General', 'href' => '#', 'current' => true],
                    ['label' => 'Company Info', 'href' => '#'],
                    ['label' => 'Localization', 'href' => '#'],
                    ['label' => 'Email', 'href' => '#'],
                    ['label' => 'System Update', 'href' => '#', 'disabled' => true],
                ]"
            />
        </x-ui.patterns.content-section-block>

        <div class="grid gap-6 xl:grid-cols-[1.2fr_minmax(0,0.8fr)]">
            <x-ui.patterns.content-section-block
                title="Dropdown Action Menu"
                description="Compact grouped actions should sit behind a trigger without becoming a one-off feature menu."
                kicker="Grouped actions"
            >
                <div class="flex flex-wrap items-center gap-3">
                    <x-ui.patterns.dropdown-action-menu label="Workspace Actions">
                        <a href="#" class="ui-pattern-dropdown-link" onclick="event.preventDefault()">View details</a>
                        <a href="#" class="ui-pattern-dropdown-link" onclick="event.preventDefault()">Open proof surface</a>
                        <div class="ui-pattern-dropdown-divider"></div>
                        <a href="#" class="ui-pattern-dropdown-link text-rose-300" onclick="event.preventDefault()">Archive workspace</a>
                    </x-ui.patterns.dropdown-action-menu>

                    <x-ui.patterns.dropdown-action-menu label="More" :icon-only="true">
                        <a href="#" class="ui-pattern-dropdown-link" onclick="event.preventDefault()">Edit labels</a>
                        <a href="#" class="ui-pattern-dropdown-link" onclick="event.preventDefault()">Export summary</a>
                    </x-ui.patterns.dropdown-action-menu>
                </div>
            </x-ui.patterns.content-section-block>

            <x-ui.patterns.content-section-block
                title="Search And Filter Bar"
                description="Search, filter, and reset controls should align as one reusable control row above list or table content."
                kicker="Operator controls"
            >
                <x-ui.patterns.search-filter-bar>
                    <label class="relative block w-full max-w-sm">
                        <span class="sr-only">Search records</span>
                        <span class="pointer-events-none absolute inset-y-0 left-0 inline-flex w-9 items-center justify-center text-slate-500">
                            <x-heroicon-o-magnifying-glass class="h-4 w-4" aria-hidden="true" />
                        </span>
                        <input type="text" placeholder="Search name or owner" class="ui-input w-full pl-9" />
                    </label>
                    <select class="ui-select w-full sm:w-56">
                        <option>Any owner</option>
                        <option>Platform Team</option>
                        <option>Security</option>
                    </select>
                    <x-slot:actions>
                        <x-ui.button variant="ghost">Reset</x-ui.button>
                        <x-ui.button semantic="primary">Apply</x-ui.button>
                    </x-slot:actions>
                </x-ui.patterns.search-filter-bar>
            </x-ui.patterns.content-section-block>
        </div>

        <x-ui.patterns.content-section-block
            title="Shell Navigation Behavior"
            description="Tier 1 shell regions stay structural; these notes define how the shared navigation patterns should present inside those shells."
            kicker="Shell family rules"
        >
            <div class="grid gap-4 lg:grid-cols-3">
                <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.15em] text-slate-300">Dashboard</h3>
                    <ul class="mt-3 list-disc space-y-1 pl-4 text-sm text-slate-300">
                        <li>Header title row leads the page.</li>
                        <li>Widget actions stay local to widgets or the page header.</li>
                        <li>Dashboard grid owns summary layout only.</li>
                    </ul>
                </article>
                <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.15em] text-slate-300">Settings / Setup</h3>
                    <ul class="mt-3 list-disc space-y-1 pl-4 text-sm text-slate-300">
                        <li>Sub-navigation sits below the page title row.</li>
                        <li>Secondary shell navigation stays separate from field-group actions.</li>
                        <li>Registration fields belong inside dedicated content sections.</li>
                    </ul>
                </article>
                <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.15em] text-slate-300">Mobile / Narrow Width</h3>
                    <ul class="mt-3 list-disc space-y-1 pl-4 text-sm text-slate-300">
                        <li>Header actions wrap before introducing bespoke mobile controls.</li>
                        <li>Sub-navigation remains horizontally scrollable.</li>
                        <li>Grouped action menus must remain keyboard reachable.</li>
                    </ul>
                </article>
            </div>
        </x-ui.patterns.content-section-block>
    </section>
</x-layouts.app>
