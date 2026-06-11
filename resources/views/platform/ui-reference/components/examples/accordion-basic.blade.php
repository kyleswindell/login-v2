@php
    $items = [
        [
            'id' => 'accordion-basic-summary',
            'title' => 'Workspace review summary',
            'meta' => 'Optional supporting detail',
            'body' => 'Show concise supporting information that helps users understand the current section without forcing it into the primary page scan.',
            'open' => true,
        ],
        [
            'id' => 'accordion-basic-history',
            'title' => 'Recent review history',
            'body' => 'Collapsed content stays available without competing with the primary section content.',
        ],
    ];
@endphp

<x-ui.accordion id="accordion-basic-example" :items="$items" />
