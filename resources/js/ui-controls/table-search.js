export const initTableSearchInputs = () => {
    document.querySelectorAll('[data-table-search-form]').forEach((form) => {
        if (form.dataset.tableSearchInit === '1') {
            return;
        }
        form.dataset.tableSearchInit = '1';

        const input = form.querySelector('[data-table-search-input]');
        const clearButton = form.querySelector('[data-table-search-clear]');
        const resetButton = form.querySelector('[data-table-search-reset]');

        if (!input || !clearButton || !resetButton) {
            return;
        }

        const initialValue = (input.dataset.initialSearch || '').trim();

        const setButtonVisible = (button, visible) => {
            button.classList.toggle('hidden', !visible);
            button.classList.toggle('inline-flex', visible);
            button.setAttribute('aria-hidden', visible ? 'false' : 'true');
        };

        const syncButtons = () => {
            const currentValue = input.value.trim();
            const hasAppliedValue = initialValue.length > 0;
            const hasCurrentValue = currentValue.length > 0;
            const isDirty = currentValue !== initialValue;

            setButtonVisible(clearButton, hasCurrentValue && (!hasAppliedValue || isDirty));
            setButtonVisible(resetButton, hasAppliedValue && !isDirty);
        };

        clearButton.addEventListener('click', () => {
            input.value = '';
            syncButtons();
            input.focus();
        });

        resetButton.addEventListener('click', () => {
            input.value = '';
            form.submit();
        });

        input.addEventListener('input', syncButtons);
        input.addEventListener('keydown', (event) => {
            if (event.key !== 'Escape') {
                return;
            }

            input.value = '';
            syncButtons();
            input.blur();
        });

        syncButtons();
    });
};
