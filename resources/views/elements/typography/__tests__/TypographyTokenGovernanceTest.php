<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| File: tests/Ui/Elements/Typography/TypographyTokenGovernanceTest.php
| Purpose: Verify Typography token ownership and consumer drift governance.
|--------------------------------------------------------------------------
|
| These tests protect the provisional Typography foundation element from raw
| type decisions, token entrypoint drift, unbaselined Blade utility usage, and
| rendered evidence contract drift.
|
*/

namespace Tests\Ui\Elements\Typography;

use Tests\TestCase;
use Tests\Ui\Elements\Support\CssTokenAudit;

final class TypographyTokenGovernanceTest extends TestCase
{
    /**
     * ---------------------------------------------------------------------
     * Standard / contract alignment
     * ---------------------------------------------------------------------
     */

    public function test_typography_standard_and_runtime_contract_stay_aligned(): void
    {
        CssTokenAudit::assertStandardAndContractAreAligned(
            'typography',
            'docs/02-standards/ui/elements/typography.md',
        );
    }

    public function test_typography_contract_remains_provisional_until_visual_and_accessibility_review(): void
    {
        $contract = CssTokenAudit::contract('typography');

        $this->assertSame('typography', data_get($contract, 'identity.slug'));
        $this->assertSame('Typography', data_get($contract, 'identity.label'));
        $this->assertSame('provisional', data_get($contract, 'lifecycle.status'));

        $this->assertContains('button', data_get($contract, 'dependencies.blocks', []));
        $this->assertContains('text-input', data_get($contract, 'dependencies.blocks', []));
        $this->assertContains('data-table', data_get($contract, 'dependencies.blocks', []));
    }

    /**
     * ---------------------------------------------------------------------
     * Token source ownership
     * ---------------------------------------------------------------------
     */

    public function test_type_entrypoint_exports_foundation_tokens_before_type_utilities(): void
    {
        CssTokenAudit::assertImports('resources/css/type/index.css', [
            './font-family.css',
            './font-weight.css',
            './scale.css',
            './fluid.css',
            './tokens.css',
            './reset.css',
            './styles.css',
            './print.css',
            './types.css',
        ]);

        $this->assertImportBefore('resources/css/type/index.css', './tokens.css', './styles.css');
        $this->assertImportBefore('resources/css/type/index.css', './tokens.css', './types.css');
    }

    public function test_type_tokens_define_required_productive_and_expressive_roles(): void
    {
        CssTokenAudit::assertDefinesTokens('resources/css/type/tokens.css', [
            '--ui-type-body-compact-01-font-size',
            '--ui-type-body-compact-01-font-weight',
            '--ui-type-body-compact-01-line-height',
            '--ui-type-body-compact-01-letter-spacing',
            '--ui-type-body-01-font-size',
            '--ui-type-body-01-font-weight',
            '--ui-type-body-01-line-height',
            '--ui-type-body-01-letter-spacing',
            '--ui-type-heading-compact-01-font-size',
            '--ui-type-heading-compact-01-font-weight',
            '--ui-type-heading-compact-01-line-height',
            '--ui-type-heading-compact-01-letter-spacing',
            '--ui-type-code-01-font-size',
            '--ui-type-code-01-font-weight',
            '--ui-type-code-01-line-height',
            '--ui-type-code-01-letter-spacing',
            '--ui-type-productive-heading-01-font-size',
            '--ui-type-expressive-heading-03-font-size',
        ]);
    }

    public function test_type_tokens_consume_foundation_font_weight_and_scale_sources(): void
    {
        CssTokenAudit::assertUsesTokens('resources/css/type/tokens.css', [
            '--ui-font-weight-regular',
            '--ui-font-weight-semibold',
        ]);
    }

    public function test_type_styles_use_type_tokens_for_installed_text_roles(): void
    {
        $css = CssTokenAudit::read('resources/css/type/styles.css');

        foreach (
            [
                '--ui-type-body-compact-01-font-size',
                '--ui-type-body-compact-01-line-height',
                '--ui-type-body-01-font-size',
                '--ui-type-body-01-line-height',
                '--ui-type-heading-compact-01-font-size',
            ] as $token
        ) {
            $this->assertStringContainsString(
                "var({$token}",
                $css,
                "resources/css/type/styles.css must consume {$token}.",
            );
        }
    }

    /**
     * ---------------------------------------------------------------------
     * Consumer governance
     * ---------------------------------------------------------------------
     */

    public function test_component_and_pattern_typography_drift_is_categorized(): void
    {
        $rawTypeDeclarations = CssTokenAudit::rawTypeDeclarations([
            'resources/css/components',
            'resources/css/patterns',
        ]);

        CssTokenAudit::assertNoNewReportOnlyItems(
            'resources/views/elements/typography/__tests__/baselines/component-type-drift.php',
            CssTokenAudit::formatDeclarations($rawTypeDeclarations),
            'Component and Pattern raw type declaration inventory',
        );

        CssTokenAudit::assertAllDeclarationsAreCategorized($rawTypeDeclarations, [
            [
                'label' => 'Icon-only and visually hidden control text uses structural zero sizing.',
                'property' => '/^(font-size|line-height|letter-spacing)$/',
                'value' => '/^(0|1)$/',
            ],
            [
                'label' => 'Controls intentionally inherit surrounding text contracts.',
                'property' => '/^font$/',
                'value' => '/^inherit$/',
            ],
            [
                'label' => 'Component line-height calculations tied to spacing geometry are structural.',
                'property' => '/^line-height$/',
                'value' => '/^calc\(.+var\(--ui-spacing-/',
            ],
            [
                'label' => 'Code snippet mono font fallback is current Carbon component parity drift.',
                'path' => '/resources\/css\/components\/code-snippet\.css$/',
                'property' => '/^font-family$/',
                'value' => '/var\(--ui-font-family-mono,\s*monospace\)/',
            ],
            [
                'label' => 'Form and list-box label/body values are installed Carbon component drift pending component token cleanup.',
                'path' => '/resources\/css\/components\/(?:form|list-box)\.css$/',
                'property' => '/^(font-weight|line-height)$/',
            ],
            [
                'label' => 'Loading component text sizing is installed Carbon component drift pending type role consumption.',
                'path' => '/resources\/css\/components\/loading\.css$/',
                'property' => '/^(font-size|line-height)$/',
            ],
            [
                'label' => 'Modal body weight is installed Carbon component drift pending type role cleanup.',
                'path' => '/resources\/css\/components\/modal\.css$/',
                'property' => '/^font-weight$/',
            ],
            [
                'label' => 'Number input and overflow menu raw weights are installed Carbon component drift pending type role cleanup.',
                'path' => '/resources\/css\/components\/(?:number-input|overflow-menu)\.css$/',
                'property' => '/^font-weight$/',
            ],
            [
                'label' => 'Progress indicator line-height and optional normal weight are installed Carbon component drift.',
                'path' => '/resources\/css\/components\/progress-indicator\.css$/',
                'property' => '/^(line-height|font-weight)$/',
            ],
            [
                'label' => 'Carbon shell side-nav and switcher raw type values are current migration drift.',
                'path' => '/resources\/css\/components\/ui-shell\/(?:side-nav|switcher|content|header-actions|header)\.css$/',
            ],
            [
                'label' => 'Status and badge indicator typography is current component-token drift.',
                'path' => '/resources\/css\/components\/(?:status|badge-indicator)\.css$/',
            ],
            [
                'label' => 'Slug optional AI label typography is isolated current drift.',
                'path' => '/resources\/css\/components\/slug\.css$/',
            ],
            [
                'label' => 'Dropdown list geometry currently uses a raw line-height value.',
                'path' => '/resources\/css\/components\/dropdown\.css$/',
                'property' => '/^line-height$/',
            ],
            [
                'label' => 'Tree view nested label line-height is current Carbon parity drift.',
                'path' => '/resources\/css\/components\/tree-view\.css$/',
                'property' => '/^line-height$/',
                'value' => '/^1\.2$/',
            ],
            [
                'label' => 'Content switcher raw font weights are current token cleanup drift.',
                'path' => '/resources\/css\/components\/content-switcher\.css$/',
                'property' => '/^font-weight$/',
            ],
        ]);
    }

    public function test_consumers_do_not_define_local_type_role_replacement_variables(): void
    {
        $declarations = CssTokenAudit::declarations([
            'resources/css/components',
            'resources/css/patterns',
        ]);

        $localTypeScales = array_values(array_filter(
            $declarations,
            static function (array $declaration): bool {
                if (! str_starts_with($declaration['property'], '--')) {
                    return false;
                }

                if (str_starts_with($declaration['property'], '--ui-')) {
                    return false;
                }

                return preg_match(
                    '/(?:font|type|text|heading|body|label|helper|line-height|letter-spacing|tracking)/i',
                    $declaration['property'],
                ) === 1;
            },
        ));

        $this->assertSame(
            [],
            CssTokenAudit::formatDeclarations($localTypeScales),
            'Components and Patterns must not define local typography replacement variables.',
        );
    }

    public function test_blade_typography_utility_usage_is_baselined_before_hard_failure(): void
    {
        $counts = CssTokenAudit::patternCountsByBucket(
            ['resources/views'],
            '/\b(?:text-(?:xs|sm|base|lg|xl|[2-9]xl)|font-(?:thin|extralight|light|normal|medium|semibold|bold|extrabold|black)|leading-(?:none|tight|snug|normal|relaxed|loose|[0-9]+)|tracking-(?:tighter|tight|normal|wide|wider|widest))\b/',
            ['.blade.php', '.php'],
        );

        CssTokenAudit::assertNoNewReportOnlyCountFindings(
            'resources/views/elements/typography/__tests__/baselines/blade-typography-utilities.php',
            $counts,
            'Blade typography utility class scan',
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
}
