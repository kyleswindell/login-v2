@php
    $multiselectOptions = [
        ['label' => 'Owner', 'value' => 'owner'],
        ['label' => 'Admin', 'value' => 'admin'],
        ['label' => 'Billing', 'value' => 'billing'],
        ['label' => 'Audit', 'value' => 'audit', 'disabled' => true],
    ];
@endphp

<div class="grid gap-4 md:grid-cols-2">
    @foreach (($sample['items'] ?? []) as $item)
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
