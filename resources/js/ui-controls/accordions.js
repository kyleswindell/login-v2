/**
 * File: resources/js/ui-controls/accordions.js
 * Purpose: Accordion interaction controller.
 *
 * Notes:
 * - Owns open/close behavior for x-ui.accordion.
 * - Keeps ARIA, data state, Carbon-compatible active classes, and panel
 *   visibility synchronized.
 * - Supports single and multiple open modes.
 * - Supports animated panel open/close with reduced-motion handling.
 * - Preserves Carbon-style anatomy:
 *   ul.ui-accordion
 *     li.ui-accordion__item
 *       button.ui-accordion__heading
 *       div.ui-accordion__wrapper
 *         div.ui-accordion__content
 */

const ACCORDION_SELECTOR = "[data-ui-accordion]";
const ACCORDION_ITEM_SELECTOR = "[data-ui-accordion-item]";
const ACCORDION_TRIGGER_SELECTOR = "[data-ui-accordion-trigger]";

const OPEN_ANIMATION_FALLBACK_MS = 260;
const CLOSE_ANIMATION_FALLBACK_MS = 240;

let accordionFocusClearRegistered = false;
let accordionAnimationId = 0;

/* --------------------------------------------------------------------------
   Motion helpers
   -------------------------------------------------------------------------- */

/**
 * Check whether the user prefers reduced motion.
 *
 * @returns {boolean}
 */
const prefersReducedMotion = () =>
    window.matchMedia?.("(prefers-reduced-motion: reduce)")?.matches ?? false;

/**
 * Create a new animation identifier so older transition handlers/timeouts
 * cannot finish a newer animation.
 *
 * @param {HTMLElement} panel
 * @returns {string}
 */
const startPanelAnimation = (panel) => {
    const id = String(++accordionAnimationId);

    panel.dataset.uiAccordionAnimationId = id;
    panel.dataset.uiAccordionAnimating = "true";

    return id;
};

/**
 * Check whether a panel animation is still current.
 *
 * @param {HTMLElement} panel
 * @param {string} id
 * @returns {boolean}
 */
const isCurrentPanelAnimation = (panel, id) =>
    panel.dataset.uiAccordionAnimationId === id;

/* --------------------------------------------------------------------------
   Focus persistence helpers
   -------------------------------------------------------------------------- */

/**
 * Clear persisted accordion trigger focus markers.
 *
 * @param {ParentNode} root
 * @returns {void}
 */
const clearPersistedAccordionFocus = (root = document) => {
    root.querySelectorAll?.(
        '[data-ui-accordion-trigger][data-ui-accordion-focus="true"]',
    ).forEach((trigger) => {
        delete trigger.dataset.uiAccordionFocus;
    });
};

/**
 * Register global focus marker clearing once.
 *
 * @returns {void}
 */
const registerAccordionFocusClear = () => {
    if (accordionFocusClearRegistered) {
        return;
    }

    document.addEventListener(
        "pointerdown",
        () => clearPersistedAccordionFocus(),
        true,
    );

    document.addEventListener(
        "keydown",
        () => clearPersistedAccordionFocus(),
        true,
    );

    accordionFocusClearRegistered = true;
};

/* --------------------------------------------------------------------------
   DOM helpers
   -------------------------------------------------------------------------- */

/**
 * Return all accordion roots within a root, including the root itself when
 * applicable.
 *
 * @param {ParentNode | Element} root
 * @returns {HTMLElement[]}
 */
const getAccordions = (root = document) => {
    const accordions = [];

    if (root instanceof HTMLElement && root.matches(ACCORDION_SELECTOR)) {
        accordions.push(root);
    }

    root.querySelectorAll?.(ACCORDION_SELECTOR).forEach((accordion) => {
        if (accordion instanceof HTMLElement) {
            accordions.push(accordion);
        }
    });

    return accordions;
};

/**
 * Find the panel controlled by a trigger.
 *
 * @param {HTMLElement} accordion
 * @param {HTMLElement} trigger
 * @returns {HTMLElement | null}
 */
const getPanelForTrigger = (accordion, trigger) => {
    const panelId = trigger.getAttribute("aria-controls");

    if (!panelId) {
        return null;
    }

    if (window.CSS?.escape) {
        const scopedPanel = accordion.querySelector(`#${CSS.escape(panelId)}`);

        if (scopedPanel instanceof HTMLElement) {
            return scopedPanel;
        }
    }

    const documentPanel = document.getElementById(panelId);

    if (
        documentPanel instanceof HTMLElement &&
        accordion.contains(documentPanel)
    ) {
        return documentPanel;
    }

    return null;
};

/**
 * Get the accordion item that owns a panel or trigger.
 *
 * @param {HTMLElement} element
 * @returns {HTMLElement | null}
 */
const getAccordionItem = (element) => {
    const item = element.closest(ACCORDION_ITEM_SELECTOR);

    return item instanceof HTMLElement ? item : null;
};

/* --------------------------------------------------------------------------
   State class helpers
   -------------------------------------------------------------------------- */

/**
 * Sync Carbon-compatible active item classes.
 *
 * @param {HTMLElement} panel
 * @param {boolean} open
 * @returns {void}
 */
const setItemActiveClasses = (panel, open) => {
    const item = getAccordionItem(panel);

    item?.classList.toggle("ui-accordion-item-active", open);
    item?.classList.toggle("ui-accordion__item--active", open);
};

/**
 * Sync Carbon-compatible disabled item classes.
 *
 * @param {HTMLButtonElement} trigger
 * @param {HTMLElement} panel
 * @returns {void}
 */
const syncItemDisabledClasses = (trigger, panel) => {
    const item = getAccordionItem(panel);
    const disabled =
        trigger.disabled ||
        trigger.dataset.uiAccordionTriggerDisabled === "true";

    item?.classList.toggle("ui-accordion-item-disabled", disabled);
    item?.classList.toggle("ui-accordion__item--disabled", disabled);
    item?.setAttribute(
        "data-ui-accordion-item-disabled",
        disabled ? "true" : "false",
    );
};

/**
 * Clear animation state classes from an accordion item.
 *
 * @param {HTMLElement} panel
 * @returns {void}
 */
const clearItemAnimationClasses = (panel) => {
    const item = getAccordionItem(panel);

    item?.classList.remove(
        "ui-accordion-item-expanding",
        "ui-accordion-item-collapsing",
        "ui-accordion__item--expanding",
        "ui-accordion__item--collapsing",
    );
};

/**
 * Set current animation state classes on an accordion item.
 *
 * @param {HTMLElement} panel
 * @param {"expanding" | "collapsing" | null} state
 * @returns {void}
 */
const setItemAnimationState = (panel, state) => {
    const item = getAccordionItem(panel);

    clearItemAnimationClasses(panel);

    if (state === "expanding") {
        item?.classList.add(
            "ui-accordion-item-expanding",
            "ui-accordion__item--expanding",
        );
    }

    if (state === "collapsing") {
        item?.classList.add(
            "ui-accordion-item-collapsing",
            "ui-accordion__item--collapsing",
        );
    }
};

/**
 * Sync public open state attributes.
 *
 * @param {HTMLButtonElement} trigger
 * @param {HTMLElement} panel
 * @param {boolean} open
 * @returns {void}
 */
const setAccordionOpenAttributes = (trigger, panel, open) => {
    const item = getAccordionItem(panel);

    trigger.setAttribute("aria-expanded", open ? "true" : "false");
    panel.dataset.uiAccordionPanelOpen = open ? "true" : "false";
    item?.setAttribute("data-ui-accordion-item-open", open ? "true" : "false");
};

/* --------------------------------------------------------------------------
   Finish handlers
   -------------------------------------------------------------------------- */

/**
 * Finish opening a panel.
 *
 * @param {HTMLElement} panel
 * @param {string} id
 * @returns {void}
 */
const finishPanelOpen = (panel, id) => {
    if (!isCurrentPanelAnimation(panel, id)) {
        return;
    }

    setItemActiveClasses(panel, true);
    clearItemAnimationClasses(panel);

    panel.hidden = false;
    panel.style.blockSize = "";
    panel.dataset.uiAccordionAnimating = "false";
};

/**
 * Finish closing a panel.
 *
 * @param {HTMLElement} panel
 * @param {string} id
 * @returns {void}
 */
const finishPanelClose = (panel, id) => {
    if (!isCurrentPanelAnimation(panel, id)) {
        return;
    }

    clearItemAnimationClasses(panel);
    setItemActiveClasses(panel, false);

    if (panel.dataset.uiAccordionPanelOpen === "false") {
        panel.hidden = true;
    }

    panel.style.blockSize = "";
    panel.dataset.uiAccordionAnimating = "false";
};

/**
 * Register a guarded transition finish callback with a timeout fallback.
 *
 * @param {HTMLElement} panel
 * @param {string} id
 * @param {() => void} callback
 * @param {number} fallbackMs
 * @returns {void}
 */
const registerPanelFinish = (panel, id, callback, fallbackMs) => {
    let finished = false;

    const finish = (event = null) => {
        if (finished) {
            return;
        }

        if (event && event.target !== panel) {
            return;
        }

        if (!isCurrentPanelAnimation(panel, id)) {
            return;
        }

        finished = true;
        panel.removeEventListener("transitionend", finish);
        callback();
    };

    panel.addEventListener("transitionend", finish);
    window.setTimeout(finish, fallbackMs);
};

/* --------------------------------------------------------------------------
   Panel open / close
   -------------------------------------------------------------------------- */

/**
 * Open or close an accordion panel.
 *
 * @param {HTMLButtonElement} trigger
 * @param {HTMLElement} panel
 * @param {boolean} open
 * @param {boolean} animate
 * @returns {void}
 */
const setAccordionPanelOpen = (trigger, panel, open, animate = true) => {
    const animationId = startPanelAnimation(panel);

    syncItemDisabledClasses(trigger, panel);
    setAccordionOpenAttributes(trigger, panel, open);

    /*
    |--------------------------------------------------------------------------
    | Open
    |--------------------------------------------------------------------------
    |
    | Add active classes before measuring so Carbon-compatible CSS displays the
    | wrapper while it animates.
    |
    */

    if (open) {
        panel.hidden = false;
        setItemActiveClasses(panel, true);
        setItemAnimationState(panel, "expanding");

        if (!animate || prefersReducedMotion()) {
            finishPanelOpen(panel, animationId);
            return;
        }

        panel.style.blockSize = "0px";

        window.requestAnimationFrame(() => {
            if (!isCurrentPanelAnimation(panel, animationId)) {
                return;
            }

            panel.style.blockSize = `${panel.scrollHeight}px`;
        });

        registerPanelFinish(
            panel,
            animationId,
            () => finishPanelOpen(panel, animationId),
            OPEN_ANIMATION_FALLBACK_MS,
        );

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Close
    |--------------------------------------------------------------------------
    |
    | Keep active classes during the collapse measurement and animation so the
    | wrapper remains rendered. Active classes are removed only after close
    | finishes.
    |
    */

    panel.hidden = false;
    setItemActiveClasses(panel, true);
    setItemAnimationState(panel, "collapsing");
    panel.style.blockSize = `${panel.scrollHeight}px`;

    if (!animate || prefersReducedMotion()) {
        finishPanelClose(panel, animationId);
        return;
    }

    window.requestAnimationFrame(() => {
        if (!isCurrentPanelAnimation(panel, animationId)) {
            return;
        }

        panel.style.blockSize = "0px";
    });

    registerPanelFinish(
        panel,
        animationId,
        () => finishPanelClose(panel, animationId),
        CLOSE_ANIMATION_FALLBACK_MS,
    );
};

/* --------------------------------------------------------------------------
   Single mode
   -------------------------------------------------------------------------- */

/**
 * Close other open items when the accordion is in single mode.
 *
 * @param {HTMLElement} accordion
 * @param {HTMLButtonElement} activeTrigger
 * @returns {void}
 */
const closeOtherAccordionItems = (accordion, activeTrigger) => {
    accordion
        .querySelectorAll('[data-ui-accordion-trigger][aria-expanded="true"]')
        .forEach((openTrigger) => {
            if (
                !(openTrigger instanceof HTMLButtonElement) ||
                openTrigger === activeTrigger
            ) {
                return;
            }

            const openPanel = getPanelForTrigger(accordion, openTrigger);

            if (!(openPanel instanceof HTMLElement)) {
                return;
            }

            setAccordionPanelOpen(openTrigger, openPanel, false);
        });
};

/* --------------------------------------------------------------------------
   Event binding
   -------------------------------------------------------------------------- */

/**
 * Bind one accordion trigger.
 *
 * @param {HTMLElement} accordion
 * @param {HTMLButtonElement} trigger
 * @returns {void}
 */
const bindAccordionTrigger = (accordion, trigger) => {
    if (trigger.dataset.uiAccordionTriggerInit === "1") {
        return;
    }

    const panel = getPanelForTrigger(accordion, trigger);

    if (!(panel instanceof HTMLElement)) {
        return;
    }

    trigger.dataset.uiAccordionTriggerInit = "1";

    /*
    |--------------------------------------------------------------------------
    | Initial state
    |--------------------------------------------------------------------------
    */

    syncItemDisabledClasses(trigger, panel);
    setAccordionPanelOpen(
        trigger,
        panel,
        trigger.getAttribute("aria-expanded") === "true",
        false,
    );

    /*
    |--------------------------------------------------------------------------
    | Click behavior
    |--------------------------------------------------------------------------
    */

    trigger.addEventListener("click", () => {
        if (trigger.disabled) {
            return;
        }

        clearPersistedAccordionFocus(accordion.ownerDocument);
        trigger.dataset.uiAccordionFocus = "true";

        const nextOpen = trigger.getAttribute("aria-expanded") !== "true";

        if (nextOpen && accordion.dataset.uiAccordionMode === "single") {
            closeOtherAccordionItems(accordion, trigger);
        }

        setAccordionPanelOpen(trigger, panel, nextOpen);
    });

    /*
    |--------------------------------------------------------------------------
    | Keyboard behavior
    |--------------------------------------------------------------------------
    |
    | Carbon closes an open AccordionItem from the heading with Escape.
    |
    */

    trigger.addEventListener("keydown", (event) => {
        if (event.key !== "Escape") {
            return;
        }

        if (trigger.getAttribute("aria-expanded") !== "true") {
            return;
        }

        event.preventDefault();
        setAccordionPanelOpen(trigger, panel, false);
    });

    /*
    |--------------------------------------------------------------------------
    | Panel Escape behavior
    |--------------------------------------------------------------------------
    |
    | If focus is inside expanded content, Escape closes the item and returns
    | focus to the owning trigger.
    |
    */

    panel.addEventListener("keydown", (event) => {
        if (event.key !== "Escape") {
            return;
        }

        if (trigger.getAttribute("aria-expanded") !== "true") {
            return;
        }

        event.preventDefault();
        setAccordionPanelOpen(trigger, panel, false);
        trigger.focus();
    });
};

/* --------------------------------------------------------------------------
   Public initializer
   -------------------------------------------------------------------------- */

/**
 * Initialize accordions.
 *
 * @param {ParentNode | Element} root
 * @returns {void}
 */
export function initAccordions(root = document) {
    registerAccordionFocusClear();

    getAccordions(root).forEach((accordion) => {
        if (!(accordion instanceof HTMLElement)) {
            return;
        }

        if (accordion.dataset.uiAccordionInit === "1") {
            return;
        }

        accordion.dataset.uiAccordionInit = "1";

        accordion
            .querySelectorAll(ACCORDION_TRIGGER_SELECTOR)
            .forEach((trigger) => {
                if (!(trigger instanceof HTMLButtonElement)) {
                    return;
                }

                bindAccordionTrigger(accordion, trigger);
            });
    });
}
