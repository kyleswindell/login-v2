const paginationSelector = '[data-ui-pagination]';
const overflowSelector = '[data-ui-pagination-overflow]';
const overflowTriggerSelector = '[data-ui-pagination-overflow-trigger]';
const overflowMenuSelector = '[data-ui-pagination-overflow-menu]';

const parseInteger = (value, fallback = 1) => {
    const parsed = Number.parseInt(value, 10);

    return Number.isFinite(parsed) ? parsed : fallback;
};

const clamp = (value, min, max) => Math.max(min, Math.min(max, value));

const isInteractive = (pagination) => pagination.dataset.uiPaginationInteractive === 'true';

const closeOverflow = (overflow, { restoreFocus = false } = {}) => {
    const trigger = overflow.querySelector(overflowTriggerSelector);
    const menu = overflow.querySelector(overflowMenuSelector);

    if (!(trigger instanceof HTMLButtonElement) || !(menu instanceof HTMLElement)) {
        return;
    }

    trigger.setAttribute('aria-expanded', 'false');
    menu.hidden = true;

    if (restoreFocus) {
        trigger.focus();
    }
};

const closeAllOverflowMenus = (root = document) => {
    root.querySelectorAll(overflowSelector).forEach((overflow) => {
        if (overflow instanceof HTMLElement) {
            closeOverflow(overflow);
        }
    });
};

const openOverflow = (overflow) => {
    if (!(overflow instanceof HTMLElement)) {
        return;
    }

    const trigger = overflow.querySelector(overflowTriggerSelector);
    const menu = overflow.querySelector(overflowMenuSelector);

    if (!(trigger instanceof HTMLButtonElement) || !(menu instanceof HTMLElement)) {
        return;
    }

    closeAllOverflowMenus();
    trigger.setAttribute('aria-expanded', 'true');
    menu.hidden = false;
};

const focusMenuItem = (menu, direction) => {
    const items = Array.from(menu.querySelectorAll('[role="menuitem"]'))
        .filter((item) => item instanceof HTMLElement && item.getClientRects().length > 0);
    const currentIndex = items.indexOf(document.activeElement);
    const nextIndex = currentIndex === -1
        ? 0
        : (currentIndex + direction + items.length) % items.length;

    items[nextIndex]?.focus();
};

const pageItems = (current, totalPages, pageWindow) => {
    if (totalPages <= 7) {
        return Array.from({ length: totalPages }, (_, index) => ({ type: 'page', page: index + 1 }));
    }

    const visible = new Set([1, totalPages]);

    for (let page = Math.max(2, current - pageWindow); page <= Math.min(totalPages - 1, current + pageWindow); page += 1) {
        visible.add(page);
    }

    const pages = Array.from(visible).sort((a, b) => a - b);
    const items = [];
    let previous = null;

    pages.forEach((page) => {
        if (previous !== null && page > previous + 1) {
            items.push({ type: 'overflow', start: previous + 1, end: page - 1 });
        }

        items.push({ type: 'page', page });
        previous = page;
    });

    return items;
};

const createPageLink = (pagination, page, current) => {
    const link = document.createElement('a');

    link.href = '#';
    link.className = `ui-pagination-page${page === current ? ' is-current' : ''}`;
    link.dataset.uiPaginationPage = String(page);
    link.setAttribute('aria-label', `Page ${page}`);
    link.textContent = String(page);

    if (page === current) {
        link.setAttribute('aria-current', 'page');
    }

    if (pagination.dataset.uiPaginationDisabled === 'true') {
        link.classList.add('is-disabled');
        link.setAttribute('aria-disabled', 'true');
        link.tabIndex = -1;
    }

    return link;
};

const createOverflow = (pagination, start, end, index) => {
    const item = document.createElement('li');
    const overflow = document.createElement('div');
    const trigger = document.createElement('button');
    const menu = document.createElement('div');
    const menuId = `${pagination.id || 'pagination'}-overflow-${start}-${end}-${index}`;

    item.className = 'ui-pagination-item ui-pagination-item-overflow';
    overflow.className = 'ui-pagination-overflow';
    overflow.dataset.uiPaginationOverflow = '';
    trigger.type = 'button';
    trigger.className = 'ui-pagination-page ui-pagination-overflow-trigger';
    trigger.setAttribute('aria-label', `Show hidden pages ${start} through ${end}`);
    trigger.setAttribute('aria-haspopup', 'menu');
    trigger.setAttribute('aria-expanded', 'false');
    trigger.setAttribute('aria-controls', menuId);
    trigger.dataset.uiPaginationOverflowTrigger = '';
    trigger.innerHTML = '<span aria-hidden="true">...</span>';
    menu.id = menuId;
    menu.className = 'ui-pagination-overflow-menu';
    menu.role = 'menu';
    menu.dataset.uiPaginationOverflowMenu = '';
    menu.hidden = true;

    for (let page = start; page <= end; page += 1) {
        const option = document.createElement('button');

        option.type = 'button';
        option.className = 'ui-pagination-overflow-item';
        option.role = 'menuitem';
        option.dataset.uiPaginationOverflowPage = String(page);
        option.textContent = `Page ${page}`;
        menu.append(option);
    }

    overflow.append(trigger, menu);
    item.append(overflow);

    return item;
};

const renderNav = (pagination) => {
    const list = pagination.querySelector('.ui-pagination-list');

    if (!(list instanceof HTMLElement)) {
        return;
    }

    const current = parseInteger(pagination.dataset.uiPaginationCurrent);
    const totalPages = parseInteger(pagination.dataset.uiPaginationTotalPages);
    const pageWindow = parseInteger(pagination.dataset.uiPaginationWindow);

    list.replaceChildren();
    pageItems(current, totalPages, pageWindow).forEach((item, index) => {
        if (item.type === 'overflow') {
            list.append(createOverflow(pagination, item.start, item.end, index));
            return;
        }

        const pageItem = document.createElement('li');
        pageItem.className = [
            'ui-pagination-item',
            'ui-pagination-item-page',
            item.page === current ? 'ui-pagination-item-current' : '',
            item.page === 1 || item.page === totalPages ? 'ui-pagination-item-edge' : '',
            item.page !== current && item.page !== 1 && item.page !== totalPages ? 'ui-pagination-item-neighbor' : '',
        ].filter(Boolean).join(' ');

        pageItem.append(createPageLink(pagination, item.page, current));
        list.append(pageItem);
    });
};

const syncDisabledControl = (control, disabled) => {
    if (!(control instanceof HTMLElement)) {
        return;
    }

    control.classList.toggle('is-disabled', disabled);

    if (disabled) {
        control.setAttribute('aria-disabled', 'true');
        control.tabIndex = -1;
    } else {
        control.removeAttribute('aria-disabled');
        control.removeAttribute('tabindex');
    }
};

const syncPageSelectOptions = (pageSelect, totalPages) => {
    const currentOptions = Array.from(pageSelect.options).map((option) => option.value);
    const expectedOptions = Array.from({ length: totalPages }, (_, index) => String(index + 1));

    if (
        currentOptions.length === expectedOptions.length
        && currentOptions.every((value, index) => value === expectedOptions[index])
    ) {
        return;
    }

    pageSelect.replaceChildren();
    expectedOptions.forEach((value) => {
        const option = document.createElement('option');

        option.value = value;
        option.textContent = value;
        pageSelect.append(option);
    });
};

const syncPagination = (pagination) => {
    const current = parseInteger(pagination.dataset.uiPaginationCurrent);
    const totalPages = parseInteger(pagination.dataset.uiPaginationTotalPages);
    const pageSize = parseInteger(pagination.dataset.uiPaginationPageSizeValue, 25);
    const totalItems = pagination.dataset.uiPaginationTotalItems
        ? parseInteger(pagination.dataset.uiPaginationTotalItems, 0)
        : null;
    const loop = pagination.dataset.uiPaginationLoop === 'true';
    const disabled = pagination.dataset.uiPaginationDisabled === 'true';
    const hasPrevious = loop ? totalPages > 1 : current > 1;
    const hasNext = loop ? totalPages > 1 : current < totalPages;
    const pageSelect = pagination.querySelector('[data-ui-pagination-page-select]');
    const pageSizeSelect = pagination.querySelector('[data-ui-pagination-page-size]');
    const range = pagination.querySelector('[data-ui-pagination-range]');

    if (pageSelect instanceof HTMLSelectElement) {
        syncPageSelectOptions(pageSelect, totalPages);
        pageSelect.value = String(current);
    }

    if (pageSizeSelect instanceof HTMLSelectElement) {
        pageSizeSelect.value = String(pageSize);
    }

    if (range instanceof HTMLElement && totalItems !== null) {
        if (totalItems === 0) {
            range.textContent = '0 items';
        } else {
            const from = ((current - 1) * pageSize) + 1;
            const to = Math.min(totalItems, current * pageSize);
            range.textContent = `${from}-${to} of ${totalItems} items`;
        }
    }

    syncDisabledControl(pagination.querySelector('[data-ui-pagination-prev]'), disabled || !hasPrevious);
    syncDisabledControl(pagination.querySelector('[data-ui-pagination-next]'), disabled || !hasNext);

    if (pagination.dataset.uiPaginationVariant === 'pagination-nav') {
        renderNav(pagination);
    }
};

const setPage = (pagination, page) => {
    const totalPages = parseInteger(pagination.dataset.uiPaginationTotalPages);
    pagination.dataset.uiPaginationCurrent = String(clamp(page, 1, totalPages));
    syncPagination(pagination);
};

const setPageSize = (pagination, pageSize) => {
    const totalItems = pagination.dataset.uiPaginationTotalItems
        ? parseInteger(pagination.dataset.uiPaginationTotalItems, 0)
        : null;

    pagination.dataset.uiPaginationPageSizeValue = String(pageSize);

    if (totalItems !== null) {
        pagination.dataset.uiPaginationTotalPages = String(Math.max(1, Math.ceil(totalItems / pageSize)));
    }

    pagination.dataset.uiPaginationCurrent = '1';
    syncPagination(pagination);
};

export function initPagination(root = document) {
    root.querySelectorAll(paginationSelector).forEach((pagination) => {
        if (!(pagination instanceof HTMLElement) || pagination.dataset.uiPaginationInit === '1') {
            return;
        }

        pagination.dataset.uiPaginationInit = '1';

        if (isInteractive(pagination)) {
            syncPagination(pagination);
        }

        if (pagination.dataset.uiPaginationOverflowOpenExample === 'true') {
            window.requestAnimationFrame(() => {
                const overflow = pagination.querySelector(overflowSelector);

                if (overflow instanceof HTMLElement) {
                    openOverflow(overflow);
                }
            });
        }

        pagination.addEventListener('click', (event) => {
            const target = event.target;
            const overflowTrigger = target instanceof HTMLElement ? target.closest(overflowTriggerSelector) : null;
            const paginationPage = target instanceof HTMLElement ? target.closest('[data-ui-pagination-page]') : null;
            const overflowPage = target instanceof HTMLElement ? target.closest('[data-ui-pagination-overflow-page]') : null;
            const previous = target instanceof HTMLElement ? target.closest('[data-ui-pagination-prev]') : null;
            const next = target instanceof HTMLElement ? target.closest('[data-ui-pagination-next]') : null;

            if (overflowTrigger instanceof HTMLButtonElement) {
                event.preventDefault();
                const overflow = overflowTrigger.closest(overflowSelector);

                if (overflow instanceof HTMLElement) {
                    if (overflowTrigger.getAttribute('aria-expanded') === 'true') {
                        closeOverflow(overflow);
                    } else {
                        openOverflow(overflow);
                    }
                }

                return;
            }

            if (!isInteractive(pagination)) {
                return;
            }

            if (previous instanceof HTMLElement) {
                event.preventDefault();

                if (!previous.classList.contains('is-disabled')) {
                    const current = parseInteger(pagination.dataset.uiPaginationCurrent);
                    const totalPages = parseInteger(pagination.dataset.uiPaginationTotalPages);
                    setPage(pagination, current <= 1 ? totalPages : current - 1);
                }
            } else if (next instanceof HTMLElement) {
                event.preventDefault();

                if (!next.classList.contains('is-disabled')) {
                    const current = parseInteger(pagination.dataset.uiPaginationCurrent);
                    const totalPages = parseInteger(pagination.dataset.uiPaginationTotalPages);
                    setPage(pagination, current >= totalPages ? 1 : current + 1);
                }
            } else if (paginationPage instanceof HTMLElement) {
                event.preventDefault();
                setPage(pagination, parseInteger(paginationPage.dataset.uiPaginationPage));
            } else if (overflowPage instanceof HTMLElement) {
                event.preventDefault();
                setPage(pagination, parseInteger(overflowPage.dataset.uiPaginationOverflowPage));
                const overflow = overflowPage.closest(overflowSelector);

                if (overflow instanceof HTMLElement) {
                    closeOverflow(overflow);
                }
            }
        });

        pagination.addEventListener('change', (event) => {
            if (!isInteractive(pagination)) {
                return;
            }

            if (event.target instanceof HTMLSelectElement && event.target.matches('[data-ui-pagination-page-select]')) {
                setPage(pagination, parseInteger(event.target.value));
            }

            if (event.target instanceof HTMLSelectElement && event.target.matches('[data-ui-pagination-page-size]')) {
                setPageSize(pagination, parseInteger(event.target.value, 25));
            }
        });

        pagination.addEventListener('keydown', (event) => {
            const target = event.target;
            const overflow = target instanceof HTMLElement ? target.closest(overflowSelector) : null;
            const menu = target instanceof HTMLElement ? target.closest(overflowMenuSelector) : null;

            if (event.key === 'Escape' && overflow instanceof HTMLElement) {
                event.preventDefault();
                closeOverflow(overflow, { restoreFocus: true });
                return;
            }

            if (target instanceof HTMLElement && target.matches(overflowTriggerSelector) && ['ArrowDown', 'Enter', ' '].includes(event.key)) {
                event.preventDefault();
                openOverflow(overflow);
                overflow?.querySelector('[role="menuitem"]')?.focus();
                return;
            }

            if (menu instanceof HTMLElement && event.key === 'ArrowDown') {
                event.preventDefault();
                focusMenuItem(menu, 1);
            } else if (menu instanceof HTMLElement && event.key === 'ArrowUp') {
                event.preventDefault();
                focusMenuItem(menu, -1);
            }
        });
    });

    if (document.body?.dataset.uiPaginationDocumentInit === '1') {
        return;
    }

    document.body.dataset.uiPaginationDocumentInit = '1';

    document.addEventListener('click', (event) => {
        if (event.target instanceof HTMLElement && event.target.closest(overflowSelector)) {
            return;
        }

        closeAllOverflowMenus();
    });
}
