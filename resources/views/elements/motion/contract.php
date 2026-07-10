<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/elements/motion/contract.php
| Purpose: Motion Foundation Element public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Motion API: duration/easing roles,
| productive motion boundaries, reduced-motion requirements, and consumer
| restrictions.
|
*/

return Surface::element([
    /*
    |--------------------------------------------------------------------------
    | Identity
    |--------------------------------------------------------------------------
    */

    "identity" => [
        "slug" => "motion",
        "label" => "Motion",
        "summary" =>
            "Transitions and reduced-motion behavior for hover, focus, overlays, loading, and feedback.",
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
            "Use productive motion roles and reduced-motion safeguards.",
    ],

    /*
    |--------------------------------------------------------------------------
    | Tokens
    |--------------------------------------------------------------------------
    */

    "tokens" => [
        "css_variables" => [
            "--ui-duration-*",
            "--ui-motion-*",
            "--ui-motion-travel-*",
        ],
        "notes" => [
            "Motion travel values are transform distances, not layout spacing.",
            "Motion may consume spacing/layout tokens as preset inputs.",
            "Motion may define larger transform distances when required by overlays, drawers, switchers, or shell panels.",
        ],
        "deprecated" => [
            "raw transition durations in consumers",
            "raw animation durations in consumers",
            "raw cubic-bezier values in consumers",
            "feature-local transform travel distances",
            "motion used as the only signal for state or status",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    "dependencies" => [
        "blocks" => [
            "accordion",
            "menu",
            "modal",
            "tooltip",
            "loading",
            "notification",
            "popover",
            "toggletip",
            "ui-shell",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility
    |--------------------------------------------------------------------------
    */

    "accessibility" => [
        "focus" => ["Motion must not be the only signal of focus or state."],
        "screen_reader" => [
            "Motion must not be required to understand status, selection, loading, error, or completion.",
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
        "css" => ["resources/css/tokens/motion.css"],
        "tokens" => ["resources/css/tokens/motion.css"],
        "contract" => ["resources/views/elements/motion/contract.php"],
        "docs" => ["docs/02-standards/ui/elements/motion.md"],
    ],
]);
