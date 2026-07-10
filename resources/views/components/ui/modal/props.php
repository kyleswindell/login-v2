<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/modal/props.php
| Purpose: Modal component public Blade prop defaults.
|--------------------------------------------------------------------------
|
| This file owns the x-ui.modal public prop defaults consumed by index.blade.php.
| Rendering logic belongs in index.blade.php.
| Normalization and derived values belong in view-model.php.
|
*/

return [
    "id" => null,

    /*
    |--------------------------------------------------------------------------
    | Header Content
    |--------------------------------------------------------------------------
    */

    "titleId" => null,
    "title" => null,
    "modalHeading" => null,
    "label" => null,
    "modalLabel" => null,
    "kicker" => null,
    "description" => null,
    "modalAriaLabel" => null,
    "closeButtonLabel" => "Close",

    /*
    |--------------------------------------------------------------------------
    | Behavior
    |--------------------------------------------------------------------------
    */

    "open" => false,
    "variant" => "transactional",
    "passiveModal" => null,
    "closeOnBackdrop" => null,
    "preventCloseOnClickOutside" => null,
    "shouldSubmitOnEnter" => false,
    "selectorPrimaryFocus" => "[data-ui-dialog-primary-focus]",

    /*
    |--------------------------------------------------------------------------
    | Style / Type
    |--------------------------------------------------------------------------
    */

    "size" => "md",
    "danger" => false,
    "alert" => false,
    "hasScrollingContent" => false,
    "isFullWidth" => false,

    /*
    |--------------------------------------------------------------------------
    | Footer Actions
    |--------------------------------------------------------------------------
    */

    "primaryButtonText" => null,
    "primaryButtonKind" => null,
    "primaryButtonType" => null,
    "primaryButtonHref" => null,
    "primaryButtonForm" => null,
    "primaryButtonName" => null,
    "primaryButtonValue" => null,
    "primaryButtonDisabled" => false,
    "primaryButtonLoading" => false,

    "secondaryButtonText" => null,
    "secondaryButtonKind" => "secondary",
    "secondaryButtonType" => "button",
    "secondaryButtonHref" => null,
    "secondaryButtonForm" => null,
    "secondaryButtonName" => null,
    "secondaryButtonValue" => null,
    "secondaryButtonDisabled" => false,

    "secondaryButtons" => [],

    "shouldCloseAfterSubmit" => false,
];
