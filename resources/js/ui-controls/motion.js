/**
 * File: resources/js/ui-controls/motion.js
 * Purpose: Shared motion lifecycle helpers.
 *
 * Notes:
 * - CSS owns motion presets, durations, distances, easing, and transforms.
 * - Runtime only initializes motion state, toggles data-ui-motion-state, and
 *   waits for transition / animation completion.
 * - Runtime must not calculate motion duration, distance, easing, size, or
 *   buckets.
 * - Collapse motion sets temporary block-size values because CSS cannot
 *   transition from auto block-size to 0.
 */

const MOTION_SELECTOR = "[data-ui-motion]";
const MOTION_STATE_ATTR = "data-ui-motion-state";
const BOUND_ATTR = "data-ui-motion-bound";

const DEFAULT_MOTION_TIMEOUT = 900;
const REDUCED_MOTION_TIMEOUT = 40;

const MOTION_STATES = {
    CLOSED: "closed",
    ENTERING: "entering",
    OPEN: "open",
    EXITING: "exiting",
};

/* --------------------------------------------------------------------------
   Guards
   -------------------------------------------------------------------------- */

function isHTMLElement(value) {
    return value instanceof HTMLElement;
}

function isMotionElement(element) {
    return isHTMLElement(element) && Boolean(element.dataset.uiMotion);
}

function prefersReducedMotion() {
    return window.matchMedia?.("(prefers-reduced-motion: reduce)")?.matches;
}

/* --------------------------------------------------------------------------
   Element lookup
   -------------------------------------------------------------------------- */

function getMotionElements(root = document) {
    const elements = [];

    if (isMotionElement(root)) {
        elements.push(root);
    }

    if (typeof root.querySelectorAll === "function") {
        root.querySelectorAll(MOTION_SELECTOR).forEach((element) => {
            if (isMotionElement(element)) {
                elements.push(element);
            }
        });
    }

    return elements;
}

/* --------------------------------------------------------------------------
   Frame / event helpers
   -------------------------------------------------------------------------- */

function nextFrame(callback) {
    window.requestAnimationFrame(() => {
        window.requestAnimationFrame(callback);
    });
}

function waitForMotionEnd(element, timeout = DEFAULT_MOTION_TIMEOUT) {
    if (!isHTMLElement(element)) {
        return Promise.resolve();
    }

    const resolvedTimeout = prefersReducedMotion()
        ? REDUCED_MOTION_TIMEOUT
        : timeout;

    return new Promise((resolve) => {
        let finished = false;

        const finish = () => {
            if (finished) {
                return;
            }

            finished = true;
            element.removeEventListener("transitionend", handleEnd);
            element.removeEventListener("animationend", handleEnd);
            resolve();
        };

        const handleEnd = (event) => {
            if (event.target !== element) {
                return;
            }

            finish();
        };

        element.addEventListener("transitionend", handleEnd);
        element.addEventListener("animationend", handleEnd);

        window.setTimeout(finish, resolvedTimeout);
    });
}

/* --------------------------------------------------------------------------
   State helpers
   -------------------------------------------------------------------------- */

export function setMotionState(element, state) {
    if (!isHTMLElement(element)) {
        return;
    }

    element.setAttribute(MOTION_STATE_ATTR, state);
}

export function clearMotionState(element) {
    if (!isHTMLElement(element)) {
        return;
    }

    element.removeAttribute(MOTION_STATE_ATTR);
}

export function getMotionState(element) {
    if (!isHTMLElement(element)) {
        return null;
    }

    return element.getAttribute(MOTION_STATE_ATTR);
}

function syncInitialMotionState(element) {
    if (!isMotionElement(element)) {
        return;
    }

    const currentState = getMotionState(element);

    if (currentState) {
        return;
    }

    setMotionState(
        element,
        element.hidden ? MOTION_STATES.CLOSED : MOTION_STATES.OPEN,
    );
}

function bindMotionElement(element) {
    if (!isMotionElement(element)) {
        return;
    }

    if (element.hasAttribute(BOUND_ATTR)) {
        syncInitialMotionState(element);
        return;
    }

    element.setAttribute(BOUND_ATTR, "true");
    syncInitialMotionState(element);
}

/* --------------------------------------------------------------------------
   Initializer
   -------------------------------------------------------------------------- */

export function initMotion(root = document) {
    getMotionElements(root).forEach(bindMotionElement);
}

/* --------------------------------------------------------------------------
   Enter / exit lifecycle
   -------------------------------------------------------------------------- */

export async function enterMotion(element, options = {}) {
    if (!isHTMLElement(element)) {
        return;
    }

    if (!isMotionElement(element)) {
        element.hidden = false;
        return;
    }

    element.hidden = false;
    setMotionState(element, MOTION_STATES.ENTERING);

    nextFrame(() => {
        setMotionState(element, MOTION_STATES.OPEN);
    });

    await waitForMotionEnd(element, options.timeout);
}

export async function exitMotion(element, options = {}) {
    if (!isHTMLElement(element)) {
        return;
    }

    if (!isMotionElement(element)) {
        if (options.hidden !== false) {
            element.hidden = true;
        }

        return;
    }

    setMotionState(element, MOTION_STATES.EXITING);

    await waitForMotionEnd(element, options.timeout);

    setMotionState(element, MOTION_STATES.CLOSED);

    if (options.hidden !== false) {
        element.hidden = true;
    }
}

export async function toggleMotion(element, open, options = {}) {
    if (open) {
        await enterMotion(element, options);
        return;
    }

    await exitMotion(element, options);
}

/* --------------------------------------------------------------------------
   Collapse lifecycle
   -------------------------------------------------------------------------- */

export async function collapseExitMotion(element, options = {}) {
    if (!isHTMLElement(element)) {
        return;
    }

    if (!isMotionElement(element)) {
        if (options.remove === true) {
            element.remove();
            return;
        }

        if (options.hidden !== false) {
            element.hidden = true;
        }

        return;
    }

    const height = element.getBoundingClientRect().height;

    if (height <= 0) {
        if (options.remove === true) {
            element.remove();
            return;
        }

        if (options.hidden !== false) {
            element.hidden = true;
        }

        setMotionState(element, MOTION_STATES.CLOSED);
        return;
    }

    element.style.blockSize = `${height}px`;
    element.style.minBlockSize = `${height}px`;
    element.style.maxBlockSize = `${height}px`;
    element.style.overflow = "hidden";

    element.getBoundingClientRect();

    setMotionState(element, MOTION_STATES.EXITING);

    nextFrame(() => {
        element.style.blockSize = "0px";
        element.style.minBlockSize = "0px";
        element.style.maxBlockSize = "0px";
    });

    await waitForMotionEnd(element, options.timeout);

    if (options.remove === true) {
        element.remove();
        return;
    }

    if (options.hidden !== false) {
        element.hidden = true;
    }

    setMotionState(element, MOTION_STATES.CLOSED);

    element.style.removeProperty("block-size");
    element.style.removeProperty("min-block-size");
    element.style.removeProperty("max-block-size");
    element.style.removeProperty("overflow");
}

/* --------------------------------------------------------------------------
   Restore lifecycle
   -------------------------------------------------------------------------- */

export function restoreMotionElement(element) {
    if (!isHTMLElement(element)) {
        return;
    }

    element.hidden = false;
    setMotionState(element, MOTION_STATES.OPEN);

    element.style.removeProperty("block-size");
    element.style.removeProperty("min-block-size");
    element.style.removeProperty("max-block-size");
    element.style.removeProperty("overflow");
}
