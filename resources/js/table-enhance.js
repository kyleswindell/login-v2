function initDataTablesLite() {
    const tables = document.querySelectorAll('[data-table-lite]');

    tables.forEach((table) => {
        const container = table.closest('[data-table-lite-container]');
        if (!container) {
            return;
        }

        const searchInput = container.querySelector('[data-table-lite-search]');
        const rowsPerPageSelect = container.querySelector('[data-table-lite-rows-per-page]');
        const info = container.querySelector('[data-table-lite-info]');
        const prevBtn = container.querySelector('[data-table-lite-prev]');
        const nextBtn = container.querySelector('[data-table-lite-next]');
        const tbody = table.querySelector('tbody');

        if (!tbody) {
            return;
        }

        const allRows = Array.from(tbody.querySelectorAll('tr')).filter((row) => !row.querySelector('td[colspan]'));
        if (allRows.length === 0) {
            return;
        }

        let page = 1;
        let rowsPerPage = Number(rowsPerPageSelect?.value ?? 10);
        let term = '';

        const filteredRows = () => {
            if (term === '') {
                return allRows;
            }

            return allRows.filter((row) => row.textContent.toLowerCase().includes(term));
        };

        const render = () => {
            const rows = filteredRows();
            const total = rows.length;
            const pages = Math.max(1, Math.ceil(total / rowsPerPage));
            page = Math.min(page, pages);

            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            allRows.forEach((row, index) => {
                row.classList.toggle('hidden', !(rows.includes(row) && index >= 0));
            });

            // Reset visibility then apply page slice.
            allRows.forEach((row) => row.classList.add('hidden'));
            rows.slice(start, end).forEach((row) => row.classList.remove('hidden'));

            if (info) {
                const shown = total === 0 ? 0 : Math.min(end, total);
                info.textContent = `Showing ${total === 0 ? 0 : start + 1} to ${shown} of ${total} entries`;
            }

            if (prevBtn) {
                prevBtn.disabled = page <= 1;
            }

            if (nextBtn) {
                nextBtn.disabled = page >= pages;
            }
        };

        searchInput?.addEventListener('input', (event) => {
            term = event.target.value.trim().toLowerCase();
            page = 1;
            render();
        });

        rowsPerPageSelect?.addEventListener('change', (event) => {
            rowsPerPage = Number(event.target.value || 10);
            page = 1;
            render();
        });

        prevBtn?.addEventListener('click', () => {
            page = Math.max(1, page - 1);
            render();
        });

        nextBtn?.addEventListener('click', () => {
            page += 1;
            render();
        });

        render();
    });
}

document.addEventListener('DOMContentLoaded', initDataTablesLite);
