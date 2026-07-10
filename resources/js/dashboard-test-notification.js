/**
 * File: resources/js/dashboard-test-notification.js
 * Purpose: Creates a persistent test notification without duplicating its realtime presentation.
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
            const originalLabel = submit?.textContent;

            if (submit instanceof HTMLButtonElement) {
                submit.disabled = true;
                submit.textContent = "Generating...";
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
                }
            } catch (error) {
                dispatchTransientToast(
                    "warning",
                    "Notification request could not be confirmed",
                    "Check the notification inbox before retrying.",
                );
            } finally {
                if (submit instanceof HTMLButtonElement) {
                    submit.disabled = false;
                    submit.textContent = originalLabel;
                }
            }
        });
    });
}
