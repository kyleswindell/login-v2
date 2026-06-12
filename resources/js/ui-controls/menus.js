const closeMenu = (trigger, menu) => {
    trigger.setAttribute('aria-expanded', 'false');
    closeSubmenus(menu);
    menu.hidden = true;
    trigger.closest('[data-ui-component="menu-composition"]')?.setAttribute('data-ui-menu-open', 'false');
};

const openMenu = (trigger, menu) => {
    trigger.setAttribute('aria-expanded', 'true');
    closeSubmenus(menu);
    menu.hidden = false;
    trigger.closest('[data-ui-component="menu-composition"]')?.setAttribute('data-ui-menu-open', 'true');
    getEnabledMenuItems(menu)[0]?.focus();
};

const getEnabledMenuItems = (menu) => Array.from(
    menu.querySelectorAll('[role="menuitem"], [role="menuitemcheckbox"], [role="menuitemradio"]'),
).filter((item) => !item.matches(':disabled, [aria-disabled="true"]') && !item.closest('[hidden]') && item.getClientRects().length > 0);

const openSubmenu = (trigger, panel) => {
    trigger.setAttribute('aria-expanded', 'true');
    panel.hidden = false;
    panel.dataset.uiMenuSubmenuOpen = 'true';
};

const closeSubmenu = (trigger, panel) => {
    trigger.setAttribute('aria-expanded', 'false');
    panel.dataset.uiMenuSubmenuOpen = 'false';
    panel.hidden = true;
};

const closeSubmenus = (menu) => {
    menu.querySelectorAll('[data-ui-menu-submenu]').forEach((group) => {
        const trigger = group.querySelector('[data-ui-menu-submenu-trigger]');
        const panel = group.querySelector('[data-ui-menu-submenu-panel]');

        if (trigger && panel) {
            closeSubmenu(trigger, panel);
        }
    });
};

const isRtlMenu = (menu) => menu.closest('[dir="rtl"], .ui-menu-composition-rtl') !== null;

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

        menu.querySelectorAll('[data-ui-menu-submenu]').forEach((group) => {
            const submenuTrigger = group.querySelector('[data-ui-menu-submenu-trigger]');
            const submenuPanel = group.querySelector('[data-ui-menu-submenu-panel]');

            if (!submenuTrigger || !submenuPanel || submenuTrigger.dataset.uiMenuSubmenuInitialized === 'true') {
                return;
            }

            submenuTrigger.dataset.uiMenuSubmenuInitialized = 'true';

            submenuTrigger.addEventListener('pointerenter', () => openSubmenu(submenuTrigger, submenuPanel));
            group.addEventListener('pointerleave', () => closeSubmenu(submenuTrigger, submenuPanel));
            submenuTrigger.addEventListener('click', (event) => {
                event.preventDefault();

                if (submenuPanel.hidden) {
                    openSubmenu(submenuTrigger, submenuPanel);
                    getEnabledMenuItems(submenuPanel)[0]?.focus();
                } else {
                    closeSubmenu(submenuTrigger, submenuPanel);
                }
            });
        });

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
            const activeMenu = event.target.closest('[role="menu"]') ?? menu;
            const items = getEnabledMenuItems(activeMenu);
            const current = event.target.closest('[role="menuitem"], [role="menuitemcheckbox"], [role="menuitemradio"]');
            const index = items.indexOf(current);
            const openSubmenuKey = isRtlMenu(activeMenu) ? 'ArrowLeft' : 'ArrowRight';
            const closeSubmenuKey = isRtlMenu(activeMenu) ? 'ArrowRight' : 'ArrowLeft';
            let next = null;

            if (event.key === 'Escape') {
                event.preventDefault();
                closeMenu(trigger, menu);
                trigger.focus();
                return;
            }

            if (event.key === openSubmenuKey && current?.hasAttribute('data-ui-menu-submenu-trigger')) {
                const group = current.closest('[data-ui-menu-submenu]');
                const submenu = group?.querySelector('[data-ui-menu-submenu-panel]');

                if (submenu) {
                    event.preventDefault();
                    openSubmenu(current, submenu);
                    getEnabledMenuItems(submenu)[0]?.focus();
                }

                return;
            }

            if (event.key === closeSubmenuKey && activeMenu.hasAttribute('data-ui-menu-submenu-panel')) {
                const group = activeMenu.closest('[data-ui-menu-submenu]');
                const submenuTrigger = group?.querySelector('[data-ui-menu-submenu-trigger]');

                if (submenuTrigger) {
                    event.preventDefault();
                    closeSubmenu(submenuTrigger, activeMenu);
                    submenuTrigger.focus();
                }

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
