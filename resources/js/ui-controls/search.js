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

        if (!(input instanceof HTMLInputElement)) {
            return;
        }

        search.dataset.uiSearchInit = '1';
        let debounceTimer = null;
        const active = search.dataset.uiSearchActive === 'true';
        const debounce = Number.parseInt(search.dataset.uiSearchDebounce || '300', 10);

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
            }
        });

        if (clearButton instanceof HTMLButtonElement) {
            clearButton.addEventListener('click', () => clearSearch(search, input, clearButton));
        }

        syncSearchState(search, input, clearButton);
    });
}
