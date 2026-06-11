@props([
    'label',
    'placement' => 'top',
    'open' => false,
])

<span
    class="relative inline-flex"
    data-ui-component="toggletip"
    data-ui-toggletip
    data-ui-toggletip-placement="{{ $placement }}"
>
    <button
        type="button"
        class="ui-icon-button ui-icon-button-sm ui-action-ghost"
        aria-expanded="{{ $open ? 'true' : 'false' }}"
        data-ui-toggletip-trigger
    >
        <span class="sr-only">{{ $label }}</span>
        <span aria-hidden="true">?</span>
    </button>
    <span
        class="absolute z-40 mt-8 w-72 rounded-lg border p-3 text-sm shadow-xl"
        style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02); color: var(--ui-text-secondary);"
        data-ui-toggletip-panel
        @if(! $open) hidden @endif
    >
        {{ $slot }}
        <button type="button" class="ui-link mt-2" data-ui-toggletip-close>Close</button>
    </span>
</span>
