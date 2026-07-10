/* ==========================================================================
   Select behavior
   ========================================================================== */

/**
 * Sync selected visual state for custom selectable option wrappers.
 */
const syncSelectableOptionStates = (scope = document) => {
    scope.querySelectorAll(".ui-selectable-option").forEach((option) => {
        const input = option.querySelector(
            'input[type="checkbox"], input[type="radio"]',
        );

        if (!(input instanceof HTMLInputElement)) {
            return;
        }

        option.classList.toggle("is-selected", input.checked);
    });
};

/**
 * Initialize selected visual state for custom selectable option wrappers.
 */
export const initSelectableOptionStates = (root = document) => {
    if (document.body?.dataset.selectableOptionStateInit !== "1") {
        document.body.dataset.selectableOptionStateInit = "1";

        document.addEventListener("change", (event) => {
            const input = event.target.closest(
                '.ui-selectable-option input[type="checkbox"], .ui-selectable-option input[type="radio"]',
            );

            if (!(input instanceof HTMLInputElement)) {
                return;
            }

            const fieldset = input.closest("fieldset");

            if (input.type === "radio" && input.name) {
                const scope = fieldset ?? document;

                scope
                    .querySelectorAll(
                        `input[type="radio"][name="${CSS.escape(input.name)}"]`,
                    )
                    .forEach((radio) => {
                        const option = radio.closest(".ui-selectable-option");

                        if (option) {
                            option.classList.toggle(
                                "is-selected",
                                radio.checked,
                            );
                        }
                    });

                return;
            }

            const option = input.closest(".ui-selectable-option");

            if (option) {
                option.classList.toggle("is-selected", input.checked);
            }
        });
    }

    syncSelectableOptionStates(root);
};

/* ==========================================================================
   Native select read-only behavior
   ========================================================================== */

/**
 * Check whether a native select should behave as read-only.
 *
 * Native select elements do not support readonly, so the Blade component emits
 * data-ui-select-readonly-control="true" and JavaScript blocks value changes.
 */
const isReadOnlySelect = (select) => {
    return select.getAttribute("data-ui-select-readonly-control") === "true";
};

/**
 * Store the current value as the last allowed value.
 */
const syncReadOnlySelectValue = (select) => {
    select.dataset.uiSelectReadonlyValue = select.value;
};

/**
 * Prevent mouse interaction from opening a read-only select.
 */
const handleReadOnlySelectMouseDown = (event) => {
    const select = event.currentTarget;

    if (!(select instanceof HTMLSelectElement)) {
        return;
    }

    if (!isReadOnlySelect(select) || select.disabled) {
        return;
    }

    event.preventDefault();
    select.focus();
};

/**
 * Prevent keyboard interaction from opening or changing a read-only select.
 */
const handleReadOnlySelectKeyDown = (event) => {
    const select = event.currentTarget;

    if (!(select instanceof HTMLSelectElement)) {
        return;
    }

    if (!isReadOnlySelect(select) || select.disabled) {
        return;
    }

    const blockedKeys = [
        " ",
        "Enter",
        "ArrowDown",
        "ArrowUp",
        "ArrowLeft",
        "ArrowRight",
        "Home",
        "End",
        "PageDown",
        "PageUp",
    ];

    if (blockedKeys.includes(event.key)) {
        event.preventDefault();
    }
};

/**
 * Restore the previous value if a read-only select is changed by browser,
 * script, autocomplete, or other unexpected interaction.
 */
const handleReadOnlySelectChange = (event) => {
    const select = event.currentTarget;

    if (!(select instanceof HTMLSelectElement)) {
        return;
    }

    if (!isReadOnlySelect(select) || select.disabled) {
        syncReadOnlySelectValue(select);
        return;
    }

    select.value = select.dataset.uiSelectReadonlyValue || select.value;
};

/**
 * Initialize one native select control.
 */
const initNativeSelectControl = (select) => {
    if (
        !(select instanceof HTMLSelectElement) ||
        select.dataset.uiSelectInit === "1"
    ) {
        return;
    }

    select.dataset.uiSelectInit = "1";
    syncReadOnlySelectValue(select);

    select.addEventListener("mousedown", handleReadOnlySelectMouseDown);
    select.addEventListener("keydown", handleReadOnlySelectKeyDown);
    select.addEventListener("change", handleReadOnlySelectChange);
};

/**
 * Initialize native select controls.
 */
export const initNativeSelectControls = (root = document) => {
    root.querySelectorAll("[data-ui-select-input]").forEach((select) => {
        initNativeSelectControl(select);
    });
};

/* ==========================================================================
   Select module initializer
   ========================================================================== */

/**
 * Initialize all select-related behavior.
 */
export const initSelectControls = (root = document) => {
    initSelectableOptionStates(root);
    initNativeSelectControls(root);
};
