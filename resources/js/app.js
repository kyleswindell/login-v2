import './bootstrap';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import './setup-sidebar';
import './table-enhance';
import './dashboard-sort';

const allowedThemeModes = new Set(['system', 'dark', 'light']);

const resolveThemeMode = (mode) => {
    if (mode === 'dark' || mode === 'light') {
        return mode;
    }

    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
};

const getPreferredThemeMode = () => {
    const storedMode = window.localStorage.getItem('platform.theme.mode');

    if (allowedThemeModes.has(storedMode)) {
        return storedMode;
    }

    const datasetMode = document.documentElement.dataset.themeMode;

    return allowedThemeModes.has(datasetMode) ? datasetMode : 'system';
};

const applyThemeMode = (mode, persistLocal = true) => {
    const normalized = allowedThemeModes.has(mode) ? mode : 'system';
    const resolved = resolveThemeMode(normalized);
    const root = document.documentElement;

    root.dataset.themeMode = normalized;
    root.dataset.themeResolved = resolved;
    root.classList.toggle('dark', resolved === 'dark');
    root.style.backgroundColor = resolved === 'light' ? 'rgb(248 250 252)' : 'rgb(9 9 11)';
    root.style.color = resolved === 'light' ? 'rgb(15 23 42)' : 'rgb(241 245 249)';

    if (document.body) {
        document.body.style.backgroundColor = resolved === 'light' ? 'rgb(248 250 252)' : 'rgb(9 9 11)';
        document.body.style.color = resolved === 'light' ? 'rgb(15 23 42)' : 'rgb(241 245 249)';
    }

    if (persistLocal) {
        window.localStorage.setItem('platform.theme.mode', normalized);
    }

    document.querySelectorAll('[data-theme-mode-toggle]').forEach((button) => {
        const isActive = button.dataset.themeMode === normalized;
        button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
        button.classList.toggle('bg-slate-700', isActive);
        button.classList.toggle('text-white', isActive);
        button.classList.toggle('text-slate-300', !isActive);
    });
};

const persistThemePreference = (mode) => {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const url = document.body?.dataset.themeUpdateUrl;

    if (!url || !token) {
        return;
    }

    window.fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
            'X-CSRF-TOKEN': token,
            Accept: 'application/json',
        },
        body: new URLSearchParams({
            theme_preference: mode,
        }),
        credentials: 'same-origin',
    }).catch(() => {});
};

const initThemeModeControls = () => {
    if (document.body?.dataset.themeControlsInit === '1') {
        applyThemeMode(getPreferredThemeMode(), false);
        return;
    }

    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

    mediaQuery.addEventListener('change', () => {
        if ((document.documentElement.dataset.themeMode || 'system') === 'system') {
            applyThemeMode('system', false);
        }
    });

    document.body.dataset.themeControlsInit = '1';

    document.addEventListener('click', (event) => {
        const button = event.target.closest('[data-theme-mode-toggle]');

        if (!button) {
            return;
        }

        event.preventDefault();
        const mode = allowedThemeModes.has(button.dataset.themeMode) ? button.dataset.themeMode : 'system';
        applyThemeMode(mode);
        persistThemePreference(mode);
    });

    applyThemeMode(getPreferredThemeMode(), false);
};

const initFilterPanels = () => {
    document.querySelectorAll('[data-filter-toggle]').forEach((toggle) => {
        if (toggle.dataset.filterToggleInit === '1') {
            return;
        }
        toggle.dataset.filterToggleInit = '1';

        const panel = toggle.closest('section')?.querySelector('[data-filter-panel]')
            ?? document.querySelector('[data-filter-panel]');

        if (!panel) {
            return;
        }

        toggle.addEventListener('click', () => {
            panel.classList.toggle('hidden');
            toggle.setAttribute('aria-expanded', panel.classList.contains('hidden') ? 'false' : 'true');
        });
    });
};

const formatDrawerPayload = (value) => {
    if (value === null || value === undefined || value === '') {
        return '';
    }

    if (typeof value === 'string') {
        return value;
    }

    try {
        return JSON.stringify(value, null, 2);
    } catch (error) {
        return String(value);
    }
};

const loadDrawerPayload = async (url) => {
    if (!url) {
        return {};
    }

    try {
        const response = await window.fetch(url, {
            headers: {
                Accept: 'application/json',
            },
            credentials: 'same-origin',
        });

        if (!response.ok) {
            return {};
        }

        return await response.json();
    } catch (error) {
        return {};
    }
};

const initLogDrawer = ({
    modalSelector,
    triggerSelector,
    rowSelector,
    closeSelector,
    initKey,
    urlAttribute,
    populate,
}) => {
    const modal = document.querySelector(modalSelector);

    if (!modal || modal.dataset[initKey] === '1') {
        return;
    }

    modal.dataset[initKey] = '1';

    const panel = modal.querySelector('[data-log-drawer-panel]');
    const closeButtons = modal.querySelectorAll(closeSelector);
    let lastFocusedElement = null;

    const openDrawer = (sourceElement) => {
        lastFocusedElement = sourceElement instanceof HTMLElement ? sourceElement : document.activeElement;
        modal.classList.remove('hidden');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');
        panel?.focus();
    };

    const closeDrawer = () => {
        modal.classList.add('hidden');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');

        if (lastFocusedElement instanceof HTMLElement) {
            lastFocusedElement.focus();
        }
    };

    const bindTrigger = (element) => {
        if (element.dataset.logDrawerInit === '1') {
            return;
        }

        element.dataset.logDrawerInit = '1';
        element.addEventListener('click', async (event) => {
            event.preventDefault();

            const url = element.dataset[urlAttribute];
            const data = await loadDrawerPayload(url);
            populate(modal, data);
            openDrawer(element);
        });
    };

    document.querySelectorAll(triggerSelector).forEach((element) => {
        bindTrigger(element);
    });

    document.querySelectorAll(rowSelector).forEach((row) => {
        if (row.dataset.logDrawerRowInit === '1') {
            return;
        }

        row.dataset.logDrawerRowInit = '1';
        row.addEventListener('click', async (event) => {
            if (event.target.closest('a, button, input, select, textarea, label, form')) {
                return;
            }

            const url = row.dataset[urlAttribute];
            const data = await loadDrawerPayload(url);
            populate(modal, data);
            openDrawer(row);
        });
    });

    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeDrawer();
        }
    });

    closeButtons.forEach((button) => {
        button.addEventListener('click', closeDrawer);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeDrawer();
        }
    });
};

const initErrorLogDrawer = () => {
    initLogDrawer({
        modalSelector: '[data-error-log-modal]',
        triggerSelector: '[data-error-log-view]',
        rowSelector: '[data-error-log-row]',
        closeSelector: '[data-error-log-close]',
        initKey: 'errorLogInit',
        urlAttribute: 'errorLogUrl',
        populate: (modal, data) => {
            const setText = (selector, value) => {
                const target = modal.querySelector(selector);

                if (target) {
                    target.textContent = value || '—';
                }
            };

            setText('[data-error-log-title]', data.message);
            setText('[data-error-log-subtitle]', data.exception_class);
            setText('[data-error-log-occurred]', data.occurred_at);
            setText('[data-error-log-severity]', data.severity);
            setText('[data-error-log-handled]', data.handled ? 'Handled' : 'Uncaught');
            setText('[data-error-log-environment]', data.environment);
            setText('[data-error-log-exception]', data.exception_class);
            setText('[data-error-log-code]', data.error_code);
            setText('[data-error-log-file]', data.file_path ? `${data.file_path}:${data.line_number || ''}` : '');
            setText('[data-error-log-route]', data.route);
            setText('[data-error-log-method]', data.method);
            setText('[data-error-log-status]', data.status_code);
            setText('[data-error-log-user]', data.user_id ? `User #${data.user_id}` : 'Guest');
            setText('[data-error-log-request]', data.request_id);
            setText('[data-error-log-trace]', data.trace_id);
            setText('[data-error-log-ip]', data.ip_address);
            setText('[data-error-log-host]', data.hostname);
            setText('[data-error-log-message]', data.message);
            setText('[data-error-log-trace-stack]', formatDrawerPayload(data.stack_trace));
            setText('[data-error-log-context]', formatDrawerPayload(data.context));
        },
    });
};

const initAuditLogDrawer = () => {
    initLogDrawer({
        modalSelector: '[data-audit-log-modal]',
        triggerSelector: '[data-audit-log-view]',
        rowSelector: '[data-audit-log-row]',
        closeSelector: '[data-audit-log-close]',
        initKey: 'auditLogInit',
        urlAttribute: 'auditLogUrl',
        populate: (modal, data) => {
            const setText = (selector, value) => {
                const target = modal.querySelector(selector);

                if (target) {
                    target.textContent = value || '—';
                }
            };

            const subject = [data.subject_type, data.subject_id].filter(Boolean).join(' #');

            setText('[data-audit-log-title]', data.event_type);
            setText('[data-audit-log-subtitle]', data.actor_label ? `${data.actor_label} • ${data.result}` : data.result);
            setText('[data-audit-log-occurred]', data.occurred_at);
            setText('[data-audit-log-result]', data.result);
            setText('[data-audit-log-severity]', data.severity);
            setText('[data-audit-log-action]', data.action);
            setText('[data-audit-log-actor-name]', data.actor_name || data.actor_label);
            setText('[data-audit-log-actor-email]', data.actor_email);
            setText('[data-audit-log-route]', data.route);
            setText('[data-audit-log-method]', data.method);
            setText('[data-audit-log-request]', data.request_id);
            setText('[data-audit-log-trace]', data.trace_id);
            setText('[data-audit-log-ip]', data.ip_address);
            setText('[data-audit-log-subject]', subject);
            setText('[data-audit-log-metadata]', formatDrawerPayload(data.metadata));
        },
    });
};

const initSidebarToggle = () => {
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

const initNotificationMenus = () => {
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

const initAccountMenu = () => {
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

const initDocsTree = () => {
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

const initMobileSidebarDock = () => {
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

document.addEventListener('DOMContentLoaded', initNotificationMenus);
document.addEventListener('livewire:navigated', initNotificationMenus);
document.addEventListener('DOMContentLoaded', initAccountMenu);
document.addEventListener('livewire:navigated', initAccountMenu);
document.addEventListener('DOMContentLoaded', initDocsTree);
document.addEventListener('livewire:navigated', initDocsTree);
document.addEventListener('DOMContentLoaded', initMobileSidebarDock);
document.addEventListener('livewire:navigated', initMobileSidebarDock);
document.addEventListener('DOMContentLoaded', initFilterPanels);
document.addEventListener('livewire:navigated', initFilterPanels);
document.addEventListener('DOMContentLoaded', initErrorLogDrawer);
document.addEventListener('livewire:navigated', initErrorLogDrawer);
document.addEventListener('DOMContentLoaded', initAuditLogDrawer);
document.addEventListener('livewire:navigated', initAuditLogDrawer);
document.addEventListener('DOMContentLoaded', initSidebarToggle);
document.addEventListener('livewire:navigated', initSidebarToggle);
document.addEventListener('DOMContentLoaded', initThemeModeControls);
document.addEventListener('livewire:navigated', initThemeModeControls);
document.addEventListener('livewire:navigating', () => {
    applyThemeMode(getPreferredThemeMode(), false);
});
window.addEventListener('pageshow', () => {
    applyThemeMode(getPreferredThemeMode(), false);
});

const realtimeRoot = document.querySelector('[data-realtime-notifications="1"]');

if (realtimeRoot) {
    window.Pusher = Pusher;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const userId = realtimeRoot.dataset.userId;
    const triggerSummary = document.querySelector('[data-notification-trigger-summary]');
    const panelSummary = document.querySelector('[data-notification-panel-summary]');
    const previewList = document.querySelector('[data-notification-preview-list]');
    const previewEmptyState = document.querySelector('[data-notification-preview-empty-state]');
    const inboxList = document.querySelector('[data-notification-inbox-list]');
    const inboxEmptyState = document.querySelector('[data-notification-inbox-empty-state]');
    const inboxUnreadCount = document.querySelector('[data-notification-inbox-unread-count]');
    const toastContainer = document.querySelector('[data-notification-toast-container]');
    const indexUrl = realtimeRoot.dataset.notificationsIndexUrl;

    const echo = new Echo({
        broadcaster: 'reverb',
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: import.meta.env.VITE_REVERB_HOST,
        wsPort: Number(import.meta.env.VITE_REVERB_PORT ?? 80),
        wssPort: Number(import.meta.env.VITE_REVERB_PORT ?? 443),
        forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
        enabledTransports: ['ws', 'wss'],
        authEndpoint: '/platform/realtime/auth',
        authorizer: (channel) => ({
            authorize: (socketId, callback) => {
                window.axios.post('/platform/realtime/auth', {
                    socket_id: socketId,
                    channel_name: channel.name,
                    _token: csrfToken,
                }).then((response) => {
                    callback(false, response.data);
                }).catch((error) => {
                    callback(true, error);
                });
            },
        }),
    });

    const escapeHtml = (value) => String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');

    const updateUnreadSummaries = (unreadCount) => {
        if (triggerSummary) {
            triggerSummary.textContent = `${unreadCount}`;
        }

        if (panelSummary) {
            panelSummary.textContent = `${unreadCount} unread across your latest updates`;
        }

        if (inboxUnreadCount) {
            inboxUnreadCount.textContent = `${unreadCount}`;
        }
    };

    const severityClasses = (severity) => {
        switch (severity) {
            case 'success':
                return 'bg-emerald-500/15 text-emerald-300';
            case 'notice':
                return 'bg-violet-500/15 text-violet-300';
            case 'warning':
                return 'bg-amber-500/15 text-amber-300';
            case 'error':
            case 'urgent':
                return 'bg-rose-500/15 text-rose-300';
            default:
                return 'bg-slate-700/60 text-slate-200';
        }
    };

    const unreadBadge = (notification) => notification.read_at
        ? ''
        : '<span class="inline-flex rounded-full bg-slate-700/70 px-2.5 py-1 text-[11px] font-medium text-slate-200">Unread</span>';

    const dismissedBadge = (notification) => notification.dismissed_at
        ? '<span class="inline-flex rounded-full bg-slate-800 px-3 py-1 text-xs font-medium text-slate-400">Dismissed</span>'
        : '';

    const readBadge = (notification) => notification.read_at
        ? '<span class="inline-flex rounded-full bg-slate-800 px-3 py-1 text-xs font-medium text-slate-300">Read</span>'
        : '<span class="inline-flex rounded-full bg-slate-700/70 px-3 py-1 text-xs font-medium text-slate-200">Unread</span>';

    const createPreviewMarkup = (notification) => `
        <a
            href="${escapeHtml(notification.action_url || indexUrl)}"
            class="block rounded-md border border-slate-800 bg-slate-950/80 px-4 py-4 transition hover:border-slate-600 hover:bg-slate-950"
            data-notification-preview-item
            data-notification-id="${notification.id}"
        >
            <div class="flex items-center gap-2">
                ${unreadBadge(notification)}
                <span class="inline-flex rounded-full px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.15em] ${severityClasses(notification.severity)}">
                    ${escapeHtml(notification.severity)}
                </span>
                <span class="ml-auto text-xs text-slate-500">${escapeHtml(notification.created_at_label || '')}</span>
            </div>
            <p class="mt-3 text-sm font-semibold text-white">${escapeHtml(notification.title)}</p>
            <p class="mt-1 line-clamp-2 text-sm text-slate-400">${escapeHtml(notification.body)}</p>
        </a>
    `;

    const createInboxMarkup = (notification) => `
        <article class="rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/20" data-notification-card data-notification-id="${notification.id}">
            <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-2" data-notification-badges>
                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] ${severityClasses(notification.severity)}">
                            ${escapeHtml(notification.severity)}
                        </span>
                        ${readBadge(notification)}
                        ${dismissedBadge(notification)}
                    </div>
                    <h2 class="mt-4 text-xl font-semibold text-white">${escapeHtml(notification.title)}</h2>
                    <p class="mt-2 leading-7 text-slate-300">${escapeHtml(notification.body)}</p>
                    <div class="mt-4 flex flex-wrap gap-4 text-sm text-slate-500">
                        <span>Module: ${escapeHtml(notification.module_key)}</span>
                        <span data-notification-created-label>${escapeHtml(notification.created_at_label || '')}</span>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="${escapeHtml(notification.action_url || indexUrl)}" class="ui-action ui-action-notice text-sm">
                            Open notification link
                        </a>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3" data-notification-actions>
                    ${notification.read_at ? '' : `
                        <form method="POST" action="${escapeHtml(notification.mark_read_url)}">
                            <input type="hidden" name="_token" value="${escapeHtml(csrfToken || '')}">
                            <button type="submit" class="ui-action ui-action-success">
                                Mark read
                            </button>
                        </form>
                    `}
                    ${notification.dismissed_at ? '' : `
                        <form method="POST" action="${escapeHtml(notification.dismiss_url)}">
                            <input type="hidden" name="_token" value="${escapeHtml(csrfToken || '')}">
                            <button type="submit" class="ui-action ui-action-ghost">
                                Dismiss
                            </button>
                        </form>
                    `}
                </div>
            </div>
        </article>
    `;

    const renderPreviewItem = (notification) => {
        const existing = previewList?.querySelector(`[data-notification-id="${notification.id}"]`);

        if (!previewList) {
            return;
        }

        if (previewEmptyState) {
            previewEmptyState.remove();
        }

        if (existing) {
            existing.outerHTML = createPreviewMarkup(notification);
            return;
        }

        previewList.insertAdjacentHTML('afterbegin', createPreviewMarkup(notification));

        while (previewList.querySelectorAll('[data-notification-preview-item]').length > 5) {
            previewList.querySelector('[data-notification-preview-item]:last-of-type')?.remove();
        }
    };

    const renderInboxItem = (notification) => {
        if (!inboxList) {
            return;
        }

        if (inboxEmptyState) {
            inboxEmptyState.remove();
        }

        const existing = inboxList.querySelector(`[data-notification-id="${notification.id}"]`);

        if (existing) {
            existing.outerHTML = createInboxMarkup(notification);
            return;
        }

        inboxList.insertAdjacentHTML('afterbegin', createInboxMarkup(notification));
    };

    const createToast = (notification) => {
        if (!toastContainer) {
            return;
        }

        const toast = document.createElement('a');
        toast.href = notification.action_url || indexUrl;
        toast.className = 'pointer-events-auto block rounded-md border border-slate-800 bg-slate-900/95 px-4 py-4 shadow-2xl shadow-black/40 transition hover:border-slate-600';
        toast.innerHTML = `
            <div class="flex items-start gap-3">
                <div class="mt-0.5 inline-flex rounded-full px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.15em] ${severityClasses(notification.severity)}">
                    ${escapeHtml(notification.severity)}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-white">${escapeHtml(notification.title)}</p>
                    <p class="mt-1 text-sm text-slate-400">${escapeHtml(notification.body)}</p>
                </div>
                <button type="button" class="ml-2 text-slate-500 transition hover:text-slate-200" data-notification-toast-close>×</button>
            </div>
        `;

        toastContainer.prepend(toast);

        const removeToast = () => toast.remove();
        const closeButton = toast.querySelector('[data-notification-toast-close]');

        closeButton?.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();
            removeToast();
        });

        window.setTimeout(removeToast, 5000);
    };

    const applyNotification = (notification, options = { toast: false }) => {
        updateUnreadSummaries(notification.unread_count ?? 0);
        renderPreviewItem(notification);
        renderInboxItem(notification);

        if (options.toast && !notification.read_at) {
            createToast(notification);
        }
    };

    echo.private(`App.Models.User.${userId}`)
        .listen('.notification.created', (event) => {
            applyNotification(event.notification, { toast: true });
        })
        .listen('.notification.updated', (event) => {
            applyNotification(event.notification, { toast: false });
        });
}
