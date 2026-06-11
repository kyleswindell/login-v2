import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

export const initRealtimeNotifications = () => {
    const realtimeRoot = document.querySelector('[data-realtime-notifications="1"]');

    if (!realtimeRoot || realtimeRoot.dataset.realtimeNotificationsInit === '1') {
        return;
    }

    realtimeRoot.dataset.realtimeNotificationsInit = '1';
    window.Pusher = Pusher;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const userId = realtimeRoot.dataset.userId;
    const notificationTrigger = document.querySelector('[data-notification-trigger]');
    const notificationTriggerLabel = document.querySelector('[data-notification-trigger-label]');
    const triggerSummary = document.querySelector('[data-notification-trigger-summary]');
    const markAllButton = document.querySelector('[data-notification-mark-all]');
    const markAllForm = document.querySelector('[data-notification-mark-all-form]');
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

    const syncNotificationTriggerState = (unreadCount) => {
        if (!notificationTrigger) {
            return;
        }

        const hasUnread = unreadCount > 0;
        notificationTrigger.dataset.notificationTriggerUnread = hasUnread ? 'true' : 'false';
        notificationTrigger.title = hasUnread ? `${unreadCount} unread notifications` : 'Notifications';

        if (notificationTriggerLabel) {
            notificationTriggerLabel.textContent = hasUnread ? `${unreadCount} unread notifications` : 'No unread notifications';
        }

        if (triggerSummary) {
            triggerSummary.textContent = `${unreadCount}`;
            triggerSummary.classList.toggle('hidden', !hasUnread);
            triggerSummary.dataset.notificationTriggerBadgeHidden = hasUnread ? 'false' : 'true';
        }

        if (markAllButton) {
            markAllButton.disabled = !hasUnread;
            markAllButton.dataset.notificationMarkAllEnabled = hasUnread ? 'true' : 'false';
        }
    };

    const updateUnreadSummaries = (unreadCount) => {
        syncNotificationTriggerState(unreadCount);

        if (panelSummary) {
            panelSummary.textContent = `${unreadCount} unread across your latest updates`;
        }

        if (inboxUnreadCount) {
            inboxUnreadCount.textContent = `${unreadCount}`;
        }
    };

    const severitySemantic = (severity) => {
        switch (severity) {
            case 'info':
                return 'info';
            case 'success':
                return 'success';
            case 'notice':
                return 'notice';
            case 'warning':
                return 'warning';
            case 'error':
            case 'urgent':
                return 'danger';
            default:
                return 'neutral';
        }
    };

    const unreadPreviewBadge = (notification) => notification.read_at
        ? ''
        : '<span class="ui-notification-preview-pill ui-notification-preview-pill-unread" data-notification-preview-unread>Unread</span>';

    const severityPreviewBadge = (notification) => {
        const semantic = severitySemantic(notification.severity);

        return `
            <span
                class="ui-notification-preview-pill ui-notification-preview-pill-${semantic}"
                data-notification-preview-severity="${semantic}"
            >
                ${escapeHtml(notification.severity)}
            </span>
        `;
    };

    const dismissedBadge = (notification) => notification.dismissed_at
        ? '<span class="ui-notification-state-badge ui-notification-state-badge-dismissed">Dismissed</span>'
        : '';

    const readBadge = (notification) => notification.read_at
        ? '<span class="ui-notification-state-badge ui-notification-state-badge-read" data-notification-read-badge="true">Read</span>'
        : '<span class="ui-notification-state-badge ui-notification-state-badge-unread" data-notification-read-badge="false">Unread</span>';

    const createPreviewMarkup = (notification) => `
        <a
            href="${escapeHtml(notification.action_url || indexUrl)}"
            class="ui-notification-preview-item${notification.read_at ? '' : ' ui-notification-preview-item-unread'}"
            data-notification-preview-item
            data-notification-preview-item-unread="${notification.read_at ? 'false' : 'true'}"
            data-notification-id="${notification.id}"
        >
            <div class="flex items-center gap-2">
                ${unreadPreviewBadge(notification)}
                ${severityPreviewBadge(notification)}
                <span class="ui-notification-card-meta ml-auto text-xs">${escapeHtml(notification.created_at_label || '')}</span>
            </div>
            <p class="ui-notification-card-title mt-3 text-sm font-semibold">${escapeHtml(notification.title)}</p>
            <p class="ui-notification-card-body mt-1 line-clamp-2 text-sm">${escapeHtml(notification.body)}</p>
        </a>
    `;

    const createInboxMarkup = (notification) => `
        <article class="ui-notification-card" data-notification-card data-notification-id="${notification.id}">
            <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-2" data-notification-badges>
                        <span class="ui-notification-preview-pill ui-notification-preview-pill-${severitySemantic(notification.severity)}" data-notification-severity-badge>
                            ${escapeHtml(notification.severity)}
                        </span>
                        ${readBadge(notification)}
                        ${dismissedBadge(notification)}
                    </div>
                    <h2 class="ui-notification-card-title mt-4 text-xl font-semibold">${escapeHtml(notification.title)}</h2>
                    <p class="ui-notification-card-body mt-2 leading-7">${escapeHtml(notification.body)}</p>
                    <div class="ui-notification-card-meta mt-4 flex flex-wrap gap-4 text-sm">
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
                        <form method="POST" action="${escapeHtml(notification.mark_read_url)}" data-notification-mark-read-form>
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

    const markPreviewItemReadLocally = (item) => {
        if (!(item instanceof HTMLElement)) {
            return;
        }

        item.dataset.notificationPreviewItemUnread = 'false';
        item.classList.remove('ui-notification-preview-item-unread');
        item.querySelector('[data-notification-preview-unread]')?.remove();
    };

    const markInboxCardReadLocally = (card) => {
        if (!(card instanceof HTMLElement)) {
            return;
        }

        card.querySelectorAll('[data-notification-mark-read-form]').forEach((form) => form.remove());

        const badges = card.querySelector('[data-notification-badges]');

        if (!(badges instanceof HTMLElement)) {
            return;
        }

        const readBadgeElement = badges.querySelector('[data-notification-read-badge]');

        if (readBadgeElement instanceof HTMLElement) {
            readBadgeElement.className = 'ui-notification-state-badge ui-notification-state-badge-read';
            readBadgeElement.dataset.notificationReadBadge = 'true';
            readBadgeElement.textContent = 'Read';
            return;
        }

        const severityBadge = badges.querySelector('[data-notification-severity-badge]');
        const badge = document.createElement('span');
        badge.className = 'ui-notification-state-badge ui-notification-state-badge-read';
        badge.dataset.notificationReadBadge = 'true';
        badge.textContent = 'Read';

        if (severityBadge?.nextSibling) {
            badges.insertBefore(badge, severityBadge.nextSibling);
            return;
        }

        badges.append(badge);
    };

    const markNotificationsReadLocally = (notificationIds = []) => {
        const ids = new Set(notificationIds.map((id) => String(id)));

        previewList?.querySelectorAll('[data-notification-id]').forEach((item) => {
            if (ids.size > 0 && !ids.has(item.dataset.notificationId || '')) {
                return;
            }

            markPreviewItemReadLocally(item);
        });

        inboxList?.querySelectorAll('[data-notification-id]').forEach((card) => {
            if (ids.size > 0 && !ids.has(card.dataset.notificationId || '')) {
                return;
            }

            markInboxCardReadLocally(card);
        });
    };

    const createToast = (notification) => {
        if (!toastContainer) {
            return;
        }

        const existing = toastContainer.querySelector(`[data-notification-toast-id="${notification.id}"]`);
        existing?.remove();

        const toast = document.createElement('a');
        toast.href = notification.action_url || indexUrl;
        toast.dataset.notificationToastId = `${notification.id}`;
        toast.className = 'ui-notification-runtime-toast';
        toast.innerHTML = `
            <div class="flex items-start gap-3">
                <div class="mt-0.5">
                    ${severityPreviewBadge(notification)}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="ui-notification-card-title text-sm font-semibold">${escapeHtml(notification.title)}</p>
                    <p class="ui-notification-card-body mt-1 text-sm">${escapeHtml(notification.body)}</p>
                </div>
                <button type="button" class="ui-notification-runtime-toast-close ml-2 transition" data-notification-toast-close>×</button>
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

    if (markAllForm && markAllButton && csrfToken) {
        markAllForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            if (markAllButton.disabled) {
                return;
            }

            const originalLabel = markAllButton.textContent;
            markAllButton.disabled = true;
            markAllButton.textContent = 'Updating...';

            try {
                const response = await window.fetch(markAllForm.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                        'X-CSRF-TOKEN': csrfToken,
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: new URLSearchParams(new FormData(markAllForm)).toString(),
                    credentials: 'same-origin',
                });

                if (!response.ok) {
                    markAllForm.submit();
                    return;
                }

                const payload = await response.json();
                updateUnreadSummaries(payload.unread_count ?? 0);
                markNotificationsReadLocally(payload.marked_notification_ids ?? []);
            } catch (error) {
                markAllForm.submit();
                return;
            } finally {
                markAllButton.textContent = originalLabel;
                markAllButton.disabled = markAllButton.dataset.notificationMarkAllEnabled !== 'true';
            }
        });
    }

    echo.private(`App.Models.User.${userId}`)
        .listen('.notification.created', (event) => {
            applyNotification(event.notification, { toast: true });
        })
        .listen('.notification.updated', (event) => {
            applyNotification(event.notification, { toast: false });
        });

    window.addEventListener('platform-notification-created', (event) => {
        const notification = event.detail?.notification;

        if (!notification) {
            return;
        }

        applyNotification(notification, { toast: true });
    });
};
