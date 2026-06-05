export const initSidebarToggle = () => {
    const root = document.documentElement;
    const body = document.body;

    const isMobile = () => window.innerWidth < 1024;
    const getSidebar = () => document.querySelector('[data-sidebar-panel]');
    const getBackdrop = () => document.querySelector('[data-sidebar-backdrop]');
    const isOpen = () => root.dataset.sidebarMobileOpen === '1';

    const updateToggleAffordances = () => {
        const open = isMobile() && isOpen();
        const icon = open ? '✕' : '☰';

        document.querySelectorAll('[data-sidebar-toggle]').forEach((toggle) => {
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });

        document.querySelectorAll('[data-sidebar-toggle-icon]').forEach((target) => {
            target.textContent = icon;
        });
    };

    const renderSidebar = () => {
        const sidebar = getSidebar();
        const backdrop = getBackdrop();

        if (!sidebar) {
            return;
        }

        const mobile = isMobile();
        const open = mobile && isOpen();
        const shouldShow = mobile ? open : true;

        root.classList.toggle('sidebar-open', open);
        sidebar.classList.toggle('hidden', !shouldShow);
        sidebar.style.display = '';

        if (backdrop) {
            backdrop.classList.toggle('hidden', !open);
        }

        if (body) {
            body.classList.toggle('overflow-hidden', open);
        }
        updateToggleAffordances();
    };

    const setOpen = (isOpen) => {
        root.dataset.sidebarMobileOpen = isMobile() && isOpen ? '1' : '0';
        renderSidebar();
    };

    if (body && body.dataset.sidebarEventsInit !== '1') {
        body.dataset.sidebarEventsInit = '1';

        document.addEventListener('click', (event) => {
            const toggle = event.target.closest('[data-sidebar-toggle]');
            if (toggle) {
                if (!isMobile()) {
                    return;
                }
                event.preventDefault();
                setOpen(!isOpen());
                return;
            }

            const backdrop = event.target.closest('[data-sidebar-backdrop]');
            if (backdrop && isMobile()) {
                setOpen(false);
                return;
            }

            if (!isMobile()) {
                return;
            }

            const navigationTarget = event.target.closest('[data-main-nav-link], [data-setup-nav-link], a[href], button[type="submit"], input[type="submit"]');
            if (navigationTarget) {
                setOpen(false);
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && isMobile() && isOpen()) {
                setOpen(false);
            }
        });

        window.addEventListener('resize', () => {
            if (!isMobile()) {
                setOpen(false);
                return;
            }
            renderSidebar();
        });

        document.addEventListener('livewire:navigating', () => {
            setOpen(false);
        });
    }

    if (!isMobile()) {
        root.dataset.sidebarMobileOpen = '0';
    }
    renderSidebar();
};

export const initNotificationMenus = () => {
    document.querySelectorAll('[data-notification-menu]').forEach((menu) => {
        if (menu.dataset.notificationMenuInit === '1') {
            return;
        }
        menu.dataset.notificationMenuInit = '1';

        const trigger = menu.querySelector('[data-notification-trigger]');
        const panel = menu.querySelector('[data-notification-panel]');

        if (!trigger || !panel) {
            return;
        }

        let pinnedOpen = false;
        let hoverCloseTimeout;

        const setOpen = (open) => {
            panel.classList.toggle('hidden', !open);
            trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
        };

        const clearHoverClose = () => {
            if (hoverCloseTimeout) {
                window.clearTimeout(hoverCloseTimeout);
                hoverCloseTimeout = undefined;
            }
        };

        const closeIfTransient = () => {
            if (!pinnedOpen) {
                setOpen(false);
            }
        };

        const scheduleTransientClose = () => {
            clearHoverClose();

            hoverCloseTimeout = window.setTimeout(() => {
                closeIfTransient();
            }, 120);
        };

        [trigger, panel].forEach((element) => {
            element.addEventListener('mouseenter', () => {
                clearHoverClose();

                if (!pinnedOpen) {
                    setOpen(true);
                }
            });
        });

        trigger.addEventListener('mouseenter', () => {
            if (!pinnedOpen) {
                setOpen(true);
            }
        });

        trigger.addEventListener('mouseleave', scheduleTransientClose);
        panel.addEventListener('mouseleave', scheduleTransientClose);

        trigger.addEventListener('click', (event) => {
            event.preventDefault();
            clearHoverClose();
            pinnedOpen = !pinnedOpen;
            setOpen(pinnedOpen);
        });

        document.addEventListener('click', (event) => {
            if (!menu.contains(event.target)) {
                clearHoverClose();
                pinnedOpen = false;
                setOpen(false);
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                clearHoverClose();
                pinnedOpen = false;
                setOpen(false);
            }
        });
    });
};

export const initAccountMenu = () => {
    const menu = document.querySelector('[data-account-menu]');
    if (!menu) {
        return;
    }
    if (menu.dataset.accountMenuInit === '1') {
        return;
    }
    menu.dataset.accountMenuInit = '1';

    const closeMenu = () => {
        menu.removeAttribute('open');
    };

    document.addEventListener('click', (event) => {
        if (!menu.contains(event.target)) {
            closeMenu();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeMenu();
        }
    });
};

export const initDocsTree = () => {
    const tree = document.querySelector('[data-docs-tree]');
    if (!tree) {
        return;
    }

    const selectedPath = tree.dataset.selectedPath || '';
    if (!selectedPath) {
        return;
    }

    tree.querySelectorAll('[data-docs-dir][data-docs-path]').forEach((node) => {
        const path = node.dataset.docsPath || '';
        if (path && (selectedPath === path || selectedPath.startsWith(`${path}/`))) {
            node.setAttribute('open', 'open');
        }
    });

    const selectedFile = tree.querySelector(`[data-docs-file][data-docs-path="${CSS.escape(selectedPath)}"]`);
    if (selectedFile) {
        selectedFile.scrollIntoView({ block: 'center' });
    }
};

export const initMobileSidebarDock = () => {
    document.querySelectorAll('[data-mobile-sidebar-dock]').forEach((container) => {
        if (container.dataset.mobileSidebarDockInit === '1') {
            return;
        }
        container.dataset.mobileSidebarDockInit = '1';

        const buttons = Array.from(container.querySelectorAll('[data-mobile-dock-target]'));
        const panels = Array.from(container.querySelectorAll('[data-mobile-dock-panel]'));
        const isMobile = () => window.innerWidth < 1024;

        if (buttons.length === 0 || panels.length === 0) {
            return;
        }

        const setActivePanel = (target) => {
            const selected = target || container.dataset.defaultPanel || 'main';

            buttons.forEach((button) => {
                const isActive = button.dataset.mobileDockTarget === selected;
                button.classList.toggle('bg-slate-700/60', isActive);
                button.classList.toggle('text-white', isActive);
                button.classList.toggle('ring-1', isActive);
                button.classList.toggle('ring-slate-500/40', isActive);
                button.classList.toggle('text-slate-300', !isActive);
                button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
            });

            panels.forEach((panel) => {
                panel.classList.toggle('hidden', isMobile() && panel.dataset.mobileDockPanel !== selected);
            });
        };

        buttons.forEach((button) => {
            button.addEventListener('click', () => {
                setActivePanel(button.dataset.mobileDockTarget);
            });
        });

        window.addEventListener('resize', () => {
            setActivePanel(container.dataset.defaultPanel || 'main');
        });

        setActivePanel(container.dataset.defaultPanel || 'main');
    });
};
