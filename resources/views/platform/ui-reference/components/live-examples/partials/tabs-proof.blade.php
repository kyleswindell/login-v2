<x-ui.tabs
    :tabs="$sample['items'] ?? []"
    :variant="$sample['variant'] ?? 'line'"
    :orientation="$sample['orientation'] ?? 'horizontal'"
    :activation="$sample['activation'] ?? 'automatic'"
    :scrollable="$sample['scrollable'] ?? false"
    :grid-aware="$sample['grid_aware'] ?? false"
/>
