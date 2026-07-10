{{-- ==========================================================================
    File: resources/views/components/ui/icon-button/index.blade.php
    Purpose: Icon-only Button component with optional tooltip and badge support.

    Notes:
    - Emits the canonical .ui-btn .ui-btn--icon-only selector contract.
    - Uses the installed tooltip wrapper/data-attribute pattern.
    - Uses Button kind and size styles from resources/css/components/button.css.
    - Uses badge styles from resources/css/components/badge-indicator.css.
    - Icon Button supports primary, secondary, tertiary, and ghost kinds only.
    - Standard text buttons should use resources/views/components/ui/button/index.blade.php.
    ========================================================================== --}}

@props([
    'href' => null,
    'type' => 'button',
    'label' => null,
    'ariaLabel' => null,
    'icon' => null,
    'kind' => null,
    'semantic' => 'ghost',
    'size' => 'md',
    'tooltip' => null,
    'tooltipPlacement' => 'top',
    'tooltipAlign' => 'center',
    'tooltipSize' => 'single',
    'disabled' => false,
    'loading' => false,
    'selected' => false,
    'isSelected' => null,
    'badgeCount' => null,
])

@php
    use Illuminate\Support\Str;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    |
    | Icon Button intentionally supports the icon-only kind set only.
    | `kind` is canonical. `semantic` is retained for older app usage.
    |
    */

    $allowedKinds = [
        'primary',
        'secondary',
        'tertiary',
        'ghost',
    ];

    $allowedSizes = [
        'xs',
        'sm',
        'md',
        'lg',
    ];

    $allowedTypes = [
        'button',
        'submit',
        'reset',
    ];

    $allowedTooltipPlacements = [
        'auto',
        'top',
        'right',
        'bottom',
        'left',
    ];

    $allowedTooltipAlignments = [
        'start',
        'center',
        'end',
    ];

    $allowedTooltipSizes = [
        'auto',
        'single',
        'multi',
        'definition',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Kind / Size / Type
    |--------------------------------------------------------------------------
    */

    $requestedKind = $kind ?? $semantic;

    $resolvedKind = in_array($requestedKind, $allowedKinds, true)
        ? $requestedKind
        : 'ghost';

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : 'md';

    $resolvedType = in_array($type, $allowedTypes, true)
        ? $type
        : 'button';

    /*
    |--------------------------------------------------------------------------
    | Resolve Tooltip Values
    |--------------------------------------------------------------------------
    |
    | The tooltip API uses split placement + alignment values. Composite
    | placement aliases such as top-start are accepted and normalized.
    |
    */

    $compositeTooltipPlacements = [
        'top-start' => ['top', 'start'],
        'top-end' => ['top', 'end'],
        'right-start' => ['right', 'start'],
        'right-end' => ['right', 'end'],
        'bottom-start' => ['bottom', 'start'],
        'bottom-end' => ['bottom', 'end'],
        'left-start' => ['left', 'start'],
        'left-end' => ['left', 'end'],
    ];

    if (array_key_exists($tooltipPlacement, $compositeTooltipPlacements)) {
        [$placementFromComposite, $alignFromComposite] = $compositeTooltipPlacements[$tooltipPlacement];

        $resolvedTooltipPlacement = $placementFromComposite;
        $resolvedTooltipAlign = in_array($tooltipAlign, $allowedTooltipAlignments, true)
            ? $tooltipAlign
            : $alignFromComposite;
    } else {
        $resolvedTooltipPlacement = in_array($tooltipPlacement, $allowedTooltipPlacements, true)
            ? $tooltipPlacement
            : 'top';

        $resolvedTooltipAlign = in_array($tooltipAlign, $allowedTooltipAlignments, true)
            ? $tooltipAlign
            : 'center';
    }

    $resolvedTooltipSize = in_array($tooltipSize, $allowedTooltipSizes, true)
        ? $tooltipSize
        : 'single';

    $resolvedTooltipRuntimePlacement = $resolvedTooltipPlacement === 'auto'
        ? 'top'
        : $resolvedTooltipPlacement;

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    |
    | Loading is treated as disabled for interaction purposes. If href is present
    | but the control is disabled/loading, render a button instead of an anchor so
    | disabled semantics remain valid.
    |
    */

    $isLoading = filter_var($loading, FILTER_VALIDATE_BOOLEAN);
    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN) || $isLoading;
    $isLink = filled($href) && ! $isDisabled;

    $resolvedSelected = ! is_null($isSelected)
        ? filter_var($isSelected, FILTER_VALIDATE_BOOLEAN)
        : filter_var($selected, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | Accessible Labeling
    |--------------------------------------------------------------------------
    |
    | Icon-only buttons require an accessible label. Tooltip text may supply the
    | visible tooltip label, but aria-label remains the control name.
    |
    */

    $accessibleLabel = $ariaLabel ?? $label ?? $tooltip ?? 'Icon button';
    $tooltipText = $tooltip ?? $label;
    $hasTooltip = filled($tooltipText);

    /*
    |--------------------------------------------------------------------------
    | Badge Handling
    |--------------------------------------------------------------------------
    |
    | A badge count of 0 renders a dot badge. Positive values render a numbered
    | badge and are included in aria-describedby.
    |
    */

    $hasBadge = ! is_null($badgeCount);
    $hasDescriptiveBadge = $hasBadge && is_numeric($badgeCount) && (int) $badgeCount > 0;

    $tooltipId = $hasTooltip ? 'ui-tooltip-'.Str::uuid() : null;
    $badgeId = $hasDescriptiveBadge ? 'ui-badge-indicator-'.Str::uuid() : null;

    /*
    |--------------------------------------------------------------------------
    | aria-describedby Merging
    |--------------------------------------------------------------------------
    |
    | Preserve caller-provided aria-describedby and append the tooltip and badge
    | IDs when those generated descriptions exist.
    |
    */

    $existingDescribedBy = $attributes->get('aria-describedby');

    $ariaDescribedBy = collect([
        $existingDescribedBy,
        $tooltipId,
        $badgeId,
    ])->filter()->implode(' ');

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    |
    | These classes must match resources/css/components/button.css and
    | resources/css/components/badge-indicator.css.
    |
    */

    $classes = [
        'ui-btn',
        'ui-btn--'.$resolvedKind,
        'ui-btn--'.$resolvedSize,
        'ui-layout--size-'.$resolvedSize,
        'ui-btn--icon-only',
        'ui-icon-button',
        'ui-btn--disabled' => $isDisabled,
        'ui-btn--loading' => $isLoading,
        'ui-btn--selected' => $resolvedKind === 'ghost' && $resolvedSelected,
    ];

    $tooltipWrapperClasses = [
        'ui-tooltip',
        'ui-icon-tooltip',
        'ui-icon-tooltip--disabled' => $isDisabled,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    |
    | aria-describedby is rebuilt so caller-provided values and generated
    | tooltip/badge descriptions can both be preserved.
    |
    */

    $componentAttributes = $attributes->except([
        'aria-describedby',
    ]);

    $controlDataAttributes = [
        'data-ui-component' => 'icon-button',
        'data-ui-icon-button' => true,
        'data-ui-icon-button-kind' => $resolvedKind,
        'data-ui-icon-button-size' => $resolvedSize,
        'data-ui-icon-button-loading' => $isLoading ? 'true' : 'false',
        'data-ui-icon-button-selected' => $resolvedSelected ? 'true' : 'false',
        'data-ui-icon-button-badge' => $hasBadge ? 'true' : 'false',
    ];
@endphp

@if ($hasTooltip)
    {{-- ----------------------------------------------------------------------
        Tooltip wrapper
        ----------------------------------------------------------------------
        Icon Button uses a tooltip wrapper around the trigger control. Tooltip
        open/close behavior is handled by the installed tooltip JavaScript.
        ---------------------------------------------------------------------- --}}

    <span
        @class($tooltipWrapperClasses)
        data-ui-component="tooltip"
        data-ui-tooltip
        data-ui-tooltip-kind="default"
        data-ui-tooltip-placement="{{ $resolvedTooltipPlacement }}"
        data-ui-tooltip-resolved-placement="{{ $resolvedTooltipRuntimePlacement }}"
        data-ui-tooltip-align="{{ $resolvedTooltipAlign }}"
        data-ui-tooltip-size="{{ $resolvedTooltipSize }}"
        data-ui-tooltip-state="closed"
    >
        <span class="ui-tooltip-trigger ui-tooltip-trigger__wrapper" data-ui-tooltip-trigger>
@endif

@if ($isLink)
    {{-- ----------------------------------------------------------------------
        Anchor rendering
        ----------------------------------------------------------------------
        Used only when href is present and the control is interactive.
        Disabled/loading href icon buttons render through the button branch.
        ---------------------------------------------------------------------- --}}

    <a
        href="{{ $href }}"
        role="button"
        aria-label="{{ $accessibleLabel }}"
        @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
        @if ($resolvedKind === 'ghost' && $resolvedSelected) aria-pressed="true" @endif
        @if (! $hasTooltip && filled($tooltipText)) title="{{ $tooltipText }}" @endif
        {{ $componentAttributes->class($classes)->merge($controlDataAttributes) }}
    >
        @if ($isLoading)
            <span class="ui-spinner" aria-hidden="true"></span>
        @elseif (filled($icon))
            <x-ui.icon
                :name="$icon"
                class="ui-btn__icon ui-icon-button__icon"
                aria-hidden="true"
            />
        @else
            {{ $slot }}
        @endif

        @if (! $isDisabled && $hasBadge)
            <span
                @if (filled($badgeId)) id="{{ $badgeId }}" @endif
                class="ui-badge-indicator"
                @if ($hasDescriptiveBadge) data-ui-count="{{ $badgeCount }}" @endif
            >
                @if ($hasDescriptiveBadge)
                    {{ $badgeCount }}
                @endif
            </span>
        @endif
    </a>
@else
    {{-- ----------------------------------------------------------------------
        Native button rendering
        ----------------------------------------------------------------------
        Default rendering branch. Also used when href is present but disabled
        or loading, because anchors do not support the disabled attribute.
        ---------------------------------------------------------------------- --}}

    <button
        type="{{ $resolvedType }}"
        aria-label="{{ $accessibleLabel }}"
        @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
        @if ($resolvedKind === 'ghost' && $resolvedSelected) aria-pressed="true" @endif
        @if (! $hasTooltip && filled($tooltipText)) title="{{ $tooltipText }}" @endif
        @if ($isLoading) aria-busy="true" @endif
        @disabled($isDisabled)
        {{ $componentAttributes->class($classes)->merge($controlDataAttributes) }}
    >
        @if ($isLoading)
            <span class="ui-spinner" aria-hidden="true"></span>
        @elseif (filled($icon))
            <x-ui.icon
                :name="$icon"
                class="ui-btn__icon ui-icon-button__icon"
                aria-hidden="true"
            />
        @else
            {{ $slot }}
        @endif

        @if (! $isDisabled && $hasBadge)
            <span
                @if (filled($badgeId)) id="{{ $badgeId }}" @endif
                class="ui-badge-indicator"
                @if ($hasDescriptiveBadge) data-ui-count="{{ $badgeCount }}" @endif
            >
                @if ($hasDescriptiveBadge)
                    {{ $badgeCount }}
                @endif
            </span>
        @endif
    </button>
@endif

@if ($hasTooltip)
        </span>

        {{-- ------------------------------------------------------------------
            Tooltip content
            ------------------------------------------------------------------
            The content is hidden by default and activated by tooltip JS.
            ------------------------------------------------------------------ --}}

        <span
            id="{{ $tooltipId }}"
            role="tooltip"
            class="ui-tooltip-content"
            aria-hidden="true"
            data-ui-tooltip-content
            data-ui-tooltip-id="{{ $tooltipId }}"
            data-ui-tooltip-state="closed"
            hidden
        >
            {{ $tooltipText }}
            <span class="ui-tooltip-caret" aria-hidden="true" data-ui-tooltip-caret></span>
        </span>
    </span>
@endif