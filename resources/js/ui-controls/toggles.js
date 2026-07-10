/* ==========================================================================
   Toggle behavior
   ========================================================================== */

const TOGGLE_SELECTOR = "[data-ui-toggle]";

const isLocked = (toggle) => {
    return (
        toggle.disabled ||
        toggle.getAttribute("aria-disabled") === "true" ||
        toggle.getAttribute("data-ui-toggle-readonly") === "true"
    );
};

const isToggled = (toggle) => {
    return (
        toggle.getAttribute("aria-checked") === "true" ||
        toggle.getAttribute("aria-pressed") === "true" ||
        toggle.getAttribute("data-ui-toggle-toggled") === "true"
    );
};

const setToggleState = (toggle, toggled) => {
    toggle.setAttribute("aria-checked", toggled ? "true" : "false");
    toggle.setAttribute("aria-pressed", toggled ? "true" : "false");
    toggle.setAttribute("data-ui-toggle-toggled", toggled ? "true" : "false");

    toggle.classList.toggle("ui-toggle--checked", toggled);
    toggle.classList.toggle("ui-toggle--toggled", toggled);

    const input = toggle.querySelector('input[type="checkbox"]');

    if (input instanceof HTMLInputElement) {
        input.checked = toggled;
        input.dispatchEvent(new Event("input", { bubbles: true }));
        input.dispatchEvent(new Event("change", { bubbles: true }));
    }

    const label = toggle.querySelector("[data-ui-toggle-state-label]");
    const onLabel = toggle.getAttribute("data-ui-toggle-label-on");
    const offLabel = toggle.getAttribute("data-ui-toggle-label-off");

    if (label && (onLabel || offLabel)) {
        label.textContent = toggled ? onLabel || "" : offLabel || "";
    }

    toggle.dispatchEvent(
        new CustomEvent("ui:toggle:change", {
            bubbles: true,
            detail: { toggled },
        }),
    );
};

const toggleState = (toggle) => {
    if (isLocked(toggle)) {
        return;
    }

    setToggleState(toggle, !isToggled(toggle));
};

const handleToggleClick = (event) => {
    const toggle = event.currentTarget;

    if (!(toggle instanceof HTMLElement)) {
        return;
    }

    event.preventDefault();
    toggleState(toggle);
};

const handleToggleKeyDown = (event) => {
    const toggle = event.currentTarget;

    if (!(toggle instanceof HTMLElement)) {
        return;
    }

    if (event.key !== "Enter" && event.key !== " ") {
        return;
    }

    event.preventDefault();
    toggleState(toggle);
};

export function initToggles(root = document) {
    root.querySelectorAll(TOGGLE_SELECTOR).forEach((toggle) => {
        if (
            !(toggle instanceof HTMLElement) ||
            toggle.dataset.uiToggleInitialized === "true"
        ) {
            return;
        }

        toggle.dataset.uiToggleInitialized = "true";

        if (!toggle.hasAttribute("role")) {
            toggle.setAttribute("role", "switch");
        }

        if (
            !toggle.hasAttribute("tabindex") &&
            !toggle.hasAttribute("disabled")
        ) {
            toggle.tabIndex = 0;
        }

        setToggleState(toggle, isToggled(toggle));

        toggle.addEventListener("click", handleToggleClick);
        toggle.addEventListener("keydown", handleToggleKeyDown);
    });
}

export default initToggles;
