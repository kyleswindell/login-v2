/**
 * File: resources/js/ui-controls/dialog/controller.js
 * Purpose: Native dialog controller.
 *
 * Notes:
 * - Owns show, showModal, close, cancel/close sync, action events, backdrop
 *   close, initial focus, focus return, body lock, scroll-region sync, and
 *   trigger state.
 * - This controller supports both primitive x-ui.dialog.* compositions and
 *   higher-level x-ui.modal compositions.
 */

import { DIALOG_BOUND_ATTR, DIALOG_SELECTOR } from "./constants";

import {
    allowsBackdropClose,
    isDialogOpen,
    isModalDialog,
    setDialogState,
    syncBodyOpenState,
} from "./state";

import {
    dispatchDialogCancel,
    dispatchDialogClose,
    dispatchDialogOpen,
    handleDialogActionClick,
    handleDialogEnterSubmit,
    requestDialogSubmit,
} from "./actions";

import {
    focusInitialDialogTarget,
    rememberFocusReturnTarget,
    restoreFocusReturnTarget,
    shouldSuppressFocusReturn,
    suppressFocusReturn,
} from "./focus";

import { bindDialogScrollRegions, syncDialogScrollRegions } from "./scroll";

import { initDialogTriggers, syncTriggerStateForDialog } from "./triggers";

/* --------------------------------------------------------------------------
   Internal transition state
   -------------------------------------------------------------------------- */

const suppressNextNativeCloseSync = new WeakSet();

/* --------------------------------------------------------------------------
   Open / close state sync
   -------------------------------------------------------------------------- */

function syncOpenedDialogState(dialog, originalEvent = null) {
    setDialogState(dialog, true);
    syncTriggerStateForDialog(dialog, true);
    syncBodyOpenState();

    window.requestAnimationFrame(() => {
        syncDialogScrollRegions(dialog);
    });

    focusInitialDialogTarget(dialog);
    dispatchDialogOpen(dialog, originalEvent);
}

function syncClosedDialogState(dialog, originalEvent = null) {
    setDialogState(dialog, false);
    syncTriggerStateForDialog(dialog, false);
    syncBodyOpenState();

    dispatchDialogClose(dialog, originalEvent);

    if (shouldSuppressFocusReturn(dialog)) {
        return;
    }

    restoreFocusReturnTarget(dialog);
}

/* --------------------------------------------------------------------------
   Public open / close helpers
   -------------------------------------------------------------------------- */

export function openDialog(dialog, trigger = null) {
    if (!(dialog instanceof HTMLDialogElement)) {
        return;
    }

    rememberFocusReturnTarget(dialog, trigger);

    const shouldOpenModal = isModalDialog(dialog);
    const alreadyOpenedByController =
        dialog.open && dialog.dataset.uiDialogOpen === "true";

    if (alreadyOpenedByController) {
        syncOpenedDialogState(dialog);
        return;
    }

    try {
        if (shouldOpenModal) {
            /*
             * showModal() throws when the dialog is already open modelessly.
             * Close first, suppress that internal close sync, then reopen as
             * a native modal dialog.
             */
            if (dialog.open) {
                suppressNextNativeCloseSync.add(dialog);
                suppressFocusReturn(dialog);
                dialog.close();
            }

            dialog.showModal();
        } else if (!dialog.open) {
            dialog.show();
        }
    } catch {
        /*
         * Defensive fallback. The app targets native dialog support, but this
         * prevents state from becoming visually disconnected if the browser
         * rejects an imperative transition.
         */
        dialog.setAttribute("open", "");
    }

    syncOpenedDialogState(dialog);
}

export function closeDialog(dialog, shouldReturnFocus = true) {
    if (!(dialog instanceof HTMLDialogElement)) {
        return;
    }

    if (!shouldReturnFocus) {
        suppressFocusReturn(dialog);
    }

    if (dialog.open) {
        dialog.close();
        return;
    }

    syncClosedDialogState(dialog);
}

export { requestDialogSubmit };

/* --------------------------------------------------------------------------
   Event handling
   -------------------------------------------------------------------------- */

function handleDialogClick(dialog, event) {
    const handledAction = handleDialogActionClick(dialog, event, {
        closeDialog,
    });

    if (handledAction) {
        return;
    }

    /*
     * For native <dialog>, clicking the backdrop reports the dialog itself as
     * the event target. Clicks inside the dialog container do not.
     */
    if (
        isModalDialog(dialog) &&
        allowsBackdropClose(dialog) &&
        event.target === dialog
    ) {
        closeDialog(dialog);
    }
}

function handleDialogKeydown(dialog, event) {
    if (!isDialogOpen(dialog)) {
        return;
    }

    handleDialogEnterSubmit(dialog, event, {
        closeDialog,
    });
}

function bindDialogEvents(dialog) {
    dialog.addEventListener("click", (event) => {
        handleDialogClick(dialog, event);
    });

    dialog.addEventListener("keydown", (event) => {
        handleDialogKeydown(dialog, event);
    });

    dialog.addEventListener("cancel", (event) => {
        const cancelEvent = dispatchDialogCancel(dialog, event);

        if (cancelEvent.defaultPrevented) {
            event.preventDefault();
        }
    });

    dialog.addEventListener("close", (event) => {
        if (suppressNextNativeCloseSync.has(dialog)) {
            suppressNextNativeCloseSync.delete(dialog);
            return;
        }

        syncClosedDialogState(dialog, event);
    });
}

/* --------------------------------------------------------------------------
   Dialog binding
   -------------------------------------------------------------------------- */

function initDialog(dialog) {
    if (!(dialog instanceof HTMLDialogElement)) {
        return;
    }

    bindDialogScrollRegions(dialog);

    if (dialog.hasAttribute(DIALOG_BOUND_ATTR)) {
        setDialogState(dialog, isDialogOpen(dialog));
        syncTriggerStateForDialog(dialog, isDialogOpen(dialog));
        syncBodyOpenState();
        syncDialogScrollRegions(dialog);
        return;
    }

    dialog.setAttribute(DIALOG_BOUND_ATTR, "true");

    bindDialogEvents(dialog);

    if (isDialogOpen(dialog)) {
        openDialog(dialog);
        return;
    }

    setDialogState(dialog, false);
    syncTriggerStateForDialog(dialog, false);
    syncBodyOpenState();
    syncDialogScrollRegions(dialog);
}

/* --------------------------------------------------------------------------
   Initializer
   -------------------------------------------------------------------------- */

export function initDialogs(root = document) {
    if (root instanceof HTMLDialogElement && root.matches(DIALOG_SELECTOR)) {
        initDialog(root);
    }

    root.querySelectorAll?.(DIALOG_SELECTOR).forEach(initDialog);
    initDialogTriggers(root, openDialog);
}
