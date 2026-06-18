const setMenuOpenState = (trigger, menu, open) => {
    const composition = trigger.closest('[data-ui-component="menu-composition"]');
    const wrapper = composition?.closest('.ui-menu-button, .ui-combo-button, .ui-overflow-menu');

    trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
    composition?.setAttribute('data-ui-menu-open', open ? 'true' : 'false');
    wrapper?.classList.toggle('ui-menu-button-open', open && wrapper.classList.contains('ui-menu-button'));
    wrapper?.classList.toggle('ui-combo-button-open', open && wrapper.classList.contains('ui-combo-button'));
    wrapper?.classList.toggle('ui-overflow-menu-open', open && wrapper.classList.contains('ui-overflow-menu'));
    menu.hidden = !open;
};

const closeMenu = (trigger, menu, restoreFocus = false) => {
    trigger.setAttribute('aria-expanded', 'false');
    closeSubmenus(menu);
    setMenuOpenState(trigger, menu, false);

    if (restoreFocus) {
        trigger.focus();
    }
};

const closeOtherMenus = (activeTrigger) => {
    document.querySelectorAll('[data-ui-menu-trigger][aria-expanded="true"]').forEach((trigger) => {
        if (trigger === activeTrigger) {
            return;
        }

        const container = trigger.closest('[data-ui-component="menu-composition"], [data-ui-breadcrumb-overflow-item]');
        const menu = container?.querySelector('[data-ui-menu]');

        if (menu) {
            closeMenu(trigger, menu);
        }
    });
};

const openMenu = (trigger, menu, focus = 'first') => {
    closeOtherMenus(trigger);
    closeSubmenus(menu);
    setMenuOpenState(trigger, menu, true);

    const items = getEnabledMenuItems(menu);
    const item = focus === 'last' ? items[items.length - 1] : items[0];
    item?.focus();
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

const isSubmenuTrigger = (item) => item?.hasAttribute('data-ui-menu-submenu-trigger');

const activateMenuItem = (event, trigger, menu, item) => {
    if (!item || item.matches(':disabled, [aria-disabled="true"]')) {
        return;
    }

    if (isSubmenuTrigger(item)) {
        const group = item.closest('[data-ui-menu-submenu]');
        const submenu = group?.querySelector('[data-ui-menu-submenu-panel]');

        event.preventDefault();

        if (submenu) {
            openSubmenu(item, submenu);
            getEnabledMenuItems(submenu)[0]?.focus();
        }

        return;
    }

    if (event.type === 'keydown') {
        event.preventDefault();
        item.click();
        return;
    }

    if (item.hasAttribute('data-ui-menu-close')) {
        closeMenu(trigger, menu);
    }
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

        trigger.addEventListener('mousedown', (event) => {
            event.preventDefault();
        });

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
            if (!['Enter', ' ', 'ArrowDown', 'ArrowUp'].includes(event.key)) {
                return;
            }

            event.preventDefault();
            openMenu(trigger, menu, event.key === 'ArrowUp' ? 'last' : 'first');
        });

        menu.addEventListener('click', (event) => {
            const item = event.target.closest('[role="menuitem"], [role="menuitemcheckbox"], [role="menuitemradio"]');

            if (!item || !menu.contains(item)) {
                return;
            }

            activateMenuItem(event, trigger, menu, item);
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
                closeMenu(trigger, menu, true);
                return;
            }

            if (event.key === 'Tab') {
                closeMenu(trigger, menu);
                return;
            }

            if (['Enter', ' '].includes(event.key) && current) {
                activateMenuItem(event, trigger, menu, current);
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
