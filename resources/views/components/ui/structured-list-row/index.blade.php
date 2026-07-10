{{-- ==========================================================================
    File: resources/views/components/ui/structured-list-row/index.blade.php
    Purpose: Structured List summary row component.

    Notes:
    - Emits the installed .ui-structured-list-row selector contract.
    - Intended for compact app-owned summary rows where a full structured-list
      table is unnecessary.
    - Use x-ui.structured-list for native table-backed row/column comparison.
    ========================================================================== --}}

@props([
    'title' => null,
    'description' => null,
    'meta' => null,
    'selected' => false,
    'disabled' => false,
])

@php
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isSelected = filter_var($selected, FILTER_VALIDATE_BOOLEAN);
    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);

    $slotContent = trim($slot->toHtml());
    $resolvedTitle = $title ?? ($slotContent !== '' ? $slot : null);

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-structured-list-row',
        'ui-structured-list-row--summary',
        'ui-structured-list-row-selected' => $isSelected,
        'ui-structured-list-row-disabled' => $isDisabled,
    ];
@endphp

<div
    {{ $attributes->class($classes)->merge([
        'data-ui-component' => 'structured-list-row',
        'data-ui-structured-list-row' => true,
        'data-ui-structured-list-row-summary' => true,
        'data-ui-structured-list-row-selected' => $isSelected ? 'true' : 'false',
        'data-ui-structured-list-row-disabled' => $isDisabled ? 'true' : 'false',
        'aria-disabled' => $isDisabled ? 'true' : null,
    ]) }}
>
    <div class="ui-structured-list-row-content">
        <div class="ui-structured-list-row-main">
            @if (filled($resolvedTitle))
                <p class="ui-structured-list-row-title">
                    @if ($resolvedTitle instanceof HtmlString)
                        {!! $resolvedTitle !!}
                    @else
                        {{ $resolvedTitle }}
                    @endif
                </p>
            @endif

            @if (filled($description))
                <p class="ui-structured-list-cell-description">
                    @if ($description instanceof HtmlString)
                        {!! $description !!}
                    @else
                        {{ $description }}
                    @endif
                </p>
            @endif
        </div>

        @if (filled($meta))
            <span class="ui-structured-list-row-meta">
                @if ($meta instanceof HtmlString)
                    {!! $meta !!}
                @else
                    {{ $meta }}
                @endif
            </span>
        @endif
    </div>
</div>