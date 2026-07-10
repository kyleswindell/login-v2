<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| File: tests/Ui/Elements/Themes/ThemeTokenGovernanceTest.php
| Purpose: Verify Themes token ownership and consumer drift governance.
|--------------------------------------------------------------------------
|
| These tests protect the approved Themes foundation element from missing
| theme role keys, component-local theme patches, unsupported theme contexts,
| and forced-colors drift.
|
*/

namespace Tests\Ui\Elements\Themes;

use Tests\TestCase;
use Tests\Ui\Elements\Support\CssTokenAudit;

final class ThemeTokenGovernanceTest extends TestCase
{
    /**
     * ---------------------------------------------------------------------
     * Standard / contract alignment
     * ---------------------------------------------------------------------
     */

    public function test_themes_standard_and_runtime_contract_stay_aligned(): void
    {
        CssTokenAudit::assertStandardAndContractAreAligned(
            'themes',
            'docs/02-standards/ui/elements/themes.md',
        );
    }

    public function test_theme_contract_stays_approved_but_manual_examples_remain_review_gated(): void
    {
        $contract = CssTokenAudit::contract('themes');

        $this->assertSame('themes', data_get($contract, 'identity.slug'));
        $this->assertSame('Themes', data_get($contract, 'identity.label'));
        $this->assertSame('approved', data_get($contract, 'lifecycle.status'));

        $this->assertContains('color', data_get($contract, 'dependencies.depends_on', []));
        $this->assertContains('button', data_get($contract, 'dependencies.blocks', []));
        $this->assertContains('ui-shell', data_get($contract, 'dependencies.blocks', []));
    }

    /**
     * ---------------------------------------------------------------------
     * Theme source ownership
     * ---------------------------------------------------------------------
     */

    public function test_theme_entrypoint_exposes_the_supported_carbon_theme_family(): void
    {
        CssTokenAudit::assertImports('resources/css/tokens/themes/index.css', [
            './white.css',
            './gray-10.css',
            './gray-90.css',
            './gray-100.css',
            './forced-colors.css',
        ]);
    }

    public function test_supported_themes_expose_the_same_role_keys(): void
    {
        CssTokenAudit::assertThemeFilesExposeSameRoleKeys($this->themeFiles());
    }

    public function test_each_theme_defines_the_required_role_contract(): void
    {
        foreach ($this->themeFilesWithSchemes() as $path => $scheme) {
            CssTokenAudit::assertDefinesTokens($path, [
                '--ui-color-scheme',
                '--ui-background',
                '--ui-layer-01',
                '--ui-layer-02',
                '--ui-field-01',
                '--ui-border-subtle-01',
                '--ui-border-strong-01',
                '--ui-text-primary',
                '--ui-icon-primary',
                '--ui-link-primary',
                '--ui-support-error',
                '--ui-focus',
                '--ui-skeleton-background',
            ]);

            $this->assertCssCustomPropertyValue($path, '--ui-color-scheme', $scheme);
        }
    }

    public function test_forced_colors_theme_source_exists_and_uses_forced_colors_context(): void
    {
        $path = 'resources/css/tokens/themes/forced-colors.css';
        $css = CssTokenAudit::read($path);

        $this->assertMatchesRegularExpression(
            '/forced-colors\s*:\s*active/i',
            $css,
            "{$path} must define forced-colors context rules.",
        );

        $this->assertMatchesRegularExpression(
            '/(?:Canvas|CanvasText|ButtonText|ButtonBorder|Highlight|HighlightText|LinkText|GrayText|Mark|SelectedItem|SelectedItemText)/',
            $css,
            "{$path} must use forced-colors system color keywords.",
        );
    }

    /**
     * ---------------------------------------------------------------------
     * Consumer governance
     * ---------------------------------------------------------------------
     */

    public function test_component_and_pattern_css_do_not_add_unapproved_theme_selectors(): void
    {
        $findings = $this->themeSelectorFindings([
            'resources/css/components',
            'resources/css/patterns',
        ]);

        $approvedThemeContextPaths = [
            'resources/css/components/time-picker.css',
            'resources/views/elements/',
            'tests/',
        ];

        $unexpected = array_values(array_filter(
            $findings,
            static function (string $finding) use ($approvedThemeContextPaths): bool {
                foreach ($approvedThemeContextPaths as $allowedPath) {
                    if (str_starts_with($finding, $allowedPath)) {
                        return false;
                    }
                }

                return true;
            },
        ));

        $this->assertSame(
            [],
            $unexpected,
            'Component and Pattern CSS must not add component-local theme selectors. Move theme-specific values into theme roles or approved component tokens.',
        );
    }

    public function test_forced_colors_rules_are_accessibility_context_not_theme_patches(): void
    {
        $paths = [];

        foreach (CssTokenAudit::files(['resources/css/components', 'resources/css/patterns'], ['.css']) as $path) {
            $css = CssTokenAudit::read($path);

            if (preg_match('/forced-colors\s*:\s*active/i', $css) !== 1) {
                continue;
            }

            $paths[] = $path;

            $this->assertMatchesRegularExpression(
                '/(?:Canvas|CanvasText|ButtonText|ButtonBorder|Highlight|HighlightText|LinkText|GrayText|Mark|SelectedItem|SelectedItemText|currentColor|transparent|none|0|1px)/',
                $css,
                "{$path} uses forced-colors rules but does not appear to use forced-colors-safe values.",
            );
        }

        sort($paths);

        $this->assertNotSame(
            [],
            $paths,
            'At least one component or Pattern should prove forced-colors rules are treated as accessibility context, not local theme patches.',
        );
    }

    /**
     * ---------------------------------------------------------------------
     * Helpers
     * ---------------------------------------------------------------------
     *
     * @return list<string>
     */
    private function themeFiles(): array
    {
        return array_keys($this->themeFilesWithSchemes());
    }

    /**
     * @return array<string, string>
     */
    private function themeFilesWithSchemes(): array
    {
        return [
            'resources/css/tokens/themes/white.css' => 'light',
            'resources/css/tokens/themes/gray-10.css' => 'light',
            'resources/css/tokens/themes/gray-90.css' => 'dark',
            'resources/css/tokens/themes/gray-100.css' => 'dark',
        ];
    }

    private function assertCssCustomPropertyValue(string $path, string $token, string $expectedValue): void
    {
        $actualValue = $this->extractCssCustomPropertyValue(CssTokenAudit::read($path), $token);

        $this->assertNotNull(
            $actualValue,
            "{$path} must define {$token}.",
        );

        $this->assertSame(
            $this->normalizeCssValue($expectedValue),
            $this->normalizeCssValue((string) $actualValue),
            "{$path} must keep {$token} aligned with the approved Theme value.",
        );
    }

    private function extractCssCustomPropertyValue(string $css, string $token): ?string
    {
        preg_match(
            '/' . preg_quote($token, '/') . '\s*:\s*(?<value>[^;]+);/',
            $css,
            $matches,
        );

        $value = $matches['value'] ?? null;

        return is_string($value) ? trim($value) : null;
    }

    private function normalizeCssValue(string $value): string
    {
        return trim((string) preg_replace('/\s+/', ' ', $value));
    }

    /**
     * @param list<string> $paths
     * @return list<string>
     */
    private function themeSelectorFindings(array $paths): array
    {
        $findings = [];

        foreach (CssTokenAudit::files($paths, ['.css']) as $file) {
            $css = CssTokenAudit::read($file);

            $patterns = [
                'data theme selector' => '/\[data-(?:theme|theme-resolved)(?:[^\]]*)\]/i',
                'prefers-color-scheme media query' => '/@media[^{]+prefers-color-scheme\s*:/i',
            ];

            foreach ($patterns as $label => $pattern) {
                preg_match_all($pattern, $css, $matches, PREG_OFFSET_CAPTURE);

                foreach ($matches[0] as $match) {
                    $matchedText = (string) ($match[0] ?? '');
                    $matchedOffset = (int) ($match[1] ?? 0);
                    $line = substr_count(substr($css, 0, $matchedOffset), "\n") + 1;

                    $findings[] = "{$file}:{$line} {$label}: {$matchedText}";
                }
            }
        }

        sort($findings);

        return array_values(array_unique($findings));
    }
}
