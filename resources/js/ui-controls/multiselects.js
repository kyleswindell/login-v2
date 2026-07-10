/* ==========================================================================
   MultiSelect behavior
   ========================================================================== */

/**
 * Selector contract used by multi-select.blade.php and
 * filterable-multi-select.blade.php.
 */
const MULTI_SELECT_SELECTOR = "[data-ui-multi-select]";
const FILTERABLE_MULTI_SELECT_SELECTOR = "[data-ui-filterable-multi-select]";
const TRIGGER_SELECTOR = "[data-ui-multi-select-trigger]";
const INPUT_SELECTOR =
    "[data-ui-multi-select-input], [data-ui-filterable-multi-select-input]";
const MENU_SELECTOR = "[data-ui-multi-select-menu]";
const OPTION_SELECTOR = "[data-ui-multi-select-option]";
const CHECKBOX_SELECTOR = "[data-ui-multi-select-checkbox]";
const CLEAR_SELECTOR = "[data-ui-multi-select-clear]";
const HIDDEN_INPUTS_SELECTOR = "[data-ui-multi-select-hidden-inputs]";
const HIDDEN_INPUT_SELECTOR = "[data-ui-multi-select-hidden-input]";
const ANNOUNCEMENT_SELECTOR = "[data-ui-multi-select-clear-announcement]";
const CLEAR_DESCRIPTION_SELECTOR = "[data-ui-multi-select-clear-description]";

/* ==========================================================================
   Lookup helpers
   ========================================================================== */

/**
 * Find the MultiSelect root for a child element.
 */
const getMultiSelect = (element) => {
    return element.closest(MULTI_SELECT_SELECTOR);
};

/**
 * Get the trigger button for a MultiSelect.
 */
const getTrigger = (component) => {
    return component.querySelector(TRIGGER_SELECTOR);
};

/**
 * Get the filter input for a filterable MultiSelect.
 */
const getFilterInput = (component) => {
    return component.querySelector(INPUT_SELECTOR);
};

/**
 * Get the menu element for a MultiSelect.
 */
const getMenu = (component) => {
    return component.querySelector(MENU_SELECTOR);
};

/**
 * Get all options for a MultiSelect.
 */
const getOptions = (component) => {
    return Array.from(component.querySelectorAll(OPTION_SELECTOR));
};

/**
 * Get visible, enabled, selectable options.
 */
const getFocusableOptions = (component) => {
    return getOptions(component).filter((option) => {
        return (
            !option.hidden &&
            option.getAttribute("aria-disabled") !== "true" &&
            option.getAttribute("data-ui-multi-select-option-disabled") !==
                "true"
        );
    });
};

/**
 * Determine whether an option is the select-all control.
 */
const isSelectAllOption = (option) => {
    return (
        option.getAttribute("data-ui-multi-select-option-select-all") === "true"
    );
};

/**
 * Determine whether an option is disabled.
 */
const isDisabledOption = (option) => {
    return (
        option.getAttribute("aria-disabled") === "true" ||
        option.getAttribute("data-ui-multi-select-option-disabled") === "true"
    );
};

/**
 * Determine whether a MultiSelect is locked from user changes.
 */
const isLocked = (component) => {
    const trigger = getTrigger(component);
    const input = getFilterInput(component);

    return (
        component.getAttribute("data-ui-multi-select-readonly") === "true" ||
        trigger?.disabled ||
        input?.disabled ||
        input?.readOnly ||
        component.classList.contains("ui-list-box--disabled")
    );
};

/**
 * Get option value.
 */
const getOptionValue = (option) => {
    return option.getAttribute("data-ui-multi-select-option-value") || "";
};

/**
 * Get option label.
 */
const getOptionLabel = (option) => {
    return (
        option.getAttribute("data-ui-multi-select-option-label") ||
        option.textContent?.trim() ||
        getOptionValue(option)
    );
};

/**
 * Determine whether an option is selected.
 */
const isSelected = (option) => {
    return (
        option.getAttribute("data-ui-multi-select-option-selected") ===
            "true" ||
        option.getAttribute("aria-checked") === "true" ||
        option.getAttribute("aria-selected") === "true"
    );
};

/**
 * Set active descendant highlight.
 */
const setHighlightedOption = (component, option) => {
    getOptions(component).forEach((item) => {
        item.classList.toggle(
            "ui-list-box__menu-item--highlighted",
            item === option,
        );
        item.classList.toggle("is-highlighted", item === option);
        item.tabIndex = item === option ? 0 : -1;
    });

    if (option) {
        component.dataset.uiMultiSelectHighlightedId = option.id || "";
        option.scrollIntoView({ block: "nearest" });
    } else {
        delete component.dataset.uiMultiSelectHighlightedId;
    }
};

/**
 * Get highlighted option.
 */
const getHighlightedOption = (component) => {
    const id = component.dataset.uiMultiSelectHighlightedId;

    if (id) {
        const option = component.querySelector(`#${CSS.escape(id)}`);

        if (option && !option.hidden && !isDisabledOption(option)) {
            return option;
        }
    }

    return component.querySelector(
        ".ui-list-box__menu-item--highlighted:not([hidden])",
    );
};

/* ==========================================================================
   Selection state
   ========================================================================== */

/**
 * Set selected state on an option.
 */
const setOptionSelected = (option, selected) => {
    const checkbox = option.querySelector(CHECKBOX_SELECTOR);

    option.setAttribute("aria-checked", selected ? "true" : "false");
    option.setAttribute("aria-selected", selected ? "true" : "false");
    option.setAttribute(
        "data-ui-multi-select-option-selected",
        selected ? "true" : "false",
    );

    option.classList.toggle("ui-list-box__menu-item--active", selected);
    option.classList.toggle("ui-list-box-menu-item-selected", selected);
    option.classList.toggle("is-selected", selected);

    if (checkbox instanceof HTMLInputElement) {
        checkbox.checked = selected;
        checkbox.indeterminate = false;
        checkbox.removeAttribute("data-ui-checkbox-indeterminate");
        checkbox.setAttribute("aria-checked", selected ? "true" : "false");
    }
};

/**
 * Set indeterminate state on an option checkbox.
 */
const setOptionIndeterminate = (option, indeterminate) => {
    const checkbox = option.querySelector(CHECKBOX_SELECTOR);

    if (indeterminate) {
        option.setAttribute("aria-checked", "mixed");
        option.setAttribute(
            "data-ui-multi-select-option-indeterminate",
            "true",
        );
    } else {
        option.removeAttribute("data-ui-multi-select-option-indeterminate");
    }

    if (checkbox instanceof HTMLInputElement) {
        checkbox.indeterminate = indeterminate;

        if (indeterminate) {
            checkbox.setAttribute("aria-checked", "mixed");
            checkbox.setAttribute("data-ui-checkbox-indeterminate", "true");
        } else {
            checkbox.removeAttribute("data-ui-checkbox-indeterminate");
        }
    }
};

/**
 * Get selected non-select-all options.
 */
const getSelectedOptions = (component) => {
    return getOptions(component).filter((option) => {
        return !isSelectAllOption(option) && isSelected(option);
    });
};

/**
 * Get visible selectable options, excluding select-all.
 */
const getVisibleSelectableOptions = (component) => {
    return getOptions(component).filter((option) => {
        return (
            !option.hidden &&
            !isSelectAllOption(option) &&
            !isDisabledOption(option)
        );
    });
};

/**
 * Sync select-all checked and indeterminate state.
 */
const syncSelectAllState = (component) => {
    const selectAll = getOptions(component).find(isSelectAllOption);

    if (!selectAll) {
        return;
    }

    const visibleOptions = getVisibleSelectableOptions(component);
    const selectedVisibleOptions = visibleOptions.filter(isSelected);

    const checked =
        visibleOptions.length > 0 &&
        selectedVisibleOptions.length === visibleOptions.length;

    const indeterminate =
        selectedVisibleOptions.length > 0 &&
        selectedVisibleOptions.length < visibleOptions.length;

    setOptionSelected(selectAll, checked);
    setOptionIndeterminate(selectAll, indeterminate);

    selectAll.hidden = visibleOptions.length === 0;
};

/**
 * Toggle an individual option.
 */
const toggleOption = (component, option) => {
    if (isLocked(component) || isDisabledOption(option)) {
        return;
    }

    if (isSelectAllOption(option)) {
        toggleAllVisibleOptions(component);
        return;
    }

    setOptionSelected(option, !isSelected(option));

    syncSelectAllState(component);
    syncSelectionState(component);
};

/**
 * Toggle all currently visible options.
 */
const toggleAllVisibleOptions = (component) => {
    if (isLocked(component)) {
        return;
    }

    const visibleOptions = getVisibleSelectableOptions(component);
    const selectedVisibleOptions = visibleOptions.filter(isSelected);

    const shouldSelect =
        selectedVisibleOptions.length !== visibleOptions.length;

    visibleOptions.forEach((option) => {
        setOptionSelected(option, shouldSelect);
    });

    syncSelectAllState(component);
    syncSelectionState(component);
};

/**
 * Clear all selected options.
 */
const clearSelection = (component) => {
    if (isLocked(component)) {
        return;
    }

    getOptions(component).forEach((option) => {
        setOptionSelected(option, false);
        setOptionIndeterminate(option, false);
    });

    syncSelectionState(component);

    const announcement = component.querySelector(ANNOUNCEMENT_SELECTOR);

    if (announcement) {
        announcement.textContent = "All items have been cleared";
    }
};

/* ==========================================================================
   Hidden inputs and selected count
   ========================================================================== */

/**
 * Resolve submitted field name for hidden inputs.
 */
const getHiddenInputName = (component) => {
    const directName =
        component.getAttribute("data-ui-multi-select-name") ||
        component.dataset.uiMultiSelectName;

    if (directName) {
        return directName;
    }

    const existingInput = component.querySelector(HIDDEN_INPUT_SELECTOR);

    return existingInput?.getAttribute("name") || null;
};

/**
 * Get or create the hidden input container.
 */
const getHiddenInputContainer = (component) => {
    let container = component.querySelector(HIDDEN_INPUTS_SELECTOR);

    if (!container) {
        container = document.createElement("div");
        container.setAttribute("data-ui-multi-select-hidden-inputs", "");

        component.appendChild(container);
    }

    return container;
};

/**
 * Sync hidden inputs for form submission.
 */
const syncHiddenInputs = (component) => {
    const name = getHiddenInputName(component);

    if (!name) {
        return;
    }

    const container = getHiddenInputContainer(component);

    container.querySelectorAll(HIDDEN_INPUT_SELECTOR).forEach((input) => {
        input.remove();
    });

    getSelectedOptions(component).forEach((option) => {
        const input = document.createElement("input");

        input.type = "hidden";
        input.name = name;
        input.value = getOptionValue(option);
        input.setAttribute("data-ui-multi-select-hidden-input", "");

        container.appendChild(input);
    });
};

/**
 * Sync selected count UI.
 */
const syncSelectionCount = (component) => {
    const selectedCount = getSelectedOptions(component).length;
    const clearButton = component.querySelector(CLEAR_SELECTOR);
    const count = component.querySelector(
        "[data-ui-multi-select-selection-count]",
    );
    const description =
        component
            .closest("[data-ui-multi-select-wrapper]")
            ?.querySelector(CLEAR_DESCRIPTION_SELECTOR) ||
        component.parentElement?.querySelector(CLEAR_DESCRIPTION_SELECTOR);

    if (count) {
        count.textContent = String(selectedCount);
    }

    if (clearButton) {
        clearButton.hidden = selectedCount === 0;
    }

    if (description) {
        const text = description.textContent || "";
        const normalized = text.replace(
            /Total items selected:\s*\d+/i,
            `Total items selected: ${selectedCount}`,
        );
        description.textContent = normalized;
    }

    component.classList.toggle("ui-multi-select--selected", selectedCount > 0);
};

/**
 * Sync all selection-related state.
 */
const syncSelectionState = (component) => {
    syncHiddenInputs(component);
    syncSelectionCount(component);

    component.dispatchEvent(
        new CustomEvent("ui:multi-select:change", {
            bubbles: true,
            detail: {
                selectedValues:
                    getSelectedOptions(component).map(getOptionValue),
                selectedLabels:
                    getSelectedOptions(component).map(getOptionLabel),
            },
        }),
    );
};

/* ==========================================================================
   Open / close
   ========================================================================== */

/**
 * Open or close the menu.
 */
const setOpen = (component, open) => {
    if (isLocked(component) && open) {
        return;
    }

    const trigger = getTrigger(component);
    const input = getFilterInput(component);
    const menu = getMenu(component);

    if (!menu) {
        return;
    }

    menu.hidden = !open;

    component.setAttribute(
        "data-ui-multi-select-open",
        open ? "true" : "false",
    );
    component.classList.toggle("ui-list-box--expanded", open);
    component.classList.toggle("ui-multi-select--open", open);

    if (trigger) {
        trigger.setAttribute("aria-expanded", open ? "true" : "false");
        trigger.classList.toggle("ui-list-box-expanded", open);
    }

    if (input) {
        input.setAttribute("aria-expanded", open ? "true" : "false");
    }

    menu.classList.toggle("ui-list-box__menu--open", open);
    menu.classList.toggle("ui-list-box-menu-open", open);

    if (open) {
        const focusTarget =
            input instanceof HTMLInputElement
                ? input
                : getSelectedOptions(component)[0] ||
                  getFocusableOptions(component)[0];

        if (focusTarget instanceof HTMLElement) {
            focusTarget.focus();
        }

        setHighlightedOption(
            component,
            getFocusableOptions(component)[0] || null,
        );
    } else {
        setHighlightedOption(component, null);
    }

    component.dispatchEvent(
        new CustomEvent("ui:multi-select:menu-change", {
            bubbles: true,
            detail: { open },
        }),
    );
};

/**
 * Close all open MultiSelects except an optional component.
 */
const closeOtherMultiSelects = (except = null) => {
    document.querySelectorAll(MULTI_SELECT_SELECTOR).forEach((component) => {
        if (component !== except) {
            setOpen(component, false);
        }
    });
};

/* ==========================================================================
   Filtering
   ========================================================================== */

/**
 * Filter options by label.
 */
const filterOptions = (component, query) => {
    const normalizedQuery = query.trim().toLowerCase();

    getOptions(component).forEach((option) => {
        if (isSelectAllOption(option)) {
            return;
        }

        const label = getOptionLabel(option).toLowerCase();
        option.hidden =
            normalizedQuery !== "" && !label.includes(normalizedQuery);
    });

    syncSelectAllState(component);

    const firstOption = getFocusableOptions(component)[0] || null;

    setHighlightedOption(component, firstOption);
};

/* ==========================================================================
   Focus helpers
   ========================================================================== */

/**
 * Move highlighted option by relative offset.
 */
const moveHighlight = (component, delta) => {
    const options = getFocusableOptions(component);

    if (!options.length) {
        return;
    }

    const current = getHighlightedOption(component);
    const currentIndex = options.findIndex((option) => option === current);
    const nextIndex =
        currentIndex === -1
            ? 0
            : (currentIndex + delta + options.length) % options.length;

    setHighlightedOption(component, options[nextIndex]);
    options[nextIndex].focus();
};

/**
 * Move highlight to first or last option.
 */
const moveHighlightToEdge = (component, edge) => {
    const options = getFocusableOptions(component);

    if (!options.length) {
        return;
    }

    const option = edge === "last" ? options[options.length - 1] : options[0];

    setHighlightedOption(component, option);
    option.focus();
};

/* ==========================================================================
   Event handlers
   ========================================================================== */

/**
 * Handle trigger click.
 */
const handleTriggerClick = (event) => {
    const component = getMultiSelect(event.currentTarget);

    if (!component) {
        return;
    }

    const open = component.getAttribute("data-ui-multi-select-open") !== "true";

    closeOtherMultiSelects(component);
    setOpen(component, open);
};

/**
 * Handle trigger keydown.
 */
const handleTriggerKeyDown = (event) => {
    const component = getMultiSelect(event.currentTarget);

    if (!component) {
        return;
    }

    if (event.key === "Delete" || event.key === "Backspace") {
        if (component.getAttribute("data-ui-multi-select-open") !== "true") {
            event.preventDefault();
            clearSelection(component);
        }

        return;
    }

    if (["ArrowDown", "ArrowUp", "Enter", " "].includes(event.key)) {
        event.preventDefault();
        closeOtherMultiSelects(component);
        setOpen(component, true);
    }

    if (event.key === "Escape") {
        event.preventDefault();
        setOpen(component, false);
    }
};

/**
 * Handle filter input.
 */
const handleFilterInput = (event) => {
    const input = event.currentTarget;
    const component = getMultiSelect(input);

    if (!component || isLocked(component)) {
        return;
    }

    filterOptions(component, input.value);
    setOpen(component, true);
};

/**
 * Handle filter click/focus.
 */
const handleFilterFocus = (event) => {
    const component = getMultiSelect(event.currentTarget);

    if (!component || isLocked(component)) {
        return;
    }

    setOpen(component, true);
};

/**
 * Handle option click.
 */
const handleOptionClick = (event) => {
    const option = event.currentTarget;
    const component = getMultiSelect(option);

    if (!component) {
        return;
    }

    event.preventDefault();
    toggleOption(component, option);
};

/**
 * Handle option keydown.
 */
const handleOptionKeyDown = (event) => {
    const option = event.currentTarget;
    const component = getMultiSelect(option);

    if (!component) {
        return;
    }

    if (event.key === "ArrowDown") {
        event.preventDefault();
        moveHighlight(component, 1);
    } else if (event.key === "ArrowUp") {
        event.preventDefault();
        moveHighlight(component, -1);
    } else if (event.key === "Home") {
        event.preventDefault();
        moveHighlightToEdge(component, "first");
    } else if (event.key === "End") {
        event.preventDefault();
        moveHighlightToEdge(component, "last");
    } else if (event.key === "Escape") {
        event.preventDefault();
        setOpen(component, false);
        getTrigger(component)?.focus();
        getFilterInput(component)?.focus();
    } else if (event.key === "Enter" || event.key === " ") {
        event.preventDefault();
        toggleOption(component, option);
    } else if (event.key === "Tab") {
        setOpen(component, false);
    }
};

/**
 * Handle filter keydown.
 */
const handleFilterKeyDown = (event) => {
    const component = getMultiSelect(event.currentTarget);

    if (!component) {
        return;
    }

    if (event.key === "ArrowDown") {
        event.preventDefault();
        setOpen(component, true);
        moveHighlight(component, 1);
    } else if (event.key === "ArrowUp") {
        event.preventDefault();
        setOpen(component, true);
        moveHighlight(component, -1);
    } else if (event.key === "Escape") {
        event.preventDefault();

        if (event.currentTarget.value) {
            event.currentTarget.value = "";
            filterOptions(component, "");
        } else {
            setOpen(component, false);
        }
    } else if (event.key === "Enter") {
        const option = getHighlightedOption(component);

        if (option) {
            event.preventDefault();
            toggleOption(component, option);
        }
    } else if (event.key === "Tab") {
        setOpen(component, false);
    }
};

/**
 * Handle clear button click.
 */
const handleClearClick = (event) => {
    const component = getMultiSelect(event.currentTarget);

    if (!component) {
        return;
    }

    event.preventDefault();
    clearSelection(component);
    getTrigger(component)?.focus();
    getFilterInput(component)?.focus();
};

/**
 * Handle outside click.
 */
const handleDocumentMouseDown = (event) => {
    const target = event.target;

    if (!(target instanceof Node)) {
        return;
    }

    document.querySelectorAll(MULTI_SELECT_SELECTOR).forEach((component) => {
        if (!component.contains(target)) {
            setOpen(component, false);
        }
    });
};

/* ==========================================================================
   Initialization
   ========================================================================== */

/**
 * Initialize one option.
 */
const initOption = (option) => {
    if (
        !(option instanceof HTMLElement) ||
        option.dataset.uiMultiSelectOptionInit === "true"
    ) {
        return;
    }

    option.dataset.uiMultiSelectOptionInit = "true";
    option.tabIndex = -1;

    const checkbox = option.querySelector(CHECKBOX_SELECTOR);

    if (checkbox instanceof HTMLInputElement) {
        checkbox.tabIndex = -1;
        checkbox.indeterminate =
            option.getAttribute("data-ui-multi-select-option-indeterminate") ===
            "true";
    }

    option.addEventListener("click", handleOptionClick);
    option.addEventListener("keydown", handleOptionKeyDown);
};

/**
 * Initialize one MultiSelect component.
 */
const initMultiSelect = (component) => {
    if (
        !(component instanceof HTMLElement) ||
        component.dataset.uiMultiSelectInitialized === "true"
    ) {
        return;
    }

    component.dataset.uiMultiSelectInitialized = "true";

    const trigger = getTrigger(component);
    const input = getFilterInput(component);
    const clear = component.querySelector(CLEAR_SELECTOR);

    trigger?.addEventListener("click", handleTriggerClick);
    trigger?.addEventListener("keydown", handleTriggerKeyDown);

    input?.addEventListener("input", handleFilterInput);
    input?.addEventListener("focus", handleFilterFocus);
    input?.addEventListener("click", handleFilterFocus);
    input?.addEventListener("keydown", handleFilterKeyDown);

    clear?.addEventListener("click", handleClearClick);

    getOptions(component).forEach((option) => {
        initOption(option);
    });

    syncSelectAllState(component);
    syncSelectionState(component);

    if (component.getAttribute("data-ui-multi-select-open") === "true") {
        setOpen(component, true);
    }
};

/**
 * Initialize MultiSelect behavior.
 */
export function initMultiselects(root = document) {
    if (document.body?.dataset.uiMultiSelectDocumentInit !== "true") {
        document.body.dataset.uiMultiSelectDocumentInit = "true";
        document.addEventListener("mousedown", handleDocumentMouseDown);
    }

    root.querySelectorAll(MULTI_SELECT_SELECTOR).forEach((component) => {
        initMultiSelect(component);
    });
}

export default initMultiselects;
