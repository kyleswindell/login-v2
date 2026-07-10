<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| File: tests/Ui/Elements/Motion/MotionTokenGovernanceTest.php
| Purpose: Verify Motion token ownership and consumer drift governance.
|--------------------------------------------------------------------------
|
| These tests protect the approved Motion foundation element from raw timing,
| easing drift, missing reduced-motion guards, and premature JavaScript timing
| hard failures before controller timing ownership is approved.
|
*/

namespace Tests\Ui\Elements\Motion;

use Tests\TestCase;
use Tests\Ui\Elements\Support\CssTokenAudit;

final class MotionTokenGovernanceTest extends TestCase
{
    /**
     * ---------------------------------------------------------------------
     * Standard / contract alignment
     * ---------------------------------------------------------------------
     */

    public function test_motion_standard_and_runtime_contract_stay_aligned(): void
    {
        CssTokenAudit::assertStandardAndContractAreAligned(
            'motion',
            'docs/02-standards/ui/elements/motion.md',
        );
    }

    public function test_motion_contract_remains_provisional_until_tokens_and_accessibility_are_reviewed(): void
    {
        $contract = CssTokenAudit::contract('motion');

        $this->assertSame('motion', data_get($contract, 'identity.slug'));
        $this->assertSame('Motion', data_get($contract, 'identity.label'));
        $this->assertSame('provisional', data_get($contract, 'lifecycle.status'));

        $this->assertContains('accordion', data_get($contract, 'dependencies.blocks', []));
        $this->assertContains('modal', data_get($contract, 'dependencies.blocks', []));
        $this->assertContains('tooltip', data_get($contract, 'dependencies.blocks', []));
    }

    /**
     * ---------------------------------------------------------------------
     * Token source ownership
     * ---------------------------------------------------------------------
     */

    public function test_motion_tokens_export_carbon_duration_and_easing_families(): void
    {
        CssTokenAudit::assertDefinesTokens('resources/css/tokens/motion.css', [
            '--duration-fast-01',
            '--duration-fast-02',
            '--duration-moderate-01',
            '--duration-moderate-02',
            '--duration-slow-01',
            '--duration-slow-02',
            '--ui-duration-fast-01',
            '--ui-duration-fast-02',
            '--ui-duration-moderate-01',
            '--ui-duration-moderate-02',
            '--ui-duration-slow-01',
            '--ui-duration-slow-02',
            '--motion-standard-productive',
            '--motion-standard-expressive',
            '--motion-entrance-productive',
            '--motion-entrance-expressive',
            '--motion-exit-productive',
            '--motion-exit-expressive',
            '--ui-motion-standard-productive',
            '--ui-motion-standard-expressive',
            '--ui-motion-entrance-productive',
            '--ui-motion-entrance-expressive',
            '--ui-motion-exit-productive',
            '--ui-motion-exit-expressive',
        ]);
    }

    public function test_motion_tokens_keep_expected_carbon_duration_values(): void
    {
        $path = 'resources/css/tokens/motion.css';

        $this->assertCssCustomPropertyValue($path, '--duration-fast-01', '70ms');
        $this->assertCssCustomPropertyValue($path, '--duration-fast-02', '110ms');
        $this->assertCssCustomPropertyValue($path, '--duration-moderate-01', '150ms');
        $this->assertCssCustomPropertyValue($path, '--duration-moderate-02', '240ms');
        $this->assertCssCustomPropertyValue($path, '--duration-slow-01', '400ms');
        $this->assertCssCustomPropertyValue($path, '--duration-slow-02', '700ms');
    }

    public function test_motion_tokens_keep_expected_carbon_easing_values(): void
    {
        $path = 'resources/css/tokens/motion.css';

        $this->assertCssCustomPropertyValue(
            $path,
            '--motion-standard-productive',
            'cubic-bezier(0.2, 0, 0.38, 0.9)',
        );

        $this->assertCssCustomPropertyValue(
            $path,
            '--motion-standard-expressive',
            'cubic-bezier(0.4, 0.14, 0.3, 1)',
        );

        $this->assertCssCustomPropertyValue(
            $path,
            '--motion-entrance-productive',
            'cubic-bezier(0, 0, 0.38, 0.9)',
        );

        $this->assertCssCustomPropertyValue(
            $path,
            '--motion-entrance-expressive',
            'cubic-bezier(0, 0, 0.3, 1)',
        );

        $this->assertCssCustomPropertyValue(
            $path,
            '--motion-exit-productive',
            'cubic-bezier(0.2, 0, 1, 0.9)',
        );

        $this->assertCssCustomPropertyValue(
            $path,
            '--motion-exit-expressive',
            'cubic-bezier(0.4, 0.14, 1, 1)',
        );
    }

    public function test_motion_ui_aliases_consume_motion_source_tokens(): void
    {
        CssTokenAudit::assertUsesTokens('resources/css/tokens/motion.css', [
            '--duration-fast-01',
            '--duration-fast-02',
            '--duration-moderate-01',
            '--duration-moderate-02',
            '--duration-slow-01',
            '--duration-slow-02',
            '--motion-standard-productive',
            '--motion-standard-expressive',
            '--motion-entrance-productive',
            '--motion-entrance-expressive',
            '--motion-exit-productive',
            '--motion-exit-expressive',
        ]);
    }

    /**
     * ---------------------------------------------------------------------
     * Consumer governance
     * ---------------------------------------------------------------------
     */

    public function test_raw_motion_values_are_categorized_until_token_cleanup(): void
    {
        $rawMotionDeclarations = CssTokenAudit::rawMotionDeclarations([
            'resources/css/base',
            'resources/css/components',
            'resources/css/patterns',
        ]);

        CssTokenAudit::assertAllDeclarationsAreCategorized($rawMotionDeclarations, [
            [
                'label' => 'Skeleton shimmer cadence is current Carbon parity drift.',
                'path' => '/resources\/css\/(?:base\/skeleton|components\/(?:button|checkbox|dropdown|form|number-input|progress-indicator|radio-button|search|select|slider|structured-list|tabs|text-area|text-input))\.css$/',
                'value' => '/(?:3000ms|1\.5s|ease-in-out|linear)/i',
            ],
            [
                'label' => 'Loading and progress animations use current Carbon geometry-specific durations.',
                'path' => '/resources\/css\/components\/(?:inline-loading|loading|progress-bar)\.css$/',
            ],
            [
                'label' => 'Data table toolbar has one raw opacity transition pending motion-token cleanup.',
                'path' => '/resources\/css\/components\/data-table-toolbar\.css$/',
                'property' => '/^transition$/',
                'value' => '/opacity 110ms/i',
            ],
        ]);
    }

    public function test_animated_foundation_surfaces_include_reduced_motion_guards(): void
    {
        foreach ($this->reducedMotionRequiredFiles() as $path) {
            $this->assertStringContainsString(
                'prefers-reduced-motion: reduce',
                CssTokenAudit::read($path),
                "{$path} must include a reduced-motion guard for installed animation or transition behavior.",
            );
        }
    }

    public function test_javascript_timing_constants_are_report_only_until_controller_ownership_is_approved(): void
    {
        $findings = CssTokenAudit::javaScriptTimingFindings(
            ['resources/js', 'resources/views'],
        );

        CssTokenAudit::assertNoNewReportOnlyItems(
            'resources/views/elements/motion/__tests__/baselines/js-timing-findings.php',
            $findings,
            'JavaScript UI timing scan',
        );
    }

    /**
     * ---------------------------------------------------------------------
     * Helpers
     * ---------------------------------------------------------------------
     *
     * @return list<string>
     */
    private function reducedMotionRequiredFiles(): array
    {
        return [
            'resources/css/base/skeleton.css',
            'resources/css/base/transform.css',
            'resources/css/components/accordion.css',
            'resources/css/components/inline-loading.css',
            'resources/css/components/loading.css',
            'resources/css/components/modal.css',
            'resources/css/components/progress-bar.css',
            'resources/css/components/tooltip.css',
            'resources/css/components/tree-view.css',
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
            "{$path} must keep {$token} aligned with the approved Carbon Motion value.",
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
}
