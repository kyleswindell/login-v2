<?php

declare(strict_types=1);

namespace Tests\Ui\Elements\Pictograms;

use Tests\TestCase;
use Tests\Ui\Elements\Support\CssTokenAudit;

require_once dirname(__DIR__, 2).'/__tests__/Support/CssTokenAudit.php';

final class PictogramElementGovernanceTest extends TestCase
{
    public function test_pictograms_standard_and_runtime_contract_stay_aligned(): void
    {
        CssTokenAudit::assertStandardAndContractAreAligned('pictograms', 'docs/02-standards/ui/elements/pictograms.md');
    }

    public function test_pictogram_contract_remains_planned_and_blocked_until_asset_decision(): void
    {
        $contract = CssTokenAudit::contract('pictograms');

        $this->assertSame('pictograms', data_get($contract, 'identity.slug'));
        $this->assertSame('Pictograms', data_get($contract, 'identity.label'));
        $this->assertSame('planned', data_get($contract, 'lifecycle.status'));
        $this->assertContains('approved pictogram asset source', data_get($contract, 'dependencies.blocked_by', []));
        $this->assertContains('pictogram accessibility contract', data_get($contract, 'dependencies.blocked_by', []));
    }

    public function test_no_public_pictogram_component_or_asset_source_is_installed(): void
    {
        $this->assertFileDoesNotExist(resource_path('views/components/ui/pictogram/index.blade.php'));
        $this->assertDirectoryDoesNotExist(resource_path('views/components/pictograms'));
        $this->assertDirectoryDoesNotExist(resource_path('views/components/pictograms/src'));
    }

    public function test_feature_and_component_sources_do_not_claim_pictogram_classes_or_wrapper(): void
    {
        $paths = CssTokenAudit::files([
            'resources/views/components',
            'resources/views/livewire',
            'resources/views/platform',
            'resources/css/components',
            'resources/css/patterns',
            'resources/images',
            'resources/icons',
            'public/images',
        ], ['.php', '.blade.php', '.css', '.svg', '.png', '.jpg', '.jpeg', '.webp']);

        $matches = [];

        foreach ($paths as $path) {
            if (str_starts_with($path, 'resources/views/components/icons/src/svg/')) {
                continue;
            }

            $contents = CssTokenAudit::read($path);
            $isAssetPath = preg_match('/\.(?:svg|png|jpe?g|webp)$/i', $path) === 1;

            if (preg_match('/<x-ui\.pictogram\b|ui-pictogram(?:--|__|\b)/', $contents) === 1
                || ($isAssetPath && preg_match('/pictogram/i', $path) === 1)
            ) {
                $matches[] = $path;
            }
        }

        $this->assertSame([], array_values(array_unique($matches)));
    }
}
