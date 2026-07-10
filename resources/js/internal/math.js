/**
 * File: resources/js/ui-controls/internal/math.js
 * Purpose: Shared numeric helpers for UI controllers.
 *
 * Notes:
 * - Framework-neutral helper surface inspired by Carbon internals.
 * - Keep this file limited to small deterministic numeric helpers.
 */

export function clamp(value, min, max) {
    const numericValue = Number(value);
    const numericMin = Number(min);
    const numericMax = Number(max);

    if (!Number.isFinite(numericValue)) {
        return Number.isFinite(numericMin) ? numericMin : 0;
    }

    if (!Number.isFinite(numericMin) || !Number.isFinite(numericMax)) {
        return numericValue;
    }

    if (numericMax < numericMin) {
        return numericMin;
    }

    return Math.min(numericMax, Math.max(numericMin, numericValue));
}

export function roundToPixel(value) {
    return Math.round(Number(value) || 0);
}
