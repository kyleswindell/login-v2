/**
 * UI shell interactions.
 *
 * Handles shell-owned disclosure behavior for:
 * - header menus
 * - side navigation menus
 * - side navigation mobile toggle / overlay
 * - side navigation footer toggle
 */

const BOUND_ATTR = "data-ui-shell-bound";
const HEADER_MENU_TRIGGER_SELECTOR = "[data-ui-shell-header-menu-trigger]";
const HEADER_SUBMENU_SELECTOR =
    "[data-ui-shell-header-submenu], .ui-shell-header__submenu";
const HEADER_MENU_PANEL_SELECTOR =
    "[data-ui-shell-header-menu], .ui-shell-header__menu";

function getPanelFromControls(trigger, fallbackSelector) {
    const controls = trigger.getAttribute("aria-controls");

    if (controls) {
        const controlled = document.getElementById(controls);

        if (controlled) {
            return controlled;
        }
    }

    return trigger.parentElement?.querySelector(fallbackSelector) ?? null;
}

function setTriggerExpanded(trigger, expanded) {
    trigger.setAttribute("aria-expanded", expanded ? "true" : "false");
}

function setPanelExpanded(panel, expanded) {
    if (!panel) {
        return;
    }

    panel.hidden = !expanded;
}

function closeHeaderMenus(exceptTrigger = null) {
    document
        .querySelectorAll(HEADER_MENU_TRIGGER_SELECTOR)
        .forEach((trigger) => {
            if (trigger === exceptTrigger) {
                return;
            }

            const panel = getPanelFromControls(
                trigger,
                HEADER_MENU_PANEL_SELECTOR,
            );

            setTriggerExpanded(trigger, false);
            setPanelExpanded(panel, false);

            trigger
                .closest(HEADER_SUBMENU_SELECTOR)
                ?.classList.remove("ui-shell-header__submenu--expanded");
        });
}

function initHeaderMenus(root) {
    root.querySelectorAll(HEADER_MENU_TRIGGER_SELECTOR).forEach((trigger) => {
        if (trigger.hasAttribute(BOUND_ATTR)) {
            return;
        }

        trigger.setAttribute(BOUND_ATTR, "true");

        trigger.addEventListener("click", (event) => {
            event.preventDefault();

            const expanded = trigger.getAttribute("aria-expanded") === "true";
            const nextExpanded = !expanded;
            const panel = getPanelFromControls(
                trigger,
                HEADER_MENU_PANEL_SELECTOR,
            );
            const menu = trigger.closest(HEADER_SUBMENU_SELECTOR);

            closeHeaderMenus(trigger);

            setTriggerExpanded(trigger, nextExpanded);
            setPanelExpanded(panel, nextExpanded);

            menu?.classList.toggle(
                "ui-shell-header__submenu--expanded",
                nextExpanded,
            );
        });
    });
}

function initSideNavMenus(root) {
    root.querySelectorAll("[data-ui-shell-side-nav-menu-trigger]").forEach(
        (trigger) => {
            if (trigger.hasAttribute(BOUND_ATTR)) {
                return;
            }

            trigger.setAttribute(BOUND_ATTR, "true");

            trigger.addEventListener("click", (event) => {
                event.preventDefault();

                const expanded =
                    trigger.getAttribute("aria-expanded") === "true";
                const nextExpanded = !expanded;
                const panel = getPanelFromControls(
                    trigger,
                    "[data-ui-shell-side-nav-menu-panel]",
                );
                const item = trigger.closest("[data-ui-shell-side-nav-menu]");

                setTriggerExpanded(trigger, nextExpanded);
                setPanelExpanded(panel, nextExpanded);

                item?.classList.toggle(
                    "ui-shell-side-nav__item--expanded",
                    nextExpanded,
                );

                trigger.dataset.uiShellSideNavMenuExpanded = nextExpanded
                    ? "true"
                    : "false";

                if (panel) {
                    panel.dataset.uiShellSideNavMenuExpanded = nextExpanded
                        ? "true"
                        : "false";
                }
            });
        },
    );
}

function setSideNavExpanded(sideNav, expanded) {
    if (!sideNav) {
        return;
    }

    sideNav.classList.toggle("ui-shell-side-nav--expanded", expanded);
    sideNav.classList.toggle("ui-shell-side-nav--collapsed", !expanded);
    sideNav.dataset.uiShellSideNavExpanded = expanded ? "true" : "false";
    sideNav.setAttribute("aria-hidden", expanded ? "false" : "true");

    const overlay = document.querySelector("[data-ui-shell-side-nav-overlay]");

    if (overlay) {
        overlay.classList.toggle(
            "ui-shell-side-nav__overlay--active",
            expanded,
        );
        overlay.dataset.uiShellSideNavOverlayActive = expanded
            ? "true"
            : "false";
        overlay.hidden = !expanded;
    }

    document
        .querySelectorAll(`[aria-controls="${sideNav.id}"]`)
        .forEach((trigger) => {
            trigger.classList.toggle(
                "ui-shell-header__action--active",
                expanded,
            );
            trigger.setAttribute("aria-expanded", expanded ? "true" : "false");

            if (
                trigger.hasAttribute("data-ui-shell-header-menu-button-active")
            ) {
                trigger.dataset.uiShellHeaderMenuButtonActive = expanded
                    ? "true"
                    : "false";
            }

            if (
                trigger.hasAttribute(
                    "data-ui-shell-side-nav-footer-toggle-expanded",
                )
            ) {
                trigger.dataset.uiShellSideNavFooterToggleExpanded = expanded
                    ? "true"
                    : "false";
            }
        });
}

function initResponsiveSideNavState(root) {
    root.querySelectorAll("[data-ui-shell-side-nav]").forEach((sideNav) => {
        if (sideNav.hasAttribute("data-ui-shell-responsive-bound")) {
            return;
        }

        sideNav.setAttribute("data-ui-shell-responsive-bound", "true");

        const mobileViewport = window.matchMedia("(max-width: 65.98rem)");
        const desktopExpanded =
            sideNav.dataset.uiShellSideNavExpanded === "true" ||
            (!sideNav.classList.contains("ui-shell-side-nav--collapsed") &&
                sideNav.dataset.uiShellSideNavPersistent === "true");
        const syncToViewport = () => {
            if (mobileViewport.matches) {
                setSideNavExpanded(sideNav, false);
                return;
            }

            setSideNavExpanded(sideNav, desktopExpanded);
        };

        syncToViewport();
        mobileViewport.addEventListener("change", syncToViewport);
    });
}

function initSideNavToggles(root) {
    root.querySelectorAll("[data-ui-shell-header-menu-button]").forEach(
        (trigger) => {
            if (trigger.hasAttribute(BOUND_ATTR)) {
                return;
            }

            trigger.setAttribute(BOUND_ATTR, "true");

            trigger.addEventListener("click", () => {
                const controls = trigger.getAttribute("aria-controls");

                if (!controls) {
                    return;
                }

                const sideNav = document.getElementById(controls);

                if (!sideNav) {
                    return;
                }

                const expanded =
                    sideNav.dataset.uiShellSideNavExpanded === "true" ||
                    sideNav.classList.contains("ui-shell-side-nav--expanded");

                setSideNavExpanded(sideNav, !expanded);
            });
        },
    );

    root.querySelectorAll("[data-ui-shell-side-nav-footer-toggle]").forEach(
        (trigger) => {
            if (trigger.hasAttribute(BOUND_ATTR)) {
                return;
            }

            trigger.setAttribute(BOUND_ATTR, "true");

            trigger.addEventListener("click", () => {
                const controls = trigger.getAttribute("aria-controls");
                const sideNav = controls
                    ? document.getElementById(controls)
                    : trigger.closest("[data-ui-shell-side-nav]");

                if (!sideNav) {
                    return;
                }

                const expanded =
                    sideNav.dataset.uiShellSideNavExpanded === "true" ||
                    sideNav.classList.contains("ui-shell-side-nav--expanded");

                setSideNavExpanded(sideNav, !expanded);
            });
        },
    );

    root.querySelectorAll("[data-ui-shell-side-nav-overlay]").forEach(
        (overlay) => {
            if (overlay.hasAttribute(BOUND_ATTR)) {
                return;
            }

            overlay.setAttribute(BOUND_ATTR, "true");

            overlay.addEventListener("click", () => {
                const sideNav = document.querySelector(
                    "[data-ui-shell-side-nav]",
                );

                setSideNavExpanded(sideNav, false);
            });
        },
    );
}

function initGlobalDismissHandlers() {
    if (document.documentElement.hasAttribute("data-ui-shell-global-bound")) {
        return;
    }

    document.documentElement.setAttribute("data-ui-shell-global-bound", "true");

    document.addEventListener("click", (event) => {
        const target = event.target;

        if (!(target instanceof Element)) {
            return;
        }

        if (
            target.closest(HEADER_SUBMENU_SELECTOR) ||
            target.closest(HEADER_MENU_TRIGGER_SELECTOR) ||
            target.closest(HEADER_MENU_PANEL_SELECTOR)
        ) {
            return;
        }

        if (target.closest("[data-ui-shell-header-global-action]")) {
            return;
        }

        if (target.closest("[data-ui-shell-header-panel]")) {
            return;
        }

        closeHeaderPanels();
        closeHeaderMenus();
    });

    document.addEventListener("keydown", (event) => {
        if (event.key !== "Escape") {
            return;
        }

        closeHeaderMenus();

        document
            .querySelectorAll("[data-ui-shell-side-nav-menu-trigger]")
            .forEach((trigger) => {
                const panel = getPanelFromControls(
                    trigger,
                    "[data-ui-shell-side-nav-menu-panel]",
                );
                const item = trigger.closest("[data-ui-shell-side-nav-menu]");

                setTriggerExpanded(trigger, false);
                setPanelExpanded(panel, false);

                item?.classList.remove("ui-shell-side-nav__item--expanded");
            });
    });
}

function closeHeaderPanels(exceptTrigger = null) {
    document
        .querySelectorAll("[data-ui-shell-header-global-action][aria-controls]")
        .forEach((trigger) => {
            if (trigger === exceptTrigger) {
                return;
            }

            const panel = document.getElementById(
                trigger.getAttribute("aria-controls"),
            );

            trigger.classList.remove("ui-shell-header__action--active");
            trigger.setAttribute("aria-expanded", "false");
            trigger.dataset.uiShellHeaderGlobalActionActive = "false";

            if (panel) {
                panel.hidden = true;
                panel.classList.remove("ui-shell-header-panel--expanded");
                panel.dataset.uiShellHeaderPanelExpanded = "false";
                panel.setAttribute("aria-expanded", "false");
            }
        });
}

function initHeaderGlobalActions(root) {
    root.querySelectorAll(
        "[data-ui-shell-header-global-action][aria-controls]",
    ).forEach((trigger) => {
        if (trigger.hasAttribute(BOUND_ATTR)) {
            return;
        }

        trigger.setAttribute(BOUND_ATTR, "true");

        trigger.addEventListener("click", (event) => {
            event.preventDefault();

            const panel = document.getElementById(
                trigger.getAttribute("aria-controls"),
            );

            if (!panel) {
                return;
            }

            const expanded =
                trigger.getAttribute("aria-expanded") === "true" ||
                trigger.classList.contains("ui-shell-header__action--active");

            const nextExpanded = !expanded;

            closeHeaderPanels(trigger);
            closeHeaderMenus();

            trigger.classList.toggle(
                "ui-shell-header__action--active",
                nextExpanded,
            );
            trigger.setAttribute(
                "aria-expanded",
                nextExpanded ? "true" : "false",
            );
            trigger.dataset.uiShellHeaderGlobalActionActive = nextExpanded
                ? "true"
                : "false";

            panel.hidden = !nextExpanded;
            panel.classList.toggle(
                "ui-shell-header-panel--expanded",
                nextExpanded,
            );
            panel.dataset.uiShellHeaderPanelExpanded = nextExpanded
                ? "true"
                : "false";
            panel.setAttribute(
                "aria-expanded",
                nextExpanded ? "true" : "false",
            );
        });
    });
}

export function initUiShell(root = document) {
    initHeaderMenus(root);
    initHeaderGlobalActions(root);
    initSideNavMenus(root);
    initResponsiveSideNavState(root);
    initSideNavToggles(root);
    initGlobalDismissHandlers();
}
