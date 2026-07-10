{{-- ==========================================================================
    File: resources/views/components/ui/progress-step/index.blade.php
    Purpose: Progress Step component.

    Notes:
    - Emits the installed .ui-progress-step selector contract.
    - Intended for use inside x-ui.progress-indicator.
    - Supports complete, current, incomplete/upcoming, invalid/error, disabled,
      secondary label, description, and optional interactive behavior.
    - Uses the unified x-ui.icon component for state icons.
    ========================================================================== --}}

@props([
    'label' => null,
    'state' => 'upcoming',
    'complete' => null,
    'current' => null,
    'invalid' => null,
    'disabled' => false,
    'description' => null,
    'secondaryLabel' => null,
    'index' => null,
    'interactive' => false,
])

@php
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $stateAliases = [
        'upcoming' => 'incomplete',
        'error' => 'invalid',
    ];

    $allowedStates = [
        'complete',
        'current',
        'incomplete',
        'invalid',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $requestedState = is_string($state)
        ? ($stateAliases[$state] ?? $state)
        : 'incomplete';

    $resolvedState = in_array($requestedState, $allowedStates, true)
        ? $requestedState
        : 'incomplete';

    if (! is_null($complete) && filter_var($complete, FILTER_VALIDATE_BOOLEAN)) {
        $resolvedState = 'complete';
    }

    if (! is_null($current) && filter_var($current, FILTER_VALIDATE_BOOLEAN)) {
        $resolvedState = 'current';
    }

    if (! is_null($invalid) && filter_var($invalid, FILTER_VALIDATE_BOOLEAN)) {
        $resolvedState = 'invalid';
    }

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isComplete = $resolvedState === 'complete';
    $isCurrent = $resolvedState === 'current';
    $isInvalid = $resolvedState === 'invalid';
    $isIncomplete = $resolvedState === 'incomplete';

    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $isInteractive = filter_var($interactive, FILTER_VALIDATE_BOOLEAN) && ! $isDisabled && ! $isCurrent;

    $statusMessage = match ($resolvedState) {
        'complete' => 'Complete',
        'current' => 'Current',
        'invalid' => 'Invalid',
        default => 'Incomplete',
    };

    $iconName = match ($resolvedState) {
        'complete' => 'checkmark--outline',
        'current' => 'incomplete',
        'invalid' => 'warning',
        default => 'circle-dash',
    };

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-progress-step',
        'ui-progress-step--current' => $isCurrent,
        'ui-progress-step--complete' => $isComplete,
        'ui-progress-step--incomplete' => $isIncomplete,
        'ui-progress-step--invalid' => $isInvalid,
        'ui-progress-step--disabled' => $isDisabled,
    ];

    $buttonClasses = [
        'ui-progress-step-button',
        'ui-progress-step-button--unclickable' => ! $isInteractive,
    ];
@endphp

<li
    {{ $attributes->class($classes)->merge([
        'data-ui-component' => 'progress-step',
        'data-ui-progress-step' => true,
        'data-ui-progress-step-state' => $resolvedState,
        'data-ui-progress-step-index' => $index,
        'data-ui-progress-step-disabled' => $isDisabled ? 'true' : 'false',
        'data-ui-progress-step-interactive' => $isInteractive ? 'true' : 'false',
    ]) }}
>
    <button
        type="button"
        @class($buttonClasses)
        @disabled($isDisabled)
        aria-disabled="{{ ($isDisabled || ! $isInteractive) ? 'true' : 'false' }}"
        tabindex="{{ $isDisabled || ! $isInteractive ? '-1' : '0' }}"
        title="{{ $label }}"
        data-ui-progress-step-button
    >
        <x-ui.icon
            :name="$iconName"
            class="ui-progress-step__icon"
            :label="$description"
            :decorative="blank($description)"
        />

        <span class="ui-progress-text">
            <span class="ui-progress-label">
                @if ($label instanceof HtmlString)
                    {!! $label !!}
                @else
                    {{ $label }}
                @endif
            </span>

            @if (! is_null($secondaryLabel))
                <span class="ui-progress-optional">
                    @if ($secondaryLabel instanceof HtmlString)
                        {!! $secondaryLabel !!}
                    @else
                        {{ $secondaryLabel }}
                    @endif
                </span>
            @endif
        </span>

        <span class="ui-assistive-text">{{ $statusMessage }}</span>
        <span class="ui-progress-line" aria-hidden="true"></span>
    </button>
</li>