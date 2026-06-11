@php
    $items = [
        [
            'id' => 'accordion-variant-scrollable-reference',
            'title' => 'Reference notes',
            'body' => 'Scrollable panels keep long optional reference content attached to its source setting while capping the panel height. Use this only for secondary content. Required guidance, errors, and recovery steps stay visible outside the collapsed region. The content should remain readable and should not become a substitute for a full page when the workflow is substantial.',
            'open' => true,
        ],
    ];
@endphp

<x-ui.accordion id="accordion-variant-scrollable-example" :items="$items" :scrollable="true" panel-max-height="6rem" />
