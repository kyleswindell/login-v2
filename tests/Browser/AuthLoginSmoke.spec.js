import { expect, test } from '@playwright/test';
import { waitForApp } from './support/waitForApp.js';

test.describe('login page', () => {
    test('renders the public identifier step', async ({ page, request }) => {
        await waitForApp(request);
        await page.goto('/login');

        await expect(page.locator('[data-auth-shell]')).toBeVisible();
        await expect(page.getByRole('heading', { name: 'Log in' })).toBeVisible();
        await expect(page.getByLabel('Email or username')).toBeVisible();
        await expect(page.getByRole('button', { name: 'Continue' })).toBeVisible();
    });
});
