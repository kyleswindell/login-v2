{{-- ==========================================================================
    File: resources/views/components/ui/pagination-nav/item.blade.php
    Purpose: UI pagination navigation page item.

    Source: Converted from the Carbon PaginationNav PaginationItem helper.

    Notes:
    - Renders one page button.
    - Uses one-based visible page numbers.
    - Uses zero-based data page index for JS behavior.
    ========================================================================== --}}

@props([
    'page',
    'pageIndex' => null,
    'active' => false,
    'itemLabel' => 'Page',
    'activeLabel' => 'Active',
])

@php
    /*
    |--------------------------------------------------------------------------
    | Normalize Values
    |--------------------------------------------------------------------------
    */

    $page = is_numeric($page) ? max((int) $page, 1) : 1;

    $resolvedPageIndex = ! is_null($pageIndex) && is_numeric($pageIndex)
        ? max((int) $pageIndex, 0)
        : $page - 1;

    $isActive = filter_var($active, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-pagination-nav__page',
        'ui-pagination-nav__page--active' => $isActive,
    ];
@endphp

<li
    class="ui-pagination-nav__list-item"
    data-ui-pagination-nav-list-item
>
    <button
        type="button"
        {{ $attributes->class($classes)->merge([
            'data-page' => $page,
            'data-page-index' => $resolvedPageIndex,
            'data-ui-pagination-nav-page' => true,
            'data-ui-pagination-nav-page-active' => $isActive ? 'true' : 'false',
        ]) }}
        @if ($isActive) aria-current="page" @endif
    >
        <span class="ui-pagination-nav__accessibility-label">
            {{ $isActive ? $activeLabel.', '.$itemLabel : $itemLabel }}
        </span>

        {{ $page }}
    </button>
</li>