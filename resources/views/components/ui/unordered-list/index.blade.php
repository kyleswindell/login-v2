{{-- ==========================================================================
    File: resources/views/components/ui/unordered-list/index.blade.php
    Purpose: UI unordered list component.

    Source: Converted from the Carbon UnorderedList React component.

    Notes:
    - Renders a ul element.
    - Applies the base unordered list class.
    - Supports nested list styling and expressive styling.
    - Intended to contain x-ui.list-item children.
    ========================================================================== --}}

@props([
    'nested' => false,
    'isExpressive' => false,
    'expressive' => null,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isNested = filter_var($nested, FILTER_VALIDATE_BOOLEAN);

    $hasExpressive = ! is_null($expressive)
        ? filter_var($expressive, FILTER_VALIDATE_BOOLEAN)
        : filter_var($isExpressive, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-list--unordered',
        'ui-list--nested' => $isNested,
        'ui-list--expressive' => $hasExpressive,
    ];
@endphp

<ul
    {{ $attributes->class($classes)->merge([
        'data-ui-component' => 'unordered-list',
        'data-ui-list' => 'unordered',
        'data-ui-list-unordered' => 'true',
        'data-ui-list-nested' => $isNested ? 'true' : 'false',
        'data-ui-list-expressive' => $hasExpressive ? 'true' : 'false',
    ]) }}
>
    {{ $slot }}
</ul>