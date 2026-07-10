{{-- ==========================================================================
    File: resources/views/components/ui/tooltip/index.blade.php
    Purpose: Tooltip disclosure component.

    Notes:
    - Emits the installed .ui-tooltip selector contract.
    - Supports default and definition tooltip kinds.
    - Supports placement, alignment, auto size resolution, default/open state,
      close-on-activation hooks, drop-shadow and high-contrast flags, and
      enter/leave delay hooks for installed tooltip JavaScript.
    - Supports label and description content. Label uses labelled-by semantics;
      description uses described-by semantics.
    - Tooltip content is non-interactive. Use Toggletip or Popover for
      interactive contextual content.
    - Tooltip behavior should be handled by installed tooltip JavaScript.
    - Tooltip styles are handled by resources/css/components/tooltip.css.
    ========================================================================== --}}

@props([
    'text' => null,
    'label' => null,
    'description' => null,
    'placement' => 'auto',
    'align' => 'center',
    'size' => 'auto',
    'kind' => 'default',
    'id' => null,
    'open' => false,
    'defaultOpen' => false,
    'closeOnActivation' => false,
    'dropShadow' => false,
    'highContrast' => true,
    'enterDelayMs' => 100,
    'leaveDelayMs' => 300,
])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedPlacements = [
        'auto',
        'top',
        'right',
        'bottom',
        'left',
    ];

    $allowedAlignments = [
        'start',
        'center',
        'end',
    ];

    $allowedSizes = [
        'auto',
        'single',
        'multi',
        'definition',
    ];

    $allowedKinds = [
        'default',
        'definition',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedPlacement = in_array($placement, $allowedPlacements, true)
        ? $placement
        : 'auto';

    $resolvedAlign = in_array($align, $allowedAlignments, true)
        ? $align
        : 'center';

    $resolvedKind = in_array($kind, $allowedKinds, true)
        ? $kind
        : 'default';

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : 'auto';

    $tooltipId = $id ?? 'ui-tooltip-'.Str::uuid();
    $isOpen = filter_var($open, FILTER_VALIDATE_BOOLEAN)
        || filter_var($defaultOpen, FILTER_VALIDATE_BOOLEAN);

    $resolvedEnterDelayMs = is_numeric($enterDelayMs) ? max(0, (int) $enterDelayMs) : 100;
    $resolvedLeaveDelayMs = is_numeric($leaveDelayMs) ? max(0, (int) $leaveDelayMs) : 300;

    /*
    |--------------------------------------------------------------------------
    | Content Resolution
    |--------------------------------------------------------------------------
    |
    | Label takes precedence over description. Text is retained as a legacy
    | description-style alias.
    |
    */

    $tooltipContent = $label ?? $description ?? $text;
    $contentPlainText = trim(strip_tags((string) $tooltipContent));
    $hasLabelRelationship = filled($label);

    /*
    |--------------------------------------------------------------------------
    | Size Resolution
    |--------------------------------------------------------------------------
    |
    | Auto size resolves to single-line or multi-line based on content length.
    | Definition kind always resolves to definition sizing.
    |
    */

    if ($resolvedSize === 'auto') {
        $resolvedSize = $resolvedKind === 'definition' || mb_strlen($contentPlainText) > 48
            ? 'multi'
            : 'single';
    }

    if ($resolvedKind === 'definition') {
        $resolvedSize = 'definition';
    }

    /*
    |--------------------------------------------------------------------------
    | Placement Resolution
    |--------------------------------------------------------------------------
    |
    | The JavaScript layer may update resolved placement at runtime. Static
    | rendering resolves auto to top as the safe default.
    |
    */

    $resolvedRuntimePlacement = $resolvedPlacement === 'auto'
        ? 'top'
        : $resolvedPlacement;

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    |
    | These classes must match resources/css/components/tooltip.css.
    |
    */

    $classes = [
        'ui-tooltip',
        'ui-tooltip--drop-shadow' => (bool) $dropShadow,
        'ui-tooltip--high-contrast' => (bool) $highContrast,
    ];
@endphp

<span
    {{ $attributes->class($classes) }}
    data-ui-component="tooltip"
    data-ui-tooltip
    data-ui-tooltip-kind="{{ $resolvedKind }}"
    data-ui-tooltip-placement="{{ $resolvedPlacement }}"
    data-ui-tooltip-resolved-placement="{{ $resolvedRuntimePlacement }}"
    data-ui-tooltip-align="{{ $resolvedAlign }}"
    data-ui-tooltip-size="{{ $resolvedSize }}"
    data-ui-tooltip-state="{{ $isOpen ? 'open' : 'closed' }}"
    data-ui-tooltip-relationship="{{ $hasLabelRelationship ? 'label' : 'description' }}"
    data-ui-tooltip-close-on-activation="{{ (bool) $closeOnActivation ? 'true' : 'false' }}"
    data-ui-tooltip-drop-shadow="{{ (bool) $dropShadow ? 'true' : 'false' }}"
    data-ui-tooltip-high-contrast="{{ (bool) $highContrast ? 'true' : 'false' }}"
    data-ui-tooltip-enter-delay-ms="{{ $resolvedEnterDelayMs }}"
    data-ui-tooltip-leave-delay-ms="{{ $resolvedLeaveDelayMs }}"
>
    {{-- ----------------------------------------------------------------------
        Trigger
        ----------------------------------------------------------------------
        The trigger slot owns the visible trigger content. JavaScript may use
        this marker to bind hover, focus, escape, activation, drag, and
        placement behavior.
        ---------------------------------------------------------------------- --}}

    <span
        class="ui-tooltip-trigger ui-tooltip-trigger__wrapper"
        data-ui-tooltip-trigger
        @if ($hasLabelRelationship) aria-labelledby="{{ $tooltipId }}" @else aria-describedby="{{ $tooltipId }}" @endif
    >
        {{ $slot }}
    </span>

    {{-- ----------------------------------------------------------------------
        Tooltip content
        ----------------------------------------------------------------------
        Tooltip content is non-interactive. Use Toggletip or Popover when the
        disclosed content contains links, buttons, form controls, or rich help.
        ---------------------------------------------------------------------- --}}

    <span
        id="{{ $tooltipId }}"
        role="tooltip"
        class="ui-tooltip-content"
        aria-hidden="{{ $isOpen ? 'false' : 'true' }}"
        data-ui-tooltip-content
        data-ui-tooltip-id="{{ $tooltipId }}"
        data-ui-tooltip-state="{{ $isOpen ? 'open' : 'closed' }}"
        @if (! $isOpen) hidden @endif
    >
        @if ($tooltipContent instanceof HtmlString)
            {!! $tooltipContent !!}
        @else
            {{ $tooltipContent }}
        @endif

        <span
            class="ui-tooltip-caret"
            aria-hidden="true"
            data-ui-tooltip-caret
        ></span>
    </span>
</span>