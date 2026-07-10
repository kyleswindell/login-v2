/**
 * File: resources/js/ui-controls/internal/keyboard.js
 * Purpose: Shared keyboard event helpers for UI controllers.
 *
 * Notes:
 * - Framework-neutral equivalent of Carbon's internal keyboard helpers.
 * - Supports modern event.key plus legacy which/keyCode/code matching.
 * - Exports tabbable/focusable selectors used by focus helpers and overlay
 *   controllers.
 * - Does not bind events by itself.
 */

/* --------------------------------------------------------------------------
   Key definitions
   -------------------------------------------------------------------------- */

export const KEY = Object.freeze({
    TAB: {
        key: "Tab",
        which: 9,
        keyCode: 9,
        code: "Tab",
    },

    ENTER: {
        key: "Enter",
        which: 13,
        keyCode: 13,
        code: "Enter",
    },

    ESCAPE: {
        key: ["Escape", "Esc"],
        which: 27,
        keyCode: 27,
        code: "Escape",
        legacyCode: "Esc",
    },

    SPACE: {
        key: [" ", "Spacebar"],
        which: 32,
        keyCode: 32,
        code: "Space",
    },

    PAGE_UP: {
        key: "PageUp",
        which: 33,
        keyCode: 33,
        code: "PageUp",
        legacyCode: "Numpad9",
    },

    PAGE_DOWN: {
        key: "PageDown",
        which: 34,
        keyCode: 34,
        code: "PageDown",
        legacyCode: "Numpad3",
    },

    END: {
        key: "End",
        which: 35,
        keyCode: 35,
        code: "End",
        legacyCode: "Numpad1",
    },

    HOME: {
        key: "Home",
        which: 36,
        keyCode: 36,
        code: "Home",
        legacyCode: "Numpad7",
    },

    ARROW_LEFT: {
        key: "ArrowLeft",
        which: 37,
        keyCode: 37,
        code: "ArrowLeft",
    },

    ARROW_UP: {
        key: "ArrowUp",
        which: 38,
        keyCode: 38,
        code: "ArrowUp",
    },

    ARROW_RIGHT: {
        key: "ArrowRight",
        which: 39,
        keyCode: 39,
        code: "ArrowRight",
    },

    ARROW_DOWN: {
        key: "ArrowDown",
        which: 40,
        keyCode: 40,
        code: "ArrowDown",
    },

    BACKSPACE: {
        key: "Backspace",
        which: 8,
        keyCode: 8,
        code: "Backspace",
    },

    DELETE: {
        key: "Delete",
        which: 46,
        keyCode: 46,
        code: "Delete",
    },
});

/* --------------------------------------------------------------------------
   Focus selectors
   -------------------------------------------------------------------------- */

export const selectorTabbable = [
    "a[href]",
    "area[href]",
    "input:not([disabled]):not([type='hidden']):not([tabindex='-1'])",
    "button:not([disabled]):not([tabindex='-1'])",
    "select:not([disabled]):not([tabindex='-1'])",
    "textarea:not([disabled]):not([tabindex='-1'])",
    "iframe",
    "object",
    "embed",
    "[tabindex]:not([tabindex='-1']):not([disabled])",
    "[contenteditable='true']",
].join(",");

export const selectorFocusable = [
    "a[href]",
    "area[href]",
    "input:not([disabled]):not([type='hidden'])",
    "button:not([disabled])",
    "select:not([disabled])",
    "textarea:not([disabled])",
    "iframe",
    "object",
    "embed",
    "[tabindex]:not([disabled])",
    "[contenteditable='true']",
].join(",");

/* --------------------------------------------------------------------------
   Key matching
   -------------------------------------------------------------------------- */

export function match(eventOrCode, keyDefinition) {
    if (!keyDefinition) {
        return false;
    }

    const { key, which, keyCode, code, legacyCode } = keyDefinition;

    if (typeof eventOrCode === "string") {
        if (Array.isArray(key)) {
            return key.includes(eventOrCode);
        }

        return (
            eventOrCode === key ||
            eventOrCode === code ||
            eventOrCode === legacyCode
        );
    }

    if (typeof eventOrCode === "number") {
        return eventOrCode === which || eventOrCode === keyCode;
    }

    if (!eventOrCode || typeof eventOrCode !== "object") {
        return false;
    }

    if (eventOrCode.key && Array.isArray(key)) {
        return key.includes(eventOrCode.key);
    }

    return (
        eventOrCode.key === key ||
        eventOrCode.which === which ||
        eventOrCode.keyCode === keyCode ||
        eventOrCode.code === code ||
        eventOrCode.code === legacyCode
    );
}

export function matches(eventOrCode, keyDefinitions) {
    const definitions = Array.isArray(keyDefinitions)
        ? keyDefinitions
        : [keyDefinitions];

    return definitions.some((keyDefinition) =>
        match(eventOrCode, keyDefinition),
    );
}

/* --------------------------------------------------------------------------
   Common key helpers
   -------------------------------------------------------------------------- */

export function isTabKey(event) {
    return match(event, KEY.TAB);
}

export function isEnterKey(event) {
    return match(event, KEY.ENTER);
}

export function isEscapeKey(event) {
    return match(event, KEY.ESCAPE);
}

export function isSpaceKey(event) {
    return match(event, KEY.SPACE);
}

export function isHomeKey(event) {
    return match(event, KEY.HOME);
}

export function isEndKey(event) {
    return match(event, KEY.END);
}

export function isPageUpKey(event) {
    return match(event, KEY.PAGE_UP);
}

export function isPageDownKey(event) {
    return match(event, KEY.PAGE_DOWN);
}

export function isArrowLeftKey(event) {
    return match(event, KEY.ARROW_LEFT);
}

export function isArrowRightKey(event) {
    return match(event, KEY.ARROW_RIGHT);
}

export function isArrowUpKey(event) {
    return match(event, KEY.ARROW_UP);
}

export function isArrowDownKey(event) {
    return match(event, KEY.ARROW_DOWN);
}

export function isArrowKey(event) {
    return matches(event, [
        KEY.ARROW_LEFT,
        KEY.ARROW_RIGHT,
        KEY.ARROW_UP,
        KEY.ARROW_DOWN,
    ]);
}

export function isActivationKey(event) {
    return isEnterKey(event) || isSpaceKey(event);
}

export function hasModifierKey(event) {
    return Boolean(
        event?.altKey || event?.ctrlKey || event?.metaKey || event?.shiftKey,
    );
}

export function isPlainKey(event, keyDefinitions) {
    return !hasModifierKey(event) && matches(event, keyDefinitions);
}

/* --------------------------------------------------------------------------
   Navigation helpers
   -------------------------------------------------------------------------- */

export function getNextIndex(eventOrCode, index, arrayLength) {
    if (
        !Number.isInteger(index) ||
        !Number.isInteger(arrayLength) ||
        arrayLength <= 0
    ) {
        return undefined;
    }

    if (match(eventOrCode, KEY.ARROW_RIGHT)) {
        return (index + 1) % arrayLength;
    }

    if (match(eventOrCode, KEY.ARROW_LEFT)) {
        return (index + arrayLength - 1) % arrayLength;
    }

    return undefined;
}

export function getNextVerticalIndex(eventOrCode, index, arrayLength) {
    if (
        !Number.isInteger(index) ||
        !Number.isInteger(arrayLength) ||
        arrayLength <= 0
    ) {
        return undefined;
    }

    if (match(eventOrCode, KEY.ARROW_DOWN)) {
        return (index + 1) % arrayLength;
    }

    if (match(eventOrCode, KEY.ARROW_UP)) {
        return (index + arrayLength - 1) % arrayLength;
    }

    return undefined;
}
