/**
 * File: resources/js/ui-controls/data-table.js
 * Purpose: Progressive enhancement for Blade-rendered data tables.
 *
 * This controller supports the Blade component family under:
 *
 * resources/views/components/ui/data-table/
 *
 * Responsibilities:
 * - Initialize select-all indeterminate state.
 * - Sync selected row classes.
 * - Show/hide batch actions.
 * - Expand/collapse expandable rows.
 * - Expand/collapse all rows.
 * - Filter static table rows from toolbar search.
 * - Sort static table rows by sortable headers.
 * - Optionally top-align cells when content wraps.
 *
 * Non-responsibilities:
 * - Does not replace Laravel, Livewire, or controller-owned table state.
 * - Does not own pagination.
 * - Does not persist selections across page loads.
 * - Does not fetch remote data.
 * - Does not mutate server-side sort/filter state.
 */

/* --------------------------------------------------------------------------
 * Selectors
 * -------------------------------------------------------------------------- */

const ROOT_SELECTOR = '[data-ui-component="data-table"], [data-ui-data-table]';
const TABLE_SELECTOR = "table.ui-data-table";
const TABLE_CONTENT_SELECTOR =
    "[data-ui-data-table-content], .ui-data-table-content";

const SORT_BUTTON_SELECTOR = "[data-ui-data-table-sort]";

const SELECT_ALL_SELECTOR = "[data-ui-table-select-all]";
const SELECT_ROW_SELECTOR = "[data-ui-table-select-row]";

const BATCH_ACTIONS_SELECTOR = "[data-ui-table-batch-actions]";
const BATCH_CANCEL_SELECTOR = "[data-ui-table-batch-cancel]";
const BATCH_SELECT_ALL_SELECTOR = "[data-ui-table-batch-select-all]";

const EXPAND_TRIGGER_SELECTOR = "[data-ui-table-expand-trigger]";
const EXPAND_ALL_SELECTOR = "[data-ui-table-expand-all]";
const EXPAND_PARENT_SELECTOR = "[data-ui-table-expand-parent]";
const EXPANDED_ROW_SELECTOR = "[data-ui-table-expanded-row], [data-child-row]";

const TOOLBAR_SEARCH_SELECTOR = "[data-ui-table-toolbar-search]";

/* --------------------------------------------------------------------------
 * Internal state attributes
 * -------------------------------------------------------------------------- */

const INITIALIZED_ATTR = "data-ui-data-table-initialized";
const ORIGINAL_INDEX_ATTR = "data-ui-data-table-original-index";
const SEARCH_HIDDEN_ATTR = "data-ui-data-table-search-hidden";
const ORIGINAL_TABINDEX_ATTR = "data-ui-data-table-original-tabindex";

/**
 * Tracks auto-alignment resize handlers by table root.
 *
 * WeakMap is used so removed table roots can be garbage-collected.
 */
const autoAlignHandlers = new WeakMap();

/* --------------------------------------------------------------------------
 * Type guards / DOM helpers
 * -------------------------------------------------------------------------- */

/**
 * True when a value is a DOM Element.
 */
function isElement(value) {
    return value instanceof Element;
}

/**
 * True when a value is an HTMLElement.
 */
function isHTMLElement(value) {
    return value instanceof HTMLElement;
}

/**
 * True when a value is an HTMLInputElement.
 */
function isInput(value) {
    return value instanceof HTMLInputElement;
}

/**
 * Returns the closest data-table root for an element.
 *
 * Most tables are wrapped by x-ui.data-table.container, which carries
 * data-ui-component="data-table". For lower-level manual composition, this
 * function can also fall back to table.ui-data-table itself.
 */
function getRootForElement(element) {
    if (!isElement(element)) {
        return null;
    }

    if (element.matches(ROOT_SELECTOR)) {
        return element;
    }

    if (element.matches(TABLE_SELECTOR)) {
        return element.closest(ROOT_SELECTOR) || element;
    }

    return element.closest(ROOT_SELECTOR);
}

/**
 * Returns the table element inside a root.
 *
 * The root may be either:
 * - the wrapping section[data-ui-component="data-table"]
 * - the table.ui-data-table itself
 */
function getTable(root) {
    if (!root) {
        return null;
    }

    if (root.matches?.(TABLE_SELECTOR)) {
        return root;
    }

    return root.querySelector(TABLE_SELECTOR);
}

/**
 * Returns the first tbody for a table.
 */
function getTbody(table) {
    return table?.tBodies?.[0] ?? null;
}

/**
 * Returns all row-level selection inputs in a table root.
 */
function getRowSelectionInputs(root) {
    return [...root.querySelectorAll(SELECT_ROW_SELECTOR)].filter(isInput);
}

/**
 * Returns all select-all inputs in a table root.
 */
function getSelectAllInputs(root) {
    return [...root.querySelectorAll(SELECT_ALL_SELECTOR)].filter(isInput);
}

/**
 * Returns row selection inputs that can be acted on.
 *
 * When visibleOnly is true, hidden rows from client-side filtering are ignored.
 */
function getEnabledRowSelectionInputs(root, visibleOnly = false) {
    return getRowSelectionInputs(root).filter((input) => {
        if (input.disabled) {
            return false;
        }

        if (!visibleOnly) {
            return true;
        }

        const row = input.closest("tr");

        return row instanceof HTMLTableRowElement && !row.hidden;
    });
}

/**
 * Groups table rows as:
 *
 * parent row
 * child expanded row(s)
 *
 * Sorting and filtering should move/hide row groups together so expanded
 * content stays attached to its parent row.
 */
function getRowGroups(table) {
    const tbody = getTbody(table);

    if (!tbody) {
        return [];
    }

    const rows = [...tbody.children].filter(
        (row) => row instanceof HTMLTableRowElement,
    );

    const groups = [];

    for (let index = 0; index < rows.length; index += 1) {
        const row = rows[index];

        /**
         * Child expanded rows are grouped with the previous parent row.
         * They are not treated as standalone sortable/filterable data rows.
         */
        if (row.matches(EXPANDED_ROW_SELECTOR)) {
            continue;
        }

        const children = [];
        let next = rows[index + 1];

        while (next && next.matches(EXPANDED_ROW_SELECTOR)) {
            children.push(next);
            index += 1;
            next = rows[index + 1];
        }

        /**
         * Store original order once. This allows a sortable header to cycle
         * back to the natural server-rendered order.
         */
        if (!row.hasAttribute(ORIGINAL_INDEX_ATTR)) {
            row.setAttribute(ORIGINAL_INDEX_ATTR, String(groups.length));
        }

        groups.push({
            parent: row,
            children,
            originalIndex: Number(
                row.getAttribute(ORIGINAL_INDEX_ATTR) || groups.length,
            ),
        });
    }

    return groups;
}

/* --------------------------------------------------------------------------
 * Selection
 * -------------------------------------------------------------------------- */

/**
 * Applies the DOM-only indeterminate property for select-all checkboxes.
 *
 * HTML cannot set input.indeterminate as an attribute, so Blade marks intent
 * with data-ui-table-select-indeterminate and JS applies the actual property.
 */
function syncIndeterminate(root) {
    getSelectAllInputs(root).forEach((input) => {
        input.indeterminate =
            input.dataset.uiTableSelectIndeterminate === "true" ||
            input.getAttribute("aria-checked") === "mixed";
    });
}

/**
 * Applies selected state to a row selection input and its parent tr.
 */
function setRowSelected(input, selected) {
    input.checked = selected;

    const row = input.closest("tr");

    if (row instanceof HTMLTableRowElement) {
        row.classList.toggle("ui-data-table-selected", selected);
        row.classList.toggle("ui-data-table--selected", selected);
    }
}

/**
 * Returns true when the table currently has a non-empty client-side filter.
 *
 * This matters because select-all should operate on visible filtered rows,
 * not hidden rows.
 */
function isFiltering(root) {
    return root.dataset.uiDataTableFiltering === "true";
}

/**
 * Synchronizes:
 * - row selected classes
 * - select-all checked / indeterminate state
 * - batch action visibility and summary
 */
function syncSelection(root) {
    const visibleOnly = isFiltering(root);
    const enabledRows = getEnabledRowSelectionInputs(root, visibleOnly);
    const selectedRows = enabledRows.filter((input) => input.checked);

    getRowSelectionInputs(root).forEach((input) => {
        setRowSelected(input, input.checked);
    });

    getSelectAllInputs(root).forEach((input) => {
        const checked =
            enabledRows.length > 0 &&
            selectedRows.length === enabledRows.length;

        const indeterminate =
            selectedRows.length > 0 && selectedRows.length < enabledRows.length;

        input.checked = checked;
        input.indeterminate = indeterminate;

        input.setAttribute(
            "aria-checked",
            indeterminate ? "mixed" : checked ? "true" : "false",
        );
    });

    syncBatchActions(root, selectedRows.length, enabledRows.length);
}

/**
 * Selects or deselects all enabled rows.
 *
 * During filtering, this only affects visible rows.
 */
function handleSelectAll(root, input) {
    const visibleOnly = isFiltering(root);
    const checked = input.checked;

    getEnabledRowSelectionInputs(root, visibleOnly).forEach((rowInput) => {
        setRowSelected(rowInput, checked);
    });

    syncSelection(root);
}

/**
 * Handles individual row selection.
 *
 * For radio mode, other radios with the same name are deselected.
 */
function handleSelectRow(root, input) {
    if (input.type === "radio") {
        getRowSelectionInputs(root).forEach((rowInput) => {
            if (
                rowInput !== input &&
                rowInput.type === "radio" &&
                rowInput.name === input.name
            ) {
                setRowSelected(rowInput, false);
            }
        });
    }

    setRowSelected(input, input.checked);
    syncSelection(root);
}

/**
 * Clears all row selections and resets select-all inputs.
 *
 * Used by batch action cancel.
 */
function clearSelection(root) {
    getRowSelectionInputs(root).forEach((input) => {
        setRowSelected(input, false);
    });

    getSelectAllInputs(root).forEach((input) => {
        input.checked = false;
        input.indeterminate = false;
        input.setAttribute("aria-checked", "false");
    });

    syncSelection(root);
}

/* --------------------------------------------------------------------------
 * Batch actions
 * -------------------------------------------------------------------------- */

/**
 * Temporarily removes batch action controls from tab order when inactive.
 *
 * Original tabindex values are preserved so activation can restore them.
 */
function setBatchControlTabbable(control, active) {
    if (!control.hasAttribute(ORIGINAL_TABINDEX_ATTR)) {
        control.setAttribute(
            ORIGINAL_TABINDEX_ATTR,
            control.hasAttribute("tabindex")
                ? control.getAttribute("tabindex") || ""
                : "",
        );
    }

    const original = control.getAttribute(ORIGINAL_TABINDEX_ATTR) || "";

    if (active) {
        if (original === "") {
            control.removeAttribute("tabindex");
        } else {
            control.setAttribute("tabindex", original);
        }

        return;
    }

    control.setAttribute("tabindex", "-1");
}

/**
 * Shows or hides batch actions based on selected row count.
 */
function syncBatchActions(root, selectedCount, totalCount) {
    root.querySelectorAll(BATCH_ACTIONS_SELECTOR).forEach((batchActions) => {
        const active = selectedCount > 0;

        batchActions.classList.toggle("ui-batch-actions--active", active);
        batchActions.setAttribute("aria-hidden", active ? "false" : "true");
        batchActions.dataset.uiTableBatchActionsActive = active
            ? "true"
            : "false";

        const summary = batchActions.querySelector(
            ".ui-batch-summary__para span",
        );

        if (summary) {
            summary.textContent =
                selectedCount === 1
                    ? "1 item selected"
                    : `${selectedCount} items selected`;
        }

        const selectAll = batchActions.querySelector(BATCH_SELECT_ALL_SELECTOR);

        if (selectAll) {
            selectAll.textContent = `Select all (${totalCount})`;
        }

        batchActions
            .querySelectorAll("button, a, input, select, textarea, [tabindex]")
            .forEach((control) => {
                setBatchControlTabbable(control, active);
            });
    });
}

/* --------------------------------------------------------------------------
 * Expansion
 * -------------------------------------------------------------------------- */

/**
 * Resolves the row(s) controlled by an expand button.
 *
 * Preferred behavior uses aria-controls. Fallback behavior uses the next
 * sibling expanded row directly after the parent row.
 */
function getControlledRows(button) {
    const controls = button.getAttribute("aria-controls");

    if (controls) {
        return controls
            .split(/\s+/)
            .map((id) => document.getElementById(id))
            .filter(isHTMLElement);
    }

    const parent = button.closest(EXPAND_PARENT_SELECTOR);

    if (!parent) {
        return [];
    }

    const next = parent.nextElementSibling;

    return next && next.matches(EXPANDED_ROW_SELECTOR) ? [next] : [];
}

/**
 * Sets expansion state for a single row trigger.
 */
function setExpanded(button, expanded) {
    button.setAttribute("aria-expanded", expanded ? "true" : "false");

    const parent = button.closest(EXPAND_PARENT_SELECTOR);

    if (parent instanceof HTMLTableRowElement) {
        parent.classList.toggle("ui-expandable-row", expanded);

        if (expanded) {
            parent.dataset.previousValue = "collapsed";
        } else {
            parent.removeAttribute("data-previous-value");
        }
    }

    /**
     * Search filtering owns visibility first. A row can be expanded but still
     * hidden when its parent is filtered out.
     */
    const parentIsSearchHidden =
        parent instanceof HTMLElement &&
        parent.getAttribute(SEARCH_HIDDEN_ATTR) === "true";

    getControlledRows(button).forEach((row) => {
        row.hidden = parentIsSearchHidden || !expanded;
        row.setAttribute(
            "aria-hidden",
            expanded && !parentIsSearchHidden ? "false" : "true",
        );
    });
}

/**
 * Updates expand-all button state based on whether every row is expanded.
 */
function syncExpandAll(root) {
    const triggers = [...root.querySelectorAll(EXPAND_TRIGGER_SELECTOR)].filter(
        (button) => button instanceof HTMLButtonElement && !button.disabled,
    );

    const allExpanded =
        triggers.length > 0 &&
        triggers.every(
            (button) => button.getAttribute("aria-expanded") === "true",
        );

    root.querySelectorAll(EXPAND_ALL_SELECTOR).forEach((button) => {
        if (button instanceof HTMLButtonElement) {
            button.setAttribute(
                "aria-expanded",
                allExpanded ? "true" : "false",
            );
        }
    });
}

/**
 * Applies initial expansion state from rendered aria-expanded values.
 */
function syncExpansion(root) {
    root.querySelectorAll(EXPAND_TRIGGER_SELECTOR).forEach((button) => {
        if (!(button instanceof HTMLButtonElement)) {
            return;
        }

        const expanded = button.getAttribute("aria-expanded") === "true";

        setExpanded(button, expanded);
    });

    syncExpandAll(root);
}

/**
 * Toggles a single expandable row.
 */
function handleExpandTrigger(root, button) {
    const expanded = button.getAttribute("aria-expanded") === "true";

    setExpanded(button, !expanded);
    syncExpandAll(root);
}

/**
 * Toggles all expandable rows in a table root.
 */
function handleExpandAll(root, button) {
    const expanded = button.getAttribute("aria-expanded") === "true";
    const nextExpanded = !expanded;

    button.setAttribute("aria-expanded", nextExpanded ? "true" : "false");

    root.querySelectorAll(EXPAND_TRIGGER_SELECTOR).forEach((trigger) => {
        if (trigger instanceof HTMLButtonElement && !trigger.disabled) {
            setExpanded(trigger, nextExpanded);
        }
    });
}

/* --------------------------------------------------------------------------
 * Static search filtering
 * -------------------------------------------------------------------------- */

/**
 * Normalizes text for case-insensitive client-side filtering and sorting.
 */
function normalizeText(value) {
    return String(value || "")
        .replace(/\s+/g, " ")
        .trim()
        .toLowerCase();
}

/**
 * Filters static rows based on toolbar search input.
 *
 * Parent rows and their expanded child rows are treated as one searchable group.
 */
function applySearch(root, value) {
    const table = getTable(root);

    if (!table) {
        return;
    }

    const query = normalizeText(value);
    const groups = getRowGroups(table);

    root.dataset.uiDataTableFiltering = query ? "true" : "false";

    groups.forEach((group) => {
        const haystack = normalizeText(
            [group.parent, ...group.children]
                .map((row) => row.textContent || "")
                .join(" "),
        );

        const matches = !query || haystack.includes(query);

        group.parent.hidden = !matches;
        group.parent.setAttribute(
            SEARCH_HIDDEN_ATTR,
            matches ? "false" : "true",
        );

        group.children.forEach((row) => {
            if (!matches) {
                row.hidden = true;
                row.setAttribute("aria-hidden", "true");
                return;
            }

            const trigger = group.parent.querySelector(EXPAND_TRIGGER_SELECTOR);
            const expanded =
                trigger instanceof HTMLButtonElement &&
                trigger.getAttribute("aria-expanded") === "true";

            row.hidden = !expanded;
            row.setAttribute("aria-hidden", expanded ? "false" : "true");
        });
    });

    syncSelection(root);
}

/* --------------------------------------------------------------------------
 * Static sorting
 * -------------------------------------------------------------------------- */

/**
 * Reads current sort direction from a sortable th.
 */
function getSortDirection(th) {
    const ariaSort = th.getAttribute("aria-sort");

    if (ariaSort === "ascending") {
        return "asc";
    }

    if (ariaSort === "descending") {
        return "desc";
    }

    return "none";
}

/**
 * Carbon-style sort cycle:
 *
 * none → ascending → descending → none
 */
function getNextSortDirection(current) {
    if (current === "none") {
        return "asc";
    }

    if (current === "asc") {
        return "desc";
    }

    return "none";
}

/**
 * Gets a sortable cell value for a row group.
 */
function getCellValue(group, columnIndex) {
    const cell = group.parent.children[columnIndex];

    return normalizeText(cell?.textContent || "");
}

/**
 * Compares two values using numeric comparison when possible, otherwise
 * locale-aware text comparison.
 */
function compareValues(a, b) {
    const numberA = Number(a.replace(/,/g, ""));
    const numberB = Number(b.replace(/,/g, ""));

    if (
        Number.isFinite(numberA) &&
        Number.isFinite(numberB) &&
        a !== "" &&
        b !== ""
    ) {
        return numberA - numberB;
    }

    return a.localeCompare(b, undefined, {
        numeric: true,
        sensitivity: "base",
    });
}

/**
 * Clears active sort styles and aria-sort state from every sortable header.
 */
function resetSortHeaders(table) {
    table.querySelectorAll("th[aria-sort]").forEach((th) => {
        th.setAttribute("aria-sort", "none");

        th.classList.remove(
            "ui-table-sort__header--active",
            "ui-table-sort__header--descending",
        );
    });

    table.querySelectorAll(SORT_BUTTON_SELECTOR).forEach((button) => {
        button.classList.remove(
            "ui-table-sort--active",
            "ui-table-sort--descending",
        );
    });
}

/**
 * Sorts static rows by the clicked sortable column.
 *
 * Row groups are moved together so expanded child rows remain attached to
 * their parent rows.
 */
function handleSort(root, button) {
    const table = getTable(root);
    const th = button.closest("th");

    if (!table || !(th instanceof HTMLTableCellElement)) {
        return;
    }

    const tbody = getTbody(table);

    if (!tbody) {
        return;
    }

    const columnIndex = th.cellIndex;
    const currentDirection = getSortDirection(th);
    const nextDirection = getNextSortDirection(currentDirection);

    const groups = getRowGroups(table);

    resetSortHeaders(table);

    if (nextDirection !== "none") {
        th.setAttribute(
            "aria-sort",
            nextDirection === "desc" ? "descending" : "ascending",
        );

        th.classList.add("ui-table-sort__header--active");
        button.classList.add("ui-table-sort--active");

        if (nextDirection === "desc") {
            th.classList.add("ui-table-sort__header--descending");
            button.classList.add("ui-table-sort--descending");
        }
    }

    const sortedGroups = [...groups].sort((groupA, groupB) => {
        if (nextDirection === "none") {
            return groupA.originalIndex - groupB.originalIndex;
        }

        const compared = compareValues(
            getCellValue(groupA, columnIndex),
            getCellValue(groupB, columnIndex),
        );

        return nextDirection === "desc" ? compared * -1 : compared;
    });

    const fragment = document.createDocumentFragment();

    sortedGroups.forEach((group) => {
        fragment.append(group.parent);

        group.children.forEach((child) => {
            fragment.append(child);
        });
    });

    tbody.append(fragment);

    /**
     * Re-apply search after sorting so filtered hidden state survives the
     * DOM reorder.
     */
    const searchInput = root.querySelector(
        `${TOOLBAR_SEARCH_SELECTOR} input[type="search"], ${TOOLBAR_SEARCH_SELECTOR} input[type="text"]`,
    );

    if (searchInput instanceof HTMLInputElement) {
        applySearch(root, searchInput.value);
    }

    syncExpansion(root);
}

/* --------------------------------------------------------------------------
 * Optional auto top-alignment
 * -------------------------------------------------------------------------- */

/**
 * Basic wrap detection for plain text cells.
 *
 * Carbon measures canvas text width. This lighter Blade implementation checks
 * whether actual rendered height exceeds roughly one line.
 */
function isWrapping(element) {
    if (!(element instanceof HTMLElement)) {
        return false;
    }

    if (element.children.length > 0) {
        return false;
    }

    const styles = window.getComputedStyle(element);
    const lineHeight =
        Number.parseFloat(styles.lineHeight) ||
        Number.parseFloat(styles.fontSize) * 1.2;

    return element.scrollHeight > lineHeight * 1.5;
}

/**
 * Toggles top-alignment classes when body/header cells wrap.
 */
function setAutoAlignment(root) {
    const table = getTable(root);

    if (!table) {
        return;
    }

    const enabled = table.dataset.uiDataTableAutoAlign === "true";

    if (!enabled) {
        table.classList.remove(
            "ui-data-table--top-aligned-body",
            "ui-data-table-top-aligned-body",
            "ui-data-table--top-aligned-header",
            "ui-data-table-top-aligned-header",
        );
        return;
    }

    const bodyWraps = [...table.querySelectorAll("tbody td")].some(isWrapping);

    const headerWraps = [...table.querySelectorAll("thead th")].some((th) => {
        const label = th.querySelector(".ui-table-header-label");

        return label instanceof HTMLElement && isWrapping(label);
    });

    table.classList.toggle("ui-data-table--top-aligned-body", bodyWraps);
    table.classList.toggle("ui-data-table-top-aligned-body", bodyWraps);

    table.classList.toggle("ui-data-table--top-aligned-header", headerWraps);
    table.classList.toggle("ui-data-table-top-aligned-header", headerWraps);
}

/**
 * Small debounce utility used for resize-driven alignment checks.
 */
function debounce(callback, delay = 100) {
    let timeout = null;

    return (...args) => {
        window.clearTimeout(timeout);
        timeout = window.setTimeout(() => callback(...args), delay);
    };
}

/**
 * Binds auto-alignment listeners once per table root.
 */
function bindAutoAlignment(root) {
    const table = getTable(root);

    if (!table || table.dataset.uiDataTableAutoAlign !== "true") {
        return;
    }

    if (autoAlignHandlers.has(root)) {
        autoAlignHandlers.get(root)();
        return;
    }

    const run = debounce(() => setAutoAlignment(root), 100);

    autoAlignHandlers.set(root, run);

    window.addEventListener("resize", run);

    if (document.fonts?.ready) {
        document.fonts.ready.then(run);
    }

    if ("ResizeObserver" in window) {
        const observer = new ResizeObserver(run);

        observer.observe(table);
    }

    run();
}

/* --------------------------------------------------------------------------
 * Event handlers
 * -------------------------------------------------------------------------- */

/**
 * Handles delegated click events for:
 * - sortable headers
 * - row expansion
 * - expand all
 * - batch cancel
 * - batch select all
 */
function handleClick(event, root) {
    const target = event.target;

    if (!isElement(target)) {
        return;
    }

    const sortButton = target.closest(SORT_BUTTON_SELECTOR);

    if (sortButton && root.contains(sortButton)) {
        event.preventDefault();
        handleSort(root, sortButton);
        return;
    }

    const expandButton = target.closest(EXPAND_TRIGGER_SELECTOR);

    if (
        expandButton instanceof HTMLButtonElement &&
        root.contains(expandButton)
    ) {
        event.preventDefault();
        handleExpandTrigger(root, expandButton);
        return;
    }

    const expandAllButton = target.closest(EXPAND_ALL_SELECTOR);

    if (
        expandAllButton instanceof HTMLButtonElement &&
        root.contains(expandAllButton)
    ) {
        event.preventDefault();
        handleExpandAll(root, expandAllButton);
        return;
    }

    const cancelButton = target.closest(BATCH_CANCEL_SELECTOR);

    if (cancelButton && root.contains(cancelButton)) {
        event.preventDefault();
        clearSelection(root);
        return;
    }

    const batchSelectAllButton = target.closest(BATCH_SELECT_ALL_SELECTOR);

    if (batchSelectAllButton && root.contains(batchSelectAllButton)) {
        event.preventDefault();

        getEnabledRowSelectionInputs(root, true).forEach((input) => {
            setRowSelected(input, true);
        });

        syncSelection(root);
    }
}

/**
 * Handles delegated change events for selection inputs.
 */
function handleChange(event, root) {
    const target = event.target;

    if (!isInput(target)) {
        return;
    }

    if (target.matches(SELECT_ALL_SELECTOR)) {
        handleSelectAll(root, target);
        return;
    }

    if (target.matches(SELECT_ROW_SELECTOR)) {
        handleSelectRow(root, target);
    }
}

/**
 * Handles delegated input events for toolbar search.
 */
function handleInput(event, root) {
    const target = event.target;

    if (!isInput(target)) {
        return;
    }

    const search = target.closest(TOOLBAR_SEARCH_SELECTOR);

    if (!search || !root.contains(search)) {
        return;
    }

    applySearch(root, target.value);
}

/* --------------------------------------------------------------------------
 * Initialization
 * -------------------------------------------------------------------------- */

/**
 * Stores the initial server-rendered order of table rows.
 */
function initializeOriginalOrder(root) {
    const table = getTable(root);

    if (!table) {
        return;
    }

    getRowGroups(table).forEach((group, index) => {
        if (!group.parent.hasAttribute(ORIGINAL_INDEX_ATTR)) {
            group.parent.setAttribute(ORIGINAL_INDEX_ATTR, String(index));
        }
    });
}

/**
 * Initializes a single data table root.
 *
 * This function is idempotent. Re-running it after Livewire navigation or
 * partial DOM replacement will resync state without binding duplicate events.
 */
function bindDataTable(root) {
    if (!(root instanceof HTMLElement)) {
        return;
    }

    if (root.hasAttribute(INITIALIZED_ATTR)) {
        syncIndeterminate(root);
        syncSelection(root);
        syncExpansion(root);
        bindAutoAlignment(root);
        return;
    }

    root.setAttribute(INITIALIZED_ATTR, "true");

    root.addEventListener("click", (event) => handleClick(event, root));
    root.addEventListener("change", (event) => handleChange(event, root));
    root.addEventListener("input", (event) => handleInput(event, root));

    initializeOriginalOrder(root);
    syncIndeterminate(root);
    syncSelection(root);
    syncExpansion(root);
    bindAutoAlignment(root);
}

/**
 * Initializes all data tables in a root document/element.
 *
 * Supports:
 * - high-level x-ui.data-table containers
 * - lower-level manually-composed table.ui-data-table instances
 */
export function initDataTables(root = document) {
    const roots = new Set();

    if (root instanceof Element) {
        const resolvedRoot = getRootForElement(root);

        if (resolvedRoot) {
            roots.add(resolvedRoot);
        }
    }

    root.querySelectorAll?.(ROOT_SELECTOR).forEach((tableRoot) => {
        roots.add(tableRoot);
    });

    root.querySelectorAll?.(TABLE_SELECTOR).forEach((table) => {
        roots.add(getRootForElement(table) || table);
    });

    roots.forEach(bindDataTable);
}
