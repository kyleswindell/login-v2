/**
 * File: resources/js/ui-controls/internal/targets.js
 * Purpose: Shared target-resolution helpers for UI controllers.
 *
 * Notes:
 * - Resolves controlled elements from data attributes, aria-controls, or
 *   fragment href values.
 * - Does not bind events by itself.
 */

export function escapeSelectorValue(value) {
    const stringValue = String(value ?? "");

    if (window.CSS && typeof window.CSS.escape === "function") {
        return window.CSS.escape(stringValue);
    }

    return stringValue.replace(/["\\]/g, "\\$&");
}

export function normalizeTargetId(value) {
    if (typeof value !== "string") {
        return null;
    }

    const trimmed = value.trim();

    if (!trimmed) {
        return null;
    }

    return trimmed.startsWith("#") ? trimmed.slice(1) : trimmed;
}

export function getHashTargetId(value) {
    if (typeof value !== "string" || value.trim() === "") {
        return null;
    }

    const trimmed = value.trim();

    if (trimmed.startsWith("#")) {
        return normalizeTargetId(trimmed);
    }

    try {
        const url = new URL(trimmed, window.location.href);

        if (
            url.origin === window.location.origin &&
            url.pathname === window.location.pathname &&
            url.hash
        ) {
            return normalizeTargetId(url.hash);
        }
    } catch {
        return null;
    }

    return null;
}

export function getTargetIdFromTrigger(trigger, options = {}) {
    if (!(trigger instanceof Element)) {
        return null;
    }

    const dataAttributes = Array.isArray(options.dataAttributes)
        ? options.dataAttributes
        : [];

    for (const attribute of dataAttributes) {
        const value = trigger.getAttribute(attribute);

        if (value) {
            return normalizeTargetId(value);
        }
    }

    const ariaControls = trigger.getAttribute("aria-controls");

    if (ariaControls) {
        return normalizeTargetId(ariaControls);
    }

    return getHashTargetId(trigger.getAttribute("href"));
}

export function getElementByTargetId(targetId, options = {}) {
    const id = normalizeTargetId(targetId);

    if (!id) {
        return null;
    }

    const root = options.root || document;
    const selector = options.selector || null;

    const element =
        root === document
            ? document.getElementById(id)
            : root.querySelector(`#${escapeSelectorValue(id)}`);

    if (!(element instanceof HTMLElement)) {
        return null;
    }

    if (selector && !element.matches(selector)) {
        return null;
    }

    return element;
}

export function getControlledElementFromTrigger(trigger, options = {}) {
    const targetId = getTargetIdFromTrigger(trigger, options);

    return getElementByTargetId(targetId, options);
}
