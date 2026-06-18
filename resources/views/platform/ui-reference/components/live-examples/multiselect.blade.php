@php
    $roleOptions = [
        ['value' => 'owner', 'label' => 'Owner'],
        ['value' => 'admin', 'label' => 'Admin'],
        ['value' => 'billing', 'label' => 'Billing'],
        ['value' => 'viewer', 'label' => 'Viewer'],
        ['value' => 'audit', 'label' => 'Audit', 'disabled' => true],
    ];

    $referenceOptions = [
        ['value' => 'audit', 'label' => 'Audit evidence package requiring owner review'],
        ['value' => 'billing', 'label' => 'Billing profile'],
        ['value' => 'domains', 'label' => 'Domain rules'],
        ['value' => 'invoices', 'label' => 'Invoice queue'],
        ['value' => 'members', 'label' => 'Member access'],
        ['value' => 'notifications', 'label' => 'Notification policy'],
        ['value' => 'security', 'label' => 'Security settings'],
        ['value' => 'workspaces', 'label' => 'Workspace catalog'],
    ];

    $tabs = [
        ['id' => 'variants', 'label' => 'Variants'],
        ['id' => 'states', 'label' => 'States'],
        ['id' => 'actions', 'label' => 'Filtering + actions'],
        ['id' => 'overflow', 'label' => 'Overflow'],
        ['id' => 'boundaries', 'label' => 'Boundaries'],
    ];

    $boundaryRows = [
        ['Multiselect', 'Multiple known-option values.', 'Use when users may choose more than one value.', 'Installed here'],
        ['Dropdown', 'Custom single selection.', 'Use when exactly one value may be chosen from a known list.', 'Separate component'],
        ['Select', 'Native single selection.', 'Use when native form and mobile behavior is preferred.', 'Separate component'],
        ['Checkbox group', 'Visible multiple choices.', 'Use when the option set is short enough to stay visible.', 'Separate component'],
        ['Combo box', 'Typed filtering or custom values.', 'Requires a dedicated Combo box API before implementation.', 'Queued gap'],
    ];
@endphp

<div class="space-y-6" data-component-live-layout="multiselect-matrix" data-ui-reference-sample-type="multiselect" data-ui-reference-tabs data-multiselect-live-tabs>
    <div class="flex flex-wrap gap-2" role="tablist" aria-label="Multiselect live example groups">
        @foreach ($tabs as $index => $tab)
            @php
                $tabId = 'multiselect-'.$tab['id'].'-tab';
                $panelId = 'multiselect-'.$tab['id'].'-panel';
            @endphp
            <button
                id="{{ $tabId }}"
                type="button"
                class="ui-reference-tab"
                role="tab"
                aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                aria-controls="{{ $panelId }}"
                tabindex="{{ $index === 0 ? '0' : '-1' }}"
            >
                {{ $tab['label'] }}
            </button>
        @endforeach
    </div>

    <section id="multiselect-variants-panel" class="ui-reference-component-panel" role="tabpanel" aria-labelledby="multiselect-variants-tab" data-multiselect-live-section="variants">
        <p class="ui-kicker">Multiselect</p>
        <h3 class="ui-card-title mt-2">Variants</h3>
        <p class="ui-card-copy mt-2">Review the closed placeholder, selected-value, and open listbox treatments through the installed Multiselect API.</p>

        <div class="mt-5 grid min-w-0 gap-5 xl:grid-cols-2">
            <article class="ui-reference-component-panel">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Placeholder</h4>
                <div class="mt-4 max-w-md">
                    <x-ui.multiselect
                        name="multiselect_placeholder_roles"
                        label="Workspace roles"
                        :options="$roleOptions"
                        helper="Choose one or more roles."
                    />
                </div>
            </article>

            <article class="ui-reference-component-panel">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Selected values</h4>
                <div class="mt-4 max-w-md">
                    <x-ui.multiselect
                        name="multiselect_selected_roles"
                        label="Workspace roles"
                        :options="$roleOptions"
                        :value="['owner', 'admin']"
                        helper="Selected values stay visible in the field."
                    />
                </div>
            </article>

            <article class="ui-reference-component-panel">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Open listbox</h4>
                <div class="mt-4 max-w-md pb-36">
                    <x-ui.multiselect
                        name="multiselect_open_roles"
                        label="Workspace roles"
                        :options="$roleOptions"
                        :value="['owner']"
                        helper="The option panel attaches directly to the field."
                        open
                    />
                </div>
            </article>

            <article class="ui-reference-component-panel">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Long selected labels</h4>
                <div class="mt-4 max-w-lg">
                    <x-ui.multiselect
                        name="multiselect_long_labels"
                        label="Reference areas"
                        :options="$referenceOptions"
                        :value="['audit', 'billing', 'notifications']"
                        helper="Selected-value labels wrap inside the trigger without changing page width."
                    />
                </div>
            </article>
        </div>
    </section>

    <section id="multiselect-states-panel" class="ui-reference-component-panel" role="tabpanel" aria-labelledby="multiselect-states-tab" data-multiselect-live-section="states" hidden>
        <p class="ui-kicker">Field states</p>
        <h3 class="ui-card-title mt-2">Validation multiselect, disabled, read-only, and loading</h3>
        <p class="ui-card-copy mt-2">State examples stay closed unless the panel is required to prove option behavior. Disabled and loading multiselect examples keep labels and helper text visible.</p>

        <div class="mt-5 grid min-w-0 gap-5 xl:grid-cols-2">
            <x-ui.multiselect
                name="multiselect_error_roles"
                label="Required roles"
                :options="$roleOptions"
                error="Choose at least one role before saving."
                required
            />

            <x-ui.multiselect
                name="multiselect_warning_roles"
                label="Elevated roles"
                :options="$roleOptions"
                :value="['owner']"
                warning="Owner roles require audit review."
            />

            <x-ui.multiselect
                name="multiselect_disabled_roles"
                label="Disabled roles"
                :options="$roleOptions"
                :value="['owner']"
                helper="Roles are managed by account ownership."
                disabled
            />

            <x-ui.multiselect
                name="multiselect_loading_roles"
                label="Loading roles"
                :options="[]"
                helper="Options are loading from the owning workflow."
                loading
                open
            />
        </div>
    </section>

    <section id="multiselect-actions-panel" class="ui-reference-component-panel" role="tabpanel" aria-labelledby="multiselect-actions-tab" data-multiselect-live-section="filtering-actions" hidden>
        <p class="ui-kicker">Filtering and actions</p>
        <h3 class="ui-card-title mt-2">Filterable, clearable, and select-all</h3>
        <p class="ui-card-copy mt-2">These examples keep batch actions inside the component-owned panel. The field remains a value selection control, not a Menu.</p>

        <div class="mt-5 grid min-w-0 gap-5 xl:grid-cols-2">
            <article class="ui-reference-component-panel">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Filterable multiselect</h4>
                <div class="mt-4 max-w-lg pb-44">
                    <x-ui.multiselect
                        name="multiselect_filter_reference"
                        label="Reference areas"
                        :options="$referenceOptions"
                        :value="['billing']"
                        helper="Filter narrows visible options without changing selected values."
                        filterable
                        open
                    />
                </div>
            </article>

            <article class="ui-reference-component-panel">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Clear and select all</h4>
                <div class="mt-4 max-w-md pb-40">
                    <x-ui.multiselect
                        name="multiselect_batch_roles"
                        label="Workspace roles"
                        :options="$roleOptions"
                        :value="['owner', 'admin']"
                        helper="Batch controls apply to enabled options only."
                        clearable
                        select-all
                        open
                    />
                </div>
            </article>
        </div>
    </section>

    <section id="multiselect-overflow-panel" class="ui-reference-component-panel" role="tabpanel" aria-labelledby="multiselect-overflow-tab" data-multiselect-live-section="overflow" hidden>
        <p class="ui-kicker">Overflow</p>
        <h3 class="ui-card-title mt-2">Selected values and option-panel overflow</h3>
        <p class="ui-card-copy mt-2">Long selected labels wrap in the trigger, while long option lists use one scroll owner inside the panel.</p>

        <div class="mt-5 grid min-w-0 gap-5 xl:grid-cols-2">
            <x-ui.multiselect
                name="multiselect_overflow_selected"
                label="Reference areas"
                :options="$referenceOptions"
                :value="['audit', 'billing', 'domains', 'notifications']"
                helper="Selected values should not hang outside the field or card."
            />

            <div class="max-w-lg pb-52">
                <x-ui.multiselect
                    name="multiselect_overflow_menu"
                    label="Reference areas"
                    :options="$referenceOptions"
                    :value="['billing']"
                    helper="The menu uses the option-list scroll area only."
                    filterable
                    clearable
                    open
                />
            </div>
        </div>
    </section>

    <section id="multiselect-boundaries-panel" class="ui-reference-component-panel" role="tabpanel" aria-labelledby="multiselect-boundaries-tab" data-multiselect-live-section="boundaries" hidden>
        <p class="ui-kicker">Boundaries</p>
        <h3 class="ui-card-title mt-2">Multiselect vs related APIs</h3>
        <p class="ui-card-copy mt-2">Multiselect owns multiple known-option values. Single selection, native selection, visible choices, and typed custom values belong elsewhere.</p>

        <div class="mt-5 overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-subtle-01);">
            <table class="min-w-full text-left text-sm">
                <thead style="background-color: var(--ui-layer-02); color: var(--ui-text-secondary);">
                    <tr>
                        <th class="px-3 py-2 font-medium">API</th>
                        <th class="px-3 py-2 font-medium">Role</th>
                        <th class="px-3 py-2 font-medium">Use when</th>
                        <th class="px-3 py-2 font-medium">Disposition</th>
                    </tr>
                </thead>
                <tbody style="color: var(--ui-text-primary);">
                    @foreach ($boundaryRows as [$api, $role, $useWhen, $disposition])
                        <tr class="border-t" style="border-color: var(--ui-border-subtle-01);">
                            <td class="px-3 py-2 font-medium">{{ $api }}</td>
                            <td class="px-3 py-2">{{ $role }}</td>
                            <td class="px-3 py-2">{{ $useWhen }}</td>
                            <td class="px-3 py-2">{{ $disposition }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
