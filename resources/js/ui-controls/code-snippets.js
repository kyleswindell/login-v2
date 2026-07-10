/**
 * File: resources/js/ui-controls/code-snippet.js
 * Purpose: Code snippet behavior.
 *
 * Notes:
 * - Handles copy-to-clipboard behavior.
 * - Handles multi-line Show more / Show less behavior.
 * - Mirrors Carbon's row-count based expansion behavior.
 */

const SNIPPET_SELECTOR = "[data-ui-code-snippet]";
const COPY_BUTTON_SELECTOR = "[data-ui-code-copy-button]";
const COPY_SOURCE_SELECTOR = "[data-ui-code-copy-source]";
const COPY_FEEDBACK_SELECTOR = "[data-ui-code-copy-feedback]";
const CONTAINER_SELECTOR = "[data-ui-code-snippet-container]";
const EXPAND_BUTTON_SELECTOR = "[data-ui-code-snippet-expand]";
const EXPAND_TEXT_SELECTOR = "[data-ui-code-snippet-expand-text]";
const BOUND_ATTR = "data-ui-code-snippet-initialized";

const ROW_HEIGHT = 16;

function toNumber(value, fallback = 0) {
    const parsed = Number(value);

    return Number.isFinite(parsed) ? parsed : fallback;
}

function isMulti(snippet) {
    return snippet.dataset.uiCodeSnippetVariant === "multi";
}

function isExpanded(snippet) {
    return snippet.dataset.uiCodeSnippetExpanded === "true";
}

function isExpandable(snippet) {
    return snippet.dataset.uiCodeSnippetExpandable === "true";
}

function getContainer(snippet) {
    return snippet.querySelector(CONTAINER_SELECTOR);
}

function getCopySource(snippet) {
    return snippet.querySelector(COPY_SOURCE_SELECTOR);
}

function getCopyText(snippet) {
    const source = getCopySource(snippet);

    if (!(source instanceof HTMLElement)) {
        return "";
    }

    return (
        source.dataset.uiCodeCopyText ||
        source.innerText ||
        source.textContent ||
        ""
    );
}

async function writeClipboard(text) {
    if (navigator.clipboard && window.isSecureContext) {
        await navigator.clipboard.writeText(text);
        return;
    }

    const textarea = document.createElement("textarea");

    textarea.value = text;
    textarea.setAttribute("readonly", "");
    textarea.style.position = "fixed";
    textarea.style.insetBlockStart = "-9999px";
    textarea.style.insetInlineStart = "-9999px";

    document.body.append(textarea);
    textarea.select();
    document.execCommand("copy");
    textarea.remove();
}

function setCopyState(snippet, state) {
    const feedback =
        snippet.dataset.uiCodeCopyFeedback || "Copied to clipboard";
    const timeout = toNumber(snippet.dataset.uiCodeCopyFeedbackTimeout, 2000);

    snippet.dataset.uiCodeCopyState = state;

    snippet.querySelectorAll(COPY_BUTTON_SELECTOR).forEach((button) => {
        button.dataset.uiCodeCopyState = state;
        button.setAttribute("copy-state", state);
    });

    snippet.querySelectorAll(COPY_FEEDBACK_SELECTOR).forEach((target) => {
        target.textContent =
            state === "copied" ? feedback : "Copy to clipboard";
    });

    if (state === "copied") {
        window.setTimeout(() => {
            setCopyState(snippet, "idle");
        }, timeout);
    }
}

async function copySnippet(snippet) {
    const text = getCopyText(snippet);

    if (!text) {
        return;
    }

    await writeClipboard(text);
    setCopyState(snippet, "copied");

    snippet.dispatchEvent(
        new CustomEvent("ui-code-snippet:copy", {
            bubbles: true,
            detail: { text },
        }),
    );
}

function getRowConfig(snippet) {
    return {
        maxCollapsedRows: toNumber(
            snippet.dataset.uiCodeSnippetMaxCollapsedRows,
            15,
        ),
        maxExpandedRows: toNumber(
            snippet.dataset.uiCodeSnippetMaxExpandedRows,
            0,
        ),
        minCollapsedRows: toNumber(
            snippet.dataset.uiCodeSnippetMinCollapsedRows,
            3,
        ),
        minExpandedRows: toNumber(
            snippet.dataset.uiCodeSnippetMinExpandedRows,
            16,
        ),
    };
}

function getHeightConfig(snippet, expanded) {
    const config = getRowConfig(snippet);

    if (expanded) {
        return {
            maxHeight:
                config.maxExpandedRows > 0
                    ? config.maxExpandedRows * ROW_HEIGHT
                    : null,
            minHeight:
                config.minExpandedRows > 0
                    ? config.minExpandedRows * ROW_HEIGHT
                    : null,
        };
    }

    return {
        maxHeight:
            config.maxCollapsedRows > 0
                ? config.maxCollapsedRows * ROW_HEIGHT
                : null,
        minHeight:
            config.minCollapsedRows > 0
                ? config.minCollapsedRows * ROW_HEIGHT
                : null,
    };
}

function applyContainerHeights(snippet, expanded) {
    const container = getContainer(snippet);

    if (!(container instanceof HTMLElement)) {
        return;
    }

    const heights = getHeightConfig(snippet, expanded);

    container.style.maxHeight =
        heights.maxHeight === null ? "" : `${heights.maxHeight}px`;

    container.style.minHeight =
        heights.minHeight === null ? "" : `${heights.minHeight}px`;

    const pre = container.querySelector("pre");

    if (pre instanceof HTMLElement) {
        pre.style.maxHeight = container.style.maxHeight;
        pre.style.minHeight = container.style.minHeight;
    }
}

function shouldShowExpandButton(snippet) {
    if (!isMulti(snippet) || !isExpandable(snippet)) {
        return false;
    }

    const container = getContainer(snippet);
    const source = getCopySource(snippet);

    if (
        !(container instanceof HTMLElement) ||
        !(source instanceof HTMLElement)
    ) {
        return false;
    }

    const config = getRowConfig(snippet);

    if (config.maxCollapsedRows <= 0) {
        return false;
    }

    const measuredHeight = source.getBoundingClientRect().height;

    return measuredHeight > config.maxCollapsedRows * ROW_HEIGHT;
}

function setExpanded(snippet, expanded) {
    const button = snippet.querySelector(EXPAND_BUTTON_SELECTOR);
    const text = snippet.querySelector(EXPAND_TEXT_SELECTOR);

    snippet.dataset.uiCodeSnippetExpanded = expanded ? "true" : "false";
    snippet.classList.toggle("ui-code-snippet-shell-expand", expanded);

    applyContainerHeights(snippet, expanded);

    if (button instanceof HTMLButtonElement) {
        button.setAttribute("aria-expanded", expanded ? "true" : "false");
    }

    if (text instanceof HTMLElement) {
        text.textContent = expanded
            ? button?.dataset.uiCodeSnippetShowLessText || "Show less"
            : button?.dataset.uiCodeSnippetShowMoreText || "Show more";
    }
}

function syncExpandable(snippet) {
    const button = snippet.querySelector(EXPAND_BUTTON_SELECTOR);

    if (!(button instanceof HTMLElement)) {
        return;
    }

    const show = shouldShowExpandButton(snippet);

    button.hidden = !show;

    if (!show) {
        setExpanded(snippet, false);
        return;
    }

    setExpanded(snippet, isExpanded(snippet));
}

function bindSnippet(snippet) {
    if (!(snippet instanceof HTMLElement)) {
        return;
    }

    if (snippet.hasAttribute(BOUND_ATTR)) {
        syncExpandable(snippet);
        return;
    }

    snippet.setAttribute(BOUND_ATTR, "true");

    snippet.addEventListener("click", (event) => {
        const target = event.target;

        if (!(target instanceof Element)) {
            return;
        }

        const copyButton = target.closest(COPY_BUTTON_SELECTOR);

        if (copyButton && snippet.contains(copyButton)) {
            event.preventDefault();
            copySnippet(snippet);
            return;
        }

        const expandButton = target.closest(EXPAND_BUTTON_SELECTOR);

        if (expandButton && snippet.contains(expandButton)) {
            event.preventDefault();
            setExpanded(snippet, !isExpanded(snippet));
        }
    });

    applyContainerHeights(snippet, false);
    syncExpandable(snippet);
}

export function initCodeSnippets(root = document) {
    root.querySelectorAll(SNIPPET_SELECTOR).forEach(bindSnippet);
}
