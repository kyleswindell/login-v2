/**
 * File: resources/js/ui-controls/pagination-nav.js
 * Purpose: Pagination navigation behavior for app-owned UI pagination nav.
 *
 * Source behavior:
 * - Mirrors the Carbon PaginationNav component's interaction layer.
 * - Blade owns initial markup and CSS classes.
 * - This file owns previous/next clicks, page button clicks, overflow select
 *   changes, active state, disabled direction buttons, live-region text, and
 *   page-change events.
 */

const PAGINATION_NAV_SELECTOR = "[data-ui-pagination-nav]";
const PAGINATION_NAV_BOUND_ATTR = "data-ui-pagination-nav-bound";

const PAGE_BUTTON_SELECTOR = "[data-ui-pagination-nav-page]";
const PREVIOUS_BUTTON_SELECTOR = "[data-ui-pagination-nav-previous]";
const NEXT_BUTTON_SELECTOR = "[data-ui-pagination-nav-next]";
const OVERFLOW_SELECTOR = "[data-ui-pagination-nav-overflow]";
const LIVE_REGION_SELECTOR = ".ui-pagination-nav__accessibility-label";

/* --------------------------------------------------------------------------
   State helpers
   -------------------------------------------------------------------------- */

function getCurrentPage(nav) {
    return Number.parseInt(nav.dataset.uiPaginationNavPage || "0", 10);
}

function getTotalItems(nav) {
    return Number.parseInt(nav.dataset.uiPaginationNavTotalItems || "0", 10);
}

function getLoop(nav) {
    return nav.dataset.uiPaginationNavLoop === "true";
}

function setCurrentPage(nav, pageIndex) {
    const totalItems = getTotalItems(nav);

    if (
        !Number.isFinite(pageIndex) ||
        pageIndex < 0 ||
        pageIndex >= totalItems
    ) {
        return;
    }

    nav.dataset.uiPaginationNavPage = String(pageIndex);

    updatePageButtons(nav, pageIndex);
    updateDirectionButtons(nav, pageIndex);
    updateLiveRegion(nav, pageIndex);

    nav.dispatchEvent(
        new CustomEvent("ui-pagination-nav:change", {
            bubbles: true,
            detail: {
                page: pageIndex,
                pageNumber: pageIndex + 1,
                totalItems,
            },
        }),
    );
}

/* --------------------------------------------------------------------------
   UI updates
   -------------------------------------------------------------------------- */

function updatePageButtons(nav, pageIndex) {
    nav.querySelectorAll(PAGE_BUTTON_SELECTOR).forEach((button) => {
        const buttonPageIndex = Number.parseInt(
            button.dataset.pageIndex || "",
            10,
        );

        const isActive = buttonPageIndex === pageIndex;

        button.classList.toggle("ui-pagination-nav__page--active", isActive);

        if (isActive) {
            button.setAttribute("aria-current", "page");
        } else {
            button.removeAttribute("aria-current");
        }
    });
}

function updateDirectionButtons(nav, pageIndex) {
    const totalItems = getTotalItems(nav);
    const loop = getLoop(nav);

    const previousButton = nav.querySelector(PREVIOUS_BUTTON_SELECTOR);
    const nextButton = nav.querySelector(NEXT_BUTTON_SELECTOR);

    if (previousButton instanceof HTMLButtonElement) {
        previousButton.disabled = !loop && pageIndex === 0;
    }

    if (nextButton instanceof HTMLButtonElement) {
        nextButton.disabled = !loop && pageIndex === totalItems - 1;
    }
}

function updateLiveRegion(nav, pageIndex) {
    const totalItems = getTotalItems(nav);
    const liveRegion = nav.querySelector(LIVE_REGION_SELECTOR);

    if (!liveRegion) {
        return;
    }

    liveRegion.textContent = `Page ${pageIndex + 1} of ${totalItems}`;
}

/* --------------------------------------------------------------------------
   Event binding
   -------------------------------------------------------------------------- */

function bindPageButtons(nav) {
    nav.querySelectorAll(PAGE_BUTTON_SELECTOR).forEach((button) => {
        button.addEventListener("click", () => {
            const pageIndex = Number.parseInt(
                button.dataset.pageIndex || "",
                10,
            );
            setCurrentPage(nav, pageIndex);
        });
    });
}

function bindDirectionButtons(nav) {
    const previousButton = nav.querySelector(PREVIOUS_BUTTON_SELECTOR);
    const nextButton = nav.querySelector(NEXT_BUTTON_SELECTOR);

    if (previousButton instanceof HTMLButtonElement) {
        previousButton.addEventListener("click", () => {
            const currentPage = getCurrentPage(nav);
            const totalItems = getTotalItems(nav);
            const loop = getLoop(nav);

            if (currentPage === 0 && loop) {
                setCurrentPage(nav, totalItems - 1);
                return;
            }

            setCurrentPage(nav, currentPage - 1);
        });
    }

    if (nextButton instanceof HTMLButtonElement) {
        nextButton.addEventListener("click", () => {
            const currentPage = getCurrentPage(nav);
            const totalItems = getTotalItems(nav);
            const loop = getLoop(nav);

            if (currentPage === totalItems - 1 && loop) {
                setCurrentPage(nav, 0);
                return;
            }

            setCurrentPage(nav, currentPage + 1);
        });
    }
}

function bindOverflowSelects(nav) {
    nav.querySelectorAll(OVERFLOW_SELECTOR).forEach((select) => {
        if (!(select instanceof HTMLSelectElement)) {
            return;
        }

        select.addEventListener("change", () => {
            const pageIndex = Number.parseInt(select.value, 10);

            if (Number.isFinite(pageIndex)) {
                setCurrentPage(nav, pageIndex);
            }

            select.value = "";
        });
    });
}

/* --------------------------------------------------------------------------
   Instance binding
   -------------------------------------------------------------------------- */

function initPaginationNavInstance(nav) {
    if (!(nav instanceof HTMLElement)) {
        return;
    }

    if (nav.hasAttribute(PAGINATION_NAV_BOUND_ATTR)) {
        return;
    }

    nav.setAttribute(PAGINATION_NAV_BOUND_ATTR, "true");

    bindPageButtons(nav);
    bindDirectionButtons(nav);
    bindOverflowSelects(nav);

    const currentPage = getCurrentPage(nav);

    updatePageButtons(nav, currentPage);
    updateDirectionButtons(nav, currentPage);
    updateLiveRegion(nav, currentPage);
}

/* --------------------------------------------------------------------------
   Initializer
   -------------------------------------------------------------------------- */

export function initPaginationNav(root = document) {
    root.querySelectorAll(PAGINATION_NAV_SELECTOR).forEach(
        initPaginationNavInstance,
    );
}
