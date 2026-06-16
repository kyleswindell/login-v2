const dispatchSearchChange = (root, input) => {
    root.dispatchEvent(new CustomEvent('ui-search:change', {
        bubbles: true,
        detail: {
            name: input.getAttribute('name'),
            value: input.value,
            scope: root.dataset.uiSearchScope || 'page',
        },
    }));
};

const syncSearchState = (root, input, clearButton) => {
    const isFilled = input.value.length > 0;

    root.classList.toggle('ui-search-filled', isFilled);
    root.dataset.uiSearchFilled = isFilled ? 'true' : 'false';

    if (clearButton) {
        clearButton.hidden = !isFilled || input.disabled || input.readOnly;
    }
};

const setExpandableState = (root, expanded, { focus = false } = {}) => {
    if (root.dataset.uiSearchExpandable !== 'true') {
        return;
    }

    const trigger = root.querySelector('[data-ui-search-expandable-trigger]');
    const field = root.querySelector('[data-ui-search-field]');
    const input = root.querySelector('[data-ui-search-input]');

    root.classList.toggle('ui-search-expanded', expanded);
    root.dataset.uiSearchExpanded = expanded ? 'true' : 'false';

    if (trigger instanceof HTMLButtonElement) {
        trigger.hidden = expanded;
        trigger.setAttribute('aria-expanded', expanded ? 'true' : 'false');
    }

    if (field instanceof HTMLElement) {
        field.hidden = !expanded;
    }

    if (focus && input instanceof HTMLInputElement) {
        window.requestAnimationFrame(() => input.focus());
    }
};

const clearSearch = (root, input, clearButton) => {
    if (input.disabled || input.readOnly) {
        return;
    }

    input.value = '';
    syncSearchState(root, input, clearButton);
    dispatchSearchChange(root, input);
    input.focus();
};

export function initSearchControls(root = document) {
    root.querySelectorAll('[data-ui-search]').forEach((search) => {
        if (!(search instanceof HTMLElement) || search.dataset.uiSearchInit === '1') {
            return;
        }

        const input = search.querySelector('[data-ui-search-input]');
        const clearButton = search.querySelector('[data-ui-search-clear]');
        const expandableTrigger = search.querySelector('[data-ui-search-expandable-trigger]');

        if (!(input instanceof HTMLInputElement)) {
            return;
        }

        search.dataset.uiSearchInit = '1';
        let debounceTimer = null;
        const active = search.dataset.uiSearchActive === 'true';
        const debounce = Number.parseInt(search.dataset.uiSearchDebounce || '300', 10);
        const isExpandable = search.dataset.uiSearchExpandable === 'true';
        const shouldCollapseOnEscape = search.dataset.uiSearchCollapseOnEscape !== 'false';

        const queueActiveChange = () => {
            if (!active) {
                return;
            }

            window.clearTimeout(debounceTimer);
            debounceTimer = window.setTimeout(() => dispatchSearchChange(search, input), Number.isFinite(debounce) ? debounce : 300);
        };

        input.addEventListener('input', () => {
            syncSearchState(search, input, clearButton);
            queueActiveChange();
        });

        input.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && input.value.length > 0) {
                event.preventDefault();
                clearSearch(search, input, clearButton);
                return;
            }

            if (event.key === 'Escape' && isExpandable && shouldCollapseOnEscape) {
                event.preventDefault();
                setExpandableState(search, false);
                expandableTrigger?.focus();
            }
        });

        if (clearButton instanceof HTMLButtonElement) {
            clearButton.addEventListener('click', () => clearSearch(search, input, clearButton));
        }

        if (expandableTrigger instanceof HTMLButtonElement) {
            expandableTrigger.addEventListener('click', () => setExpandableState(search, true, { focus: true }));
        }

        setExpandableState(search, search.dataset.uiSearchExpanded === 'true' || input.value.length > 0);
        syncSearchState(search, input, clearButton);
    });
}
