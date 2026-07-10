<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| File: resources/views/components/patterns/common-actions/destructive-actions/options.php
| Purpose: Destructive Actions pattern allowed values and role maps.
|--------------------------------------------------------------------------
|
| This file owns static option maps only. It does not normalize props, compute
| classes, inspect attributes, render markup, or perform business logic.
|
*/

return [
    /*
    |--------------------------------------------------------------------------
    | Allowed Public Values
    |--------------------------------------------------------------------------
    */

    "modes" => ["trigger", "confirmation"],

    "scopes" => ["local", "form", "page", "row", "bulk", "global"],

    "placements" => ["inline", "footer", "dialog-footer", "overflow"],

    "severities" => ["danger", "critical"],

    "alignments" => ["start", "end", "between"],

    "orientations" => ["horizontal", "vertical"],

    "sizes" => ["sm", "md", "lg"],

    "dangerKinds" => ["danger", "danger-ghost", "danger-tertiary"],

    "cancelKinds" => ["secondary", "ghost", "tertiary"],

    /*
    |--------------------------------------------------------------------------
    | Semantic Role Maps
    |--------------------------------------------------------------------------
    */

    "destructiveRoles" => [
        "delete",
        "remove",
        "discard",
        "destroy",
        "revoke",
        "archive",
        "deactivate",
        "reset",
        "danger",
        "destructive",
    ],

    "cancelRoles" => ["cancel", "back"],
];
