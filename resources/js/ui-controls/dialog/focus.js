/**
 * File: resources/js/ui-controls/dialog/focus.js
 * Purpose: Dialog-specific focus management.
 *
 * Notes:
 * - Shared focus primitives live in resources/js/ui-controls/internal/focus.js.
 * - This file owns dialog launcher tracking, initial focus, and focus return.
 */

import {
    focusElement,
    getInitialFocusTarget as getInternalInitialFocusTarget,
    restoreFocus,
} from "../../internal/focus";

import { DEFAULT_PRIMARY_FOCUS_SELECTORS } from "./constants";

/* --------------------------------------------------------------------------
   Focus return state
   -------------------------------------------------------------------------- */

const focusReturnTargets = new WeakMap();
const suppressNextFocusReturn = new WeakSet();

export function rememberFocusReturnTarget(dialog, trigger = null) {
    if (!(dialog instanceof HTMLDialogElement)) {
        return;
    }

    if (trigger instanceof HTMLElement) {
        focusReturnTargets.set(dialog, trigger);
        return;
    }

    if (document.activeElement instanceof HTMLElement) {
        focusReturnTargets.set(dialog, document.activeElement);
    }
}

export function suppressFocusReturn(dialog) {
    if (dialog instanceof HTMLDialogElement) {
        suppressNextFocusReturn.add(dialog);
    }
}

export function shouldSuppressFocusReturn(dialog) {
    if (!suppressNextFocusReturn.has(dialog)) {
        return false;
    }

    suppressNextFocusReturn.delete(dialog);
    return true;
}

export function restoreFocusReturnTarget(dialog) {
    const focusReturnTarget = focusReturnTargets.get(dialog);

    if (focusReturnTarget instanceof HTMLElement) {
        restoreFocus(focusReturnTarget);
    }
}

/* --------------------------------------------------------------------------
   Initial focus
   -------------------------------------------------------------------------- */

function getPrimaryFocusSelectors(dialog) {
    const configuredSelector = dialog.dataset.uiDialogSelectorPrimaryFocus;

    return [configuredSelector, ...DEFAULT_PRIMARY_FOCUS_SELECTORS].filter(
        Boolean,
    );
}

export function focusInitialDialogTarget(dialog) {
    const focusTarget = getInternalInitialFocusTarget(
        dialog,
        getPrimaryFocusSelectors(dialog),
    );

    if (!(focusTarget instanceof HTMLElement)) {
        return;
    }

    window.setTimeout(() => {
        if (dialog.open && document.contains(focusTarget)) {
            focusElement(focusTarget, {
                preventScroll: true,
                defer: false,
            });
        }
    });
}
