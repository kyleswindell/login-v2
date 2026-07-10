{{-- ==========================================================================
    File: resources/views/components/ui/data-table/toolbar/index.blade.php
    Purpose: Data Table toolbar root wrapper.

    Notes:
    - Owns toolbar grouping semantics and size attributes.
    - Composes toolbar search, content, menu, and action subcomponents.
    - Does not own table filtering, sorting, selection, or batch action state.
    ========================================================================== --}}

@props([
    'ariaLabel' => 'data table toolbar',
    'size' => null,
])

@php
    $resolvedSize = in_array($size, ['xs', 'sm', 'lg'], true) ? $size : null;
@endphp

<section
    {{ $attributes->class([
        'ui-table-toolbar',
        'ui-table-toolbar--'.$resolvedSize => filled($resolvedSize),
        'ui-layout--size-'.$resolvedSize => filled($resolvedSize),
    ])->merge([
        'role' => 'group',
        'aria-label' => $ariaLabel,
        'data-ui-component' => 'data-table-toolbar',
        'data-ui-table-toolbar' => true,
        'data-ui-table-toolbar-size' => $resolvedSize,
    ]) }}
>
    {{ $slot }}
</section>
