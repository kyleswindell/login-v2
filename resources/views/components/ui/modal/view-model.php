<?php

declare(strict_types=1);

use Illuminate\View\ComponentAttributeBag;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/modal/view-model.php
| Purpose: Modal component render view-model.
|--------------------------------------------------------------------------
|
| This file normalizes x-ui.modal props into render-ready values.
| The Blade file should remain focused on component composition and markup.
|
*/

return static function (
    array $props,
    ComponentAttributeBag $attributes,
    array $options,
): array {
    /*
    |--------------------------------------------------------------------------
    | Local Helpers
    |--------------------------------------------------------------------------
    */

    $bool = static fn(mixed $value): bool => filter_var(
        $value,
        FILTER_VALIDATE_BOOLEAN,
    );

    $option = static function (
        array $values,
        mixed $requested,
        mixed $fallback,
    ): mixed {
        return in_array($requested, $values, true) ? $requested : $fallback;
    };

    $attributeBag = static fn(
        array $values = [],
    ): ComponentAttributeBag => new ComponentAttributeBag(
        collect($values)
            ->filter(
                fn(mixed $value): bool => !is_null($value) && $value !== "",
            )
            ->all(),
    );

    /*
    |--------------------------------------------------------------------------
    | Resolve IDs
    |--------------------------------------------------------------------------
    */

    $resolvedId =
        $props["id"] ?? $options["defaults"]["id_prefix"] . str()->uuid();

    $resolvedTitle = $props["modalHeading"] ?? $props["title"];
    $resolvedLabel =
        $props["modalLabel"] ?? ($props["label"] ?? $props["kicker"]);

    $resolvedTitleId =
        $props["titleId"] ?? ($resolvedTitle ? "{$resolvedId}-heading" : null);

    $resolvedLabelId = $resolvedLabel ? "{$resolvedId}-label" : null;

    $resolvedBodyId = "{$resolvedId}-body";

    /*
    |--------------------------------------------------------------------------
    | Resolve Variants / Booleans
    |--------------------------------------------------------------------------
    */

    $resolvedSize = $option(
        $options["sizes"],
        $props["size"],
        $options["defaults"]["size"],
    );

    $resolvedVariant = $option(
        $options["variants"],
        $props["variant"],
        $options["defaults"]["variant"],
    );

    $resolvedPassive = !is_null($props["passiveModal"])
        ? $bool($props["passiveModal"])
        : $resolvedVariant === "passive";

    if (!is_null($props["preventCloseOnClickOutside"])) {
        $resolvedCloseOnBackdrop = !$bool($props["preventCloseOnClickOutside"]);
    } elseif (!is_null($props["closeOnBackdrop"])) {
        $resolvedCloseOnBackdrop = $bool($props["closeOnBackdrop"]);
    } else {
        $resolvedCloseOnBackdrop = $resolvedPassive;
    }

    $resolvedOpen = $bool($props["open"]);
    $resolvedDanger = $bool($props["danger"]);
    $resolvedAlert = $bool($props["alert"]);
    $resolvedScrolling = $bool($props["hasScrollingContent"]);
    $resolvedFullWidth = $bool($props["isFullWidth"]);
    $resolvedSubmitOnEnter = $bool($props["shouldSubmitOnEnter"]);
    $resolvedCloseAfterSubmit = $bool($props["shouldCloseAfterSubmit"]);

    $resolvedPrimaryLoading = $bool($props["primaryButtonLoading"]);
    $resolvedPrimaryDisabled =
        $bool($props["primaryButtonDisabled"]) || $resolvedPrimaryLoading;
    $resolvedSecondaryDisabled = $bool($props["secondaryButtonDisabled"]);

    /*
    |--------------------------------------------------------------------------
    | Resolve ARIA
    |--------------------------------------------------------------------------
    */

    $resolvedRole = $resolvedAlert ? "alertdialog" : "dialog";

    $resolvedAriaLabel =
        $props["modalAriaLabel"] ??
        (!$resolvedTitle && !$resolvedLabel
            ? $options["defaults"]["title_fallback"]
            : null);

    $ariaLabelledBy = $resolvedTitleId ?: $resolvedLabelId;

    $resolvedDescribedBy =
        $props["description"] || ($resolvedAlert && !$resolvedPassive)
            ? $resolvedBodyId
            : null;

    /*
    |--------------------------------------------------------------------------
    | Resolve Footer Actions
    |--------------------------------------------------------------------------
    */

    $resolvedPrimaryKind = filled($props["primaryButtonKind"])
        ? $props["primaryButtonKind"]
        : ($resolvedDanger
            ? $options["defaults"]["danger_primary_kind"]
            : $options["defaults"]["primary_kind"]);

    $resolvedPrimaryKind = $option(
        $options["button_kinds"],
        $resolvedPrimaryKind,
        $resolvedDanger
            ? $options["defaults"]["danger_primary_kind"]
            : $options["defaults"]["primary_kind"],
    );

    $resolvedPrimaryType = filled($props["primaryButtonType"])
        ? $props["primaryButtonType"]
        : (filled($props["primaryButtonForm"])
            ? "submit"
            : "button");

    $resolvedPrimaryType = $option(
        $options["button_types"],
        $resolvedPrimaryType,
        "button",
    );

    $resolvedSecondaryKind = $option(
        $options["button_kinds"],
        $props["secondaryButtonKind"],
        $options["defaults"]["secondary_kind"],
    );

    $resolvedSecondaryType = $option(
        $options["button_types"],
        $props["secondaryButtonType"],
        "button",
    );

    $secondaryButtonRows = is_iterable($props["secondaryButtons"])
        ? collect($props["secondaryButtons"])->take(2)->values()
        : collect();

    if (
        $secondaryButtonRows->isEmpty() &&
        filled($props["secondaryButtonText"])
    ) {
        $secondaryButtonRows = collect([
            [
                "label" => $props["secondaryButtonText"],
                "kind" => $resolvedSecondaryKind,
                "type" => $resolvedSecondaryType,
                "href" => $props["secondaryButtonHref"],
                "form" => $props["secondaryButtonForm"],
                "name" => $props["secondaryButtonName"],
                "value" => $props["secondaryButtonValue"],
                "disabled" => $resolvedSecondaryDisabled,
                "close" => true,
            ],
        ]);
    }

    $resolvedSecondaryButtons = $secondaryButtonRows
        ->map(function (mixed $button, int $index) use (
            $bool,
            $option,
            $options,
            $resolvedDanger,
            $resolvedSecondaryDisabled,
            $resolvedSecondaryKind,
        ): ?array {
            $buttonData = is_array($button) ? $button : ["label" => $button];

            $isVisible =
                !array_key_exists("visible", $buttonData) ||
                $bool(data_get($buttonData, "visible", true));

            if (!$isVisible) {
                return null;
            }

            return [
                "index" => $index,
                "label" => data_get(
                    $buttonData,
                    "label",
                    data_get(
                        $buttonData,
                        "buttonText",
                        data_get(
                            $buttonData,
                            "text",
                            $options["defaults"]["secondary_label"],
                        ),
                    ),
                ),
                "kind" => $option(
                    $options["button_kinds"],
                    data_get($buttonData, "kind", $resolvedSecondaryKind),
                    $resolvedSecondaryKind,
                ),
                "type" => $option(
                    $options["button_types"],
                    data_get($buttonData, "type", "button"),
                    "button",
                ),
                "href" => data_get(
                    $buttonData,
                    "href",
                    data_get($buttonData, "url"),
                ),
                "form" => data_get($buttonData, "form"),
                "name" => data_get($buttonData, "name"),
                "value" => data_get($buttonData, "value"),
                "disabled" => $bool(
                    data_get(
                        $buttonData,
                        "disabled",
                        $resolvedSecondaryDisabled,
                    ),
                ),
                "close" => $bool(data_get($buttonData, "close", true)),
                "primaryFocus" => $resolvedDanger && $index === 0,
            ];
        })
        ->filter()
        ->values();

    $hasGeneratedPrimary = filled($props["primaryButtonText"]);
    $hasGeneratedFooter =
        $resolvedSecondaryButtons->isNotEmpty() || $hasGeneratedPrimary;
    $hasThreeButtonFooter =
        $resolvedSecondaryButtons->count() === 2 && $hasGeneratedPrimary;
    $primaryShouldReceiveFocus = !$resolvedDanger;

    /*
    |--------------------------------------------------------------------------
    | Resolve CSS Classes
    |--------------------------------------------------------------------------
    */

    $classes = $options["classes"];

    $rootClasses = [
        $classes["root"],
        $classes["visible_legacy"] => $resolvedOpen,
        $classes["open_legacy"] => $resolvedOpen,
        $classes["open"] => $resolvedOpen,
        $classes["tall"] => !$resolvedPassive,
        $classes["danger"] => $resolvedDanger,
        $classes["passive"] => $resolvedPassive,
    ];

    $containerClasses = [
        $classes["container"],
        $classes["container_size_prefix"] . $resolvedSize,
        $classes["container_full_width"] => $resolvedFullWidth,
    ];

    $headerClasses = [$classes["header"]];

    $contentClasses = [
        $classes["content"],
        $classes["content_scroll"] => $resolvedScrolling,
    ];

    $footerClasses = [
        $classes["footer"],
        $classes["footer_three_button"] => $hasThreeButtonFooter,
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Attribute Bags
    |--------------------------------------------------------------------------
    */

    $rootAttributes = $attributes
        ->except(["id"])
        ->class($rootClasses)
        ->merge([
            "tabindex" => "-1",
            "aria-modal" => "true",
            "data-ui-component" => "modal",
            "data-ui-dialog-kind" => "modal",
            "data-ui-dialog-variant" => $resolvedPassive
                ? "passive"
                : "transactional",
            "data-ui-dialog-passive" => $resolvedPassive ? "true" : "false",
            "data-ui-dialog-danger" => $resolvedDanger ? "true" : "false",
            "data-ui-dialog-alert" => $resolvedAlert ? "true" : "false",
            "data-ui-dialog-size" => $resolvedSize,
            "data-ui-dialog-full-width" => $resolvedFullWidth
                ? "true"
                : "false",
            "data-ui-dialog-has-scrolling-content" => $resolvedScrolling
                ? "true"
                : "false",
            "data-ui-dialog-close-on-backdrop" => $resolvedCloseOnBackdrop
                ? "true"
                : "false",
            "data-ui-dialog-submit-on-enter" => $resolvedSubmitOnEnter
                ? "true"
                : "false",
            "data-ui-dialog-close-after-submit" => $resolvedCloseAfterSubmit
                ? "true"
                : "false",
            "data-ui-dialog-selector-primary-focus" =>
                $props["selectorPrimaryFocus"] ?:
                $options["defaults"]["primary_focus_selector"],
        ]);

    $containerAttributes = $attributeBag([
        "data-ui-dialog-panel" => "true",
        "data-ui-modal-container" => "true",
    ])->class($containerClasses);

    $headerAttributes = $attributeBag([
        "data-ui-dialog-modal-header" => "true",
    ])->class($headerClasses);

    $contentAttributes = $attributeBag([
        "id" => $resolvedBodyId,
    ])->class($contentClasses);

    $footerAttributes = $attributeBag()->class($footerClasses);

    /*
    |--------------------------------------------------------------------------
    | View Model
    |--------------------------------------------------------------------------
    */

    return [
        "resolvedId" => $resolvedId,
        "resolvedTitle" => $resolvedTitle,
        "resolvedLabel" => $resolvedLabel,
        "resolvedTitleId" => $resolvedTitleId,
        "resolvedLabelId" => $resolvedLabelId,
        "resolvedBodyId" => $resolvedBodyId,

        "resolvedOpen" => $resolvedOpen,
        "resolvedPassive" => $resolvedPassive,
        "resolvedDanger" => $resolvedDanger,
        "resolvedScrolling" => $resolvedScrolling,
        "resolvedPrimaryLoading" => $resolvedPrimaryLoading,
        "resolvedPrimaryDisabled" => $resolvedPrimaryDisabled,

        "resolvedRole" => $resolvedRole,
        "resolvedAriaLabel" => $resolvedAriaLabel,
        "ariaLabelledBy" => $ariaLabelledBy,
        "resolvedDescribedBy" => $resolvedDescribedBy,

        "resolvedPrimaryKind" => $resolvedPrimaryKind,
        "resolvedPrimaryType" => $resolvedPrimaryType,
        "resolvedSecondaryButtons" => $resolvedSecondaryButtons,
        "hasGeneratedPrimary" => $hasGeneratedPrimary,
        "hasGeneratedFooter" => $hasGeneratedFooter,
        "hasThreeButtonFooter" => $hasThreeButtonFooter,
        "primaryShouldReceiveFocus" => $primaryShouldReceiveFocus,

        "rootAttributes" => $rootAttributes,
        "containerAttributes" => $containerAttributes,
        "headerAttributes" => $headerAttributes,
        "contentAttributes" => $contentAttributes,
        "footerAttributes" => $footerAttributes,
        "modalClasses" => $classes,
    ];
};
