@php
    $items = [
        [
            'id' => 'accordion-variant-compact-help',
            'title' => 'Compact support note',
            'body' => 'Compact accordions reduce padding for dense secondary guidance without changing behavior.',
            'open' => true,
        ],
        [
            'id' => 'accordion-variant-compact-policy',
            'title' => 'Policy details',
            'body' => 'Use compact density only inside constrained settings, side panels, or utility regions.',
        ],
    ];
@endphp

<x-ui.accordion id="accordion-variant-compact-example" size="compact" :items="$items" />
