{{-- ==========================================================================
    File: resources/views/components/ui/inline-loading/index.blade.php
    Purpose: Inline Loading status component.

    Carbon references:
    - reference/carbon-main/packages/react/src/components/InlineLoading/InlineLoading.tsx
    - reference/carbon-main/packages/styles/scss/components/inline-loading/_inline-loading.scss

    Notes:
    - Implements Carbon InlineLoading statuses: inactive, active, finished,
      and error.
    - Supports loading and success as compatibility aliases for active and
      finished.
    - Composes the app-owned Loading component for the active state.
    - Keeps status elements mounted so JavaScript can update status without
      replacing component markup.
    - Dispatches delayed success behavior through the Inline Loading controller.
    - Parent components and Patterns own pending operations, disabled actions,
      retry behavior, and final workflow handoff.
    ========================================================================== --}}

@props ([
    "status" => "active",
    "description" => null,
    "label" => null,
    "iconDescription" => null,
    "ariaLive" => null,
    "live" => null,
    "successDelay" => 1500,
])

@php
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $statusAliases = [
        'loading' => 'active',
        'success' => 'finished',
    ];

    $allowedStatuses = [
        'inactive',
        'active',
        'finished',
        'error',
    ];

    $allowedLiveValues = [
        'off',
        'polite',
        'assertive',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Status
    |--------------------------------------------------------------------------
    */

    $requestedStatus = $statusAliases[$status] ?? $status;

    $resolvedStatus = in_array($requestedStatus, $allowedStatuses, true)
        ? $requestedStatus
        : 'active';

    /*
    |--------------------------------------------------------------------------
    | Resolve Accessibility
    |--------------------------------------------------------------------------
    */

    $resolvedAriaLive = $ariaLive
        ?? $live
        ?? ($resolvedStatus === 'inactive' ? 'off' : 'assertive');

    $resolvedAriaLive = in_array($resolvedAriaLive, $allowedLiveValues, true)
        ? $resolvedAriaLive
        : ($resolvedStatus === 'inactive' ? 'off' : 'assertive');

    $defaultIconDescriptions = [
        'active' => 'loading',
        'finished' => 'finished',
        'error' => 'error',
    ];

    $resolvedIconDescription = trim(
        (string) (
            $iconDescription
            ?? $defaultIconDescriptions[$resolvedStatus]
            ?? ''
        )
    );

    /*
    |--------------------------------------------------------------------------
    | Resolve Content
    |--------------------------------------------------------------------------
    */

    $resolvedDescription = $description ?? $label;
    $hasSlotContent = ! $slot->isEmpty();

    /*
    |--------------------------------------------------------------------------
    | Resolve Success Delay
    |--------------------------------------------------------------------------
    */

    $resolvedSuccessDelay = max(0, (int) $successDelay);

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    |
    | aria-live is owned by this component so its default follows the current
    | Inline Loading status.
    |
    */

    $componentAttributes = $attributes->except([
        'aria-live',
    ]);
@endphp

<div
    {{
        $componentAttributes->class(
            "ui-inline-loading",
        )
    }}
    aria-live="{{ $resolvedAriaLive }}"
    data-ui-component="inline-loading"
    data-ui-inline-loading
    data-ui-inline-loading-status="{{ $resolvedStatus }}"
    data-ui-inline-loading-success-delay="{{ $resolvedSuccessDelay }}"
>
    {{-- ----------------------------------------------------------------------
        Status animation
        ----------------------------------------------------------------------
        All status visuals remain mounted so the JavaScript controller can
        switch states without rebuilding the component.
        ---------------------------------------------------------------------- --}}

    <div
        class="ui-inline-loading__animation"
        data-ui-inline-loading-animation
        @if ($resolvedStatus === "inactive") hidden @endif
    >
        {{-- Active spinner --}}

        <span
            data-ui-inline-loading-indicator="active"
            @if ($resolvedStatus !== "active") hidden @endif
        >
            <x-ui.loading
                size="sm"
                :with-overlay="false"
                :description="$resolvedIconDescription !== '' ? $resolvedIconDescription : 'loading'"
            />
        </span>

        {{-- Finished icon --}}

        <span
            class="ui-inline-loading__status-icon ui-inline-loading__status-icon--finished"
            role="img"
            aria-label="{{ $resolvedIconDescription !== '' ? $resolvedIconDescription : 'finished' }}"
            data-ui-inline-loading-indicator="finished"
            @if ($resolvedStatus !== "finished") hidden @endif
        >
            <x-ui.icon
                name="checkmark--filled"
                class="ui-inline-loading__checkmark-container"
                aria-hidden="true"
            />
        </span>

        {{-- Error icon --}}

        <span
            class="ui-inline-loading__status-icon ui-inline-loading__status-icon--error"
            role="img"
            aria-label="{{ $resolvedIconDescription !== '' ? $resolvedIconDescription : 'error' }}"
            data-ui-inline-loading-indicator="error"
            @if ($resolvedStatus !== "error") hidden @endif
        >
            <x-ui.icon
                name="error--filled"
                class="ui-inline-loading__error"
                aria-hidden="true"
            />
        </span>
    </div>

    {{-- ----------------------------------------------------------------------
        Description
        ----------------------------------------------------------------------
        Description can be supplied through description, the compatibility
        label alias, or the default slot.
        ---------------------------------------------------------------------- --}}

    @if (filled($resolvedDescription) || $hasSlotContent)
        <div class="ui-inline-loading__text">
            @if (filled($resolvedDescription))
                @if ($resolvedDescription instanceof HtmlString)
                    {!! $resolvedDescription !!}
                @else
                    {{ $resolvedDescription }}
                @endif
            @else
                {{ $slot }}
            @endif
        </div>
    @endif
</div>
