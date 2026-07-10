{{-- ==========================================================================
    File: resources/views/components/patterns/common-actions/action-set/index.blade.php
    Purpose: Common Actions pattern for grouping related action controls.

    Notes:
    - Establishes semantic grouping for related actions.
    - Accepts approved interactive primitives such as x-ui.button and x-ui.link.
    - Icons must remain inside accessible action controls.
    - Does not define button styling, spacing, layout, or action-specific CSS.
========================================================================== --}}

@props([
    'label' => 'Actions',
    'labelledBy' => null,
])

@php
    $resolvedLabelledBy = is_string($labelledBy) ? trim($labelledBy) : '';
    $resolvedLabel = is_string($label) && trim($label) !== ''
        ? trim($label)
        : 'Actions';

    $baseAttributes = [
        'data-pattern' => 'common-actions.action-set',
        'role' => 'group',
    ];

    if ($resolvedLabelledBy !== '') {
        $baseAttributes['aria-labelledby'] = $resolvedLabelledBy;
    } else {
        $baseAttributes['aria-label'] = $resolvedLabel;
    }

    $reservedAttributes = [
        'data-pattern',
        'role',
        'aria-label',
        'aria-labelledby',
        'aria-orientation',
    ];
@endphp

<div {{ $attributes->except($reservedAttributes)->merge($baseAttributes) }}>
    {{ $slot }}
</div>