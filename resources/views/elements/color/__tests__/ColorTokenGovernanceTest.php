<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| File: tests/Ui/Elements/Color/ColorTokenGovernanceTest.php
| Purpose: Verify Color token ownership and consumer drift governance.
|--------------------------------------------------------------------------
|
| These tests protect the approved Color foundation element from raw color,
| primitive palette, unapproved component color token, and utility-class drift.
|
*/

namespace Tests\Ui\Elements\Color;

use Tests\TestCase;
use Tests\Ui\Elements\Support\CssTokenAudit;

final class ColorTokenGovernanceTest extends TestCase
{
    /**
     * ---------------------------------------------------------------------
     * Standard / contract alignment
     * ---------------------------------------------------------------------
     */

    public function test_color_standard_and_runtime_contract_stay_aligned(): void
    {
        CssTokenAudit::assertStandardAndContractAreAligned(
            'color',
            'docs/02-standards/ui/elements/color.md',
        );
    }

    /**
     * ---------------------------------------------------------------------
     * Token source ownership
     * ---------------------------------------------------------------------
     */

    public function test_color_token_entrypoints_preserve_carbon_palette_and_semantic_layers(): void
    {
        CssTokenAudit::assertImports('resources/css/tokens/index.css', [
            './palette/index.css',
            './themes/index.css',
            './components/index.css',
            './semantic/index.css',
        ]);

        CssTokenAudit::assertImports('resources/css/tokens/palette/index.css', [
            './base-colors.css',
        ]);

        CssTokenAudit::assertImports('resources/css/tokens/semantic/index.css', [
            './app-aliases.css',
        ]);

        CssTokenAudit::assertDefinesTokens('resources/css/tokens/palette/base-colors.css', [
            '--ui-white',
            '--ui-black',
            '--ui-gray-10',
            '--ui-gray-100',
            '--ui-blue-60',
            '--ui-red-60',
            '--ui-green-50',
            '--ui-yellow-30',
            '--ui-purple-60',
            '--ui-orange-40',
            '--ui-gray-50-rgb',
            '--ui-blue-60-hover',
        ]);

        CssTokenAudit::assertDefinesTokens('resources/css/tokens/semantic/app-aliases.css', [
            '--ui-canvas',
            '--ui-surface',
            '--ui-text-muted',
            '--ui-icon-muted',
            '--ui-action-primary-bg',
            '--ui-status-success-bg',
            '--ui-notification-info-bg',
        ]);
    }

    public function test_component_color_token_families_match_carbon_allowed_component_tokens(): void
    {
        $allowedFiles = [
            'buttons.css',
            'content-switcher.css',
            'notifications.css',
            'tags.css',
        ];

        $imports = CssTokenAudit::imports('resources/css/tokens/components/index.css');
        $importFiles = array_values(array_map(
            static fn(string $import): string => basename($import),
            $imports,
        ));

        sort($importFiles);

        foreach ($allowedFiles as $allowedFile) {
            $this->assertContains(
                $allowedFile,
                $importFiles,
                "{$allowedFile} must remain an approved Carbon component color token family.",
            );
        }

        CssTokenAudit::assertNoNewReportOnlyItems(
            'resources/views/elements/color/__tests__/baselines/component-token-file-drift.php',
            array_values(array_diff($importFiles, $allowedFiles)),
            'Component token imports outside Button, Content Switcher, Notification, and Tag',
        );

        $componentTokenFiles = array_values(array_filter(
            array_map(
                static fn(string $path): string => basename($path),
                CssTokenAudit::cssFiles('resources/css/tokens/components'),
            ),
            static fn(string $file): bool => $file !== 'index.css',
        ));

        sort($componentTokenFiles);

        foreach ($allowedFiles as $allowedFile) {
            $this->assertContains(
                $allowedFile,
                $componentTokenFiles,
                "{$allowedFile} must remain an approved Carbon component color token file.",
            );
        }

        CssTokenAudit::assertNoNewReportOnlyItems(
            'resources/views/elements/color/__tests__/baselines/component-token-file-drift.php',
            array_values(array_diff($componentTokenFiles, $allowedFiles)),
            'Component token files outside Button, Content Switcher, Notification, and Tag',
        );

        CssTokenAudit::assertDefinesTokens('resources/css/tokens/components/buttons.css', [
            '--ui-button-primary',
            '--ui-button-primary-hover',
            '--ui-button-danger-primary',
            '--ui-button-disabled',
        ]);

        CssTokenAudit::assertDefinesTokens('resources/css/tokens/components/notifications.css', [
            '--ui-notification-background-error',
            '--ui-notification-background-success',
            '--ui-notification-action-tertiary-inverse',
        ]);
    }

    /**
     * ---------------------------------------------------------------------
     * Consumer governance
     * ---------------------------------------------------------------------
     */

    public function test_consumer_color_drift_is_categorized_instead_of_silently_allowed(): void
    {
        $rawColorDeclarations = CssTokenAudit::rawColorDeclarations([
            'resources/css/components',
            'resources/css/patterns',
        ]);

        CssTokenAudit::assertAllDeclarationsAreCategorized($rawColorDeclarations, $this->knownConsumerColorDriftRules());
    }

    public function test_consumer_css_does_not_consume_primitive_palette_tokens_directly(): void
    {
        $primitivePaletteDeclarations = CssTokenAudit::primitivePaletteColorDeclarations([
            'resources/css/components',
            'resources/css/patterns',
        ]);

        CssTokenAudit::assertAllDeclarationsAreCategorized(
            $primitivePaletteDeclarations,
            $this->knownPrimitivePaletteDriftRules(),
        );
    }

    public function test_blade_color_utility_usage_is_baselined_before_hard_failure(): void
    {
        $counts = CssTokenAudit::patternCountsByBucket(
            ['resources/views'],
            '/\b(?:text|bg|border|from|to|via|ring|divide|placeholder|accent|decoration|outline)-(?:slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose|white|black)(?:-[0-9]{2,3})?\b/',
            ['.blade.php', '.php'],
        );

        CssTokenAudit::assertNoNewReportOnlyCountFindings(
            'resources/views/elements/color/__tests__/baselines/blade-color-utilities.php',
            $counts,
            'Blade color utility class scan',
        );
    }

    /**
     * ---------------------------------------------------------------------
     * rendered evidence contract
     * ---------------------------------------------------------------------
     */

    public function test_color_contract_exposes_expected_identity_and_reference_routes(): void
    {
        $contract = CssTokenAudit::contract('color');

        $this->assertSame('color', data_get($contract, 'identity.slug'));
        $this->assertSame('Color', data_get($contract, 'identity.label'));
        $this->assertContains(
            'docs/02-standards/ui/elements/color.md',
            data_get($contract, 'source.docs', []),
        );
    }

    /**
     * ---------------------------------------------------------------------
     * Helpers
     * ---------------------------------------------------------------------
     *
     * @return list<array{label:string,path?:string,property?:string,value?:string}>
     */
    private function knownConsumerColorDriftRules(): array
    {
        return [
            [
                'label' => 'Zero-alpha transparency is a structural transparent stop, not an authored color role.',
                'value' => '/rgba?\([^)]*(?:\/\s*0|\b0\s*\))|rgb\(255 255 255 \/ 0\)/i',
            ],
            [
                'label' => 'Pagination transparent fallbacks are current Carbon component state drift.',
                'path' => '/resources\/css\/components\/pagination(?:-nav)?\.css$/',
                'value' => '/(?:transparent|rgba?\([^)]*(?:\/\s*0|\b0\s*\)))/i',
            ],
            [
                'label' => 'Carbon mask gradients use black as mask alpha, not UI color.',
                'path' => '/resources\/css\/components\/(code-snippet|tabs)\.css$/',
                'value' => '/#000(?:000)?/',
            ],
            [
                'label' => 'Installed Carbon SVG glyph fills still use black palette fallbacks pending icon-currentColor cleanup.',
                'path' => '/resources\/css\/components\/(?:actionable-notification|checkbox|date-picker|icon-indicator|inline-notification|number-input|radio-button|select|slider|text-area|text-input|toast-notification)\.css$/',
                'property' => '/^fill$/',
                'value' => '/var\(--ui-black(?:-100)?,\s*#000(?:000)?\)|var\(--ui-black-100\)/',
            ],
            [
                'label' => 'Shadow fallback values are current drift until all components consume shadow tokens.',
                'property' => '/shadow/',
                'value' => '/(?:rgb|rgba|color-mix)\(/i',
            ],
            [
                'label' => 'Flatpickr floating shadow fallback is current third-party adapter drift.',
                'path' => '/resources\/css\/components\/flatpickr\.css$/',
                'property' => '/shadow/',
                'value' => '/color-mix\(/i',
            ],
            [
                'label' => 'Time picker disabled field fallback uses current token-mixed Carbon adapter drift.',
                'path' => '/resources\/css\/components\/time-picker\.css$/',
                'value' => '/color-mix\(/i',
            ],
            [
                'label' => 'Skeleton fallback color remains a documented migration exception.',
                'value' => '/--ui-skeleton-background,\s*rgb\(255 255 255 \/ 0\.18\)/i',
            ],
            [
                'label' => 'Select native text-shadow fallback is current platform-specific drift.',
                'path' => '/resources\/css\/components\/select\.css$/',
                'property' => '/^text-shadow$/',
                'value' => '/#000000/',
            ],
            [
                'label' => 'Slug/AI label styles are optional current drift and must stay isolated to slug.css.',
                'path' => '/resources\/css\/components\/slug\.css$/',
            ],

        ];
    }

    /**
     * @return list<array{label:string,path?:string,property?:string,value?:string}>
     */
    private function knownPrimitivePaletteDriftRules(): array
    {
        return array_values(array_filter(
            $this->knownConsumerColorDriftRules(),
            static fn(array $rule): bool => str_contains($rule['label'], 'SVG glyph fills'),
        ));
    }
}
