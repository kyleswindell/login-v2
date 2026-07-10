/* ==========================================================================
   Combo box behavior
   ========================================================================== */

const COMBO_BOX_SELECTOR = "[data-ui-combo-box], [data-ui-combobox]";
const INPUT_SELECTOR = "[data-ui-combo-box-input], [data-ui-combobox-input]";
const TRIGGER_SELECTOR =
    "[data-ui-combo-box-trigger], [data-ui-combobox-trigger]";
const CLEAR_SELECTOR = "[data-ui-combo-box-clear], [data-ui-combobox-clear]";
const MENU_SELECTOR = "[data-ui-combo-box-menu], [data-ui-combobox-menu]";
const OPTION_SELECTOR = "[data-ui-combo-box-option], [data-ui-combobox-option]";
const HIDDEN_INPUT_SELECTOR =
    "[data-ui-combo-box-hidden-input], [data-ui-combobox-hidden-input]";

const getComboBox = (element) => element.closest(COMBO_BOX_SELECTOR);

const getInput = (component) => component.querySelector(INPUT_SELECTOR);

const getTrigger = (component) => component.querySelector(TRIGGER_SELECTOR);

const getClearButton = (component) => component.querySelector(CLEAR_SELECTOR);

const getMenu = (component) => component.querySelector(MENU_SELECTOR);

const getOptions = (component) =>
    Array.from(component.querySelectorAll(OPTION_SELECTOR));

const getVisibleOptions = (component) => {
    return getOptions(component).filter((option) => {
        return (
            !option.hidden && option.getAttribute("aria-disabled") !== "true"
        );
    });
};

const getOptionValue = (option) => {
    return (
        option.getAttribute("data-ui-combo-box-option-value") ||
        option.getAttribute("data-ui-combobox-option-value") ||
        option.dataset.value ||
        ""
    );
};

const getOptionLabel = (option) => {
    return (
        option.getAttribute("data-ui-combo-box-option-label") ||
        option.getAttribute("data-ui-combobox-option-label") ||
        option.textContent?.trim() ||
        getOptionValue(option)
    );
};

const isLocked = (component) => {
    const input = getInput(component);

    return (
        component.getAttribute("data-ui-combo-box-readonly") === "true" ||
        component.getAttribute("data-ui-combobox-readonly") === "true" ||
        input?.disabled ||
        input?.readOnly
    );
};

const setOpen = (component, open) => {
    if (open && isLocked(component)) {
        return;
    }

    const input = getInput(component);
    const trigger = getTrigger(component);
    const menu = getMenu(component);

    if (!menu) {
        return;
    }

    component.setAttribute("data-ui-combo-box-open", open ? "true" : "false");
    component.classList.toggle("ui-combo-box--open", open);
    component.classList.toggle("ui-list-box--expanded", open);

    menu.hidden = !open;

    input?.setAttribute("aria-expanded", open ? "true" : "false");
    trigger?.setAttribute("aria-expanded", open ? "true" : "false");

    if (open && input instanceof HTMLInputElement) {
        input.focus();
    }
};

const syncHiddenInput = (component, value) => {
    const hiddenInput = component.querySelector(HIDDEN_INPUT_SELECTOR);

    if (hiddenInput instanceof HTMLInputElement) {
        hiddenInput.value = value;
    }
};

const syncClearButton = (component) => {
    const input = getInput(component);
    const clearButton = getClearButton(component);

    if (!clearButton || !(input instanceof HTMLInputElement)) {
        return;
    }

    clearButton.hidden = input.value.length === 0;
};

const selectOption = (component, option) => {
    if (
        isLocked(component) ||
        option.getAttribute("aria-disabled") === "true"
    ) {
        return;
    }

    const input = getInput(component);
    const value = getOptionValue(option);
    const label = getOptionLabel(option);

    getOptions(component).forEach((item) => {
        const selected = item === option;

        item.setAttribute("aria-selected", selected ? "true" : "false");
        item.setAttribute(
            "data-ui-combo-box-option-selected",
            selected ? "true" : "false",
        );
        item.classList.toggle("ui-list-box__menu-item--active", selected);
    });

    if (input instanceof HTMLInputElement) {
        input.value = label;
        input.dispatchEvent(new Event("input", { bubbles: true }));
        input.dispatchEvent(new Event("change", { bubbles: true }));
    }

    syncHiddenInput(component, value);
    syncClearButton(component);
    setOpen(component, false);

    component.dispatchEvent(
        new CustomEvent("ui:combo-box:change", {
            bubbles: true,
            detail: { value, label },
        }),
    );
};

const filterOptions = (component, query) => {
    const normalizedQuery = query.trim().toLowerCase();

    getOptions(component).forEach((option) => {
        const label = getOptionLabel(option).toLowerCase();
        option.hidden =
            normalizedQuery !== "" && !label.includes(normalizedQuery);
    });
};

const focusRelativeOption = (component, direction) => {
    const options = getVisibleOptions(component);

    if (!options.length) {
        return;
    }

    const currentIndex = options.findIndex(
        (option) => option === document.activeElement,
    );
    const nextIndex =
        currentIndex === -1
            ? 0
            : (currentIndex + direction + options.length) % options.length;

    options[nextIndex].focus();
};

const handleInput = (event) => {
    const input = event.currentTarget;
    const component = getComboBox(input);

    if (!component || isLocked(component)) {
        return;
    }

    filterOptions(component, input.value);
    syncHiddenInput(component, "");
    syncClearButton(component);
    setOpen(component, true);
};

const handleInputKeyDown = (event) => {
    const component = getComboBox(event.currentTarget);

    if (!component) {
        return;
    }

    if (event.key === "ArrowDown") {
        event.preventDefault();
        setOpen(component, true);
        focusRelativeOption(component, 1);
    } else if (event.key === "ArrowUp") {
        event.preventDefault();
        setOpen(component, true);
        focusRelativeOption(component, -1);
    } else if (event.key === "Enter") {
        if (document.activeElement?.matches(OPTION_SELECTOR)) {
            event.preventDefault();
            selectOption(component, document.activeElement);
        }
    } else if (event.key === "Escape") {
        event.preventDefault();
        setOpen(component, false);
    }
};

const handleTriggerClick = (event) => {
    const component = getComboBox(event.currentTarget);

    if (!component) {
        return;
    }

    setOpen(
        component,
        component.getAttribute("data-ui-combo-box-open") !== "true",
    );
};

const handleClearClick = (event) => {
    const component = getComboBox(event.currentTarget);
    const input = component ? getInput(component) : null;

    if (
        !component ||
        !(input instanceof HTMLInputElement) ||
        isLocked(component)
    ) {
        return;
    }

    event.preventDefault();

    input.value = "";
    syncHiddenInput(component, "");
    syncClearButton(component);
    filterOptions(component, "");
    input.focus();

    input.dispatchEvent(new Event("input", { bubbles: true }));
    input.dispatchEvent(new Event("change", { bubbles: true }));
};

const handleOptionClick = (event) => {
    const option = event.currentTarget;
    const component = getComboBox(option);

    if (component) {
        event.preventDefault();
        selectOption(component, option);
    }
};

const handleOptionKeyDown = (event) => {
    const option = event.currentTarget;
    const component = getComboBox(option);

    if (!component) {
        return;
    }

    if (event.key === "ArrowDown") {
        event.preventDefault();
        focusRelativeOption(component, 1);
    } else if (event.key === "ArrowUp") {
        event.preventDefault();
        focusRelativeOption(component, -1);
    } else if (event.key === "Enter" || event.key === " ") {
        event.preventDefault();
        selectOption(component, option);
    } else if (event.key === "Escape") {
        event.preventDefault();
        setOpen(component, false);
        getInput(component)?.focus();
    }
};

const handleDocumentMouseDown = (event) => {
    if (!(event.target instanceof Node)) {
        return;
    }

    document.querySelectorAll(COMBO_BOX_SELECTOR).forEach((component) => {
        if (!component.contains(event.target)) {
            setOpen(component, false);
        }
    });
};

export function initComboBoxes(root = document) {
    if (document.body?.dataset.uiComboBoxDocumentInit !== "true") {
        document.body.dataset.uiComboBoxDocumentInit = "true";
        document.addEventListener("mousedown", handleDocumentMouseDown);
    }

    root.querySelectorAll(COMBO_BOX_SELECTOR).forEach((component) => {
        if (component.dataset.uiComboBoxInitialized === "true") {
            return;
        }

        component.dataset.uiComboBoxInitialized = "true";

        getInput(component)?.addEventListener("input", handleInput);
        getInput(component)?.addEventListener("keydown", handleInputKeyDown);
        getInput(component)?.addEventListener("focus", () =>
            setOpen(component, true),
        );
        getTrigger(component)?.addEventListener("click", handleTriggerClick);
        getClearButton(component)?.addEventListener("click", handleClearClick);

        getOptions(component).forEach((option) => {
            option.tabIndex = -1;
            option.addEventListener("click", handleOptionClick);
            option.addEventListener("keydown", handleOptionKeyDown);
        });

        syncClearButton(component);
    });
}

export default initComboBoxes;
