@php
    $statusOptions = [
        ['value' => 'active', 'label' => 'Active'],
        ['value' => 'pending', 'label' => 'Pending'],
        ['value' => 'paused', 'label' => 'Paused'],
    ];

    $roleOptions = [
        ['value' => 'admin', 'label' => 'Admin'],
        ['value' => 'billing', 'label' => 'Billing'],
        ['value' => 'viewer', 'label' => 'Viewer'],
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

    $tabs = [
        ['id' => 'variants', 'label' => 'Variants'],
        ['id' => 'states', 'label' => 'States'],
        ['id' => 'sizes', 'label' => 'Sizes'],
        ['id' => 'family', 'label' => 'Family'],
        ['id' => 'boundaries', 'label' => 'Boundaries'],
    ];

    $familyRows = [
        ['Dropdown', 'Installed', 'x-ui.dropdown', 'Single-select option list.'],
        ['Fluid dropdown', 'Installed', 'x-ui.dropdown variant="fluid"', '64px field treatment for fluid field layouts.'],
        ['Multiselect', 'Installed standalone', 'x-ui.multiselect', 'Multiple selected values; reviewed on its own component page.'],
        ['Filterable multiselect', 'Installed standalone', 'x-ui.multiselect filterable', 'Multiple selected values with filtering; reviewed on its own component page.'],
        ['Inline dropdown', 'Required gap', 'No approved API', 'Inline single-select behavior is not installed.'],
        ['Combo box', 'Required gap', 'No approved API', 'Typed filtering and custom values need a dedicated API.'],
    ];

    $boundaryRows = [
        ['Dropdown', 'Custom single selection from a known option list.', 'Use for filters, sorting controls, and custom single-value fields.', 'Approved here'],
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

<div class="space-y-6" data-component-live-layout="dropdown-matrix" data-ui-reference-sample-type="field" data-ui-reference-tabs data-dropdown-live-tabs>
    <div class="flex flex-wrap gap-2" role="tablist" aria-label="Dropdown live example groups">
        @foreach ($tabs as $index => $tab)
            @php
                $tabId = 'dropdown-'.$tab['id'].'-tab';
                $panelId = 'dropdown-'.$tab['id'].'-panel';
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

    <section id="dropdown-variants-panel" class="ui-reference-component-panel" role="tabpanel" aria-labelledby="dropdown-variants-tab" data-dropdown-live-section="variants">
        <p class="ui-kicker">Dropdown</p>
        <h3 class="ui-card-title mt-2">Variants</h3>
        <p class="ui-card-copy mt-2">Review the default, selected, long-option, and fluid dropdown field treatments. Open each control to confirm listbox behavior.</p>

        <div class="mt-5 grid min-w-0 gap-5 xl:grid-cols-2">
            <article class="ui-reference-component-panel">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Placeholder</h4>
                <div class="mt-4 max-w-md">
                    <x-ui.dropdown
                        name="status_closed"
                        label="Status"
                        placeholder="Choose status"
                        :options="$statusOptions"
                        helper="Choose the current workspace status."
                    />
                </div>
            </article>

            <article class="ui-reference-component-panel">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Selected value</h4>
                <div class="mt-4 max-w-md">
                    <x-ui.dropdown
                        name="status_selected"
                        label="Status"
                        :options="$statusOptions"
                        value="active"
                        helper="Selected values update the visible field and hidden submitted value."
                    />
                </div>
            </article>

            <article class="ui-reference-component-panel">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Long known-option handoff</h4>
                <div class="mt-4 max-w-lg">
                    <x-ui.dropdown
                        name="long_known_option"
                        label="Reference area"
                        placeholder="Choose area"
                        :options="$longOptions"
                        value="billing"
                        helper="Long labels truncate visually and keep their full title for hover or focus inspection."
                        menu-max-height="11rem"
                    />
                </div>
            </article>

            <article class="ui-reference-component-panel">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Fluid dropdown</h4>
                <div class="mt-4 max-w-md pb-1">
                    <x-ui.dropdown
                        name="fluid_status"
                        label="Billing status"
                        variant="fluid"
                        :options="$statusOptions"
                        value="pending"
                        helper="Fluid keeps the 64px field treatment."
                    />
                </div>
            </article>
        </div>
    </section>

    <section id="dropdown-states-panel" class="ui-reference-component-panel" role="tabpanel" aria-labelledby="dropdown-states-tab" data-dropdown-live-section="states" hidden>
        <p class="ui-kicker">Field states</p>
        <h3 class="ui-card-title mt-2">Validation, disabled, and read-only</h3>
        <p class="ui-card-copy mt-2">State examples stay closed by default so the field border, label, helper, and message spacing can be reviewed clearly.</p>

        <div class="mt-5 grid min-w-0 gap-5 xl:grid-cols-2">
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
                :options="$roleOptions"
                value="billing"
                warning="Pending roles may delay access."
            />

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
                :options="$roleOptions"
                value="viewer"
                helper="System roles are assigned by policy."
                readonly
            />
        </div>
    </section>

    <section id="dropdown-sizes-panel" class="ui-reference-component-panel" role="tabpanel" aria-labelledby="dropdown-sizes-tab" data-dropdown-live-section="size-comparison" hidden>
        <p class="ui-kicker">Sizing</p>
        <h3 class="ui-card-title mt-2">Size comparison</h3>
        <p class="ui-card-copy mt-2">Small, medium, and large fields should align to their matching option row heights without hanging outside the card.</p>

        <div class="mt-5 grid min-w-0 gap-5 xl:grid-cols-3">
            <x-ui.dropdown name="dropdown_sm" label="Small" size="sm" :options="$statusOptions" value="active" />
            <x-ui.dropdown name="dropdown_md" label="Medium" size="md" :options="$statusOptions" value="pending" />
            <x-ui.dropdown name="dropdown_lg" label="Large" size="lg" :options="$statusOptions" value="paused" />
        </div>
    </section>

    <section id="dropdown-family-panel" class="ui-reference-component-panel" role="tabpanel" aria-labelledby="dropdown-family-tab" data-dropdown-live-section="family-coverage" hidden>
        <p class="ui-kicker">Selection family</p>
        <h3 class="ui-card-title mt-2">Dropdown family coverage</h3>
        <p class="ui-card-copy mt-2">Dropdown remains the single-select owner. Related installed family members are linked here for boundary review instead of being rendered as Dropdown variants.</p>

        <div class="mt-6 overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-subtle-01);">
            <table class="min-w-full text-left text-sm">
                <thead style="background-color: var(--ui-layer-02); color: var(--ui-text-secondary);">
                    <tr>
                        <th class="px-3 py-2 font-medium">Family member</th>
                        <th class="px-3 py-2 font-medium">Status</th>
                        <th class="px-3 py-2 font-medium">API</th>
                        <th class="px-3 py-2 font-medium">Behavior</th>
                    </tr>
                </thead>
                <tbody style="color: var(--ui-text-primary);">
                    @foreach ($familyRows as [$variant, $status, $api, $behavior])
                        <tr class="border-t" style="border-color: var(--ui-border-subtle-01);">
                            <td class="px-3 py-2 font-medium">{{ $variant }}</td>
                            <td class="px-3 py-2">{{ $status }}</td>
                            <td class="px-3 py-2"><code>{{ $api }}</code></td>
                            <td class="px-3 py-2">{{ $behavior }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section id="dropdown-boundaries-panel" class="ui-reference-component-panel" role="tabpanel" aria-labelledby="dropdown-boundaries-tab" data-dropdown-live-section="boundaries" hidden>
        <p class="ui-kicker">Boundaries</p>
        <h3 class="ui-card-title mt-2">Dropdown vs related APIs</h3>
        <p class="ui-card-copy mt-2">Dropdown options are values. Commands, native form selection, multiple values, and typed search belong to other APIs.</p>

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

        <h4 class="mt-6 text-sm font-semibold" style="color: var(--ui-text-primary);">Deferred and gated capabilities</h4>
        <div class="mt-3 grid min-w-0 gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($deferredRows as [$capability, $status, $reason])
                <article class="ui-reference-component-panel">
                    <div class="flex flex-wrap items-center gap-2">
                        <h5 class="text-sm font-semibold" style="color: var(--ui-text-primary);">{{ $capability }}</h5>
                        <span class="inline-flex items-center rounded-full border px-2 py-0.5 text-xs font-semibold" style="border-color: var(--ui-border-subtle-01); color: var(--ui-text-secondary);">{{ $status }}</span>
                    </div>
                    <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">{{ $reason }}</p>
                </article>
            @endforeach
        </div>
    </section>
</div>
