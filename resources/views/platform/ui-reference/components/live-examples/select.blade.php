@php
    $statusOptions = [
        ['value' => 'active', 'label' => 'Active'],
        ['value' => 'archived', 'label' => 'Archived'],
        ['value' => 'pending', 'label' => 'Pending'],
        ['value' => 'suspended', 'label' => 'Suspended'],
    ];

    $cycleOptions = [
        ['value' => 'monthly', 'label' => 'Monthly'],
        ['value' => 'quarterly', 'label' => 'Quarterly'],
        ['value' => 'annual', 'label' => 'Annual'],
    ];

    $groupedOptions = [
        ['label' => 'Production', 'options' => [
            ['value' => 'active', 'label' => 'Active'],
            ['value' => 'paused', 'label' => 'Paused'],
        ]],
        ['label' => 'Review', 'options' => [
            ['value' => 'pending', 'label' => 'Pending review'],
            ['value' => 'blocked', 'label' => 'Blocked'],
        ]],
    ];

    $boundaryRows = [
        ['Select', 'One form value submitted with the form.', '<x-ui.select name="status" label="Status" :options="$options" />', 'Approved here'],
        ['Radio button', 'Two choices or a small visible set that benefits from comparison.', '<x-ui.radio-group ... />', 'Separate component'],
        ['Dropdown', 'Custom single-selection control for filters, sorting, or listbox needs.', '<x-ui.dropdown ... />', 'Separate component'],
        ['Multiselect', 'Multiple values with selected-item display.', '<x-ui.multiselect ... />', 'Separate component'],
        ['Menu', 'Contextual actions, not submitted field values.', '<x-ui.menu ... />', 'Separate component'],
        ['Combo box', 'Typed filtering, autocomplete, or custom values.', 'Not installed as Select', 'Deferred boundary'],
    ];
@endphp

<div class="space-y-6" data-component-live-layout="select-matrix" data-ui-reference-sample-type="field">
    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-select-live-section="short-native-selection">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Short native selection</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Select uses native browser option behavior for one submitted form value. Use a prompt option when the user must make an intentional choice.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Prompt option</h4>
                <div class="mt-4 max-w-sm">
                    <x-ui.select
                        name="select_prompt_status"
                        label="Status"
                        placeholder="Choose status"
                        helper="Choose the current account state."
                        :options="$statusOptions"
                        required
                    />
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Selected value</h4>
                <div class="mt-4 max-w-sm">
                    <x-ui.select
                        name="select_selected_status"
                        label="Status"
                        helper="The selected option remains a scalar form value."
                        :options="$statusOptions"
                        value="active"
                    />
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-select-live-section="styles-and-sizes">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Styles and sizes</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Default select supports small, medium, and large field heights. Inline is lower weight. Fluid uses the 64px expressive field treatment.</p>
        <div class="mt-4 grid gap-4 xl:grid-cols-3">
            <x-ui.select name="select_sm" label="Small" size="sm" :options="$cycleOptions" value="monthly" />
            <x-ui.select name="select_md" label="Medium" size="md" :options="$cycleOptions" value="quarterly" />
            <x-ui.select name="select_lg" label="Large" size="lg" :options="$cycleOptions" value="annual" />
        </div>
        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Inline select</h4>
                <div class="mt-4 flex flex-wrap items-center gap-3 text-sm" style="color: var(--ui-text-secondary);">
                    <span>Sort by</span>
                    <x-ui.select name="select_inline" label="Sort order" variant="inline" :options="$cycleOptions" value="monthly" />
                </div>
            </article>
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Fluid select</h4>
                <div class="mt-4 max-w-sm">
                    <x-ui.select name="select_fluid" label="Billing cycle" style="fluid" :options="$cycleOptions" value="annual" />
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-select-live-section="validation-selection">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Validation selection</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Error and warning states replace helper text, associate the message by ID, and keep native selection behavior.</p>
        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <x-ui.select
                name="select_error"
                label="Account type"
                placeholder="Choose type"
                :options="$cycleOptions"
                invalid
                invalid-text="Choose an account type before saving."
                required
            />
            <x-ui.select
                name="select_warning"
                label="Billing cycle"
                :options="$cycleOptions"
                value="quarterly"
                warn
                warn-text="Quarterly billing may change invoice timing."
            />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-select-live-section="disabled-readonly-loading">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Disabled, read-only, and loading</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Disabled selects are unavailable. Read-only renders a value summary plus hidden submitted value. Loading keeps the select disabled and exposes status copy.</p>
        <div class="mt-4 grid gap-4 xl:grid-cols-3">
            <x-ui.select name="select_disabled" label="Plan" :options="$cycleOptions" value="annual" helper="Plan is managed by owner policy." disabled />
            <x-ui.select name="select_readonly" label="Plan" :options="$cycleOptions" value="annual" helper="Plan is locked by policy." readonly />
            <x-ui.select name="select_loading" label="Plan" :options="$cycleOptions" placeholder="Loading plans" skeleton />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-select-live-section="grouped-options">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Grouped options</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Use native option groups only when grouping improves scan speed and the list remains short.</p>
        <div class="mt-4 max-w-sm">
            <x-ui.select name="select_grouped" label="Workspace state" :options="$groupedOptions" value="pending" helper="Groups are native optgroup elements." />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-select-live-section="select-boundaries">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Select versus related APIs</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Select owns native form submission for one value. Use a different component when the interaction is action, filtering, searching, or multiple choice.</p>
        <div class="mt-4 overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-subtle-01);">
            <table class="min-w-full text-left text-sm">
                <thead style="background-color: var(--ui-layer-02); color: var(--ui-text-secondary);">
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
