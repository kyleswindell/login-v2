@php
    $type = $sample['type'] ?? 'note';
    $items = $sample['items'] ?? [];
@endphp

<div class="space-y-4" data-ui-reference-sample-type="{{ $type }}">
    @switch($type)
        @case('buttons')
            <div class="flex flex-wrap items-center gap-3">
                @foreach ($items as $item)
                    <x-ui.button
                        :semantic="$item['semantic'] ?? 'neutral'"
                        :variant="$item['variant'] ?? 'base'"
                        :size="$item['size'] ?? 'md'"
                        :loading="$item['loading'] ?? false"
                        :disabled="$item['disabled'] ?? false"
                        @class([
                            'is-active' => ($item['pressed'] ?? false) || (($item['state'] ?? null) === 'active'),
                            'is-hover' => ($item['state'] ?? null) === 'hover',
                            'is-focus' => ($item['state'] ?? null) === 'focus',
                        ])
                    >
                        {{ $item['label'] }}
                    </x-ui.button>
                @endforeach
            </div>
        @break

        @case('icon-button')
            <div class="flex flex-wrap items-center gap-3">
                @foreach ($items as $item)
                    <x-ui.icon-button
                        :label="$item['label']"
                        :disabled="$item['disabled'] ?? false"
                        @class([
                            'is-hover' => ($item['state'] ?? null) === 'hover',
                            'is-focus' => ($item['state'] ?? null) === 'focus',
                            'is-active' => ($item['state'] ?? null) === 'active',
                        ])
                    >
                        <span aria-hidden="true">{{ $item['icon'] === 'arrow-path' ? '↻' : '•••' }}</span>
                    </x-ui.icon-button>
                @endforeach
            </div>
        @break

        @case('links')
            <div class="flex flex-wrap items-center gap-4 text-sm">
                @foreach ($items as $item)
                    <x-ui.link
                        :href="$item['href'] ?? '#'"
                        :external="$item['external'] ?? false"
                        :new-tab="$item['new_tab'] ?? false"
                        :icon="$item['icon'] ?? null"
                        :icon-position="$item['icon_position'] ?? 'leading'"
                        :disabled="$item['disabled'] ?? false"
                        :current="$item['current'] ?? false"
                        :visited="$item['visited'] ?? false"
                        @class([
                            'is-hover' => ($item['state'] ?? null) === 'hover',
                            'is-focus' => ($item['state'] ?? null) === 'focus',
                        ])
                    >
                        {{ $item['label'] }}
                    </x-ui.link>
                @endforeach
            </div>
        @break

        @case('menu')
            <x-ui.menu
                :items="$items"
                :trigger-label="$sample['trigger_label'] ?? 'Actions'"
                :trigger-kind="$sample['trigger_kind'] ?? 'text'"
                :size="$sample['size'] ?? 'md'"
                :align="$sample['align'] ?? 'bottom-start'"
                :open="$sample['open'] ?? false"
                :rtl="$sample['rtl'] ?? false"
            />
            @if ($sample['proof_panel'] ?? false)
                @php
                    $requestedProofSize = $sample['size'] ?? 'md';
                    $requestedProofAlign = $sample['align'] ?? 'bottom-start';
                    $proofSize = in_array($requestedProofSize, ['xs', 'sm', 'md', 'lg'], true) ? $requestedProofSize : 'md';
                    $proofAlign = in_array($requestedProofAlign, ['top-start', 'top-end', 'bottom-start', 'bottom-end'], true) ? $requestedProofAlign : 'bottom-start';
                    $proofItems = collect($items)->reject(fn ($item) => $item['hidden'] ?? false);
                    $proofReservesSelectionIndicator = $proofItems->contains(fn ($item) => ($item['selected'] ?? false) || filled($item['selection_type'] ?? $item['selectionType'] ?? null));
                @endphp
                <div
                    class="ui-menu ui-menu-{{ $proofSize }} ui-menu-proof-panel"
                    role="menu"
                    data-ui-menu-proof-panel
                    data-ui-menu-placement="{{ $proofAlign }}"
                    data-ui-menu-size="{{ $proofSize }}"
                    @if ($sample['rtl'] ?? false) dir="rtl" @endif
                >
                    @foreach ($proofItems as $item)
                        @php
                            $children = collect($item['children'] ?? [])->reject(fn ($child) => $child['hidden'] ?? false);
                            $hasSubmenu = $children->isNotEmpty() || ($item['submenu'] ?? false);
                        @endphp

                        @if ($item['divider'] ?? false)
                            <div class="ui-menu-divider" role="separator"></div>
                        @elseif ($children->isNotEmpty())
                            <div class="ui-menu-submenu-group" data-ui-menu-submenu>
                                <x-ui.menu-item
                                    :semantic="($item['danger'] ?? false) ? 'danger' : ($item['semantic'] ?? 'neutral')"
                                    :current="$item['current'] ?? false"
                                    :selected="$item['selected'] ?? false"
                                    :disabled="$item['disabled'] ?? false"
                                    :shortcut="$item['shortcut'] ?? null"
                                    submenu
                                    :size="$proofSize"
                                    :state="$item['state'] ?? null"
                                    :selection-type="$item['selection_type'] ?? $item['selectionType'] ?? null"
                                    :title="$item['title'] ?? null"
                                    :reserve-indicator="$proofReservesSelectionIndicator"
                                >
                                    {{ $item['label'] }}
                                </x-ui.menu-item>

                                <div
                                    class="ui-menu ui-menu-{{ $proofSize }} ui-menu-submenu-panel"
                                    role="menu"
                                    data-ui-menu-submenu-panel
                                    data-ui-menu-size="{{ $proofSize }}"
                                >
                                    @foreach ($children as $child)
                                        @if ($child['divider'] ?? false)
                                            <div class="ui-menu-divider" role="separator"></div>
                                        @else
                                            <x-ui.menu-item
                                                href="{{ $child['href'] ?? null }}"
                                                :semantic="($child['danger'] ?? false) ? 'danger' : ($child['semantic'] ?? 'neutral')"
                                                :current="$child['current'] ?? false"
                                                :selected="$child['selected'] ?? false"
                                                :disabled="$child['disabled'] ?? false"
                                                :shortcut="$child['shortcut'] ?? null"
                                                :size="$proofSize"
                                                :state="$child['state'] ?? null"
                                                :selection-type="$child['selection_type'] ?? $child['selectionType'] ?? null"
                                                :title="$child['title'] ?? null"
                                            >
                                                {{ $child['label'] }}
                                            </x-ui.menu-item>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <x-ui.menu-item
                                href="{{ $item['href'] ?? null }}"
                                :semantic="($item['danger'] ?? false) ? 'danger' : ($item['semantic'] ?? 'neutral')"
                                :current="$item['current'] ?? false"
                                :selected="$item['selected'] ?? false"
                                :disabled="$item['disabled'] ?? false"
                                :shortcut="$item['shortcut'] ?? null"
                                :submenu="$hasSubmenu"
                                :size="$proofSize"
                                :state="$item['state'] ?? null"
                                :selection-type="$item['selection_type'] ?? $item['selectionType'] ?? null"
                                :title="$item['title'] ?? null"
                                :reserve-indicator="$proofReservesSelectionIndicator"
                            >
                                {{ $item['label'] }}
                            </x-ui.menu-item>
                        @endif
                    @endforeach
                </div>
                <p class="ui-menu-proof-note">Static proof panel uses <code>x-ui.menu-item</code> states without forcing the interactive menu open.</p>
            @endif
        @break

        @case('menu-button')
            <div class="flex flex-wrap items-center gap-3">
                @foreach ($items as $item)
                    @if (($item['kind'] ?? 'text') === 'icon')
                        <button type="button" @disabled($item['disabled'] ?? false) class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-lg border" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01); color: var(--ui-icon-primary);" aria-label="{{ $item['label'] }}">•••</button>
                    @else
                        <x-ui.button variant="outline" :loading="$item['loading'] ?? false" :disabled="$item['disabled'] ?? false">{{ $item['label'] }} ▾</x-ui.button>
                    @endif
                @endforeach
            </div>
        @break

        @case('field')
            <div class="grid gap-4 md:grid-cols-2">
                @foreach ($items as $item)
                    @php
                        $fieldId = 'field-'.Str::slug($item['label'] ?? 'field').'-'.substr(md5(json_encode($item)), 0, 6);
                        $state = $item['state'] ?? 'default';
                        $controlClass = $item['type'] === 'select' ? 'ui-select' : ($item['type'] === 'textarea' ? 'ui-textarea' : 'ui-input');
                        $fieldOptions = $item['options'] ?? [
                            ['label' => 'Enabled', 'value' => 'enabled'],
                            ['label' => 'Pending review', 'value' => 'pending'],
                            ['label' => 'Disabled', 'value' => 'disabled'],
                        ];
                    @endphp
                    @if (($item['type'] ?? 'text') === 'search')
                        <x-ui.search
                            :name="$item['name'] ?? Str::slug($item['label'] ?? 'search', '_')"
                            :id="$fieldId"
                            :label="$item['label']"
                            :value="$item['value'] ?? null"
                            placeholder="Search records"
                            helper="Search applies to the current page region."
                            :disabled="$state === 'disabled'"
                            :loading="$item['loading'] ?? $state === 'loading'"
                            @class(['is-focus' => $state === 'focus'])
                        />
                    @elseif (($item['type'] ?? 'text') === 'select')
                        <x-ui.select
                            :name="$item['name'] ?? Str::slug($item['label'] ?? 'select', '_')"
                            :id="$fieldId"
                            :label="$item['label']"
                            :options="$fieldOptions"
                            :value="$item['value_key'] ?? 'enabled'"
                            helper="Helper text stays visible and concise."
                            :error="$state === 'error' ? 'Resolve this field before saving.' : null"
                            :warning="$state === 'warning' ? 'Review this selection before saving.' : null"
                            :disabled="$state === 'disabled'"
                            :readonly="$state === 'readonly'"
                            @class(['is-focus' => $state === 'focus'])
                        />
                    @elseif (($item['type'] ?? 'text') === 'dropdown')
                        <x-ui.dropdown
                            :name="$item['name'] ?? Str::slug($item['label'] ?? 'dropdown', '_')"
                            :label="$item['label']"
                            :options="$fieldOptions"
                            :value="$item['value_key'] ?? 'enabled'"
                            helper="Helper text stays visible and concise."
                            :error="$state === 'error' ? 'Resolve this dropdown before saving.' : null"
                            :warning="$state === 'warning' ? 'Review this selection before saving.' : null"
                            :disabled="$state === 'disabled'"
                            :open="$item['open'] ?? $state === 'focus'"
                        />
                    @elseif (($item['type'] ?? 'text') === 'file')
                        <x-ui.file-uploader
                            :name="$item['name'] ?? Str::slug($item['label'] ?? 'file', '_')"
                            :id="$fieldId"
                            :label="$item['label']"
                            helper="Upload accepted evidence files only."
                            :error="$state === 'error' ? 'Choose an accepted file before saving.' : null"
                            :warning="$state === 'warning' ? 'Large files may take longer to scan.' : null"
                            :disabled="$state === 'disabled'"
                        />
                    @elseif (($item['type'] ?? 'text') === 'number')
                        <x-ui.number-input
                            :name="$item['name'] ?? Str::slug($item['label'] ?? 'number', '_')"
                            :id="$fieldId"
                            :label="$item['label']"
                            :value="$item['value'] ?? 5"
                            :min="$item['min'] ?? 0"
                            :max="$item['max'] ?? 20"
                            :step="$item['step'] ?? 1"
                            helper="Helper text stays visible and concise."
                            :error="$state === 'error' ? 'Enter a valid number before saving.' : null"
                            :warning="$state === 'warning' ? 'Review this value before saving.' : null"
                            :disabled="$state === 'disabled'"
                            :readonly="$state === 'readonly'"
                            @class(['is-focus' => $state === 'focus'])
                        />
                    @else
                        <label class="block" for="{{ $fieldId }}" data-ui-component="{{ ($item['type'] ?? 'text') === 'textarea' ? 'textarea' : 'text-input' }}">
                            <span class="text-sm font-semibold" style="color: var(--ui-text-primary);">{{ $item['label'] }}</span>
                            @if (($item['type'] ?? 'text') === 'textarea')
                            <textarea id="{{ $fieldId }}" class="{{ $controlClass }} mt-2" @readonly($state === 'readonly') @disabled($state === 'disabled') @if ($state === 'error') aria-invalid="true" @endif>{{ $item['value'] }}</textarea>
                            @else
                                <input id="{{ $fieldId }}" type="{{ $item['type'] ?? 'text' }}" value="{{ $item['value'] }}" class="{{ $controlClass }} ui-text-input mt-2" @readonly($state === 'readonly') @disabled($state === 'disabled') @if ($state === 'error') aria-invalid="true" @endif>
                            @endif
                            <span class="mt-1 block text-xs" style="color: {{ $state === 'error' ? 'var(--ui-text-error)' : 'var(--ui-text-helper)' }};">{{ $state === 'error' ? 'Resolve this field before saving.' : 'Helper text stays visible and concise.' }}</span>
                        </label>
                    @endif
                @endforeach
            </div>
        @break

        @case('date-picker')
            <div class="grid gap-4 md:grid-cols-2">
                @foreach ($items as $item)
                    <x-ui.date-picker
                        :name="$item['name'] ?? 'date_picker_example'"
                        :id="$item['id'] ?? null"
                        :label="$item['label'] ?? 'Date'"
                        :value="$item['value'] ?? null"
                        :type="$item['date_type'] ?? 'date'"
                        :min="$item['min'] ?? null"
                        :max="$item['max'] ?? null"
                        :step="$item['step'] ?? null"
                        :required="$item['required'] ?? false"
                        :disabled="($item['state'] ?? null) === 'disabled' || ($item['disabled'] ?? false)"
                        :readonly="($item['state'] ?? null) === 'readonly' || ($item['readonly'] ?? false)"
                        :helper="$item['helper'] ?? null"
                        :error="($item['state'] ?? null) === 'error' ? ($item['error'] ?? 'Choose a valid date before continuing.') : ($item['error'] ?? null)"
                        :warning="($item['state'] ?? null) === 'warning' ? ($item['warning'] ?? 'This date is outside the recommended scheduling window.') : ($item['warning'] ?? null)"
                        :autocomplete="$item['autocomplete'] ?? null"
                        @class([
                            'is-focus' => ($item['state'] ?? null) === 'focus',
                        ])
                    />
                @endforeach
            </div>
        @break

        @case('multiselect')
            @php
                $multiselectOptions = [
                    ['label' => 'Owner', 'value' => 'owner'],
                    ['label' => 'Admin', 'value' => 'admin'],
                    ['label' => 'Billing', 'value' => 'billing'],
                    ['label' => 'Audit', 'value' => 'audit', 'disabled' => true],
                ];
            @endphp
            <div class="grid gap-4 md:grid-cols-2">
                @foreach ($items as $item)
                    <x-ui.multiselect
                        :name="$item['name'] ?? 'multiselect_example'"
                        :label="$item['label'] ?? 'Options'"
                        :options="$item['options'] ?? $multiselectOptions"
                        :value="$item['value'] ?? []"
                        :helper="$item['helper'] ?? 'Choose one or more known values.'"
                        :error="$item['error'] ?? null"
                        :warning="$item['warning'] ?? null"
                        :disabled="$item['disabled'] ?? false"
                        :readonly="$item['readonly'] ?? false"
                        :open="$item['open'] ?? false"
                        :filterable="$item['filterable'] ?? false"
                        :clearable="$item['clearable'] ?? false"
                        :select-all="$item['select_all'] ?? false"
                        :loading="$item['loading'] ?? false"
                    />
                @endforeach
            </div>
        @break

        @case('popover')
            <div class="flex flex-wrap items-start gap-4">
                @foreach ($items as $item)
                    <x-ui.popover
                        :label="$item['label'] ?? 'Open popover'"
                        :panel-label="$item['panel_label'] ?? null"
                        :placement="$item['placement'] ?? 'bottom'"
                        :align="$item['align'] ?? 'start'"
                        :size="$item['size'] ?? 'md'"
                        :tip="$item['tip'] ?? 'caret'"
                        :trigger-kind="$item['trigger_kind'] ?? 'icon'"
                        :trigger-icon="$item['trigger_icon'] ?? 'heroicon-o-information-circle'"
                        :interaction="$item['interaction'] ?? 'click'"
                        :open="$item['open'] ?? false"
                        :disabled="$item['disabled'] ?? false"
                        :closeable="$item['closeable'] ?? true"
                    >
                        @if (filled($item['title'] ?? null))
                            <x-slot:title>{{ $item['title'] }}</x-slot:title>
                        @endif
                        {{ $item['body'] ?? 'Short contextual content stays close to the trigger.' }}
                        @if (filled($item['footer'] ?? null))
                            <x-slot:footer>{{ $item['footer'] }}</x-slot:footer>
                        @endif
                    </x-ui.popover>
                @endforeach
            </div>
        @break

        @case('slider')
            <div class="grid gap-5 md:grid-cols-2">
                @foreach ($items as $item)
                    <x-ui.slider
                        :name="$item['name'] ?? 'slider_example'"
                        :label="$item['label'] ?? 'Slider'"
                        :min="$item['min'] ?? 0"
                        :max="$item['max'] ?? 100"
                        :step="$item['step'] ?? 1"
                        :value="$item['value'] ?? 50"
                        :unit="$item['unit'] ?? null"
                        :helper="$item['helper'] ?? 'Use sliders for bounded relative adjustment.'"
                        :error="$item['error'] ?? null"
                        :warning="$item['warning'] ?? null"
                        :disabled="$item['disabled'] ?? false"
                        :readonly="$item['readonly'] ?? false"
                        :show-input="$item['show_input'] ?? false"
                    />
                @endforeach
            </div>
        @break

        @case('range-slider')
            <div class="grid gap-5">
                @foreach ($items as $item)
                    <x-ui.range-slider
                        :name-min="$item['name_min'] ?? 'range_min'"
                        :name-max="$item['name_max'] ?? 'range_max'"
                        :label="$item['label'] ?? 'Range slider'"
                        :min="$item['min'] ?? 0"
                        :max="$item['max'] ?? 100"
                        :step="$item['step'] ?? 1"
                        :value-min="$item['value_min'] ?? 25"
                        :value-max="$item['value_max'] ?? 75"
                        :unit="$item['unit'] ?? null"
                        :helper="$item['helper'] ?? 'Use range sliders for lower and upper bounds.'"
                        :error="$item['error'] ?? null"
                        :warning="$item['warning'] ?? null"
                        :disabled="$item['disabled'] ?? false"
                        :readonly="$item['readonly'] ?? false"
                        :show-inputs="$item['show_inputs'] ?? false"
                    />
                @endforeach
            </div>
        @break

        @case('selection')
            <div class="grid gap-4 md:grid-cols-2">
                @foreach ($items as $item)
                    @php($selectionType = $item['type'] ?? 'checkbox')
                    <fieldset class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);">
                        <legend class="text-sm font-semibold" style="color: var(--ui-text-primary);">{{ $item['title'] }}</legend>
                        @if ($selectionType === 'toggle')
                            <div class="mt-4">
                                <x-ui.toggle
                                    :name="'toggle_'.Str::slug($item['title'])"
                                    label="Enable workspace notifications"
                                    :checked="($item['state'] ?? null) !== 'off'"
                                    :disabled="($item['state'] ?? null) === 'disabled'"
                                    :readonly="($item['state'] ?? null) === 'readonly'"
                                    helper="Changes apply immediately when enabled."
                                />
                            </div>
                        @elseif ($selectionType === 'checkbox')
                            <div class="mt-3">
                                <x-ui.checkbox-group
                                    :name="'selection_'.Str::slug($item['title'])"
                                    :options="[
                                        ['label' => 'Owner access', 'value' => 'owner'],
                                        ['label' => 'Billing access', 'value' => 'billing', 'indeterminate' => ($item['title'] ?? '') === 'Selected and unselected'],
                                        ['label' => 'Audit access', 'value' => 'audit', 'disabled' => ($item['state'] ?? null) === 'disabled'],
                                    ]"
                                    :selected="['owner']"
                                    :disabled="($item['state'] ?? null) === 'disabled'"
                                    :readonly="($item['state'] ?? null) === 'readonly'"
                                    :error="($item['state'] ?? null) === 'error' ? 'Choose an allowed option before continuing.' : null"
                                    helper="Choose every permission this role should receive."
                                />
                            </div>
                        @else
                            <div class="mt-3">
                                <x-ui.radio-group
                                    :name="'radio_'.Str::slug($item['title'])"
                                    label="Access level"
                                    :options="[
                                        ['label' => 'Owner access', 'value' => 'owner'],
                                        ['label' => 'Billing access', 'value' => 'billing'],
                                        ['label' => 'Audit access', 'value' => 'audit', 'disabled' => ($item['state'] ?? null) === 'disabled'],
                                    ]"
                                    value="owner"
                                    :orientation="($item['orientation'] ?? 'vertical')"
                                    helper="Choose one access level."
                                    :error="($item['state'] ?? null) === 'error' ? 'Choose an access level before continuing.' : null"
                                />
                            </div>
                        @endif
                        @if (($item['state'] ?? null) === 'error')
                            <p class="mt-3 text-xs" style="color: var(--ui-text-error);">Choose an allowed option before continuing.</p>
                        @endif
                    </fieldset>
                @endforeach
            </div>
        @break

        @case('content-switcher')
            <x-ui.content-switcher
                :options="$items"
                :value="$sample['value'] ?? null"
                :label="$sample['label'] ?? 'Content switcher'"
                :size="$sample['size'] ?? 'md'"
                :show-panels="$sample['show_panels'] ?? true"
            />
        @break

        @case('alert')
            <div class="grid gap-3">
                @foreach ($items as $item)
                    <x-ui.inline-alert :semantic="$item['semantic'] ?? 'info'" :title="$item['title'] ?? 'Information'">
                        The message explains what happened and what the user should do next.
                    </x-ui.inline-alert>
                @endforeach
            </div>
        @break

        @case('tag')
            <div class="flex flex-wrap gap-2">
                @foreach ($items as $item)
                    <x-ui.tag :tone="$item['semantic'] ?? ($item['tone'] ?? 'neutral')" :removable="$item['removable'] ?? false">
                        {{ $item['title'] ?? $item['semantic'] ?? 'Active' }}
                    </x-ui.tag>
                @endforeach
            </div>
        @break

        @case('loading')
            <div class="space-y-4">
                <div class="ui-loading flex items-center gap-3 text-sm" style="color: var(--ui-text-secondary);" data-ui-component="loading">
                    <span class="ui-spinner" aria-hidden="true"></span>
                    <span>{{ $items[0]['title'] ?? 'Loading state' }}</span>
                </div>
                <div class="space-y-2" aria-hidden="true">
                    <div class="h-3 w-1/2 rounded" style="background-color: var(--ui-skeleton-background);"></div>
                    <div class="h-3 w-3/4 rounded" style="background-color: var(--ui-skeleton-element);"></div>
                </div>
            </div>
        @break

        @case('inline-loading')
            <div class="flex flex-wrap items-center gap-4">
                @foreach ($items as $item)
                    <x-ui.inline-loading
                        :status="$item['status'] ?? ($item['semantic'] ?? 'loading')"
                        :label="$item['title'] ?? 'Saving changes'"
                    />
                @endforeach
            </div>
        @break

        @case('progress')
            <x-ui.progress-bar :value="$items[0]['value'] ?? 66" label="{{ $items[0]['title'] ?? 'Progress' }}" />
        @break

        @case('steps')
            <x-ui.progress-indicator :steps="$items[0]['steps'] ?? [
                ['label' => 'Details', 'state' => 'complete'],
                ['label' => 'Review', 'state' => 'current'],
                ['label' => 'Complete', 'state' => 'upcoming'],
            ]" :orientation="$items[0]['orientation'] ?? 'horizontal'" />
        @break

        @case('modal')
            <div class="rounded-xl border p-5 shadow-xl" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-ui-component="modal-preview">
                <h4 class="font-semibold" style="color: var(--ui-text-primary);">{{ $items[0]['title'] ?? 'Confirmation dialog' }}</h4>
                <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Modal copy states the decision and keeps required actions visible.</p>
                <div class="mt-4 flex flex-wrap justify-end gap-2">
                    <x-ui.button variant="ghost">Cancel</x-ui.button>
                    <x-ui.button semantic="primary">Continue</x-ui.button>
                </div>
            </div>
        @break

        @case('tooltip')
            <div class="flex flex-wrap items-center gap-4">
                <x-ui.tooltip :text="$items[0]['title'] ?? 'Helpful context'" :placement="$items[0]['placement'] ?? 'top'">
                    <x-ui.icon-button label="Tooltip target">?</x-ui.icon-button>
                </x-ui.tooltip>
            </div>
        @break

        @case('toggletip')
            <div class="flex flex-wrap items-start gap-4">
                @foreach ($items as $item)
                    <x-ui.toggletip
                        :label="$item['title'] ?? 'Open help'"
                        :placement="$item['placement'] ?? 'top'"
                        :open="$item['open'] ?? true"
                    >
                        {{ $item['body'] ?? 'Use toggletips for dismissible contextual help that needs richer content than a tooltip.' }}
                    </x-ui.toggletip>
                @endforeach
            </div>
        @break

        @case('table')
            <x-ui.data-table
                title="{{ $items[0]['title'] ?? 'Workspace table' }}"
                description="Rendered through the canonical data table Component API."
                :columns="[
                    ['key' => 'name', 'label' => 'Name', 'sortable' => true],
                    ['key' => 'status', 'label' => 'Status'],
                    ['key' => 'updated', 'label' => 'Updated'],
                ]"
                :rows="[
                    ['name' => 'Workspace alpha', 'status' => 'Active', 'updated' => 'Today', 'current' => true],
                    ['name' => 'Workspace beta', 'status' => 'Pending', 'updated' => 'Yesterday'],
                ]"
                sortable
                sort-by="name"
                sort-direction="asc"
                row-actions
            />
        @break

        @case('pagination')
            <x-ui.pagination
                :current-page="$items[0]['current_page'] ?? 2"
                :last-page="$items[0]['last_page'] ?? 5"
                :total="$items[0]['total'] ?? 120"
                :per-page="$items[0]['per_page'] ?? 25"
                :variant="$items[0]['variant'] ?? 'full'"
                :page-size-options="$items[0]['page_size_options'] ?? [10, 25, 50]"
            />
        @break

        @case('structured-list')
            <x-ui.structured-list
                :selectable="$items[0]['selectable'] ?? true"
                :condensed="($items[0]['density'] ?? null) === 'compact'"
                :rows="$items[0]['rows'] ?? [
                    ['title' => 'Production tenant', 'description' => 'Primary tenant environment.', 'meta' => 'Active', 'selected' => true],
                    ['title' => 'Staging tenant', 'description' => 'Release review environment.', 'meta' => 'Pending'],
                    ['title' => 'Sandbox tenant', 'description' => 'Local test environment.', 'meta' => 'Disabled', 'disabled' => true],
                ]"
            />
        @break

        @case('list')
            @php($listKind = $items[0]['kind'] ?? 'unordered')
            @if ($listKind === 'ordered')
                <ol class="ui-list ui-list-ordered">
                    <li>Review tenant identity.</li>
                    <li>Confirm routing policy.</li>
                    <li>Save the configuration.</li>
                </ol>
            @elseif ($listKind === 'content')
                <ul class="ui-list ui-list-content">
                    <li>Content lists remove marker styling when the surrounding content already provides structure.</li>
                    <li>Use this only for content blocks, not navigation or actions.</li>
                </ul>
            @else
                <ul class="ui-list ui-list-unordered">
                    <li>Ordered and unordered content uses browser semantics.</li>
                    <li>Nested lists are limited to content documentation, not app navigation.
                        <ul class="ui-list ui-list-nested">
                            <li>Nested item text remains short and supporting.</li>
                        </ul>
                    </li>
                    <li>Comparable rows should move to structured list or table.</li>
                </ul>
            @endif
        @break

        @case('contained-list')
            <div class="grid gap-4 md:grid-cols-2">
                @foreach ($items as $item)
                    <x-ui.contained-list
                        :title="$item['title'] ?? 'Contained list'"
                        :description="$item['description'] ?? null"
                        :items="$item['rows'] ?? []"
                        :variant="$item['variant'] ?? 'on-page'"
                        :size="$item['size'] ?? 'md'"
                        :loading="$item['loading'] ?? false"
                        :empty-title="$item['empty_title'] ?? 'No items'"
                        :empty-description="$item['empty_description'] ?? null"
                    />
                @endforeach
            </div>
        @break

        @case('tree-view')
            <div class="grid gap-4 md:grid-cols-2">
                @foreach ($items as $item)
                    <x-ui.tree-view
                        :label="$item['label'] ?? 'Tree view'"
                        :nodes="$item['nodes'] ?? []"
                        :selected="$item['selected'] ?? null"
                        :active="$item['active'] ?? null"
                        :expanded="$item['expanded'] ?? []"
                    />
                @endforeach
            </div>
        @break

        @case('code')
            <x-ui.code-snippet
                :variant="$sample['variant'] ?? 'single'"
                :language="$sample['language'] ?? 'Blade'"
                :copyable="$sample['copyable'] ?? false"
                :copy-state="$sample['copy_state'] ?? 'idle'"
            >{!! $sample['code'] ?? '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.button</span> <span class="ui-code-token-property">semantic</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"primary"</span><span class="ui-code-token-punctuation">&gt;</span>Save<span class="ui-code-token-punctuation">&lt;/</span><span class="ui-code-token-keyword">x-ui.button</span><span class="ui-code-token-punctuation">&gt;</span>' !!}</x-ui.code-snippet>
        @break

        @case('tile')
            <div class="grid gap-3 md:grid-cols-3">
                <x-ui.tile title="Static tile" description="Tile content stays compact and scannable." />
                <x-ui.tile title="Clickable tile" description="Links may make the full tile actionable." href="#" variant="clickable" />
                <x-ui.tile title="Selectable tile" description="Selected tiles use the selected layer token." variant="selectable" selected />
            </div>
        @break

        @case('breadcrumb')
            <div class="w-full max-w-full min-w-0 overflow-visible rounded-md border px-3 py-3 sm:px-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-ui-reference-breadcrumb-sample>
                <x-ui.breadcrumb
                    :items="$items"
                    :size="$sample['size'] ?? 'md'"
                    :include-current="$sample['include_current'] ?? false"
                    :current="$sample['current'] ?? null"
                    :overflow="$sample['overflow'] ?? false"
                    :menu-open="$sample['menu_open'] ?? false"
                />
            </div>
        @break

        @case('tabs')
            <x-ui.tabs
                :tabs="$items"
                :variant="$sample['variant'] ?? 'line'"
                :orientation="$sample['orientation'] ?? 'horizontal'"
                :activation="$sample['activation'] ?? 'automatic'"
                :scrollable="$sample['scrollable'] ?? false"
                :grid-aware="$sample['grid_aware'] ?? false"
            />
        @break

        @case('shell')
            <div class="overflow-hidden rounded-lg border" style="border-color: var(--ui-border-subtle-01);">
                <div class="flex items-center justify-between px-4 py-3" style="background-color: var(--ui-layer-inverse); color: var(--ui-text-inverse);">
                    <span class="font-semibold">Login App 2.0</span>
                    <span>Account</span>
                </div>
                <div class="grid min-h-40 grid-cols-[10rem_1fr]">
                    <aside class="border-r p-3 text-sm" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02); color: var(--ui-text-secondary);">Left panel</aside>
                    <main class="p-4" style="background-color: var(--ui-background); color: var(--ui-text-primary);">Main content region</main>
                </div>
            </div>
        @break

        @case('deferred')
            <div class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);">
                <p class="font-semibold" style="color: var(--ui-text-primary);">{{ $items[0]['label'] ?? 'Deferred implementation' }}</p>
                <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">This page documents the boundary and trigger condition before an app API is created.</p>
                @if (count($items) > 1)
                    <ul class="mt-3 space-y-1 text-sm" style="color: var(--ui-text-secondary);">
                        @foreach ($items as $item)
                            <li>{{ $item['label'] }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @break

        @default
            <div class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);">
                <p class="font-semibold" style="color: var(--ui-text-primary);">{{ $items[0]['title'] ?? 'Reference sample' }}</p>
            </div>
    @endswitch
</div>
