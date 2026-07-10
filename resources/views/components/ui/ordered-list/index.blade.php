{{-- ==========================================================================
    File: resources/views/components/ui/ordered-list/index.blade.php
    Purpose: UI ordered list component.

    Source: Converted from the Carbon OrderedList React component.

    Notes:
    - Renders an ordered list element.
    - Uses custom ordered-list styling by default.
    - Supports native list styling, nested list styling, and expressive styling.
    - Intended to contain x-ui.list-item children.
    ========================================================================== --}}

@props([
    'nested' => false,
    'native' => false,
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
    $isNative = filter_var($native, FILTER_VALIDATE_BOOLEAN);

    $hasExpressive = ! is_null($expressive)
        ? filter_var($expressive, FILTER_VALIDATE_BOOLEAN)
        : filter_var($isExpressive, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-list--ordered' => ! $isNative,
        'ui-list--ordered--native' => $isNative,
        'ui-list--nested' => $isNested,
        'ui-list--expressive' => $hasExpressive,
    ];
@endphp

<ol
    {{ $attributes->class($classes)->merge([
        'data-ui-component' => 'ordered-list',
        'data-ui-list' => 'ordered',
        'data-ui-list-ordered' => 'true',
        'data-ui-list-native' => $isNative ? 'true' : 'false',
        'data-ui-list-nested' => $isNested ? 'true' : 'false',
        'data-ui-list-expressive' => $hasExpressive ? 'true' : 'false',
    ]) }}
>
    {{ $slot }}
</ol>