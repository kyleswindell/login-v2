<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/elements/typography/contract.php
| Purpose: Typography Foundation Element public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Typography API: type roles, font stacks,
| text property tokens, utility/class families, and consumer restrictions.
|
*/

return Surface::element([
    /*
    |--------------------------------------------------------------------------
    | Identity
    |--------------------------------------------------------------------------
    */

    "identity" => [
        "slug" => "typography",
        "label" => "Typography",
        "summary" =>
            "Type roles, font stacks, line heights, weights, and text rhythm for application UI.",
    ],

    /*
    |--------------------------------------------------------------------------
    | Lifecycle
    |--------------------------------------------------------------------------
    */

    "lifecycle" => [
        "status" => "provisional",
    ],

    /*
    |--------------------------------------------------------------------------
    | API
    |--------------------------------------------------------------------------
    */

    "api" => [
        "usage_context" =>
            "Use approved type roles and text utilities instead of raw font, size, weight, line-height, or letter-spacing values.",
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Contract
    |--------------------------------------------------------------------------
    */

    "class_contract" => [
        "optional" => [
            "ui-card-title",
            "ui-card-copy",
            "ui-kicker",
            "ui-code-snippet",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tokens
    |--------------------------------------------------------------------------
    */

    "tokens" => [
        "css_variables" => [
            "--ui-type-*",
            "--ui-font-*",
            "--ui-font-family-*",
            "--ui-font-weight-*",
            "--ui-line-height-*",
            "--ui-letter-spacing-*",
        ],
        "utility_classes" => [
            "approved type role classes",
            "approved card/title/copy/kicker text classes",
            "approved code text classes",
        ],
        "class_families" => [
            "ui-card-title",
            "ui-card-copy",
            "ui-kicker",
            "ui-code-snippet",
        ],
        "deprecated" => [
            "raw font-family values in consumers",
            "raw font-size values in consumers",
            "raw font-weight values in consumers",
            "raw line-height values in consumers",
            "raw letter-spacing values in consumers",
            "feature-local typography variables",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    "dependencies" => [
        "blocks" => [
            "button",
            "text-input",
            "tag",
            "data-table",
            "notification",
            "forms",
            "layout",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility
    |--------------------------------------------------------------------------
    */

    "accessibility" => [
        "screen_reader" => [
            "Type roles must preserve readable hierarchy and not hide required instructions, labels, validation, or task-critical copy.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Enforcement
    |--------------------------------------------------------------------------
    */

    "enforcement" => [
        "mode" => "legacy-compatible",
        "invalid_usage" => "warn",
    ],

    /*
    |--------------------------------------------------------------------------
    | Source
    |--------------------------------------------------------------------------
    */

    "source" => [
        "css" => ["resources/css/tokens/type/index.css"],
        "tokens" => ["resources/css/tokens/type/index.css"],
        "contract" => ["resources/views/elements/typography/contract.php"],
        "docs" => ["docs/02-standards/ui/elements/typography.md"],
    ],
]);
