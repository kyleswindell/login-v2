/**
 * File: resources/js/ui-controls/tabs.js
 * Purpose: Tabs interaction initializer.
 *
 * Notes:
 * - Owns array-driven x-ui.tabs interaction behavior.
 * - Supports automatic and manual activation.
 * - Syncs ARIA, tabindex, selected data attributes, selected classes, and
 *   hidden panel state.
 * - Does not own route/page navigation tabs.
 */

const TAB_ROOT_SELECTOR = "[data-ui-tabs]";
const TABLIST_SELECTOR = "[data-ui-tabs-list]";
const TAB_SELECTOR = "[data-ui-tabs-tab]";
const PANEL_SELECTOR = "[data-ui-tabs-panel]";
const DISMISS_SELECTOR = "[data-ui-tabs-dismiss], .ui-tabs-tab-dismiss";

const SELECTED_TAB_CLASSES = [
    "ui-tabs-tab-selected",
    "ui-tabs__nav-item--selected",
];

const DISABLED_TAB_CLASSES = [
    "ui-tabs-tab-disabled",
    "ui-tabs__nav-item--disabled",
];

const SELECTED_PANEL_CLASSES = ["ui-tabs-panel-selected"];

const enabledTabs = (tablist) =>
    Array.from(tablist.querySelectorAll(TAB_SELECTOR)).filter((tab) => {
        if (!(tab instanceof HTMLElement)) {
            return false;
        }

        return !tab.disabled && tab.getAttribute("aria-disabled") !== "true";
    });

const getPanelForTab = (root, tab) => {
    const panelId = tab.getAttribute("aria-controls");

    if (!panelId) {
        return null;
    }

    return root.querySelector(`#${CSS.escape(panelId)}`);
};

const setClasses = (element, classes, enabled) => {
    classes.forEach((className) => {
        element.classList.toggle(className, enabled);
    });
};

const syncTab = (tab, selected) => {
    tab.setAttribute("aria-selected", selected ? "true" : "false");
    tab.tabIndex = selected ? 0 : -1;
    tab.dataset.uiTabsTabSelected = selected ? "true" : "false";

    setClasses(tab, SELECTED_TAB_CLASSES, selected);

    const disabled =
        tab.disabled || tab.getAttribute("aria-disabled") === "true";

    tab.dataset.uiTabsTabDisabled = disabled ? "true" : "false";
    setClasses(tab, DISABLED_TAB_CLASSES, disabled);
};

const syncPanel = (panel, selected) => {
    panel.hidden = !selected;
    panel.setAttribute("aria-hidden", selected ? "false" : "true");
    panel.dataset.uiTabsPanelSelected = selected ? "true" : "false";

    setClasses(panel, SELECTED_PANEL_CLASSES, selected);
};

const selectTab = (root, tab) => {
    const tabs = Array.from(root.querySelectorAll(TAB_SELECTOR)).filter(
        (candidate) => candidate instanceof HTMLElement,
    );
    const panels = Array.from(root.querySelectorAll(PANEL_SELECTOR)).filter(
        (panel) => panel instanceof HTMLElement,
    );

    tabs.forEach((candidate, index) => {
        const selected = candidate === tab;

        syncTab(candidate, selected);

        if (selected) {
            root.dataset.uiTabsSelectedIndex = String(index);
        }
    });

    panels.forEach((panel) => {
        syncPanel(panel, panel.id === tab.getAttribute("aria-controls"));
    });
};

const nextEnabledTab = (tabs, current, direction) => {
    if (tabs.length === 0) {
        return current;
    }

    const currentIndex = tabs.indexOf(current);
    const safeCurrentIndex = currentIndex === -1 ? 0 : currentIndex;
    const nextIndex =
        (safeCurrentIndex + direction + tabs.length) % tabs.length;

    return tabs[nextIndex] ?? current;
};

const firstEnabledTab = (tabs, fallback = null) => tabs[0] ?? fallback;

const lastEnabledTab = (tabs, fallback = null) =>
    tabs[tabs.length - 1] ?? fallback;

const orientationFor = (tablist) =>
    tablist.getAttribute("aria-orientation") === "vertical"
        ? "vertical"
        : "horizontal";

const isArrowForOrientation = (event, orientation) => {
    if (orientation === "vertical") {
        return event.key === "ArrowDown" || event.key === "ArrowUp";
    }

    return event.key === "ArrowRight" || event.key === "ArrowLeft";
};

const directionForKey = (key) => {
    if (key === "ArrowRight" || key === "ArrowDown") {
        return 1;
    }

    if (key === "ArrowLeft" || key === "ArrowUp") {
        return -1;
    }

    return 0;
};

const removeTab = (root, tablist, tab) => {
    const tabs = enabledTabs(tablist);
    const selected = tab.getAttribute("aria-selected") === "true";
    const currentIndex = tabs.indexOf(tab);
    const panel = getPanelForTab(root, tab);
    const fallback =
        currentIndex === tabs.length - 1
            ? nextEnabledTab(tabs, tab, -1)
            : nextEnabledTab(tabs, tab, 1);

    panel?.remove();
    tab.remove();

    if (selected && fallback && fallback !== tab && fallback.isConnected) {
        selectTab(root, fallback);
        fallback.focus();
    }
};

const initializeRootState = (root, tablist) => {
    const tabs = enabledTabs(tablist);
    const selected = tabs.find(
        (tab) => tab.getAttribute("aria-selected") === "true",
    );

    if (selected) {
        selectTab(root, selected);
        return;
    }

    const fallback = firstEnabledTab(tabs);

    if (fallback) {
        selectTab(root, fallback);
    }
};

export function initTabs(root = document) {
    root.querySelectorAll(TAB_ROOT_SELECTOR).forEach((tabsRoot) => {
        if (!(tabsRoot instanceof HTMLElement)) {
            return;
        }

        if (tabsRoot.dataset.uiTabsInitialized === "true") {
            return;
        }

        const tablist = tabsRoot.querySelector(TABLIST_SELECTOR);

        if (!(tablist instanceof HTMLElement)) {
            return;
        }

        tabsRoot.dataset.uiTabsInitialized = "true";

        const activation =
            tabsRoot.dataset.uiTabsActivation === "manual"
                ? "manual"
                : "automatic";

        initializeRootState(tabsRoot, tablist);

        tablist.addEventListener("click", (event) => {
            const target = event.target;

            if (!(target instanceof Element)) {
                return;
            }

            const dismiss = target.closest(DISMISS_SELECTOR);
            const tab = target.closest(TAB_SELECTOR);

            if (!(tab instanceof HTMLElement) || tab.disabled) {
                return;
            }

            if (dismiss) {
                removeTab(tabsRoot, tablist, tab);
                return;
            }

            selectTab(tabsRoot, tab);
            tab.focus();
        });

        tablist.addEventListener("keydown", (event) => {
            const current = event.target.closest(TAB_SELECTOR);

            if (!(current instanceof HTMLElement)) {
                return;
            }

            const tabs = enabledTabs(tablist);
            const orientation = orientationFor(tablist);
            let next = null;

            if (isArrowForOrientation(event, orientation)) {
                next = nextEnabledTab(
                    tabs,
                    current,
                    directionForKey(event.key),
                );
            } else if (event.key === "Home") {
                next = firstEnabledTab(tabs, current);
            } else if (event.key === "End") {
                next = lastEnabledTab(tabs, current);
            } else if (
                activation === "manual" &&
                (event.key === "Enter" || event.key === " ")
            ) {
                event.preventDefault();
                selectTab(tabsRoot, current);
                return;
            } else if (event.key === "Delete") {
                const dismissible =
                    current.dataset.uiTabsDismissible === "true" ||
                    current.querySelector(DISMISS_SELECTOR);

                if (dismissible) {
                    event.preventDefault();
                    removeTab(tabsRoot, tablist, current);
                }

                return;
            }

            if (!next || next === current) {
                return;
            }

            event.preventDefault();
            next.focus();

            if (activation === "automatic") {
                selectTab(tabsRoot, next);
            }
        });
    });
}
