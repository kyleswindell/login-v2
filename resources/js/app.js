import './bootstrap';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import './setup-sidebar';
import './table-enhance';

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-notification-menu]').forEach((menu) => {
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
        const unreadLabel = `${unreadCount} unread`;

        if (triggerSummary) {
            triggerSummary.textContent = unreadLabel;
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
                return 'bg-sky-500/15 text-sky-300';
        }
    };

    const unreadBadge = (notification) => notification.read_at
        ? ''
        : '<span class="inline-flex rounded-full bg-sky-500/15 px-2.5 py-1 text-[11px] font-medium text-sky-200">Unread</span>';

    const dismissedBadge = (notification) => notification.dismissed_at
        ? '<span class="inline-flex rounded-full bg-slate-800 px-3 py-1 text-xs font-medium text-slate-400">Dismissed</span>'
        : '';

    const readBadge = (notification) => notification.read_at
        ? '<span class="inline-flex rounded-full bg-slate-800 px-3 py-1 text-xs font-medium text-slate-300">Read</span>'
        : '<span class="inline-flex rounded-full bg-sky-500/15 px-3 py-1 text-xs font-medium text-sky-200">Unread</span>';

    const createPreviewMarkup = (notification) => `
        <a
            href="${escapeHtml(notification.action_url || indexUrl)}"
            class="block rounded-2xl border border-slate-800 bg-slate-950/80 px-4 py-4 transition hover:border-sky-500/30 hover:bg-slate-950"
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
        <article class="rounded-3xl border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/20" data-notification-card data-notification-id="${notification.id}">
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
                    <div class="mt-4">
                        <a href="${escapeHtml(notification.action_url || indexUrl)}" class="text-sm font-semibold text-sky-300 transition hover:text-sky-200">
                            Open notification link
                        </a>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3" data-notification-actions>
                    ${notification.read_at ? '' : `
                        <form method="POST" action="${escapeHtml(notification.mark_read_url)}">
                            <input type="hidden" name="_token" value="${escapeHtml(csrfToken || '')}">
                            <button type="submit" class="inline-flex rounded-xl border border-slate-700 px-4 py-3 text-sm font-semibold text-slate-100 transition hover:border-sky-400 hover:text-sky-300">
                                Mark read
                            </button>
                        </form>
                    `}
                    ${notification.dismissed_at ? '' : `
                        <form method="POST" action="${escapeHtml(notification.dismiss_url)}">
                            <input type="hidden" name="_token" value="${escapeHtml(csrfToken || '')}">
                            <button type="submit" class="inline-flex rounded-xl border border-slate-700 px-4 py-3 text-sm font-semibold text-slate-100 transition hover:border-slate-500 hover:text-white">
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
        toast.className = 'pointer-events-auto block rounded-2xl border border-slate-800 bg-slate-900/95 px-4 py-4 shadow-2xl shadow-black/40 transition hover:border-sky-500/30';
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
