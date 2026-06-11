@php
    $items = [
        [
            'id' => 'accordion-variant-single-access',
            'title' => 'Access summary',
            'body' => 'Single-open mode closes sibling panels when a new section opens.',
            'open' => true,
        ],
        [
            'id' => 'accordion-variant-single-audit',
            'title' => 'Audit detail',
            'body' => 'Use this when one visible support section is clearer than several expanded panels.',
        ],
    ];
@endphp

<x-ui.accordion id="accordion-variant-single-open-example" mode="single" :items="$items" />
