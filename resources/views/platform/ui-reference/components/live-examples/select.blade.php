@php
    $statusOptions = [
        ['value' => 'active', 'text' => 'Active'],
        ['value' => 'archived', 'text' => 'Archived'],
        ['value' => 'pending', 'text' => 'Pending'],
        ['value' => 'suspended', 'text' => 'Suspended'],
    ];

    $cycleOptions = [
        ['value' => 'monthly', 'text' => 'Monthly'],
        ['value' => 'quarterly', 'text' => 'Quarterly'],
        ['value' => 'annual', 'text' => 'Annual'],
    ];

    $emptyDefaultOptions = [
        ['value' => '', 'text' => ''],
        ['value' => 'option-1', 'text' => 'Option 1'],
        ['value' => 'option-2', 'text' => 'Option 2'],
    ];

    $itemOptions = [
        ['value' => '', 'text' => ''],
        ['value' => 'option-1', 'text' => 'Option 1'],
        ['value' => 'option-2', 'text' => 'Disabled option', 'disabled' => true],
        ['value' => 'option-3', 'text' => 'Hidden option', 'hidden' => true],
    ];

    $groupedOptions = [
        [
            'label' => 'Planning',
            'options' => [
                ['value' => 'active', 'text' => 'Active'],
                ['value' => 'paused', 'text' => 'Paused'],
            ],
        ],
        [
            'label' => 'Review',
            'disabled' => true,
            'options' => [
                ['value' => 'pending', 'text' => 'Pending review'],
                ['value' => 'blocked', 'text' => 'Blocked'],
            ],
        ],
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
    <section class="ui-reference-layer-section" data-select-live-section="default-option-behavior">
        <div>
            <h3 class="ui-reference-section-title">Default option behavior</h3>
            <p class="ui-reference-section-description">Select supports an empty prompt option, native first-option defaulting, and explicit default values.</p>
        </div>

        <div class="mt-4 grid gap-4 xl:grid-cols-3">
            <article class="ui-reference-card">
                <div class="ui-reference-card-header"><h4>Empty default option</h4></div>
                <div class="ui-reference-card-body">
                    <x-ui.select name="select_empty_default" label="Select an option" helper-text="The first option is intentionally empty." :options="$emptyDefaultOptions" />
                </div>
            </article>

            <article class="ui-reference-card">
                <div class="ui-reference-card-header"><h4>First option default</h4></div>
                <div class="ui-reference-card-body">
                    <x-ui.select name="select_first_default" label="Select an option" helper-text="Without an empty option or value, the browser selects the first option." :options="$cycleOptions" />
                </div>
            </article>

            <article class="ui-reference-card">
                <div class="ui-reference-card-header"><h4>Custom option default</h4></div>
                <div class="ui-reference-card-body">
                    <x-ui.select name="select_custom_default" label="Select an option" helper-text="The provided value selects the matching option." value="annual" :options="$cycleOptions" />
                </div>
            </article>
        </div>
    </section>

    <section class="ui-reference-layer-section" data-select-live-section="variants">
        <div>
            <h3 class="ui-reference-section-title">Variants</h3>
            <p class="ui-reference-section-description">Default, inline, fluid, and skeleton are rendered by the same Select component and each owns one native select chevron.</p>
        </div>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="ui-reference-card">
                <div class="ui-reference-card-header"><h4>Default select</h4></div>
                <div class="ui-reference-card-body">
                    <x-ui.select name="select_default_variant" label="Status" helper-text="Standard visible-label select." :options="$statusOptions" value="active" />
                </div>
            </article>

            <article class="ui-reference-card">
                <div class="ui-reference-card-header"><h4>Inline select with label</h4></div>
                <div class="ui-reference-card-body">
                    <x-ui.select name="select_inline_labeled" label="Sort order" helper-text="Inline can still own label and helper text in form contexts." inline :options="$cycleOptions" value="monthly" />
                </div>
            </article>

            <article class="ui-reference-card">
                <div class="ui-reference-card-header"><h4>Inline no-label select</h4></div>
                <div class="ui-reference-card-body">
                    <div class="flex flex-wrap items-center gap-3 text-sm" style="color: var(--ui-text-secondary);">
                        <span>Sort by</span>
                        <x-ui.select name="select_inline_no_label" inline no-label aria-label="Sort order" :options="$cycleOptions" value="monthly" />
                    </div>
                </div>
            </article>

            <article class="ui-reference-card">
                <div class="ui-reference-card-header"><h4>Fluid select</h4></div>
                <div class="ui-reference-card-body">
                    <x-ui.select name="select_fluid_variant" label="Billing cycle" style="fluid" :options="$cycleOptions" value="annual" />
                </div>
            </article>

            <article class="ui-reference-card">
                <div class="ui-reference-card-header"><h4>Skeleton select</h4></div>
                <div class="ui-reference-card-body">
                    <x-ui.select name="select_skeleton_variant" label="Plan" :options="$cycleOptions" placeholder="Loading plans" skeleton />
                </div>
            </article>
        </div>
    </section>

    <section class="ui-reference-layer-section" data-select-live-section="sizes">
        <div>
            <h3 class="ui-reference-section-title">Sizes</h3>
            <p class="ui-reference-section-description">Default and inline select support xs, sm, md, and lg heights. Fluid remains the 64px field treatment.</p>
        </div>
        <div class="mt-4 grid gap-4 xl:grid-cols-4">
            <x-ui.select name="select_xs" label="Extra small" size="xs" :options="$cycleOptions" value="monthly" />
            <x-ui.select name="select_sm" label="Small" size="sm" :options="$cycleOptions" value="monthly" />
            <x-ui.select name="select_md" label="Medium" size="md" :options="$cycleOptions" value="quarterly" />
            <x-ui.select name="select_lg" label="Large" size="lg" :options="$cycleOptions" value="annual" />
        </div>
    </section>

    <section class="ui-reference-layer-section" data-select-live-section="states">
        <div>
            <h3 class="ui-reference-section-title">States</h3>
            <p class="ui-reference-section-description">Error and warning messages replace helper text. Disabled is non-interactive; read-only remains readable and submits a hidden value.</p>
        </div>
        <div class="mt-4 grid gap-4 xl:grid-cols-3">
            <x-ui.select name="select_enabled" label="Enabled" :options="$cycleOptions" value="monthly" helper-text="Enabled helper text." />
            <x-ui.select name="select_focus" label="Focus" :options="$cycleOptions" value="monthly" class="ui-reference-force-focus" helper-text="Focus uses the focus token on the field." />
            <x-ui.select name="select_disabled" label="Disabled" :options="$cycleOptions" value="annual" helper-text="Plan is managed by owner policy." disabled />
            <x-ui.select name="select_readonly" label="Read-only" :options="$cycleOptions" value="annual" helper-text="Plan is locked by policy." readonly />
            <x-ui.select name="select_error" label="Invalid" placeholder="Choose type" :options="$cycleOptions" invalid invalid-text="Choose an account type before saving." required />
            <x-ui.select name="select_warning" label="Warning" :options="$cycleOptions" value="quarterly" warn warn-text="Quarterly billing may change invoice timing." />
            <x-ui.select name="select_state_skeleton" label="Skeleton" :options="$cycleOptions" placeholder="Loading plans" skeleton />
        </div>
    </section>

    <section class="ui-reference-layer-section" data-select-live-section="option-behavior">
        <div>
            <h3 class="ui-reference-section-title">Options and groups</h3>
            <p class="ui-reference-section-description">Select renders native option items, disabled options, hidden options, and disabled option groups.</p>
        </div>
        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <x-ui.select name="select_item_options" label="Item options" :options="$itemOptions" helper-text="Includes disabled and hidden option data." />
            <x-ui.select name="select_grouped" label="Workspace state" :option-groups="$groupedOptions" value="active" helper-text="Groups are native optgroup elements." />
        </div>
    </section>

    <section class="ui-reference-layer-section" data-select-live-section="label-behavior">
        <div>
            <h3 class="ui-reference-section-title">Label behavior</h3>
            <p class="ui-reference-section-description">Visible, hidden, and no-label modes are distinct so compound components can own context without appending chevrons or duplicate labels.</p>
        </div>
        <div class="mt-4 grid gap-4 xl:grid-cols-3">
            <x-ui.select name="select_visible_label" label="Visible label" :options="$cycleOptions" value="monthly" />
            <x-ui.select name="select_hidden_label" label="Hidden label" hide-label :options="$cycleOptions" value="quarterly" helper-text="The label is available to screen readers." />
            <x-ui.select name="select_no_label" no-label aria-label="No-label select" :options="$cycleOptions" value="annual" />
        </div>
    </section>

    <section class="ui-reference-layer-section" data-select-live-section="select-boundaries">
        <div>
            <h3 class="ui-reference-section-title">Select versus related APIs</h3>
            <p class="ui-reference-section-description">Select owns native form submission for one value. Use a different component when the interaction is action, filtering, searching, or multiple choice.</p>
        </div>
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
