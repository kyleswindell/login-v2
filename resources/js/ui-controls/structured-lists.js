const selectableRowSelector = '[data-ui-structured-list-selectable-row]';
const radioSelector = '[data-ui-structured-list-radio]';

const syncRows = (list) => {
    list.querySelectorAll(selectableRowSelector).forEach((row) => {
        const radio = row.querySelector(radioSelector);
        const selected = radio instanceof HTMLInputElement && radio.checked;

        row.classList.toggle('ui-structured-list-row-selected', selected);
        row.setAttribute('data-ui-structured-list-row-selected', selected ? 'true' : 'false');
    });
};

const selectRow = (list, row) => {
    const radio = row.querySelector(radioSelector);

    if (!(radio instanceof HTMLInputElement) || radio.disabled) {
        return;
    }

    radio.checked = true;
    radio.dispatchEvent(new Event('change', { bubbles: true }));
    radio.focus();
    syncRows(list);
};

const moveFocus = (rows, currentRow, direction) => {
    const enabledRows = rows.filter((row) => {
        const radio = row.querySelector(radioSelector);

        return radio instanceof HTMLInputElement && !radio.disabled;
    });
    const currentIndex = enabledRows.indexOf(currentRow);

    if (currentIndex === -1) {
        return;
    }

    const nextIndex = (currentIndex + direction + enabledRows.length) % enabledRows.length;
    const nextRadio = enabledRows[nextIndex]?.querySelector(radioSelector);

    if (nextRadio instanceof HTMLInputElement) {
        nextRadio.focus();
    }
};

export function initStructuredLists(root = document) {
    root.querySelectorAll('[data-ui-structured-list]').forEach((list) => {
        if (!(list instanceof HTMLElement) || list.dataset.uiStructuredListInit === '1') {
            return;
        }

        const rows = Array.from(list.querySelectorAll(selectableRowSelector));

        if (rows.length === 0) {
            return;
        }

        list.dataset.uiStructuredListInit = '1';

        rows.forEach((row) => {
            row.addEventListener('click', (event) => {
                const target = event.target;

                if (target instanceof HTMLInputElement) {
                    syncRows(list);
                    return;
                }

                selectRow(list, row);
            });

            row.addEventListener('keydown', (event) => {
                if (event.key === ' ') {
                    event.preventDefault();
                    selectRow(list, row);
                    return;
                }

                if (event.key === 'ArrowDown') {
                    event.preventDefault();
                    moveFocus(rows, row, 1);
                    return;
                }

                if (event.key === 'ArrowUp') {
                    event.preventDefault();
                    moveFocus(rows, row, -1);
                }
            });
        });

        list.querySelectorAll(radioSelector).forEach((radio) => {
            radio.addEventListener('change', () => syncRows(list));
        });

        syncRows(list);
    });
}
