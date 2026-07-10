/**
 * File: resources/js/ui-controls/internal/timing.js
 * Purpose: Shared timing helpers for UI controllers.
 *
 * Notes:
 * - Provides lightweight debounce/throttle/delay helpers without adding a
 *   runtime dependency.
 * - Controllers own when timing behavior should be used.
 */

export function debounce(callback, wait = 0) {
    let timeoutId = null;

    const debounced = (...args) => {
        window.clearTimeout(timeoutId);

        timeoutId = window.setTimeout(() => {
            timeoutId = null;
            callback(...args);
        }, wait);
    };

    debounced.cancel = () => {
        window.clearTimeout(timeoutId);
        timeoutId = null;
    };

    return debounced;
}

export function throttle(callback, wait = 0) {
    let timeoutId = null;
    let lastArgs = null;

    const run = () => {
        timeoutId = null;

        if (lastArgs) {
            const args = lastArgs;
            lastArgs = null;
            throttled(...args);
        }
    };

    const throttled = (...args) => {
        if (timeoutId !== null) {
            lastArgs = args;
            return;
        }

        callback(...args);
        timeoutId = window.setTimeout(run, wait);
    };

    throttled.cancel = () => {
        window.clearTimeout(timeoutId);
        timeoutId = null;
        lastArgs = null;
    };

    return throttled;
}

export function delay(callback, wait = 0) {
    const timeoutId = window.setTimeout(callback, wait);

    return () => {
        window.clearTimeout(timeoutId);
    };
}
