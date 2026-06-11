@php
    $items = [
        [
            'id' => 'accordion-long-wrapping',
            'title' => 'Long guidance wraps without horizontal overflow',
            'body' => 'Accordion body content may wrap across multiple lines when a section needs extra explanation. Keep the copy concise, use visible labels and validation outside the panel, and move long workflows into a full page or Pattern-owned surface when the content becomes substantial.',
            'open' => true,
        ],
        [
            'id' => 'accordion-long-boundary',
            'title' => 'Panel boundary',
            'body' => 'Required instructions and validation recovery still belong outside the collapsed region.',
        ],
    ];
@endphp

<x-ui.accordion id="accordion-long-content-example" :items="$items" />
