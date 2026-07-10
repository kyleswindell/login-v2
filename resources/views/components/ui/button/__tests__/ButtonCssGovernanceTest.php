<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/button/__tests__/ButtonCssGovernanceTest.php
| Purpose: Verify Button CSS, class, token, and drift governance.
|--------------------------------------------------------------------------
|
| These tests protect the Button CSS selector contract, component token source,
| and local drift boundaries without duplicating the full Color, Spacing,
| Typography, Motion, or Icon element governance suites.
|
*/

namespace Tests\Ui\Components\Button;

use Tests\TestCase;
use Tests\Ui\Elements\Support\CssTokenAudit;

require_once dirname(__DIR__, 4) . '/elements/__tests__/Support/CssTokenAudit.php';

final class ButtonCssGovernanceTest extends TestCase
{
    /**
     * ---------------------------------------------------------------------
     * Source inventory
     * ---------------------------------------------------------------------
     */

    public function test_button_css_and_token_sources_are_installed(): void
    {
        foreach (
            [
                'resources/views/components/ui/button/index.blade.php',
                'resources/views/components/ui/button/contract.php',
                'resources/css/components/button.css',
                'resources/css/tokens/components/buttons.css',
                'docs/02-standards/ui/components/button.md',
            ] as $path
        ) {
            $this->assertFileExists(base_path($path), "Button source [{$path}] must exist.");
        }
    }

    public function test_button_contract_points_to_installed_css_and_token_sources(): void
    {
        $contract = $this->contract();

        $this->assertContains(
            'resources/css/components/button.css',
            data_get($contract, 'source.css', []),
        );

        $this->assertContains(
            'resources/css/tokens/components/buttons.css',
            data_get($contract, 'source.tokens', []),
        );

        $this->assertContains(
            'resources/views/components/ui/button/index.blade.php',
            data_get($contract, 'source.blade', []),
        );
    }

    /**
     * ---------------------------------------------------------------------
     * CSS selector contract
     * ---------------------------------------------------------------------
     */

    public function test_button_css_owns_required_root_modifier_and_anatomy_selectors(): void
    {
        $css = CssTokenAudit::read('resources/css/components/button.css');

        foreach (
            [
                '.ui-btn',
                '.ui-btn--primary',
                '.ui-btn--secondary',
                '.ui-btn--tertiary',
                '.ui-btn--ghost',
                '.ui-btn--danger',
                '.ui-btn--danger--primary',
                '.ui-btn--danger--tertiary',
                '.ui-btn--danger--ghost',
                '.ui-btn--xs',
                '.ui-btn--sm',
                '.ui-btn--md',
                '.ui-btn--lg',
                '.ui-btn--xl',
                '.ui-btn--2xl',
                '.ui-btn--expressive',
                '.ui-btn--loading',
                '.ui-btn--disabled',
                '.ui-btn__label',
                '.ui-btn__icon',
            ] as $selector
        ) {
            $this->assertStringContainsString(
                $selector,
                $css,
                "Button CSS must own selector [{$selector}].",
            );
        }
    }

    public function test_button_contract_class_names_are_supported_by_rendering_or_css(): void
    {
        $contract = $this->contract();
        $css = CssTokenAudit::read('resources/css/components/button.css');
        $blade = CssTokenAudit::read('resources/views/components/ui/button/index.blade.php');

        foreach (data_get($contract, 'class_contract.required', []) as $className) {
            $this->assertClassReferencedByBladeOrCss($className, $blade, $css);
        }

        foreach (data_get($contract, 'class_contract.optional', []) as $className) {
            $this->assertClassReferencedByBladeOrCss($className, $blade, $css);
        }

        foreach (
            [
                'ui-btn__label',
                'ui-btn__icon',
                'ui-spinner',
                'ui-spinner-inverse',
                'ui-visually-hidden',
            ] as $className
        ) {
            $this->assertClassReferencedByBladeOrCss($className, $blade, $css);
        }
    }

    public function test_button_css_does_not_reintroduce_carbon_or_feature_local_button_class_names(): void
    {
        $css = CssTokenAudit::read('resources/css/components/button.css');

        $this->assertDoesNotMatchRegularExpression(
            '/\.cds--btn\b/',
            $css,
            'Button CSS must expose the local ui-btn selector contract, not Carbon cds--btn selectors.',
        );

        $this->assertDoesNotMatchRegularExpression(
            '/\.(?:btn|button)-(?:primary|secondary|danger|ghost|outline|soft)\b/',
            $css,
            'Button CSS must not reintroduce feature-local button class families.',
        );
    }

    /**
     * ---------------------------------------------------------------------
     * Component color tokens
     * ---------------------------------------------------------------------
     */

    public function test_button_component_tokens_define_required_button_color_roles(): void
    {
        CssTokenAudit::assertDefinesTokens('resources/css/tokens/components/buttons.css', [
            '--ui-button-primary',
            '--ui-button-primary-hover',
            '--ui-button-primary-active',
            '--ui-button-secondary',
            '--ui-button-secondary-hover',
            '--ui-button-secondary-active',
            '--ui-button-tertiary',
            '--ui-button-tertiary-hover',
            '--ui-button-tertiary-active',
            '--ui-button-danger-primary',
            '--ui-button-danger-secondary',
            '--ui-button-danger-hover',
            '--ui-button-danger-active',
            '--ui-button-separator',
            '--ui-button-disabled',
        ]);
    }

    public function test_button_css_consumes_button_component_color_roles(): void
    {
        CssTokenAudit::assertUsesTokens('resources/css/components/button.css', [
            '--ui-button-primary',
            '--ui-button-primary-hover',
            '--ui-button-primary-active',
            '--ui-button-secondary',
            '--ui-button-secondary-hover',
            '--ui-button-secondary-active',
            '--ui-button-tertiary',
            '--ui-button-tertiary-hover',
            '--ui-button-tertiary-active',
            '--ui-button-danger-primary',
            '--ui-button-danger-secondary',
            '--ui-button-danger-hover',
            '--ui-button-danger-active',
            '--ui-button-separator',
            '--ui-button-disabled',
        ]);
    }

    /**
     * ---------------------------------------------------------------------
     * Local drift boundaries
     * ---------------------------------------------------------------------
     */

    public function test_button_css_does_not_define_local_palette_or_spacing_scales(): void
    {
        $declarations = CssTokenAudit::declarations([
            'resources/css/components/button.css',
        ]);

        $localScales = array_values(array_filter(
            $declarations,
            static function (array $declaration): bool {
                if (! str_starts_with($declaration['property'], '--')) {
                    return false;
                }

                if (str_starts_with($declaration['property'], '--ui-btn')) {
                    return false;
                }

                if (str_starts_with($declaration['property'], '--ui-button')) {
                    return false;
                }

                if (str_starts_with($declaration['property'], '--ui-')) {
                    return false;
                }

                return preg_match(
                    '/(?:color|palette|background|text|border|spacing|space|gap|padding|margin|size|height|width|duration|motion|easing)/i',
                    $declaration['property'],
                ) === 1;
            },
        ));

        $this->assertSame(
            [],
            CssTokenAudit::formatDeclarations($localScales),
            'Button CSS must not define local palette, spacing, size, or motion replacement scales.',
        );
    }

    public function test_button_raw_color_drift_is_categorized(): void
    {
        $rawColorDeclarations = CssTokenAudit::rawColorDeclarations([
            'resources/css/components/button.css',
        ]);

        CssTokenAudit::assertAllDeclarationsAreCategorized($rawColorDeclarations, [
            [
                'label' => 'Button shadow fallback values are current component drift until shadow tokens fully replace raw fallback values.',
                'property' => '/shadow/',
                'value' => '/(?:rgb|rgba|color-mix)\(/i',
            ],
            [
                'label' => 'Transparent structural values are not authored color roles.',
                'value' => '/(?:transparent|rgba?\([^)]*(?:\/\s*0|\b0\s*\)))/i',
            ],
        ]);
    }

    public function test_button_raw_motion_drift_is_categorized(): void
    {
        $rawMotionDeclarations = CssTokenAudit::rawMotionDeclarations([
            'resources/css/components/button.css',
        ]);

        CssTokenAudit::assertAllDeclarationsAreCategorized($rawMotionDeclarations, [
            [
                'label' => 'Button skeleton/loading shimmer cadence is current Carbon parity drift.',
                'value' => '/(?:3000ms|1\.5s|ease-in-out|linear)/i',
            ],
        ]);
    }

    public function test_button_typography_drift_is_categorized(): void
    {
        $rawTypeDeclarations = CssTokenAudit::rawTypeDeclarations([
            'resources/css/components/button.css',
        ]);

        CssTokenAudit::assertAllDeclarationsAreCategorized($rawTypeDeclarations, [
            [
                'label' => 'Icon-only or visually hidden structural text rules use zero sizing.',
                'property' => '/^(font-size|line-height|letter-spacing)$/',
                'value' => '/^(0|1)$/',
            ],
            [
                'label' => 'Button loading or expressive structural type values are current component-token drift.',
                'path' => '/resources\/css\/components\/button\.css$/',
            ],
        ]);
    }

    /**
     * ---------------------------------------------------------------------
     * Helpers
     * ---------------------------------------------------------------------
     *
     * @return array<string, mixed>
     */
    private function contract(): array
    {
        $contract = require resource_path('views/components/ui/button/contract.php');

        $this->assertIsArray($contract);

        return $contract;
    }

    private function assertClassReferencedByBladeOrCss(string $className, string $blade, string $css): void
    {
        $this->assertTrue(
            str_contains($blade, $className) || str_contains($css, '.' . $className),
            "Button class [{$className}] must be referenced by Blade or CSS.",
        );
    }
}
