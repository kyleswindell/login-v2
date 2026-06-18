const getDropdownParts = (root) => {
    const trigger = root.querySelector("[data-ui-dropdown-trigger]");
    const menu = root.querySelector("[data-ui-dropdown-menu]");
    const listBox = root.querySelector(
        "[data-ui-dropdown-list-box], [data-ui-list-box]",
    );
    const hiddenInput = root.querySelector("[data-ui-dropdown-hidden-input]");
    const triggerValue = root.querySelector("[data-ui-dropdown-value]");

    if (
        !(trigger instanceof HTMLButtonElement) ||
        !(menu instanceof HTMLElement) ||
        !(listBox instanceof HTMLElement)
    ) {
        return null;
    }

    return {
        trigger,
        menu,
        listBox,
        hiddenInput,
        triggerValue,
    };
};

const getEnabledOptions = (root) => {
    return Array.from(
        root.querySelectorAll("[data-ui-dropdown-option]"),
    ).filter((option) => {
        return (
            option instanceof HTMLButtonElement &&
            !option.disabled &&
            option.getAttribute("aria-disabled") !== "true"
        );
    });
};

const getSelectedOption = (root) => {
    const selected = root.querySelector(
        '[data-ui-dropdown-option][aria-selected="true"]:not(:disabled)',
    );

    return selected instanceof HTMLButtonElement &&
        selected.getAttribute("aria-disabled") !== "true"
        ? selected
        : null;
};

const clearHighlightedOption = (root) => {
    root.querySelectorAll("[data-ui-dropdown-option]").forEach((option) => {
        option.classList.remove(
            "ui-list-box-menu-item-highlighted",
            "is-highlighted",
        );
    });

    const parts = getDropdownParts(root);

    if (parts) {
        parts.trigger.removeAttribute("aria-activedescendant");
    }
};

const setHighlightedOption = (root, option) => {
    const parts = getDropdownParts(root);

    if (!parts || !(option instanceof HTMLButtonElement)) {
        return;
    }

    clearHighlightedOption(root);

    if (!option.id) {
        const value =
            option.dataset.uiDropdownOptionValue ||
            option.dataset.uiDropdownValue ||
            Math.random().toString(36).slice(2);

        option.id = `${parts.trigger.id || "dropdown"}-option-${String(value)
            .toLowerCase()
            .replace(/[^a-z0-9_-]+/g, "-")}`;
    }

    option.classList.add("ui-list-box-menu-item-highlighted", "is-highlighted");
    parts.trigger.setAttribute("aria-activedescendant", option.id);

    option.scrollIntoView({
        block: "nearest",
    });
};

const getHighlightedOption = (root) => {
    const highlighted = root.querySelector(
        "[data-ui-dropdown-option].ui-list-box-menu-item-highlighted",
    );

    return highlighted instanceof HTMLButtonElement ? highlighted : null;
};

const setOpenState = (root, isOpen) => {
    const parts = getDropdownParts(root);

    if (!parts) {
        return;
    }

    const { trigger, menu, listBox } = parts;

    root.dataset.uiDropdownOpen = isOpen ? "true" : "false";
    root.classList.toggle("ui-dropdown-open", isOpen);
    root.classList.toggle("ui-dropdown-focus", isOpen);

    listBox.classList.toggle("ui-list-box-expanded", isOpen);

    if (isOpen) {
        listBox.dataset.uiListBoxExpanded = "true";
    } else {
        delete listBox.dataset.uiListBoxExpanded;
    }

    trigger.setAttribute("aria-expanded", isOpen ? "true" : "false");

    menu.hidden = !isOpen;
    menu.classList.toggle("ui-list-box-menu-open", isOpen);
};

const closeDropdown = (root, { restoreFocus = false } = {}) => {
    const parts = getDropdownParts(root);

    if (!parts) {
        return;
    }

    setOpenState(root, false);
    clearHighlightedOption(root);

    if (restoreFocus) {
        parts.trigger.focus();
    }
};

const openDropdown = (root, { highlight = "selected" } = {}) => {
    const parts = getDropdownParts(root);

    if (!parts) {
        return;
    }

    if (
        root.dataset.uiDropdownReadonly === "true" ||
        root.classList.contains("ui-dropdown-disabled") ||
        parts.trigger.disabled
    ) {
        return;
    }

    document.querySelectorAll("[data-ui-dropdown]").forEach((otherRoot) => {
        if (otherRoot !== root && otherRoot instanceof HTMLElement) {
            closeDropdown(otherRoot);
        }
    });

    setOpenState(root, true);

    window.requestAnimationFrame(() => {
        const options = getEnabledOptions(root);

        if (options.length === 0) {
            return;
        }

        const selectedOption = getSelectedOption(root);
        let target = selectedOption ?? options[0];

        if (highlight === "first") {
            target = options[0];
        }

        if (highlight === "last") {
            target = options[options.length - 1];
        }

        setHighlightedOption(root, target);
    });
};

const focusDropdownOption = (root, placement) => {
    const options = getEnabledOptions(root);

    if (options.length === 0) {
        return;
    }

    const target =
        placement === "last" ? options[options.length - 1] : options[0];
    setHighlightedOption(root, target);
};

const focusRelativeOption = (root, direction) => {
    const options = getEnabledOptions(root);

    if (options.length === 0) {
        return;
    }

    const highlighted = getHighlightedOption(root);
    const currentIndex = highlighted
        ? options.findIndex((option) => option === highlighted)
        : -1;

    const nextIndex =
        currentIndex === -1
            ? direction > 0
                ? 0
                : options.length - 1
            : (currentIndex + direction + options.length) % options.length;

    setHighlightedOption(root, options[nextIndex]);
};

const selectDropdownOption = (root, option) => {
    const parts = getDropdownParts(root);

    if (!parts || !(option instanceof HTMLButtonElement)) {
        return;
    }

    if (option.disabled || option.getAttribute("aria-disabled") === "true") {
        return;
    }

    const { hiddenInput, triggerValue } = parts;

    const optionValue =
        option.dataset.uiDropdownOptionValue ||
        option.dataset.uiDropdownValue ||
        "";

    const optionLabel =
        option.dataset.uiDropdownOptionLabel ||
        option.textContent?.trim() ||
        optionValue;

    if (hiddenInput instanceof HTMLInputElement) {
        hiddenInput.value = optionValue;

        hiddenInput.dispatchEvent(
            new Event("input", {
                bubbles: true,
            }),
        );

        hiddenInput.dispatchEvent(
            new Event("change", {
                bubbles: true,
            }),
        );
    }

    if (triggerValue instanceof HTMLElement) {
        triggerValue.textContent = optionLabel;
        triggerValue.classList.remove("ui-dropdown-placeholder");
    }

    root.querySelectorAll("[data-ui-dropdown-option]").forEach((item) => {
        const isSelected = item === option;

        item.setAttribute("aria-selected", isSelected ? "true" : "false");

        item.classList.toggle("ui-dropdown-option-selected", isSelected);
        item.classList.toggle("ui-dropdown-selected", isSelected);
        item.classList.toggle("ui-list-box-menu-item-selected", isSelected);
        item.classList.toggle("ui-list-box-menu-item-active", isSelected);
        item.classList.remove(
            "ui-list-box-menu-item-highlighted",
            "is-highlighted",
        );
    });

    closeDropdown(root, {
        restoreFocus: true,
    });
};

const handleTriggerKeydown = (dropdown, event) => {
    const isReadonly = dropdown.dataset.uiDropdownReadonly === "true";
    const isOpen = dropdown.dataset.uiDropdownOpen === "true";
    const highlighted = getHighlightedOption(dropdown);

    if (isReadonly) {
        if (["ArrowDown", "ArrowUp", "Enter", " "].includes(event.key)) {
            event.preventDefault();
        }

        return;
    }

    if (event.key === "ArrowDown") {
        event.preventDefault();

        if (!isOpen) {
            openDropdown(dropdown, {
                highlight: "selected",
            });
            return;
        }

        focusRelativeOption(dropdown, 1);
        return;
    }

    if (event.key === "ArrowUp") {
        event.preventDefault();

        if (!isOpen) {
            openDropdown(dropdown, {
                highlight: "last",
            });
            return;
        }

        focusRelativeOption(dropdown, -1);
        return;
    }

    if (event.key === "Home" && isOpen) {
        event.preventDefault();
        focusDropdownOption(dropdown, "first");
        return;
    }

    if (event.key === "End" && isOpen) {
        event.preventDefault();
        focusDropdownOption(dropdown, "last");
        return;
    }

    if (event.key === "Enter" || event.key === " ") {
        event.preventDefault();

        if (!isOpen) {
            openDropdown(dropdown, {
                highlight: "selected",
            });
            return;
        }

        if (highlighted) {
            selectDropdownOption(dropdown, highlighted);
        }

        return;
    }

    if (event.key === "Escape" && isOpen) {
        event.preventDefault();
        closeDropdown(dropdown, {
            restoreFocus: true,
        });
    }
};

export function initDropdowns(root = document) {
    root.querySelectorAll("[data-ui-dropdown]").forEach((dropdown) => {
        if (
            !(dropdown instanceof HTMLElement) ||
            dropdown.dataset.uiDropdownInit === "1"
        ) {
            return;
        }

        const parts = getDropdownParts(dropdown);

        if (!parts) {
            return;
        }

        const { trigger, menu, listBox } = parts;
        const options = Array.from(
            dropdown.querySelectorAll("[data-ui-dropdown-option]"),
        );

        dropdown.dataset.uiDropdownInit = "1";

        if (dropdown.dataset.uiDropdownOpen === "true") {
            setOpenState(dropdown, true);
            openDropdown(dropdown, {
                highlight: "selected",
            });
        } else {
            setOpenState(dropdown, false);
        }

        trigger.addEventListener("click", () => {
            if (dropdown.dataset.uiDropdownReadonly === "true") {
                trigger.focus();
                return;
            }

            if (trigger.getAttribute("aria-expanded") === "true") {
                closeDropdown(dropdown, {
                    restoreFocus: true,
                });
                return;
            }

            openDropdown(dropdown, {
                highlight: "selected",
            });
        });

        trigger.addEventListener("keydown", (event) => {
            handleTriggerKeydown(dropdown, event);
        });

        dropdown.addEventListener("focusin", () => {
            dropdown.classList.add("ui-dropdown-focus");
        });

        dropdown.addEventListener("focusout", () => {
            window.requestAnimationFrame(() => {
                if (!dropdown.contains(document.activeElement)) {
                    closeDropdown(dropdown);
                    dropdown.classList.remove("ui-dropdown-focus");
                }
            });
        });

        menu.addEventListener("mousemove", (event) => {
            const option =
                event.target instanceof HTMLElement
                    ? event.target.closest("[data-ui-dropdown-option]")
                    : null;

            if (option instanceof HTMLButtonElement) {
                setHighlightedOption(dropdown, option);
            }
        });

        options.forEach((option) => {
            if (!(option instanceof HTMLButtonElement)) {
                return;
            }

            option.addEventListener("click", () => {
                selectDropdownOption(dropdown, option);
            });

            option.addEventListener("focus", () => {
                setHighlightedOption(dropdown, option);
            });

            option.addEventListener("keydown", (event) => {
                if (event.key === "ArrowDown") {
                    event.preventDefault();
                    focusRelativeOption(dropdown, 1);
                } else if (event.key === "ArrowUp") {
                    event.preventDefault();
                    focusRelativeOption(dropdown, -1);
                } else if (event.key === "Home") {
                    event.preventDefault();
                    focusDropdownOption(dropdown, "first");
                } else if (event.key === "End") {
                    event.preventDefault();
                    focusDropdownOption(dropdown, "last");
                } else if (event.key === "Escape") {
                    event.preventDefault();
                    closeDropdown(dropdown, {
                        restoreFocus: true,
                    });
                } else if (event.key === "Enter" || event.key === " ") {
                    event.preventDefault();
                    selectDropdownOption(dropdown, option);
                } else if (event.key === "Tab") {
                    closeDropdown(dropdown);
                }
            });
        });

        if (menu.hidden) {
            menu.classList.remove("ui-list-box-menu-open");
        }

        if (listBox.classList.contains("ui-list-box-expanded")) {
            dropdown.classList.add("ui-dropdown-open");
            dropdown.dataset.uiDropdownOpen = "true";
            trigger.setAttribute("aria-expanded", "true");
        }
    });

    if (document.body?.dataset.uiDropdownDocumentInit === "1") {
        return;
    }

    document.body.dataset.uiDropdownDocumentInit = "1";

    document.addEventListener("click", (event) => {
        if (
            event.target instanceof HTMLElement &&
            event.target.closest("[data-ui-dropdown]")
        ) {
            return;
        }

        document.querySelectorAll("[data-ui-dropdown]").forEach((dropdown) => {
            if (dropdown instanceof HTMLElement) {
                closeDropdown(dropdown);
            }
        });
    });

    document.addEventListener("keydown", (event) => {
        if (event.key !== "Escape") {
            return;
        }

        document.querySelectorAll("[data-ui-dropdown]").forEach((dropdown) => {
            if (dropdown instanceof HTMLElement) {
                closeDropdown(dropdown, {
                    restoreFocus: dropdown.contains(document.activeElement),
                });
            }
        });
    });
}
