/**
 * File: resources/js/ui-controls/internal/focus.js
 * Purpose: Shared focus helpers for UI controllers.
 *
 * Notes:
 * - Provides framework-neutral focus discovery and focus-wrap behavior inspired
 *   by Carbon's internal focus utilities.
 * - Does not import tabbable; this app uses a local selector and visibility
 *   checks to avoid adding a runtime dependency.
 * - Controllers own when and why focus should be moved.
 */

import { isTabKey } from "./keyboard";

const DOCUMENT_POSITION_BROAD_PRECEDING =
    typeof Node !== "undefined"
        ? Node.DOCUMENT_POSITION_PRECEDING | Node.DOCUMENT_POSITION_CONTAINS
        : 0;

const DOCUMENT_POSITION_BROAD_FOLLOWING =
    typeof Node !== "undefined"
        ? Node.DOCUMENT_POSITION_FOLLOWING | Node.DOCUMENT_POSITION_CONTAINED_BY
        : 0;

export const FOCUSABLE_SELECTOR = [
    "a[href]",
    "area[href]",
    "button:not([disabled])",
    "input:not([disabled]):not([type='hidden'])",
    "select:not([disabled])",
    "textarea:not([disabled])",
    "iframe",
    "object",
    "embed",
    "[contenteditable='true']",
    "[tabindex]:not([tabindex='-1'])",
].join(",");

const DEFAULT_FLOATING_MENU_SELECTORS = [
    ".ui-overflow-menu-options",
    ".ui-tooltip",
    ".ui-popover",
    ".ui-popover-content",
    ".ui-combo-box-menu",
    ".ui-list-box-menu",
    ".flatpickr-calendar",
    "[data-ui-floating-menu]",
    "[data-ui-popover-content]",
];

export function elementOrParentIsFloatingMenu(
    node,
    selectorsFloatingMenus = [],
) {
    if (!(node instanceof Element) || typeof node.closest !== "function") {
        return false;
    }

    const selectors = [
        ...DEFAULT_FLOATING_MENU_SELECTORS,
        ...selectorsFloatingMenus,
    ];

    return selectors.some((selector) => {
        try {
            return Boolean(node.closest(selector));
        } catch {
            return false;
        }
    });
}

export function isFocusable(element) {
    if (!(element instanceof HTMLElement)) {
        return false;
    }

    if (element.hidden || element.getAttribute("aria-hidden") === "true") {
        return false;
    }

    if (element.closest("[inert]")) {
        return false;
    }

    if ("disabled" in element && element.disabled) {
        return false;
    }

    const style = window.getComputedStyle(element);

    if (style.display === "none" || style.visibility === "hidden") {
        return false;
    }

    if (element.getClientRects().length === 0 && style.position !== "fixed") {
        return false;
    }

    return true;
}

export function getFocusableElements(container) {
    if (!(container instanceof Element)) {
        return [];
    }

    return Array.from(container.querySelectorAll(FOCUSABLE_SELECTOR)).filter(
        isFocusable,
    );
}

export function getFirstFocusable(container) {
    return getFocusableElements(container)[0] || null;
}

export function getLastFocusable(container) {
    const focusable = getFocusableElements(container);

    return focusable[focusable.length - 1] || null;
}

export function getInitialFocusTarget(container, preferredSelector = null) {
    if (!(container instanceof HTMLElement)) {
        return null;
    }

    const selectors = Array.isArray(preferredSelector)
        ? preferredSelector
        : [preferredSelector];

    for (const selector of selectors.filter(Boolean)) {
        try {
            const candidate = container.querySelector(selector);

            if (candidate instanceof HTMLElement && isFocusable(candidate)) {
                return candidate;
            }
        } catch {
            /*
             * Invalid optional selectors should not break controller setup.
             */
        }
    }

    return getFirstFocusable(container) || container;
}

export function focusElement(element, options = {}) {
    if (!(element instanceof HTMLElement)) {
        return;
    }

    const { preventScroll = true, defer = true } = options;

    const run = () => {
        if (document.contains(element)) {
            element.focus({ preventScroll });
        }
    };

    if (defer) {
        window.setTimeout(run);
        return;
    }

    run();
}

export function restoreFocus(element, options = {}) {
    focusElement(element, options);
}

export function wrapFocusWithin(container, event) {
    if (!(container instanceof HTMLElement) || !isTabKey(event)) {
        return;
    }

    const focusable = getFocusableElements(container);

    if (!focusable.length) {
        event.preventDefault();
        container.focus();
        return;
    }

    const first = focusable[0];
    const last = focusable[focusable.length - 1];

    if (event.shiftKey && document.activeElement === first) {
        event.preventDefault();
        last.focus();
        return;
    }

    if (!event.shiftKey && document.activeElement === last) {
        event.preventDefault();
        first.focus();
    }
}

export function wrapFocusWithSentinels({
    bodyNode,
    startTrapNode,
    endTrapNode,
    currentActiveNode,
    oldActiveNode,
    selectorsFloatingMenus = [],
} = {}) {
    if (
        !(bodyNode instanceof HTMLElement) ||
        !(currentActiveNode instanceof HTMLElement) ||
        !(oldActiveNode instanceof HTMLElement) ||
        bodyNode.contains(currentActiveNode) ||
        elementOrParentIsFloatingMenu(currentActiveNode, selectorsFloatingMenus)
    ) {
        return;
    }

    const comparisonResult =
        oldActiveNode.compareDocumentPosition(currentActiveNode);

    if (
        currentActiveNode === startTrapNode ||
        comparisonResult & DOCUMENT_POSITION_BROAD_PRECEDING
    ) {
        const lastFocusable = getLastFocusable(bodyNode);

        if (lastFocusable) {
            lastFocusable.focus();
            return;
        }

        if (bodyNode !== oldActiveNode) {
            bodyNode.focus();
        }

        return;
    }

    if (
        currentActiveNode === endTrapNode ||
        comparisonResult & DOCUMENT_POSITION_BROAD_FOLLOWING
    ) {
        const firstFocusable = getFirstFocusable(bodyNode);

        if (firstFocusable) {
            firstFocusable.focus();
            return;
        }

        if (bodyNode !== oldActiveNode) {
            bodyNode.focus();
        }
    }
}

export function focusFirstAvailable(container, preferredSelector = null) {
    const target = getInitialFocusTarget(container, preferredSelector);

    focusElement(target);
}
