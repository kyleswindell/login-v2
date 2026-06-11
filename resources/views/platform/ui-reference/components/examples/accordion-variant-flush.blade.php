@php
    $items = [
        [
            'id' => 'accordion-variant-flush-filters',
            'title' => 'Sidebar filter details',
            'body' => 'Flush alignment keeps the title and chevron aligned to the surrounding rule lines until hover or focus adds the interaction padding.',
            'open' => true,
        ],
        [
            'id' => 'accordion-variant-flush-shortcuts',
            'title' => 'Keyboard shortcuts',
            'body' => 'Use this alignment only in constrained side panels, sidebars, or similar compact regions.',
        ],
    ];
@endphp

<div class="max-w-sm border-y py-2" style="border-color: var(--ui-border-subtle-01);">
    <x-ui.accordion id="accordion-variant-flush-example" alignment="flush" :items="$items" />
</div>
