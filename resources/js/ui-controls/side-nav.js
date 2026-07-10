/**
 * File: resources/js/ui-controls/side-nav.js
 * Purpose: UI shell side navigation menu behavior.
 *
 * Notes:
 * - Uses the actual rendered shell side-nav menu data attributes.
 * - Keeps aria-expanded, hidden, and data-ui-shell-side-nav-menu-expanded in sync.
 * - Captures clicks before the older ui-shell side-nav binding can create
 *   mismatched state.
 */

const TRIGGER_SELECTOR = "[data-ui-shell-side-nav-menu-trigger]";
const PANEL_SELECTOR = "[data-ui-shell-side-nav-menu-panel]";
const BOUND_ATTR = "data-app-side-nav-menu-bound";

function getPanelForTrigger(trigger) {
    const controls = trigger.getAttribute("aria-controls");

    if (controls) {
        const controlledPanel = document.getElementById(controls);

        if (
            controlledPanel instanceof HTMLElement &&
            controlledPanel.matches(PANEL_SELECTOR)
        ) {
            return controlledPanel;
        }
    }

    const adjacent = trigger.nextElementSibling;

    if (adjacent instanceof HTMLElement && adjacent.matches(PANEL_SELECTOR)) {
        return adjacent;
    }

    return null;
}

function getInitialExpanded(trigger, panel) {
    const ariaExpanded = trigger.getAttribute("aria-expanded");

    if (ariaExpanded === "true") {
        return true;
    }

    if (ariaExpanded === "false") {
        return false;
    }

    const triggerData = trigger.dataset.uiShellSideNavMenuExpanded;

    if (triggerData === "true") {
        return true;
    }

    if (triggerData === "false") {
        return false;
    }

    if (panel instanceof HTMLElement) {
        const panelData = panel.dataset.uiShellSideNavMenuExpanded;

        if (panelData === "true") {
            return true;
        }

        if (panelData === "false") {
            return false;
        }

        return !panel.hidden;
    }

    return false;
}

function setExpanded(trigger, expanded) {
    const panel = getPanelForTrigger(trigger);
    const expandedValue = expanded ? "true" : "false";

    trigger.setAttribute("aria-expanded", expandedValue);
    trigger.dataset.uiShellSideNavMenuExpanded = expandedValue;

    if (!(panel instanceof HTMLElement)) {
        return;
    }

    panel.hidden = !expanded;
    panel.dataset.uiShellSideNavMenuExpanded = expandedValue;
    panel.setAttribute("aria-hidden", expanded ? "false" : "true");

    if (!panel.id) {
        panel.id = `side-nav-menu-${Math.random().toString(36).slice(2, 10)}`;
    }

    trigger.setAttribute("aria-controls", panel.id);
}

function toggleTrigger(trigger) {
    const expanded = trigger.getAttribute("aria-expanded") === "true";

    setExpanded(trigger, !expanded);
}

function bindTrigger(trigger) {
    if (!(trigger instanceof HTMLElement)) {
        return;
    }

    const panel = getPanelForTrigger(trigger);

    if (trigger.hasAttribute(BOUND_ATTR)) {
        setExpanded(trigger, getInitialExpanded(trigger, panel));
        return;
    }

    trigger.setAttribute(BOUND_ATTR, "true");

    setExpanded(trigger, getInitialExpanded(trigger, panel));

    trigger.addEventListener(
        "click",
        (event) => {
            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();

            toggleTrigger(trigger);
        },
        true,
    );

    trigger.addEventListener("keydown", (event) => {
        if (event.key !== "Escape") {
            return;
        }

        if (trigger.getAttribute("aria-expanded") !== "true") {
            return;
        }

        event.preventDefault();
        event.stopPropagation();

        setExpanded(trigger, false);
        trigger.focus();
    });
}

export function initSideNavs(root = document) {
    root.querySelectorAll(TRIGGER_SELECTOR).forEach(bindTrigger);
}
