/**
 * File: Modules/Notifications/resources/js/header-menu.js
 * Purpose: App header notifications popover behavior.
 *
 * Notes:
 * - Popover open/close is handled by initPopovers.
 * - This file handles Unread / All panel switching, persisted dismiss hooks,
 *   panel empty-state sync, and realtime row normalization for notification
 *   preview rows.
 * - Shared row dismiss motion is handled by resources/js/ui-controls/motion.js.
 * - Runtime.js owns realtime unread count synchronization. This file only
 *   performs local unread counter reconciliation after a user-initiated
 *   persisted dismiss action.
 */

import { collapseExitMotion, restoreMotionElement } from "@/ui-controls/motion";

const MENU_SELECTOR = "[data-app-notifications-menu]";
const FILTER_SELECTOR = "[data-app-notifications-filter]";
const PANEL_SELECTOR = "[data-app-notifications-filter-panel]";
const DISMISS_SELECTOR = "[data-app-notification-dismiss]";
const ROW_SELECTOR = "[data-app-notification-row]";
const SWITCHER_SELECTOR = "[data-app-notifications-filter-switcher]";

const NOTIFICATION_TRIGGER_SELECTOR = "[data-notification-trigger]";
const NOTIFICATION_TRIGGER_LABEL_SELECTOR = "[data-notification-trigger-label]";
const NOTIFICATION_TRIGGER_SUMMARY_SELECTOR =
    "[data-notification-trigger-summary]";
const NOTIFICATION_PANEL_SUMMARY_SELECTOR = "[data-notification-panel-summary]";
const NOTIFICATION_UNREAD_TAG_SELECTOR =
    '[data-notification-filter-count-tag="unread"]';
const NOTIFICATION_UNREAD_TAG_VALUE_SELECTOR =
    "[data-notification-filter-count-value]";
const NOTIFICATION_UNREAD_TAG_SR_SELECTOR =
    '[data-notification-filter-count-sr="unread"]';
const MARK_ALL_SELECTOR = "[data-notification-mark-all]";

const BOUND_ATTR = "data-app-notifications-bound";
const BODY_SELECTOR = ".ui-shell-notifications-menu__body";
const ROW_NORMALIZED_ATTR = "data-app-notification-row-normalized";
const ROW_OBSERVER_BOUND_ATTR = "data-app-notification-row-observer-bound";

const MOTION_STATE_ATTR = "data-ui-motion-state";
const MOTION_STATE_EXITING = "exiting";

const DISMISS_TEMPLATE_TOKEN = "__NOTIFICATION_ID__";

const DISMISS_KEEPALIVE_CONTENT_TYPE =
    "application/x-www-form-urlencoded; charset=UTF-8";

const pendingDismissRequests = new Map();

let navigationDismissFlushBound = false;
let pageIsTransitioning = false;
let pageTransitionResetTimer = null;

/* --------------------------------------------------------------------------
   Filter tabs
   -------------------------------------------------------------------------- */

function setActiveFilter(menu, filter) {
    menu.dataset.appNotificationsActiveFilter = filter;

    const switcher = menu.querySelector(SWITCHER_SELECTOR);

    if (switcher instanceof HTMLElement) {
        switcher.dataset.uiContentSwitcherValue = filter;
    }

    menu.querySelectorAll(FILTER_SELECTOR).forEach((button) => {
        if (!(button instanceof HTMLElement)) {
            return;
        }

        const isActive = button.dataset.appNotificationsFilter === filter;

        button.classList.toggle("ui-content-switcher--selected", isActive);
        button.classList.toggle(
            "ui-content-switcher-button-selected",
            isActive,
        );
        button.classList.toggle(
            "ui-content-switcher-option-selected",
            isActive,
        );

        button.setAttribute("aria-selected", isActive ? "true" : "false");
        button.removeAttribute("aria-pressed");
        button.dataset.uiCurrent = isActive ? "true" : "false";
        button.tabIndex = isActive ? 0 : -1;
    });

    menu.querySelectorAll(PANEL_SELECTOR).forEach((panel) => {
        panel.hidden = panel.dataset.appNotificationsFilterPanel !== filter;
    });
}

/* --------------------------------------------------------------------------
   Unread counter reconciliation
   -------------------------------------------------------------------------- */

function parseCount(value) {
    const parsed = Number.parseInt(value, 10);

    return Number.isFinite(parsed) ? parsed : null;
}

function getCurrentUnreadCount() {
    const triggerSummary = document.querySelector(
        NOTIFICATION_TRIGGER_SUMMARY_SELECTOR,
    );

    if (triggerSummary instanceof HTMLElement) {
        const count = parseCount(triggerSummary.textContent);

        if (count !== null) {
            return Math.max(0, count);
        }
    }

    const unreadTag = document.querySelector(NOTIFICATION_UNREAD_TAG_SELECTOR);

    if (unreadTag instanceof HTMLElement) {
        const count = parseCount(unreadTag.dataset.notificationCountValue);

        if (count !== null) {
            return Math.max(0, count);
        }

        const tagTextCount = parseCount(unreadTag.textContent);

        if (tagTextCount !== null) {
            return Math.max(0, tagTextCount);
        }
    }

    const panelSummary = document.querySelector(
        NOTIFICATION_PANEL_SUMMARY_SELECTOR,
    );

    if (panelSummary instanceof HTMLElement) {
        const summaryCount = parseCount(panelSummary.textContent);

        if (summaryCount !== null) {
            return Math.max(0, summaryCount);
        }
    }

    return 0;
}

function normalizeUnreadCount(unreadCount) {
    const count = Number.parseInt(unreadCount, 10);

    if (!Number.isFinite(count)) {
        return 0;
    }

    return Math.max(0, count);
}

function getUnreadTriggerText(unreadCount) {
    if (unreadCount === 0) {
        return "No unread notifications";
    }

    if (unreadCount === 1) {
        return "1 unread notification";
    }

    return `${unreadCount} unread notifications`;
}

function getUnreadPanelSummaryText(unreadCount) {
    if (unreadCount === 0) {
        return "No unread notifications across your latest updates";
    }

    if (unreadCount === 1) {
        return "1 unread notification across your latest updates";
    }

    return `${unreadCount} unread across your latest updates`;
}

function syncUnreadCountTag(unreadCount) {
    const count = normalizeUnreadCount(unreadCount);
    const hasUnread = count > 0;
    const countText = `${count}`;
    const accessibleText = getUnreadTriggerText(count);

    document
        .querySelectorAll(NOTIFICATION_UNREAD_TAG_SELECTOR)
        .forEach((tag) => {
            if (!(tag instanceof HTMLElement)) {
                return;
            }

            tag.dataset.notificationCountValue = countText;
            tag.dataset.notificationCountEmpty = hasUnread ? "false" : "true";
            tag.setAttribute("aria-hidden", "true");

            const visibleLabel =
                tag.querySelector(NOTIFICATION_UNREAD_TAG_VALUE_SELECTOR) ||
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
        .querySelectorAll(NOTIFICATION_UNREAD_TAG_SR_SELECTOR)
        .forEach((node) => {
            node.textContent = accessibleText;
        });
}

function syncNotificationTriggerState(unreadCount) {
    const count = normalizeUnreadCount(unreadCount);
    const hasUnread = count > 0;
    const triggerText = getUnreadTriggerText(count);

    document.querySelectorAll(NOTIFICATION_TRIGGER_SELECTOR).forEach((node) => {
        if (!(node instanceof HTMLElement)) {
            return;
        }

        node.dataset.notificationTriggerUnread = hasUnread ? "true" : "false";
        node.setAttribute("aria-label", triggerText);
        node.title = triggerText;
    });

    document
        .querySelectorAll(NOTIFICATION_TRIGGER_LABEL_SELECTOR)
        .forEach((node) => {
            node.textContent = triggerText;
        });

    document
        .querySelectorAll(NOTIFICATION_TRIGGER_SUMMARY_SELECTOR)
        .forEach((node) => {
            if (!(node instanceof HTMLElement)) {
                return;
            }

            node.textContent = `${count}`;
            node.classList.toggle("hidden", !hasUnread);
            node.dataset.notificationTriggerBadgeHidden = hasUnread
                ? "false"
                : "true";
            node.setAttribute("aria-label", triggerText);
        });
}

function syncMarkAllState(unreadCount) {
    const count = normalizeUnreadCount(unreadCount);
    const hasUnread = count > 0;

    document.querySelectorAll(MARK_ALL_SELECTOR).forEach((button) => {
        if (!(button instanceof HTMLElement)) {
            return;
        }

        button.dataset.notificationMarkAllEnabled = hasUnread
            ? "true"
            : "false";

        if (button instanceof HTMLButtonElement) {
            button.disabled = !hasUnread;
        }
    });
}

function syncUnreadSummaries(menu, unreadCount) {
    const count = normalizeUnreadCount(unreadCount);

    syncNotificationTriggerState(count);
    syncUnreadCountTag(count);
    syncMarkAllState(count);

    const summaryText = getUnreadPanelSummaryText(count);
    const summaryNodes = menu
        ? menu.querySelectorAll(NOTIFICATION_PANEL_SUMMARY_SELECTOR)
        : document.querySelectorAll(NOTIFICATION_PANEL_SUMMARY_SELECTOR);

    summaryNodes.forEach((node) => {
        node.textContent = summaryText;
    });
}

function getServerUnreadCount(payload) {
    if (!payload || typeof payload !== "object") {
        return null;
    }

    const candidates = [
        payload.unread_count,
        payload.unreadCount,
        payload.unread,
        payload.counts?.unread,
        payload.notification?.unread_count,
        payload.notification?.unreadCount,
    ];

    for (const candidate of candidates) {
        const count = parseCount(candidate);

        if (count !== null) {
            return Math.max(0, count);
        }
    }

    return null;
}

function isRowUnread(row) {
    return (
        row.dataset.appNotificationUnread === "true" ||
        row.dataset.notificationPreviewItemUnread === "true" ||
        row.classList.contains("ui-shell-notification-row--unread") ||
        Boolean(row.querySelector("[data-notification-preview-unread]"))
    );
}

function getDismissedUnreadCount(rows) {
    const countedIds = new Set();
    let fallbackIndex = 0;
    let count = 0;

    rows.forEach((row) => {
        if (!(row instanceof HTMLElement)) {
            return;
        }

        if (!isRowUnread(row)) {
            return;
        }

        const rowId = getNotificationId(row) || `row-${fallbackIndex}`;
        fallbackIndex += 1;

        if (countedIds.has(rowId)) {
            return;
        }

        countedIds.add(rowId);
        count += 1;
    });

    return count;
}

/* --------------------------------------------------------------------------
   Dismiss persistence
   -------------------------------------------------------------------------- */

function getCsrfToken() {
    return document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");
}

function createDismissRequestBody(csrfToken) {
    return new URLSearchParams({
        _token: csrfToken,
    }).toString();
}

function rememberPendingDismissRequest(dismissUrl, body) {
    pendingDismissRequests.set(dismissUrl, body);
}

function forgetPendingDismissRequest(dismissUrl) {
    pendingDismissRequests.delete(dismissUrl);
}

function sendPendingDismissWithBeacon(dismissUrl, body) {
    if (typeof navigator?.sendBeacon !== "function") {
        return false;
    }

    const payload = new Blob([body], {
        type: DISMISS_KEEPALIVE_CONTENT_TYPE,
    });

    return navigator.sendBeacon(dismissUrl, payload);
}

function flushPendingDismissRequests() {
    if (pendingDismissRequests.size < 1) {
        return;
    }

    pendingDismissRequests.forEach((body, dismissUrl) => {
        const sentWithBeacon = sendPendingDismissWithBeacon(dismissUrl, body);

        if (sentWithBeacon) {
            pendingDismissRequests.delete(dismissUrl);
            return;
        }

        void window
            .fetch(dismissUrl, {
                method: "POST",
                headers: {
                    "Content-Type": DISMISS_KEEPALIVE_CONTENT_TYPE,
                },
                body,
                credentials: "same-origin",
                keepalive: true,
            })
            .catch(() => {})
            .finally(() => {
                pendingDismissRequests.delete(dismissUrl);
            });
    });
}

function clearPageTransitionState() {
    pageIsTransitioning = false;

    if (pageTransitionResetTimer !== null) {
        window.clearTimeout(pageTransitionResetTimer);
        pageTransitionResetTimer = null;
    }
}

function markPageTransitioning() {
    pageIsTransitioning = true;
    flushPendingDismissRequests();

    if (pageTransitionResetTimer !== null) {
        window.clearTimeout(pageTransitionResetTimer);
    }

    pageTransitionResetTimer = window.setTimeout(() => {
        clearPageTransitionState();
    }, 5000);
}

function isNavigationRelatedFetchError(error) {
    if (!pageIsTransitioning) {
        return false;
    }

    return error?.name === "AbortError" || error instanceof TypeError;
}

function bindDismissNavigationFlush() {
    if (navigationDismissFlushBound) {
        return;
    }

    navigationDismissFlushBound = true;

    window.addEventListener("pagehide", markPageTransitioning);
    window.addEventListener("beforeunload", markPageTransitioning);

    document.addEventListener("livewire:navigating", markPageTransitioning);
    document.addEventListener("livewire:navigated", clearPageTransitionState);
}

function getNotificationId(row) {
    return row.dataset.notificationId || row.dataset.appNotificationId || null;
}

function buildDismissUrlFromTemplate(menu, row) {
    const notificationId = getNotificationId(row);
    const template = menu?.dataset?.appNotificationsDismissUrlTemplate;

    if (!notificationId || !template) {
        return null;
    }

    return template
        .split(DISMISS_TEMPLATE_TOKEN)
        .join(window.encodeURIComponent(notificationId));
}

function getDismissUrlFromRow(menu, row) {
    const dismissButton = row.querySelector(DISMISS_SELECTOR);

    if (dismissButton instanceof HTMLElement) {
        const buttonUrl = dismissButton.dataset.appNotificationDismissUrl;

        if (buttonUrl) {
            return buttonUrl;
        }
    }

    const rowUrl = row.dataset.appNotificationDismissUrl;

    if (rowUrl) {
        return rowUrl;
    }

    return buildDismissUrlFromTemplate(menu, row);
}

function setDismissDisabled(row, disabled) {
    row.querySelectorAll(DISMISS_SELECTOR).forEach((button) => {
        if (!(button instanceof HTMLElement)) {
            return;
        }

        button.setAttribute("aria-disabled", disabled ? "true" : "false");

        if (button instanceof HTMLButtonElement) {
            button.disabled = disabled;
        }
    });
}

async function readJsonPayload(response) {
    const contentType = response.headers.get("content-type") || "";

    if (!contentType.includes("application/json")) {
        return null;
    }

    try {
        return await response.json();
    } catch {
        return null;
    }
}

async function persistNotificationDismiss(menu, row) {
    const dismissUrl = getDismissUrlFromRow(menu, row);

    if (!dismissUrl) {
        window.console.warn(
            "Notification dismiss skipped: no dismiss URL was available for this row.",
            row,
        );

        return {
            ok: false,
            unreadCount: null,
        };
    }

    const csrfToken = getCsrfToken();

    if (!csrfToken) {
        window.console.warn(
            "Notification dismiss skipped: missing CSRF token.",
        );

        return {
            ok: false,
            unreadCount: null,
        };
    }

    const body = createDismissRequestBody(csrfToken);

    rememberPendingDismissRequest(dismissUrl, body);

    try {
        const response = await window.fetch(dismissUrl, {
            method: "POST",
            headers: {
                "Content-Type": DISMISS_KEEPALIVE_CONTENT_TYPE,
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
            },
            body,
            credentials: "same-origin",
            keepalive: true,
        });

        forgetPendingDismissRequest(dismissUrl);

        const payload = await readJsonPayload(response);

        return {
            ok: response.ok,
            unreadCount: getServerUnreadCount(payload),
        };
    } catch (error) {
        if (isNavigationRelatedFetchError(error)) {
            flushPendingDismissRequests();

            return {
                ok: true,
                unreadCount: null,
                pending: true,
            };
        }

        forgetPendingDismissRequest(dismissUrl);

        window.console.error("Notification dismiss failed.", error);

        return {
            ok: false,
            unreadCount: null,
        };
    }
}

/* --------------------------------------------------------------------------
   Shared motion helpers
   -------------------------------------------------------------------------- */

function isRowExiting(row) {
    return row.getAttribute(MOTION_STATE_ATTR) === MOTION_STATE_EXITING;
}

function isVisibleNotificationRow(row) {
    return (
        row instanceof HTMLElement &&
        !row.hidden &&
        row.dataset.appNotificationDismissed !== "true" &&
        !isRowExiting(row)
    );
}

function restoreFailedDismissRow(row) {
    if (!(row instanceof HTMLElement)) {
        return;
    }

    restoreMotionElement(row);
    row.dataset.appNotificationDismissed = "false";
    setDismissDisabled(row, false);
}

function markDismissedRow(row) {
    if (!(row instanceof HTMLElement)) {
        return;
    }

    row.dataset.appNotificationDismissed = "true";
}

/* --------------------------------------------------------------------------
   Local dismiss behavior
   -------------------------------------------------------------------------- */

function getMatchingNotificationRows(menu, row) {
    const notificationId = getNotificationId(row);

    if (!notificationId) {
        return [row];
    }

    return Array.from(menu.querySelectorAll(ROW_SELECTOR)).filter(
        (candidate) => {
            if (!(candidate instanceof HTMLElement)) {
                return false;
            }

            return getNotificationId(candidate) === notificationId;
        },
    );
}

async function hideMatchingNotificationRows(menu, row) {
    const matchingRows = getMatchingNotificationRows(menu, row);
    const dismissedUnreadCount = getDismissedUnreadCount(matchingRows);
    const currentUnreadCount = getCurrentUnreadCount();
    const optimisticUnreadCount = Math.max(
        0,
        currentUnreadCount - dismissedUnreadCount,
    );

    matchingRows.forEach((candidate) => {
        setDismissDisabled(candidate, true);
    });

    syncUnreadSummaries(menu, optimisticUnreadCount);

    const motionPromise = Promise.all(
        matchingRows.map((candidate) =>
            collapseExitMotion(candidate, {
                hidden: true,
            }),
        ),
    );

    const result = await persistNotificationDismiss(menu, row);

    if (!result.ok) {
        await motionPromise;

        matchingRows.forEach(restoreFailedDismissRow);
        syncUnreadSummaries(menu, currentUnreadCount);
        syncMenuPanelStates(menu);
        return;
    }

    if (result.unreadCount !== null) {
        syncUnreadSummaries(menu, result.unreadCount);
    }

    await motionPromise;

    matchingRows.forEach(markDismissedRow);
    syncMenuPanelStates(menu);
}

/* --------------------------------------------------------------------------
   Panel state sync
   -------------------------------------------------------------------------- */

function hasVisibleRows(root) {
    return Array.from(root.querySelectorAll(ROW_SELECTOR)).some(
        isVisibleNotificationRow,
    );
}

function syncPanelState(panel) {
    if (!(panel instanceof HTMLElement)) {
        return;
    }

    panel
        .querySelectorAll(".ui-shell-notifications-menu__section")
        .forEach((section) => {
            if (!(section instanceof HTMLElement)) {
                return;
            }

            const visibleRowCount = Array.from(
                section.querySelectorAll(ROW_SELECTOR),
            ).filter(isVisibleNotificationRow).length;

            section.hidden = visibleRowCount < 1;

            section
                .querySelectorAll("[data-ui-contained-list-item-count]")
                .forEach((list) => {
                    if (list instanceof HTMLElement) {
                        list.dataset.uiContainedListItemCount = `${visibleRowCount}`;
                    }
                });
        });

    let emptyState = panel.querySelector(
        "[data-notification-preview-empty-state]",
    );

    if (hasVisibleRows(panel)) {
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
}

function syncMenuPanelStates(menu) {
    menu.querySelectorAll(PANEL_SELECTOR).forEach(syncPanelState);
}

/* --------------------------------------------------------------------------
   Realtime row normalization
   --------------------------------------------------------------------------
   Realtime-created notification rows must match the Blade-rendered contained
   list item surface. Page refresh fixes the layout because Blade emits these
   classes; this normalizer makes live-inserted rows match immediately.
   -------------------------------------------------------------------------- */

function getNotificationRowKind(row) {
    const explicitKind = row.dataset.uiContainedListItemStatus;

    if (explicitKind) {
        return explicitKind;
    }

    const statusMarker = row.querySelector(
        "[data-notification-preview-severity]",
    );

    if (statusMarker instanceof HTMLElement) {
        const markerKind = statusMarker.dataset.notificationPreviewSeverity;

        if (markerKind) {
            return markerKind;
        }
    }

    for (const className of row.classList) {
        if (!className.startsWith("ui-shell-notification-row--")) {
            continue;
        }

        const classKind = className.replace("ui-shell-notification-row--", "");

        if (classKind && classKind !== "unread") {
            return classKind;
        }
    }

    return "info";
}

function applyContainedListStatusClass(row, kind) {
    row.classList.remove(
        "ui-contained-list-status-info",
        "ui-contained-list-status-success",
        "ui-contained-list-status-warning",
        "ui-contained-list-status-error",
    );

    if (["info", "info-square", "notice"].includes(kind)) {
        row.classList.add("ui-contained-list-status-info");
        return;
    }

    if (kind === "success") {
        row.classList.add("ui-contained-list-status-success");
        return;
    }

    if (["warning", "warning-alt"].includes(kind)) {
        row.classList.add("ui-contained-list-status-warning");
        return;
    }

    if (["error", "danger", "urgent"].includes(kind)) {
        row.classList.add("ui-contained-list-status-error");
    }
}

function syncDismissUrlFromTemplate(row) {
    const menu = row.closest(MENU_SELECTOR);

    if (!(menu instanceof HTMLElement)) {
        return;
    }

    const dismissButton = row.querySelector(DISMISS_SELECTOR);

    if (!(dismissButton instanceof HTMLElement)) {
        return;
    }

    if (dismissButton.dataset.appNotificationDismissUrl) {
        return;
    }

    const templateUrl = buildDismissUrlFromTemplate(menu, row);

    if (templateUrl) {
        dismissButton.dataset.appNotificationDismissUrl = templateUrl;
    }
}

function normalizeNotificationRow(row) {
    if (!(row instanceof HTMLElement)) {
        return;
    }

    if (!row.hasAttribute(ROW_NORMALIZED_ATTR)) {
        row.setAttribute(ROW_NORMALIZED_ATTR, "true");
    }

    const kind = getNotificationRowKind(row);

    row.classList.add(
        "ui-contained-list-item",
        "ui-contained-list-item-with-actions",
    );

    if (kind) {
        row.classList.add(`ui-shell-notification-row--${kind}`);
    }

    row.dataset.uiComponent = "contained-list-item";
    row.dataset.uiContainedListItem = "";
    row.dataset.uiContainedListItemInteractive =
        row.dataset.uiContainedListItemInteractive || "true";
    row.dataset.uiContainedListItemStatus = kind;
    row.dataset.uiContainedListItemActions =
        row.dataset.uiContainedListItemActions || "true";
    row.dataset.uiSelected = row.dataset.uiSelected || "false";
    row.dataset.uiCurrent = row.dataset.uiCurrent || "false";
    row.dataset.uiDisabled = row.dataset.uiDisabled || "false";
    row.dataset.uiMotion = row.dataset.uiMotion || "row-dismiss";

    applyContainedListStatusClass(row, kind);
    syncDismissUrlFromTemplate(row);

    row.querySelectorAll(".ui-shell-notification-row__main").forEach((node) => {
        node.classList.add("ui-contained-list-item-content");
    });

    row.querySelectorAll(".ui-shell-notification-row__status").forEach(
        (node) => {
            node.classList.add("ui-contained-list-item-icon");
        },
    );

    row.querySelectorAll(".ui-shell-notification-row__content").forEach(
        (node) => {
            node.classList.add("ui-contained-list-item-text");
        },
    );

    row.querySelectorAll(".ui-shell-notification-row__meta").forEach((node) => {
        node.classList.add("ui-contained-list-item-meta");
    });

    row.querySelectorAll(".ui-shell-notification-row__title").forEach(
        (node) => {
            node.classList.add("ui-contained-list-item-title");
        },
    );

    row.querySelectorAll(".ui-shell-notification-row__subtitle").forEach(
        (node) => {
            node.classList.add("ui-contained-list-item-description");
        },
    );

    row.querySelectorAll(".ui-shell-notification-row__actions").forEach(
        (node) => {
            node.classList.add("ui-contained-list-item-actions");
        },
    );
}

function normalizeNotificationRows(menu) {
    menu.querySelectorAll(ROW_SELECTOR).forEach(normalizeNotificationRow);
}

function bindNotificationRowObserver(menu) {
    normalizeNotificationRows(menu);
    syncMenuPanelStates(menu);

    const observerTarget = menu.querySelector(BODY_SELECTOR) || menu;

    if (!(observerTarget instanceof HTMLElement)) {
        return;
    }

    if (observerTarget.hasAttribute(ROW_OBSERVER_BOUND_ATTR)) {
        return;
    }

    observerTarget.setAttribute(ROW_OBSERVER_BOUND_ATTR, "true");

    const observer = new MutationObserver(() => {
        window.requestAnimationFrame(() => {
            normalizeNotificationRows(menu);
            syncMenuPanelStates(menu);
        });
    });

    observer.observe(observerTarget, {
        childList: true,
        subtree: true,
    });
}

/* --------------------------------------------------------------------------
   Instance binding
   -------------------------------------------------------------------------- */

function bindNotificationsMenu(menu) {
    if (!(menu instanceof HTMLElement)) {
        return;
    }

    if (menu.hasAttribute(BOUND_ATTR)) {
        return;
    }

    menu.setAttribute(BOUND_ATTR, "true");

    bindNotificationRowObserver(menu);

    menu.querySelectorAll(FILTER_SELECTOR).forEach((button) => {
        button.addEventListener("click", () => {
            setActiveFilter(
                menu,
                button.dataset.appNotificationsFilter || "unread",
            );
        });
    });

    menu.addEventListener("click", (event) => {
        const target = event.target;

        if (!(target instanceof Element)) {
            return;
        }

        const dismissButton = target.closest(DISMISS_SELECTOR);

        if (!dismissButton || !menu.contains(dismissButton)) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();

        const row = dismissButton.closest(ROW_SELECTOR);

        if (row instanceof HTMLElement) {
            void hideMatchingNotificationRows(menu, row);
        }
    });

    setActiveFilter(
        menu,
        menu.dataset.appNotificationsActiveFilter || "unread",
    );
}

/* --------------------------------------------------------------------------
   Initializer
   -------------------------------------------------------------------------- */

export function initAppHeaderNotifications(root = document) {
    bindDismissNavigationFlush();
    root.querySelectorAll(MENU_SELECTOR).forEach(bindNotificationsMenu);
}
