{{-- ==========================================================================
    File: resources/views/components/ui/search-skeleton/index.blade.php
    Purpose: Search skeleton/loading placeholder component.

    Notes:
    - Emits the installed Search skeleton selector contract.
    - Supports Search size variants.
    - Retains small=true as a compatibility alias for size="sm".
    - Uses skeleton animation styles from resources/css/base/skeleton.css.
    - Uses Search styles from resources/css/components/search.css.
    - Does not render an interactive search input.
    ========================================================================== --}}

@props([
    'size' => null,
    'small' => false,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Supported public values
    |--------------------------------------------------------------------------
    */

    $allowedSizes = ['xs', 'sm', 'md', 'lg'];

    /*
    |--------------------------------------------------------------------------
    | Resolve values
    |--------------------------------------------------------------------------
    |
    | `small` is retained as a compatibility alias for size="sm".
    |
    */

    $resolvedSize = $small
        ? 'sm'
        : (in_array($size, $allowedSizes, true) ? $size : null);

    /*
    |--------------------------------------------------------------------------
    | CSS class contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-skeleton',
        'ui-search--sm' => (bool) $small,
        'ui-layout--size-'.$resolvedSize => filled($resolvedSize),
    ];
@endphp

<div
    aria-hidden="true"
    {{ $attributes->class($classes)->merge(['data-ui-component' => 'search-skeleton']) }}
>
    <div class="ui-search-input"></div>
</div>