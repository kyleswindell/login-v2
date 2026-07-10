{{-- ==========================================================================
File: resources/views/components/ui/button/index.blade.php
Purpose: Standard Button component.

Notes:
- Emits the canonical .ui-btn selector contract.
- Supports button and anchor rendering from one component API.
- Keeps legacy semantic / variant inputs as compatibility aliases.
- Standard Button anatomy renders a trailing icon only.
- Icon-only buttons should use resources/views/components/ui/icon-button/index.blade.php.
- Button visual styles are handled by resources/css/components/button.css.
- Button token values are handled by resources/css/tokens/components/buttons.css.
========================================================================== --}}

@props ([
    "href" => null,
    "type" => "button",
    "kind" => null,
    "semantic" => "primary",
    "variant" => null,
    "size" => "lg",
    "expressive" => false,
    "loading" => false,
    "disabled" => false,
    "icon" => null,
    "iconPosition" => "trailing",
    "dangerDescription" => null,
])

@php
    use Illuminate\Support\Str;

    /*
     *--------------------------------------------------------------------------
     * Supported public values
     *--------------------------------------------------------------------------
     *
     * `kind` is the canonical Button API.
     * `semantic` is retained as a compatibility input for older app usage.
     *
     */

    $allowedKinds = [
        "primary",
        "secondary",
        "tertiary",
        "ghost",
        "danger",
        "danger--primary",
        "danger--tertiary",
        "danger--ghost",
    ];

    $allowedSizes = ["xs", "sm", "md", "lg", "xl", "2xl"];
    $allowedTypes = ["button", "submit", "reset"];

    /*
     *--------------------------------------------------------------------------
     * Compatibility aliases
     *--------------------------------------------------------------------------
     *
     * Dashed danger aliases are accepted and normalized to the canonical
     * double-modifier form used by the installed .ui-btn CSS contract.
     *
     */

    $kindAliases = [
        "danger-primary" => "danger--primary",
        "danger-tertiary" => "danger--tertiary",
        "danger-ghost" => "danger--ghost",

        // Legacy semantic aliases
        "neutral" => "tertiary",
        "warning" => "tertiary",
        "notice" => "tertiary",
        "info" => "tertiary",
        "success" => "primary",
    ];

    /*
     *--------------------------------------------------------------------------
     * Resolve kind, size, type, and expressive mode
     *--------------------------------------------------------------------------
     */

    $requestedKind = $kind ?? $semantic;
    $resolvedKind = $kindAliases[$requestedKind] ?? $requestedKind;
    $resolvedKind = in_array($resolvedKind, $allowedKinds, true)
        ? $resolvedKind
        : "primary";

    $resolvedSize = in_array($size, $allowedSizes, true) ? $size : "lg";
    $resolvedType = in_array($type, $allowedTypes, true) ? $type : "button";
    $resolvedExpressive = (bool) $expressive;

    /*
     *--------------------------------------------------------------------------
     * Legacy expressive size support
     *--------------------------------------------------------------------------
     *
     * `lg-expressive` is not emitted as a size class. It resolves to the large
     * layout size plus the expressive modifier.
     *
     */

    if ($size === "lg-expressive") {
        $resolvedSize = "lg";
        $resolvedExpressive = true;
    }

    /*
     *--------------------------------------------------------------------------
     * Legacy variant mapping
     *--------------------------------------------------------------------------
     *
     * `outline` and `soft` resolve to tertiary button styling.
     * `ghost` resolves to ghost styling while preserving danger intent.
     *
     */

    if (($variant === "outline" || $variant === "soft")) {
        $resolvedKind = str_starts_with($resolvedKind, "danger")
            ? "danger--tertiary"
            : "tertiary";
    } elseif ($variant === "ghost") {
        $resolvedKind = str_starts_with($resolvedKind, "danger")
            ? "danger--ghost"
            : "ghost";
    }

    /*
     *--------------------------------------------------------------------------
     * Render state
     *--------------------------------------------------------------------------
     *
     * Loading is treated as disabled for interaction purposes.
     * If href is present but the control is disabled/loading, render a button
     * instead of an anchor so disabled semantics remain valid.
     *
     */

    $isDisabled = (bool) $disabled || (bool) $loading;
    $isLink = filled($href) && !$isDisabled;

    /*
     *--------------------------------------------------------------------------
     * Icon handling
     *--------------------------------------------------------------------------
     * Standard Button renders a trailing icon. Leading icons are intentionally
     * not emitted here to preserve the installed Button anatomy.
     */

    $renderIcon = filled($icon) && $iconPosition === "trailing";

    /*
     *--------------------------------------------------------------------------
     * Danger assistive description
     *--------------------------------------------------------------------------
     *
     * Danger buttons may include additional hidden assistive text. The generated
     * ID is merged with any aria-describedby value already passed by the caller.
     *
     */

    $isDangerVariant = in_array(
        $resolvedKind,
        ["danger", "danger--primary", "danger--tertiary", "danger--ghost"],
        true,
    );

    $dangerDescriptionId =
        $isDangerVariant && filled($dangerDescription)
            ? "ui-btn-danger-description-" . Str::uuid()
            : null;

    $existingDescribedBy = $attributes->get("aria-describedby");

    $ariaDescribedBy = collect([$existingDescribedBy, $dangerDescriptionId])
        ->filter()
        ->implode(" ");

    /*
     *--------------------------------------------------------------------------
     * CSS class contract
     *--------------------------------------------------------------------------
     *
     * These classes must match resources/css/components/button.css.
     *
     */

    $classes = [
        "ui-btn",
        "ui-btn--" . $resolvedKind,
        "ui-btn--" . $resolvedSize,
        "ui-layout--size-" . $resolvedSize,
    ];

    if ($resolvedExpressive) {
        $classes[] = "ui-btn--expressive";
    }

    if ($loading) {
        $classes[] = "ui-btn--loading";
    }

    if ($isDisabled) {
        $classes[] = "ui-btn--disabled";
    }

    /*
     *--------------------------------------------------------------------------
     * Loading spinner contrast
     *--------------------------------------------------------------------------
     *
     * Filled button kinds use the inverse spinner treatment.
     *
     */

    $showInverseSpinner =
        $loading &&
        in_array(
            $resolvedKind,
            ["primary", "secondary", "danger", "danger--primary"],
            true,
        );

    /*
     *--------------------------------------------------------------------------
     * Attribute handling
     *--------------------------------------------------------------------------
     *
     * aria-describedby is rebuilt so the caller-provided value and generated
     * danger description ID can both be preserved.
     *
     */

    $componentAttributes = $attributes->except("aria-describedby");
@endphp

@if ($isLink)
    {{-- ----------------------------------------------------------------------
    Anchor rendering
    ----------------------------------------------------------------------
    Used only when href is present and the control is interactive.
    Disabled/loading href buttons render through the button branch.
    ---------------------------------------------------------------------- --}}

    <a
        href="{{ $href }}"
        @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
        {{
            $componentAttributes
                ->class($classes)
                ->merge(["data-ui-component" => "button"])
        }}
    >
        {{--         
            Hidden danger description is included inside the control so the aria-describedby target is adjacent to the described element.
        --}}

        @if (filled($dangerDescriptionId))
            <span id="{{ $dangerDescriptionId }}" class="ui-visually-hidden">
                {{ $dangerDescription }}
            </span>
        @endif

        {{-- 
            Loading indicator is decorative; aria-busy is only emitted for the native button branch where loading disables interaction. 
        --}}
        @if ($loading)
            <span
                @class ([ "ui-spinner", "ui-spinner-inverse" => $showInverseSpinner ])
                aria-hidden="true"
            ></span>
        @endif

        <span class="ui-btn__label">{{ $slot }}</span>

        @if ($renderIcon)
            <x-ui.icon :name="$icon" class="ui-btn__icon" aria-hidden="true" />
        @endif
    </a>
@else
    {{-- 
        ----------------------------------------------------------------------
        Native button rendering
        ----------------------------------------------------------------------
        Default rendering branch. Also used when href is present but disabled
        or loading, because anchors do not support the disabled attribute.
        ---------------------------------------------------------------------- 
    --}}

    <button
        type="{{ $resolvedType }}"
        @disabled ($isDisabled)
        @if ($loading) aria-busy="true" @endif
        @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
        {{
            $componentAttributes
                ->class($classes)
                ->merge(["data-ui-component" => "button"])
        }}
    >
        {{-- Hidden danger description is available to assistive technology
through aria-describedby. --}}
        @if (filled($dangerDescriptionId))
            <span id="{{ $dangerDescriptionId }}" class="ui-visually-hidden">
                {{ $dangerDescription }}
            </span>
        @endif

        {{-- Spinner is decorative because the button already exposes busy and
disabled state. --}}
        @if ($loading)
            <span
                @class ([ "ui-spinner", "ui-spinner-inverse" => $showInverseSpinner ])
                aria-hidden="true"
            ></span>
        @endif

        <span class="ui-btn__label">{{ $slot }}</span>

        @if ($renderIcon)
            <x-ui.icon :name="$icon" class="ui-btn__icon" aria-hidden="true" />
        @endif
    </button>
@endif
