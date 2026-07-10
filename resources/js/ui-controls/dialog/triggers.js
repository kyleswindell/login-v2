/**
 * File: resources/js/ui-controls/dialog/triggers.js
 * Purpose: Dialog trigger binding and trigger state synchronization.
 *
 * Notes:
 * - Triggers use data-ui-dialog-trigger or data-ui-dialog-open-trigger.
 * - A trigger target may be supplied through the data attribute value,
 *   aria-controls, or href="#dialog-id".
 */

import { getControlledElementFromTrigger } from "../../internal/targets";

import {
    DIALOG_SELECTOR,
    DIALOG_TRIGGER_BOUND_ATTR,
    DIALOG_TRIGGER_SELECTOR,
    DIALOG_TRIGGER_TARGET_ATTRIBUTES,
} from "./constants";

import { isDialogOpen } from "./state";

/* --------------------------------------------------------------------------
   Target resolution
   -------------------------------------------------------------------------- */

export function getDialogFromTrigger(trigger) {
    const controlledElement = getControlledElementFromTrigger(trigger, {
        dataAttributes: DIALOG_TRIGGER_TARGET_ATTRIBUTES,
        selector: DIALOG_SELECTOR,
    });

    return controlledElement instanceof HTMLDialogElement
        ? controlledElement
        : null;
}

function triggerControlsDialog(trigger, dialog) {
    return getDialogFromTrigger(trigger) === dialog;
}

/* --------------------------------------------------------------------------
   Trigger state
   -------------------------------------------------------------------------- */

export function syncTriggerStateForDialog(dialog, open = isDialogOpen(dialog)) {
    document.querySelectorAll(DIALOG_TRIGGER_SELECTOR).forEach((trigger) => {
        if (!(trigger instanceof HTMLElement)) {
            return;
        }

        if (!triggerControlsDialog(trigger, dialog)) {
            return;
        }

        trigger.setAttribute("aria-expanded", open ? "true" : "false");
        trigger.dataset.uiDialogTriggerOpen = open ? "true" : "false";
    });
}

/* --------------------------------------------------------------------------
   Trigger binding
   -------------------------------------------------------------------------- */

function bindDialogTrigger(trigger, openDialog) {
    if (!(trigger instanceof HTMLElement)) {
        return;
    }

    if (trigger.hasAttribute(DIALOG_TRIGGER_BOUND_ATTR)) {
        return;
    }

    trigger.setAttribute(DIALOG_TRIGGER_BOUND_ATTR, "true");

    const dialog = getDialogFromTrigger(trigger);

    if (dialog instanceof HTMLDialogElement) {
        trigger.setAttribute(
            "aria-expanded",
            isDialogOpen(dialog) ? "true" : "false",
        );

        trigger.dataset.uiDialogTriggerOpen = isDialogOpen(dialog)
            ? "true"
            : "false";
    }

    trigger.addEventListener("click", (event) => {
        const targetDialog = getDialogFromTrigger(trigger);

        if (!(targetDialog instanceof HTMLDialogElement)) {
            return;
        }

        event.preventDefault();
        openDialog(targetDialog, trigger);
    });
}

export function initDialogTriggers(root = document, openDialog) {
    if (root instanceof HTMLElement && root.matches(DIALOG_TRIGGER_SELECTOR)) {
        bindDialogTrigger(root, openDialog);
    }

    root.querySelectorAll?.(DIALOG_TRIGGER_SELECTOR).forEach((trigger) => {
        bindDialogTrigger(trigger, openDialog);
    });
}
