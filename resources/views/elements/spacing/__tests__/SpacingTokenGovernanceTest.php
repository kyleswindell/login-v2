<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| File: tests/Ui/Elements/Spacing/SpacingTokenGovernanceTest.php
| Purpose: Verify Spacing token ownership and consumer drift governance.
|--------------------------------------------------------------------------
|
| These tests protect the approved Spacing foundation element from arbitrary
| spacing, local replacement scales, load-order drift, and unbaselined Blade
| utility-class usage.
|
*/

namespace Tests\Ui\Elements\Spacing;

use Tests\TestCase;
use Tests\Ui\Elements\Support\CssTokenAudit;

final class SpacingTokenGovernanceTest extends TestCase
{
    /**
     * ---------------------------------------------------------------------
     * Standard / contract alignment
     * ---------------------------------------------------------------------
     */

    public function test_spacing_standard_and_runtime_contract_stay_aligned(): void
    {
        CssTokenAudit::assertStandardAndContractAreAligned(
            'spacing',
            'docs/02-standards/ui/elements/spacing.md',
        );
    }

    public function test_spacing_contract_stays_approved_for_layout_and_component_consumers(): void
    {
        $contract = CssTokenAudit::contract('spacing');

        $this->assertSame('spacing', data_get($contract, 'identity.slug'));
        $this->assertSame('Spacing', data_get($contract, 'identity.label'));
        $this->assertSame('approved', data_get($contract, 'lifecycle.status'));

        $this->assertContains('button', data_get($contract, 'dependencies.blocks', []));
        $this->assertContains('text-input', data_get($contract, 'dependencies.blocks', []));
        $this->assertContains('tile', data_get($contract, 'dependencies.blocks', []));
    }

    /**
     * ---------------------------------------------------------------------
     * Token source ownership
     * ---------------------------------------------------------------------
     */

    public function test_spacing_tokens_export_the_carbon_comparable_scales(): void
    {
        CssTokenAudit::assertDefinesTokens('resources/css/tokens/spacing.css', [
            '--spacing-01',
            '--spacing-02',
            '--spacing-03',
            '--spacing-04',
            '--spacing-05',
            '--spacing-06',
            '--spacing-07',
            '--spacing-08',
            '--spacing-09',
            '--spacing-10',
            '--spacing-11',
            '--spacing-12',
            '--spacing-13',
            '--fluid-spacing-01',
            '--fluid-spacing-02',
            '--fluid-spacing-03',
            '--fluid-spacing-04',
            '--layout-01',
            '--layout-02',
            '--layout-03',
            '--layout-04',
            '--layout-05',
            '--layout-06',
            '--layout-07',
            '--ui-spacing-01',
            '--ui-spacing-02',
            '--ui-spacing-03',
            '--ui-spacing-04',
            '--ui-spacing-05',
            '--ui-spacing-06',
            '--ui-spacing-07',
            '--ui-spacing-08',
            '--ui-spacing-09',
            '--ui-spacing-10',
            '--ui-spacing-11',
            '--ui-spacing-12',
            '--ui-spacing-13',
            '--ui-fluid-spacing-01',
            '--ui-fluid-spacing-02',
            '--ui-fluid-spacing-03',
            '--ui-fluid-spacing-04',
            '--ui-layout-01',
            '--ui-layout-02',
            '--ui-layout-03',
            '--ui-layout-04',
            '--ui-layout-05',
            '--ui-layout-06',
            '--ui-layout-07',
        ]);
    }

    public function test_spacing_ui_aliases_consume_spacing_source_tokens(): void
    {
        CssTokenAudit::assertUsesTokens('resources/css/tokens/spacing.css', [
            '--spacing-01',
            '--spacing-02',
            '--spacing-03',
            '--spacing-04',
            '--spacing-05',
            '--spacing-06',
            '--spacing-07',
            '--spacing-08',
            '--spacing-09',
            '--spacing-10',
            '--spacing-11',
            '--spacing-12',
            '--spacing-13',
            '--fluid-spacing-01',
            '--fluid-spacing-02',
            '--fluid-spacing-03',
            '--fluid-spacing-04',
            '--layout-01',
            '--layout-02',
            '--layout-03',
            '--layout-04',
            '--layout-05',
            '--layout-06',
            '--layout-07',
        ]);
    }

    public function test_layout_tokens_export_grid_container_and_component_size_roles(): void
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
            '--ui-size-xs',
            '--ui-size-sm',
            '--ui-size-md',
            '--ui-size-lg',
            '--ui-size-xl',
            '--ui-size-2xl',
        ]);
    }

    public function test_spacing_tokens_load_before_component_tokens_and_component_css(): void
    {
        $this->assertImportBefore(
            'resources/css/tokens/index.css',
            './spacing.css',
            './components/index.css',
        );

        $this->assertImportBefore(
            'resources/css/app.css',
            './tokens/index.css',
            './components/index.css',
        );
    }

    /**
     * ---------------------------------------------------------------------
     * Consumer governance
     * ---------------------------------------------------------------------
     */

    public function test_component_and_pattern_css_do_not_define_local_spacing_replacement_scales(): void
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

                if (preg_match('/var\(\s*--ui-(?:spacing|fluid-spacing|layout|container|size|grid)-[\w-]+/', $declaration['value']) === 1) {
                    return false;
                }

                return preg_match(
                    '/^--(?:(?:ui-)?(?:spacing|fluid-spacing|layout|container|size)(?:-|$)|(?:space|gap|gutter|rhythm)(?:-|$))/i',
                    $declaration['property'],
                ) === 1;
            },
        ));

        $this->assertSame(
            [],
            CssTokenAudit::formatDeclarations($localScales),
            'Components and Patterns must not define local spacing, gap, size, or layout rhythm replacement scales.',
        );
    }

    public function test_pattern_css_does_not_introduce_unowned_raw_spacing_values(): void
    {
        $rawSpacingDeclarations = CssTokenAudit::rawSpacingDeclarations([
            'resources/css/patterns',
        ]);

        CssTokenAudit::assertAllDeclarationsAreCategorized($rawSpacingDeclarations, [
            // Pattern-level raw spacing should stay exceptional and explicitly reasoned here.
        ]);
    }

    public function test_component_margin_declarations_are_report_only_baselined(): void
    {
        CssTokenAudit::assertNoNewReportOnlyItems(
            'resources/views/elements/spacing/__tests__/baselines/component-margin-declarations.php',
            CssTokenAudit::formatDeclarations($this->componentMarginDeclarations()),
            'Component margin declaration inventory',
        );
    }

    public function test_component_spacing_geometry_is_report_only_baselined(): void
    {
        CssTokenAudit::assertNoNewReportOnlyItems(
            'resources/views/elements/spacing/__tests__/baselines/component-spacing-geometry.php',
            CssTokenAudit::formatDeclarations($this->componentSpacingGeometryDeclarations()),
            'Component spacing geometry inventory',
        );
    }

    public function test_blade_spacing_utility_usage_is_baselined_before_hard_failure(): void
    {
        $counts = CssTokenAudit::patternCountsByBucket(
            ['resources/views'],
            '/\b(?:m[trblxy]?|p[trblxy]?|gap[xy]?|space-[xy]|inset[xy]?|top|right|bottom|left|w|h|min-w|min-h|max-w|max-h|size)-(?:(?:px|auto|full|screen|min|max|fit)|(?:0|0\.5|1|1\.5|2|2\.5|3|3\.5|4|5|6|7|8|9|10|11|12|14|16|20|24|28|32|36|40|44|48|52|56|60|64|72|80|96)|\[[^\]]+\])\b/',
            ['.blade.php', '.php'],
        );

        CssTokenAudit::assertNoNewReportOnlyCountFindings(
            'resources/views/elements/spacing/__tests__/baselines/blade-spacing-utilities.php',
            $counts,
            'Blade spacing utility class scan',
        );
    }

    /**
     * ---------------------------------------------------------------------
     * Helpers
     * ---------------------------------------------------------------------
     */

    private function assertImportBefore(string $path, string $firstImport, string $secondImport): void
    {
        $imports = CssTokenAudit::imports($path);

        $firstIndex = array_search($firstImport, $imports, true);
        $secondIndex = array_search($secondImport, $imports, true);

        $this->assertNotFalse(
            $firstIndex,
            "{$path} must import {$firstImport}.",
        );

        $this->assertNotFalse(
            $secondIndex,
            "{$path} must import {$secondImport}.",
        );

        $this->assertLessThan(
            (int) $secondIndex,
            (int) $firstIndex,
            "{$path} must import {$firstImport} before {$secondImport}.",
        );
    }

    /**
     * @return list<array{path:string,line:int,property:string,value:string}>
     */
    private function componentMarginDeclarations(): array
    {
        return array_values(array_filter(
            CssTokenAudit::declarations(['resources/css/components']),
            static fn(array $declaration): bool => preg_match('/^margin(?:-(?:block|inline)(?:-(?:start|end))?)?$/', $declaration['property']) === 1,
        ));
    }

    /**
     * @return list<array{path:string,line:int,property:string,value:string}>
     */
    private function componentSpacingGeometryDeclarations(): array
    {
        return array_values(array_filter(
            CssTokenAudit::declarations(['resources/css/components']),
            static fn(array $declaration): bool => preg_match('/^(?:padding(?:-(?:block|inline)(?:-(?:start|end))?)?|gap|row-gap|column-gap|width|height|inset(?:-(?:block|inline)(?:-(?:start|end))?)?|top|right|bottom|left|block-size|inline-size|min-(?:width|height|block-size|inline-size)|max-(?:width|height|block-size|inline-size))$/', $declaration['property']) === 1,
        ));
    }
}
