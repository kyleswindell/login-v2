function initDataTablesLite() {
    const tables = document.querySelectorAll('[data-table-lite]');

    tables.forEach((table) => {
        const container = table.closest('[data-table-lite-container]');
        if (!container) {
            return;
        }

        const searchInput = container.querySelector('[data-table-lite-search]');
        const statusFilter = container.querySelector('[data-table-lite-filter-status]');
        const roleFilter = container.querySelector('[data-table-lite-filter-role]');
        const resetFiltersBtn = container.querySelector('[data-table-lite-filter-reset]');
        const rowsPerPageSelect = container.querySelector('[data-table-lite-rows-per-page], [data-ui-pagination-page-size]');
        const pageSelect = container.querySelector('[data-table-lite-page-select], [data-ui-pagination-page-select]');
        const info = container.querySelector('[data-table-lite-info], [data-ui-pagination-range]');
        const prevBtn = container.querySelector('[data-table-lite-prev], [data-ui-pagination-prev]');
        const nextBtn = container.querySelector('[data-table-lite-next], [data-ui-pagination-next]');
        const pagination = container.querySelector('[data-ui-pagination]');
        const totalPagesLabel = container.querySelector('[data-ui-pagination-total-pages-label]');
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
        let status = '';
        let role = '';

        const filteredRows = () => {
            if (term === '') {
                return allRows.filter((row) => {
                    const rowStatus = row.dataset.tableStatus || '';
                    const rowRoles = row.dataset.tableRoles || '';

                    const statusMatch = status === '' || rowStatus === status;
                    const roleMatch = role === '' || rowRoles.split(',').includes(role);

                    return statusMatch && roleMatch;
                });
            }

            return allRows.filter((row) => {
                const rowStatus = row.dataset.tableStatus || '';
                const rowRoles = row.dataset.tableRoles || '';
                const statusMatch = status === '' || rowStatus === status;
                const roleMatch = role === '' || rowRoles.split(',').includes(role);

                return statusMatch && roleMatch && row.textContent.toLowerCase().includes(term);
            });
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
                info.textContent = `${total === 0 ? 0 : start + 1}\u2013${shown} of ${total} employees`;
            }

            if (prevBtn) {
                prevBtn.disabled = page <= 1;
                prevBtn.classList.toggle('is-disabled', page <= 1);
                prevBtn.setAttribute('aria-disabled', page <= 1 ? 'true' : 'false');
            }

            if (nextBtn) {
                nextBtn.disabled = page >= pages;
                nextBtn.classList.toggle('is-disabled', page >= pages);
                nextBtn.setAttribute('aria-disabled', page >= pages ? 'true' : 'false');
            }

            if (pageSelect) {
                const desiredOptions = Array.from({ length: pages }, (_, index) => index + 1);
                const existingOptions = Array.from(pageSelect.options).map((option) => Number(option.value));

                if (desiredOptions.length !== existingOptions.length || desiredOptions.some((value, index) => value !== existingOptions[index])) {
                    pageSelect.innerHTML = '';
                    desiredOptions.forEach((value) => {
                        const option = document.createElement('option');
                        option.value = `${value}`;
                        option.textContent = `${value}`;
                        pageSelect.append(option);
                    });
                }

                pageSelect.value = `${page}`;
            }

            if (totalPagesLabel) {
                totalPagesLabel.textContent = `of ${pages} ${pages === 1 ? 'page' : 'pages'}`;
            }

            if (pagination) {
                pagination.dataset.uiPaginationCurrent = `${page}`;
                pagination.dataset.uiPaginationTotalPages = `${pages}`;
                pagination.dataset.uiPaginationTotalItems = `${total}`;
                pagination.dataset.uiPaginationPageSizeValue = `${rowsPerPage}`;
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

        statusFilter?.addEventListener('change', (event) => {
            status = (event.target.value || '').toLowerCase();
            page = 1;
            render();
        });

        roleFilter?.addEventListener('change', (event) => {
            role = (event.target.value || '').toLowerCase();
            page = 1;
            render();
        });

        resetFiltersBtn?.addEventListener('click', () => {
            term = '';
            status = '';
            role = '';
            page = 1;

            if (searchInput) {
                searchInput.value = '';
            }

            if (statusFilter) {
                statusFilter.value = '';
            }

            if (roleFilter) {
                roleFilter.value = '';
            }

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

        pageSelect?.addEventListener('change', (event) => {
            page = Number(event.target.value || 1);
            render();
        });

        render();
    });
}

document.addEventListener('DOMContentLoaded', initDataTablesLite);
