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
                <x-ui.patterns.inline-form-row
                    for="inline-timezone"
                    label="Default Timezone"
                    helper="Used for display formatting when a user preference is missing."
                >
                    <input id="inline-timezone" type="text" value="America/New_York" class="ui-input w-full" />
                </x-ui.patterns.inline-form-row>

                <x-ui.patterns.inline-form-row
                    for="inline-locale"
                    label="Default Locale"
                    helper="Locale drives numeric and currency formatting."
                    error="Locale must be a valid ISO language code."
                >
                    <input id="inline-locale" type="text" value="" placeholder="e.g. en" aria-invalid="true" class="ui-input w-full" />
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
