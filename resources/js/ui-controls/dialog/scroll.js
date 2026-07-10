/**
 * File: resources/js/ui-controls/dialog/scroll.js
 * Purpose: Dialog body scroll-region synchronization.
 *
 * Notes:
 * - Supports both primitive dialog scroll classes and modal visual scroll
 *   classes when x-ui.modal composes x-ui.dialog.body.
 * - Resize observation is controller-owned and cleanup-safe.
 */

import { observeResize } from "../../internal/resize";
import { syncScrollRegion } from "../../internal/scroll-region";

import {
    DIALOG_BODY_SELECTOR,
    DIALOG_SCROLL_CONTENT_CLASS,
    DIALOG_SCROLL_CONTENT_NO_FADE_CLASS,
    MODAL_SCROLL_CONTENT_CLASS,
    MODAL_SCROLL_CONTENT_NO_FADE_CLASS,
} from "./constants";

/* --------------------------------------------------------------------------
   Observer state
   -------------------------------------------------------------------------- */

const bodyObserverCleanupByDialog = new WeakMap();

/* --------------------------------------------------------------------------
   Body lookup
   -------------------------------------------------------------------------- */

function getDialogBodies(dialog) {
    return Array.from(dialog.querySelectorAll(DIALOG_BODY_SELECTOR)).filter(
        (body) => body instanceof HTMLElement,
    );
}

function hasExplicitScrolling(dialog, body) {
    return (
        dialog.dataset.uiDialogHasScrollingContent === "true" ||
        body.dataset.uiDialogBodyScrollContent === "true"
    );
}

function hasExplicitNoFade(body) {
    return body.dataset.uiDialogBodyNoFade === "true";
}

function getScrollRegionLabelledBy(dialog, body) {
    return (
        body.getAttribute("aria-labelledby") ||
        body.dataset.uiDialogBodyLabelledBy ||
        dialog.getAttribute("aria-labelledby")
    );
}

function getScrollRegionAriaLabel(dialog, body) {
    return (
        body.getAttribute("aria-label") ||
        body.dataset.uiDialogBodyAriaLabel ||
        dialog.getAttribute("aria-label")
    );
}

/* --------------------------------------------------------------------------
   Synchronization
   -------------------------------------------------------------------------- */

export function syncDialogScrollRegions(dialog) {
    getDialogBodies(dialog).forEach((body) => {
        const active = syncScrollRegion(body, {
            enabled: hasExplicitScrolling(dialog, body),
            scrollClass: DIALOG_SCROLL_CONTENT_CLASS,
            noFadeClass: DIALOG_SCROLL_CONTENT_NO_FADE_CLASS,
            labelledBy: getScrollRegionLabelledBy(dialog, body),
            ariaLabel: getScrollRegionAriaLabel(dialog, body),
        });

        const shouldUseNoFade =
            active &&
            (hasExplicitNoFade(body) ||
                body.dataset.uiScrollRegionNoFade === "true");

        body.classList.toggle(MODAL_SCROLL_CONTENT_CLASS, active);
        body.classList.toggle(
            MODAL_SCROLL_CONTENT_NO_FADE_CLASS,
            shouldUseNoFade,
        );

        body.dataset.uiDialogBodyScrollContent = active ? "true" : "false";
        body.dataset.uiDialogBodyNoFade = shouldUseNoFade ? "true" : "false";
    });
}

export function bindDialogScrollRegions(dialog) {
    if (bodyObserverCleanupByDialog.has(dialog)) {
        syncDialogScrollRegions(dialog);
        return;
    }

    const cleanups = getDialogBodies(dialog).map((body) =>
        observeResize(body, () => {
            syncDialogScrollRegions(dialog);
        }),
    );

    bodyObserverCleanupByDialog.set(dialog, () => {
        cleanups.forEach((cleanup) => cleanup());
    });

    syncDialogScrollRegions(dialog);
}

export function unbindDialogScrollRegions(dialog) {
    const cleanup = bodyObserverCleanupByDialog.get(dialog);

    if (typeof cleanup === "function") {
        cleanup();
    }

    bodyObserverCleanupByDialog.delete(dialog);
}
