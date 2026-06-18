<div class="w-full max-w-full min-w-0 overflow-visible rounded-md border px-3 py-3 sm:px-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-breadcrumb-live-proof>
    <x-ui.breadcrumb
        :items="$sample['items'] ?? []"
        :size="$sample['size'] ?? 'md'"
        :include-current="$sample['include_current'] ?? false"
        :current="$sample['current'] ?? null"
        :overflow="$sample['overflow'] ?? false"
        :menu-open="$sample['menu_open'] ?? false"
    />
</div>
