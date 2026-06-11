@php
    $items = [
        [
            'id' => 'accordion-variant-icon-start-tree',
            'title' => 'Permission group',
            'body' => 'Start icon alignment is reserved for rare tree-like disclosure where the chevron visually leads the row label.',
            'open' => true,
        ],
        [
            'id' => 'accordion-variant-icon-start-audit',
            'title' => 'Audit detail group',
            'body' => 'Do not alternate icon placement inside the same page. Choose end alignment by default unless the whole surface needs this tree-like treatment.',
        ],
    ];
@endphp

<x-ui.accordion id="accordion-variant-icon-start-example" icon-alignment="start" :items="$items" />
