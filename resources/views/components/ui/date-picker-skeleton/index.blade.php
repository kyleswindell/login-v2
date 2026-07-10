{{-- ==========================================================================
    File: resources/views/components/ui/date-picker-skeleton/index.blade.php
    Purpose: Date Picker skeleton/loading placeholder component.

    Notes:
    - Emits the installed .ui-date-picker skeleton selector contract.
    - Supports simple/single and range skeleton variants.
    - Supports hidden label.
    - Uses skeleton animation styles from resources/css/base/skeleton.css.
    - Uses Date Picker styles from resources/css/components/date-picker.css.
    - Does not render interactive date inputs.
    ========================================================================== --}}

@props([
    'id' => null,
    'hideLabel' => false,
    'range' => false,
])

@php
    use Illuminate\Support\Str;

    /*
    |--------------------------------------------------------------------------
    | Resolve IDs
    |--------------------------------------------------------------------------
    */

    $resolvedId = $id ?? 'ui-date-picker-skeleton-'.Str::uuid();

    /*
    |--------------------------------------------------------------------------
    | Render state
    |--------------------------------------------------------------------------
    */

    $isRange = (bool) $range;

    /*
    |--------------------------------------------------------------------------
    | CSS class contract
    |--------------------------------------------------------------------------
    */

    $datePickerClasses = [
        'ui-date-picker',
        'ui-date-picker--range' => $isRange,
        'ui-date-picker--short' => ! $isRange,
        'ui-date-picker--simple' => ! $isRange,
        'ui-skeleton',
    ];
@endphp

<div
    aria-hidden="true"
    class="ui-form-item"
    data-ui-component="date-picker-skeleton"
>
    <div {{ $attributes->class($datePickerClasses) }}>
        @foreach (range(0, $isRange ? 1 : 0) as $index)
            <div class="ui-date-picker-container">
                @unless ($hideLabel)
                    <span
                        id="{{ $resolvedId }}-label-{{ $index }}"
                        class="ui-label ui-skeleton"
                    ></span>
                @endunless

                <div class="ui-date-picker__input ui-skeleton"></div>
            </div>
        @endforeach
    </div>
</div>