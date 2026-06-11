@php
    $items = [
        [
            'id' => 'accordion-multiple-access',
            'title' => 'Access requirements',
            'body' => 'Users can keep this section open while opening another nearby section for comparison.',
            'open' => true,
        ],
        [
            'id' => 'accordion-multiple-notifications',
            'title' => 'Notification behavior',
            'body' => 'Multiple panels may be open at once. Do not build single-open behavior until a product workflow requires it.',
            'open' => true,
        ],
        [
            'id' => 'accordion-multiple-disabled',
            'title' => 'Locked integration details',
            'meta' => 'Disabled until integration setup exists',
            'body' => 'Disabled accordion items cannot be expanded.',
            'disabled' => true,
        ],
    ];
@endphp

<x-ui.accordion id="accordion-multiple-example" :items="$items" />
