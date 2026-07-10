<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| File: resources/views/components/patterns/common-actions/destructive-actions/props.php
| Purpose: Destructive Actions pattern Blade prop defaults.
|--------------------------------------------------------------------------
|
| This file owns only public Blade prop defaults. It does not resolve derived
| state, normalize actions, inspect attributes, render markup, access the
| request, query data, or perform authorization.
|
*/

return [
    "id" => null,
    "actions" => [],
    "label" => "Destructive actions",
    "labelledBy" => null,
    "mode" => "confirmation",
    "scope" => "local",
    "placement" => "inline",
    "severity" => "danger",
    "alignment" => "end",
    "orientation" => "horizontal",
    "size" => "md",
    "subject" => null,
    "subjectId" => null,
    "actionRole" => "delete",
    "actionLabel" => "Delete",
    "confirmLabel" => null,
    "cancelLabel" => "Cancel",
    "description" => null,
    "consequence" => null,
    "icon" => null,
    "dangerKind" => "danger",
    "cancelKind" => "secondary",
    "requireConfirmation" => true,
    "requireTypedConfirmation" => false,
    "typedConfirmationValue" => null,
    "typedConfirmationInputId" => null,
    "typedConfirmationInputName" => "typed_confirmation",
    "typedConfirmationLabel" => null,
    "typedConfirmationHelperText" => null,
    "typedConfirmationPlaceholder" => null,
    "busy" => false,
    "loading" => false,
    "disabled" => false,
    "form" => null,
];
