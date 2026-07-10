/**
 * File: resources/js/ui-controls/internal/warnings.js
 * Purpose: Development warning helper for UI controllers.
 *
 * Notes:
 * - Mirrors Carbon's warning(condition, message) convention.
 * - Warnings are suppressed in production builds.
 * - Do not use warnings for required runtime behavior.
 */

function isProduction() {
    if (typeof import.meta !== "undefined" && import.meta.env) {
        return Boolean(import.meta.env.PROD);
    }

    if (typeof process !== "undefined" && process.env) {
        return process.env.NODE_ENV === "production";
    }

    return false;
}

export function warning(condition, message) {
    if (isProduction()) {
        return;
    }

    if (typeof message === "undefined") {
        throw new Error(
            "`warning(condition, message)` requires a warning message.",
        );
    }

    if (!condition) {
        console.warn(`Warning: ${message}`);
    }
}

export const warn = warning;
