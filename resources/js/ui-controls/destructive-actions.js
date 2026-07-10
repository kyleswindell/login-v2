/**
 * File: resources/js/ui-controls/destructive-actions.js
 * Purpose: Destructive Actions interaction helpers.
 *
 * Notes:
 * - Owns typed-confirmation enablement for
 *   x-patterns.common-actions.destructive-actions.
 * - Locks generated destructive actions until the expected typed-confirmation
 *   value matches exactly.
 * - Does not own modal open/close behavior.
 * - Does not own authorization, persistence, validation, or form submission.
 */

const ROOT_SELECTOR = "[data-ui-destructive-actions]";
const ACTION_SELECTOR = "[data-ui-destructive-action]";
const TYPED_CONFIRMATION_CONTROL_SELECTOR =
    "[data-ui-destructive-actions-typed-confirmation-control]";
const TEXT_INPUT_SELECTOR = "[data-ui-text-input]";

/* --------------------------------------------------------------------------
   Helpers
   -------------------------------------------------------------------------- */

const normalize = (value) => String(value ?? "").trim();

const getRoots = (root = document) => {
    const roots = [];

    if (root instanceof HTMLElement && root.matches(ROOT_SELECTOR)) {
        roots.push(root);
    }

    root.querySelectorAll?.(ROOT_SELECTOR).forEach((element) => {
        if (element instanceof HTMLElement) {
            roots.push(element);
        }
    });

    return roots;
};

const setActionDisabled = (action, disabled) => {
    action.setAttribute("aria-disabled", disabled ? "true" : "false");
    action.dataset.uiDestructiveActionDisabled = disabled ? "true" : "false";

    if (action instanceof HTMLButtonElement) {
        action.disabled = disabled;
        return;
    }

    if (disabled) {
        action.setAttribute("tabindex", "-1");
    } else {
        action.removeAttribute("tabindex");
    }
};

const isDisabledAction = (action) =>
    action instanceof HTMLElement &&
    action.getAttribute("aria-disabled") === "true";

const getTypedConfirmationState = (root) => {
    const control = root.querySelector(TYPED_CONFIRMATION_CONTROL_SELECTOR);

    if (!(control instanceof HTMLElement)) {
        return {
            hasControl: false,
            matches: false,
        };
    }

    const input = control.querySelector(TEXT_INPUT_SELECTOR);

    if (!(input instanceof HTMLInputElement)) {
        return {
            hasControl: false,
            matches: false,
        };
    }

    const expected = normalize(
        control.dataset.uiDestructiveActionsTypedConfirmationExpected,
    );

    return {
        hasControl: true,
        matches: expected !== "" && normalize(input.value) === expected,
    };
};

const syncTypedConfirmation = (root) => {
    if (root.dataset.uiDestructiveActionsRequiresTypedConfirmation !== "true") {
        return;
    }

    const state = getTypedConfirmationState(root);

    root.querySelectorAll(ACTION_SELECTOR).forEach((action) => {
        if (!(action instanceof HTMLElement)) {
            return;
        }

        if (
            action.dataset.uiDestructiveActionRequiresTypedConfirmation !==
            "true"
        ) {
            return;
        }

        const locked = action.dataset.uiDestructiveActionLocked === "true";
        const shouldDisable = locked || !state.hasControl || !state.matches;

        setActionDisabled(action, shouldDisable);
    });
};

const guardDisabledActionClick = (event) => {
    const target = event.target;

    if (!(target instanceof Element)) {
        return;
    }

    const action = target.closest(ACTION_SELECTOR);

    if (!(action instanceof HTMLElement)) {
        return;
    }

    if (!isDisabledAction(action)) {
        return;
    }

    event.preventDefault();
    event.stopPropagation();
};

/* --------------------------------------------------------------------------
   Binding
   -------------------------------------------------------------------------- */

const bindRoot = (root) => {
    if (!(root instanceof HTMLElement)) {
        return;
    }

    if (root.dataset.uiDestructiveActionsInit === "true") {
        syncTypedConfirmation(root);
        return;
    }

    root.dataset.uiDestructiveActionsInit = "true";

    root.addEventListener("click", guardDisabledActionClick);

    root.querySelectorAll(TYPED_CONFIRMATION_CONTROL_SELECTOR).forEach(
        (control) => {
            if (!(control instanceof HTMLElement)) {
                return;
            }

            const input = control.querySelector(TEXT_INPUT_SELECTOR);

            if (!(input instanceof HTMLInputElement)) {
                return;
            }

            if (
                input.dataset.uiDestructiveActionsTypedConfirmationInit ===
                "true"
            ) {
                return;
            }

            input.dataset.uiDestructiveActionsTypedConfirmationInit = "true";

            input.addEventListener("input", () => {
                syncTypedConfirmation(root);
            });
        },
    );

    syncTypedConfirmation(root);
};

/* --------------------------------------------------------------------------
   Public initializer
   -------------------------------------------------------------------------- */

export function initDestructiveActions(root = document) {
    getRoots(root).forEach(bindRoot);
}
