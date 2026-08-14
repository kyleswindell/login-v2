/**
 * File: resources/js/dashboard-test-notification.js
 * Purpose: Creates a persistent test notification and confirms it immediately with a transient toast.
 */

const FORM_SELECTOR = "[data-dashboard-test-notification-form]";
const SUBMIT_SELECTOR = "[data-dashboard-test-notification-submit]";
const BOUND_ATTR = "data-dashboard-test-notification-bound";

const dispatchTransientToast = (kind, title, subtitle) => {
    window.dispatchEvent(
        new CustomEvent("notifications:toast", {
            detail: {
                kind,
                title,
                subtitle,
            },
        }),
    );
};

export function initDashboardTestNotification(root = document) {
    root.querySelectorAll(FORM_SELECTOR).forEach((form) => {
        if (!(form instanceof HTMLFormElement)) {
            return;
        }

        if (form.hasAttribute(BOUND_ATTR)) {
            return;
        }

        form.setAttribute(BOUND_ATTR, "true");

        form.addEventListener("submit", async (event) => {
            event.preventDefault();

            const submit = form.querySelector(SUBMIT_SELECTOR);
            const submitIsTile =
                submit instanceof HTMLButtonElement &&
                submit.matches("[data-ui-tile]");
            const originalLabel = submit?.textContent;
            const originalBusy = submit?.getAttribute("aria-busy") ?? null;
            const originalLoading =
                submit?.getAttribute("data-ui-loading") ?? null;

            if (submit instanceof HTMLButtonElement) {
                submit.disabled = true;

                if (submitIsTile) {
                    submit.setAttribute("aria-busy", "true");
                    submit.setAttribute("data-ui-loading", "true");
                } else {
                    submit.textContent = "Generating...";
                }
            }

            try {
                const response = await window.fetch(form.action, {
                    method: "POST",
                    headers: {
                        Accept: "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                    },
                    body: new FormData(form),
                    credentials: "same-origin",
                });

                if (!response.ok) {
                    dispatchTransientToast(
                        "error",
                        "Test notification could not be created",
                        "The server rejected the request. Review your access and try again.",
                    );

                    return;
                }

                let payload;

                try {
                    payload = await response.json();
                } catch (error) {
                    dispatchTransientToast(
                        "warning",
                        "Notification request could not be confirmed",
                        "Check the notification inbox before retrying.",
                    );

                    return;
                }

                if (payload?.created !== true) {
                    dispatchTransientToast(
                        "warning",
                        "Notification request could not be confirmed",
                        "Check the notification inbox before retrying.",
                    );

                    return;
                }

                window.dispatchEvent(
                    new CustomEvent("notifications:toast", {
                        detail: {
                            id: payload.notification_id,
                            kind: "success",
                            title: "Test notification created",
                            subtitle:
                                "The notification is available in your notification center.",
                        },
                    }),
                );
            } catch (error) {
                dispatchTransientToast(
                    "warning",
                    "Notification request could not be confirmed",
                    "Check the notification inbox before retrying.",
                );
            } finally {
                if (submit instanceof HTMLButtonElement) {
                    submit.disabled = false;

                    if (submitIsTile) {
                        if (originalBusy === null) {
                            submit.removeAttribute("aria-busy");
                        } else {
                            submit.setAttribute("aria-busy", originalBusy);
                        }

                        if (originalLoading === null) {
                            submit.removeAttribute("data-ui-loading");
                        } else {
                            submit.setAttribute(
                                "data-ui-loading",
                                originalLoading,
                            );
                        }
                    } else {
                        submit.textContent = originalLabel;
                    }
                }
            }
        });
    });
}
