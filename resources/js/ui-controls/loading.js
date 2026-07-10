/**
 * File: resources/js/ui-controls/loading.js
 * Purpose: Loading component state controller.
 *
 * Carbon reference:
 * - reference/carbon-main/packages/react/src/components/Loading/Loading.tsx
 *
 * Notes:
 * - Synchronizes server-rendered loading state with Carbon-equivalent classes.
 * - Supports lifecycle initialization after initial load and Livewire navigation.
 * - Exposes helpers for programmatically starting and stopping loaders.
 */

const SELECTORS = Object.freeze({
    loading: "[data-ui-loading]",
    overlay: "[data-ui-loading-overlay]",
});

const CLASSES = Object.freeze({
    loadingStop: "ui-loading--stop",
    overlayStop: "ui-loading-overlay--stop",
});

/**
 * Resolve a loading element from an element or selector.
 *
 * @param {Element|string} target
 * @returns {HTMLElement|null}
 */
const resolveLoadingElement = (target) => {
    if (target instanceof HTMLElement) {
        if (target.matches(SELECTORS.loading)) {
            return target;
        }

        const loading = target.querySelector(SELECTORS.loading);

        return loading instanceof HTMLElement ? loading : null;
    }

    if (typeof target !== "string") {
        return null;
    }

    const element = document.querySelector(target);

    if (!(element instanceof HTMLElement)) {
        return null;
    }

    if (element.matches(SELECTORS.loading)) {
        return element;
    }

    const loading = element.querySelector(SELECTORS.loading);

    return loading instanceof HTMLElement ? loading : null;
};

/**
 * Resolve the overlay containing a loading element.
 *
 * @param {HTMLElement} loading
 * @returns {HTMLElement|null}
 */
const resolveLoadingOverlay = (loading) => {
    const overlay = loading.closest(SELECTORS.overlay);

    return overlay instanceof HTMLElement ? overlay : null;
};

/**
 * Set the active state of a loading indicator.
 *
 * @param {Element|string} target
 * @param {boolean} active
 * @returns {boolean}
 */
export const setLoadingActive = (target, active) => {
    const loading = resolveLoadingElement(target);

    if (!loading) {
        return false;
    }

    const resolvedActive = Boolean(active);
    const overlay = resolveLoadingOverlay(loading);

    loading.classList.toggle(CLASSES.loadingStop, !resolvedActive);
    loading.setAttribute("aria-live", resolvedActive ? "assertive" : "off");
    loading.dataset.uiLoadingActive = String(resolvedActive);

    if (overlay) {
        overlay.classList.toggle(CLASSES.overlayStop, !resolvedActive);
        overlay.dataset.uiLoadingActive = String(resolvedActive);
    }

    loading.dispatchEvent(
        new CustomEvent("ui:loading-change", {
            bubbles: true,
            detail: {
                active: resolvedActive,
            },
        }),
    );

    return true;
};

/**
 * Start a loading indicator.
 *
 * @param {Element|string} target
 * @returns {boolean}
 */
export const startLoading = (target) => {
    return setLoadingActive(target, true);
};

/**
 * Stop a loading indicator.
 *
 * @param {Element|string} target
 * @returns {boolean}
 */
export const stopLoading = (target) => {
    return setLoadingActive(target, false);
};

/**
 * Initialize loading indicators within a DOM root.
 *
 * @param {ParentNode} root
 * @returns {void}
 */
export const initLoading = (root = document) => {
    root.querySelectorAll(SELECTORS.loading).forEach((element) => {
        if (!(element instanceof HTMLElement)) {
            return;
        }

        const active = element.dataset.uiLoadingActive !== "false";

        setLoadingActive(element, active);
    });
};
