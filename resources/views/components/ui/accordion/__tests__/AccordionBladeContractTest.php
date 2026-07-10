<?php

namespace Tests\Ui\Components\Accordion;

use Illuminate\Support\HtmlString;
use Tests\TestCase;

class AccordionBladeContractTest extends TestCase
{
    public function test_it_renders_the_installed_root_and_item_contract(): void
    {
        $html = $this->renderAccordion();

        $this->assertStringContainsString('class="ui-accordion', $html);
        $this->assertStringContainsString('data-ui-component="accordion"', $html);
        $this->assertStringContainsString('data-ui-accordion="account-settings"', $html);
        $this->assertStringContainsString('data-ui-accordion-mode="multiple"', $html);
        $this->assertStringContainsString('data-ui-accordion-alignment="default"', $html);
        $this->assertStringContainsString('data-ui-accordion-icon-alignment="end"', $html);
        $this->assertSame(3, $this->countAttribute($html, 'data-ui-accordion-item'));
        $this->assertSame(3, $this->countAttribute($html, 'data-ui-accordion-trigger'));
        $this->assertSame(3, $this->countAttribute($html, 'data-ui-accordion-panel'));
    }

    public function test_it_pairs_trigger_and_panel_accessibility_attributes(): void
    {
        $html = $this->renderAccordion();

        $this->assertStringContainsString('id="summary-trigger"', $html);
        $this->assertStringContainsString('aria-controls="summary-panel"', $html);
        $this->assertStringContainsString('id="summary-panel"', $html);
        $this->assertStringContainsString('role="region"', $html);
        $this->assertStringContainsString('aria-labelledby="summary-trigger"', $html);
    }

    public function test_it_renders_open_closed_and_disabled_item_state(): void
    {
        $html = $this->renderAccordion();

        $this->assertStringContainsString('aria-expanded="true"', $html);
        $this->assertStringContainsString('data-ui-accordion-panel-open="true"', $html);
        $this->assertStringContainsString('aria-expanded="false"', $html);
        $this->assertStringContainsString('data-ui-accordion-panel-open="false"', $html);
        $this->assertMatchesRegularExpression('/id="history-panel"[^>]*hidden/s', $html);
        $this->assertMatchesRegularExpression('/id="disabled-trigger"[^>]*disabled/s', $html);
    }

    public function test_it_resolves_supported_variants_and_scrollable_panel_style(): void
    {
        $html = $this->renderAccordion(
            '<x-ui.accordion id="variant-accordion" :items="$items" variant="contained" alignment="flush" icon-alignment="start" size="compact" mode="single" scrollable panel-max-height="8rem" />'
        );

        $this->assertStringContainsString('ui-accordion-contained', $html);
        $this->assertStringContainsString('ui-accordion-flush', $html);
        $this->assertStringContainsString('ui-accordion-icon-start', $html);
        $this->assertStringContainsString('ui-accordion-compact', $html);
        $this->assertStringContainsString('ui-accordion-scrollable', $html);
        $this->assertStringContainsString('data-ui-accordion-mode="single"', $html);
        $this->assertStringContainsString('data-ui-accordion-alignment="flush"', $html);
        $this->assertStringContainsString('data-ui-accordion-icon-alignment="start"', $html);
        $this->assertStringContainsString('style="--ui-accordion-panel-max-height: 8rem;"', $html);
    }

    public function test_it_renders_trusted_html_body_content(): void
    {
        $html = $this->renderAccordion(
            '<x-ui.accordion id="html-body-accordion" :items="$items" />',
            [
                [
                    'id' => 'html-body',
                    'title' => 'Rendered HTML',
                    'body' => new HtmlString('<ul><li>Trusted HTML body</li></ul>'),
                    'open' => true,
                ],
            ]
        );

        $this->assertStringContainsString('<ul><li>Trusted HTML body</li></ul>', $html);
        $this->assertStringNotContainsString('&lt;ul&gt;', $html);
    }

    /**
     * @param list<array<string, mixed>>|null $items
     */
    private function renderAccordion(
        string $template = '<x-ui.accordion id="account-settings" :items="$items" />',
        ?array $items = null
    ): string {
        return (string) $this->blade($template, [
            'items' => $items ?? $this->accordionItems(),
        ]);
    }

    private function countAttribute(string $html, string $attribute): int
    {
        preg_match_all('/\s'.preg_quote($attribute, '/').'(?=[\s=>])/', $html, $matches);

        return count($matches[0]);
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function accordionItems(): array
    {
        return [
            [
                'id' => 'summary',
                'trigger_id' => 'summary-trigger',
                'panel_id' => 'summary-panel',
                'title' => 'Summary',
                'meta' => 'Open',
                'body' => 'Summary body',
                'open' => true,
            ],
            [
                'id' => 'history',
                'trigger_id' => 'history-trigger',
                'panel_id' => 'history-panel',
                'title' => 'History',
                'body' => 'History body',
                'open' => false,
            ],
            [
                'id' => 'disabled',
                'trigger_id' => 'disabled-trigger',
                'panel_id' => 'disabled-panel',
                'title' => 'Disabled',
                'body' => 'Disabled body',
                'disabled' => true,
            ],
        ];
    }
}
