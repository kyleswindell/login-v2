/**
 * File: resources/js/ui-controls/app-header-search.js
 * Purpose: App header global search behavior.
 *
 * Notes:
 * - This controls the app-specific header search composition.
 * - The base x-ui.search component remains separate for normal search fields.
 * - Search opens inline inside the header, not in a shell header panel.
 */

const SEARCH_SELECTOR = "[data-app-header-search]";
const TRIGGER_SELECTOR = "[data-app-header-search-trigger]";
const INPUT_SELECTOR = "[data-app-header-search-input]";
const CLOSE_SELECTOR = "[data-app-header-search-close]";
const RESULTS_SELECTOR = "[data-app-header-search-results]";
const BOUND_ATTR = "data-app-header-search-bound";

function setExpanded(search, expanded, { focusInput = false } = {}) {
    const trigger = search.querySelector(TRIGGER_SELECTOR);
    const input = search.querySelector(INPUT_SELECTOR);
    const closeButton = search.querySelector(CLOSE_SELECTOR);

    search.dataset.appHeaderSearchExpanded = expanded ? "true" : "false";

    if (trigger instanceof HTMLElement) {
        trigger.setAttribute("aria-expanded", expanded ? "true" : "false");
        trigger.tabIndex = expanded ? -1 : 0;
    }

    if (input instanceof HTMLInputElement) {
        input.tabIndex = expanded ? 0 : -1;

        if (focusInput) {
            window.requestAnimationFrame(() => input.focus());
        }
    }

    if (closeButton instanceof HTMLElement) {
        closeButton.tabIndex = expanded ? 0 : -1;
    }
}

function closeSearch(search, { returnFocus = false } = {}) {
    const trigger = search.querySelector(TRIGGER_SELECTOR);
    const input = search.querySelector(INPUT_SELECTOR);
    const results = search.querySelector(RESULTS_SELECTOR);

    if (input instanceof HTMLInputElement) {
        input.value = "";
    }

    if (results instanceof HTMLElement) {
        results.hidden = true;
    }

    setExpanded(search, false);

    if (returnFocus && trigger instanceof HTMLElement) {
        window.requestAnimationFrame(() => trigger.focus());
    }
}

function bindSearch(search) {
    if (!(search instanceof HTMLElement)) {
        return;
    }

    if (search.hasAttribute(BOUND_ATTR)) {
        return;
    }

    search.setAttribute(BOUND_ATTR, "true");

    const trigger = search.querySelector(TRIGGER_SELECTOR);
    const input = search.querySelector(INPUT_SELECTOR);
    const closeButton = search.querySelector(CLOSE_SELECTOR);

    if (trigger instanceof HTMLElement) {
        trigger.addEventListener("click", (event) => {
            event.preventDefault();
            setExpanded(search, true, { focusInput: true });
        });
    }

    if (closeButton instanceof HTMLElement) {
        closeButton.addEventListener("click", (event) => {
            event.preventDefault();
            closeSearch(search, { returnFocus: true });
        });
    }

    if (input instanceof HTMLInputElement) {
        input.addEventListener("keydown", (event) => {
            if (event.key !== "Escape") {
                return;
            }

            event.preventDefault();
            closeSearch(search, { returnFocus: true });
        });
    }

    setExpanded(search, search.dataset.appHeaderSearchExpanded === "true");
}

function bindGlobalDismiss() {
    if (
        document.documentElement.hasAttribute(
            "data-app-header-search-global-bound",
        )
    ) {
        return;
    }

    document.documentElement.setAttribute(
        "data-app-header-search-global-bound",
        "true",
    );

    document.addEventListener("click", (event) => {
        const target = event.target;

        if (!(target instanceof Node)) {
            return;
        }

        document.querySelectorAll(SEARCH_SELECTOR).forEach((search) => {
            if (!(search instanceof HTMLElement)) {
                return;
            }

            if (search.contains(target)) {
                return;
            }

            if (search.dataset.appHeaderSearchExpanded === "true") {
                closeSearch(search);
            }
        });
    });
}

export function initAppHeaderSearch(root = document) {
    root.querySelectorAll(SEARCH_SELECTOR).forEach(bindSearch);
    bindGlobalDismiss();
}
