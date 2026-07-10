<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| File: tests/Ui/Elements/Icons/IconElementGovernanceTest.php
| Purpose: Verify Icon element manifest, renderer, and API governance.
|--------------------------------------------------------------------------
|
| These tests protect the approved Icons foundation element from unsafe dynamic
| component icon rendering, non-canonical config-driven names, stale icon alias
| APIs, and renderer drift.
|
*/

namespace Tests\Ui\Elements\Icons;

use Illuminate\Support\Facades\Blade;
use Tests\TestCase;
use Tests\Ui\Elements\Support\CssTokenAudit;

final class IconElementGovernanceTest extends TestCase
{
    /**
     * ---------------------------------------------------------------------
     * Standard / contract alignment
     * ---------------------------------------------------------------------
     */

    public function test_icons_standard_and_runtime_contract_stay_aligned(): void
    {
        CssTokenAudit::assertStandardAndContractAreAligned(
            'icons',
            'docs/02-standards/ui/elements/icons.md',
        );
    }

    public function test_icon_contract_stays_approved_and_manifest_backed(): void
    {
        $contract = CssTokenAudit::contract('icons');

        $this->assertSame('icons', data_get($contract, 'identity.slug'));
        $this->assertSame('Icons', data_get($contract, 'identity.label'));
        $this->assertSame('approved', data_get($contract, 'lifecycle.status'));

        $this->assertContains(
            'internal-icon-manifest',
            data_get($contract, 'dependencies.uses.icons', []),
        );

        $this->assertContains(
            'ui.icon',
            data_get($contract, 'dependencies.uses.components', []),
        );
    }

    /**
     * ---------------------------------------------------------------------
     * Runtime config / manifest
     * ---------------------------------------------------------------------
     */

    public function test_icon_runtime_config_points_to_generated_manifest_and_source_folder(): void
    {
        CssTokenAudit::assertIconRuntimeConfigIsValid();

        $this->assertSame('carbon', config('ui-icons.default_set'));
        $this->assertSame('empty', config('ui-icons.fallback'));

        $this->assertSame(
            resource_path('views/components/icons/src/svg'),
            config('ui-icons.sets.carbon.path'),
        );

        $this->assertSame(
            resource_path('views/components/icons/src/svg/manifest.php'),
            config('ui-icons.sets.carbon.manifest'),
        );

        $this->assertSame(
            [
                'xs' => 12,
                'sm' => 16,
                'md' => 16,
                'lg' => 20,
                'xl' => 24,
                '2xl' => 32,
            ],
            config('ui-icons.sizes'),
        );
    }

    public function test_manifest_contains_current_required_carbon_icons(): void
    {
        $manifest = CssTokenAudit::iconManifest();

        $this->assertGreaterThanOrEqual(
            2600,
            count($manifest),
            'Generated icon manifest should include the installed Carbon SVG inventory.',
        );

        CssTokenAudit::assertIconManifestContains([
            'empty',
            'apps',
            'notification',
            'notebook',
            'report',
            'color-palette',
            'copy--to-clipboard',
            'overflow-menu--vertical',
            'chevron--down',
            'settings--check',
            'arrow--right',
            'warning',
            'warning--filled',
            'view',
            'view--off',
        ]);

        foreach (['apps', 'notification', 'notebook', 'settings--check'] as $iconName) {
            $this->assertManifestDefaultSourceExists($manifest, $iconName);
        }
    }

    /**
     * ---------------------------------------------------------------------
     * Renderer behavior
     * ---------------------------------------------------------------------
     */

    public function test_ui_icon_blade_owns_current_color_sizing_and_data_contract(): void
    {
        $html = Blade::render('<x-ui.icon name="notebook" size="lg" />');

        $this->assertStringContainsString('data-ui-component="icon"', $html);
        CssTokenAudit::assertAttributePresent(
            $html,
            'data-ui-icon',
            'The icon renderer must expose the data-ui-icon marker regardless of boolean attribute serialization.',
        );
        $this->assertStringContainsString('data-ui-icon-name="notebook"', $html);
        $this->assertStringContainsString('data-ui-icon-requested="notebook"', $html);
        $this->assertStringContainsString('data-ui-icon-size="lg"', $html);
        $this->assertStringContainsString('data-ui-icon-missing="false"', $html);
        $this->assertStringContainsString('fill="currentColor"', $html);
        $this->assertStringContainsString('focusable="false"', $html);
        $this->assertStringContainsString('width="20"', $html);
        $this->assertStringContainsString('height="20"', $html);
    }

    public function test_ui_icon_missing_icon_contract_renders_fallback_without_crashing(): void
    {
        $html = Blade::render('<x-ui.icon name="does-not-exist" />');

        $this->assertStringContainsString('data-ui-component="icon"', $html);
        $this->assertStringContainsString('data-ui-icon-name="empty"', $html);
        $this->assertStringContainsString('data-ui-icon-requested="does-not-exist"', $html);
        $this->assertStringContainsString('data-ui-icon-missing="true"', $html);
        $this->assertStringContainsString('fill="currentColor"', $html);
    }

    public function test_ui_icon_accessibility_contract_supports_labels_and_decorative_icons(): void
    {
        $decorative = Blade::render('<x-ui.icon name="apps" decorative />');

        $this->assertStringContainsString('aria-hidden="true"', $decorative);
        $this->assertStringNotContainsString('role="img"', $decorative);

        $labelled = Blade::render('<x-ui.icon name="warning--filled" label="Warning" />');

        $this->assertStringContainsString('role="img"', $labelled);
        $this->assertStringContainsString('aria-label="Warning"', $labelled);
        $this->assertStringNotContainsString('aria-hidden="true"', $labelled);

        $labelledBy = Blade::render('<x-ui.icon name="settings--check" labelledby="security-icon-label" />');

        $this->assertStringContainsString('role="img"', $labelledBy);
        $this->assertStringContainsString('aria-labelledby="security-icon-label"', $labelledBy);
        $this->assertStringNotContainsString('aria-hidden="true"', $labelledBy);
    }

    /**
     * ---------------------------------------------------------------------
     * Consumer governance
     * ---------------------------------------------------------------------
     */

    public function test_unsafe_dynamic_icon_component_usage_does_not_reappear(): void
    {
        $findings = $this->dynamicIconComponentFindings([
            'resources/views/components',
            'resources/views/elements',
            'resources/views/platform',
            'config',
        ]);

        $this->assertSame(
            [],
            $findings,
            'Dynamic/config-driven icons must use x-ui.icon and manifest names, not x-dynamic-component or icons.* component aliases.',
        );
    }

    public function test_legacy_static_icon_component_usage_is_baselined_before_hard_failure(): void
    {
        $findings = $this->legacyStaticIconUsageFindings([
            'resources/views',
            'config',
        ]);

        CssTokenAudit::assertNoNewReportOnlyItems(
            'resources/views/elements/icons/__tests__/baselines/legacy-static-icon-usage.php',
            $findings,
            'Legacy static icon API scan',
        );
    }

    public function test_legacy_generated_icon_blades_are_not_treated_as_runtime_manifest_source(): void
    {
        $this->assertFileExists(resource_path('views/components/icons/src/svg/manifest.php'));
        $this->assertDirectoryExists(resource_path('views/components/icons/src/svg'));
        $this->assertDirectoryExists(resource_path('views/components/ui/icon'));

        $this->assertSame(
            resource_path('views/components/icons/src/svg/manifest.php'),
            config('ui-icons.sets.carbon.manifest'),
        );
    }

    /**
     * ---------------------------------------------------------------------
     * Helpers
     * ---------------------------------------------------------------------
     *
     * @param array<string, mixed> $manifest
     */
    private function assertManifestDefaultSourceExists(array $manifest, string $iconName): void
    {
        $entry = $manifest[$iconName] ?? null;

        $this->assertIsArray($entry, "Manifest entry [{$iconName}] must be an array.");
        $this->assertArrayHasKey('default', $entry, "Manifest entry [{$iconName}] must define a default source.");

        $relativePath = $entry['default'];

        $this->assertIsString($relativePath, "Manifest entry [{$iconName}] default source must be a string.");

        $this->assertFileExists(
            resource_path('views/components/icons/src/svg/' . $relativePath),
            "Manifest entry [{$iconName}] default source must exist.",
        );
    }

    /**
     * @param list<string> $paths
     * @return list<string>
     */
    private function dynamicIconComponentFindings(array $paths): array
    {
        $findings = [];

        foreach (CssTokenAudit::files($paths, ['.blade.php', '.php']) as $file) {
            if ($this->isApprovedIconSourcePath($file)) {
                continue;
            }

            if ($this->isTestSourcePath($file)) {
                continue;
            }

            $contents = CssTokenAudit::read($file);

            $patterns = [
                'dynamic icon component' => '/<x-dynamic-component\b[^>]*(?:\$icon|\$chevronIcon|\$leadingIcon|\$trailingIcon|\$closeIcon|icon|Icon|chevron)[^>]*>/i',
                'dynamic icons.* alias' => '/(?:^|\s)(?::?icon|chevron-icon|chevronIcon|leading-icon|leadingIcon|trailing-icon|trailingIcon|close-icon|closeIcon)=["\'][^"\']*icons\.[^"\']+["\']/i',
            ];

            foreach ($patterns as $label => $pattern) {
                preg_match_all($pattern, $contents, $matches, PREG_OFFSET_CAPTURE);

                foreach ($matches[0] as $match) {
                    $matchedText = (string) ($match[0] ?? '');
                    $matchedOffset = (int) ($match[1] ?? 0);
                    $line = substr_count(substr($contents, 0, $matchedOffset), "\n") + 1;

                    $findings[] = "{$file}:{$line} {$label}: {$matchedText}";
                }
            }
        }

        sort($findings);

        return array_values(array_unique($findings));
    }

    /**
     * @param list<string> $paths
     * @return list<string>
     */
    private function legacyStaticIconUsageFindings(array $paths): array
    {
        $findings = [];

        foreach (CssTokenAudit::files($paths, ['.blade.php', '.php']) as $file) {
            if ($this->isApprovedIconSourcePath($file)) {
                continue;
            }

            if ($this->isTestSourcePath($file)) {
                continue;
            }

            $contents = CssTokenAudit::read($file);

            $patterns = [
                'x-icons component' => '/<x-icons\.[\w.-]+/',
                'legacy nav icon adapter' => '/<x-layouts\.nav-icon\b/',
            ];

            foreach ($patterns as $label => $pattern) {
                preg_match_all($pattern, $contents, $matches, PREG_OFFSET_CAPTURE);

                foreach ($matches[0] as $match) {
                    $matchedText = (string) ($match[0] ?? '');
                    $matchedOffset = (int) ($match[1] ?? 0);
                    $line = substr_count(substr($contents, 0, $matchedOffset), "\n") + 1;

                    $findings[] = "{$file}:{$line} {$label}: {$matchedText}";
                }
            }
        }

        sort($findings);

        return array_values(array_unique($findings));
    }

    private function isApprovedIconSourcePath(string $file): bool
    {
        return str_starts_with($file, 'resources/views/components/icons/src/svg/')
            || $file === 'resources/views/components/icons/src/svg/manifest.php'
            || str_starts_with($file, 'resources/views/components/ui/icon/');
    }

    private function isTestSourcePath(string $file): bool
    {
        return str_contains(str_replace('\\', '/', $file), '/__tests__/');
    }
}
