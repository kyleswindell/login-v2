/* ==========================================================================
   Text input behavior
   ========================================================================== */

/**
 * Resolve the password input controlled by a visibility toggle.
 *
 * The preferred contract is data-ui-password-toggle-target="{inputId}".
 * Fallback selectors are retained for older text input markup.
 */
const getPasswordInputForToggle = (button, root = document) => {
    const targetId = button.getAttribute("data-ui-password-toggle-target");

    if (targetId) {
        const target = document.getElementById(targetId);

        if (target instanceof HTMLInputElement) {
            return target;
        }
    }

    const scope = button.closest(
        "[data-ui-password-input-wrapper], [data-ui-text-input-wrapper], [data-ui-text-input], .ui-password-input-wrapper, .ui-text-input-wrapper",
    );

    const searchRoot = scope || root;

    return searchRoot.querySelector(
        '[data-ui-password-input], [data-ui-text-input-control], input.ui-password-input, input[type="password"], input[type="text"]',
    );
};

/**
 * Synchronize the visibility toggle button with the current input type.
 */
const syncPasswordToggle = (button, input) => {
    const isVisible = input.type === "text";

    const showLabel =
        button.getAttribute("data-ui-password-show-label") || "Show password";
    const hideLabel =
        button.getAttribute("data-ui-password-hide-label") || "Hide password";
    const nextLabel = isVisible ? hideLabel : showLabel;

    button.setAttribute("aria-pressed", isVisible ? "true" : "false");
    button.setAttribute("aria-label", nextLabel);

    input.setAttribute(
        "data-toggle-password-visibility",
        input.type === "password" ? "true" : "false",
    );

    const assistiveText = button.querySelector(".ui-assistive-text");

    if (assistiveText) {
        assistiveText.textContent = nextLabel;
    }

    const visibleIcon = button.querySelector(".ui-icon-visibility-on");
    const hiddenIcon = button.querySelector(".ui-icon-visibility-off");

    if (visibleIcon) {
        if (isVisible) {
            visibleIcon.setAttribute("hidden", "");
        } else {
            visibleIcon.removeAttribute("hidden");
        }
    }

    if (hiddenIcon) {
        if (isVisible) {
            hiddenIcon.removeAttribute("hidden");
        } else {
            hiddenIcon.setAttribute("hidden", "");
        }
    }
};

/**
 * Initialize text input behaviors.
 *
 * Current behavior scope:
 * - password visibility toggle
 */
export function initTextInputs(root = document) {
    root.querySelectorAll("[data-ui-password-toggle]").forEach((button) => {
        if (
            !(button instanceof HTMLButtonElement) ||
            button.dataset.uiPasswordToggleInit === "1"
        ) {
            return;
        }

        const input = getPasswordInputForToggle(button, root);

        if (!(input instanceof HTMLInputElement)) {
            button.dataset.uiPasswordToggleInit = "1";
            return;
        }

        button.dataset.uiPasswordToggleInit = "1";
        syncPasswordToggle(button, input);

        button.addEventListener("click", () => {
            if (input.disabled || input.readOnly || button.disabled) {
                return;
            }

            input.type = input.type === "password" ? "text" : "password";

            syncPasswordToggle(button, input);
            input.focus();
        });
    });
}
