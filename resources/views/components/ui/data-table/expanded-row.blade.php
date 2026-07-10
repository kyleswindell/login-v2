{{-- ==========================================================================
    File: resources/views/components/ui/data-table/expanded-row.blade.php
    Purpose: Data Table expandable child detail row.

    Notes:
    - Renders the child row controlled by an expandable parent row.
    - Expanded state and column span are supplied by the caller.
    - Does not add local JavaScript expansion behavior.
    ========================================================================== --}}

@props([
    'id' => null,
    'colspan' => null,
    'colSpan' => null,
    'expanded' => false,
    'isExpanded' => null,
])

@php
    use Illuminate\Support\Str;

    $resolvedId = $id ?? 'ui-table-expanded-row-'.Str::uuid();
    $resolvedColspan = $colspan ?? $colSpan ?? 1;
    $isExpanded = is_null($isExpanded) ? (bool) $expanded : (bool) $isExpanded;
@endphp

<tr
    id="{{ $resolvedId }}"
    {{ $attributes->class('ui-expandable-row') }}
    data-child-row
    data-ui-table-expanded-row
    aria-hidden="{{ $isExpanded ? 'false' : 'true' }}"
    @unless ($isExpanded) hidden @endunless
>
    <td colspan="{{ $resolvedColspan }}">
        <div class="ui-child-row-inner-container">
            {{ $slot }}
        </div>
    </td>
</tr>
