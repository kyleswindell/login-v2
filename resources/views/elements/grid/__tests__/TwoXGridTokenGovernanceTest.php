<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| File: tests/Ui/Elements/Grid2x/TwoXGridTokenGovernanceTest.php
| Purpose: Verify 2x Grid token ownership and consumer governance.
|--------------------------------------------------------------------------
|
| These tests protect the approved 2x Grid foundation element from local
| breakpoint, container, column, and gutter replacement scales.
|
*/

namespace Tests\Ui\Elements\Grid2x;

use Tests\TestCase;
use Tests\Ui\Elements\Support\CssTokenAudit;

final class TwoXGridTokenGovernanceTest extends TestCase
{
    /**
     * ---------------------------------------------------------------------
     * Standard / contract alignment
     * ---------------------------------------------------------------------
     */

    public function test_2x_grid_standard_and_runtime_contract_stay_aligned(): void
    {
        CssTokenAudit::assertStandardAndContractAreAligned(
            '2x-grid',
            'docs/02-standards/ui/elements/2x-grid.md',
        );
    }

    public function test_2x_grid_contract_exposes_expected_identity_and_dependencies(): void
    {
        $contract = CssTokenAudit::contract('2x-grid');

        $this->assertSame('2x-grid', data_get($contract, 'identity.slug'));
        $this->assertSame('2x Grid', data_get($contract, 'identity.label'));
        $this->assertSame('approved', data_get($contract, 'lifecycle.status'));

        $this->assertContains('layout', data_get($contract, 'dependencies.blocks', []));
        $this->assertContains('data-and-content', data_get($contract, 'dependencies.blocks', []));
    }

    /**
     * ---------------------------------------------------------------------
     * Token source ownership
     * ---------------------------------------------------------------------
     */

    public function test_layout_tokens_define_approved_grid_roles(): void
    {
        CssTokenAudit::assertDefinesTokens('resources/css/tokens/layout.css', [
            '--ui-breakpoint-sm',
            '--ui-breakpoint-md',
            '--ui-breakpoint-lg',
            '--ui-breakpoint-xlg',
            '--ui-breakpoint-max',
            '--ui-grid-columns-sm',
            '--ui-grid-columns-md',
            '--ui-grid-columns-lg',
            '--ui-grid-columns-xlg',
            '--ui-grid-columns-max',
            '--ui-grid-margin-sm',
            '--ui-grid-margin-md',
            '--ui-grid-margin-lg',
            '--ui-grid-margin-xlg',
            '--ui-grid-margin-max',
            '--ui-container-01',
            '--ui-container-02',
            '--ui-container-03',
            '--ui-container-04',
            '--ui-container-05',
        ]);
    }

    public function test_grid_css_consumes_approved_grid_roles(): void
    {
        CssTokenAudit::assertUsesTokens('resources/css/base/grid.css', [
            '--ui-grid-columns-sm',
            '--ui-grid-columns-md',
            '--ui-grid-columns-lg',
            '--ui-grid-columns-xlg',
            '--ui-grid-columns-max',
            '--ui-grid-margin-sm',
            '--ui-grid-margin-md',
            '--ui-grid-margin-lg',
            '--ui-grid-margin-xlg',
            '--ui-grid-margin-max',
            '--ui-grid-gutter',
        ]);
    }

    public function test_grid_css_owns_installed_literal_media_queries_from_layout_tokens(): void
    {
        $layout = CssTokenAudit::read('resources/css/tokens/layout.css');
        $grid = CssTokenAudit::read('resources/css/base/grid.css');

        foreach (['md', 'lg', 'xlg', 'max'] as $breakpoint) {
            $token = "--ui-breakpoint-{$breakpoint}";
            $value = $this->extractCssCustomPropertyValue($layout, $token);

            $this->assertNotNull(
                $value,
                "Layout tokens must define {$token} before grid media queries are asserted.",
            );

            $this->assertStringContainsString(
                "@media (min-width: {$value})",
                $grid,
                "Grid source must own the installed literal media query for {$token} ({$value}).",
            );
        }
    }

    /**
     * ---------------------------------------------------------------------
     * Consumer governance
     * ---------------------------------------------------------------------
     */

    public function test_consumers_do_not_create_local_grid_replacement_custom_properties(): void
    {
        $declarations = CssTokenAudit::declarations([
            'resources/css/components',
            'resources/css/patterns',
        ]);

        $localScales = array_values(array_filter(
            $declarations,
            static function (array $declaration): bool {
                if (! str_starts_with($declaration['property'], '--')) {
                    return false;
                }

                return preg_match(
                    '/^--(?:breakpoint|container|grid-(?:column|columns|column-count|gutter|margin)|ui-(?:breakpoint|container(?:-\d+)?|grid-(?:column|columns|column-count|gutter|margin)))(?:-|$)/i',
                    $declaration['property'],
                ) === 1;
            },
        ));

        $this->assertSame(
            [],
            CssTokenAudit::formatDeclarations($localScales),
            'Consumers must not create local breakpoint, container, column, or gutter replacement scales.',
        );
    }

    public function test_component_and_pattern_media_query_usage_is_report_only_baselined(): void
    {
        CssTokenAudit::assertNoNewReportOnlyItems(
            'resources/views/elements/2x-grid/__tests__/baselines/component-media-query-usage.php',
            CssTokenAudit::mediaQueryFindings([
                'resources/css/components',
                'resources/css/patterns',
            ]),
            'Component and Pattern media query scan',
        );
    }

    /**
     * ---------------------------------------------------------------------
     * Helpers
     * ---------------------------------------------------------------------
     */

    private function extractCssCustomPropertyValue(string $css, string $token): ?string
    {
        preg_match(
            '/' . preg_quote($token, '/') . '\s*:\s*(?<value>[^;]+);/',
            $css,
            $matches,
        );

        $value = $matches['value'] ?? null;

        if (! is_string($value)) {
            return null;
        }

        return trim($value);
    }
}
