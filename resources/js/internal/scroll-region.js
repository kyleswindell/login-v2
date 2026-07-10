/**
 * File: resources/js/ui-controls/internal/scroll-region.js
 * Purpose: Shared scroll-region helpers for modal and dialog bodies.
 *
 * Notes:
 * - Standardizes scroll-content class toggling, no-fade treatment, keyboard
 *   focusability, and accessible region labelling.
 * - Inspired by Carbon Modal/Dialog body scroll-region behavior.
 * - Consumers provide the component-specific class names.
 */

import { observeResize } from "./resize";

const NULL_VALUE = "__ui_scroll_region_null__";

function rememberAttribute(element, attribute) {
    const key = `uiScrollRegionPrevious${attribute
        .replace(/^aria-/, "Aria")
        .replace(/(^|-)([a-z])/g, (_, _dash, char) => char.toUpperCase())}`;

    if (Object.prototype.hasOwnProperty.call(element.dataset, key)) {
        return;
    }

    element.dataset[key] = element.hasAttribute(attribute)
        ? element.getAttribute(attribute)
        : NULL_VALUE;
}

function restoreAttribute(element, attribute) {
    const key = `uiScrollRegionPrevious${attribute
        .replace(/^aria-/, "Aria")
        .replace(/(^|-)([a-z])/g, (_, _dash, char) => char.toUpperCase())}`;

    if (!Object.prototype.hasOwnProperty.call(element.dataset, key)) {
        return;
    }

    const value = element.dataset[key];

    if (value === NULL_VALUE) {
        element.removeAttribute(attribute);
    } else {
        element.setAttribute(attribute, value);
    }

    delete element.dataset[key];
}

function markManagedAttributes(element) {
    ["tabindex", "role", "aria-labelledby", "aria-label"].forEach(
        (attribute) => {
            rememberAttribute(element, attribute);
        },
    );

    element.dataset.uiScrollRegionManaged = "true";
}

function restoreManagedAttributes(element) {
    ["tabindex", "role", "aria-labelledby", "aria-label"].forEach(
        (attribute) => {
            restoreAttribute(element, attribute);
        },
    );

    delete element.dataset.uiScrollRegionManaged;
}

export function isScrollable(element, threshold = 5) {
    if (!(element instanceof HTMLElement)) {
        return false;
    }

    return element.scrollHeight - element.clientHeight > threshold;
}

export function syncScrollRegion(element, options = {}) {
    if (!(element instanceof HTMLElement)) {
        return false;
    }

    const {
        enabled = false,
        threshold = 5,
        noFadeThreshold = 300,
        scrollClass = "ui-dialog-scroll-content",
        noFadeClass = "ui-dialog-scroll-content--no-fade",
        labelledBy = null,
        ariaLabel = null,
        role = "region",
    } = options;

    const shouldUseScrollRegion =
        Boolean(enabled) || isScrollable(element, threshold);
    const shouldUseNoFade =
        shouldUseScrollRegion && element.clientHeight <= noFadeThreshold;

    element.classList.toggle(scrollClass, shouldUseScrollRegion);
    element.classList.toggle(noFadeClass, shouldUseNoFade);

    element.dataset.uiScrollRegionActive = shouldUseScrollRegion
        ? "true"
        : "false";
    element.dataset.uiScrollRegionNoFade = shouldUseNoFade ? "true" : "false";

    if (shouldUseScrollRegion) {
        if (element.dataset.uiScrollRegionManaged !== "true") {
            markManagedAttributes(element);
        }

        element.setAttribute("tabindex", "0");
        element.setAttribute("role", role);

        if (labelledBy) {
            element.setAttribute("aria-labelledby", labelledBy);
            element.removeAttribute("aria-label");
        } else if (ariaLabel) {
            element.setAttribute("aria-label", ariaLabel);
            element.removeAttribute("aria-labelledby");
        }

        return true;
    }

    if (element.dataset.uiScrollRegionManaged === "true") {
        restoreManagedAttributes(element);
    }

    return false;
}

export function observeScrollRegion(element, options = {}) {
    if (!(element instanceof HTMLElement)) {
        return () => {};
    }

    const sync = () => {
        syncScrollRegion(element, options);
    };

    sync();

    return observeResize(element, sync, {
        initial: false,
    });
}
