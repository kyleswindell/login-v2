import { expect, test } from "@playwright/test";
import { waitForApp } from "./support/waitForApp.js";

const email = process.env.PLAYWRIGHT_TEST_EMAIL ?? "test@example.com";
const password = process.env.PLAYWRIGHT_TEST_PASSWORD ?? "password";

async function login(page, request, { waitForRealtime = false } = {}) {
    const scriptFailures = [];

    page.on("requestfailed", (failedRequest) => {
        if (failedRequest.resourceType() === "script") {
            scriptFailures.push(
                `${failedRequest.url()}: ${failedRequest.failure()?.errorText || "request failed"}`,
            );
        }
    });

    await waitForApp(request);
    await page.goto("/login");
    await page.getByLabel("Email or username").fill(email);
    await page.getByRole("button", { name: "Continue" }).click();
    await page.locator("#password").fill(password);

    const realtimeSubscription = waitForRealtime
        ? waitForNotificationSubscription(page)
        : null;

    await page.getByRole("button", { name: "Log in" }).click();
    await page.waitForURL("**/dashboard");
    await page.waitForLoadState("domcontentloaded");

    expect(
        scriptFailures,
        `Browser JavaScript failed to load:\n${scriptFailures.join("\n")}`,
    ).toEqual([]);

    await waitForNotificationRuntimes(page);

    if (realtimeSubscription) {
        await realtimeSubscription;
        await page
            .locator('[data-notification-realtime-state="subscribed"]')
            .waitFor({ state: "attached" });
    }
}

function waitForNotificationSubscription(page) {
    return new Promise((resolve) => {
        page.on("websocket", (websocket) => {
            websocket.on("framereceived", ({ payload }) => {
                try {
                    const message = JSON.parse(payload);

                    if (
                        message.event ===
                            "pusher_internal:subscription_succeeded" &&
                        String(message.channel || "").startsWith(
                            "private-App.Models.User.",
                        )
                    ) {
                        resolve();
                    }
                } catch (error) {
                    // Ignore protocol frames that are not JSON messages.
                }
            });
        });
    });
}

async function waitForNotificationRuntimes(page) {
    await page
        .locator('[data-transient-notifications-init="1"]')
        .waitFor({ state: "attached" });
    await page
        .locator('[data-dashboard-test-notification-bound="true"]')
        .waitFor({ state: "attached" });
}

async function unreadCount(page) {
    const text = await page
        .locator("[data-notification-trigger-summary]")
        .textContent();

    return Number.parseInt(text?.trim() || "0", 10);
}

test.describe("notification transport", () => {
    test("deduplicates explicit transient toast IDs", async ({
        page,
        request,
    }) => {
        await login(page, request);

        const unreadBefore = await unreadCount(page);

        await page.evaluate(() => {
            const payload = {
                id: "browser-transient-dedupe",
                kind: "success",
                title: "Saved",
                subtitle: "The command completed.",
                timeout: 0,
            };

            window.dispatchEvent(
                new CustomEvent("notifications:toast", { detail: payload }),
            );
            window.dispatchEvent(
                new CustomEvent("notifications:toast", { detail: payload }),
            );
        });

        const transientToast = page.locator(
            '[data-notification-toast-id="browser-transient-dedupe"]',
        );

        await expect(transientToast).toHaveCount(1);
        await expect(transientToast).toBeVisible();
        await expect(transientToast).toBeInViewport();
        await expect(transientToast).toContainText("The command completed.");
        expect(await unreadCount(page)).toBe(unreadBefore);
    });

    test("presents one persistent toast per tab after repeated lifecycle initialization", async ({
        context,
        page,
        request,
    }) => {
        await login(page, request, { waitForRealtime: true });

        const secondPage = await context.newPage();
        const secondPageRealtimeSubscription =
            waitForNotificationSubscription(secondPage);
        await secondPage.goto("/dashboard");
        await waitForNotificationRuntimes(secondPage);
        await secondPageRealtimeSubscription;
        await secondPage
            .locator('[data-notification-realtime-state="subscribed"]')
            .waitFor({ state: "attached" });

        const firstTabUnreadBefore = await unreadCount(page);
        const secondTabUnreadBefore = await unreadCount(secondPage);

        await page.evaluate(() => {
            document.dispatchEvent(new CustomEvent("livewire:navigated"));
            document.dispatchEvent(new CustomEvent("livewire:navigated"));
        });

        const responsePromise = page.waitForResponse(
            (response) =>
                response.url().endsWith("/dashboard/test-notification") &&
                response.request().method() === "POST",
        );

        await page
            .getByRole("button", { name: "Generate test notification" })
            .click();

        const response = await responsePromise;
        const payload = await response.json();

        expect(response.status()).toBe(201);
        expect(Object.keys(payload).sort()).toEqual([
            "created",
            "notification_id",
        ]);
        expect(payload.created).toBe(true);

        const toastSelector = `[data-notification-toast-id="${payload.notification_id}"]`;

        const firstTabToast = page.locator(toastSelector);
        const secondTabToast = secondPage.locator(toastSelector);

        await expect(firstTabToast).toHaveCount(1);
        await expect(firstTabToast).toBeVisible();
        await expect(firstTabToast).toBeInViewport();
        await expect(firstTabToast).toContainText("Test notification");
        await expect(secondTabToast).toHaveCount(1);
        await expect(secondTabToast).toBeVisible();
        await expect(secondTabToast).toBeInViewport();
        await expect(secondTabToast).toContainText("Test notification");
        await expect
            .poll(() => unreadCount(page))
            .toBe(firstTabUnreadBefore + 1);
        await expect
            .poll(() => unreadCount(secondPage))
            .toBe(secondTabUnreadBefore + 1);

        await page.locator("[data-notification-trigger]").click();
        await secondPage.locator("[data-notification-trigger]").click();

        const previewSelector = `[data-notification-preview-item][data-notification-id="${payload.notification_id}"]`;
        const firstTabPreview = page
            .locator(previewSelector)
            .filter({ visible: true });
        const secondTabPreview = secondPage
            .locator(previewSelector)
            .filter({ visible: true });

        await expect(firstTabPreview).toHaveCount(1);
        await expect(firstTabPreview).toBeVisible();
        await expect(firstTabPreview).toContainText("Test notification");
        await expect(secondTabPreview).toHaveCount(1);
        await expect(secondTabPreview).toBeVisible();
        await expect(secondTabPreview).toContainText("Test notification");

        await page.waitForTimeout(250);

        await expect(firstTabToast).toHaveCount(1);
        await expect(secondTabToast).toHaveCount(1);
    });
});
