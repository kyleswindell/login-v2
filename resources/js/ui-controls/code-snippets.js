const copiedText = 'Copied to clipboard';
const defaultCopyText = 'Copy to clipboard';

const sourceText = (snippet) => snippet.querySelector('[data-ui-code-copy-source]')?.textContent ?? '';

const tooltipContentFor = (button) => {
    const tooltip = button.closest('[data-ui-tooltip]');

    return tooltip?.querySelector('[data-ui-tooltip-content]') ?? null;
};

const setCopyState = (snippet, button, copied) => {
    const state = copied ? 'copied' : 'idle';
    const label = copied ? copiedText : defaultCopyText;
    const tooltip = tooltipContentFor(button);
    const feedback = snippet.querySelector('[data-ui-code-copy-feedback]');

    snippet.dataset.uiCodeCopyState = state;
    button.dataset.uiCodeCopyState = state;
    button.setAttribute('aria-label', label);

    if (tooltip) {
        const caret = tooltip.querySelector('[data-ui-tooltip-caret]');
        tooltip.textContent = label;

        if (caret) {
            tooltip.append(caret);
        }
    }

    if (feedback) {
        feedback.textContent = label;
    }
};

const copySnippet = async (snippet, button) => {
    const text = sourceText(snippet);

    if (!text.trim()) {
        return;
    }

    try {
        await navigator.clipboard?.writeText(text);
    } catch {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.setAttribute('readonly', '');
        textarea.style.position = 'fixed';
        textarea.style.insetInlineStart = '-9999px';
        document.body.append(textarea);
        textarea.select();
        document.execCommand('copy');
        textarea.remove();
    }

    setCopyState(snippet, button, true);
    window.setTimeout(() => setCopyState(snippet, button, false), 1600);
};

const setExpanded = (snippet, button, expanded) => {
    const showMoreLabel = button.dataset.uiCodeShowMoreLabel || 'Show more';
    const showLessLabel = button.dataset.uiCodeShowLessLabel || 'Show less';

    snippet.dataset.uiCodeSnippetExpanded = expanded ? 'true' : 'false';
    button.setAttribute('aria-expanded', expanded ? 'true' : 'false');
    button.textContent = expanded ? showLessLabel : showMoreLabel;
};

export function initCodeSnippets(root = document) {
    root.querySelectorAll('[data-ui-code-snippet]').forEach((snippet) => {
        if (!(snippet instanceof HTMLElement) || snippet.dataset.uiCodeSnippetInitialized === 'true') {
            return;
        }

        snippet.dataset.uiCodeSnippetInitialized = 'true';

        const copyButtons = [
            ...(snippet.matches('[data-ui-code-copy-button]') ? [snippet] : []),
            ...snippet.querySelectorAll('[data-ui-code-copy-button]'),
        ];

        copyButtons.forEach((button) => {
            if (!(button instanceof HTMLElement)) {
                return;
            }

            setCopyState(snippet, button, button.dataset.uiCodeCopyState === 'copied');
            button.addEventListener('click', () => copySnippet(snippet, button));
        });

        snippet.querySelectorAll('[data-ui-code-show-more]').forEach((button) => {
            if (!(button instanceof HTMLButtonElement)) {
                return;
            }

            setExpanded(snippet, button, snippet.dataset.uiCodeSnippetExpanded === 'true');
            button.addEventListener('click', () => {
                setExpanded(snippet, button, snippet.dataset.uiCodeSnippetExpanded !== 'true');
            });
        });
    });
}
