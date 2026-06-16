@php
    $statusOptions = [
        ['value' => 'active', 'label' => 'Active'],
        ['value' => 'pending', 'label' => 'Pending'],
        ['value' => 'paused', 'label' => 'Paused'],
    ];

    $longOptions = [
        ['value' => 'audit', 'label' => 'Audit evidence package requiring owner review'],
        ['value' => 'billing', 'label' => 'Billing profile'],
        ['value' => 'domains', 'label' => 'Domain rules'],
        ['value' => 'invoices', 'label' => 'Invoice queue'],
        ['value' => 'members', 'label' => 'Member access'],
        ['value' => 'notifications', 'label' => 'Notification policy'],
        ['value' => 'security', 'label' => 'Security settings'],
        ['value' => 'workspaces', 'label' => 'Workspace catalog'],
    ];

    $familyRows = [
        ['Dropdown', 'Installed', 'x-ui.dropdown', 'Single-select option list. Selecting an option closes the menu and updates the field text.'],
        ['Multiselect', 'Installed', 'x-ui.multiselect', 'Multiple selected values. Menu stays open while selections are made.'],
        ['Filterable multiselect', 'Installed', 'x-ui.multiselect filterable', 'Typed filtering removes non-matching options and keeps selected values summarized.'],
        ['Fluid dropdown', 'Installed for dropdown', 'x-ui.dropdown variant="fluid"', '64px field height with fluid label/field spacing.'],
        ['Inline dropdown', 'Required gap', 'No approved API', 'Inline modifier still needs keyboard, sizing, and layout proof before use.'],
        ['Combo box', 'Required gap', 'No approved API', 'Typed filtering plus optional custom value entry requires a dedicated combo-box API.'],
    ];

    $boundaryRows = [
        ['Dropdown', 'Custom single selection from a known option list.', 'Use for page filters, sorting controls, and custom single-value fields.', 'Approved here'],
        ['Select', 'Native form selection.', 'Use when native mobile/form behavior is preferred.', 'Separate component'],
        ['Menu buttons / Menu', 'Command disclosure.', 'Use when items are actions like Edit, Duplicate, or Archive.', 'Separate component'],
        ['Multiselect', 'Multiple selected values.', 'Use when users can choose more than one option.', 'Installed separate component'],
        ['Combo box', 'Typed filtering or custom values.', 'Requires dedicated Combo box approval before implementation.', 'Required gap'],
        ['Radio button / Toggle', 'Visible few choices or immediate binary settings.', 'Use for two options, visible comparison, or on/off settings.', 'Separate component'],
    ];

    $deferredRows = [
        ['Inline dropdown', 'Required gap', 'Needs separate inline selection keyboard, spacing, and labeling contract.'],
        ['Combo box', 'Required gap', 'Needs dedicated API for typed suggestions, highlighted best match, clear icon, and custom value save behavior.'],
        ['Vertical divider sets', 'Required gap for combo/filterable variants', 'Divider rules apply when clear and chevron controls become separately interactive.'],
        ['Skeleton dropdown', 'Deferred', 'Requires async option loading ownership.'],
        ['AI presence dropdown', 'Gated', 'Requires approved AI feature and AI label standard.'],
    ];
@endphp

<div class="space-y-6" data-component-live-layout="dropdown-matrix" data-ui-reference-sample-type="field">
    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-dropdown-live-section="basic-known-option-dropdown">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Basic known-option dropdown</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Dropdown selects one known value through the app-owned custom listbox API. Closed and open states use the same field width.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Closed</h4>
                <div class="mt-4 max-w-sm">
                    <x-ui.dropdown
                        name="status_closed"
                        label="Status"
                        placeholder="Choose status"
                        :options="$statusOptions"
                        helper="Choose the current workspace status."
                    />
                </div>
            </article>
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Open with selected value</h4>
                <div class="mt-4 max-w-sm">
                    <x-ui.dropdown
                        name="status_open"
                        label="Status"
                        :options="$statusOptions"
                        value="active"
                        helper="Selecting an option closes the menu and updates the hidden value."
                        open
                    />
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-dropdown-live-section="family-coverage">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Dropdown family coverage</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Carbon groups dropdown, multiselect, filterable multiselect, and combo box as one selection family. Login App maps installed behavior to separate app-owned APIs and keeps unimplemented family variants visible as required gaps.</p>

        <div class="mt-4 overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-subtle-01);">
            <table class="min-w-full text-left text-sm">
                <thead style="background-color: var(--ui-layer-accent-01); color: var(--ui-text-secondary);">
                    <tr>
                        <th class="px-4 py-3">Family variant</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">API</th>
                        <th class="px-4 py-3">Behavior</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($familyRows as [$variant, $status, $api, $behavior])
                        <tr class="border-t" style="border-color: var(--ui-border-subtle-01);">
                            <td class="px-4 py-3 font-semibold" style="color: var(--ui-text-primary);">{{ $variant }}</td>
                            <td class="px-4 py-3" style="color: var(--ui-text-secondary);">{{ $status }}</td>
                            <td class="px-4 py-3"><code>{{ $api }}</code></td>
                            <td class="max-w-lg px-4 py-3 leading-6" style="color: var(--ui-text-secondary);">{{ $behavior }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 grid gap-4 xl:grid-cols-3">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Fluid dropdown</h4>
                <div class="mt-4">
                    <x-ui.dropdown name="fluid_status" label="Billing status" variant="fluid" :options="$statusOptions" value="pending" />
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Multiselect</h4>
                <div class="mt-4">
                    <x-ui.multiselect name="dropdown_family_roles" label="Roles" :options="$statusOptions" :value="['active', 'paused']" clearable open />
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Filterable multiselect</h4>
                <div class="mt-4">
                    <x-ui.multiselect name="dropdown_family_filterable" label="Reference areas" :options="$longOptions" :value="['billing']" filterable clearable open />
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-dropdown-live-section="long-known-option-handoff">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Long known-option handoff</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Long known lists cap the menu height, keep option text to one line, expose full text through the browser title, and preserve menu elevation.</p>
        <div class="mt-4 max-w-lg">
            <x-ui.dropdown
                name="long_known_option"
                label="Reference area"
                placeholder="Choose area"
                :options="$longOptions"
                value="billing"
                helper="Long option labels truncate visually and keep their full title for hover/focus inspection."
                menu-max-height="11rem"
                open
            />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-dropdown-live-section="validation-selection">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Validation selection</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Helper text is replaced or supplemented by non-color-only error and warning states when validation applies.</p>
        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <x-ui.dropdown
                name="validation_error"
                label="Workspace type"
                placeholder="Choose type"
                :options="$statusOptions"
                error="Choose a workspace type before saving."
                required
            />
            <x-ui.dropdown
                name="validation_warning"
                label="Owner role"
                :options="$statusOptions"
                value="pending"
                warning="Pending roles may delay access."
            />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-dropdown-live-section="disabled-readonly">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Disabled and read-only dropdown</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Disabled dropdowns cannot be reached or opened. Read-only dropdowns keep the fixed value visible and suppress opening.</p>
        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <x-ui.dropdown
                name="disabled_plan"
                label="Billing plan"
                :options="$statusOptions"
                value="active"
                helper="Plan is managed by account ownership."
                disabled
            />
            <x-ui.dropdown
                name="readonly_plan"
                label="System role"
                :options="$statusOptions"
                value="paused"
                helper="System roles are assigned by policy."
                readonly
            />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-dropdown-live-section="size-comparison">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Size comparison</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Default Dropdown sizes keep field height and option height aligned.</p>
        <div class="mt-4 grid gap-4 xl:grid-cols-3">
            <x-ui.dropdown name="dropdown_sm" label="Small" size="sm" :options="$statusOptions" value="active" />
            <x-ui.dropdown name="dropdown_md" label="Medium" size="md" :options="$statusOptions" value="pending" />
            <x-ui.dropdown name="dropdown_lg" label="Large" size="lg" :options="$statusOptions" value="paused" />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-dropdown-live-section="related-api-boundaries">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Dropdown vs related APIs</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Use Dropdown for values, Menu/Menu buttons for actions, Multiselect for multiple values, and Select when native form behavior is the better control.</p>
        <div class="mt-4 overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-subtle-01);">
            <table class="min-w-full text-left text-sm">
                <thead style="background-color: var(--ui-layer-accent-01); color: var(--ui-text-secondary);">
                    <tr>
                        <th class="px-4 py-3">API</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Use when</th>
                        <th class="px-4 py-3">Disposition</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($boundaryRows as [$api, $role, $useWhen, $disposition])
                        <tr class="border-t" style="border-color: var(--ui-border-subtle-01);">
                            <td class="px-4 py-3 font-semibold" style="color: var(--ui-text-primary);">{{ $api }}</td>
                            <td class="max-w-xs px-4 py-3 leading-6" style="color: var(--ui-text-secondary);">{{ $role }}</td>
                            <td class="max-w-md px-4 py-3 leading-6" style="color: var(--ui-text-secondary);">{{ $useWhen }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center rounded-full border px-2 py-0.5 text-xs font-semibold" style="border-color: var(--ui-border-subtle-01); color: var(--ui-text-secondary);">{{ $disposition }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-dropdown-live-section="deferred-gated-capabilities">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Deferred and gated capabilities</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">These remaining family capabilities are not complete. The page documents trigger conditions instead of rendering fake production controls.</p>
        <div class="mt-4 grid gap-3 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($deferredRows as [$capability, $status, $reason])
                <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                    <div class="flex flex-wrap items-center gap-2">
                        <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">{{ $capability }}</h4>
                        <span class="inline-flex items-center rounded-full border px-2 py-0.5 text-xs font-semibold" style="border-color: var(--ui-border-subtle-01); color: var(--ui-text-secondary);">{{ $status }}</span>
                    </div>
                    <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">{{ $reason }}</p>
                </article>
            @endforeach
        </div>
    </section>
</div>
