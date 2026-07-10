/**
 * File: resources/js/ui-controls/toggletip.js
 * Purpose: Progressive enhancement for Blade-rendered Toggletips.
 *
 * Expected Blade structure:
 *
 * <span data-ui-toggletip>
 *     <button data-ui-toggletip-trigger>...</button>
 *     <span data-ui-toggletip-panel hidden>
 *         ...
 *         <button data-ui-toggletip-close>Close</button>
 *     </span>
 * </span>
 *
 * Behavior:
 * - Opens/closes on trigger click.
 * - Closes on close button click.
 * - Closes when focus leaves the toggletip.
 * - Closes on outside pointer/click.
 * - Closes on Escape and returns focus to the trigger.
 * - Preserves Blade-rendered default-open state.
 *
 * Notes:
 * - Toggletip is click/disclosure help, not hover-only tooltip.
 * - The trigger may be rendered next to checkbox/radio labels, so trigger
 *   click events intentionally stop propagation to avoid toggling the form
 *   control by accident.
 * - Visual positioning/caret behavior belongs to toggletip.css/popover.css.
 */

/* --------------------------------------------------------------------------
 * Selectors / attributes
 * -------------------------------------------------------------------------- */

const ROOT_SELECTOR = "[data-ui-toggletip]";
const TRIGGER_SELECTOR = "[data-ui-toggletip-trigger]";
const PANEL_SELECTOR = "[data-ui-toggletip-panel]";
const CLOSE_SELECTOR = "[data-ui-toggletip-close]";

const INITIALIZED_ATTR = "data-ui-toggletip-initialized";

/* --------------------------------------------------------------------------
 * Utilities
 * -------------------------------------------------------------------------- */

/**
 * Create a stable-enough ID for panels that do not already have one.
 */
function createId() {
    if (window.crypto?.randomUUID) {
        return `ui-toggletip-${window.crypto.randomUUID()}`;
    }

    return `ui-toggletip-${Math.random().toString(36).slice(2)}`;
}

/**
 * Returns true when a value is a DOM Element.
 */
function isElement(value) {
    return value instanceof Element;
}

/**
 * Returns true when a value is an HTMLElement.
 */
function isHTMLElement(value) {
    return value instanceof HTMLElement;
}

/**
 * Returns the toggletip trigger button/control.
 */
function getTrigger(root) {
    return root.querySelector(TRIGGER_SELECTOR);
}

/**
 * Returns the toggletip content panel.
 */
function getPanel(root) {
    return root.querySelector(PANEL_SELECTOR);
}

/**
 * Returns whether the toggletip is currently open according to its state attr.
 */
function isOpen(root) {
    return root.dataset.uiToggletipState === "open";
}

/**
 * Checks whether a target is inside a given root.
 *
 * Uses composedPath when available so outside-click behavior still works with
 * composed events.
 */
function isEventInsideRoot(event, root) {
    if (!(root instanceof Node)) {
        return false;
    }

    if (event.target instanceof Node && root.contains(event.target)) {
        return true;
    }

    if (typeof event.composedPath === "function") {
        return event.composedPath().some((entry) => entry === root);
    }

    return false;
}

/* --------------------------------------------------------------------------
 * State / accessibility
 * -------------------------------------------------------------------------- */

/**
 * Ensures the trigger and panel have the ARIA relationship required by the
 * toggletip contract.
 *
 * Blade should ideally render this correctly, but JS repairs missing IDs and
 * attributes so manually composed toggletips still work.
 */
function ensureAccessibility(root) {
    const trigger = getTrigger(root);
    const panel = getPanel(root);

    if (!isHTMLElement(trigger) || !isHTMLElement(panel)) {
        return;
    }

    if (!panel.id) {
        panel.id = createId();
    }

    trigger.setAttribute("aria-controls", panel.id);
    trigger.setAttribute("aria-haspopup", "dialog");

    panel.setAttribute("role", "dialog");
    panel.setAttribute("aria-hidden", panel.hidden ? "true" : "false");
}

/**
 * Applies the open/closed state to the root, trigger, and panel.
 *
 * This is the single source of truth for DOM state changes:
 * - root class
 * - data state
 * - aria-expanded
 * - aria-describedby
 * - hidden
 * - aria-hidden
 */
function setOpen(root, open) {
    const trigger = getTrigger(root);
    const panel = getPanel(root);

    if (!isHTMLElement(trigger) || !isHTMLElement(panel)) {
        return;
    }

    root.dataset.uiToggletipState = open ? "open" : "closed";
    root.classList.toggle("ui-toggletip--open", open);

    trigger.setAttribute("aria-expanded", open ? "true" : "false");

    if (open) {
        trigger.setAttribute("aria-describedby", panel.id);
    } else {
        trigger.removeAttribute("aria-describedby");
    }

    panel.hidden = !open;
    panel.setAttribute("aria-hidden", open ? "false" : "true");
}

/**
 * Closes every toggletip except the provided active root.
 */
function closeAllExcept(activeRoot = null) {
    document.querySelectorAll(ROOT_SELECTOR).forEach((root) => {
        if (root !== activeRoot) {
            setOpen(root, false);
        }
    });
}

/**
 * Closes a single toggletip and optionally returns focus to its trigger.
 */
function closeToggletip(root, returnFocus = false) {
    setOpen(root, false);

    if (returnFocus) {
        getTrigger(root)?.focus();
    }
}

/* --------------------------------------------------------------------------
 * Per-root event binding
 * -------------------------------------------------------------------------- */

/**
 * Handles clicks inside one toggletip instance.
 *
 * Trigger click toggles the panel.
 * Close button click closes the panel and returns focus to the trigger.
 */
function handleRootClick(event, root) {
    const target = event.target;

    if (!isElement(target)) {
        return;
    }

    const trigger = target.closest(TRIGGER_SELECTOR);

    if (trigger && root.contains(trigger)) {
        event.preventDefault();
        event.stopPropagation();

        const nextOpen = !isOpen(root);

        closeAllExcept(root);
        setOpen(root, nextOpen);

        return;
    }

    const closeButton = target.closest(CLOSE_SELECTOR);

    if (closeButton && root.contains(closeButton)) {
        event.preventDefault();
        event.stopPropagation();

        closeToggletip(root, true);
    }
}

/**
 * Closes the toggletip when keyboard focus leaves the whole root.
 *
 * This mirrors Carbon’s intent: if focus moves from the trigger into the panel,
 * keep it open; if focus leaves the toggletip entirely, close it.
 */
function handleRootFocusOut(event, root) {
    const nextFocusedElement = event.relatedTarget;

    /**
     * When relatedTarget is null, the browser/window may be losing focus.
     * The global window blur handler handles that case.
     */
    if (nextFocusedElement === null) {
        return;
    }

    if (
        nextFocusedElement instanceof Node &&
        root.contains(nextFocusedElement)
    ) {
        return;
    }

    setOpen(root, false);
}

/**
 * Binds a single toggletip root.
 *
 * Idempotent: safe to call repeatedly after Livewire navigation or partial DOM
 * replacement.
 */
function bindToggletip(root) {
    if (!(root instanceof HTMLElement)) {
        return;
    }

    if (root.hasAttribute(INITIALIZED_ATTR)) {
        ensureAccessibility(root);
        setOpen(root, isOpen(root));
        return;
    }

    root.setAttribute(INITIALIZED_ATTR, "true");

    ensureAccessibility(root);

    /**
     * Preserve server-rendered/default-open state from Blade.
     */
    setOpen(root, root.dataset.uiToggletipState === "open");

    root.addEventListener("click", (event) => handleRootClick(event, root));
    root.addEventListener("focusout", (event) =>
        handleRootFocusOut(event, root),
    );
}

/* --------------------------------------------------------------------------
 * Global event binding
 * -------------------------------------------------------------------------- */

/**
 * Closes toggletips on outside pointer down.
 *
 * Pointer-down is used instead of click so the panel closes immediately when
 * the user begins interacting elsewhere.
 */
function handleDocumentPointerDown(event) {
    document.querySelectorAll(ROOT_SELECTOR).forEach((root) => {
        if (!isEventInsideRoot(event, root)) {
            setOpen(root, false);
        }
    });
}

/**
 * Closes all open toggletips on Escape.
 *
 * Returns focus to the trigger for each open toggletip, matching expected
 * disclosure/popover keyboard behavior.
 */
function handleDocumentKeydown(event) {
    if (event.key !== "Escape") {
        return;
    }

    document.querySelectorAll(ROOT_SELECTOR).forEach((root) => {
        if (isOpen(root)) {
            closeToggletip(root, true);
        }
    });
}

/**
 * Closes all toggletips when the browser window loses focus.
 */
function handleWindowBlur() {
    document.querySelectorAll(ROOT_SELECTOR).forEach((root) => {
        setOpen(root, false);
    });
}

let globalEventsBound = false;

/**
 * Binds global listeners once.
 */
function bindGlobalEvents() {
    if (globalEventsBound) {
        return;
    }

    globalEventsBound = true;

    const pointerEvent = "PointerEvent" in window ? "pointerdown" : "mousedown";

    document.addEventListener(pointerEvent, handleDocumentPointerDown, {
        capture: true,
    });

    document.addEventListener("keydown", handleDocumentKeydown);
    window.addEventListener("blur", handleWindowBlur);
}

/* --------------------------------------------------------------------------
 * Public initializer
 * -------------------------------------------------------------------------- */

/**
 * Initializes all toggletips inside a root document/element.
 *
 * Supports:
 * - full document initialization
 * - Livewire partial root initialization
 * - direct initialization when root itself is a toggletip
 */
export function initToggletips(root = document) {
    if (root instanceof Element && root.matches(ROOT_SELECTOR)) {
        bindToggletip(root);
    }

    root.querySelectorAll?.(ROOT_SELECTOR).forEach(bindToggletip);

    bindGlobalEvents();
}
