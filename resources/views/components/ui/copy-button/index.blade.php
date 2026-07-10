{{-- ==========================================================================
    File: resources/views/components/ui/copy-button/index.blade.php
    Purpose: Icon-only copy button with feedback tooltip support.

    Notes:
    - Emits the canonical .ui-btn .ui-btn--icon-only selector contract.
    - Extends the installed Icon Button / Tooltip anatomy.
    - Adds copy-specific data attributes for JavaScript clipboard behavior.
    - Uses the unified x-ui.icon component for icon rendering.
    - Uses Button kind and size styles from resources/css/components/button.css.
    - Uses Copy Button styles from resources/css/components/copy-button.css.
    - Uses tooltip styles/behavior from resources/css/components/tooltip.css.
    ========================================================================== --}}

@props([
    'copy' => null,
    'value' => null,
    'target' => null,
    'type' => 'button',
    'label' => null,
    'ariaLabel' => null,
    'icon' => 'copy--to-clipboard',
    'kind' => 'ghost',
    'semantic' => null,
    'size' => 'md',
    'align' => 'bottom',
    'tooltipPlacement' => null,
    'tooltipAlign' => 'center',
    'tooltipSize' => 'single',
    'feedback' => 'Copied!',
    'feedbackTimeout' => 2000,
    'copyState' => 'idle',
    'iconDescription' => 'Copy to clipboard',
    'disabled' => false,
    'loading' => false,
])

@php
    use Illuminate\Support\Str;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedKinds = ['primary', 'secondary', 'tertiary', 'ghost'];
    $allowedSizes = ['xs', 'sm', 'md', 'lg'];
    $allowedTypes = ['button', 'submit', 'reset'];
    $allowedCopyStates = ['idle', 'copied'];

    $allowedTooltipPlacements = [
        'auto',
        'top',
        'top-start',
        'top-end',
        'right',
        'right-start',
        'right-end',
        'bottom',
        'bottom-start',
        'bottom-end',
        'left',
        'left-start',
        'left-end',
    ];

    $allowedTooltipAlignments = ['start', 'center', 'end'];
    $allowedTooltipSizes = ['auto', 'single', 'multi', 'definition'];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    |
    | `align` is retained as a compatibility alias for tooltip placement.
    | `semantic` is retained as an older app alias for `kind`.
    |
    */

    $requestedKind = $semantic ?? $kind;

    $resolvedKind = in_array($requestedKind, $allowedKinds, true)
        ? $requestedKind
        : 'ghost';

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : 'md';

    $resolvedType = in_array($type, $allowedTypes, true)
        ? $type
        : 'button';

    $resolvedCopyState = in_array($copyState, $allowedCopyStates, true)
        ? $copyState
        : 'idle';

    $requestedTooltipPlacement = $tooltipPlacement ?? $align;

    $resolvedTooltipPlacement = in_array($requestedTooltipPlacement, $allowedTooltipPlacements, true)
        ? $requestedTooltipPlacement
        : 'bottom';

    $resolvedTooltipAlign = in_array($tooltipAlign, $allowedTooltipAlignments, true)
        ? $tooltipAlign
        : 'center';

    $resolvedTooltipSize = in_array($tooltipSize, $allowedTooltipSizes, true)
        ? $tooltipSize
        : 'single';

    /*
    |--------------------------------------------------------------------------
    | Copy Source
    |--------------------------------------------------------------------------
    |
    | `copy` and `value` are equivalent direct copy strings.
    | `target` may be used by JavaScript to copy from another element.
    |
    */

    $copyValue = $copy ?? $value;
    $copyTarget = $target;

    /*
    |--------------------------------------------------------------------------
    | Accessible Labeling and Tooltip Text
    |--------------------------------------------------------------------------
    */

    $accessibleLabel = $attributes->get('aria-label')
        ?? $ariaLabel
        ?? $label
        ?? $iconDescription;

    $tooltipText = $label ?? $iconDescription;
    $visibleTooltipText = $resolvedCopyState === 'copied' ? $feedback : $tooltipText;
    $tooltipId = 'ui-tooltip-'.Str::uuid();

    /*
    |--------------------------------------------------------------------------
    | ARIA Describedby Merging
    |--------------------------------------------------------------------------
    */

    $existingDescribedBy = $attributes->get('aria-describedby');

    $ariaDescribedBy = collect([$existingDescribedBy, $tooltipId])
        ->filter()
        ->implode(' ');

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isLoading = filter_var($loading, FILTER_VALIDATE_BOOLEAN);
    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN) || $isLoading;

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-btn',
        'ui-btn--'.$resolvedKind,
        'ui-btn--'.$resolvedSize,
        'ui-layout--size-'.$resolvedSize,
        'ui-btn--icon-only',
        'ui-icon-button',
        'ui-copy-btn',
        'ui-btn--disabled' => $isDisabled,
        'ui-btn--loading' => $isLoading,
    ];

    $tooltipWrapperClasses = [
        'ui-tooltip',
        'ui-icon-tooltip',
        'ui-copy-btn__wrapper',
        'ui-icon-tooltip--disabled' => $isDisabled,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    */

    $buttonAttributes = $attributes->except([
        'aria-label',
        'aria-describedby',
        'copy',
        'value',
        'target',
        'type',
        'label',
        'ariaLabel',
        'aria-label',
        'icon',
        'kind',
        'semantic',
        'size',
        'align',
        'tooltip-placement',
        'tooltipPlacement',
        'tooltip-align',
        'tooltipAlign',
        'tooltip-size',
        'tooltipSize',
        'feedback',
        'feedback-timeout',
        'feedbackTimeout',
        'copy-state',
        'copyState',
        'icon-description',
        'iconDescription',
        'disabled',
        'loading',
    ]);
@endphp

<span
    @class($tooltipWrapperClasses)
    data-ui-component="copy-button"
    data-ui-copy-button-wrapper
    data-ui-tooltip
    data-ui-tooltip-kind="default"
    data-ui-tooltip-placement="{{ $resolvedTooltipPlacement }}"
    data-ui-tooltip-resolved-placement="{{ $resolvedTooltipPlacement === 'auto' ? 'bottom' : $resolvedTooltipPlacement }}"
    data-ui-tooltip-align="{{ $resolvedTooltipAlign }}"
    data-ui-tooltip-size="{{ $resolvedTooltipSize }}"
    data-ui-tooltip-state="closed"
>
    <span class="ui-tooltip-trigger ui-tooltip-trigger__wrapper" data-ui-tooltip-trigger>
        <button
            type="{{ $resolvedType }}"
            aria-label="{{ $accessibleLabel }}"
            aria-describedby="{{ $ariaDescribedBy }}"
            @if ($isLoading) aria-busy="true" @endif
            @disabled($isDisabled)
            data-ui-copy-button
            data-ui-copy-button-trigger
            data-ui-copy-state="{{ $resolvedCopyState }}"
            data-ui-copy-feedback="{{ $feedback }}"
            data-ui-copy-feedback-timeout="{{ $feedbackTimeout }}"
            @if (filled($copyValue)) data-ui-copy-value="{{ $copyValue }}" @endif
            @if (filled($copyTarget)) data-ui-copy-target="{{ $copyTarget }}" @endif
            {{ $buttonAttributes->class($classes) }}
        >
            @if ($isLoading)
                <span class="ui-spinner" aria-hidden="true"></span>
            @else
                <x-ui.icon
                    :name="$icon"
                    class="ui-btn__icon ui-icon-button__icon ui-copy-btn__icon"
                    aria-hidden="true"
                />
            @endif
        </button>
    </span>

    <span
        id="{{ $tooltipId }}"
        role="tooltip"
        class="ui-tooltip-content ui-copy-btn__feedback"
        aria-hidden="true"
        data-ui-tooltip-content
        data-ui-tooltip-id="{{ $tooltipId }}"
        data-ui-tooltip-state="closed"
        data-ui-copy-feedback-content
        hidden
    >
        {{ $visibleTooltipText }}
        <span class="ui-tooltip-caret" aria-hidden="true" data-ui-tooltip-caret></span>
    </span>
</span>