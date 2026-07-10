{{-- ==========================================================================
    File: resources/views/components/ui/dialog/footer.blade.php
    Purpose: UI dialog footer.

    Source: Converted from the Carbon DialogFooter React component.

    Notes:
    - Renders the footer using the app-owned Button Set selector contract.
    - Acts as a form-action-state compatible action root so submit buttons can
      be replaced with Inline Loading-compatible DOM during native form submit.
    - Avoids forwarding raw attribute bags inside child component opening tags.
    - Buttons should be passed through the slot so the app-owned button
      component remains the source of button markup.
    - Generated primary/secondary action APIs are intentionally not implemented
      here; higher-level Modal or Pattern APIs own generated action behavior.
    - Accepts extraAttributes for safe component-to-component attribute
      forwarding.
    ========================================================================== --}}

@props ([
    "threeButton" => false,
    "busy" => false,
    "stacked" => false,
    "fluid" => false,
    "autoStack" => true,
    "width" => null,
    "align" => null,
    "order" => "carbon",
    "state" => null,
    "loadingText" => null,
    "successText" => null,
    "errorText" => null,
    "statusAriaLive" => null,
    "disableDuringBusy" => true,
    "extraAttributes" => null,
])

@php
    use Illuminate\View\ComponentAttributeBag;

    /*
     *--------------------------------------------------------------------------
     * Attribute bag state
     *--------------------------------------------------------------------------
     */

    $extraAttributes = $extraAttributes instanceof ComponentAttributeBag
        ? $extraAttributes
        : new ComponentAttributeBag();

    /*
     *--------------------------------------------------------------------------
     * Render state
     *--------------------------------------------------------------------------
     */

    $hasThreeButtons = filter_var($threeButton, FILTER_VALIDATE_BOOLEAN);
    $isBusy = filter_var($busy, FILTER_VALIDATE_BOOLEAN);
    $isFluid = filter_var($fluid, FILTER_VALIDATE_BOOLEAN);
    $isStacked = ! $isFluid && filter_var($stacked, FILTER_VALIDATE_BOOLEAN);
    $usesAutoStack = $isFluid && filter_var($autoStack, FILTER_VALIDATE_BOOLEAN);
    $disablesDuringBusy = filter_var($disableDuringBusy, FILTER_VALIDATE_BOOLEAN);

    /*
     *--------------------------------------------------------------------------
     * Action state
     *--------------------------------------------------------------------------
     */

    $stateAliases = [
        "active" => "loading",
        "busy" => "loading",
        "finished" => "success",
        "complete" => "success",
        "completed" => "success",
        "failed" => "error",
        "failure" => "error",
    ];

    $allowedStates = [
        "idle",
        "loading",
        "success",
        "error",
    ];

    $requestedState = is_string($state)
        ? ($stateAliases[$state] ?? $state)
        : null;

    $resolvedState = in_array($requestedState, $allowedStates, true)
        ? $requestedState
        : ($isBusy ? "loading" : "idle");

    $hasStatus = $resolvedState !== "idle";

    /*
     *--------------------------------------------------------------------------
     * Width, alignment, and ordering
     *--------------------------------------------------------------------------
     */

    $allowedWidths = ["half", "full"];
    $allowedAlignments = ["start", "end", "stretch"];
    $allowedOrders = ["carbon", "source"];

    $resolvedWidth = $isFluid && is_string($width) && in_array($width, $allowedWidths, true)
        ? $width
        : null;

    $resolvedAlign = is_string($align) && in_array($align, $allowedAlignments, true)
        ? $align
        : null;

    $resolvedOrder = is_string($order) && in_array($order, $allowedOrders, true)
        ? $order
        : "carbon";

    if ($isFluid && $resolvedWidth === "half" && $resolvedAlign === null) {
        $resolvedAlign = "end";
    }

    /*
     *--------------------------------------------------------------------------
     * CSS class contract
     *--------------------------------------------------------------------------
     */

    $classes = [
        "ui-btn-set",
        "ui-dialog-footer",
        "ui-dialog-footer--three-button" => $hasThreeButtons,
        "ui-btn-set--stacked" => $isStacked,
        "ui-btn-set--fluid" => $isFluid,
        "ui-btn-set--width-".$resolvedWidth => filled($resolvedWidth),
        "ui-btn-set--align-".$resolvedAlign => filled($resolvedAlign),
        "ui-btn-set--order-".$resolvedOrder,
        "ui-form-actions--state-".$resolvedState,
        "ui-form-actions--busy" => $resolvedState === "loading",
        "ui-form-actions--has-status" => $hasStatus,
    ];

    $fluidInnerClasses = [
        "ui-btn-set__fluid-inner",
        "ui-btn-set__fluid-inner--auto-stack" => $usesAutoStack,
    ];

    /*
     *--------------------------------------------------------------------------
     * Attribute handling
     *--------------------------------------------------------------------------
     */

    $mergedAttributes = (new ComponentAttributeBag(
        array_merge(
            $extraAttributes->getAttributes(),
            $attributes->getAttributes()
        )
    ))
        ->class($classes)
        ->merge([
            "aria-busy" => $resolvedState === "loading" ? "true" : null,

            "data-ui-component" => "dialog-footer",
            "data-ui-dialog-footer" => "true",
            "data-ui-dialog-footer-three-button" => $hasThreeButtons ? "true" : "false",
            "data-ui-dialog-footer-busy" => $resolvedState === "loading" ? "true" : "false",

            "data-ui-form-actions" => "true",
            "data-ui-form-actions-placement" => "dialog-footer",
            "data-ui-form-actions-orientation" => $isStacked ? "vertical" : "horizontal",
            "data-ui-form-actions-alignment" => $resolvedAlign ?? "auto",
            "data-ui-form-actions-state" => $resolvedState,
            "data-ui-form-actions-busy" => $resolvedState === "loading" ? "true" : "false",
            "data-ui-form-actions-has-status" => $hasStatus ? "true" : "false",
            "data-ui-form-actions-loading-text" => $loadingText,
            "data-ui-form-actions-success-text" => $successText,
            "data-ui-form-actions-error-text" => $errorText,
            "data-ui-form-actions-status-aria-live" => $statusAriaLive,
            "data-ui-form-actions-disable-during-busy" => $disablesDuringBusy ? "true" : "false",

            "data-ui-button-set" => "true",
            "data-ui-button-set-fluid" => $isFluid ? "true" : "false",
            "data-ui-button-set-stacked" => $isStacked ? "true" : "false",
            "data-ui-button-set-auto-stack" => $usesAutoStack ? "true" : "false",
            "data-ui-button-set-width" => $resolvedWidth ?? "auto",
            "data-ui-button-set-align" => $resolvedAlign ?? "auto",
            "data-ui-button-set-order" => $resolvedOrder,
        ]);
@endphp

<div {{ $mergedAttributes }}>
    @if ($isFluid)
        <div @class ($fluidInnerClasses) data-ui-button-set-fluid-inner>
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif
</div>
