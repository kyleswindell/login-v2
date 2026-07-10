{{-- ==========================================================================
    File: resources/views/components/ui/loading/index.blade.php
    Purpose: Loading indicator component.

    Carbon references:
    - reference/carbon-main/packages/react/src/components/Loading/Loading.tsx
    - reference/carbon-main/packages/styles/scss/components/loading/_loading.scss

    Notes:
    - Implements Carbon's SVG-based loading indicator structure.
    - Supports Carbon-equivalent active, size, description, and overlay states.
    - Inactive indicators remain rendered and receive the Carbon stop state.
    - The SVG owns the accessible loading description.
    - Dynamic state changes are handled by resources/js/components/loading.js.
    ========================================================================== --}}

@props ([
    "active" => true,
    "size" => "lg",
    "description" => "Loading",
    "withOverlay" => true,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Resolve Public Values
    |--------------------------------------------------------------------------
    */

    $resolvedActive = filter_var($active, FILTER_VALIDATE_BOOL);
    $resolvedWithOverlay = filter_var($withOverlay, FILTER_VALIDATE_BOOL);
    $resolvedSize = $size === 'sm' ? 'sm' : 'lg';
    $resolvedDescription = trim((string) $description);

    if ($resolvedDescription === '') {
        $resolvedDescription = 'Loading';
    }

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $loadingClasses = [
        'ui-loading',
        'ui-loading--small' => $resolvedSize === 'sm',
        'ui-loading--stop' => ! $resolvedActive,
    ];

    $overlayClasses = [
        'ui-loading-overlay',
        'ui-loading-overlay--stop' => ! $resolvedActive,
    ];

    /*
    |--------------------------------------------------------------------------
    | Forwarded Attributes
    |--------------------------------------------------------------------------
    |
    | Carbon's accessibility attributes are owned by this component. Remaining
    | attributes are forwarded to the loading indicator.
    |
    */

    $componentAttributes = $attributes->except([
        'aria-atomic',
        'aria-live',
        'aria-label',
        'role',
    ]);
@endphp

@if ($resolvedWithOverlay)
    <div
        @class ($overlayClasses)
        data-ui-loading-overlay
        data-ui-loading-active="{{ $resolvedActive ? 'true' : 'false' }}"
    >
@endif

<div
    {{
        $componentAttributes->class(
            $loadingClasses,
        )
    }}
    aria-atomic="true"
    aria-live="{{ $resolvedActive ? 'assertive' : 'off' }}"
    data-ui-component="loading"
    data-ui-loading
    data-ui-loading-active="{{ $resolvedActive ? 'true' : 'false' }}"
    data-ui-loading-size="{{ $resolvedSize }}"
>
    {{-- ----------------------------------------------------------------------
        SVG indicator
        ----------------------------------------------------------------------
        Carbon exposes the loading description through the SVG rather than
        assigning status semantics directly to the containing element.
        ---------------------------------------------------------------------- --}}

    <svg
        class="ui-loading__svg"
        viewBox="0 0 100 100"
        role="img"
        aria-label="{{ $resolvedDescription }}"
    >
        <title>{{ $resolvedDescription }}</title>

        @if ($resolvedSize === "sm")
            <circle class="ui-loading__background" cx="50%" cy="50%" r="42" />
        @endif

        <circle
            class="ui-loading__stroke"
            cx="50%"
            cy="50%"
            r="{{ $resolvedSize === 'sm' ? '42' : '44' }}"
        />
    </svg>
</div>

@if ($resolvedWithOverlay)
    </div>
@endif
