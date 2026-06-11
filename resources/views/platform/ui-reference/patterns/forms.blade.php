<x-layouts.app title="UI Reference · Form Patterns">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.forms'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <x-ui.patterns.page-title-actions-row
            title="Form Patterns"
            description="Tier 2 form scaffolding built from the Tier 1 control, searchable dropdown, alert, and action baselines."
            kicker="Tier 2A"
        >
            <x-slot:actions>
                <x-ui.button variant="outline" size="sm">Desktop proof</x-ui.button>
                <x-ui.button semantic="primary" size="sm">Responsive proof</x-ui.button>
            </x-slot:actions>
        </x-ui.patterns.page-title-actions-row>

        <x-ui.patterns.proof-review-banner
            :items="[
                ['id' => 'P2-B-CQ-001', 'note' => 'Review the shared searchable dropdown-select shell here. The trigger, embedded search row, and current-selection state should read as one Inputs And Forms standard instead of a page-local localization fix.'],
                ['id' => 'P2-B-CQ-003', 'note' => 'Proof-only guidance should use the same clearly defined notice treatment as the rest of the active batch review mode.'],
                ['id' => 'P2-B-CQ-017', 'note' => 'Internal phone inputs should normalize plain digit entry into the shared baseline phone format instead of expecting manual punctuation.'],
            ]"
            :focus="[
                'Judge the timezone and locale rows as the canonical Inputs And Forms searchable dropdown standard, not as a localization-only demo.',
                'Treat the review banner as temporary batch-review context, not permanent component UI.',
                'Judge the inline explanatory notes as library guidance that should stay visually separate from the component examples themselves.',
            ]"
        />

        <x-ui.patterns.proof-note semantic="notice" title="How to read this proof">
            Use option-backed selectors and the shared searchable dropdown when the acceptable values are known up front, such as locale and timezone. Keep validator-heavy examples on fields the user truly types free-form, such as email addresses and phone numbers.
        </x-ui.patterns.proof-note>

        <x-ui.patterns.proof-note semantic="info" title="Form usage guidance">
            <div data-ui-guidance="form-pattern-usage" data-guidance-id="P2-F-CQ-010">
                <ul class="list-disc space-y-1 pl-5">
                    <li><span class="font-semibold">G-FORM-01:</span> required fields are marked in the label and reinforced with helper or validation copy when needed.</li>
                    <li><span class="font-semibold">G-FORM-03:</span> submit validation belongs in the form-level summary and the affected field group.</li>
                    <li><span class="font-semibold">G-SEL-02:</span> short exclusive choices stay visible as radio options instead of being hidden in a select menu.</li>
                    <li><span class="font-semibold">Select / combo box / multi-select:</span> choose the smallest control that makes the option set scannable before saving.</li>
                </ul>
            </div>
        </x-ui.patterns.proof-note>

        <section class="ui-card" data-ui-reference-example="t2-form-composition" data-guidance-id="P2-F-CQ-010">
            <p class="ui-kicker">Pattern Form Composition Examples</p>
            <div class="mt-5 grid gap-5 xl:grid-cols-2">
                <article class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Settings-style form section</p>
                    <form class="mt-3 grid gap-4" action="#" method="POST" onsubmit="event.preventDefault()">
                        <x-ui.patterns.form-group for="settings-workspace-title" label="Workspace Title" helper="Shown in internal page headers." required>
                            <input id="settings-workspace-title" type="text" value="Platform Operations" class="ui-input w-full" />
                        </x-ui.patterns.form-group>
                        <x-ui.patterns.form-group for="settings-default-owner" label="Default Owner" helper="Short known lists use select.">
                            <select id="settings-default-owner" class="ui-select w-full">
                                <option>Platform Team</option>
                                <option>Security Team</option>
                            </select>
                        </x-ui.patterns.form-group>
                    </form>
                </article>

                <article class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Compact account/profile form</p>
                    <form class="mt-3 grid gap-4" action="#" method="POST" onsubmit="event.preventDefault()">
                        <x-ui.patterns.inline-form-row for="account-display-name" label="Display Name" helper="Compact profile rows keep labels visible.">
                            <input id="account-display-name" type="text" value="Alex Operator" class="ui-input w-full" />
                        </x-ui.patterns.inline-form-row>
                        <x-ui.patterns.inline-form-row for="account-timezone" label="Timezone" helper="Long known list uses searchable select.">
                            <x-ui.searchable-select
                                id="account-timezone"
                                name="account_timezone"
                                :options="App\Support\UiOptionCatalog::timezoneOptions()"
                                selected="America/New_York"
                                placeholder="Choose a timezone"
                                search-placeholder="Search timezones"
                            />
                        </x-ui.patterns.inline-form-row>
                    </form>
                </article>

                <article class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Validation summary + field error</p>
                    <div class="mt-3 space-y-4">
                        <x-ui.patterns.validation-summary
                            title="Review the fields below"
                            :errors="[
                                'Support email must be complete.',
                                'Owner scope must be selected.',
                            ]"
                        />
                        <x-ui.patterns.form-group for="composition-support-email" label="Support Email" error="Enter a valid support email address." required>
                            <input id="composition-support-email" type="email" value="ops@" aria-invalid="true" class="ui-input w-full" />
                        </x-ui.patterns.form-group>
                    </div>
                </article>

                <article class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Form action bar</p>
                    <div class="mt-3">
                        <x-ui.patterns.form-actions-bar>
                            <x-slot:leading>
                                <x-ui.button variant="ghost">Cancel</x-ui.button>
                            </x-slot:leading>

                            <x-ui.button semantic="danger" variant="soft">Archive</x-ui.button>
                            <x-ui.button semantic="primary">Save Workspace</x-ui.button>
                        </x-ui.patterns.form-actions-bar>
                    </div>
                    <p class="mt-3 text-sm text-slate-400">One primary save action sits at the end; destructive secondary actions stay lower emphasis unless confirmation is active.</p>
                </article>
            </div>
        </section>

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
            description="When space allows, keep labels and controls aligned horizontally without breaking label associations at narrow widths, including the shared searchable dropdown standard for long known-option lists."
            kicker="Responsive row"
        >
            <div class="space-y-4">
                <x-ui.patterns.proof-review-target
                    :items="[
                        ['id' => 'P2-B-CQ-001', 'note' => 'This section is the proof target for the shared searchable dropdown-select baseline. Confirm the trigger spacing, typography, menu shell, and single current-selection treatment stay aligned with the canonical select family.'],
                        ['id' => 'P2-B-CQ-003', 'note' => 'This section carries proof-only selector guidance. The review target here is consistent proof-note treatment at the point where reviewers judge the pattern, not only in the page banner.'],
                    ]"
                />

                <x-ui.patterns.inline-form-row
                    for="inline-timezone"
                    label="Default Timezone"
                    helper="Search the approved timezone list inside the shared Inputs And Forms dropdown, then choose the default."
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

                <x-ui.patterns.proof-note semantic="notice" title="Searchable Dropdown Standard">
                    Use this for long known-option lists that still need quick filtering. The trigger keeps the canonical select shell, search stays inside the open dropdown, and the current selection uses one shared in-menu treatment.
                </x-ui.patterns.proof-note>

                <x-ui.patterns.inline-form-row
                    for="inline-locale"
                    label="Default Locale"
                    helper="Locale follows the same shared dropdown standard used by timezone and other long known-option lists."
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
                    helper="Partial entry should render as `(5`, `(555`, `(555) 5`, then normalize to `(555) 555-5555`; standard extensions remain allowed."
                >
                    <x-ui.patterns.proof-review-target
                        :items="[
                            ['id' => 'P2-B-CQ-017', 'note' => 'The shared internal phone-input pattern should progressively render `(5`, `(555`, `(555) 5`, and then the canonical `(555) 555-5555` format on the proof surface and the consuming settings forms.'],
                        ]"
                    />

                    <x-ui.patterns.proof-note semantic="notice" title="Partial entry contract">
                        Format from the first typed digit. Keep the area-code wrapper open through the third digit, add the space on the fourth digit, and add the dash only after the sixth digit.
                    </x-ui.patterns.proof-note>

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
