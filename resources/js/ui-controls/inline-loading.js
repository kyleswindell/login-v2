/**
 * File: resources/js/ui-controls/inline-loading.js
 * Purpose: Inline Loading status controller.
 *
 * Carbon reference:
 * - reference/carbon-main/packages/react/src/components/InlineLoading/InlineLoading.tsx
 *
 * Notes:
 * - Synchronizes inactive, active, finished, and error states.
 * - Implements Carbon's delayed success callback behavior as a DOM event.
 * - Supports initial page load and Livewire navigation lifecycle calls.
 * - Keeps initialization idempotent for existing DOM elements.
 */

const STATUSES = Object.freeze(["inactive", "active", "finished", "error"]);

const STATUS_ALIASES = Object.freeze({
    loading: "active",
    success: "finished",
});

const SELECTORS = Object.freeze({
    component: "[data-ui-inline-loading]",
    animation: "[data-ui-inline-loading-animation]",
    indicator: "[data-ui-inline-loading-indicator]",
});

const DEFAULT_SUCCESS_DELAY = 1500;

/**
 * Tracks pending success timers by Inline Loading element.
 *
 * @type {WeakMap<HTMLElement, number>}
 */
const successTimers = new WeakMap();

/**
 * Determine whether a value is a supported Inline Loading status.
 *
 * @param {string} status
 * @returns {boolean}
 */
const isInlineLoadingStatus = (status) => {
    return STATUSES.includes(status);
};

/**
 * Resolve compatibility aliases and unsupported status values.
 *
 * @param {unknown} status
 * @returns {"inactive"|"active"|"finished"|"error"}
 */
const resolveStatus = (status) => {
    if (typeof status !== "string") {
        return "active";
    }

    const requestedStatus = STATUS_ALIASES[status] ?? status;

    return isInlineLoadingStatus(requestedStatus) ? requestedStatus : "active";
};

/**
 * Resolve an Inline Loading component from an element or selector.
 *
 * @param {Element|string} target
 * @returns {HTMLElement|null}
 */
const resolveInlineLoadingElement = (target) => {
    if (target instanceof HTMLElement) {
        if (target.matches(SELECTORS.component)) {
            return target;
        }

        const component = target.querySelector(SELECTORS.component);

        return component instanceof HTMLElement ? component : null;
    }

    if (typeof target !== "string") {
        return null;
    }

    const element = document.querySelector(target);

    if (!(element instanceof HTMLElement)) {
        return null;
    }

    if (element.matches(SELECTORS.component)) {
        return element;
    }

    const component = element.querySelector(SELECTORS.component);

    return component instanceof HTMLElement ? component : null;
};

/**
 * Clear a pending success timer.
 *
 * @param {HTMLElement} component
 * @returns {void}
 */
const clearSuccessTimer = (component) => {
    const timer = successTimers.get(component);

    if (timer === undefined) {
        return;
    }

    window.clearTimeout(timer);
    successTimers.delete(component);
};

/**
 * Resolve the configured success delay.
 *
 * @param {HTMLElement} component
 * @returns {number}
 */
const resolveSuccessDelay = (component) => {
    const configuredDelay = Number.parseInt(
        component.dataset.uiInlineLoadingSuccessDelay ?? "",
        10,
    );

    if (!Number.isFinite(configuredDelay) || configuredDelay < 0) {
        return DEFAULT_SUCCESS_DELAY;
    }

    return configuredDelay;
};

/**
 * Update accessible labels for finished and error status icons.
 *
 * @param {HTMLElement} component
 * @param {"inactive"|"active"|"finished"|"error"} status
 * @param {string|null} iconDescription
 * @returns {void}
 */
const updateIconDescriptions = (component, status, iconDescription) => {
    component
        .querySelectorAll('[data-ui-inline-loading-indicator="finished"]')
        .forEach((indicator) => {
            indicator.setAttribute(
                "aria-label",
                status === "finished" && iconDescription
                    ? iconDescription
                    : "finished",
            );
        });

    component
        .querySelectorAll('[data-ui-inline-loading-indicator="error"]')
        .forEach((indicator) => {
            indicator.setAttribute(
                "aria-label",
                status === "error" && iconDescription
                    ? iconDescription
                    : "error",
            );
        });

    const loading = component.querySelector(
        '[data-ui-inline-loading-indicator="active"] [data-ui-loading]',
    );
    const loadingSvg = loading?.querySelector("svg");
    const loadingTitle = loadingSvg?.querySelector("title");

    if (!(loadingSvg instanceof SVGElement)) {
        return;
    }

    const loadingDescription =
        status === "active" && iconDescription ? iconDescription : "loading";

    loadingSvg.setAttribute("aria-label", loadingDescription);

    if (loadingTitle) {
        loadingTitle.textContent = loadingDescription;
    }
};

/**
 * Schedule Carbon-equivalent delayed success behavior.
 *
 * @param {HTMLElement} component
 * @returns {void}
 */
const scheduleSuccess = (component) => {
    clearSuccessTimer(component);

    const timer = window.setTimeout(() => {
        successTimers.delete(component);

        component.dispatchEvent(
            new CustomEvent("ui:inline-loading-success", {
                bubbles: true,
                detail: {
                    status: "finished",
                },
            }),
        );
    }, resolveSuccessDelay(component));

    successTimers.set(component, timer);
};

/**
 * Apply an Inline Loading status.
 *
 * @param {HTMLElement} component
 * @param {"inactive"|"active"|"finished"|"error"} status
 * @param {{emit?: boolean, iconDescription?: string|null}} options
 * @returns {void}
 */
const applyStatus = (
    component,
    status,
    { emit = true, iconDescription = null } = {},
) => {
    clearSuccessTimer(component);

    const animation = component.querySelector(SELECTORS.animation);

    if (animation instanceof HTMLElement) {
        animation.hidden = status === "inactive";
    }

    component.querySelectorAll(SELECTORS.indicator).forEach((indicator) => {
        if (!(indicator instanceof HTMLElement)) {
            return;
        }

        indicator.hidden =
            indicator.dataset.uiInlineLoadingIndicator !== status;
    });

    component.dataset.uiInlineLoadingStatus = status;
    component.setAttribute(
        "aria-live",
        status === "inactive" ? "off" : "assertive",
    );

    updateIconDescriptions(component, status, iconDescription);

    if (status === "finished") {
        scheduleSuccess(component);
    }

    if (!emit) {
        return;
    }

    component.dispatchEvent(
        new CustomEvent("ui:inline-loading-change", {
            bubbles: true,
            detail: {
                status,
            },
        }),
    );
};

/**
 * Set the status of an Inline Loading component.
 *
 * @param {Element|string} target
 * @param {string} status
 * @param {{iconDescription?: string|null}} options
 * @returns {boolean}
 */
export const setInlineLoadingStatus = (
    target,
    status,
    { iconDescription = null } = {},
) => {
    const component = resolveInlineLoadingElement(target);

    if (!component) {
        return false;
    }

    applyStatus(component, resolveStatus(status), {
        iconDescription,
    });

    return true;
};

/**
 * Initialize Inline Loading components within a DOM root.
 *
 * @param {ParentNode} root
 * @returns {void}
 */
export const initInlineLoading = (root = document) => {
    root.querySelectorAll(SELECTORS.component).forEach((component) => {
        if (!(component instanceof HTMLElement)) {
            return;
        }

        if (component.dataset.uiInlineLoadingInitialized === "true") {
            return;
        }

        component.dataset.uiInlineLoadingInitialized = "true";

        applyStatus(
            component,
            resolveStatus(component.dataset.uiInlineLoadingStatus),
            {
                emit: false,
            },
        );
    });
};
