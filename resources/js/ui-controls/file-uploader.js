/* ==========================================================================
   File uploader behavior
   ========================================================================== */

/**
 * Selector contract used by the File Uploader Blade components.
 */
const FILE_UPLOADER_SELECTOR = "[data-ui-file-uploader]";
const FILE_DROP_SELECTOR = "[data-ui-file-drop]";
const FILE_INPUT_SELECTOR = "[data-ui-file-uploader-input]";
const FILE_BUTTON_SELECTOR = "[data-ui-file-uploader-button]";
const FILE_DROP_TRIGGER_SELECTOR = "[data-ui-file-drop-trigger]";
const FILE_CONTAINER_SELECTOR = "[data-ui-file-container]";
const FILE_REMOVE_SELECTOR = "[data-ui-file-remove]";

/**
 * Internal file state by uploader/drop root.
 */
const fileUploaderState = new WeakMap();

/* ==========================================================================
   Small SVG icons
   ========================================================================== */

/**
 * Dynamic file items are created in JavaScript, so these status icons are
 * emitted as minimal inline SVG instead of server-rendered Blade icon components.
 */
const icons = {
    close: `
        <svg aria-hidden="true" focusable="false" viewBox="0 0 16 16">
            <path d="M12 4.7 11.3 4 8 7.3 4.7 4 4 4.7 7.3 8 4 11.3l.7.7L8 8.7l3.3 3.3.7-.7L8.7 8z"></path>
        </svg>
    `,
    checkmarkFilled: `
        <svg aria-hidden="true" focusable="false" viewBox="0 0 16 16">
            <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1Zm-1 10L4.3 8.3l.9-.9L7 9.2l3.8-3.8.9.9L7 11Z"></path>
        </svg>
    `,
    warningFilled: `
        <svg aria-hidden="true" focusable="false" viewBox="0 0 16 16">
            <path d="M8.9 1.5a1 1 0 0 0-1.8 0L.6 13.1A1 1 0 0 0 1.5 14h13a1 1 0 0 0 .9-1.5L8.9 1.5ZM8.5 12h-1v-1h1v1Zm0-2h-1V5h1v5Z"></path>
        </svg>
    `,
};

/* ==========================================================================
   Utility helpers
   ========================================================================== */

/**
 * Escape a string for safe querySelector usage.
 */
const escapeSelector = (value) => {
    if (window.CSS?.escape) {
        return CSS.escape(value);
    }

    return String(value).replace(/["\\]/g, "\\$&");
};

/**
 * Convert an accept value into a clean list.
 */
const parseAcceptList = (value) => {
    if (!value) {
        return [];
    }

    if (Array.isArray(value)) {
        return value.map((item) => String(item).trim()).filter(Boolean);
    }

    return String(value)
        .split(",")
        .map((item) => item.trim())
        .filter(Boolean);
};

/**
 * Parse a boolean-like value from data attributes.
 */
const boolValue = (value, fallback = false) => {
    if (value === undefined || value === null || value === "") {
        return fallback;
    }

    return value === true || value === "true" || value === "1";
};

/**
 * Parse a numeric data attribute.
 */
const numberValue = (value, fallback = null) => {
    if (value === undefined || value === null || value === "") {
        return fallback;
    }

    const parsed = Number(value);

    return Number.isFinite(parsed) ? parsed : fallback;
};

/**
 * Generate a stable-enough UUID for client-rendered file items.
 */
const createFileUuid = () => {
    if (crypto?.randomUUID) {
        return crypto.randomUUID();
    }

    return `file-${Date.now()}-${Math.random().toString(36).slice(2)}`;
};

/**
 * Build a duplicate-detection key for a file.
 */
const getFileKey = (file) => {
    return `${file.name}|${file.size}|${file.lastModified}`;
};

/**
 * Convert bytes to a short readable value for error messaging.
 */
const formatBytes = (bytes) => {
    if (!Number.isFinite(bytes)) {
        return "";
    }

    if (bytes < 1024) {
        return `${bytes} B`;
    }

    if (bytes < 1024 * 1024) {
        return `${Math.round(bytes / 1024)} KB`;
    }

    return `${(bytes / (1024 * 1024)).toFixed(1)} MB`;
};

/* ==========================================================================
   Root/input lookup
   ========================================================================== */

/**
 * Find the component root for an input, button, or remove control.
 */
const getFileUploaderRoot = (element) => {
    return (
        element.closest(FILE_UPLOADER_SELECTOR) ||
        element.closest(FILE_DROP_SELECTOR)
    );
};

/**
 * Find the selected-file container for a root.
 */
const getFileContainer = (root) => {
    if (!root) {
        return null;
    }

    const localContainer = root.querySelector(FILE_CONTAINER_SELECTOR);

    if (localContainer) {
        return localContainer;
    }

    const parentUploader = root.closest(FILE_UPLOADER_SELECTOR);

    return parentUploader?.querySelector(FILE_CONTAINER_SELECTOR) || null;
};

/**
 * Find a native file input by ID.
 */
const getFileInputById = (id) => {
    if (!id) {
        return null;
    }

    const input = document.getElementById(id);

    return input instanceof HTMLInputElement ? input : null;
};

/**
 * Find the target input for a button/drop trigger.
 */
const getTargetInput = (trigger) => {
    const targetId = trigger.getAttribute("data-ui-file-uploader-input-target");

    if (targetId) {
        return getFileInputById(targetId);
    }

    const root = getFileUploaderRoot(trigger);

    return root?.querySelector(FILE_INPUT_SELECTOR) || null;
};

/**
 * Find the visible button for an input.
 */
const getButtonForInput = (input) => {
    if (!input.id) {
        return null;
    }

    return document.querySelector(
        `${FILE_BUTTON_SELECTOR}[data-ui-file-uploader-input-target="${escapeSelector(input.id)}"]`,
    );
};

/* ==========================================================================
   State helpers
   ========================================================================== */

/**
 * Get current component state.
 */
const getState = (root) => {
    if (!fileUploaderState.has(root)) {
        fileUploaderState.set(root, {
            items: [],
        });
    }

    return fileUploaderState.get(root);
};

/**
 * Assign a file array back to the native file input when the browser supports it.
 */
const syncNativeInputFiles = (input, items) => {
    if (!window.DataTransfer) {
        return;
    }

    const transfer = new DataTransfer();

    items
        .filter((item) => !item.invalid)
        .forEach((item) => {
            transfer.items.add(item.file);
        });

    input.files = transfer.files;
};

/**
 * Dispatch a component-level custom event.
 */
const dispatchFileUploaderEvent = (
    root,
    action,
    addedFiles = [],
    removedFiles = [],
) => {
    const state = getState(root);

    root.dispatchEvent(
        new CustomEvent("ui:file-uploader:change", {
            bubbles: true,
            detail: {
                action,
                addedFiles,
                removedFiles,
                currentFiles: [...state.items],
            },
        }),
    );
};

/* ==========================================================================
   Validation
   ========================================================================== */

/**
 * Determine whether a file matches the accept list.
 */
const isAcceptedFileType = (file, acceptList) => {
    if (!acceptList.length) {
        return true;
    }

    const fileName = file.name.toLowerCase();
    const mimeType = (file.type || "").toLowerCase();

    return acceptList.some((acceptRule) => {
        const rule = acceptRule.toLowerCase();

        if (rule.startsWith(".")) {
            return fileName.endsWith(rule);
        }

        if (rule.endsWith("/*")) {
            return mimeType.startsWith(rule.slice(0, -1));
        }

        return mimeType === rule;
    });
};

/**
 * Read validation config from the uploader/drop root and input.
 */
const getValidationConfig = (root, input) => {
    const accept =
        root?.getAttribute("data-ui-file-uploader-accept") ||
        root?.getAttribute("data-ui-file-drop-accept") ||
        input?.getAttribute("accept") ||
        "";

    const maxFileSize =
        numberValue(
            root?.getAttribute("data-ui-file-uploader-max-file-size"),
        ) ?? numberValue(root?.getAttribute("data-ui-file-drop-max-file-size"));

    return {
        acceptList: parseAcceptList(accept),
        maxFileSize,
    };
};

/**
 * Validate an incoming file and return a normalized file item.
 */
const createFileItem = (file, root, input) => {
    const { acceptList, maxFileSize } = getValidationConfig(root, input);

    const exceedsSize = Number.isFinite(maxFileSize) && file.size > maxFileSize;
    const hasAcceptedType = isAcceptedFileType(file, acceptList);

    const invalid = exceedsSize || !hasAcceptedType;

    let errorSubject = null;
    let errorBody = null;

    if (exceedsSize) {
        errorSubject = "File size exceeds limit";
        errorBody = `Maximum file size is ${formatBytes(maxFileSize)}.`;
    } else if (!hasAcceptedType) {
        errorSubject = "File type is not accepted";
        errorBody = acceptList.length
            ? `Accepted file types: ${acceptList.join(", ")}.`
            : null;
    }

    return {
        uuid: createFileUuid(),
        name: file.name,
        file,
        invalid,
        disabled: false,
        errorSubject,
        errorBody,
    };
};

/* ==========================================================================
   Rendering
   ========================================================================== */

/**
 * Render the status control for a selected file item.
 */
const renderFilenameStatus = (item, status, iconDescription) => {
    if (status === "uploading") {
        return `
            <span
                class="ui-file-loading ui-spinner"
                role="status"
                aria-label="${iconDescription}"
                data-ui-file-status="uploading"
            >
                <span class="ui-visually-hidden">${iconDescription}</span>
            </span>
        `;
    }

    if (status === "complete") {
        return `
            <span
                class="ui-file-complete"
                role="img"
                aria-label="${iconDescription}"
                tabindex="-1"
                data-ui-file-status="complete"
            >
                ${icons.checkmarkFilled}
            </span>
        `;
    }

    return `
        ${item.invalid ? `<span class="ui-file-invalid">${icons.warningFilled}</span>` : ""}
        <button
            type="button"
            class="ui-file-close"
            aria-label="${iconDescription} - ${item.name}"
            ${item.invalid && item.errorSubject ? `aria-describedby="${item.uuid}-error"` : ""}
            ${item.disabled ? "disabled" : ""}
            tabindex="0"
            data-ui-file-remove
            data-ui-file-remove-uuid="${item.uuid}"
        >
            ${icons.close}
        </button>
    `;
};

/**
 * Render one file item.
 */
const renderFileItem = (item, root) => {
    const size = root.getAttribute("data-ui-file-uploader-size") || "md";
    const configuredStatus =
        root.getAttribute("data-ui-file-uploader-filename-status") || "edit";

    const status = item.invalid ? "edit" : configuredStatus;
    const iconDescription =
        root.getAttribute("data-ui-file-uploader-icon-description") ||
        (status === "edit" ? "Remove uploaded file" : "Uploaded file");

    const sizeClass =
        size === "small" || size === "sm"
            ? "ui-file__selected-file--sm"
            : size === "field" || size === "md"
              ? "ui-file__selected-file--md"
              : "";

    return `
        <span
            class="ui-file__selected-file ${sizeClass} ${item.invalid ? "ui-file__selected-file--invalid" : ""} ${item.disabled ? "ui-file__selected-file--disabled" : ""}"
            data-ui-component="file-uploader-item"
            data-ui-file-uploader-item
            data-ui-file-uploader-item-uuid="${item.uuid}"
            data-ui-file-uploader-item-name="${item.name}"
            data-ui-file-uploader-item-status="${status}"
            data-ui-file-uploader-item-invalid="${item.invalid ? "true" : "false"}"
        >
            <span class="${item.invalid ? "ui-file-filename-container-wrap-invalid" : "ui-file-filename-container-wrap"}">
                <p
                    id="${item.uuid}-filename"
                    class="ui-file-filename"
                    title="${item.name}"
                >${item.name}</p>
            </span>

            <span class="ui-file-container-item">
                <span class="ui-file__state-container">
                    ${renderFilenameStatus(item, status, iconDescription)}
                </span>
            </span>

            ${
                item.invalid && item.errorSubject
                    ? `
                        <div
                            id="${item.uuid}-error"
                            class="ui-form-requirement"
                            role="alert"
                        >
                            <div class="ui-form-requirement__title">${item.errorSubject}</div>
                            ${
                                item.errorBody
                                    ? `<p class="ui-form-requirement__supplement">${item.errorBody}</p>`
                                    : ""
                            }
                        </div>
                    `
                    : ""
            }
        </span>
    `;
};

/**
 * Render the selected file list.
 */
const renderFileList = (root) => {
    const container = getFileContainer(root);

    if (!container) {
        return;
    }

    const state = getState(root);

    container.innerHTML = state.items
        .map((item) => renderFileItem(item, root))
        .join("");
};

/**
 * Update the visible upload button label.
 */
const updateButtonLabel = (input, root) => {
    const button = getButtonForInput(input);

    if (!button) {
        return;
    }

    const disableLabelChanges =
        button.getAttribute("data-ui-file-uploader-disable-label-changes") ===
        "true";

    if (disableLabelChanges) {
        return;
    }

    const label = button.querySelector("[data-ui-file-uploader-button-label]");

    if (!label) {
        return;
    }

    const state = getState(root);
    const validItems = state.items.filter((item) => !item.invalid);

    if (validItems.length > 1) {
        label.textContent = `${validItems.length} files`;
        return;
    }

    if (validItems.length === 1) {
        label.textContent = validItems[0].name;
    }
};

/* ==========================================================================
   File processing
   ========================================================================== */

/**
 * Merge incoming items into state.
 */
const mergeFileItems = (root, incomingItems) => {
    const state = getState(root);
    const multiple = boolValue(
        root.getAttribute("data-ui-file-uploader-multiple"),
        false,
    );

    if (!multiple) {
        state.items = incomingItems.slice(0, 1);
        return incomingItems.slice(0, 1);
    }

    const existingKeys = new Set(
        state.items.map((item) => getFileKey(item.file)),
    );

    const uniqueIncoming = incomingItems.filter((item) => {
        const key = getFileKey(item.file);

        if (existingKeys.has(key)) {
            return false;
        }

        existingKeys.add(key);
        return true;
    });

    state.items = [...state.items, ...uniqueIncoming];

    return uniqueIncoming;
};

/**
 * Process an added FileList/File array.
 */
const processAddedFiles = (event, input, files) => {
    const root =
        getFileUploaderRoot(input) || input.closest(FILE_DROP_SELECTOR);

    if (!root) {
        return;
    }

    const incomingFiles = Array.from(files || []);

    if (!incomingFiles.length) {
        dispatchFileUploaderEvent(root, "add", [], []);
        return;
    }

    const multiple =
        input.multiple ||
        boolValue(root.getAttribute("data-ui-file-uploader-multiple"), false);

    const filesToProcess = multiple ? incomingFiles : [incomingFiles[0]];

    const incomingItems = filesToProcess.map((file) =>
        createFileItem(file, root, input),
    );
    const addedItems = mergeFileItems(root, incomingItems);

    syncNativeInputFiles(input, getState(root).items);
    renderFileList(root);
    updateButtonLabel(input, root);
    dispatchFileUploaderEvent(root, "add", addedItems, []);
};

/**
 * Remove a selected file item.
 */
const removeFileItem = (button) => {
    const root = getFileUploaderRoot(button);

    if (!root) {
        return;
    }

    const uuid = button.getAttribute("data-ui-file-remove-uuid");

    if (!uuid) {
        return;
    }

    const state = getState(root);
    const removedItems = state.items.filter((item) => item.uuid === uuid);

    state.items = state.items.filter((item) => item.uuid !== uuid);

    const input = root.querySelector(FILE_INPUT_SELECTOR);

    if (input instanceof HTMLInputElement) {
        syncNativeInputFiles(input, state.items);
        updateButtonLabel(input, root);
    }

    renderFileList(root);
    dispatchFileUploaderEvent(root, "remove", [], removedItems);
};

/* ==========================================================================
   Button and input handlers
   ========================================================================== */

/**
 * Open the native file dialog from a visible trigger.
 */
const openFileInput = (trigger) => {
    const input = getTargetInput(trigger);

    if (!(input instanceof HTMLInputElement) || input.disabled) {
        return;
    }

    input.value = "";
    input.click();
};

/**
 * Handle visible file button click.
 */
const handleFileButtonClick = (event) => {
    event.preventDefault();
    openFileInput(event.currentTarget);
};

/**
 * Handle visible file button keyboard activation.
 */
const handleFileButtonKeyDown = (event) => {
    if (event.key !== "Enter" && event.key !== " ") {
        return;
    }

    event.preventDefault();
    openFileInput(event.currentTarget);
};

/**
 * Handle native file input changes.
 */
const handleFileInputChange = (event) => {
    const input = event.currentTarget;

    if (!(input instanceof HTMLInputElement)) {
        return;
    }

    processAddedFiles(event, input, input.files);
};

/**
 * Reset file input before opening so selecting the same file again fires change.
 */
const handleFileInputClick = (event) => {
    const input = event.currentTarget;

    if (input instanceof HTMLInputElement) {
        input.value = "";
    }
};

/* ==========================================================================
   Drop container handlers
   ========================================================================== */

/**
 * Set drop active state.
 */
const setDropActive = (drop, isActive) => {
    const trigger = drop.querySelector(FILE_DROP_TRIGGER_SELECTOR);

    if (!trigger) {
        return;
    }

    trigger.classList.toggle("ui-file__drop-container--drag-over", isActive);
};

/**
 * Handle drag over.
 */
const handleDropDragOver = (event) => {
    const drop = event.currentTarget;

    if (!(drop instanceof HTMLElement)) {
        return;
    }

    if (drop.getAttribute("data-ui-file-drop-disabled") === "true") {
        return;
    }

    event.preventDefault();
    event.stopPropagation();

    event.dataTransfer.dropEffect = "copy";
    setDropActive(drop, true);
};

/**
 * Handle drag leave.
 */
const handleDropDragLeave = (event) => {
    const drop = event.currentTarget;

    if (!(drop instanceof HTMLElement)) {
        return;
    }

    event.preventDefault();
    event.stopPropagation();

    setDropActive(drop, false);
};

/**
 * Extract files from a drop event while ignoring directories/non-file entries.
 */
const getDroppedFiles = (event) => {
    const items = Array.from(event.dataTransfer?.items || []);

    if (items.length) {
        return items.reduce((files, item) => {
            if (item.kind !== "file") {
                return files;
            }

            const entry = item.webkitGetAsEntry?.();

            if (entry?.isDirectory) {
                return files;
            }

            const file = item.getAsFile();

            if (file) {
                files.push(file);
            }

            return files;
        }, []);
    }

    return Array.from(event.dataTransfer?.files || []);
};

/**
 * Handle file drop.
 */
const handleDrop = (event) => {
    const drop = event.currentTarget;

    if (!(drop instanceof HTMLElement)) {
        return;
    }

    if (drop.getAttribute("data-ui-file-drop-disabled") === "true") {
        return;
    }

    event.preventDefault();
    event.stopPropagation();

    setDropActive(drop, false);

    const input = drop.querySelector(FILE_INPUT_SELECTOR);
    const files = getDroppedFiles(event);

    if (input instanceof HTMLInputElement) {
        processAddedFiles(event, input, files);
    }
};

/* ==========================================================================
   Remove handlers
   ========================================================================== */

/**
 * Handle remove button click.
 */
const handleFileRemoveClick = (event) => {
    event.preventDefault();
    removeFileItem(event.currentTarget);
};

/**
 * Handle remove button keyboard activation.
 */
const handleFileRemoveKeyDown = (event) => {
    if (event.key !== "Enter" && event.key !== " ") {
        return;
    }

    event.preventDefault();
    removeFileItem(event.currentTarget);
};

/* ==========================================================================
   Initialization
   ========================================================================== */

/**
 * Initialize one visible file trigger button.
 */
const initFileButton = (button) => {
    if (
        !(button instanceof HTMLElement) ||
        button.dataset.uiFileUploaderButtonInit === "true"
    ) {
        return;
    }

    button.dataset.uiFileUploaderButtonInit = "true";

    button.addEventListener("click", handleFileButtonClick);
    button.addEventListener("keydown", handleFileButtonKeyDown);
};

/**
 * Initialize one native file input.
 */
const initFileInput = (input) => {
    if (
        !(input instanceof HTMLInputElement) ||
        input.dataset.uiFileUploaderInputInit === "true"
    ) {
        return;
    }

    input.dataset.uiFileUploaderInputInit = "true";

    input.addEventListener("click", handleFileInputClick);
    input.addEventListener("change", handleFileInputChange);
};

/**
 * Initialize one drag/drop container.
 */
const initDropContainer = (drop) => {
    if (
        !(drop instanceof HTMLElement) ||
        drop.dataset.uiFileDropInit === "true"
    ) {
        return;
    }

    drop.dataset.uiFileDropInit = "true";

    drop.addEventListener("dragover", handleDropDragOver);
    drop.addEventListener("dragleave", handleDropDragLeave);
    drop.addEventListener("drop", handleDrop);
};

/**
 * Initialize one remove button.
 */
const initRemoveButton = (button) => {
    if (
        !(button instanceof HTMLButtonElement) ||
        button.dataset.uiFileRemoveInit === "true"
    ) {
        return;
    }

    button.dataset.uiFileRemoveInit = "true";

    button.addEventListener("click", handleFileRemoveClick);
    button.addEventListener("keydown", handleFileRemoveKeyDown);
};

/**
 * Initialize File Uploader behavior.
 */
export const initFileUploaders = (root = document) => {
    root.querySelectorAll(FILE_BUTTON_SELECTOR).forEach((button) => {
        initFileButton(button);
    });

    root.querySelectorAll(FILE_DROP_TRIGGER_SELECTOR).forEach((button) => {
        initFileButton(button);
    });

    root.querySelectorAll(FILE_INPUT_SELECTOR).forEach((input) => {
        initFileInput(input);
    });

    root.querySelectorAll(FILE_DROP_SELECTOR).forEach((drop) => {
        initDropContainer(drop);
    });

    root.querySelectorAll(FILE_REMOVE_SELECTOR).forEach((button) => {
        initRemoveButton(button);
    });
};

export default initFileUploaders;
