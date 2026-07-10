{{-- ==========================================================================
    File: resources/views/components/ui/progress-indicator/index.blade.php
    Purpose: Progress Indicator component.

    Notes:
    - Emits the installed .ui-progress selector contract.
    - Composes x-ui.progress-step.
    - Supports horizontal/vertical orientation, equal spacing, current index,
      array-driven steps, and optional interactive step behavior.
    ========================================================================== --}}

@props([
    'steps' => [],
    'currentIndex' => 0,
    'orientation' => 'horizontal',
    'vertical' => null,
    'spaceEqually' => false,
    'interactive' => false,
    'ariaLabel' => 'Progress',
])

@php
    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $isVertical = ! is_null($vertical)
        ? filter_var($vertical, FILTER_VALIDATE_BOOLEAN)
        : $orientation === 'vertical';

    $hasEqualSpacing = filter_var($spaceEqually, FILTER_VALIDATE_BOOLEAN) && ! $isVertical;
    $isInteractive = filter_var($interactive, FILTER_VALIDATE_BOOLEAN);

    $resolvedOrientation = $isVertical ? 'vertical' : 'horizontal';
    $resolvedCurrentIndex = is_numeric($currentIndex) ? (int) $currentIndex : 0;

    /*
    |--------------------------------------------------------------------------
    | Step Normalization
    |--------------------------------------------------------------------------
    */

    $normalizedSteps = collect($steps)
        ->values()
        ->map(function ($step, int $index) use ($resolvedCurrentIndex): array {
            if (is_string($step)) {
                $step = [
                    'label' => $step,
                ];
            }

            $explicitState = data_get($step, 'state');

            if (data_get($step, 'invalid') === true) {
                $state = 'invalid';
            } elseif (data_get($step, 'complete') === true) {
                $state = 'complete';
            } elseif (data_get($step, 'current') === true) {
                $state = 'current';
            } elseif (filled($explicitState)) {
                $state = $explicitState;
            } elseif ($index < $resolvedCurrentIndex) {
                $state = 'complete';
            } elseif ($index === $resolvedCurrentIndex) {
                $state = 'current';
            } else {
                $state = 'incomplete';
            }

            return [
                'label' => data_get($step, 'label', 'Step '.($index + 1)),
                'description' => data_get($step, 'description'),
                'secondaryLabel' => data_get($step, 'secondaryLabel', data_get($step, 'secondary_label')),
                'state' => $state,
                'disabled' => filter_var(data_get($step, 'disabled', false), FILTER_VALIDATE_BOOLEAN),
                'index' => $index,
            ];
        });

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-progress',
        'ui-progress--vertical' => $isVertical,
        'ui-progress--space-equal' => $hasEqualSpacing,
    ];
@endphp

<ol
    {{ $attributes->class($classes)->merge([
        'data-ui-component' => 'progress-indicator',
        'data-ui-progress-indicator' => true,
        'data-ui-progress-indicator-orientation' => $resolvedOrientation,
        'data-ui-progress-indicator-current-index' => $resolvedCurrentIndex,
        'data-ui-progress-indicator-space-equally' => $hasEqualSpacing ? 'true' : 'false',
        'data-ui-progress-indicator-interactive' => $isInteractive ? 'true' : 'false',
        'aria-label' => $ariaLabel,
    ]) }}
>
    @foreach ($normalizedSteps as $step)
        <x-ui.progress-step
            :label="$step['label']"
            :description="$step['description']"
            :secondary-label="$step['secondaryLabel']"
            :state="$step['state']"
            :disabled="$step['disabled']"
            :index="$step['index']"
            :interactive="$isInteractive"
        />
    @endforeach
</ol>