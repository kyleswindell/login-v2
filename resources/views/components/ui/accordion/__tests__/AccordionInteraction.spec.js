import { expect, test } from '@playwright/test';
import { readFile } from 'node:fs/promises';

const fixtureHtml = await readFile(new URL('./fixtures/accordion.html', import.meta.url), 'utf8');
const accordionModuleSource = await readFile(
    new URL('../../../../../js/ui-controls/accordions.js', import.meta.url),
    'utf8'
);

test.describe('accordion interactions', () => {
    test.beforeEach(async ({ page }) => {
        await page.setContent(fixtureHtml);
        await page.evaluate(async (source) => {
            const moduleUrl = URL.createObjectURL(new Blob([source], { type: 'text/javascript' }));
            const module = await import(moduleUrl);

            module.initAccordions(document);
            URL.revokeObjectURL(moduleUrl);
        }, accordionModuleSource);
    });

    test('click toggles hidden state and aria state', async ({ page }) => {
        const trigger = page.locator('#multiple-a-trigger');
        const panel = page.locator('#multiple-a-panel');

        await expect(trigger).toHaveAttribute('aria-expanded', 'false');
        await expect(panel).toBeHidden();

        await trigger.click();

        await expect(trigger).toHaveAttribute('aria-expanded', 'true');
        await expect(panel).toBeVisible();
        await expect(panel).toHaveAttribute('data-ui-accordion-panel-open', 'true');
        await expect(trigger).toHaveAttribute('data-ui-accordion-focus', 'true');

        await trigger.click();

        await expect(trigger).toHaveAttribute('aria-expanded', 'false');
        await expect(panel).toBeHidden();
        await expect(panel).toHaveAttribute('data-ui-accordion-panel-open', 'false');
    });

    test('enter and space activate the focused trigger through native button behavior', async ({ page }) => {
        const trigger = page.locator('#multiple-a-trigger');
        const panel = page.locator('#multiple-a-panel');

        await trigger.focus();
        await page.keyboard.press('Enter');

        await expect(trigger).toHaveAttribute('aria-expanded', 'true');
        await expect(panel).toBeVisible();

        await page.keyboard.press('Space');

        await expect(trigger).toHaveAttribute('aria-expanded', 'false');
        await expect(panel).toBeHidden();
    });

    test('single mode closes sibling panels when a new item opens', async ({ page }) => {
        const firstTrigger = page.locator('#single-a-trigger');
        const firstPanel = page.locator('#single-a-panel');
        const secondTrigger = page.locator('#single-b-trigger');
        const secondPanel = page.locator('#single-b-panel');

        await expect(firstTrigger).toHaveAttribute('aria-expanded', 'true');
        await expect(firstPanel).toBeVisible();

        await secondTrigger.click();

        await expect(secondTrigger).toHaveAttribute('aria-expanded', 'true');
        await expect(secondPanel).toBeVisible();
        await expect(firstTrigger).toHaveAttribute('aria-expanded', 'false');
        await expect(firstPanel).toBeHidden();
    });

    test('disabled triggers do not toggle panels', async ({ page }) => {
        const trigger = page.locator('#multiple-disabled-trigger');
        const panel = page.locator('#multiple-disabled-panel');

        await expect(trigger).toBeDisabled();
        await expect(trigger).toHaveAttribute('aria-expanded', 'false');
        await expect(panel).toBeHidden();

        await trigger.dispatchEvent('click');

        await expect(trigger).toHaveAttribute('aria-expanded', 'false');
        await expect(panel).toBeHidden();
    });
});
