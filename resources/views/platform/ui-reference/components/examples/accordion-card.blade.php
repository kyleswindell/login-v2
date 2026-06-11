@php
    $items = [
        [
            'id' => 'accordion-card-ownership',
            'title' => 'Surface ownership',
            'body' => 'The parent card owns external spacing and context. The Accordion owns only trigger, panel, and internal item spacing.',
            'open' => true,
        ],
        [
            'id' => 'accordion-card-theme',
            'title' => 'Theme and layer behavior',
            'body' => 'Nested surfaces use approved layer, border, text, and focus tokens so the component remains readable in supported themes.',
        ],
    ];
@endphp

<div class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);">
    <p class="text-sm font-semibold" style="color: var(--ui-text-primary);">Review configuration</p>
    <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Accordion may be composed inside a card when the card remains the owner of the surrounding content region.</p>
    <div class="mt-4">
        <x-ui.accordion id="accordion-card-example" variant="contained" :items="$items" />
    </div>
</div>
