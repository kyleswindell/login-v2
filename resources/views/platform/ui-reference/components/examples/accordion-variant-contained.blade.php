@php
    $items = [
        [
            'id' => 'accordion-variant-contained-layer',
            'title' => 'Contained layer example',
            'body' => 'Contained accordions sit on a parent surface and use nested layer tokens for the panel.',
            'open' => true,
        ],
        [
            'id' => 'accordion-variant-contained-boundary',
            'title' => 'Spacing boundary',
            'body' => 'The parent card owns external spacing; the Accordion owns internal trigger and panel spacing.',
        ],
    ];
@endphp

<div class="rounded-lg border p-3" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);">
    <x-ui.accordion id="accordion-variant-contained-example" variant="contained" :items="$items" />
</div>
