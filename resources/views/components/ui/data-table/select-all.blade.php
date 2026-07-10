{{-- ==========================================================================
    File: resources/views/components/ui/data-table/select-all.blade.php
    Purpose: Data Table select-all header checkbox cell.

    Notes:
    - Renders only the table-header selection control anatomy.
    - Selection state and indeterminate behavior are supplied by the caller.
    - JavaScript must set the DOM input.indeterminate property when needed.
    ========================================================================== --}}

@props([
    'id' => null,
    'name' => 'select-all',
    'ariaLabel' => 'Select all rows in the table',
    'checked' => false,
    'indeterminate' => false,
    'disabled' => false,
])

@php
    use Illuminate\Support\Str;

    $resolvedId = $id ?? 'ui-table-select-all-'.Str::uuid();
@endphp

<th
    {{ $attributes->class('ui-table-column-checkbox') }}
    aria-live="off"
    scope="col"
>
    <input
        id="{{ $resolvedId }}"
        class="ui-checkbox"
        type="checkbox"
        name="{{ $name }}"
        aria-label="{{ $ariaLabel }}"
        aria-checked="{{ $indeterminate ? 'mixed' : ($checked ? 'true' : 'false') }}"
        @checked($checked)
        @disabled($disabled)
        data-ui-table-select-all
        @if ($indeterminate) data-ui-table-select-indeterminate="true" @endif
    >

    <label class="ui-checkbox-label" for="{{ $resolvedId }}">
        <span class="ui-visually-hidden sr-only">{{ $ariaLabel }}</span>
    </label>
</th>
