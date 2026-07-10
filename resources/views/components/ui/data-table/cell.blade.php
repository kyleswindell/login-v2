{{-- ==========================================================================
    File: resources/views/components/ui/data-table/cell.blade.php
    Purpose: Data Table body cell wrapper.

    Notes:
    - Renders native td cells with optional alignment and span metadata.
    - Cell content is supplied by the parent table renderer or composition slot.
    ========================================================================== --}}

@props([
    'align' => 'start',
    'headers' => null,
    'colspan' => null,
])

@php
    $resolvedAlign = in_array($align, ['start', 'center', 'end'], true)
        ? $align
        : 'start';
@endphp

<td
    {{ $attributes->class([
        'ui-data-table-cell',
        'ui-data-table-cell-align-'.$resolvedAlign,
    ]) }}
    @if ($headers) headers="{{ $headers }}" @endif
    @if ($colspan) colspan="{{ $colspan }}" @endif
    @if ($resolvedAlign === 'end') align="right" @endif
    @if ($resolvedAlign === 'center') align="center" @endif
    data-ui-data-table-cell
>
    {{ $slot }}
</td>
