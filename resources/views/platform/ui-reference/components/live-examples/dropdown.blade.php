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

    $boundaryRows = [
        ['Dropdown', 'Custom single selection from a known option list.', 'Use for page filters, sorting controls, and custom single-value fields.', 'Approved here'],
        ['Select', 'Native form selection.', 'Use when native mobile/form behavior is preferred.', 'Separate component'],
        ['Menu buttons / Menu', 'Command disclosure.', 'Use when items are actions like Edit, Duplicate, or Archive.', 'Separate component'],
        ['Multiselect', 'Multiple selected values.', 'Use when users can choose more than one option.', 'Separate component'],
        ['Combo box', 'Typed filtering or custom values.', 'Requires dedicated Combo box approval before implementation.', 'Deferred boundary'],
        ['Radio button / Toggle', 'Visible few choices or immediate binary settings.', 'Use for two options, visible comparison, or on/off settings.', 'Separate component'],
    ];

    $deferredRows = [
        ['Fluid dropdown', 'Gated', 'Needs attached/contained field context and spacing proof before production use.'],
        ['Inline dropdown', 'Deferred', 'Needs separate inline selection keyboard and labeling contract.'],
        ['Filterable dropdown', 'Not implemented here', 'Use Search/Text input today or approve Combo box/filterable Multiselect.'],
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
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Carbon’s dropdown family is documented, but this app keeps neighboring behaviors in their own component owners unless the standard is updated first.</p>
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
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">These capabilities remain standards-gated. The page documents trigger conditions instead of rendering fake production controls.</p>
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
