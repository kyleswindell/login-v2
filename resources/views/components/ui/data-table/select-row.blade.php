{{-- ==========================================================================
    File: resources/views/components/ui/data-table/select-row.blade.php
    Purpose: Data Table body row selection cell.

    Notes:
    - Renders checkbox or radio row-selection controls inside a table cell.
    - Selection state is supplied by the caller.
    - Does not wire selection into the high-level data-table array renderer.
    ========================================================================== --}}

@props([
    'id' => null,
    'name' => null,
    'value' => null,
    'ariaLabel' => 'Select row',
    'checked' => false,
    'disabled' => false,
    'radio' => false,
])

@php
    use Illuminate\Support\Str;

    $resolvedId = $id ?? 'ui-table-select-row-'.Str::uuid();
    $resolvedName = $name ?? ($radio ? 'table-row-radio' : 'table-row-selection');
@endphp

<td
    {{ $attributes->class([
        'ui-table-column-checkbox',
        'ui-table-column-radio' => $radio,
    ]) }}
    aria-live="off"
>
    @if ($radio)
        <input
            id="{{ $resolvedId }}"
            class="ui-radio-button"
            type="radio"
            name="{{ $resolvedName }}"
            value="{{ $value ?? $resolvedId }}"
            aria-label="{{ $ariaLabel }}"
            @checked($checked)
            @disabled($disabled)
            data-ui-table-select-row
        >

        <label class="ui-radio-button-label" for="{{ $resolvedId }}">
            <span
                class="ui-radio-button-appearance ui-radio-button__appearance"
                aria-hidden="true"
            ></span>
            <span class="ui-visually-hidden sr-only">{{ $ariaLabel }}</span>
        </label>
    @else
        <input
            id="{{ $resolvedId }}"
            class="ui-checkbox"
            type="checkbox"
            name="{{ $resolvedName }}"
            value="{{ $value ?? $resolvedId }}"
            aria-label="{{ $ariaLabel }}"
            @checked($checked)
            @disabled($disabled)
            data-ui-table-select-row
        >

        <label class="ui-checkbox-label" for="{{ $resolvedId }}">
            <span class="ui-visually-hidden sr-only">{{ $ariaLabel }}</span>
        </label>
    @endif
</td>
