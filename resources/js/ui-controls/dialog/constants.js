/**
 * File: resources/js/ui-controls/dialog/constants.js
 * Purpose: Shared constants for native dialog behavior.
 *
 * Notes:
 * - Root state uses data-ui-dialog-open.
 * - Trigger behavior uses data-ui-dialog-trigger or
 *   data-ui-dialog-open-trigger.
 * - Do not use data-ui-dialog-open as a trigger marker.
 */

/* --------------------------------------------------------------------------
   Selectors
   -------------------------------------------------------------------------- */

export const DIALOG_SELECTOR = "[data-ui-dialog]";
export const DIALOG_BODY_SELECTOR = "[data-ui-dialog-body]";
export const DIALOG_CLOSE_SELECTOR = "[data-ui-dialog-close]";
export const DIALOG_PRIMARY_SELECTOR = "[data-ui-dialog-primary]";
export const DIALOG_SECONDARY_SELECTOR = "[data-ui-dialog-secondary]";

export const DIALOG_TRIGGER_SELECTOR = [
    "[data-ui-dialog-trigger]",
    "[data-ui-dialog-open-trigger]",
].join(", ");

export const DIALOG_TRIGGER_TARGET_ATTRIBUTES = [
    "data-ui-dialog-trigger",
    "data-ui-dialog-open-trigger",
];

/* --------------------------------------------------------------------------
   Binding markers
   -------------------------------------------------------------------------- */

export const DIALOG_BOUND_ATTR = "data-ui-dialog-bound";
export const DIALOG_TRIGGER_BOUND_ATTR = "data-ui-dialog-trigger-bound";

/* --------------------------------------------------------------------------
   Body state
   -------------------------------------------------------------------------- */

export const BODY_OPEN_CLASS = "ui--body--with-modal-open";
export const BODY_OPEN_ALIAS_CLASS = "ui-body--with-modal-open";
export const BODY_PREVIOUS_OVERFLOW_DATA_KEY = "uiDialogPreviousOverflow";

/* --------------------------------------------------------------------------
   CSS classes
   -------------------------------------------------------------------------- */

export const DIALOG_OPEN_CLASS = "ui-dialog--open";

export const MODAL_VISIBLE_LEGACY_CLASS = "is-visible";
export const MODAL_OPEN_LEGACY_CLASS = "ui-modal-open";
export const MODAL_OPEN_CLASS = "ui-modal--open";

export const DIALOG_SCROLL_CONTENT_CLASS = "ui-dialog-scroll-content";
export const DIALOG_SCROLL_CONTENT_NO_FADE_CLASS =
    "ui-dialog-scroll-content--no-fade";

export const MODAL_SCROLL_CONTENT_CLASS = "ui-modal-scroll-content";
export const MODAL_SCROLL_CONTENT_NO_FADE_CLASS =
    "ui-modal-scroll-content--no-fade";

/* --------------------------------------------------------------------------
   Focus selectors
   -------------------------------------------------------------------------- */

export const DEFAULT_PRIMARY_FOCUS_SELECTORS = [
    "[data-ui-dialog-primary-focus]",
    "[data-dialog-primary-focus]",
    "[autofocus]",
];

/* --------------------------------------------------------------------------
   Events
   -------------------------------------------------------------------------- */

export const DIALOG_EVENT_OPEN = "ui-dialog:open";
export const DIALOG_EVENT_CLOSE = "ui-dialog:close";
export const DIALOG_EVENT_CANCEL = "ui-dialog:cancel";
export const DIALOG_EVENT_SUBMIT = "ui-dialog:submit";
export const DIALOG_EVENT_SECONDARY = "ui-dialog:secondary";
