const closeOpenDropdownActionMenus = (exception = null) => {
    document.querySelectorAll('[data-ui-pattern="dropdown-action-menu"][open]').forEach((menu) => {
        if (exception instanceof HTMLElement && menu === exception) {
            return;
        }

        menu.removeAttribute('open');
    });
};

export const initDropdownActionMenus = () => {
    if (document.body?.dataset.dropdownActionMenuInit !== '1') {
        document.body.dataset.dropdownActionMenuInit = '1';

        document.addEventListener('click', (event) => {
            const target = event.target;
            const menu = target instanceof HTMLElement
                ? target.closest('[data-ui-pattern="dropdown-action-menu"]')
                : null;
            const summary = target instanceof HTMLElement ? target.closest('summary') : null;

            if (summary && menu instanceof HTMLElement) {
                window.requestAnimationFrame(() => {
                    closeOpenDropdownActionMenus(menu.hasAttribute('open') ? menu : null);
                });

                return;
            }

            if (menu instanceof HTMLElement) {
                return;
            }

            closeOpenDropdownActionMenus();
        });

        document.addEventListener('focusin', (event) => {
            const target = event.target;

            if (target instanceof HTMLElement && target.closest('[data-ui-pattern="dropdown-action-menu"]')) {
                return;
            }

            closeOpenDropdownActionMenus();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key !== 'Escape') {
                return;
            }

            const openMenus = Array.from(document.querySelectorAll('[data-ui-pattern="dropdown-action-menu"][open]'));

            if (openMenus.length === 0) {
                return;
            }

            const activeMenu = openMenus.at(-1);
            closeOpenDropdownActionMenus();
            activeMenu?.querySelector('summary')?.focus();
        });

        document.addEventListener('toggle', (event) => {
            const target = event.target;

            if (!(target instanceof HTMLDetailsElement) || target.dataset.uiPattern !== 'dropdown-action-menu') {
                return;
            }

            if (!target.open) {
                return;
            }

            closeOpenDropdownActionMenus(target);
        }, true);
    }

    document.querySelectorAll('[data-ui-pattern="dropdown-action-menu"]').forEach((menu) => {
        if (!(menu instanceof HTMLDetailsElement)) {
            return;
        }

        const summary = menu.querySelector('summary');

        if (summary instanceof HTMLElement && !summary.hasAttribute('aria-haspopup')) {
            summary.setAttribute('aria-haspopup', 'menu');
        }
    });
};
