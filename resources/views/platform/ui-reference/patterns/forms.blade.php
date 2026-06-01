<x-layouts.app title="UI Reference · Form Patterns">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.forms'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <x-ui.patterns.page-title-actions-row
            title="Form Patterns"
            description="Tier 2 form scaffolding built from the Tier 1 control, alert, and action baselines."
            kicker="Tier 2A"
        >
            <x-slot:actions>
                <x-ui.button variant="outline" size="sm">Desktop proof</x-ui.button>
                <x-ui.button semantic="primary" size="sm">Responsive proof</x-ui.button>
            </x-slot:actions>
        </x-ui.patterns.page-title-actions-row>

        <x-ui.patterns.proof-review-banner
            :items="[
                ['id' => 'P2-B-CQ-003', 'note' => 'Proof-only guidance should use the same clearly defined notice treatment as the rest of the active batch review mode.'],
                ['id' => 'P2-B-CQ-017', 'note' => 'Internal phone inputs should normalize plain digit entry into the shared baseline phone format instead of expecting manual punctuation.'],
            ]"
            :focus="[
                'Treat the review banner as temporary batch-review context, not permanent component UI.',
                'Judge the inline explanatory notes as library guidance that should stay visually separate from the component examples themselves.',
            ]"
        />

        <x-ui.patterns.proof-note semantic="notice" title="How to read this proof">
            Use option-backed selectors when the acceptable values are known up front, such as locale and timezone. Keep validator-heavy examples on fields the user truly types free-form, such as email addresses and phone numbers.
        </x-ui.patterns.proof-note>

        <x-ui.patterns.form-section
            title="Form Group and Form Section"
            description="Use form sections to group related fields under a shared heading, then wrap each field in a canonical form group."
            kicker="Grouped fields"
        >
            <form class="grid gap-5 lg:grid-cols-2" action="#" method="POST" onsubmit="event.preventDefault()">
                <x-ui.patterns.form-group for="pattern-workspace-name" label="Workspace Name" helper="Shared label visible in the app shell." required>
                    <input id="pattern-workspace-name" type="text" value="Platform Operations Workspace" class="ui-input w-full" />
                </x-ui.patterns.form-group>

                <x-ui.patterns.form-group for="pattern-owner-scope" label="Owner Scope" helper="Ownership stays internal to the current shell family.">
                    <select id="pattern-owner-scope" class="ui-select w-full">
                        <option>Platform Administrator</option>
                        <option>Base Operator</option>
                        <option>Read-only Auditor</option>
                    </select>
                </x-ui.patterns.form-group>

                <x-ui.patterns.form-group class="lg:col-span-2" for="pattern-description" label="Description" helper="Use a normal textarea inside the shared field wrapper.">
                    <textarea id="pattern-description" rows="4" class="ui-textarea w-full">Reusable Tier 2 scaffolding for future setup, settings, and account forms.</textarea>
                </x-ui.patterns.form-group>
            </form>
        </x-ui.patterns.form-section>

        <x-ui.patterns.content-section-block
            title="Inline Form Row"
            description="When space allows, keep labels and controls aligned horizontally without breaking label associations at narrow widths."
            kicker="Responsive row"
        >
            <div class="space-y-4">
                <x-ui.patterns.proof-review-target
                    :items="[
                        ['id' => 'P2-B-CQ-003', 'note' => 'This section carries proof-only selector guidance. The review target here is consistent proof-note treatment at the point where reviewers judge the pattern, not only in the page banner.'],
                    ]"
                />

                <x-ui.patterns.inline-form-row
                    for="inline-timezone"
                    label="Default Timezone"
                    helper="Search the approved timezone list inside the option-backed selector, then choose the default."
                >
                    <x-ui.searchable-select
                        id="inline-timezone"
                        name="inline_timezone"
                        :options="App\Support\UiOptionCatalog::timezoneOptions()"
                        selected="America/New_York"
                        placeholder="Choose a timezone"
                        search-placeholder="Search timezones"
                    />
                </x-ui.patterns.inline-form-row>

                <x-ui.patterns.proof-note semantic="notice" title="Selector intent">
                    This is the canonical integrated searchable selector variant for long known-option lists. Search happens inside the open dropdown, and the option list stays bounded to the viewport instead of stretching off-page.
                </x-ui.patterns.proof-note>

                <x-ui.patterns.inline-form-row
                    for="inline-locale"
                    label="Default Locale"
                    helper="Locale drives numeric and currency formatting and should come from the approved locale set."
                >
                    <x-ui.searchable-select
                        id="inline-locale"
                        name="inline_locale"
                        :options="App\Support\UiOptionCatalog::localeOptions()"
                        selected="en"
                        placeholder="Choose a locale"
                        search-placeholder="Search locales"
                    />
                </x-ui.patterns.inline-form-row>

                <x-ui.patterns.inline-form-row
                    for="inline-support-email"
                    label="Support Email"
                    helper="Use validator-driven copy on fields the operator actually types by hand."
                    error="Enter a valid email address for escalation notices."
                >
                    <input id="inline-support-email" type="email" value="ops@" aria-invalid="true" class="ui-input w-full" />
                </x-ui.patterns.inline-form-row>

                <x-ui.patterns.inline-form-row
                    for="inline-support-phone"
                    label="Support Phone"
                    helper="Plain ten-digit entry should auto-format to the internal phone baseline while still allowing standard extensions when needed."
                >
                    <x-ui.patterns.proof-review-target
                        :items="[
                            ['id' => 'P2-B-CQ-017', 'note' => 'The shared internal phone-input pattern should auto-normalize raw ten-digit entry to the canonical `(555) 555-5555` format on the proof surface and the consuming settings forms.'],
                        ]"
                    />

                    <input id="inline-support-phone" type="tel" value="" placeholder="e.g. (555) 867-5309 x204" class="ui-input w-full" data-ui-phone-input inputmode="tel" autocomplete="tel" />
                </x-ui.patterns.inline-form-row>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Validation Summary and Form Actions"
            description="Use a form-level error summary for multi-error flows, then keep actions grouped in a consistent footer bar."
            kicker="Submission state"
        >
            <div class="space-y-5">
                <x-ui.patterns.validation-summary
                    title="Review the fields below"
                    :errors="[
                        'Workspace name is required.',
                        'Owner scope must be selected before saving.',
                    ]"
                />

                <x-ui.patterns.form-actions-bar>
                    <x-slot:leading>
                        <x-ui.button variant="ghost">Cancel</x-ui.button>
                    </x-slot:leading>

                    <x-ui.button semantic="danger" variant="soft">Archive</x-ui.button>
                    <x-ui.button semantic="primary">Save Workspace</x-ui.button>
                </x-ui.patterns.form-actions-bar>
            </div>
        </x-ui.patterns.content-section-block>
    </section>
</x-layouts.app>
