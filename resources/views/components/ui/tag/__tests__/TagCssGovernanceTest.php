<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/tag/__tests__/TagCssGovernanceTest.php
| Purpose: Verify Tag CSS, class, token, and drift governance.
|--------------------------------------------------------------------------
|
| These tests protect the Tag CSS selector contract, component token source,
| and local drift boundaries without duplicating the full Color, Spacing,
| Typography, Motion, or Icon element governance suites.
|
*/

namespace Tests\Ui\Components\Tag;

use Tests\TestCase;
use Tests\Ui\Elements\Support\CssTokenAudit;

require_once dirname(__DIR__, 4) . '/elements/__tests__/Support/CssTokenAudit.php';

final class TagCssGovernanceTest extends TestCase
{
    /**
     * ---------------------------------------------------------------------
     * Source inventory
     * ---------------------------------------------------------------------
     */

    public function test_tag_css_and_contract_sources_are_installed(): void
    {
        foreach (
            [
                'resources/views/components/ui/tag/index.blade.php',
                'resources/views/components/ui/tag/contract.php',
                'resources/css/components/tag.css',
                'resources/css/tokens/components/tags.css',
                'docs/02-standards/ui/components/tag.md',
            ] as $path
        ) {
            $this->assertFileExists(base_path($path), "Tag source [{$path}] must exist.");
        }
    }

    public function test_tag_contract_points_to_installed_css_blade_and_token_sources(): void
    {
        $contract = $this->contract();

        $this->assertContains(
            'resources/views/components/ui/tag/index.blade.php',
            data_get($contract, 'source.blade', []),
        );

        $this->assertContains(
            'resources/css/components/tag.css',
            data_get($contract, 'source.css', []),
        );

        $this->assertContains(
            'resources/css/tokens/components/tags.css',
            data_get($contract, 'source.tokens', []),
            'Tag contract must reference the installed component token source.',
        );
    }

    /**
     * ---------------------------------------------------------------------
     * CSS selector contract
     * ---------------------------------------------------------------------
     */

    public function test_tag_css_owns_required_root_variant_type_size_and_anatomy_selectors(): void
    {
        $css = CssTokenAudit::read('resources/css/components/tag.css');

        foreach (
            [
                '.ui-tag',
                '.ui-tag-read-only',
                '.ui-tag-dismissible',
                '.ui-tag-selectable',
                '.ui-tag-operational',
                '.ui-tag-type-gray',
                '.ui-tag-type-cool-gray',
                '.ui-tag-type-warm-gray',
                '.ui-tag-type-red',
                '.ui-tag-type-magenta',
                '.ui-tag-type-purple',
                '.ui-tag-type-blue',
                '.ui-tag-type-cyan',
                '.ui-tag-type-teal',
                '.ui-tag-type-green',
                '.ui-tag-type-high-contrast',
                '.ui-tag-type-outline',
                '.ui-tag-sm',
                '.ui-tag-md',
                '.ui-tag-lg',
                '.ui-tag-has-icon',
                '.ui-tag-has-decorator',
                '.ui-tag-selected',
                '.ui-tag-disabled',
                '.ui-tag-label',
                '.ui-tag-label-middle',
                '.ui-tag-label-start',
                '.ui-tag-label-end',
                '.ui-tag-icon',
                '.ui-tag-close',
                '.ui-tag-close-icon',
                '.ui-tag-decorator',
                '.ui-tag-truncate-start',
                '.ui-tag-truncate-middle',
                '.ui-tag-truncate-end',
            ] as $selector
        ) {
            $this->assertStringContainsString(
                $selector,
                $css,
                "Tag CSS must own selector [{$selector}].",
            );
        }
    }

    public function test_tag_contract_class_names_are_supported_by_rendering_or_css(): void
    {
        $contract = $this->contract();
        $css = CssTokenAudit::read('resources/css/components/tag.css');
        $blade = CssTokenAudit::read('resources/views/components/ui/tag/index.blade.php');

        foreach (data_get($contract, 'class_contract.required', []) as $className) {
            $this->assertClassReferencedByBladeOrCss($className, $blade, $css);
        }

        foreach (data_get($contract, 'class_contract.optional', []) as $className) {
            $this->assertClassReferencedByBladeOrCss($className, $blade, $css);
        }

        foreach (data_get($contract, 'class_contract.internal', []) as $className) {
            $this->assertClassReferencedByBladeOrCss($className, $blade, $css);
        }
    }

    public function test_tag_css_does_not_reintroduce_carbon_or_feature_local_tag_class_names(): void
    {
        $css = CssTokenAudit::read('resources/css/components/tag.css');

        $this->assertDoesNotMatchRegularExpression(
            '/\.cds--tag\b/',
            $css,
            'Tag CSS must expose the local ui-tag selector contract, not Carbon cds--tag selectors.',
        );

        $this->assertDoesNotMatchRegularExpression(
            '/\.(?:tag|badge)-(?:gray|blue|green|red|yellow|purple|status|success|error|warning|info)\b/',
            $css,
            'Tag CSS must not reintroduce feature-local tag or badge class families.',
        );
    }

    /**
     * ---------------------------------------------------------------------
     * Component tokens
     * ---------------------------------------------------------------------
     */

    public function test_tag_component_tokens_are_installed_and_consumed_by_tag_css(): void
    {
        $tokenPath = 'resources/css/tokens/components/tags.css';

        $this->assertFileExists(
            base_path($tokenPath),
            'Tag component token source must exist.',
        );

        $tagCss = CssTokenAudit::read('resources/css/components/tag.css');
        $tokenCss = CssTokenAudit::read($tokenPath);

        $consumedTagTokens = $this->customPropertiesConsumedByVar($tagCss, '/^--ui-tag-/');
        $definedTagTokens = array_values(array_unique(array_merge(
            $this->customPropertiesDefinedByCss($tagCss, '/^--ui-tag-/'),
            $this->customPropertiesDefinedByCss($tokenCss, '/^--ui-tag-/'),
        )));
        $definedTokenSourceRoles = $this->customPropertiesDefinedByCss($tokenCss, '/^--ui-tag-/');

        sort($consumedTagTokens);
        sort($definedTagTokens);
        sort($definedTokenSourceRoles);

        $this->assertNotSame(
            [],
            $definedTokenSourceRoles,
            'Tag component token source must define --ui-tag-* roles.',
        );

        $this->assertNotSame(
            [],
            $consumedTagTokens,
            'Tag CSS must consume --ui-tag-* roles.',
        );

        $this->assertSame(
            [],
            array_values(array_diff($consumedTagTokens, $definedTagTokens)),
            'Every --ui-tag-* token consumed by Tag CSS must be defined by Tag CSS or the Tag component token source.',
        );
    }

    /**
     * ---------------------------------------------------------------------
     * Local drift boundaries
     * ---------------------------------------------------------------------
     */

    public function test_tag_css_does_not_define_local_palette_typography_spacing_or_motion_scales(): void
    {
        $declarations = CssTokenAudit::declarations([
            'resources/css/components/tag.css',
        ]);

        $localScales = array_values(array_filter(
            $declarations,
            static function (array $declaration): bool {
                if (! str_starts_with($declaration['property'], '--')) {
                    return false;
                }

                if (str_starts_with($declaration['property'], '--ui-tag')) {
                    return false;
                }

                if (str_starts_with($declaration['property'], '--ui-')) {
                    return false;
                }

                return preg_match(
                    '/(?:color|palette|background|text|border|font|type|spacing|space|gap|padding|margin|size|height|width|duration|motion|easing)/i',
                    $declaration['property'],
                ) === 1;
            },
        ));

        $this->assertSame(
            [],
            CssTokenAudit::formatDeclarations($localScales),
            'Tag CSS must not define local palette, typography, spacing, size, or motion replacement scales.',
        );
    }

    public function test_tag_raw_color_drift_is_categorized(): void
    {
        $rawColorDeclarations = CssTokenAudit::rawColorDeclarations([
            'resources/css/components/tag.css',
        ]);

        CssTokenAudit::assertAllDeclarationsAreCategorized($rawColorDeclarations, [
            [
                'label' => 'Transparent structural values are not authored color roles.',
                'value' => '/(?:transparent|rgba?\([^)]*(?:\/\s*0|\b0\s*\)))/i',
            ],
            [
                'label' => 'Tag shadow or disabled fallback values are current component drift until token cleanup.',
                'property' => '/(?:shadow|background|color|border)/',
                'value' => '/(?:rgb|rgba|color-mix)\(/i',
            ],
        ]);
    }

    public function test_tag_raw_motion_drift_is_categorized(): void
    {
        $rawMotionDeclarations = CssTokenAudit::rawMotionDeclarations([
            'resources/css/components/tag.css',
        ]);

        CssTokenAudit::assertAllDeclarationsAreCategorized($rawMotionDeclarations, []);
    }

    public function test_tag_typography_drift_is_categorized(): void
    {
        $rawTypeDeclarations = CssTokenAudit::rawTypeDeclarations([
            'resources/css/components/tag.css',
        ]);

        CssTokenAudit::assertAllDeclarationsAreCategorized($rawTypeDeclarations, [
            [
                'label' => 'Tag icon-only or visually hidden structural text rules use zero sizing.',
                'property' => '/^(font-size|line-height|letter-spacing)$/',
                'value' => '/^(0|1)$/',
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
        $contract = require resource_path('views/components/ui/tag/contract.php');

        $this->assertIsArray($contract);

        return $contract;
    }

    private function assertClassReferencedByBladeOrCss(string $className, string $blade, string $css): void
    {
        $this->assertTrue(
            str_contains($blade, $className) || str_contains($css, '.' . $className),
            "Tag class [{$className}] must be referenced by Blade or CSS.",
        );
    }

    /**
     * @return list<string>
     */
    private function customPropertiesConsumedByVar(string $css, string $propertyFilter): array
    {
        preg_match_all('/var\(\s*(?<property>--[-a-zA-Z0-9_]+)/', $css, $matches);

        $properties = array_values(array_unique($matches['property'] ?? []));

        return array_values(array_filter(
            $properties,
            static fn(string $property): bool => preg_match($propertyFilter, $property) === 1,
        ));
    }

    /**
     * @return list<string>
     */
    private function customPropertiesDefinedByCss(string $css, string $propertyFilter): array
    {
        preg_match_all('/(?<property>--[-a-zA-Z0-9_]+)\s*:/', $css, $matches);

        $properties = array_values(array_unique($matches['property'] ?? []));

        return array_values(array_filter(
            $properties,
            static fn(string $property): bool => preg_match($propertyFilter, $property) === 1,
        ));
    }
}
