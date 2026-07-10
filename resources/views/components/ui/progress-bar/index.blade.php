{{-- ==========================================================================
    File: resources/views/components/ui/progress-bar/index.blade.php
    Purpose: Progress Bar component.

    Notes:
    - Emits the installed .ui-progress-bar selector contract.
    - Supports active, finished, error, and indeterminate progress states.
    - Supports small/big sizes and default/inline/indented alignment types.
    - Uses the unified x-ui.icon component for finished/error status icons.
    ========================================================================== --}}

@props([
    'id' => null,
    'value' => null,
    'max' => 100,
    'label' => null,
    'ariaLabel' => null,
    'helperText' => null,
    'hideLabel' => false,
    'status' => 'active',
    'size' => 'big',
    'type' => 'default',
    'showValue' => false,
])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedStatuses = [
        'active',
        'finished',
        'error',
    ];

    $statusAliases = [
        'neutral' => 'active',
        'success' => 'finished',
        'complete' => 'finished',
        'done' => 'finished',
        'invalid' => 'error',
    ];

    $allowedSizes = [
        'small',
        'big',
    ];

    $sizeAliases = [
        'sm' => 'small',
        'md' => 'big',
        'lg' => 'big',
    ];

    $allowedTypes = [
        'default',
        'inline',
        'indented',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedId = $id ?? 'ui-progress-bar-'.Str::uuid();

    $requestedStatus = is_string($status)
        ? ($statusAliases[$status] ?? $status)
        : 'active';

    $resolvedStatus = in_array($requestedStatus, $allowedStatuses, true)
        ? $requestedStatus
        : 'active';

    $requestedSize = is_string($size)
        ? ($sizeAliases[$size] ?? $size)
        : 'big';

    $resolvedSize = in_array($requestedSize, $allowedSizes, true)
        ? $requestedSize
        : 'big';

    $resolvedType = in_array($type, $allowedTypes, true)
        ? $type
        : 'default';

    $safeMax = max(1, (float) $max);
    $numericValue = is_numeric($value) ? (float) $value : null;

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isFinished = $resolvedStatus === 'finished';
    $isError = $resolvedStatus === 'error';
    $isLabelHidden = filter_var($hideLabel, FILTER_VALIDATE_BOOLEAN);
    $shouldShowValue = filter_var($showValue, FILTER_VALIDATE_BOOLEAN);

    $isIndeterminate = ! $isFinished && ! $isError && is_null($numericValue);

    if ($isError) {
        $cappedValue = 0.0;
    } elseif ($isFinished) {
        $cappedValue = $safeMax;
    } elseif (! is_null($numericValue)) {
        $cappedValue = max(0, min($safeMax, $numericValue));
    } else {
        $cappedValue = null;
    }

    $percentage = is_null($cappedValue)
        ? null
        : round(($cappedValue / $safeMax) * 100);

    $scale = is_null($cappedValue)
        ? 1
        : max(0, min(1, $cappedValue / $safeMax));

    /*
    |--------------------------------------------------------------------------
    | ARIA Wiring
    |--------------------------------------------------------------------------
    */

    $labelId = $resolvedId.'-label';
    $helperTextId = filled($helperText) ? $resolvedId.'-helper-text' : null;

    $resolvedAriaLabel = $ariaLabel ?? $label ?? 'Progress';

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $rootClasses = [
        'ui-progress-bar',
        'ui-progress-bar--'.$resolvedSize,
        'ui-progress-bar--'.$resolvedType,
        'ui-progress-bar--indeterminate' => $isIndeterminate,
        'ui-progress-bar--finished' => $isFinished,
        'ui-progress-bar--error' => $isError,
    ];

    $labelClasses = [
        'ui-progress-bar__label',
        'ui-visually-hidden' => $isLabelHidden,
    ];

    $barStyle = 'transform: scaleX('.$scale.');';
@endphp

<div
    {{ $attributes->class($rootClasses)->merge([
        'id' => $resolvedId,
        'data-ui-component' => 'progress-bar',
        'data-ui-progress-bar' => true,
        'data-ui-progress-bar-status' => $resolvedStatus,
        'data-ui-progress-bar-size' => $resolvedSize,
        'data-ui-progress-bar-type' => $resolvedType,
        'data-ui-progress-bar-indeterminate' => $isIndeterminate ? 'true' : 'false',
    ]) }}
>
    @if (filled($label))
        <div id="{{ $labelId }}" @class($labelClasses)>
            <span class="ui-progress-bar__label-text">
                @if ($label instanceof HtmlString)
                    {!! $label !!}
                @else
                    {{ $label }}
                @endif
            </span>

            @if ($isFinished)
                <x-ui.icon
                    name="checkmark--filled"
                    class="ui-progress-bar__status-icon"
                    aria-hidden="true"
                />
            @elseif ($isError)
                <x-ui.icon
                    name="error--filled"
                    class="ui-progress-bar__status-icon"
                    aria-hidden="true"
                />
            @endif

            @if ($shouldShowValue && ! $isIndeterminate)
                <span class="ui-progress-bar__value-text">{{ $percentage }}%</span>
            @endif
        </div>
    @endif

    <div
        class="ui-progress-bar__track"
        role="progressbar"
        aria-busy="{{ $isFinished ? 'false' : 'true' }}"
        @if ($isError) aria-invalid="true" @endif
        @if (filled($label)) aria-labelledby="{{ $labelId }}" @else aria-label="{{ $resolvedAriaLabel }}" @endif
        @if (filled($helperTextId)) aria-describedby="{{ $helperTextId }}" @endif
        @unless ($isIndeterminate)
            aria-valuemin="0"
            aria-valuemax="{{ $safeMax }}"
            aria-valuenow="{{ $cappedValue }}"
        @endunless
        data-ui-progress-bar-track
    >
        <div
            class="ui-progress-bar__bar"
            style="{{ $barStyle }}"
            data-ui-progress-bar-bar
        ></div>
    </div>

    @if (filled($helperText))
        <div id="{{ $helperTextId }}" class="ui-progress-bar__helper-text">
            @if ($helperText instanceof HtmlString)
                {!! $helperText !!}
            @else
                {{ $helperText }}
            @endif

            <div class="ui-visually-hidden" aria-live="polite">
                {{ $isFinished ? 'Done' : 'Loading' }}
            </div>
        </div>
    @endif
</div>