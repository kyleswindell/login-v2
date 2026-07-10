{{-- ==========================================================================
    File: resources/views/components/ui/data-table/decorator-row.blade.php
    Purpose: Data Table decorator leading cell.

    Notes:
    - Low-level render component for decorator / AI-label table rows.
    - Prefer this component over slug-row for new usage.
    - Visual treatment is intentionally deferred until decorator cells are used.
    ========================================================================== --}}

@props([
    'decorator' => null,
    'active' => null,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Decorator row cell
    |--------------------------------------------------------------------------
    |
    | Carbon uses this as a leading cell for decorator / AI-label table rows.
    | In Blade, the decorator can be passed as a prop or provided through the
    | default slot.
    |
    */

    $hasDecorator = ! is_null($active)
        ? (bool) $active
        : filled($decorator) || trim((string) $slot) !== '';
@endphp

<td
    {{ $attributes->class([
        'ui-table-column-decorator',
        'ui-table-column-decorator--active' => $hasDecorator,
    ]) }}
>
    @if ($decorator)
        {!! $decorator !!}
    @else
        {{ $slot }}
    @endif
</td>
