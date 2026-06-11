@php
    $stateRows = [
        ['Unselected', ['name' => 'checkbox_state_unselected', 'label' => 'Alerts']],
        ['Selected', ['name' => 'checkbox_state_selected', 'label' => 'Alerts', 'checked' => true]],
        ['Focus', ['name' => 'checkbox_state_focus', 'label' => 'Tab to focus']],
        ['Disabled', ['name' => 'checkbox_state_disabled', 'label' => 'Archived', 'disabled' => true]],
        ['Disabled selected', ['name' => 'checkbox_state_disabled_selected', 'label' => 'Archived', 'checked' => true, 'disabled' => true]],
        ['Read-only', ['name' => 'checkbox_state_readonly', 'label' => 'Locked', 'readonly' => true]],
        ['Read-only selected', ['name' => 'checkbox_state_readonly_selected', 'label' => 'Locked', 'checked' => true, 'readonly' => true]],
        ['Error', ['name' => 'checkbox_state_error', 'label' => 'Required', 'error' => 'Choose this option before continuing.']],
        ['Warning', ['name' => 'checkbox_state_warning', 'label' => 'Optional', 'warning' => 'Changing this may affect reports.']],
    ];

    $nestedOptions = [
        [
            'label' => 'Notifications',
            'value' => 'notifications',
            'children' => [
                ['label' => 'Product updates', 'value' => 'product'],
                ['label' => 'Security alerts', 'value' => 'security'],
                ['label' => 'Billing notices', 'value' => 'billing'],
            ],
        ],
        [
            'label' => 'Reports',
            'value' => 'reports',
            'children' => [
                ['label' => 'Weekly summary', 'value' => 'weekly'],
                ['label' => 'Audit digest', 'value' => 'audit'],
            ],
        ],
    ];
@endphp

<div class="space-y-6" data-component-live-layout="checkbox-matrix">
    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-checkbox-live-section="usage">
        <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
            <div>
                <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Usage examples</h3>
                <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Checkbox supports independent choices and visible zero-or-more choice groups.</p>
            </div>
            <span class="inline-flex w-fit items-center rounded-full border px-2.5 py-1 text-xs font-semibold" style="border-color: var(--ui-border-subtle-01); color: var(--ui-text-secondary);">Flexible live-example layout</span>
        </div>

        <div class="mt-4 grid gap-4 lg:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Independent choice</h4>
                <div class="mt-4">
                    <x-ui.checkbox name="checkbox_independent_choice" label="Email alerts" helper="A single setting can be changed without affecting nearby options." />
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Multi-select group</h4>
                <div class="mt-4">
                    <x-ui.checkbox-group
                        name="checkbox_multi_select"
                        legend="Workspace permissions"
                        :options="[
                            ['label' => 'Manage users', 'value' => 'users'],
                            ['label' => 'View billing', 'value' => 'billing'],
                            ['label' => 'Export logs', 'value' => 'logs'],
                        ]"
                        :selected="['users']"
                        helper="Select every permission this role should receive."
                    />
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-checkbox-live-section="states">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">States</h3>
        <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">State treatments keep the control dimensions stable. Indeterminate appears only as a parent state in nested groups.</p>
        <div class="mt-4 grid gap-3 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($stateRows as [$label, $props])
                <article class="rounded-md border p-3" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-checkbox-state-row="{{ Str::slug($label) }}">
                    <p class="mb-3 text-xs font-semibold uppercase tracking-wide" style="color: var(--ui-text-helper);">{{ $label }}</p>
                    <x-ui.checkbox
                        :name="$props['name']"
                        :label="$props['label']"
                        :checked="$props['checked'] ?? false"
                        :disabled="$props['disabled'] ?? false"
                        :readonly="$props['readonly'] ?? false"
                        :error="$props['error'] ?? null"
                        :warning="$props['warning'] ?? null"
                    />
                </article>
            @endforeach
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-checkbox-live-section="group-states">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Group states</h3>
        <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Helper, disabled, read-only, error, and warning states apply to the group label and options. Error and warning copy appears once below the group.</p>
        <div class="mt-4 grid gap-4 lg:grid-cols-2">
            <x-ui.checkbox-group
                name="checkbox_group_helper"
                legend="Helper text"
                :options="[
                    ['label' => 'Reports', 'value' => 'reports'],
                    ['label' => 'Alerts', 'value' => 'alerts'],
                ]"
                helper="Use helper text when the whole group needs context."
            />

            <x-ui.checkbox-group
                name="checkbox_group_disabled"
                legend="Disabled group"
                :options="[
                    ['label' => 'Reports', 'value' => 'reports'],
                    ['label' => 'Alerts', 'value' => 'alerts'],
                ]"
                :selected="['reports']"
                disabled
            />

            <x-ui.checkbox-group
                name="checkbox_group_readonly"
                legend="Read-only group"
                :options="[
                    ['label' => 'Reports', 'value' => 'reports'],
                    ['label' => 'Alerts', 'value' => 'alerts'],
                ]"
                :selected="['reports']"
                readonly
            />

            <x-ui.checkbox-group
                name="checkbox_group_error"
                legend="Error group"
                :options="[
                    ['label' => 'Reports', 'value' => 'reports'],
                    ['label' => 'Alerts', 'value' => 'alerts'],
                ]"
                error="Choose at least one notification type."
            />

            <x-ui.checkbox-group
                name="checkbox_group_warning"
                legend="Warning group"
                :options="[
                    ['label' => 'Reports', 'value' => 'reports'],
                    ['label' => 'Alerts', 'value' => 'alerts'],
                ]"
                :selected="['alerts']"
                warning="Changing these options may affect scheduled reports."
            />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-checkbox-live-section="nesting">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Nested group</h3>
        <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Parent checkboxes select all children. Partial child selection sets the parent to the native mixed state.</p>
        <div class="mt-4 max-w-xl">
            <x-ui.checkbox-group
                name="checkbox_nested_permissions"
                legend="Notification groups"
                :options="$nestedOptions"
                :selected="['product', 'security', 'weekly']"
                nested
                helper="Use nesting only when parent and child options have a real relationship."
            />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-checkbox-live-section="overflow-alignment">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Overflow and alignment</h3>
        <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Labels wrap instead of truncating, with the control aligned to the top of the text. Vertical groups remain the default; horizontal groups are only for short labels.</p>
        <div class="mt-4 grid gap-4 lg:grid-cols-2">
            <x-ui.checkbox-group
                name="checkbox_wrapping_labels"
                legend="Long label handling"
                :options="[
                    ['label' => 'Receive workspace activity notifications when tenant administrators update security-sensitive settings', 'value' => 'activity'],
                    ['label' => 'Send audit digest', 'value' => 'audit'],
                ]"
                helper="Do not truncate checkbox labels with ellipses."
            />

            <x-ui.checkbox-group
                name="checkbox_horizontal_alignment"
                legend="Horizontal alignment"
                orientation="horizontal"
                :options="[
                    ['label' => 'Email', 'value' => 'email'],
                    ['label' => 'SMS', 'value' => 'sms'],
                    ['label' => 'Phone', 'value' => 'phone'],
                ]"
                :selected="['email']"
                helper="Use horizontal layout only for short predictable options."
            />
        </div>
    </section>
</div>
