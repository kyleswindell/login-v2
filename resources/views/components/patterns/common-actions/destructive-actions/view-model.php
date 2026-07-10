<?php

declare(strict_types=1);

use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/patterns/common-actions/destructive-actions/view-model.php
| Purpose: Destructive Actions pattern derived view state.
|--------------------------------------------------------------------------
|
| This file owns derived state for the Destructive Actions pattern:
| normalized options, IDs, ARIA values, typed-confirmation state, button-set
| layout values, action shaping, data attributes, and CSS class arrays.
|
| It does not render markup, query data, perform authorization, inspect the
| request, submit forms, or own modal/dialog behavior.
|
*/

return static function (
    array $props,
    ComponentAttributeBag $attributes,
    mixed $slot,
): array {
    /*
    |--------------------------------------------------------------------------
    | Static Options
    |--------------------------------------------------------------------------
    */

    $options = require resource_path(
        "views/components/patterns/common-actions/destructive-actions/options.php",
    );

    $resolveAllowed = static function (
        mixed $value,
        array $allowed,
        string $fallback,
    ): string {
        return is_string($value) && in_array($value, $allowed, true)
            ? $value
            : $fallback;
    };

    $toBoolean = static fn(mixed $value): bool => filter_var(
        $value,
        FILTER_VALIDATE_BOOLEAN,
    );

    $renderTrustedContent = static function (mixed $content): string {
        if ($content instanceof HtmlString) {
            return $content->toHtml();
        }

        if (is_object($content) && method_exists($content, "toHtml")) {
            return $content->toHtml();
        }

        return e((string) $content);
    };

    /*
    |--------------------------------------------------------------------------
    | Resolved Public Values
    |--------------------------------------------------------------------------
    */

    $resolvedId =
        $props["id"] ??
        ($attributes->get("id") ?? "ui-destructive-actions-" . Str::uuid());

    $resolvedMode = $resolveAllowed(
        $props["mode"],
        $options["modes"],
        "confirmation",
    );
    $resolvedScope = $resolveAllowed(
        $props["scope"],
        $options["scopes"],
        "local",
    );
    $resolvedPlacement = $resolveAllowed(
        $props["placement"],
        $options["placements"],
        "inline",
    );
    $resolvedSeverity = $resolveAllowed(
        $props["severity"],
        $options["severities"],
        "danger",
    );
    $resolvedAlignment = $resolveAllowed(
        $props["alignment"],
        $options["alignments"],
        "end",
    );
    $resolvedOrientation = $resolveAllowed(
        $props["orientation"],
        $options["orientations"],
        "horizontal",
    );
    $resolvedSize = $resolveAllowed($props["size"], $options["sizes"], "md");
    $resolvedDangerKind = $resolveAllowed(
        $props["dangerKind"],
        $options["dangerKinds"],
        "danger",
    );
    $resolvedCancelKind = $resolveAllowed(
        $props["cancelKind"],
        $options["cancelKinds"],
        "secondary",
    );

    $resolvedConfirmLabel = $props["confirmLabel"] ?? $props["actionLabel"];

    $resolvedGroupLabel =
        filled($props["subject"]) && $props["label"] === "Destructive actions"
            ? "Destructive actions for " . $props["subject"]
            : $props["label"];

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $requiresConfirmation = $toBoolean($props["requireConfirmation"]);
    $requiresTypedConfirmation = $toBoolean($props["requireTypedConfirmation"]);
    $isBusy = $toBoolean($props["busy"]) || $toBoolean($props["loading"]);
    $isDisabled = $toBoolean($props["disabled"]);

    $isFooterPlacement = in_array(
        $resolvedPlacement,
        ["footer", "dialog-footer"],
        true,
    );

    $buttonSetFluid = $isFooterPlacement;
    $buttonSetWidth = $isFooterPlacement ? "full" : "auto";
    $buttonSetAlign = $isFooterPlacement
        ? "stretch"
        : match ($resolvedAlignment) {
            "start" => "start",
            "between" => "stretch",
            default => "end",
        };

    $buttonSetAutoStack = $resolvedPlacement !== "dialog-footer";

    /*
    |--------------------------------------------------------------------------
    | Typed Confirmation State
    |--------------------------------------------------------------------------
    */

    $resolvedTypedConfirmationInputId =
        $props["typedConfirmationInputId"] ??
        "{$resolvedId}-typed-confirmation";

    $resolvedTypedConfirmationLabel = filled($props["typedConfirmationLabel"])
        ? $props["typedConfirmationLabel"]
        : (filled($props["typedConfirmationValue"])
            ? "Type {$props["typedConfirmationValue"]} to confirm"
            : "Type the required confirmation value");

    $resolvedTypedConfirmationHelperText = filled(
        $props["typedConfirmationHelperText"],
    )
        ? $props["typedConfirmationHelperText"]
        : "The destructive action will remain disabled until the value matches exactly.";

    $resolvedTypedConfirmationPlaceholder = filled(
        $props["typedConfirmationPlaceholder"],
    )
        ? $props["typedConfirmationPlaceholder"]
        : $props["typedConfirmationValue"];

    $showsMessage =
        filled($props["description"]) ||
        filled($props["consequence"]) ||
        $requiresTypedConfirmation;

    $messageId = $showsMessage ? "{$resolvedId}-message" : null;

    $ariaDescribedBy = collect([
        $attributes->get("aria-describedby"),
        $messageId,
    ])
        ->filter()
        ->implode(" ");

    /*
    |--------------------------------------------------------------------------
    | Default Actions
    |--------------------------------------------------------------------------
    */

    $defaultActions =
        $resolvedMode === "trigger"
            ? [
                [
                    "label" => $props["actionLabel"],
                    "role" => $props["actionRole"],
                    "kind" => $resolvedDangerKind,
                    "type" => "button",
                    "icon" => $props["icon"],
                    "danger" => true,
                ],
            ]
            : [
                [
                    "label" => $props["cancelLabel"],
                    "role" => "cancel",
                    "kind" => $resolvedCancelKind,
                    "type" => "button",
                    "allowDuringBusy" => true,
                ],
                [
                    "label" => $resolvedConfirmLabel,
                    "role" => $props["actionRole"],
                    "kind" => $resolvedDangerKind,
                    "type" => filled($props["form"]) ? "submit" : "button",
                    "icon" => $props["icon"],
                    "danger" => true,
                    "form" => $props["form"],
                ],
            ];

    /*
    |--------------------------------------------------------------------------
    | Normalized Actions
    |--------------------------------------------------------------------------
    */

    $inputActions = collect(
        is_iterable($props["actions"]) ? $props["actions"] : [],
    );

    $normalizedActions = collect(
        $inputActions->isNotEmpty() ? $inputActions : $defaultActions,
    )
        ->map(function (mixed $action, int $index) use (
            $props,
            $isDisabled,
            $isBusy,
            $requiresTypedConfirmation,
            $options,
            $resolvedSize,
            $resolvedDangerKind,
            $resolvedCancelKind,
            $renderTrustedContent,
            $toBoolean,
        ) {
            $actionData = is_array($action)
                ? $action
                : [
                    "label" => $action,
                    "role" => $index === 0 ? "destructive" : "secondary",
                ];

            $isVisible =
                !array_key_exists("visible", $actionData) ||
                $toBoolean(data_get($actionData, "visible", true));

            if (!$isVisible) {
                return null;
            }

            $role = data_get(
                $actionData,
                "role",
                data_get($actionData, "action", "destructive"),
            );
            $role =
                is_string($role) && $role !== ""
                    ? strtolower(str_replace("_", "-", trim($role)))
                    : "destructive";

            $isDestructive =
                in_array($role, $options["destructiveRoles"], true) ||
                $toBoolean(data_get($actionData, "danger", false)) ||
                $toBoolean(data_get($actionData, "destructive", false));

            $kind =
                data_get($actionData, "kind") ??
                match (true) {
                    $isDestructive => $resolvedDangerKind,
                    $role === "cancel" => $resolvedCancelKind,
                    default => "secondary",
                };

            $type =
                data_get($actionData, "type") ??
                match ($role) {
                    "submit", "confirm-submit" => "submit",
                    "reset" => "reset",
                    default => "button",
                };

            $itemDisabled = $toBoolean(
                data_get($actionData, "disabled", false),
            );

            $allowDuringBusy = $toBoolean(
                data_get(
                    $actionData,
                    "allowDuringBusy",
                    in_array($role, $options["cancelRoles"], true),
                ),
            );

            $baseActionDisabled =
                $isDisabled || $itemDisabled || ($isBusy && !$allowDuringBusy);

            $requiresTypedConfirmationForAction =
                $requiresTypedConfirmation && $isDestructive;

            $actionDisabled =
                $baseActionDisabled || $requiresTypedConfirmationForAction;

            $actionLoading =
                $toBoolean(data_get($actionData, "loading", false)) ||
                ($isBusy && $isDestructive);

            $extraClasses = data_get($actionData, "class");

            $classes = [
                "ui-destructive-actions__action",
                "ui-destructive-actions__action--{$role}",
                "ui-destructive-actions__action--destructive" => $isDestructive,
            ];

            foreach (
                collect(
                    is_array($extraClasses) ? $extraClasses : [$extraClasses],
                )->filter()
                as $extraClass
            ) {
                $classes[] = $extraClass;
            }

            $label = data_get(
                $actionData,
                "label",
                data_get($actionData, "text", "Action"),
            );

            return [
                "index" => $index,
                "role" => $role,
                "label_html" => $renderTrustedContent($label),
                "type" => $type,
                "kind" => $kind,
                "size" => data_get($actionData, "size", $resolvedSize),
                "href" => data_get(
                    $actionData,
                    "href",
                    data_get($actionData, "url"),
                ),
                "target" => data_get($actionData, "target"),
                "rel" => data_get($actionData, "rel"),
                "name" => data_get($actionData, "name"),
                "value" => data_get($actionData, "value"),
                "form" => data_get($actionData, "form", $props["form"]),
                "icon" => data_get($actionData, "icon"),
                "classes" => $classes,
                "disabled" => $actionDisabled,
                "loading" => $actionLoading,
                "destructive" => $isDestructive,
                "locked" => $baseActionDisabled,
                "requires_typed_confirmation" => $requiresTypedConfirmationForAction,
                "subject_id" => data_get(
                    $actionData,
                    "subjectId",
                    data_get($actionData, "subject_id", $props["subjectId"]),
                ),
            ];
        })
        ->filter()
        ->values()
        ->all();

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $rootClasses = [
        "ui-destructive-actions",
        "ui-destructive-actions--{$resolvedMode}",
        "ui-destructive-actions--scope-{$resolvedScope}",
        "ui-destructive-actions--{$resolvedPlacement}",
        "ui-destructive-actions--{$resolvedSeverity}",
        "ui-destructive-actions--{$resolvedOrientation}",
        "ui-destructive-actions--align-{$resolvedAlignment}",
        "ui-destructive-actions--requires-confirmation" => $requiresConfirmation,
        "ui-destructive-actions--requires-typed-confirmation" => $requiresTypedConfirmation,
        "ui-destructive-actions--busy" => $isBusy,
        "ui-destructive-actions--disabled" => $isDisabled,
    ];

    $setClasses = ["ui-destructive-actions__set"];

    $messageClasses = [
        "ui-destructive-actions__message",
        "ui-destructive-actions__message--critical" =>
            $resolvedSeverity === "critical",
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    */

    $rootAttributes = $attributes->except(["id", "aria-describedby"]);

    $rootAttributeMerge = collect([
        "aria-describedby" => filled($ariaDescribedBy)
            ? $ariaDescribedBy
            : null,
        "data-ui-pattern" => "common-actions-destructive-actions",
        "data-ui-destructive-actions" => "true",
        "data-ui-destructive-actions-id" => $resolvedId,
        "data-ui-destructive-actions-mode" => $resolvedMode,
        "data-ui-destructive-actions-scope" => $resolvedScope,
        "data-ui-destructive-actions-placement" => $resolvedPlacement,
        "data-ui-destructive-actions-severity" => $resolvedSeverity,
        "data-ui-destructive-actions-alignment" => $resolvedAlignment,
        "data-ui-destructive-actions-orientation" => $resolvedOrientation,
        "data-ui-destructive-actions-subject" => $props["subject"],
        "data-ui-destructive-actions-subject-id" => $props["subjectId"],
        "data-ui-destructive-actions-requires-confirmation" => $requiresConfirmation
            ? "true"
            : "false",
        "data-ui-destructive-actions-requires-typed-confirmation" => $requiresTypedConfirmation
            ? "true"
            : "false",
        "data-ui-destructive-actions-typed-confirmation-value" =>
            $requiresTypedConfirmation &&
            filled($props["typedConfirmationValue"])
                ? $props["typedConfirmationValue"]
                : null,
        "data-ui-destructive-actions-busy" => $isBusy ? "true" : "false",
        "data-ui-destructive-actions-disabled" => $isDisabled
            ? "true"
            : "false",
    ])
        ->filter(fn(mixed $value) => !is_null($value) && $value !== "")
        ->all();

    $slotHtml =
        is_object($slot) && method_exists($slot, "toHtml")
            ? $slot->toHtml()
            : (string) $slot;

    /*
    |--------------------------------------------------------------------------
    | View State
    |--------------------------------------------------------------------------
    */

    return [
        "id" => $resolvedId,
        "mode" => $resolvedMode,
        "scope" => $resolvedScope,
        "placement" => $resolvedPlacement,
        "severity" => $resolvedSeverity,
        "alignment" => $resolvedAlignment,
        "orientation" => $resolvedOrientation,
        "labelledBy" => $props["labelledBy"],
        "groupLabel" => $resolvedGroupLabel,

        "rootAttributes" => $rootAttributes,
        "rootAttributeMerge" => $rootAttributeMerge,
        "rootClasses" => $rootClasses,
        "setClasses" => $setClasses,
        "messageClasses" => $messageClasses,

        "showsMessage" => $showsMessage,
        "messageId" => $messageId,
        "descriptionHtml" => filled($props["description"])
            ? $renderTrustedContent($props["description"])
            : null,
        "consequenceHtml" => filled($props["consequence"])
            ? $renderTrustedContent($props["consequence"])
            : null,

        "requiresTypedConfirmation" => $requiresTypedConfirmation,
        "typedConfirmationExpectedValue" => $props["typedConfirmationValue"],
        "typedConfirmationInputId" => $resolvedTypedConfirmationInputId,
        "typedConfirmationInputName" => $props["typedConfirmationInputName"],
        "typedConfirmationLabel" => $resolvedTypedConfirmationLabel,
        "typedConfirmationHelperText" => $resolvedTypedConfirmationHelperText,
        "typedConfirmationPlaceholder" => $resolvedTypedConfirmationPlaceholder,
        "typedConfirmationDisabled" => $isDisabled || $isBusy,

        "buttonSetStacked" => $resolvedOrientation === "vertical",
        "buttonSetFluid" => $buttonSetFluid,
        "buttonSetWidth" => $buttonSetWidth,
        "buttonSetAlign" => $buttonSetAlign,
        "buttonSetAutoStack" => $buttonSetAutoStack,

        "actions" => $normalizedActions,
        "hasSlotContent" => trim($slotHtml) !== "",
    ];
};
