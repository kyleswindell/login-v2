/* ==========================================================================
   Text area behavior
   ========================================================================== */

const TEXT_AREA_SELECTOR = "[data-ui-text-area], [data-ui-textarea]";
const COUNTER_SELECTOR =
    "[data-ui-text-area-counter], [data-ui-textarea-counter]";

const getTextArea = (element) => {
    if (element instanceof HTMLTextAreaElement) {
        return element;
    }

    return element.querySelector("textarea");
};

const getCounter = (textarea) => {
    const wrapper =
        textarea.closest(
            "[data-ui-text-area-wrapper], [data-ui-textarea-wrapper]",
        ) || textarea.closest(".ui-text-area-wrapper");

    const formItem = textarea.closest(
        "[data-ui-text-area-form-item], .ui-form-item",
    );

    return (
        wrapper?.querySelector(COUNTER_SELECTOR) ||
        formItem?.querySelector(COUNTER_SELECTOR) ||
        textarea.parentElement?.querySelector(COUNTER_SELECTOR)
    );
};

const getCountMode = (textarea) => {
    return (
        textarea.getAttribute("data-ui-text-area-counter-mode") ||
        textarea.getAttribute("data-ui-textarea-counter-mode") ||
        "character"
    );
};

const getMaxCount = (textarea) => {
    const attrValue =
        textarea.getAttribute("data-ui-text-area-max-count") ||
        textarea.getAttribute("data-ui-textarea-max-count") ||
        textarea.getAttribute("maxlength");

    const value = Number(attrValue);

    return Number.isFinite(value) ? value : null;
};

const countWords = (value) => {
    const words = value.trim().split(/\s+/).filter(Boolean);

    return words.length;
};

const getCount = (textarea) => {
    return getCountMode(textarea) === "word"
        ? countWords(textarea.value)
        : textarea.value.length;
};

const syncTextAreaCounter = (textarea) => {
    const counter = getCounter(textarea);

    if (!counter) {
        return;
    }

    const count = getCount(textarea);
    const max = getMaxCount(textarea);

    counter.textContent = Number.isFinite(max)
        ? `${count}/${max}`
        : String(count);

    textarea.toggleAttribute(
        "data-ui-text-area-limit-exceeded",
        Number.isFinite(max) && count > max,
    );
};

const autoResizeTextArea = (textarea) => {
    if (textarea.getAttribute("data-ui-text-area-auto-resize") !== "true") {
        return;
    }

    textarea.style.height = "auto";
    textarea.style.height = `${textarea.scrollHeight}px`;
};

const handleTextAreaInput = (event) => {
    const textarea = event.currentTarget;

    if (!(textarea instanceof HTMLTextAreaElement)) {
        return;
    }

    syncTextAreaCounter(textarea);
    autoResizeTextArea(textarea);
};

export function initTextAreas(root = document) {
    root.querySelectorAll(TEXT_AREA_SELECTOR).forEach((target) => {
        const textarea = getTextArea(target);

        if (!(textarea instanceof HTMLTextAreaElement)) {
            return;
        }

        if (textarea.dataset.uiTextAreaInitialized === "true") {
            return;
        }

        textarea.dataset.uiTextAreaInitialized = "true";
        textarea.addEventListener("input", handleTextAreaInput);

        syncTextAreaCounter(textarea);
        autoResizeTextArea(textarea);
    });
}

export default initTextAreas;
