/**
 * File: resources/js/ui-controls/internal/resize.js
 * Purpose: Shared ResizeObserver helpers for UI controllers.
 *
 * Notes:
 * - Provides vanilla DOM resize observation inspired by Carbon's
 *   useResizeObserver hook.
 * - Does not depend on React.
 * - Returns cleanup functions for controller-owned lifecycle management.
 */

/* --------------------------------------------------------------------------
   Size helpers
   -------------------------------------------------------------------------- */

export function getContentBoxSize(element) {
    if (!(element instanceof HTMLElement)) {
        return {
            width: 0,
            height: 0,
        };
    }

    const styles = window.getComputedStyle(element);

    const paddingInline =
        parseFloat(styles.paddingLeft || "0") +
        parseFloat(styles.paddingRight || "0");

    const paddingBlock =
        parseFloat(styles.paddingTop || "0") +
        parseFloat(styles.paddingBottom || "0");

    return {
        width: Math.max(0, element.offsetWidth - paddingInline),
        height: Math.max(0, element.offsetHeight - paddingBlock),
    };
}

/* --------------------------------------------------------------------------
   Resize observation
   -------------------------------------------------------------------------- */

export function observeResize(element, callback, options = {}) {
    if (!(element instanceof HTMLElement) || typeof callback !== "function") {
        return () => {};
    }

    const { initial = true } = options;

    let frame = null;

    const invoke = (rect) => {
        if (frame !== null) {
            window.cancelAnimationFrame(frame);
        }

        frame = window.requestAnimationFrame(() => {
            frame = null;
            callback(rect, element);
        });
    };

    if (initial) {
        invoke(getContentBoxSize(element));
    }

    if (typeof ResizeObserver === "undefined") {
        const handleWindowResize = () => {
            invoke(getContentBoxSize(element));
        };

        window.addEventListener("resize", handleWindowResize);

        return () => {
            if (frame !== null) {
                window.cancelAnimationFrame(frame);
            }

            window.removeEventListener("resize", handleWindowResize);
        };
    }

    const observer = new ResizeObserver((entries) => {
        const entry = entries[0];

        if (!entry) {
            return;
        }

        invoke(entry.contentRect);
    });

    observer.observe(element);

    return () => {
        if (frame !== null) {
            window.cancelAnimationFrame(frame);
        }

        observer.disconnect();
    };
}

export function observeResizeOnce(element, callback) {
    let cleanup = () => {};

    cleanup = observeResize(
        element,
        (rect, observedElement) => {
            cleanup();
            callback(rect, observedElement);
        },
        {
            initial: false,
        },
    );

    return cleanup;
}
