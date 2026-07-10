/**
 * File: resources/js/ui-controls/dialog/actions.js
 * Purpose: Dialog action event handling.
 *
 * Notes:
 * - Owns primary, secondary, close, and Enter-submit behavior.
 * - Native form submission is not prevented unless a custom dialog event is
 *   canceled.
 */

import { isEnterKey } from "../../internal/keyboard";

import {
    DIALOG_CLOSE_SELECTOR,
    DIALOG_EVENT_CANCEL,
    DIALOG_EVENT_CLOSE,
    DIALOG_EVENT_OPEN,
    DIALOG_EVENT_SECONDARY,
    DIALOG_EVENT_SUBMIT,
    DIALOG_PRIMARY_SELECTOR,
    DIALOG_SECONDARY_SELECTOR,
} from "./constants";

import { shouldCloseAfterSubmit, shouldSubmitOnEnter } from "./state";

/* --------------------------------------------------------------------------
   Event dispatch
   -------------------------------------------------------------------------- */

export function dispatchDialogEvent(
    dialog,
    type,
    originalEvent = null,
    detail = {},
) {
    const dialogEvent = new CustomEvent(type, {
        bubbles: true,
        cancelable: true,
        detail: {
            dialog,
            originalEvent,
            ...detail,
        },
    });

    dialog.dispatchEvent(dialogEvent);

    return dialogEvent;
}

export function dispatchDialogOpen(dialog, originalEvent = null) {
    return dispatchDialogEvent(dialog, DIALOG_EVENT_OPEN, originalEvent);
}

export function dispatchDialogClose(dialog, originalEvent = null) {
    return dispatchDialogEvent(dialog, DIALOG_EVENT_CLOSE, originalEvent);
}

export function dispatchDialogCancel(dialog, originalEvent = null) {
    return dispatchDialogEvent(dialog, DIALOG_EVENT_CANCEL, originalEvent);
}

export function requestDialogSubmit(dialog, originalEvent = null) {
    return dispatchDialogEvent(dialog, DIALOG_EVENT_SUBMIT, originalEvent);
}

export function requestDialogSecondary(dialog, originalEvent = null) {
    return dispatchDialogEvent(dialog, DIALOG_EVENT_SECONDARY, originalEvent);
}

/* --------------------------------------------------------------------------
   Target helpers
   -------------------------------------------------------------------------- */

function closestInsideDialog(dialog, target, selector) {
    if (!(target instanceof Element)) {
        return null;
    }

    const matched = target.closest(selector);

    return matched instanceof HTMLElement && dialog.contains(matched)
        ? matched
        : null;
}

function hasCloseBehavior(element) {
    return (
        element instanceof HTMLElement && element.matches(DIALOG_CLOSE_SELECTOR)
    );
}

function shouldIgnoreEnterSubmitTarget(target) {
    if (!(target instanceof HTMLElement)) {
        return true;
    }

    if (
        target.closest(DIALOG_CLOSE_SELECTOR) ||
        target.closest(DIALOG_PRIMARY_SELECTOR) ||
        target.closest(DIALOG_SECONDARY_SELECTOR)
    ) {
        return true;
    }

    if (target.isContentEditable) {
        return true;
    }

    const tagName = target.tagName.toLowerCase();

    if (tagName === "textarea" || tagName === "select") {
        return true;
    }

    if (tagName === "button" || tagName === "a") {
        return true;
    }

    return false;
}

/* --------------------------------------------------------------------------
   Click behavior
   -------------------------------------------------------------------------- */

export function handleDialogActionClick(dialog, event, callbacks = {}) {
    const { closeDialog } = callbacks;
    const target = event.target;

    const secondaryTarget = closestInsideDialog(
        dialog,
        target,
        DIALOG_SECONDARY_SELECTOR,
    );

    if (secondaryTarget) {
        const secondaryEvent = requestDialogSecondary(dialog, event);

        if (secondaryEvent.defaultPrevented) {
            event.preventDefault();
            return true;
        }

        if (hasCloseBehavior(secondaryTarget)) {
            event.preventDefault();
            closeDialog?.(dialog);
        }

        return true;
    }

    const primaryTarget = closestInsideDialog(
        dialog,
        target,
        DIALOG_PRIMARY_SELECTOR,
    );

    if (primaryTarget) {
        const submitEvent = requestDialogSubmit(dialog, event);

        if (submitEvent.defaultPrevented) {
            event.preventDefault();
            return true;
        }

        if (shouldCloseAfterSubmit(dialog)) {
            closeDialog?.(dialog);
        }

        return true;
    }

    const closeTarget = closestInsideDialog(
        dialog,
        target,
        DIALOG_CLOSE_SELECTOR,
    );

    if (closeTarget) {
        event.preventDefault();
        closeDialog?.(dialog);
        return true;
    }

    return false;
}

/* --------------------------------------------------------------------------
   Keyboard behavior
   -------------------------------------------------------------------------- */

export function handleDialogEnterSubmit(dialog, event, callbacks = {}) {
    const { closeDialog } = callbacks;

    if (!shouldSubmitOnEnter(dialog) || !isEnterKey(event)) {
        return false;
    }

    if (shouldIgnoreEnterSubmitTarget(event.target)) {
        return false;
    }

    event.preventDefault();

    const submitEvent = requestDialogSubmit(dialog, event);

    if (!submitEvent.defaultPrevented && shouldCloseAfterSubmit(dialog)) {
        closeDialog?.(dialog);
    }

    return true;
}
