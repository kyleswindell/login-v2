@props([
    'text',
    'placement' => 'top',
])

<span
    class="relative inline-flex group"
    data-ui-component="tooltip"
    data-ui-tooltip-placement="{{ $placement }}"
>
    <span data-ui-tooltip-trigger>{{ $slot }}</span>
    <span
        role="tooltip"
        class="pointer-events-none absolute z-40 hidden max-w-xs rounded-md px-2 py-1 text-xs shadow-lg group-hover:block group-focus-within:block"
        style="background-color: var(--ui-background-inverse); color: var(--ui-text-inverse);"
        data-ui-tooltip-content
        data-ui-tooltip-state="closed"
    >
        {{ $text }}
    </span>
</span>
