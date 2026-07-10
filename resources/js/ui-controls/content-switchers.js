/**
 * File: resources/js/ui-controls/content-switchers.js
 * Purpose: Content switcher interaction behavior.
 *
 * Notes:
 * - Supports app-owned content switcher markup and x-ui.content-switcher output.
 * - Updates selected state for visual styling and accessibility.
 * - Does not own app-specific side effects such as theme persistence.
 * - Theme controls can still listen to data-theme-mode-toggle separately.
 * - data-ui-current is intentionally not used as selected state because some
 *   consumers use it to represent a resolved/current context that can differ
 *   from the selected switch value.
 */

const CONTENT_SWITCHER_BOUND_ATTR = "data-ui-content-switcher-bound";

const OPTION_SELECTOR = [
    "[data-ui-content-switcher-option]",
    "[data-ui-content-switcher-switch]",
    "[data-ui-switch]",
    ".ui-content-switcher-btn",
    ".ui-content-switcher-button",
    ".ui-content-switcher-option",
].join(", ");

const SELECTED_CLASSES = [
    "ui-content-switcher--selected",
    "ui-content-switcher-button-selected",
    "ui-content-switcher-option-selected",
];

/* --------------------------------------------------------------------------
   Option lookup
   -------------------------------------------------------------------------- */

const isSelectedOption = (option) => {
    return (
        option.getAttribute("aria-selected") === "true" ||
        SELECTED_CLASSES.some((className) =>
            option.classList.contains(className),
        )
    );
};

const getOptions = (switcher) => {
    return Array.from(switcher.querySelectorAll(OPTION_SELECTOR)).filter(
        (option) => option instanceof HTMLButtonElement,
    );
};

const getCurrentIndex = (options) => {
    const selectedIndex = options.findIndex(isSelectedOption);

    return selectedIndex >= 0 ? selectedIndex : 0;
};

/* --------------------------------------------------------------------------
   Selected state
   -------------------------------------------------------------------------- */

const setSelectedOption = (switcher, selectedOption) => {
    const options = getOptions(switcher);

    options.forEach((option, index) => {
        const isSelected = option === selectedOption;

        option.setAttribute("aria-selected", isSelected ? "true" : "false");
        option.setAttribute("aria-pressed", isSelected ? "true" : "false");
        option.setAttribute("tabindex", isSelected ? "0" : "-1");

        SELECTED_CLASSES.forEach((className) => {
            option.classList.toggle(className, isSelected);
        });

        option.dataset.uiContentSwitcherIndex = String(index);
    });

    switcher.dataset.uiContentSwitcherValue =
        selectedOption.dataset.uiContentSwitcherValue ||
        selectedOption.value ||
        "";
};

/* --------------------------------------------------------------------------
   Keyboard behavior
   -------------------------------------------------------------------------- */

const moveFocus = (switcher, direction, shouldSelect) => {
    const options = getOptions(switcher).filter((option) => !option.disabled);

    if (!options.length) {
        return;
    }

    const currentIndex = getCurrentIndex(options);
    const nextIndex =
        direction === "next"
            ? (currentIndex + 1) % options.length
            : (currentIndex - 1 + options.length) % options.length;

    const nextOption = options[nextIndex];

    nextOption.focus();

    if (shouldSelect) {
        setSelectedOption(switcher, nextOption);
        nextOption.click();
    }
};

const handleOptionClick = (switcher, option) => {
    if (option.disabled) {
        return;
    }

    setSelectedOption(switcher, option);
};

const handleOptionKeydown = (event, switcher, option) => {
    const selectionMode =
        switcher.dataset.uiContentSwitcherSelectionMode || "automatic";

    if (event.key === "ArrowRight" || event.key === "ArrowDown") {
        event.preventDefault();
        moveFocus(switcher, "next", selectionMode !== "manual");
        return;
    }

    if (event.key === "ArrowLeft" || event.key === "ArrowUp") {
        event.preventDefault();
        moveFocus(switcher, "previous", selectionMode !== "manual");
        return;
    }

    if (event.key === "Home") {
        event.preventDefault();

        const firstOption = getOptions(switcher).find(
            (candidate) => !candidate.disabled,
        );

        if (firstOption) {
            firstOption.focus();

            if (selectionMode !== "manual") {
                setSelectedOption(switcher, firstOption);
                firstOption.click();
            }
        }

        return;
    }

    if (event.key === "End") {
        event.preventDefault();

        const availableOptions = getOptions(switcher).filter(
            (candidate) => !candidate.disabled,
        );
        const lastOption = availableOptions[availableOptions.length - 1];

        if (lastOption) {
            lastOption.focus();

            if (selectionMode !== "manual") {
                setSelectedOption(switcher, lastOption);
                lastOption.click();
            }
        }

        return;
    }

    if (event.key === "Enter" || event.key === " ") {
        event.preventDefault();
        setSelectedOption(switcher, option);
        option.click();
    }
};

/* --------------------------------------------------------------------------
   Initializer
   -------------------------------------------------------------------------- */

export const initContentSwitchers = (root = document) => {
    root.querySelectorAll(
        "[data-ui-content-switcher], .ui-content-switcher",
    ).forEach((switcher) => {
        if (!(switcher instanceof HTMLElement)) {
            return;
        }

        if (switcher.hasAttribute(CONTENT_SWITCHER_BOUND_ATTR)) {
            return;
        }

        switcher.setAttribute(CONTENT_SWITCHER_BOUND_ATTR, "true");

        const options = getOptions(switcher);

        options.forEach((option, index) => {
            option.dataset.uiContentSwitcherIndex = String(index);

            option.addEventListener("click", () => {
                handleOptionClick(switcher, option);
            });

            option.addEventListener("keydown", (event) => {
                handleOptionKeydown(event, switcher, option);
            });
        });

        const initiallySelected = options.find(isSelectedOption) || options[0];

        if (initiallySelected) {
            setSelectedOption(switcher, initiallySelected);
        }
    });
};
