@props([
    'title' => null,
    'description' => null,
    'meta' => null,
    'selected' => false,
    'disabled' => false,
])

<div
    @class(['grid gap-1 border-b px-4 py-3 last:border-b-0', 'opacity-60' => $disabled])
    style="border-color: var(--ui-border-subtle-01); background-color: {{ $selected ? 'var(--ui-layer-selected-01)' : 'transparent' }};"
    data-ui-component="structured-list-row"
    data-ui-structured-list-row-selected="{{ $selected ? 'true' : 'false' }}"
    @if($disabled) aria-disabled="true" @endif
>
    <div class="flex flex-wrap items-start justify-between gap-3">
        <p class="text-sm font-semibold" style="color: var(--ui-text-primary);">{{ $title ?? $slot }}</p>
        @if ($meta)
            <span class="text-xs font-medium" style="color: var(--ui-text-helper);">{{ $meta }}</span>
        @endif
    </div>
    @if ($description)
        <p class="text-sm" style="color: var(--ui-text-secondary);">{{ $description }}</p>
    @endif
</div>
