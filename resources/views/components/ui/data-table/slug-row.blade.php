{{-- ==========================================================================
    File: resources/views/components/ui/data-table/slug-row.blade.php
    Purpose: Deprecated Data Table slug leading cell.

    Notes:
    - Compatibility alias for older local examples or APIs.
    - Prefer resources/views/components/ui/data-table/decorator-row.blade.php.
    - Visual treatment is intentionally deferred until decorator cells are used.
    ========================================================================== --}}

@props([
    'slug' => null,
    'active' => null,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Deprecated slug row cell
    |--------------------------------------------------------------------------
    |
    | Carbon deprecated TableSlugRow in favor of TableDecoratorRow.
    | Keep this only for compatibility with older local examples or APIs.
    |
    */

    $hasSlug = ! is_null($active)
        ? (bool) $active
        : filled($slug) || trim((string) $slot) !== '';
@endphp

<td
    {{ $attributes->class([
        'ui-table-column-slug',
        'ui-table-column-slug--active' => $hasSlug,
    ])->merge([
        'data-ui-deprecated' => 'data-table.slug-row',
    ]) }}
>
    @if ($slug)
        {!! $slug !!}
    @else
        {{ $slot }}
    @endif
</td>
