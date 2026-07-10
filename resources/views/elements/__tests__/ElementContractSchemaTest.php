<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| File: resources/views/elements/__tests__/ElementContractSchemaTest.php
| Purpose: Verify shared UI Element contract schema requirements.
|--------------------------------------------------------------------------
|
| These tests define the required core schema that every UI Element runtime
| contract must expose. Optional governance metadata remains optional here and
| should only be asserted by element-specific tests after it is standardized.
|
*/

namespace Tests\Ui\Elements;

use Tests\TestCase;

final class ElementContractSchemaTest extends TestCase
{
    /**
     * ---------------------------------------------------------------------
     * Installed contract inventory
     * ---------------------------------------------------------------------
     */

    public function test_expected_element_contracts_are_installed(): void
    {
        $installedSlugs = array_keys($this->contracts());

        sort($installedSlugs);

        $this->assertSame(
            [
                '2x-grid',
                'color',
                'icons',
                'motion',
                'pictograms',
                'spacing',
                'themes',
                'typography',
            ],
            $installedSlugs,
            'The installed UI Element contract inventory must match the governed element set.',
        );
    }

    public function test_element_contract_slugs_match_their_directory_names(): void
    {
        foreach ($this->contracts() as $slug => $contract) {
            $this->assertSame(
                $slug,
                data_get($contract, 'identity.slug'),
                "Contract [{$slug}] identity.slug must match its element directory name.",
            );
        }
    }

    public function test_element_contract_labels_are_unique_and_non_empty(): void
    {
        $labels = [];

        foreach ($this->contracts() as $slug => $contract) {
            $label = data_get($contract, 'identity.label');

            $this->assertIsString($label, "Contract [{$slug}] identity.label must be a string.");
            $this->assertNotSame('', trim($label), "Contract [{$slug}] identity.label must not be empty.");

            $labels[$slug] = $label;
        }

        $this->assertCount(
            count($labels),
            array_unique($labels),
            'UI Element contract labels must be unique.',
        );
    }

    /**
     * ---------------------------------------------------------------------
     * Required core schema
     * ---------------------------------------------------------------------
     */

    public function test_each_element_contract_exposes_required_core_schema(): void
    {
        foreach ($this->contracts() as $slug => $contract) {
            $this->assertIsArray($contract, "Contract [{$slug}] must return an array.");

            $this->assertIsArray(
                data_get($contract, 'identity'),
                "Contract [{$slug}] must expose identity metadata.",
            );

            $this->assertIsArray(
                data_get($contract, 'lifecycle'),
                "Contract [{$slug}] must expose lifecycle metadata.",
            );

            $this->assertIsArray(
                data_get($contract, 'source'),
                "Contract [{$slug}] must expose source metadata.",
            );

            $this->assertIsArray(
                data_get($contract, 'dependencies'),
                "Contract [{$slug}] must expose dependency metadata.",
            );

            $this->assertIsString(
                data_get($contract, 'identity.slug'),
                "Contract [{$slug}] identity.slug must be a string.",
            );

            $this->assertIsString(
                data_get($contract, 'identity.label'),
                "Contract [{$slug}] identity.label must be a string.",
            );

            $this->assertIsString(
                data_get($contract, 'lifecycle.status'),
                "Contract [{$slug}] lifecycle.status must be a string.",
            );

            $this->assertContains(
                data_get($contract, 'lifecycle.status'),
                [
                    'approved',
                    'provisional',
                    'planned',
                    'deprecated',
                ],
                "Contract [{$slug}] lifecycle.status must use an approved status value.",
            );
        }
    }

    public function test_each_element_contract_references_existing_standard_documents(): void
    {
        foreach ($this->contracts() as $slug => $contract) {
            $docs = data_get($contract, 'source.docs');

            $this->assertIsArray($docs, "Contract [{$slug}] source.docs must be an array.");
            $this->assertNotSame([], $docs, "Contract [{$slug}] source.docs must not be empty.");

            foreach ($docs as $docPath) {
                $this->assertIsString($docPath, "Contract [{$slug}] source.docs entries must be strings.");

                $this->assertFileExists(
                    base_path($docPath),
                    "Contract [{$slug}] references missing standard document [{$docPath}].",
                );
            }
        }
    }

    public function test_each_element_contract_references_its_canonical_standard_document(): void
    {
        foreach ($this->canonicalStandardPaths() as $slug => $standardPath) {
            $contract = $this->contracts()[$slug] ?? null;

            $this->assertIsArray($contract, "Contract [{$slug}] must be installed.");

            $this->assertContains(
                $standardPath,
                data_get($contract, 'source.docs', []),
                "Contract [{$slug}] must reference its canonical standard document.",
            );
        }
    }

    /**
     * ---------------------------------------------------------------------
     * Optional metadata shape
     * ---------------------------------------------------------------------
     */

    public function test_optional_contract_metadata_uses_stable_shapes_when_present(): void
    {
        foreach ($this->contracts() as $slug => $contract) {
            if (array_key_exists('review', $contract)) {
                $this->assertIsArray($contract['review'], "Contract [{$slug}] review metadata must be an array when present.");
            }

            if (array_key_exists('catalog', $contract)) {
                $this->assertIsArray($contract['catalog'], "Contract [{$slug}] catalog metadata must be an array when present.");

                if (array_key_exists('visibility', $contract['catalog'])) {
                    $this->assertIsString(
                        $contract['catalog']['visibility'],
                        "Contract [{$slug}] catalog.visibility must be a string when present.",
                    );
                }

                if (array_key_exists('route', $contract['catalog'])) {
                    $this->assertIsString(
                        $contract['catalog']['route'],
                        "Contract [{$slug}] catalog.route must be a string when present.",
                    );
                }
            }

            if (array_key_exists('enforcement', $contract)) {
                $this->assertIsArray($contract['enforcement'], "Contract [{$slug}] enforcement metadata must be an array when present.");

                if (array_key_exists('mode', $contract['enforcement'])) {
                    $this->assertIsString(
                        $contract['enforcement']['mode'],
                        "Contract [{$slug}] enforcement.mode must be a string when present.",
                    );
                }
            }

            if (array_key_exists('api_approved', data_get($contract, 'lifecycle', []))) {
                $this->assertIsBool(
                    data_get($contract, 'lifecycle.api_approved'),
                    "Contract [{$slug}] lifecycle.api_approved must be boolean when present.",
                );
            }

            if (array_key_exists('allowed_in_app_layouts', data_get($contract, 'lifecycle', []))) {
                $this->assertIsBool(
                    data_get($contract, 'lifecycle.allowed_in_app_layouts'),
                    "Contract [{$slug}] lifecycle.allowed_in_app_layouts must be boolean when present.",
                );
            }

            if (array_key_exists('allowed_in_patterns', data_get($contract, 'lifecycle', []))) {
                $this->assertIsBool(
                    data_get($contract, 'lifecycle.allowed_in_patterns'),
                    "Contract [{$slug}] lifecycle.allowed_in_patterns must be boolean when present.",
                );
            }
        }
    }

    /**
     * ---------------------------------------------------------------------
     * Helpers
     * ---------------------------------------------------------------------
     *
     * @return array<string, array<string, mixed>>
     */
    private function contracts(): array
    {
        $contracts = [];

        foreach (glob(resource_path('views/elements/*/contract.php')) ?: [] as $path) {
            $slug = basename(dirname($path));
            $contract = require $path;

            $this->assertIsArray($contract, "Contract file [{$path}] must return an array.");

            $contracts[$slug] = $contract;
        }

        ksort($contracts);

        return $contracts;
    }

    /**
     * @return array<string, string>
     */
    private function canonicalStandardPaths(): array
    {
        return [
            '2x-grid' => 'docs/02-standards/ui/elements/2x-grid.md',
            'color' => 'docs/02-standards/ui/elements/color.md',
            'icons' => 'docs/02-standards/ui/elements/icons.md',
            'motion' => 'docs/02-standards/ui/elements/motion.md',
            'pictograms' => 'docs/02-standards/ui/elements/pictograms.md',
            'spacing' => 'docs/02-standards/ui/elements/spacing.md',
            'themes' => 'docs/02-standards/ui/elements/themes.md',
            'typography' => 'docs/02-standards/ui/elements/typography.md',
        ];
    }
}
