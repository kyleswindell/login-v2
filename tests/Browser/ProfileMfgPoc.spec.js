import { expect, test } from "@playwright/test";
import { waitForApp } from "./support/waitForApp.js";

const pocEnabled = process.env.PROFILE_MFG_POC_ENABLED === "true";
const email = process.env.PLAYWRIGHT_TEST_EMAIL ?? "test@example.com";
const password = process.env.PLAYWRIGHT_TEST_PASSWORD ?? "password";

async function signIn(page, request) {
    await waitForApp(request);
    await page.goto("/login");
    await page.getByLabel("Email or username").fill(email);
    await page.getByRole("button", { name: "Continue" }).click();
    await page.locator("#password").fill(password);
    await page.getByRole("button", { name: "Log in" }).click();
    await expect(page).toHaveURL(/\/profile-mfg$/);
}

test.describe("Profile Mfg static POC", () => {
    test.skip(
        !pocEnabled,
        "PROFILE_MFG_POC_ENABLED must be true for the POC walkthrough.",
    );

    test("supports the authenticated operations drill-down", async ({
        page,
        request,
    }) => {
        await signIn(page, request);

        await expect(
            page.getByRole("heading", { name: "Shipping schedule", exact: true }),
        ).toBeVisible();
        await expect(page.getByText("Static proof of concept")).toBeVisible();
        await expect(
            page.getByRole("link", { name: "Customers" }),
        ).toBeVisible();
        await expect(page.getByRole("link", { name: "Orders" })).toBeVisible();
        await expect(
            page.getByRole("table", { name: "Two-week shipping schedule" }),
        ).toBeVisible();

        await page.getByRole("link", { name: "Inventory", exact: true }).click();
        await expect(
            page.getByRole("heading", {
                name: "Finished-goods inventory",
                exact: true,
            }),
        ).toBeVisible();
        await expect(
            page.locator('[data-ui-shell-side-nav-link-active="true"]'),
        ).toContainText("Inventory");
        await expect(
            page.getByRole("table", { name: "Finished-goods inventory by part" }),
        ).toBeVisible();

        await page
            .getByRole("link", { name: "Scan activity", exact: true })
            .click();
        await expect(
            page.getByRole("heading", { name: "Scan activity", exact: true }),
        ).toBeVisible();
        await expect(
            page.getByRole("table", { name: "Serialized box activity" }),
        ).toBeVisible();
        await expect(
            page.locator('[data-ui-shell-side-nav-link-active="true"]'),
        ).toContainText("Scan activity");

        await page.getByRole("link", { name: "Reports", exact: true }).click();
        await expect(
            page.getByRole("heading", { name: "Reports", exact: true }),
        ).toBeVisible();
        await expect(
            page.getByRole("link", {
                name: /Daily and weekly shipping schedule/,
            }),
        ).toBeVisible();
        await expect(
            page.getByRole("link", { name: /Inventory scanned/ }),
        ).toBeVisible();

        await page.getByRole("link", { name: "Customers" }).click();
        await expect(
            page.locator('[data-ui-shell-side-nav-link-active="true"]'),
        ).toContainText("Customers");
        await page.getByRole("link", { name: "Northstar Automotive" }).click();
        await expect(
            page.getByRole("heading", {
                name: "Northstar Automotive",
                exact: true,
            }),
        ).toBeVisible();

        await page
            .getByRole("table", { name: "Associated parts" })
            .getByRole("link", { name: "PMI-01001" })
            .click();
        await expect(
            page.getByRole("heading", { name: "PMI-01001", exact: true }),
        ).toBeVisible();
        await expect(
            page
                .getByRole("paragraph")
                .filter({ hasText: "Front reinforcement profile" })
                .first(),
        ).toBeVisible();
        await expect(
            page.getByRole("heading", { name: "Part image", exact: true }),
        ).toBeVisible();
        await expect(
            page.locator('[data-ui-shell-side-nav-link-active="true"]'),
        ).toContainText("Parts");

        await page
            .getByRole("table", { name: "Open orders for this part" })
            .getByRole("link", { name: "ORD-1001" })
            .click();
        await expect(
            page.getByRole("heading", { name: "ORD-1001", exact: true }),
        ).toBeVisible();
        await expect(
            page.getByLabel("Order fulfillment summary"),
        ).toBeVisible();
        await expect(
            page.locator('[data-ui-shell-side-nav-link-active="true"]'),
        ).toContainText("Orders");

        await page.getByRole("link", { name: "Orders", exact: true }).click();
        await expect(
            page.getByRole("heading", { name: "Orders", exact: true }),
        ).toBeVisible();

        const futurePreview = page.getByRole("button", {
            name: "Scan in / ship out — Future preview",
        });
        await expect(futurePreview).toBeVisible();
        await expect(futurePreview).toBeDisabled();

        await page
            .getByRole("button", { name: "Account & admin" })
            .click();
        await expect(
            page.getByRole("link", { name: "My profile", exact: true }),
        ).toBeVisible();
        await expect(
            page.getByRole("link", { name: "Preferences", exact: true }),
        ).toBeVisible();
        await expect(
            page.getByRole("button", {
                name: "Employees and access — Future preview",
            }),
        ).toBeDisabled();

        await page
            .getByRole("link", { name: "My profile", exact: true })
            .click();
        await expect(
            page.getByRole("heading", {
                name: "Profile",
                exact: true,
                level: 1,
            }),
        ).toBeVisible();

        await page.goto("/account/preferences");
        await expect(
            page.getByRole("heading", {
                name: "Preferences",
                exact: true,
                level: 1,
            }),
        ).toBeVisible();

    });

    test("keeps the workspace usable at a mobile viewport", async ({
        page,
        request,
    }) => {
        await page.setViewportSize({ width: 390, height: 844 });
        await signIn(page, request);

        await expect(
            page.getByRole("heading", { name: "Shipping schedule", exact: true }),
        ).toBeVisible();
        await expect(page.getByRole("main")).toBeVisible();

        let hasHorizontalOverflow = await page.evaluate(
            () =>
                document.documentElement.scrollWidth >
                document.documentElement.clientWidth,
        );

        expect(hasHorizontalOverflow).toBe(false);

        const menuButton = page.getByRole("button", { name: "Open menu" });
        await expect(menuButton).toHaveAttribute("data-ui-shell-bound", "true");
        await menuButton.click();
        await expect(
            page.getByRole("navigation", { name: "Profile Mfg navigation" }),
        ).toBeVisible();
        await expect(
            page.getByRole("button", {
                name: "Scan in / ship out — Future preview",
            }),
        ).toBeDisabled();

        hasHorizontalOverflow = await page.evaluate(
            () =>
                document.documentElement.scrollWidth >
                document.documentElement.clientWidth,
        );

        expect(hasHorizontalOverflow).toBe(false);

    });
});
