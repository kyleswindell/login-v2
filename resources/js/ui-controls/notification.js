/**
 * File: resources/js/ui-controls/notification.js
 * Purpose: Notification behavior for app-owned UI notification components.
 *
 * Source behavior:
 * - Mirrors Carbon notification interaction behavior for dismissible toast,
 *   inline, actionable, and callout/static notification structures.
 * - Blade components own rendered structure and CSS classes.
 * - This file owns close-button dismissal, optional timeout dismissal,
 *   Escape-to-close behavior for actionable notifications, and focus handling
 *   for alertdialog-style actionable notifications.
 *
 * Supported hooks:
 * - data-ui-notification
 * - data-ui-notification-close
 * - data-ui-notification-timeout
 * - data-ui-notification-close-on-escape
 */

const NOTIFICATION_SELECTOR = "[data-ui-notification]";
const NOTIFICATION_CLOSE_SELECTOR = "[data-ui-notification-close]";
const NOTIFICATION_BOUND_ATTR = "data-ui-notification-bound";
const NOTIFICATION_CLOSE_BOUND_ATTR = "data-ui-notification-close-bound";

/* --------------------------------------------------------------------------
   Focus handling
   -------------------------------------------------------------------------- */

/**
 * Carbon focuses the actionable notification action button when the notification
 * is rendered as alertdialog. This helper keeps that behavior opt-in through
 * the rendered role.
 */
function focusActionableNotification(notification) {
    if (notification.getAttribute("role") !== "alertdialog") {
        return;
    }

    const actionButton = notification.querySelector(
        ".ui-actionable-notification__action-button",
    );

    if (actionButton instanceof HTMLElement) {
        window.requestAnimationFrame(() => {
            actionButton.focus();
        });
    }
}

/**
 * Carbon wraps focus for actionable alertdialog notifications. This gives the
 * same practical keyboard containment without adding sentinel nodes in Blade.
 */
function trapActionableNotificationFocus(notification, event) {
    if (
        notification.getAttribute("role") !== "alertdialog" ||
        event.key !== "Tab"
    ) {
        return;
    }

    const focusableElements = Array.from(
        notification.querySelectorAll(
            [
                "a[href]",
                "button:not([disabled])",
                "textarea:not([disabled])",
                "input:not([disabled])",
                "select:not([disabled])",
                "[tabindex]:not([tabindex='-1'])",
            ].join(","),
        ),
    ).filter((element) => element instanceof HTMLElement);

    if (!focusableElements.length) {
        return;
    }

    const firstFocusable = focusableElements[0];
    const lastFocusable = focusableElements[focusableElements.length - 1];

    if (event.shiftKey && document.activeElement === firstFocusable) {
        event.preventDefault();
        lastFocusable.focus();
        return;
    }

    if (!event.shiftKey && document.activeElement === lastFocusable) {
        event.preventDefault();
        firstFocusable.focus();
    }
}

/* --------------------------------------------------------------------------
   State helpers
   -------------------------------------------------------------------------- */

function getNotificationType(notification) {
    return notification.dataset.uiNotificationType || "inline";
}

function isToastNotification(notification) {
    return (
        getNotificationType(notification) === "toast" ||
        notification.hasAttribute("data-ui-notification-toast") ||
        notification.dataset.uiNotificationToast === "true"
    );
}

function canCloseOnEscape(notification) {
    return notification.dataset.uiNotificationCloseOnEscape !== "false";
}

function dispatchNotificationEvent(
    notification,
    eventName,
    originalEvent = null,
) {
    return notification.dispatchEvent(
        new CustomEvent(eventName, {
            bubbles: true,
            cancelable: true,
            detail: {
                notification,
                notificationType: getNotificationType(notification),
                originalEvent,
            },
        }),
    );
}

export function closeNotification(notification, originalEvent = null) {
    if (!(notification instanceof HTMLElement)) {
        return;
    }

    const shouldClose = dispatchNotificationEvent(
        notification,
        "ui-notification:before-close",
        originalEvent,
    );

    if (!shouldClose) {
        return;
    }

    notification.dataset.uiNotificationOpen = "false";

    if (isToastNotification(notification)) {
        dismissToast(notification);

        dispatchNotificationEvent(
            notification,
            "ui-notification:close",
            originalEvent,
        );

        return;
    }

    notification.hidden = true;

    dispatchNotificationEvent(
        notification,
        "ui-notification:close",
        originalEvent,
    );
}

/* --------------------------------------------------------------------------
   Close buttons
   -------------------------------------------------------------------------- */

function bindNotificationCloseButtons(notification) {
    notification
        .querySelectorAll(NOTIFICATION_CLOSE_SELECTOR)
        .forEach((closeButton) => {
            if (!(closeButton instanceof HTMLElement)) {
                return;
            }

            if (closeButton.hasAttribute(NOTIFICATION_CLOSE_BOUND_ATTR)) {
                return;
            }

            closeButton.setAttribute(NOTIFICATION_CLOSE_BOUND_ATTR, "true");

            closeButton.addEventListener("click", (event) => {
                event.preventDefault();

                dispatchNotificationEvent(
                    notification,
                    "ui-notification:close-button-click",
                    event,
                );

                closeNotification(notification, event);
            });
        });
}

/* --------------------------------------------------------------------------
   Timeout dismissal
   -------------------------------------------------------------------------- */

function bindNotificationTimeout(notification) {
    const timeoutValue = notification.dataset.uiNotificationTimeout;

    if (!timeoutValue) {
        return;
    }

    const timeout = Number.parseInt(timeoutValue, 10);

    if (!Number.isFinite(timeout) || timeout <= 0) {
        return;
    }

    window.setTimeout(() => {
        closeNotification(notification);
    }, timeout);
}

/* --------------------------------------------------------------------------
   Keyboard behavior
   -------------------------------------------------------------------------- */

function bindNotificationKeyboard(notification) {
    notification.addEventListener("keydown", (event) => {
        trapActionableNotificationFocus(notification, event);

        if (event.key !== "Escape") {
            return;
        }

        if (!canCloseOnEscape(notification)) {
            return;
        }

        if (!notification.contains(document.activeElement)) {
            return;
        }

        closeNotification(notification, event);
    });
}

/* ==========================================================================
   Toast notification motion
   ========================================================================== */

const TOAST_SELECTOR = "[data-ui-notification-toast]";
const TOAST_CONTAINER_SELECTOR = "[data-notification-toast-container]";

const TOAST_EXIT_FALLBACK_MS = 320;
const TOAST_SHIFT_FALLBACK_MS = 320;

const setToastState = (toast, state) => {
    toast.dataset.uiToastState = state;
};

const shouldReduceToastMotion = () =>
    window.matchMedia?.("(prefers-reduced-motion: reduce)")?.matches === true;

const getToastStackItems = (container) =>
    Array.from(container.querySelectorAll(TOAST_SELECTOR)).filter(
        (toast) => toast instanceof HTMLElement,
    );

const isToastStackShiftCandidate = (toast) =>
    toast instanceof HTMLElement &&
    toast.dataset.uiToastState !== "exiting" &&
    !toast.hidden;

const captureToastRects = (container, exclude = new Set()) => {
    const rects = new Map();

    if (!(container instanceof HTMLElement)) {
        return rects;
    }

    getToastStackItems(container).forEach((toast) => {
        if (exclude.has(toast) || !isToastStackShiftCandidate(toast)) {
            return;
        }

        rects.set(toast, toast.getBoundingClientRect());
    });

    return rects;
};

const restoreToastTransition = (toast, transition) => {
    if (transition) {
        toast.style.transition = transition;
        return;
    }

    toast.style.removeProperty("transition");
};

const cleanupToastStackShift = (toast) => {
    toast.style.removeProperty("--ui-toast-motion-y");
    toast.style.removeProperty("transition");
    delete toast.dataset.uiToastStackMotion;
};

const animateToastStackShift = (container, firstRects, exclude = new Set()) => {
    if (
        !(container instanceof HTMLElement) ||
        !(firstRects instanceof Map) ||
        shouldReduceToastMotion()
    ) {
        return;
    }

    const shiftedToasts = [];

    getToastStackItems(container).forEach((toast) => {
        if (exclude.has(toast) || !isToastStackShiftCandidate(toast)) {
            return;
        }

        const firstRect = firstRects.get(toast);

        if (!firstRect) {
            return;
        }

        const lastRect = toast.getBoundingClientRect();
        const deltaY = firstRect.top - lastRect.top;

        if (Math.abs(deltaY) < 1) {
            return;
        }

        const previousTransition = toast.style.transition;

        toast.dataset.uiToastStackMotion = "preparing";
        toast.style.transition = "none";
        toast.style.setProperty("--ui-toast-motion-y", `${deltaY}px`);

        /**
         * Force the inverted transform to apply before transitioning it back
         * to zero. This is the FLIP "invert" step.
         */
        toast.getBoundingClientRect();

        shiftedToasts.push({
            toast,
            previousTransition,
        });
    });

    if (!shiftedToasts.length) {
        return;
    }

    window.requestAnimationFrame(() => {
        shiftedToasts.forEach(({ toast, previousTransition }) => {
            let cleaned = false;

            const cleanup = (event = null) => {
                if (cleaned) {
                    return;
                }

                if (event && event.target !== toast) {
                    return;
                }

                if (event && event.propertyName !== "transform") {
                    return;
                }

                cleaned = true;
                toast.removeEventListener("transitionend", cleanup);
                cleanupToastStackShift(toast);
            };

            toast.dataset.uiToastStackMotion = "moving";
            restoreToastTransition(toast, previousTransition);
            toast.addEventListener("transitionend", cleanup);
            toast.style.setProperty("--ui-toast-motion-y", "0px");

            window.setTimeout(cleanup, TOAST_SHIFT_FALLBACK_MS);
        });
    });
};

export const animateToastIn = (toast) => {
    if (!(toast instanceof HTMLElement)) {
        return;
    }

    toast.dataset.uiNotificationToast = "true";
    toast.style.setProperty("--ui-toast-motion-y", "0px");
    setToastState(toast, "entering");

    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            setToastState(toast, "open");
        });
    });
};

export const dismissToast = (toast) => {
    if (!(toast instanceof HTMLElement)) {
        return;
    }

    if (toast.dataset.uiToastState === "exiting") {
        return;
    }

    const container =
        toast.parentElement instanceof HTMLElement ? toast.parentElement : null;

    setToastState(toast, "exiting");

    let removed = false;

    const removeToast = () => {
        if (removed) {
            return;
        }

        removed = true;

        const firstRects = container
            ? captureToastRects(container, new Set([toast]))
            : new Map();

        toast.remove();

        if (container) {
            animateToastStackShift(container, firstRects);
        }
    };

    toast.addEventListener(
        "transitionend",
        (event) => {
            if (event.target !== toast || event.propertyName !== "transform") {
                return;
            }

            removeToast();
        },
        { once: true },
    );

    window.setTimeout(removeToast, TOAST_EXIT_FALLBACK_MS);
};

export const prependToast = (container, toast) => {
    if (
        !(container instanceof HTMLElement) ||
        !(toast instanceof HTMLElement)
    ) {
        return;
    }

    const firstRects = captureToastRects(container);

    toast.dataset.uiNotificationToast = "true";
    toast.dataset.uiToastState = "entering";

    container.prepend(toast);
    animateToastIn(toast);
    animateToastStackShift(container, firstRects, new Set([toast]));
};

export function initNotificationToasts(root = document) {
    root.querySelectorAll(TOAST_SELECTOR).forEach((toast) => {
        if (!(toast instanceof HTMLElement)) {
            return;
        }

        if (toast.dataset.uiToastMotionInitialized === "true") {
            return;
        }

        toast.dataset.uiToastMotionInitialized = "true";

        if (!toast.dataset.uiToastState) {
            animateToastIn(toast);
        }
    });
}

export const getToastContainer = () =>
    document.querySelector(TOAST_CONTAINER_SELECTOR);

/* --------------------------------------------------------------------------
   Instance binding
   -------------------------------------------------------------------------- */

function initNotification(notification) {
    if (!(notification instanceof HTMLElement)) {
        return;
    }

    if (notification.hasAttribute(NOTIFICATION_BOUND_ATTR)) {
        return;
    }

    notification.setAttribute(NOTIFICATION_BOUND_ATTR, "true");
    notification.dataset.uiNotificationOpen = "true";

    bindNotificationCloseButtons(notification);
    bindNotificationTimeout(notification);
    bindNotificationKeyboard(notification);
    focusActionableNotification(notification);
}

/* --------------------------------------------------------------------------
   Initializer
   -------------------------------------------------------------------------- */

export function initNotifications(root = document) {
    root.querySelectorAll(NOTIFICATION_SELECTOR).forEach(initNotification);
    initNotificationToasts(root);
}
