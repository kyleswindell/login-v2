const closeMenu = (trigger, menu) => {
    trigger.setAttribute('aria-expanded', 'false');
    menu.hidden = true;
    trigger.closest('[data-ui-component="menu-composition"]')?.setAttribute('data-ui-menu-open', 'false');
};

const openMenu = (trigger, menu) => {
    trigger.setAttribute('aria-expanded', 'true');
    menu.hidden = false;
    trigger.closest('[data-ui-component="menu-composition"]')?.setAttribute('data-ui-menu-open', 'true');
    menu.querySelector('[role="menuitem"]:not(:disabled), [role="menuitemcheckbox"]:not(:disabled), [role="menuitemradio"]:not(:disabled)')?.focus();
};

export function initMenus(root = document) {
    root.querySelectorAll('[data-ui-menu-trigger]').forEach((trigger) => {
        if (trigger.dataset.uiMenuInitialized === 'true') {
            return;
        }

        const container = trigger.closest('[data-ui-component="menu-composition"], [data-ui-breadcrumb-overflow-item]');
        const menu = container?.querySelector('[data-ui-menu]');

        if (!menu) {
            return;
        }

        trigger.dataset.uiMenuInitialized = 'true';

        trigger.addEventListener('click', (event) => {
            event.preventDefault();

            if (menu.hidden) {
                openMenu(trigger, menu);
            } else {
                closeMenu(trigger, menu);
            }
        });

        trigger.addEventListener('keydown', (event) => {
            if (!['Enter', ' ', 'ArrowDown'].includes(event.key)) {
                return;
            }

            event.preventDefault();
            openMenu(trigger, menu);
        });

        menu.addEventListener('keydown', (event) => {
            const items = Array.from(menu.querySelectorAll('[role="menuitem"]:not(:disabled), [role="menuitemcheckbox"]:not(:disabled), [role="menuitemradio"]:not(:disabled)'));
            const current = event.target.closest('[role="menuitem"], [role="menuitemcheckbox"], [role="menuitemradio"]');
            const index = items.indexOf(current);
            let next = null;

            if (event.key === 'Escape') {
                event.preventDefault();
                closeMenu(trigger, menu);
                trigger.focus();
                return;
            }

            if (event.key === 'ArrowDown') {
                next = items[(index + 1 + items.length) % items.length];
            } else if (event.key === 'ArrowUp') {
                next = items[(index - 1 + items.length) % items.length];
            } else if (event.key === 'Home') {
                next = items[0];
            } else if (event.key === 'End') {
                next = items[items.length - 1];
            }

            if (next) {
                event.preventDefault();
                next.focus();
            }
        });
    });

    if (document.documentElement.dataset.uiMenusDocumentListener !== 'true') {
        document.documentElement.dataset.uiMenusDocumentListener = 'true';

        document.addEventListener('click', (event) => {
            document.querySelectorAll('[data-ui-menu-trigger][aria-expanded="true"]').forEach((trigger) => {
                const container = trigger.closest('[data-ui-component="menu-composition"], [data-ui-breadcrumb-overflow-item]');

                if (container?.contains(event.target)) {
                    return;
                }

                const menu = container?.querySelector('[data-ui-menu]');

                if (menu) {
                    closeMenu(trigger, menu);
                }
            });
        });
    }
}
