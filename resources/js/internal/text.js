/**
 * File: resources/js/ui-controls/internal/text.js
 * Purpose: Shared text normalization helpers for UI controllers.
 *
 * Notes:
 * - Intended for option/item components such as listbox, combo box,
 *   searchable select, and multi-select.
 */

export function defaultItemToString(item) {
    if (typeof item === "string") {
        return item;
    }

    if (typeof item === "number") {
        return String(item);
    }

    if (item && typeof item === "object" && typeof item.label === "string") {
        return item.label;
    }

    if (item && typeof item === "object" && typeof item.text === "string") {
        return item.text;
    }

    if (item && typeof item === "object" && typeof item.value === "string") {
        return item.value;
    }

    return "";
}

export function hasText(value) {
    return typeof value === "string" && value.trim() !== "";
}

export function hasHelperText(value) {
    return value !== undefined && value !== null && String(value).trim() !== "";
}
