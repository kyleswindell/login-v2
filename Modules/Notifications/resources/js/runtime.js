/**
 * File: Modules/Notifications/resources/js/runtime.js
 * Purpose: Runtime notification orchestration for realtime events and toasts.
 *
 * Notes:
 * - Keeps realtime notification updates wired to the Notifications module.
 * - Renders runtime toasts through the installed Notification toast contract.
 */

import Echo from "laravel-echo";
import Pusher from "pusher-js";
import {
    dismissToast,
    prependToast,
} from "/resources/js/ui-controls/notification.js";

const MAX_PRESENTED_TOAST_IDS = 250;
const MARK_ALL_BOUND_ATTR = "data-notification-mark-all-bound";

const presentedPersistentToastIds = new Set();
const presentedTransientToastIds = new Set();

let currentApplyNotification = null;
let currentCreateToast = null;
let realtimeEcho = null;
let realtimeChannelName = null;
let realtimeConnectionSignature = null;
let transientToastEventsBound = false;

const rememberBoundedId = (ids, id) => {
    if (!id) {
        return true;
    }

    const normalizedId = `${id}`;

    if (ids.has(normalizedId)) {
        return false;
    }

    ids.add(normalizedId);

    while (ids.size > MAX_PRESENTED_TOAST_IDS) {
        ids.delete(ids.values().next().value);
    }

    return true;
};

const persistentNotificationId = (notification) =>
    notification?.id || notification?.uuid || null;

const disconnectRealtime = () => {
    if (!realtimeEcho) {
        realtimeChannelName = null;
        realtimeConnectionSignature = null;

        return;
    }

    if (realtimeChannelName) {
        realtimeEcho.leave(realtimeChannelName);
    }

    realtimeEcho.disconnect();
    realtimeEcho = null;
    realtimeChannelName = null;
    realtimeConnectionSignature = null;
};

export const initNotificationRuntime = (root = document) => {
    const runtimeDocument =
        root instanceof Document ? root : root.ownerDocument || document;
    const transientRoot = runtimeDocument.querySelector(
        '[data-transient-notifications="1"]',
    );
    const toastPayloadsScript = runtimeDocument.querySelector(
        "[data-transient-notification-payloads]",
    );
    const realtimeRoot = runtimeDocument.querySelector(
        '[data-realtime-notifications="1"]',
    );

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");
    const userId = realtimeRoot?.dataset.userId;
    const notificationTrigger = document.querySelector(
        "[data-notification-trigger]",
    );
    const notificationTriggerLabel = document.querySelector(
        "[data-notification-trigger-label]",
    );
    const triggerSummary = document.querySelector(
        "[data-notification-trigger-summary]",
    );
    const markAllButton = document.querySelector(
        "[data-notification-mark-all]",
    );
    const markAllForm = document.querySelector(
        "[data-notification-mark-all-form]",
    );
    const panelSummary = document.querySelector(
        "[data-notification-panel-summary]",
    );
    const previewLists = Array.from(
        document.querySelectorAll("[data-notification-preview-list]"),
    );
    const inboxList = document.querySelector("[data-notification-inbox-list]");
    const inboxEmptyState = document.querySelector(
        "[data-notification-inbox-empty-state]",
    );
    const inboxUnreadCount = document.querySelector(
        "[data-notification-inbox-unread-count]",
    );
    const indexUrl = realtimeRoot?.dataset.notificationsIndexUrl;
    const realtimeAuthUrl =
        realtimeRoot?.dataset.notificationsRealtimeAuthUrl ||
        "/notifications/realtime/auth";

    const escapeHtml = (value) =>
        String(value ?? "")
            .replaceAll("&", "&amp;")
            .replaceAll("<", "&lt;")
            .replaceAll(">", "&gt;")
            .replaceAll('"', "&quot;")
            .replaceAll("'", "&#039;");

    const syncNotificationTriggerState = (unreadCount) => {
        if (!notificationTrigger) {
            return;
        }

        const hasUnread = unreadCount > 0;
        const triggerText = hasUnread
            ? `${unreadCount} unread notifications`
            : "No unread notifications";

        notificationTrigger.dataset.notificationTriggerUnread = hasUnread
            ? "true"
            : "false";
        notificationTrigger.setAttribute("aria-label", triggerText);
        notificationTrigger.title = triggerText;

        if (notificationTriggerLabel) {
            notificationTriggerLabel.textContent = triggerText;
        }

        if (triggerSummary) {
            triggerSummary.textContent = `${unreadCount}`;
            triggerSummary.classList.toggle("hidden", !hasUnread);
            triggerSummary.dataset.notificationTriggerBadgeHidden = hasUnread
                ? "false"
                : "true";
        }

        if (markAllButton) {
            markAllButton.disabled = !hasUnread;
            markAllButton.dataset.notificationMarkAllEnabled = hasUnread
                ? "true"
                : "false";
        }
    };

    const syncUnreadFilterTag = (unreadCount) => {
        const count = Math.max(0, Number.parseInt(unreadCount, 10) || 0);
        const hasUnread = count > 0;
        const countText = `${count}`;
        const accessibleText =
            count === 1
                ? "1 unread notification"
                : `${count} unread notifications`;

        document
            .querySelectorAll('[data-notification-filter-count-tag="unread"]')
            .forEach((tag) => {
                if (!(tag instanceof HTMLElement)) {
                    return;
                }

                tag.dataset.notificationCountValue = countText;
                tag.dataset.notificationCountEmpty = hasUnread
                    ? "false"
                    : "true";
                tag.setAttribute("aria-hidden", "true");

                const visibleLabel =
                    tag.querySelector(
                        "[data-notification-filter-count-value]",
                    ) ||
                    tag.querySelector(".ui-tag-label") ||
                    tag.querySelector(".ui-tag-label-middle") ||
                    tag.querySelector(".ui-tag-label-end") ||
                    tag.querySelector(".ui-tag-label-start");

                if (visibleLabel instanceof HTMLElement) {
                    visibleLabel.textContent = countText;
                    return;
                }

                tag.textContent = countText;
            });

        document
            .querySelectorAll('[data-notification-filter-count-sr="unread"]')
            .forEach((node) => {
                node.textContent = accessibleText;
            });
    };

    const updateUnreadSummaries = (unreadCount) => {
        const count = Math.max(0, Number.parseInt(unreadCount, 10) || 0);

        syncNotificationTriggerState(count);
        syncUnreadFilterTag(count);

        if (panelSummary) {
            panelSummary.textContent = `${count} unread across your latest updates`;
        }

        if (inboxUnreadCount) {
            inboxUnreadCount.textContent = `${count}`;
        }
    };

    const severitySemantic = (severity) => {
        switch (severity) {
            case "info":
                return "info";
            case "success":
                return "success";
            case "notice":
                return "notice";
            case "warning":
                return "warning";
            case "error":
            case "urgent":
                return "danger";
            default:
                return "neutral";
        }
    };

    const toastKind = (severity) => {
        switch (severity) {
            case "error":
                return "error";
            case "success":
                return "success";
            case "warning":
                return "warning";
            case "urgent":
                return "warning";
            case "info":
            case "notice":
                return "info";
            default:
                return "info";
        }
    };

    const transientToastKind = (kind) => {
        switch (kind) {
            case "error":
            case "success":
            case "warning":
            case "info":
                return kind;
            default:
                return "info";
        }
    };

    const unreadPreviewBadge = (notification) =>
        notification.read_at
            ? ""
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

    const dismissedBadge = (notification) =>
        notification.dismissed_at
            ? '<span class="ui-notification-state-badge ui-notification-state-badge-dismissed">Dismissed</span>'
            : "";

    const readBadge = (notification) =>
        notification.read_at
            ? '<span class="ui-notification-state-badge ui-notification-state-badge-read" data-notification-read-badge="true">Read</span>'
            : '<span class="ui-notification-state-badge ui-notification-state-badge-unread" data-notification-read-badge="false">Unread</span>';

    const createPreviewMarkup = (notification) => `
        <a
            href="${escapeHtml(notification.action_url || indexUrl)}"
            class="ui-notification-preview-item${notification.read_at ? "" : " ui-notification-preview-item-unread"}"
            data-notification-preview-item
            data-notification-preview-item-unread="${notification.read_at ? "false" : "true"}"
            data-notification-id="${notification.id}"
        >
            <div class="flex items-center gap-2">
                ${unreadPreviewBadge(notification)}
                ${severityPreviewBadge(notification)}
                <span class="ui-notification-card-meta ml-auto text-xs">${escapeHtml(notification.created_at_label || "")}</span>
            </div>
            <p class="ui-notification-card-title mt-3 text-sm font-semibold">${escapeHtml(notification.title)}</p>
            <p class="ui-notification-card-body mt-1 line-clamp-2 text-sm">${escapeHtml(notification.body)}</p>
        </a>
    `;

    const createShellPreviewMarkup = (notification) => {
        const semantic = severitySemantic(notification.severity);
        const unread = !notification.read_at;

        return `
            <li
                class="ui-shell-notification-row${unread ? " ui-shell-notification-row--unread" : ""} ui-shell-notification-row--${semantic}"
                data-app-notification-row
                data-app-notification-id="${escapeHtml(notification.id)}"
                data-app-notification-unread="${unread ? "true" : "false"}"
                data-notification-preview-item
                data-notification-preview-item-unread="${unread ? "true" : "false"}"
                data-notification-id="${escapeHtml(notification.id)}"
            >
                <a
                    href="${escapeHtml(notification.action_url || indexUrl)}"
                    class="ui-shell-notification-row__main"
                    wire:navigate
                >
                    <span
                        class="ui-shell-notification-row__status"
                        ${unread ? "data-notification-preview-unread" : ""}
                        data-notification-preview-severity="${semantic}"
                        aria-hidden="true"
                    ></span>

                    <span class="ui-shell-notification-row__content">
                        <span class="ui-shell-notification-row__meta">
                            ${escapeHtml(notification.created_at_label || "")}
                        </span>

                        <span class="ui-shell-notification-row__title">
                            ${escapeHtml(notification.title)}
                        </span>

                        <span class="ui-shell-notification-row__subtitle">
                            ${escapeHtml(notification.body)}
                        </span>
                    </span>
                </a>

                <button
                    type="button"
                    class="ui-shell-notification-row__dismiss"
                    aria-label="Dismiss ${escapeHtml(notification.title)}"
                    data-app-notification-dismiss
                >
                    ×
                </button>
            </li>
        `;
    };

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
                        <span data-notification-created-label>${escapeHtml(notification.created_at_label || "")}</span>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="${escapeHtml(notification.action_url || indexUrl)}" class="ui-action ui-action-notice text-sm">
                            Open notification link
                        </a>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3" data-notification-actions>
                    ${
                        notification.read_at
                            ? ""
                            : `
                        <form method="POST" action="${escapeHtml(notification.mark_read_url)}" data-notification-mark-read-form>
                            <input type="hidden" name="_token" value="${escapeHtml(csrfToken || "")}">
                            <button type="submit" class="ui-action ui-action-success">
                                Mark read
                            </button>
                        </form>
                    `
                    }
                    ${
                        notification.dismissed_at
                            ? ""
                            : `
                        <form method="POST" action="${escapeHtml(notification.dismiss_url)}">
                            <input type="hidden" name="_token" value="${escapeHtml(csrfToken || "")}">
                            <button type="submit" class="ui-action ui-action-ghost">
                                Dismiss
                            </button>
                        </form>
                    `
                    }
                </div>
            </div>
        </article>
    `;

    const isShellPreviewList = (previewList) =>
        previewList?.classList.contains("ui-shell-notifications-list");

    const renderPreviewItemInList = (previewList, notification) => {
        if (!previewList) {
            return;
        }

        const existing = previewList.querySelector(
            `[data-notification-id="${notification.id}"]`,
        );
        const previewEmptyState = previewList
            .closest(
                "[data-app-notifications-filter-panel], [data-notification-panel]",
            )
            ?.querySelector("[data-notification-preview-empty-state]");

        if (previewEmptyState) {
            previewEmptyState.remove();
        }

        const previewSection = previewList.closest(
            ".ui-shell-notifications-menu__section",
        );

        if (previewSection instanceof HTMLElement) {
            previewSection.hidden = false;
        }

        const markup = isShellPreviewList(previewList)
            ? createShellPreviewMarkup(notification)
            : createPreviewMarkup(notification);

        if (existing) {
            existing.outerHTML = markup;
            return;
        }

        previewList.insertAdjacentHTML("afterbegin", markup);

        while (
            previewList.querySelectorAll("[data-notification-preview-item]")
                .length > 5
        ) {
            previewList
                .querySelector("[data-notification-preview-item]:last-of-type")
                ?.remove();
        }
    };

    const renderPreviewItem = (notification) => {
        previewLists.forEach((previewList) =>
            renderPreviewItemInList(previewList, notification),
        );
    };

    const renderInboxItem = (notification) => {
        if (!inboxList) {
            return;
        }

        if (inboxEmptyState) {
            inboxEmptyState.remove();
        }

        const existing = inboxList.querySelector(
            `[data-notification-id="${notification.id}"]`,
        );

        if (existing) {
            existing.outerHTML = createInboxMarkup(notification);
            return;
        }

        inboxList.insertAdjacentHTML(
            "afterbegin",
            createInboxMarkup(notification),
        );
    };

    const markPreviewItemReadLocally = (item) => {
        if (!(item instanceof HTMLElement)) {
            return;
        }

        item.dataset.notificationPreviewItemUnread = "false";
        item.classList.remove("ui-notification-preview-item-unread");
        item.classList.remove("ui-shell-notification-row--unread");
        item.dataset.appNotificationUnread = "false";

        item.querySelectorAll("[data-notification-preview-unread]").forEach(
            (marker) => {
                if (!(marker instanceof HTMLElement)) {
                    return;
                }

                if (
                    marker.classList.contains(
                        "ui-shell-notification-row__status",
                    ) ||
                    marker.classList.contains("ui-contained-list-item-icon")
                ) {
                    marker.removeAttribute("data-notification-preview-unread");
                    return;
                }

                marker.remove();
            },
        );
    };

    const markInboxCardReadLocally = (card) => {
        if (!(card instanceof HTMLElement)) {
            return;
        }

        card.querySelectorAll("[data-notification-mark-read-form]").forEach(
            (form) => form.remove(),
        );

        const badges = card.querySelector("[data-notification-badges]");

        if (!(badges instanceof HTMLElement)) {
            return;
        }

        const readBadgeElement = badges.querySelector(
            "[data-notification-read-badge]",
        );

        if (readBadgeElement instanceof HTMLElement) {
            readBadgeElement.className =
                "ui-notification-state-badge ui-notification-state-badge-read";
            readBadgeElement.dataset.notificationReadBadge = "true";
            readBadgeElement.textContent = "Read";
            return;
        }

        const severityBadge = badges.querySelector(
            "[data-notification-severity-badge]",
        );
        const badge = document.createElement("span");
        badge.className =
            "ui-notification-state-badge ui-notification-state-badge-read";
        badge.dataset.notificationReadBadge = "true";
        badge.textContent = "Read";

        if (severityBadge?.nextSibling) {
            badges.insertBefore(badge, severityBadge.nextSibling);
            return;
        }

        badges.append(badge);
    };

    const syncPreviewPanelEmptyState = (panel) => {
        if (!(panel instanceof HTMLElement)) {
            return;
        }

        const hasVisibleItems = Array.from(
            panel.querySelectorAll("[data-notification-preview-item]"),
        ).some((item) => item instanceof HTMLElement && !item.hidden);

        panel
            .querySelectorAll(".ui-shell-notifications-menu__section")
            .forEach((section) => {
                if (!(section instanceof HTMLElement)) {
                    return;
                }

                const hasSectionItems = Array.from(
                    section.querySelectorAll(
                        "[data-notification-preview-item]",
                    ),
                ).some((item) => item instanceof HTMLElement && !item.hidden);

                section.hidden = !hasSectionItems;
            });

        let emptyState = panel.querySelector(
            "[data-notification-preview-empty-state]",
        );

        if (hasVisibleItems) {
            emptyState?.remove();
            return;
        }

        if (!(emptyState instanceof HTMLElement)) {
            emptyState = document.createElement("div");
            emptyState.className = "ui-shell-notifications-menu__empty";
            emptyState.dataset.notificationPreviewEmptyState = "";
            panel.append(emptyState);
        }

        emptyState.textContent =
            panel.dataset.appNotificationsFilterPanel === "all"
                ? "No notifications."
                : "No unread notifications.";
    };

    const markNotificationsReadLocally = (notificationIds = []) => {
        const ids = new Set(notificationIds.map((id) => String(id)));

        previewLists.forEach((previewList) => {
            const isUnreadPreviewList =
                previewList.dataset.notificationPreviewList === "unread";

            previewList
                .querySelectorAll("[data-notification-id]")
                .forEach((item) => {
                    if (!(item instanceof HTMLElement)) {
                        return;
                    }

                    if (
                        ids.size > 0 &&
                        !ids.has(item.dataset.notificationId || "")
                    ) {
                        return;
                    }

                    if (isUnreadPreviewList) {
                        item.remove();
                        return;
                    }

                    markPreviewItemReadLocally(item);
                });

            syncPreviewPanelEmptyState(
                previewList.closest(
                    "[data-app-notifications-filter-panel], [data-notification-panel]",
                ),
            );
        });

        inboxList
            ?.querySelectorAll("[data-notification-id]")
            .forEach((card) => {
                if (!(card instanceof HTMLElement)) {
                    return;
                }

                if (
                    ids.size > 0 &&
                    !ids.has(card.dataset.notificationId || "")
                ) {
                    return;
                }

                markInboxCardReadLocally(card);
            });
    };

    const createToast = (notification, options = { persistent: false }) => {
        const toastContainer = document.querySelector(
            "[data-notification-toast-container]",
        );

        if (!toastContainer) {
            return;
        }

        const explicitNotificationId =
            notification.id ||
            notification.uuid ||
            notification.toast_id ||
            null;
        const notificationId =
            explicitNotificationId ||
            `transient-${Date.now()}-${Math.random().toString(36).slice(2)}`;

        const existing = toastContainer.querySelector(
            `[data-notification-toast-id="${notificationId}"]`,
        );
        if (existing instanceof HTMLElement) {
            return existing;
        }

        if (
            !options.persistent &&
            explicitNotificationId &&
            !rememberBoundedId(
                presentedTransientToastIds,
                explicitNotificationId,
            )
        ) {
            return null;
        }

        const kind = notification.kind
            ? transientToastKind(notification.kind)
            : toastKind(notification.severity);
        const template = document.querySelector(
            `[data-notification-toast-template="${kind}"]`,
        );
        const toast =
            template?.content?.firstElementChild?.cloneNode(true) ??
            document.createElement("div");

        if (!template) {
            toast.className = `ui-toast-notification ui-toast-notification--${kind}`;
            toast.setAttribute("role", "status");
            toast.setAttribute("kind", kind);
            toast.dataset.uiNotification = "true";
            toast.dataset.uiNotificationType = "toast";
            toast.dataset.uiNotificationKind = kind;
            toast.innerHTML = `
                <span
                    class="ui-toast-notification__icon"
                    data-ui-notification-icon
                    data-ui-notification-kind="${kind}"
                >
                    <span class="ui-visually-hidden">${kind} icon</span>
                </span>
                <div class="ui-toast-notification__details">
                    <div class="ui-toast-notification__title"></div>
                    <div class="ui-toast-notification__subtitle"></div>
                </div>
                <button
                    type="button"
                    class="ui-toast-notification__close-button"
                    aria-label="Close notification"
                    title="Close notification"
                    data-ui-notification-close
                >×</button>
            `;
        }

        toast.dataset.notificationToastId = `${notificationId}`;
        toast.dataset.uiNotificationKind = kind;

        toast.dataset.uiNotification = "true";
        toast.dataset.uiNotificationType = "toast";
        toast.dataset.uiNotificationToast = "true";
        toast.dataset.uiNotificationOpen = "true";

        const toastTitle = toast.querySelector(".ui-toast-notification__title");
        const toastSubtitle = toast.querySelector(
            ".ui-toast-notification__subtitle",
        );
        const closeButton = toast.querySelector("[data-ui-notification-close]");
        const closeLabel = `Close ${notification.title || "notification"}`;
        const subtitle = notification.subtitle || notification.body || "";

        if (toastTitle) {
            toastTitle.textContent = notification.title || "Notification";
        }

        if (toastSubtitle) {
            toastSubtitle.textContent = subtitle;
        }

        closeButton?.setAttribute(
            "aria-label",
            notification.close_label || notification.closeLabel || closeLabel,
        );
        closeButton?.setAttribute(
            "title",
            notification.close_label || notification.closeLabel || closeLabel,
        );

        prependToast(toastContainer, toast);

        const removeToast = () => dismissToast(toast);

        closeButton?.addEventListener("click", (event) => {
            event.preventDefault();
            event.stopPropagation();
            removeToast();
        });

        const timeout = Number.parseInt(notification.timeout, 10);

        if (timeout !== 0) {
            window.setTimeout(
                removeToast,
                Number.isFinite(timeout) && timeout > 0 ? timeout : 5000,
            );
        }

        return toast;
    };

    const transientToastPayloads = () => {
        if (!(toastPayloadsScript instanceof HTMLScriptElement)) {
            return [];
        }

        try {
            const payloads = JSON.parse(
                toastPayloadsScript.textContent || "[]",
            );

            return Array.isArray(payloads) ? payloads : [];
        } catch (error) {
            return [];
        }
    };

    const initTransientToasts = () => {
        if (
            transientRoot instanceof HTMLElement &&
            transientRoot.dataset.transientNotificationsInit !== "1"
        ) {
            transientRoot.dataset.transientNotificationsInit = "1";
            transientToastPayloads().forEach((payload) => {
                if (payload && typeof payload === "object") {
                    createToast(payload);
                }
            });
        }

        if (!transientToastEventsBound) {
            transientToastEventsBound = true;

            window.addEventListener("notifications:toast", (event) => {
                const payload = event.detail;

                if (
                    payload &&
                    typeof payload === "object" &&
                    typeof currentCreateToast === "function"
                ) {
                    currentCreateToast(payload);
                }
            });
        }
    };

    const applyNotification = (
        notification,
        options = { toast: false, persistent: false },
    ) => {
        updateUnreadSummaries(notification.unread_count ?? 0);
        renderPreviewItem(notification);
        renderInboxItem(notification);

        const shouldToast =
            options.toast &&
            !notification.read_at &&
            (!options.persistent ||
                rememberBoundedId(
                    presentedPersistentToastIds,
                    persistentNotificationId(notification),
                ));

        if (shouldToast) {
            createToast(notification, { persistent: options.persistent });
        }
    };

    currentCreateToast = createToast;
    currentApplyNotification = applyNotification;

    if (
        markAllForm &&
        markAllButton &&
        csrfToken &&
        !markAllForm.hasAttribute(MARK_ALL_BOUND_ATTR)
    ) {
        markAllForm.setAttribute(MARK_ALL_BOUND_ATTR, "true");

        markAllForm.addEventListener("submit", async (event) => {
            event.preventDefault();

            if (markAllButton.disabled) {
                return;
            }

            const originalLabel = markAllButton.textContent;
            markAllButton.disabled = true;
            markAllButton.textContent = "Updating...";

            try {
                const response = await window.fetch(markAllForm.action, {
                    method: "POST",
                    headers: {
                        "Content-Type":
                            "application/x-www-form-urlencoded; charset=UTF-8",
                        "X-CSRF-TOKEN": csrfToken,
                        Accept: "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                    },
                    body: new URLSearchParams(
                        new FormData(markAllForm),
                    ).toString(),
                    credentials: "same-origin",
                });

                if (!response.ok) {
                    markAllForm.submit();
                    return;
                }

                const payload = await response.json();
                updateUnreadSummaries(payload.unread_count ?? 0);
                markNotificationsReadLocally(
                    payload.marked_notification_ids ?? [],
                );
            } catch (error) {
                markAllForm.submit();
                return;
            } finally {
                markAllButton.textContent = originalLabel;
                markAllButton.disabled =
                    markAllButton.dataset.notificationMarkAllEnabled !== "true";
            }
        });
    }

    initTransientToasts();

    if (!realtimeRoot || !userId) {
        disconnectRealtime();

        return;
    }

    const connectionSignature = JSON.stringify({
        userId: `${userId}`,
        realtimeAuthUrl,
        csrfToken,
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: import.meta.env.VITE_REVERB_HOST,
        wsPort: Number(import.meta.env.VITE_REVERB_PORT ?? 80),
        wssPort: Number(import.meta.env.VITE_REVERB_PORT ?? 443),
        forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? "https") === "https",
    });

    if (realtimeEcho && realtimeConnectionSignature === connectionSignature) {
        return;
    }

    disconnectRealtime();
    window.Pusher = Pusher;

    realtimeEcho = new Echo({
        broadcaster: "reverb",
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: import.meta.env.VITE_REVERB_HOST,
        wsPort: Number(import.meta.env.VITE_REVERB_PORT ?? 80),
        wssPort: Number(import.meta.env.VITE_REVERB_PORT ?? 443),
        forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? "https") === "https",
        enabledTransports: ["ws", "wss"],
        authEndpoint: realtimeAuthUrl,
        authorizer: (channel) => ({
            authorize: (socketId, callback) => {
                window.axios
                    .post(realtimeAuthUrl, {
                        socket_id: socketId,
                        channel_name: channel.name,
                        _token: csrfToken,
                    })
                    .then((response) => {
                        callback(false, response.data);
                    })
                    .catch((error) => {
                        callback(true, error);
                    });
            },
        }),
    });

    realtimeChannelName = `App.Models.User.${userId}`;
    realtimeConnectionSignature = connectionSignature;

    realtimeEcho
        .private(realtimeChannelName)
        .listen(".notification.created", (event) => {
            currentApplyNotification?.(event.notification, {
                toast: true,
                persistent: true,
            });
        })
        .listen(".notification.updated", (event) => {
            currentApplyNotification?.(event.notification, {
                toast: false,
                persistent: true,
            });
        });
};
