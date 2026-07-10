/**
 * File: resources/js/ui-controls/dialog/state.js
 * Purpose: Native dialog state helpers.
 *
 * Notes:
 * - Owns data/class state synchronization.
 * - Owns document body modal-open scroll lock state.
 */

import {
    BODY_OPEN_ALIAS_CLASS,
    BODY_OPEN_CLASS,
    BODY_PREVIOUS_OVERFLOW_DATA_KEY,
    DIALOG_OPEN_CLASS,
    DIALOG_SELECTOR,
    MODAL_OPEN_CLASS,
    MODAL_OPEN_LEGACY_CLASS,
    MODAL_VISIBLE_LEGACY_CLASS,
} from "./constants";

/* --------------------------------------------------------------------------
   Dialog state
   -------------------------------------------------------------------------- */

export function isModalDialog(dialog) {
    return (
        dialog instanceof HTMLDialogElement &&
        (dialog.dataset.uiDialogModal === "true" ||
            dialog.classList.contains("ui-dialog--modal") ||
            dialog.dataset.uiDialogKind === "modal")
    );
}

export function isDialogOpen(dialog) {
    return (
        dialog instanceof HTMLDialogElement &&
        (dialog.open || dialog.dataset.uiDialogOpen === "true")
    );
}

export function allowsBackdropClose(dialog) {
    return (
        dialog.dataset.uiDialogCloseOnBackdrop !== "false" &&
        dialog.dataset.uiDialogPreventCloseOnBackdrop !== "true"
    );
}

export function shouldSubmitOnEnter(dialog) {
    return dialog.dataset.uiDialogSubmitOnEnter === "true";
}

export function shouldCloseAfterSubmit(dialog) {
    return dialog.dataset.uiDialogCloseAfterSubmit === "true";
}

export function setDialogState(dialog, open) {
    dialog.dataset.uiDialogOpen = open ? "true" : "false";

    dialog.classList.toggle(DIALOG_OPEN_CLASS, open);

    /*
     * x-ui.modal keeps ui-modal classes for styling, but dialog.js owns the
     * behavior state.
     */
    dialog.classList.toggle(MODAL_VISIBLE_LEGACY_CLASS, open);
    dialog.classList.toggle(MODAL_OPEN_LEGACY_CLASS, open);
    dialog.classList.toggle(MODAL_OPEN_CLASS, open);
}

/* --------------------------------------------------------------------------
   Document modal-open state
   -------------------------------------------------------------------------- */

export function getOpenModalDialogs() {
    return Array.from(document.querySelectorAll(DIALOG_SELECTOR)).filter(
        (dialog) =>
            dialog instanceof HTMLDialogElement &&
            dialog.open &&
            isModalDialog(dialog),
    );
}

export function syncBodyOpenState() {
    const hasOpenModalDialog = getOpenModalDialogs().length > 0;

    document.body.classList.toggle(BODY_OPEN_CLASS, hasOpenModalDialog);
    document.body.classList.toggle(BODY_OPEN_ALIAS_CLASS, hasOpenModalDialog);

    if (hasOpenModalDialog) {
        if (!document.body.dataset[BODY_PREVIOUS_OVERFLOW_DATA_KEY]) {
            document.body.dataset[BODY_PREVIOUS_OVERFLOW_DATA_KEY] =
                document.body.style.overflow || "__empty__";
        }

        document.body.style.overflow = "hidden";
        return;
    }

    const previousOverflow =
        document.body.dataset[BODY_PREVIOUS_OVERFLOW_DATA_KEY];

    if (previousOverflow) {
        document.body.style.overflow =
            previousOverflow === "__empty__" ? "" : previousOverflow;

        delete document.body.dataset[BODY_PREVIOUS_OVERFLOW_DATA_KEY];
    }
}
