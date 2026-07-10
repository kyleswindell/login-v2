<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/modal/options.php
| Purpose: Modal component supported values and internal defaults.
|--------------------------------------------------------------------------
|
| This file owns allowed values and reusable modal option sets.
| Public prop defaults belong in props.php.
| Derived render state belongs in view-model.php.
|
*/

return [
    "sizes" => ["xs", "sm", "md", "lg"],

    "variants" => ["passive", "transactional"],

    "button_kinds" => [
        "primary",
        "secondary",
        "tertiary",
        "ghost",
        "danger",
        "danger-ghost",
        "danger-tertiary",
    ],

    "button_types" => ["button", "submit", "reset"],

    "defaults" => [
        "id_prefix" => "modal-",
        "size" => "md",
        "variant" => "transactional",
        "title_fallback" => "Modal dialog",
        "secondary_label" => "Cancel",
        "secondary_kind" => "secondary",
        "primary_kind" => "primary",
        "danger_primary_kind" => "danger",
        "primary_focus_selector" => "[data-ui-dialog-primary-focus]",
    ],

    "classes" => [
        "root" => "ui-modal",
        "open" => "ui-modal--open",
        "open_legacy" => "ui-modal-open",
        "visible_legacy" => "is-visible",
        "tall" => "ui-modal-tall",
        "danger" => "ui-modal--danger",
        "passive" => "ui-modal--passive",

        "container" => "ui-modal-container",
        "container_size_prefix" => "ui-modal-container--",
        "container_full_width" => "ui-modal-container--full-width",

        "header" => "ui-modal-header",
        "header_label" => "ui-modal-header__label",
        "header_heading" => "ui-modal-header__heading",

        "close_button_wrapper" => "ui-modal-close-button",
        "close_button" => "ui-modal-close",
        "close_icon" => "ui-modal-close__icon",

        "content" => "ui-modal-content",
        "content_scroll" => "ui-modal-scroll-content",
        "description" => "ui-modal-description",

        "footer" => "ui-modal-footer",
        "footer_three_button" => "ui-modal-footer--three-button",
    ],
];
